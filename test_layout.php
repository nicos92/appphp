<?php
// Archivo para probar directamente el layout
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Definir la ruta base del proyecto
define('PROJECT_ROOT', __DIR__);

require_once PROJECT_ROOT . '/config/config.php';

// Probar el archivo de layout directamente
$viewPath = __DIR__ . '/views/layouts/main.php';

if (file_exists($viewPath)) {
    echo "El archivo de layout existe.<br>";
    
    // Simular variables que deberían estar disponibles
    $content = '<h1>Contenido de prueba</h1>';
    $title = 'Título de prueba';
    
    // Incluir directamente el layout
    include $viewPath;
} else {
    echo "El archivo de layout no existe: " . $viewPath;
}

?>