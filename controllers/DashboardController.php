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
        
        // Obtener estadísticas de usuarios solo si es administrador
        $totalUsuarios = 0;
        if ($this->hasRole('administrador')) {
            $totalUsuarios = $this->usuarioModel->getTotalUsuarios();
        }
        
        $data = [
            'username' => $_SESSION['username'],
            'title' => 'Panel de Control',
            'success' => $_GET['success'] ?? null,
            'total_tarimas' => $totalTarimas,
            'tarimas_activas' => "",
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
            'title' => 'Gestión de Usuarios',
            'role' => $_SESSION['role'],
            'usuarios' => $usuarios
        ];
        
        $this->view('dashboard/usuarios', $data);
    }
    
    public function editarUsuario($id) {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
            return;
        }
        
        // Solo usuarios con rol de administrador pueden editar usuarios
        if (!$this->hasRole('administrador')) {
            $this->redirect('auth/login');
            return;
        }
        
        $stmt = $this->usuarioModel->getConnection()->prepare("
            SELECT u.*, r.nombre_rol
            FROM usuarios u
            LEFT JOIN roles r ON u.id_rol = r.id_rol
            WHERE u.id_usuario = ?
        ");
        $stmt->execute([$id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$usuario) {
            $this->redirect('dashboard/usuarios');
            return;
        }
        
        $data = [
            'username' => $_SESSION['username'],
            'title' => 'Editar Usuario',
            'role' => $_SESSION['role'],
            'usuario' => $usuario
        ];
        
        $this->view('dashboard/editar_usuario', $data);
    }
    
    public function actualizarUsuario($id) {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
            return;
        }
        
        // Solo usuarios con rol de administrador pueden actualizar usuarios
        if (!$this->hasRole('administrador')) {
            $this->redirect('auth/login');
            return;
        }
        
        $usuarioData = [
            'id' => $id,
            'firstName' => trim($_POST['firstName']),
            'lastName' => trim($_POST['lastName']),
            'email' => trim($_POST['email']),
            'username' => trim($_POST['username']),
            'legajo' => trim($_POST['legajo']),
            'department' => $_POST['department'],
            'idRol' => (int)($_POST['idRol'] ?? 2),
            'activo' => isset($_POST['activo']) ? 1 : 0,
            'newPassword' => trim($_POST['newPassword'] ?? ''),
            'confirmPassword' => trim($_POST['confirmPassword'] ?? '')
        ];

        // Validaciones...
        if (empty($usuarioData['firstName']) || empty($usuarioData['lastName']) ||
            empty($usuarioData['email']) || empty($usuarioData['username']) || empty($usuarioData['legajo'])) {
            $this->redirect('dashboard/editar_usuario/' . $id . '?error=empty_fields');
            return;
        }

        if (!filter_var($usuarioData['email'], FILTER_VALIDATE_EMAIL)) {
            $this->redirect('dashboard/editar_usuario/' . $id . '?error=invalid_email');
            return;
        }

        // Verificar si el email o username ya están siendo usados por otro usuario
        $existingUserStmt = $this->usuarioModel->getConnection()->prepare("
            SELECT id_usuario FROM usuarios WHERE (email = ? OR username = ?) AND id_usuario != ?
        ");
        $existingUserStmt->execute([$usuarioData['email'], $usuarioData['username'], $usuarioData['id']]);
        $existingUser = $existingUserStmt->fetch();
        
        if ($existingUser) {
            $this->redirect('dashboard/editar_usuario/' . $id . '?error=user_exists');
            return;
        }

        // Si se proporciona una nueva contraseña, validarla
        if (!empty($usuarioData['newPassword']) || !empty($usuarioData['confirmPassword'])) {
            // Verificar que ambas contraseñas estén presentes y coincidan
            if (empty($usuarioData['newPassword']) || empty($usuarioData['confirmPassword'])) {
                $this->redirect('dashboard/editar_usuario/' . $id . '?error=empty_password_fields');
                return;
            }
            
            if ($usuarioData['newPassword'] !== $usuarioData['confirmPassword']) {
                $this->redirect('dashboard/editar_usuario/' . $id . '?error=password_mismatch');
                return;
            }
            
            // Validar la contraseña
            if (strlen($usuarioData['newPassword']) < 6) {
                $this->redirect('dashboard/editar_usuario/' . $id . '?error=weak_password');
                return;
            }
            
            // Encriptar la contraseña
            $usuarioData['newPassword'] = password_hash($usuarioData['newPassword'], PASSWORD_DEFAULT);
            
            // Actualizar con contraseña incluida
            $stmt = $this->usuarioModel->getConnection()->prepare("
                UPDATE usuarios
                SET first_name = ?, last_name = ?, email = ?, username = ?, legajo = ?,
                    department = ?, id_rol = ?, activo = ?, password = ?
                WHERE id_usuario = ?
            ");
            
            $result = $stmt->execute([
                $usuarioData['firstName'],
                $usuarioData['lastName'],
                $usuarioData['email'],
                $usuarioData['username'],
                $usuarioData['legajo'],
                $usuarioData['department'],
                $usuarioData['idRol'],
                $usuarioData['activo'],
                $usuarioData['newPassword'],
                $usuarioData['id']
            ]);
        } else {
            // Actualizar sin cambiar contraseña
            $stmt = $this->usuarioModel->getConnection()->prepare("
                UPDATE usuarios
                SET first_name = ?, last_name = ?, email = ?, username = ?, legajo = ?,
                    department = ?, id_rol = ?, activo = ?
                WHERE id_usuario = ?
            ");
            
            $result = $stmt->execute([
                $usuarioData['firstName'],
                $usuarioData['lastName'],
                $usuarioData['email'],
                $usuarioData['username'],
                $usuarioData['legajo'],
                $usuarioData['department'],
                $usuarioData['idRol'],
                $usuarioData['activo'],
                $usuarioData['id']
            ]);
        }
        
        if ($result) {
            $this->redirect('dashboard/usuarios?success=usuario_actualizado');
        } else {
            $this->redirect('dashboard/editar_usuario/' . $id . '?error=update_failed');
        }
    }
}

