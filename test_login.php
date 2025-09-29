<?php
// Archivo temporal para probar directamente el controlador de login
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Definir la ruta base del proyecto
define('PROJECT_ROOT', __DIR__);

require_once PROJECT_ROOT . '/config/config.php';
require_once PROJECT_ROOT . '/models/Database.php';
require_once PROJECT_ROOT . '/models/Usuario.php';
require_once PROJECT_ROOT . '/controllers/Controller.php';
require_once PROJECT_ROOT . '/controllers/AuthController.php';

echo "Archivos incluidos correctamente.<br>";

// Probar la creación del controlador
$controller = new AuthController();
echo "Controlador AuthController creado correctamente.<br>";

// Probar la ejecución del método showLogin
echo "Ejecutando showLogin...<br>";

try {
    $controller->showLogin();
    echo "showLogin ejecutado sin errores.<br>";
} catch (Exception $e) {
    echo "Error en showLogin: " . $e->getMessage() . "<br>";
    echo "Archivo: " . $e->getFile() . "<br>";
    echo "Línea: " . $e->getLine() . "<br>";
}

?>