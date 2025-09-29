<?php
// Archivo de prueba de conexión a la base de datos
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/config/config.php';

echo "Incluyendo Database.php...<br>";
require_once __DIR__ . '/models/Database.php';

echo "Creando instancia de Database...<br>";
try {
    $db = Database::getInstance();
    $pdo = $db->getConnection();
    echo "Conexión exitosa a la base de datos.<br>";
} catch (Exception $e) {
    echo "Error de conexión: " . $e->getMessage() . "<br>";
    die();
}

echo "Probando consulta de usuarios...<br>";
try {
    $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios");
    $count = $stmt->fetchColumn();
    echo "Tabla usuarios existe y tiene $count usuarios.<br>";
} catch (Exception $e) {
    echo "Error al consultar usuarios: " . $e->getMessage() . "<br>";
}

echo "Probando consulta de tarimas...<br>";
try {
    $stmt = $pdo->query("SELECT COUNT(*) FROM tarimas");
    $count = $stmt->fetchColumn();
    echo "Tabla tarimas existe y tiene $count tarimas.<br>";
} catch (Exception $e) {
    echo "Error al consultar tarimas: " . $e->getMessage() . "<br>";
}

echo "Todo parece funcionar correctamente.<br>";
?>