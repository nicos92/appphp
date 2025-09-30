-- Actualizar procedimiento almacenado para filtrar tarimas por número de producto

-- Eliminar el procedimiento existente
DROP PROCEDURE IF EXISTS FiltrarTarimas;

-- Crear procedimiento almacenado actualizado con el número de producto como primer parámetro
DELIMITER //

CREATE PROCEDURE FiltrarTarimas(
    IN p_numero_producto VARCHAR(6),
    IN p_numero_tarima VARCHAR(6),
    IN p_numero_usuario VARCHAR(2),
    IN p_numero_venta VARCHAR(10),
    IN p_fecha_registro DATE,
    IN p_legajo VARCHAR(20),
    IN p_nombre_usuario VARCHAR(101),
    IN p_cantidad_cajas_min INT,
    IN p_peso_min DECIMAL(10,2)
)
BEGIN
    SELECT 
        t.id_tarima,
        t.numero_tarima,
        t.numero_producto,
        t.numero_usuario,
        t.cantidad_cajas,
        t.peso,
        t.numero_venta,
        t.descripcion,
        t.fecha_registro,
        u.legajo,
        CONCAT(u.first_name, ' ', u.last_name) AS nombre_usuario
    FROM tarimas t
    LEFT JOIN usuarios u ON t.id_usuario = u.id_usuario
    WHERE 
        (p_numero_producto IS NULL OR p_numero_producto = '' OR t.numero_producto LIKE CONCAT('%', p_numero_producto, '%'))
        AND (p_numero_tarima IS NULL OR p_numero_tarima = '' OR t.numero_tarima LIKE CONCAT('%', p_numero_tarima, '%'))
        AND (p_numero_usuario IS NULL OR p_numero_usuario = '' OR t.numero_usuario LIKE CONCAT('%', p_numero_usuario, '%'))
        AND (p_numero_venta IS NULL OR p_numero_venta = '' OR t.numero_venta LIKE CONCAT('%', p_numero_venta, '%'))
        AND (p_fecha_registro IS NULL OR DATE(t.fecha_registro) = p_fecha_registro)
        AND (p_legajo IS NULL OR p_legajo = '' OR u.legajo LIKE CONCAT('%', p_legajo, '%'))
        AND (p_nombre_usuario IS NULL OR p_nombre_usuario = '' OR CONCAT(u.first_name, ' ', u.last_name) LIKE CONCAT('%', p_nombre_usuario, '%'))
        AND (p_cantidad_cajas_min IS NULL OR t.cantidad_cajas >= p_cantidad_cajas_min)
        AND (p_peso_min IS NULL OR t.peso >= p_peso_min)
    ORDER BY t.fecha_registro DESC
    LIMIT 1000;
END //

DELIMITER ;