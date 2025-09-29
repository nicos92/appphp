<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/models/Database.php';
require_once __DIR__ . '/models/Usuario.php';

// Test database connection
echo "<h2>Database Connection Test</h2>";
try {
    $db = Database::getInstance()->getConnection();
    echo "Database connection: SUCCESS<br>";
} catch (Exception $e) {
    echo "Database connection: FAILED - " . $e->getMessage() . "<br>";
}

// Test user retrieval
echo "<h2>User Retrieval Test</h2>";
$username = $_GET['username'] ?? 'test';
$usuarioModel = new Usuario();
$user = $usuarioModel->getByUsername($username);

if ($user) {
    echo "User found:<br>";
    echo "ID: " . $user['id'] . "<br>";
    echo "Username: " . $user['username'] . "<br>";
    echo "Email: " . $user['email'] . "<br>";
    echo "Password (first 10 chars): " . substr($user['password'], 0, 10) . "...<br>";
    echo "Password length: " . strlen($user['password']) . "<br>";
    
    // Check if password is properly hashed
    if (strlen($user['password']) >= 60) { // Standard bcrypt hash length
        echo "Password appears to be properly hashed<br>";
    } else {
        echo "Password might not be properly hashed<br>";
    }
} else {
    echo "User not found with username: '$username'<br>";
    
    // Let's try to get all users to see what's in the database
    echo "<h3>All users in the database:</h3>";
    try {
        $stmt = $db->query("SELECT id, username, email FROM usuarios LIMIT 10");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($users) {
            foreach ($users as $u) {
                echo "ID: " . $u['id'] . ", Username: " . $u['username'] . ", Email: " . $u['email'] . "<br>";
            }
        } else {
            echo "No users found in the database<br>";
        }
    } catch (Exception $e) {
        echo "Error fetching users: " . $e->getMessage() . "<br>";
    }
}

// Test password verification
if (isset($_GET['password']) && $user) {
    echo "<h2>Password Verification Test</h2>";
    $inputPassword = $_GET['password'];
    $storedHash = $user['password'];
    
    echo "Input password: $inputPassword<br>";
    echo "Stored hash: $storedHash<br>";
    echo "Password verify result: " . (password_verify($inputPassword, $storedHash) ? 'TRUE' : 'FALSE') . "<br>";
}

echo "<br><h3>Test different username:</h3>";
echo '<form method="GET">';
echo '<input type="text" name="username" placeholder="Username to test" value="' . htmlspecialchars($username) . '">';
echo '<input type="password" name="password" placeholder="Password to test">';
echo '<input type="submit" value="Test">';
echo '</form>';
?>