-- Insertar múltiples tarimas de ejemplo
-- Tarima 1: Producto estándar
INSERT INTO tarimas (codigo_barras, numero_producto, numero_tarima, numero_usuario, cantidad_cajas, peso, numero_venta, descripcion, id_usuario) 
VALUES ('099999921296599980006045090774', '999999', '212965', '06', 45, 907.74, '25-123456', 'Tarima de ejemplo con código de barras completo', 1);

-- Tarima 2: Producto con bajo peso
INSERT INTO tarimas (codigo_barras, numero_producto, numero_tarima, numero_usuario, cantidad_cajas, peso, numero_venta, descripcion, id_usuario) 
VALUES ('012345678901234567890123456789', '123456', '789012', '12', 12, 150.25, '25-234567', 'Tarima con productos livianos', 2);

-- Tarima 3: Producto con alta cantidad de cajas
INSERT INTO tarimas (codigo_barras, numero_producto, numero_tarima, numero_usuario, cantidad_cajas, peso, numero_venta, descripcion, id_usuario) 
VALUES ('098765432109876543210987654321', '789012', '345678', '34', 250, 4500.50, '25-345678', 'Tarima con alta densidad de productos', 3);

-- Tarima 4: Producto de tipo perecedero
INSERT INTO tarimas (codigo_barras, numero_producto, numero_tarima, numero_usuario, cantidad_cajas, peso, numero_venta, descripcion, id_usuario) 
VALUES ('011111111111111111111111111111', '111111', '456789', '56', 75, 890.00, '25-456789', 'Productos perecederos - Manejar con cuidado', 4);

-- Tarima 5: Producto electrónico
INSERT INTO tarimas (codigo_barras, numero_producto, numero_tarima, numero_usuario, cantidad_cajas, peso, numero_venta, descripcion, id_usuario) 
VALUES ('022222222222222222222222222222', '222222', '567890', '78', 30, 500.75, '25-567890', 'Electrónicos - Frágil', 5);

-- Tarima 6: Producto textil
INSERT INTO tarimas (codigo_barras, numero_producto, numero_tarima, numero_usuario, cantidad_cajas, peso, numero_venta, descripcion, id_usuario) 
VALUES ('033333333333333333333333333333', '333333', '678901', '90', 180, 2100.25, '25-678901', 'Ropa textil - Cuidado especial', 6);

-- Tarima 7: Producto alimenticio
INSERT INTO tarimas (codigo_barras, numero_producto, numero_tarima, numero_usuario, cantidad_cajas, peso, numero_venta, descripcion, id_usuario) 
VALUES ('044444444444444444444444444444', '444444', '789012', '01', 95, 1780.90, '25-789012', 'Alimentos envasados', 1);

-- Tarima 8: Producto industrial
INSERT INTO tarimas (codigo_barras, numero_producto, numero_tarima, numero_usuario, cantidad_cajas, peso, numero_venta, descripcion, id_usuario) 
VALUES ('055555555555555555555555555555', '555555', '890123', '15', 55, 3250.60, '25-890123', 'Componentes industriales', 2);

-- Tarima 9: Producto químico
INSERT INTO tarimas (codigo_barras, numero_producto, numero_tarima, numero_usuario, cantidad_cajas, peso, numero_venta, descripcion, id_usuario) 
VALUES ('066666666666666666666666666666', '666666', '901234', '25', 40, 1200.45, '25-901234', 'Productos químicos - Manipular con precaución', 3);

-- Tarima 10: Producto de oficina
INSERT INTO tarimas (codigo_barras, numero_producto, numero_tarima, numero_usuario, cantidad_cajas, peso, numero_venta, descripcion, id_usuario) 
VALUES ('077777777777777777777777777777', '777777', '012345', '35', 85, 680.30, '25-012345', 'Suministros de oficina', 4);