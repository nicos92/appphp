<?php
// models/Tarima.php
require_once __DIR__ . '/Database.php';

class Tarima {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($tarimaData) {
        $idUsuario = $tarimaData['idUsuario'];
        
        // Si se proporciona un idUsuario distinto de 0, verificar que exista en la tabla de usuarios
        if ($idUsuario != 0) {
            $userCheck = $this->db->prepare("SELECT id_usuario FROM usuarios WHERE id_usuario = ?");
            $userCheck->execute([$idUsuario]);
            $userExists = $userCheck->fetch();
            
            if (!$userExists) {
                // Si el usuario no existe, establecer idUsuario a NULL
                $idUsuario = null;
            }
        }
        
        $stmt = $this->db->prepare("INSERT INTO tarimas (codigo_barras, numero_tarima, numero_usuario, cantidad_cajas, peso, numero_venta, descripcion, id_usuario, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([
            $tarimaData['codigoBarras'],
            $tarimaData['numeroTarima'],
            $tarimaData['numeroUsuario'],
            $tarimaData['cantidadCajas'],
            $tarimaData['peso'],
            $tarimaData['numeroVenta'],
            $tarimaData['descripcion'],
            $idUsuario
        ]);
    }
    
    public function getLastTarimas($limit = 1000) {
        // Validar y asegurar que el límite sea un número entero positivo
        $limit = (int)$limit;
        if ($limit <= 0) {
            $limit = 1000; // Valor por defecto
        }
        
        // Establecer un límite máximo para evitar problemas de rendimiento
        $limit = min($limit, 10000); // Límite máximo de 10,000 para evitar problemas de rendimiento
        
        $stmt = $this->db->prepare("SELECT * FROM vista_tarimas_con_legajo ORDER BY fecha_registro DESC LIMIT " . $limit);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getTotalTarimas() {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM tarimas");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
   
}
