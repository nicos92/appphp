-- ELIMINAR LA BASE DE DATOS SI YA EXISTE
DROP DATABASE IF EXISTS gestiontarimas;
-- Script SQL para crear la base de datos de gestión de tarimas
-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS gestiontarimas;
USE gestiontarimas;

-- Crear la tabla de usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    legajo VARCHAR(20) NOT NULL,
    department VARCHAR(100),
    activo TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Crear la tabla de tarimas sin la clave foránea
CREATE TABLE tarimas (
    id_tarima INT AUTO_INCREMENT PRIMARY KEY,
    codigo_barras VARCHAR(30) NOT NULL,
    numero_tarima VARCHAR(6) NOT NULL,
    numero_usuario VARCHAR(2) NOT NULL,
    cantidad_cajas INT NOT NULL,
    peso DECIMAL(10,2) DEFAULT 0.00,
    numero_venta VARCHAR(10) NOT NULL,
    descripcion TEXT,
    id_usuario INT NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Añadir la clave foránea después de crear ambas tablas
ALTER TABLE tarimas 
ADD CONSTRAINT fk_tarima_usuario 
FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) 
ON DELETE SET NULL 
ON UPDATE CASCADE;

-- Crear índices para mejorar la velocidad de consulta
CREATE INDEX idx_codigo_barras ON tarimas(codigo_barras);
CREATE INDEX idx_numero_tarima ON tarimas(numero_tarima);
CREATE INDEX idx_fecha_registro ON tarimas(fecha_registro);
CREATE INDEX idx_id_usuario ON tarimas(id_usuario);

-- Insertar un usuario de ejemplo
INSERT INTO usuarios (username, email, password, first_name, last_name, legajo, department, activo) VALUES
('admin', 'admin@empresa.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'User', '001', 'Administración', 1);

-- Insertar una tarima de ejemplo
INSERT INTO tarimas (codigo_barras, numero_tarima, numero_usuario, cantidad_cajas, peso, numero_venta, descripcion, id_usuario) VALUES
('099999921296599980006045090774', '212965', '06', 45, 0907.74, '25-0774', 'Tarima de ejemplo creada con el código de barras completo', 1);

-- creacion de vista general
CREATE VIEW vista_tarimas_con_legajo AS
SELECT t.id_tarima,
t.codigo_barras, 
t.numero_tarima, 
t.numero_usuario, 
t.cantidad_cajas, 
t.peso, 
t.numero_venta, 
t.descripcion, 
t.fecha_registro, 
u.legajo, 
CONCAT(u.first_name, ' ', u.last_name) AS nombre_usuario
FROM tarimas t 
LEFT JOIN usuarios u ON t.id_usuario = u.id_usuario;
