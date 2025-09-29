<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/models/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    // Get table structure
    echo "<h2>Usuarios table structure:</h2>";
    $stmt = $db->query("DESCRIBE usuarios");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        echo "Field: " . $column['Field'] . ", Type: " . $column['Type'] . ", Null: " . $column['Null'] . ", Key: " . $column['Key'] . "<br>";
    }
    
    echo "<h2>Sample user data (first 5):</h2>";
    $stmt = $db->query("SELECT * FROM usuarios LIMIT 5");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($users as $user) {
        echo "<pre>";
        print_r($user);
        echo "</pre><br>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>