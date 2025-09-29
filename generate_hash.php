<?php
// Script para generar un hash de contraseña
$password = $_GET['password'] ?? '@Admin1234';

echo "<h2>Generador de Hash de Contraseña</h2>";
echo "Contraseña original: " . htmlspecialchars($password) . "<br>";
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo "Hash de contraseña: " . $hashedPassword . "<br><br>";

echo "Para actualizar la contraseña en la base de datos, ejecuta esta consulta SQL:<br>";
echo "<code>UPDATE usuarios SET password = '$hashedPassword' WHERE username = 'nicolas';</code><br><br>";

echo "Formulario para generar otro hash:<br>";
echo '<form method="GET">';
echo '<input type="text" name="password" placeholder="Contraseña" value="' . htmlspecialchars($password) . '">';
echo '<input type="submit" value="Generar Hash">';
echo '</form>';
?>