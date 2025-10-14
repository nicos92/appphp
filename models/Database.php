<?php
// models/Database.php
class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        // === DSN CORREGIDO ===
        // El charset debe estar en la primera cadena (el DSN).
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

        try {
            // Los argumentos ahora son: DSN, Usuario, Contraseña
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS);

            // Configuración de atributos (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION)
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // En un entorno de producción, es mejor registrar el error que mostrarlo al usuario.
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}
