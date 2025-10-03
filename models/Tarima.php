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
        
        $stmt = $this->db->prepare("INSERT INTO tarimas (codigo_barras, numero_producto, numero_tarima, numero_usuario, cantidad_cajas, peso, numero_venta, descripcion, id_usuario, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([
            $tarimaData['codigoBarras'],
            $tarimaData['numeroProducto'],
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
    
    public function getTodayLastTarimas($limit = 1000) {
        // Validar y asegurar que el límite sea un número entero positivo
        $limit = (int)$limit;
        if ($limit <= 0) {
            $limit = 1000; // Valor por defecto
        }
        
        // Establecer un límite máximo para evitar problemas de rendimiento
        $limit = min($limit, 10000); // Límite máximo de 10,000 para evitar problemas de rendimiento
        
        $today = date('Y-m-d');
        $stmt = $this->db->prepare("SELECT * FROM vista_tarimas_con_legajo WHERE DATE(fecha_registro) = ? ORDER BY fecha_registro DESC LIMIT " . $limit);
        $stmt->execute([$today]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getTotalTarimas() {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM tarimas");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    public function getTodayTarimasCount() {
        $today = date('Y-m-d');
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM vista_tarimas_con_legajo WHERE DATE(fecha_registro) = ?");
        $stmt->execute([$today]);
        return $stmt->fetchColumn();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM tarimas WHERE id_tarima = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getTarimasFiltradas($filtros) {
        // Prepare parameters for the stored procedure
        $numero_producto = isset($filtros['numero_producto']) ? $filtros['numero_producto'] : null;
        $numero_tarima = isset($filtros['numero_tarima']) ? $filtros['numero_tarima'] : null;
        $numero_usuario = isset($filtros['numero_usuario']) ? $filtros['numero_usuario'] : null;
        $numero_venta = isset($filtros['numero_venta']) ? $filtros['numero_venta'] : null;
        $fecha_registro = isset($filtros['fecha_registro']) ? $filtros['fecha_registro'] : null;
        $legajo = isset($filtros['legajo']) ? $filtros['legajo'] : null;
        $nombre_usuario = isset($filtros['nombre_usuario']) ? $filtros['nombre_usuario'] : null;
        $cantidad_cajas_min = isset($filtros['cantidad_cajas_min']) && is_numeric($filtros['cantidad_cajas_min']) ? (int)$filtros['cantidad_cajas_min'] : null;
        $peso_min = isset($filtros['peso_min']) && is_numeric($filtros['peso_min']) ? (float)$filtros['peso_min'] : null;
        
        // Ensure all string parameters are properly sanitized and limited in length
        $numero_producto = ($numero_producto !== null && $numero_producto !== '') ? substr(trim($numero_producto), 0, 6) : null;
        $numero_tarima = ($numero_tarima !== null && $numero_tarima !== '') ? substr(trim($numero_tarima), 0, 6) : null;
        $numero_usuario = ($numero_usuario !== null && $numero_usuario !== '') ? substr(trim($numero_usuario), 0, 2) : null;
        $numero_venta = ($numero_venta !== null && $numero_venta !== '') ? substr(trim($numero_venta), 0, 10) : null;
        $legajo = ($legajo !== null && $legajo !== '') ? substr(trim($legajo), 0, 20) : null;
        $nombre_usuario = ($nombre_usuario !== null && $nombre_usuario !== '') ? substr(trim($nombre_usuario), 0, 101) : null;
        
        // Handle date parameter - convert empty string to null
        $fecha_registro = ($fecha_registro !== null && $fecha_registro !== '') ? $fecha_registro : null;
        
        $sql = "CALL FiltrarTarimas(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $numero_producto,
            $numero_tarima,
            $numero_usuario,
            $numero_venta,
            $fecha_registro,
            $legajo,
            $nombre_usuario,
            $cantidad_cajas_min,
            $peso_min
        ]);
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor(); // Close the cursor to free up resources
        
        return $results;
    }
    
    public function getConnection() {
        return $this->db;
    }
}
