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
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM tarimas WHERE id_tarima = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getTarimasFiltradas($filtros) {
        $whereConditions = [];
        $params = [];
        
        // Número de tarima
        if (!empty($filtros['numero_tarima'])) {
            $whereConditions[] = "t.numero_tarima LIKE ?";
            $params[] = '%' . $filtros['numero_tarima'] . '%';
        }
        
        // Número de usuario
        if (!empty($filtros['numero_usuario'])) {
            $whereConditions[] = "t.numero_usuario LIKE ?";
            $params[] = '%' . $filtros['numero_usuario'] . '%';
        }
        
        // Número de venta
        if (!empty($filtros['numero_venta'])) {
            $whereConditions[] = "t.numero_venta LIKE ?";
            $params[] = '%' . $filtros['numero_venta'] . '%';
        }
        
        // Fecha de registro
        if (!empty($filtros['fecha_registro'])) {
            $whereConditions[] = "DATE(t.fecha_registro) = ?";
            $params[] = $filtros['fecha_registro'];
        }
        
        // Legajo
        if (!empty($filtros['legajo'])) {
            $whereConditions[] = "t.legajo LIKE ?";
            $params[] = '%' . $filtros['legajo'] . '%';
        }
        
        // Nombre de usuario
        if (!empty($filtros['nombre_usuario'])) {
            $whereConditions[] = "t.nombre_usuario LIKE ?";
            $params[] = '%' . $filtros['nombre_usuario'] . '%';
        }
        
        // Cantidad de cajas mínima
        if (!empty($filtros['cantidad_cajas_min']) && is_numeric($filtros['cantidad_cajas_min'])) {
            $whereConditions[] = "t.cantidad_cajas >= ?";
            $params[] = (int)$filtros['cantidad_cajas_min'];
        }
        
        // Peso mínimo
        if (!empty($filtros['peso_min']) && is_numeric($filtros['peso_min'])) {
            $whereConditions[] = "t.peso >= ?";
            $params[] = (float)$filtros['peso_min'];
        }
        
        $whereClause = '';
        if (!empty($whereConditions)) {
            $whereClause = 'WHERE ' . implode(' AND ', $whereConditions);
        }
        
        $sql = "SELECT
                    t.id_tarima,
                    t.numero_tarima,
                    t.numero_usuario,
                    t.cantidad_cajas,
                    t.peso,
                    t.numero_venta,
                    t.descripcion,
                    t.fecha_registro,
                    t.legajo,
                    t.nombre_usuario
                FROM vista_tarimas_con_legajo t
                {$whereClause}
                ORDER BY t.fecha_registro DESC
                LIMIT 1000";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getConnection() {
        return $this->db;
    }
}
