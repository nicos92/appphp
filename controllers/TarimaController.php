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

        $tarimaData = [
            'codigoBarras' => filter_var(trim($_POST['codigoBarras']), FILTER_SANITIZE_STRING),
            'numeroTarima' => filter_var(trim($_POST['numeroTarima']), FILTER_SANITIZE_STRING),
            'numeroUsuario' => filter_var(trim($_POST['numeroUsuario']), FILTER_SANITIZE_STRING),
            'cantidadCajas' => filter_var(trim($_POST['cantidadCajas']), FILTER_VALIDATE_INT) ? (int)$_POST['cantidadCajas'] : 0,
            'peso' => filter_var(trim($_POST['peso']), FILTER_VALIDATE_FLOAT) ? (float)$_POST['peso'] : 0,
            'numeroVenta' => filter_var(trim($_POST['numeroVenta']), FILTER_SANITIZE_STRING),
            'descripcion' => filter_var(trim($_POST['descripcion']), FILTER_SANITIZE_STRING)
        ];

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
}
?>