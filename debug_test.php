<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

echo "<h2>Debug Information</h2>";

echo "<h3>Configuration:</h3>";
echo "BASE_URL: " . BASE_URL . "<br>";

echo "<h3>Session Status:</h3>";
echo "Session ID: " . session_id() . "<br>";
echo "Session Variables: ";
var_dump($_SESSION);

echo "<h3>Files Check:</h3>";
$files = [
    __DIR__ . '/public/index.php',
    __DIR__ . '/config/config.php',
    __DIR__ . '/controllers/AuthController.php',
    __DIR__ . '/views/auth/login.php',
    __DIR__ . '/views/layouts/main.php'
];
foreach ($files as $file) {
    echo "File: $file - " . (file_exists($file) ? "EXISTS" : "NOT FOUND") . "<br>";
}

echo "<h3>Testing View Rendering:</h3>";
try {
    require_once __DIR__ . '/config/config.php';
    require_once __DIR__ . '/controllers/Controller.php';
    require_once __DIR__ . '/controllers/AuthController.php';
    
    $controller = new AuthController();
    echo "Controller created successfully<br>";
    
    // Try to manually render the login view
    $viewPath = __DIR__ . '/views/';
    $viewFile = $viewPath . 'auth/login.php';
    $layoutFile = $viewPath . 'layouts/main.php';
    
    echo "View file: $viewFile - " . (file_exists($viewFile) ? "EXISTS" : "NOT FOUND") . "<br>";
    echo "Layout file: $layoutFile - " . (file_exists($layoutFile) ? "EXISTS" : "NOT FOUND") . "<br>";
    
    if (file_exists($viewFile)) {
        ob_start();
        include $viewFile;
        $content = ob_get_clean();
        echo "Content loaded successfully, length: " . strlen($content) . "<br>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
    echo "Trace: " . $e->getTraceAsString();
}
?>