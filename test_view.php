<?php
// Archivo para probar directamente la función view()
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Definir la ruta base del proyecto
define('PROJECT_ROOT', __DIR__);

require_once PROJECT_ROOT . '/config/config.php';
require_once PROJECT_ROOT . '/models/Database.php';
require_once PROJECT_ROOT . '/controllers/Controller.php';

// Crear una subclase para poder acceder al método view()
class TestController extends Controller {
    public function testView($view, $data = []) {
        return $this->view($view, $data);
    }
}

$controller = new TestController();

echo "Controlador de prueba creado.<br>";

// Probar la función view() usando la subclase
echo "Probando la función view()...<br>";

try {
    $controller->testView('auth/login', ['error' => null]);
    echo "La función view() se ejecutó sin errores.<br>";
} catch (Exception $e) {
    echo "Error en la función view(): " . $e->getMessage() . "<br>";
    echo "Archivo: " . $e->getFile() . "<br>";
    echo "Línea: " . $e->getLine() . "<br>";
}

?>