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
        
        // Verificar si el usuario tiene permiso para ver el panel completo
        if (!$this->hasRole('administrador')) {
            // Los usuarios de producción pueden ver el dashboard pero con acceso limitado
        }
        
        // Obtener estadísticas de tarimas
        $totalTarimas = $this->tarimaModel->getTotalTarimas();
        $tarimasActivas = $this->tarimaModel->getTarimasActivas(); // Asumiendo que todas son activas
        
        // Obtener estadísticas de usuarios solo si es administrador
        $totalUsuarios = 0;
        if ($this->hasRole('administrador')) {
            $totalUsuarios = $this->usuarioModel->getTotalUsuarios();
        }
        
        $data = [
            'username' => $_SESSION['username'],
            'success' => $_GET['success'] ?? null,
            'total_tarimas' => $totalTarimas,
            'tarimas_activas' => $tarimasActivas,
            'total_usuarios' => $totalUsuarios,
            'role' => $_SESSION['role'] ?? 'produccion'
        ];
        
        $this->view('dashboard/index', $data);
    }
    
    public function usuarios() {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
            return;
        }
        
        // Solo usuarios con rol de administrador pueden ver la lista de usuarios
        if (!$this->hasRole('administrador')) {
            $this->redirect('auth/login');
            return;
        }
        
        $usuarios = $this->usuarioModel->getAllUsuariosWithRoles();
        
        $data = [
            'username' => $_SESSION['username'],
            'role' => $_SESSION['role'],
            'usuarios' => $usuarios
        ];
        
        $this->view('dashboard/usuarios', $data);
    }
}
?>