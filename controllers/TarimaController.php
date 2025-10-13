<?php
// controllers/TarimaController.php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Tarima.php';

class TarimaController extends Controller
{
    private $tarimaModel;

    public function __construct()
    {
        parent::__construct();
        $this->tarimaModel = new Tarima();
    }

    public function nuevaTarima()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
            return;
        }

        // Solo usuarios con permiso para crear tarimas pueden acceder
        if (!$this->hasAnyRole(['administrador', 'produccion', 'jefe_produccion'])) {
            $this->redirect('auth/login');
            return;
        }

        $data = [
            'username' => $_SESSION['username'],
            'title' => 'Nueva Tarima',
            'success' => $_GET['success'] ?? null,
            'error' => $_GET['error'] ?? null
        ];

        $this->view('tarimas/nueva_tarima', $data);
    }

    public function guardarTarima()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
            return;
        }

        // Solo usuarios con permiso para crear tarimas pueden guardar
        if (!$this->hasAnyRole(['administrador', 'produccion', 'jefe_produccion'])) {
            $this->redirect('auth/login');
            return;
        }

        $tarimaData = [
            'codigoBarras' => filter_var(trim($_POST['codigoBarras']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'numeroProducto' => filter_var(trim($_POST['numeroProducto']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'numeroTarima' => filter_var(trim($_POST['numeroTarima']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'numeroUsuario' => filter_var(trim($_POST['numeroUsuario']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'cantidadCajas' => filter_var(trim($_POST['cantidadCajas']), FILTER_VALIDATE_INT) ? (int)$_POST['cantidadCajas'] : 0,
            'peso' => filter_var(trim($_POST['peso']), FILTER_VALIDATE_FLOAT) ? (float)$_POST['peso'] : 0,
            'numeroVenta' => filter_var(trim($_POST['numeroVenta']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'descripcion' => filter_var(trim($_POST['descripcion']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'idUsuario' => isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0 // Asegurar que el ID del usuario esté disponible
        ];

        // Si la cantidad de cajas es 0, intentar extraerla del código de barras
        if ($tarimaData['cantidadCajas'] == 0 && !empty($tarimaData['codigoBarras'])) {
            $codigoBarras = $tarimaData['codigoBarras'];
            if (strlen($codigoBarras) >= 24) {
                // Extraer la cantidad de cajas de las posiciones 21-23 del código de barras (3 dígitos)
                $cajasPart = substr($codigoBarras, 21, 3);
                if (is_numeric($cajasPart)) {
                    $tarimaData['cantidadCajas'] = (int)$cajasPart;
                }
            }
        }

        // Si el peso no está definido o es 0, intentar extraerlo de los últimos 6 dígitos del código de barras
        if ($tarimaData['peso'] == 0 && !empty($tarimaData['codigoBarras'])) {
            $codigoBarras = $tarimaData['codigoBarras'];
            if (strlen($codigoBarras) >= 6) {
                // Extraer los últimos 6 dígitos
                $lastSixDigits = substr($codigoBarras, -6);

                // Los primeros 4 dígitos son la parte entera, los últimos 2 son decimales
                $wholePart = substr($lastSixDigits, 0, 4);
                $decimalPart = substr($lastSixDigits, 4, 2);

                $tarimaData['peso'] = (float)($wholePart . '.' . $decimalPart);
            }
        }

        // Validate required fields
        if (empty($tarimaData['codigoBarras']) || empty($tarimaData['numeroTarima'])) {
            $this->redirect('tarimas/nueva_tarima?error=required_fields_missing');
            return;
        }

        try {
            if ($this->tarimaModel->create($tarimaData)) {
                $this->redirect('tarimas/nueva_tarima?success=entity_created');
            } else {
                $this->redirect('tarimas/nueva_tarima?error=save_failed');
            }
        } catch (PDOException $e) {
            // Capturar error de duplicado
            if ($e->getCode() === '23000' || strpos($e->getMessage(), 'Duplicate entry') !== false) {
                // Error de duplicado
                header('Location: ' . BASE_URL . '/tarimas/nueva_tarima?error=duplicate_tarima');
            } else {
                // Otro error
                header('Location: ' . BASE_URL . '/tarimas/nueva_tarima?error=unknown');
            }
        }
    }

    public function listarTarimas()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
            return;
        }

        // Solo usuarios con permiso para ver tarimas pueden acceder
        if (!$this->hasAnyRole(['administrador', 'produccion', 'jefe_produccion'])) {
            $this->redirect('auth/login');
            return;
        }

        // Recoger parámetros de filtro
        $filtros = [
            'numero_producto' => $_GET['numero_producto'] ?? '',
            'numero_tarima' => $_GET['numero_tarima'] ?? '',
            'numero_usuario' => $_GET['numero_usuario'] ?? '',
            'numero_venta' => $_GET['numero_venta'] ?? '',
            'fecha_registro' => $_GET['fecha_registro'] ?? '',
            'legajo' => $_GET['legajo'] ?? '',
            'nombre_usuario' => $_GET['nombre_usuario'] ?? '',
            'cantidad_cajas_min' => $_GET['cantidad_cajas_min'] ?? '',
            'peso_min' => $_GET['peso_min'] ?? ''
        ];

        // Check if all filters are empty (no filter applied)
        $hasFilters = false;
        foreach ($filtros as $filtro) {
            if ($filtro !== '') {
                $hasFilters = true;
                break;
            }
        }

        // Check if 'all' parameter is present to show last 1000 tarimas without date restriction
        $showAll = isset($_GET['all']) && $_GET['all'] === '1';

        if ($showAll) {
            // Show last 1000 tarimas without date restriction
            $tarimas = $this->tarimaModel->getLastTarimas(1000);
        } elseif (!$hasFilters) {
            // No filters applied, get today's last 1000 tarimas
            $tarimas = $this->tarimaModel->getTodayLastTarimas(1000);
        } else {
            // Filters applied, use the filtered method
            $tarimas = $this->tarimaModel->getTarimasFiltradas($filtros);
        }

        // Obtener la cantidad de tarimas ingresadas hoy
        $tarimasHoy = $this->tarimaModel->getTodayTarimasCount();

        $data = [
            'username' => $_SESSION['username'],
            'title' => 'Inventario de Tarimas',
            'tarimas' => $tarimas,
            'tarimas_hoy' => $tarimasHoy,
            'role' => $_SESSION['role'] ?? 'produccion',
            'filtros' => $filtros
        ];

        $this->view('tarimas/listar_tarimas', $data);
    }

    public function editarTarima($id)
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
            return;
        }

        // Solo administradores y jefes de producción pueden editar tarimas
        if (!$this->hasAnyRole(['administrador', 'jefe_produccion'])) {
            $this->redirect('tarimas/listar_tarimas');
            return;
        }

        $stmt = $this->tarimaModel->getConnection()->prepare("SELECT * FROM tarimas WHERE id_tarima = ?");
        $stmt->execute([$id]);
        $tarima = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$tarima) {
            $this->redirect('tarimas/listar_tarimas');
            return;
        }

        $data = [
            'username' => $_SESSION['username'],
            'title' => 'Editar Tarima',
            'tarima' => $tarima,
            'role' => $_SESSION['role']
        ];

        $this->view('tarimas/editar_tarima', $data);
    }

    public function actualizarTarima($id)
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
            return;
        }

        // Solo administradores y jefes de producción pueden actualizar tarimas
        if (!$this->hasAnyRole(['administrador', 'jefe_produccion'])) {
            $this->redirect('tarimas/listar_tarimas');
            return;
        }

        $tarimaData = [
            'id' => $id,
            'codigoBarras' => filter_var(trim($_POST['codigoBarras']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'numeroProducto' => filter_var(trim($_POST['numeroProducto']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'numeroTarima' => filter_var(trim($_POST['numeroTarima']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'numeroUsuario' => filter_var(trim($_POST['numeroUsuario']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'cantidadCajas' => filter_var(trim($_POST['cantidadCajas']), FILTER_VALIDATE_INT) ? (int)$_POST['cantidadCajas'] : 0,
            'peso' => filter_var(trim($_POST['peso']), FILTER_VALIDATE_FLOAT) ? (float)$_POST['peso'] : 0,
            'numeroVenta' => filter_var(trim($_POST['numeroVenta']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'descripcion' => filter_var(trim($_POST['descripcion']), FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        ];

        // Validate required fields
        if (empty($tarimaData['codigoBarras']) || empty($tarimaData['numeroTarima'])) {
            // Recuperar la tarima para mostrarla en el formulario
            $stmt = $this->tarimaModel->getConnection()->prepare("SELECT * FROM tarimas WHERE id_tarima = ?");
            $stmt->execute([$id]);
            $tarima = $stmt->fetch(PDO::FETCH_ASSOC);

            $data = [
                'username' => $_SESSION['username'],
                'title' => 'Editar Tarima',
                'tarima' => $tarima,
                'role' => $_SESSION['role'],
                'error' => 'required_fields_missing'
            ];

            $this->view('tarimas/editar_tarima', $data);
            return;
        }

        try {
            $stmt = $this->tarimaModel->getConnection()->prepare("
                UPDATE tarimas
                SET codigo_barras = ?, numero_producto = ?, numero_tarima = ?, numero_usuario = ?,
                    cantidad_cajas = ?, peso = ?, numero_venta = ?, descripcion = ?
                WHERE id_tarima = ?
            ");

            $result = $stmt->execute([
                $tarimaData['codigoBarras'],
                $tarimaData['numeroProducto'],
                $tarimaData['numeroTarima'],
                $tarimaData['numeroUsuario'],
                $tarimaData['cantidadCajas'],
                $tarimaData['peso'],
                $tarimaData['numeroVenta'],
                $tarimaData['descripcion'],
                $tarimaData['id']
            ]);

            if ($result) {
                // Recuperar la tarima actualizada para mostrarla en el formulario
                $stmt = $this->tarimaModel->getConnection()->prepare("SELECT * FROM tarimas WHERE id_tarima = ?");
                $stmt->execute([$id]);
                $tarima = $stmt->fetch(PDO::FETCH_ASSOC);

                $data = [
                    'username' => $_SESSION['username'],
                    'title' => 'Editar Tarima',
                    'tarima' => $tarima,
                    'role' => $_SESSION['role'],
                    'success' => 'tarima_actualizada'
                ];

                $this->view('tarimas/editar_tarima', $data);
            } else {
                // Recuperar la tarima para mostrarla en el formulario
                $stmt = $this->tarimaModel->getConnection()->prepare("SELECT * FROM tarimas WHERE id_tarima = ?");
                $stmt->execute([$id]);
                $tarima = $stmt->fetch(PDO::FETCH_ASSOC);

                $data = [
                    'username' => $_SESSION['username'],
                    'title' => 'Editar Tarima',
                    'tarima' => $tarima,
                    'role' => $_SESSION['role'],
                    'error' => 'update_failed'
                ];

                $this->view('tarimas/editar_tarima', $data);
            }
        } catch (PDOException $e) {
            // Capturar error de duplicado
            if ($e->getCode() === '23000' || strpos($e->getMessage(), 'Duplicate entry') !== false) {
                // Recuperar la tarima para mostrarla en el formulario
                $stmt = $this->tarimaModel->getConnection()->prepare("SELECT * FROM tarimas WHERE id_tarima = ?");
                $stmt->execute([$id]);
                $tarima = $stmt->fetch(PDO::FETCH_ASSOC);

                $data = [
                    'username' => $_SESSION['username'],
                    'title' => 'Editar Tarima',
                    'tarima' => $tarima,
                    'role' => $_SESSION['role'],
                    'error' => 'Ya existe una tarima registrada con este código de barras en la misma fecha.'
                ];

                $this->view('tarimas/editar_tarima', $data);
            } else {
                // Recuperar la tarima para mostrarla en el formulario
                $stmt = $this->tarimaModel->getConnection()->prepare("SELECT * FROM tarimas WHERE id_tarima = ?");
                $stmt->execute([$id]);
                $tarima = $stmt->fetch(PDO::FETCH_ASSOC);

                $data = [
                    'username' => $_SESSION['username'],
                    'title' => 'Editar Tarima',
                    'tarima' => $tarima,
                    'role' => $_SESSION['role'],
                    'error' => 'unknown'
                ];

                $this->view('tarimas/editar_tarima', $data);
            }
        }
    }
}
