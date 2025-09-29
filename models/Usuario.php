<?php
// models/Usuario.php
require_once __DIR__ . '/Database.php';

class Usuario {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($userData) {
        $stmt = $this->db->prepare("INSERT INTO usuarios (username, email, password, first_name, last_name, legajo, department) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $userData['username'],
            $userData['email'],
            $userData['password'],
            $userData['firstName'],
            $userData['lastName'],
            $userData['legajo'],
            $userData['department']
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
}
