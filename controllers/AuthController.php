<?php
// controllers/AuthController.php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Usuario.php';

class AuthController extends Controller {
    private $usuarioModel;

    public function __construct() {
        parent::__construct();
        $this->usuarioModel = new Usuario();
    }

    public function showLogin() {
        $this->view('auth/login', ['error' => $_GET['error'] ?? null]);
    }

    public function login() {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $remember = isset($_POST['remember']);

        if (empty($username) || empty($password)) {
            $this->redirect('auth/login?error=empty_fields');
            return;
        }

        // Check if user exists in database
        $user = $this->usuarioModel->getByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user['id_usuario'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['nombre_rol'] ?? 'produccion'; // Por defecto 'produccion' si no tiene rol asignado

            if ($remember) {
                setcookie('remember_user', $username, time() + (86400 * 30), '/');
            }

            $this->redirect('dashboard');
        } else {
            // Debug: Log failed login attempts (be careful with this in production)
            error_log("Login failed for username: '$username'. User found in DB: " . ($user ? 'yes' : 'no'));
            if ($user) {
                error_log("Stored password hash length: " . strlen($user['password']) . ", starts with: " . substr($user['password'], 0, 10));
                error_log("Password verify result: " . (password_verify($password, $user['password']) ? 'true' : 'false'));
            }
            
            $this->redirect('auth/login?error=invalid_credentials');
        }
    }

    public function showRegister() {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
            return;
        }
        
        // Solo administradores pueden registrar nuevos usuarios
        if (!$this->hasRole('administrador')) {
            $this->redirect('dashboard');
            return;
        }
        
        $data = [
            'error' => $_GET['error'] ?? null,
            'success' => $_GET['success'] ?? null,
            'role' => $_SESSION['role'] ?? null
        ];
        
        $this->view('auth/register', $data);
    }

    public function register() {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
            return;
        }

        // Solo administradores pueden crear nuevos usuarios
        if (!$this->hasRole('administrador')) {
            $this->redirect('dashboard');
            return;
        }

        $userData = [
            'firstName' => trim($_POST['firstName']),
            'lastName' => trim($_POST['lastName']),
            'email' => trim($_POST['email']),
            'username' => trim($_POST['username']),
            'legajo' => trim($_POST['legajo']),
            'password' => $_POST['password'],
            'confirmPassword' => $_POST['confirmPassword'],
            'department' => $_POST['department']
        ];

        // Solo los administradores pueden asignar roles y estado
        if ($this->hasRole('administrador')) {
            $userData['idRol'] = (int)($_POST['idRol'] ?? 2); // Por defecto rol de producción
            $userData['activo'] = isset($_POST['activo']) ? 1 : 0; // Por defecto inactivo
        } else {
            $userData['idRol'] = 2; // Por defecto rol de producción
            $userData['activo'] = 1; // Por defecto activo
        }

        // Validaciones...
        if (empty($userData['firstName']) || empty($userData['lastName']) || empty($userData['email']) || 
            empty($userData['username']) || empty($userData['legajo']) || empty($userData['password']) || 
            empty($userData['confirmPassword'])) {
            $this->redirect('auth/register?error=empty_fields');
            return;
        }

        if ($userData['password'] !== $userData['confirmPassword']) {
            $this->redirect('auth/register?error=password_mismatch');
            return;
        }

        // Eliminar la validación de términos y condiciones, ya que no es necesaria

        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            $this->redirect('auth/register?error=invalid_email');
            return;
        }

        // Verificar si el usuario ya existe
        if ($this->usuarioModel->exists($userData['username'], $userData['email'])) {
            $this->redirect('auth/register?error=user_exists');
            return;
        }

        // Encriptar la contraseña
        $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
        unset($userData['confirmPassword']); // No necesitamos guardar la confirmación

        if ($this->usuarioModel->create($userData)) {
            $this->redirect('auth/register?success=true');
        } else {
            $this->redirect('auth/register?error=registration_failed');
        }
    }

    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        
        if (isset($_COOKIE['remember_user'])) {
            setcookie('remember_user', '', time() - 3600, '/');
        }
        
        $this->redirect('auth/login');
    }
}
?>