-- ELIMINAR LA BASE DE DATOS SI YA EXISTE
DROP DATABASE IF EXISTS gestiontarimas;
-- Script SQL para crear la base de datos de gestión de tarimas
-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS gestiontarimas;
USE gestiontarimas;

-- Crear la tabla de roles
CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT,
    activo TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear la tabla de permisos
CREATE TABLE permisos (
    id_permiso INT AUTO_INCREMENT PRIMARY KEY,
    nombre_permiso VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT,
    modulo VARCHAR(50),
    activo TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear la tabla intermedia roles_permisos
CREATE TABLE roles_permisos (
    id_rol INT,
    id_permiso INT,
    PRIMARY KEY (id_rol, id_permiso),
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol) ON DELETE CASCADE,
    FOREIGN KEY (id_permiso) REFERENCES permisos(id_permiso) ON DELETE CASCADE
);

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
    id_rol INT DEFAULT 2,
    activo TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
);

-- Crear la tabla de tarimas
CREATE TABLE tarimas (
    id_tarima INT AUTO_INCREMENT PRIMARY KEY,
    codigo_barras VARCHAR(30) NOT NULL,
    numero_tarima VARCHAR(6) NOT NULL,
    numero_usuario VARCHAR(2) NOT NULL,
    cantidad_cajas INT NOT NULL,
    peso DECIMAL(10,2) DEFAULT 0.00,
    numero_venta VARCHAR(10) NOT NULL,
    descripcion TEXT,
    id_usuario INT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE SET NULL ON UPDATE CASCADE
);

-- Crear índices para mejorar la velocidad de consulta
CREATE INDEX idx_codigo_barras ON tarimas(codigo_barras);
CREATE INDEX idx_numero_tarima ON tarimas(numero_tarima);
CREATE INDEX idx_fecha_registro ON tarimas(fecha_registro);
CREATE INDEX idx_id_usuario ON tarimas(id_usuario);

-- Insertar roles predeterminados
INSERT INTO roles (nombre_rol, descripcion) VALUES
('administrador', 'Usuario con permisos totales de administración'),
('produccion', 'Usuario con permisos limitados para operaciones de producción'),
('jefe_produccion', 'Jefe de producción con permisos para gestionar tarimas');

-- Insertar permisos predeterminados
INSERT INTO permisos (nombre_permiso, descripcion, modulo) VALUES 
('crear_tarima', 'Permiso para crear nuevas tarimas', 'tarimas'),
('ver_tarimas', 'Permiso para ver el inventario de tarimas', 'tarimas'),
('editar_tarima', 'Permiso para editar tarimas existentes', 'tarimas'),
('eliminar_tarima', 'Permiso para eliminar tarimas', 'tarimas'),
('ver_usuarios', 'Permiso para ver la lista de usuarios', 'usuarios'),
('acceso_admin', 'Permiso para acceso al panel de administración', 'admin');

-- Asignar permisos a roles
-- Administrador: todos los permisos
INSERT INTO roles_permisos (id_rol, id_permiso) VALUES 
(1, 1), -- crear_tarima
(1, 2), -- ver_tarimas
(1, 3), -- editar_tarima
(1, 4), -- eliminar_tarima
(1, 5), -- ver_usuarios
(1, 6); -- acceso_admin

-- Producción: solo crear y ver tarimas
INSERT INTO roles_permisos (id_rol, id_permiso) VALUES 
(2, 1), -- crear_tarima
(2, 2); -- ver_tarimas

-- Jefe de producción: crear, ver y editar tarimas
INSERT INTO roles_permisos (id_rol, id_permiso) VALUES 
(3, 1), -- crear_tarima
(3, 2), -- ver_tarimas
(3, 3), -- editar_tarima
(3, 4); -- eliminar_tarima

-- Insertar un usuario de ejemplo (admin) - contraseña: password
INSERT INTO usuarios (username, email, password, first_name, last_name, legajo, department, id_rol, activo) VALUES
('admin', 'admin@empresa.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'User', '001', 'Administración', 1, 1);

-- Insertar una tarima de ejemplo
INSERT INTO tarimas (codigo_barras, numero_tarima, numero_usuario, cantidad_cajas, peso, numero_venta, descripcion, id_usuario) VALUES
('099999921296599980006045090774', '212965', '06', 45, 0907.74, '25-0774', 'Tarima de ejemplo creada con el código de barras completo', 1);

-- Crear vista para mostrar tarimas con información del usuario
CREATE VIEW vista_tarimas_con_legajo AS
SELECT 
    t.id_tarima,
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
