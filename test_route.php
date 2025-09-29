<?php
// Archivo para probar el flujo completo como en public/index.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Definir la ruta base del proyecto
define('PROJECT_ROOT', __DIR__);

require_once PROJECT_ROOT . '/config/config.php';
require_once PROJECT_ROOT . '/models/Database.php';
require_once PROJECT_ROOT . '/models/Usuario.php';
require_once PROJECT_ROOT . '/models/Tarima.php';
require_once PROJECT_ROOT . '/controllers/Controller.php';
require_once PROJECT_ROOT . '/controllers/AuthController.php';
require_once PROJECT_ROOT . '/controllers/DashboardController.php';
require_once PROJECT_ROOT . '/controllers/TarimaController.php';

// Simular la URI que se obtendría al acceder a /auth/login directamente
$_SERVER['REQUEST_URI'] = '/appphp/auth/login';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Ajustar la URI para eliminar el prefijo
$basePath = '/appphp';
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

echo "URI procesada: " . $uri . "<br>";

if ($uri === '/auth/login' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    echo "Ejecutando AuthController->showLogin()...<br>";
    $controller = new AuthController();
    $controller->showLogin();
    echo "showLogin finalizado.<br>";
} else {
    echo "Ruta no coincidente. URI: " . $uri . "<br>";
}

?>