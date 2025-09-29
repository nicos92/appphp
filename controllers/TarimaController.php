<?php
// controllers/TarimaController.php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Tarima.php';

class TarimaController extends Controller {
    private $tarimaModel;

    public function __construct() {
        parent::__construct();
        $this->tarimaModel = new Tarima();
    }

    public function nuevaTarima() {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
            return;
        }
        
        // Solo usuarios con permiso para crear tarimas pueden acceder
        if (!$this->hasAnyRole(['administrador', 'produccion'])) {
            $this->redirect('auth/login');
            return;
        }
        
        $data = [
            'username' => $_SESSION['username'],
            'success' => $_GET['success'] ?? null,
            'error' => $_GET['error'] ?? null
        ];
        
        $this->view('tarimas/nueva_tarima', $data);
    }

    public function guardarTarima() {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
            return;
        }

        // Solo usuarios con permiso para crear tarimas pueden guardar
        if (!$this->hasAnyRole(['administrador', 'produccion'])) {
            $this->redirect('auth/login');
            return;
        }

        $tarimaData = [
            'codigoBarras' => filter_var(trim($_POST['codigoBarras']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
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

        if ($this->tarimaModel->create($tarimaData)) {
            $this->redirect('tarimas/nueva_tarima?success=entity_created');
        } else {
            $this->redirect('tarimas/nueva_tarima?error=save_failed');
        }
    }
    
    public function listarTarimas() {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
            return;
        }
        
        // Solo usuarios con permiso para ver tarimas pueden acceder
        if (!$this->hasAnyRole(['administrador', 'produccion'])) {
            $this->redirect('auth/login');
            return;
        }
        
        $tarimas = $this->tarimaModel->getLastTarimas(1000);
        
        $data = [
            'username' => $_SESSION['username'],
            'tarimas' => $tarimas,
            'role' => $_SESSION['role'] ?? 'produccion'
        ];
        
        $this->view('tarimas/listar_tarimas', $data);
    }
}
