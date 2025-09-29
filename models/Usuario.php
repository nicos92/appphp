<?php
// models/Usuario.php
require_once __DIR__ . '/Database.php';

class Usuario {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getByUsername($username) {
        $stmt = $this->db->prepare("SELECT u.*, r.nombre_rol FROM usuarios u LEFT JOIN roles r ON u.id_rol = r.id_rol WHERE u.username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($userData) {
        $idRol = $userData['idRol'] ?? 2; // Por defecto rol de producción (id_rol = 2)
        $activo = $userData['activo'] ?? 1; // Por defecto activo (1)
        
        $stmt = $this->db->prepare("INSERT INTO usuarios (username, email, password, first_name, last_name, legajo, department, id_rol, activo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $userData['username'],
            $userData['email'],
            $userData['password'],
            $userData['firstName'],
            $userData['lastName'],
            $userData['legajo'],
            $userData['department'],
            $idRol,
            $activo
        ]);
    }

    public function exists($username, $email) {
        $stmt = $this->db->prepare("SELECT id_usuario FROM usuarios WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        return $stmt->fetch() !== false;
    }
    
    public function getTotalUsuarios() {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM usuarios");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    public function getAllUsuariosWithRoles() {
        $stmt = $this->db->prepare("
            SELECT u.id_usuario, u.username, u.email, u.first_name, u.last_name, u.legajo, u.department, u.created_at, u.activo, r.nombre_rol
            FROM usuarios u
            LEFT JOIN roles r ON u.id_rol = r.id_rol
            ORDER BY u.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getConnection() {
        return $this->db;
    }
}
