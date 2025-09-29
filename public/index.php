<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Definir la ruta base del proyecto para permitir inclusión desde cualquier lugar
define('PROJECT_ROOT', dirname(__DIR__));

// Incluir configuración
require_once PROJECT_ROOT . '/config/config.php';
require_once PROJECT_ROOT . '/models/Database.php';
require_once PROJECT_ROOT . '/models/Usuario.php';
require_once PROJECT_ROOT . '/models/Tarima.php';
require_once PROJECT_ROOT . '/controllers/Controller.php';
require_once PROJECT_ROOT . '/controllers/AuthController.php';
require_once PROJECT_ROOT . '/controllers/DashboardController.php';
require_once PROJECT_ROOT . '/controllers/TarimaController.php';

// Rutas simples para el ejemplo
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Ajustar la URI para eliminar el prefijo
$basePath = '/appphp';
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

if ($uri === '/' || $uri === '' || $uri === '/public') {
    // Redirigir al login o al dashboard según el estado de sesión
    if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
        // Redirect to dashboard if logged in
        header('Location: ' . BASE_URL . '/dashboard');
        exit;
    } else {
        // Redirect to login if not logged in
        header('Location: ' . BASE_URL . '/auth/login');
        exit;
    }
} elseif ($uri === '/auth/login' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new AuthController();
    $controller->showLogin();
} elseif ($uri === '/auth/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new AuthController();
    $controller->login();
} elseif ($uri === '/auth/register' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new AuthController();
    $controller->showRegister();
} elseif ($uri === '/auth/register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new AuthController();
    $controller->register();
} elseif ($uri === '/auth/logout') {
    $controller = new AuthController();
    $controller->logout();
} elseif ($uri === '/dashboard' && isset($_SESSION['user_logged_in'])) {
    $controller = new DashboardController();
    $controller->index();
} elseif ($uri === '/tarimas/nueva_tarima' && isset($_SESSION['user_logged_in'])) {
    $controller = new TarimaController();
    $controller->nuevaTarima();
} elseif ($uri === '/tarimas/guardar' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_logged_in'])) {
    $controller = new TarimaController();
    $controller->guardarTarima();
} elseif ($uri === '/tarimas' && isset($_SESSION['user_logged_in'])) {
    $controller = new TarimaController();
    $controller->listarTarimas();
} elseif ($uri === '/dashboard/usuarios' && isset($_SESSION['user_logged_in'])) {
    $controller = new DashboardController();
    $controller->usuarios();
} else {
    // Página no encontrada
    http_response_code(404);
    echo "Página no encontrada";
}
