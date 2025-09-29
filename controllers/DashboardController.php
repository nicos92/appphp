<?php
// controllers/DashboardController.php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Tarima.php';
require_once __DIR__ . '/../models/Usuario.php';

class DashboardController extends Controller {
    private $tarimaModel;
    private $usuarioModel;
    
    public function __construct() {
        parent::__construct();
        $this->tarimaModel = new Tarima();
        $this->usuarioModel = new Usuario();
    }
    
    public function index() {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
            return;
        }
        
        // Obtener estadísticas de tarimas
        $totalTarimas = $this->tarimaModel->getTotalTarimas();
        $tarimasActivas = $this->tarimaModel->getTarimasActivas(); // Asumiendo que todas son activas
        
        // Obtener estadísticas de usuarios
        $totalUsuarios = $this->usuarioModel->getTotalUsuarios();
        
        $data = [
            'username' => $_SESSION['username'],
            'success' => $_GET['success'] ?? null,
            'total_tarimas' => $totalTarimas,
            'tarimas_activas' => $tarimasActivas,
            'total_usuarios' => $totalUsuarios
        ];
        
        $this->view('dashboard/index', $data);
    }
}
?>