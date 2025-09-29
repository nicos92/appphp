<?php
// models/Tarima.php
require_once __DIR__ . '/Database.php';

class Tarima {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($tarimaData) {
        $stmt = $this->db->prepare("INSERT INTO tarimas (codigo_barras, numero_tarima, numero_usuario, cantidad_cajas, peso, numero_venta, descripcion, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([
            $tarimaData['codigoBarras'],
            $tarimaData['numeroTarima'],
            $tarimaData['numeroUsuario'],
            $tarimaData['cantidadCajas'],
            $tarimaData['peso'],
            $tarimaData['numeroVenta'],
            $tarimaData['descripcion']
        ]);
    }
}
