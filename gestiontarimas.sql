-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-09-2025 a las 17:59:02
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestiontarimas`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `FiltrarTarimas` (IN `p_numero_tarima` VARCHAR(6), IN `p_numero_usuario` VARCHAR(2), IN `p_numero_venta` VARCHAR(10), IN `p_fecha_registro` DATE, IN `p_legajo` VARCHAR(20), IN `p_nombre_usuario` VARCHAR(101), IN `p_cantidad_cajas_min` INT, IN `p_peso_min` DECIMAL(10,2))   BEGIN
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
    LEFT JOIN usuarios u ON t.id_usuario = u.id_usuario
    WHERE 
        (p_numero_tarima IS NULL OR p_numero_tarima = '' OR t.numero_tarima LIKE CONCAT('%', p_numero_tarima, '%'))
        AND (p_numero_usuario IS NULL OR p_numero_usuario = '' OR t.numero_usuario LIKE CONCAT('%', p_numero_usuario, '%'))
        AND (p_numero_venta IS NULL OR p_numero_venta = '' OR t.numero_venta LIKE CONCAT('%', p_numero_venta, '%'))
        AND (p_fecha_registro IS NULL OR DATE(t.fecha_registro) = p_fecha_registro)
        AND (p_legajo IS NULL OR p_legajo = '' OR u.legajo LIKE CONCAT('%', p_legajo, '%'))
        AND (p_nombre_usuario IS NULL OR p_nombre_usuario = '' OR CONCAT(u.first_name, ' ', u.last_name) LIKE CONCAT('%', p_nombre_usuario, '%'))
        AND (p_cantidad_cajas_min IS NULL OR t.cantidad_cajas >= p_cantidad_cajas_min)
        AND (p_peso_min IS NULL OR t.peso >= p_peso_min)
    ORDER BY t.fecha_registro DESC
    LIMIT 1000;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL,
  `nombre_permiso` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `modulo` varchar(50) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `nombre_permiso`, `descripcion`, `modulo`, `activo`, `created_at`) VALUES
(1, 'crear_tarima', 'Permiso para crear nuevas tarimas', 'tarimas', 1, '2025-09-29 09:29:35'),
(2, 'ver_tarimas', 'Permiso para ver el inventario de tarimas', 'tarimas', 1, '2025-09-29 09:29:35'),
(3, 'editar_tarima', 'Permiso para editar tarimas existentes', 'tarimas', 1, '2025-09-29 09:29:35'),
(4, 'eliminar_tarima', 'Permiso para eliminar tarimas', 'tarimas', 1, '2025-09-29 09:29:35'),
(5, 'ver_usuarios', 'Permiso para ver la lista de usuarios', 'usuarios', 1, '2025-09-29 09:29:35'),
(6, 'acceso_admin', 'Permiso para acceso al panel de administración', 'admin', 1, '2025-09-29 09:29:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`, `descripcion`, `activo`, `created_at`) VALUES
(1, 'administrador', 'Usuario con permisos totales de administración', 1, '2025-09-29 09:29:34'),
(2, 'produccion', 'Usuario con permisos limitados para operaciones de producción', 1, '2025-09-29 09:29:34'),
(3, 'jefe_produccion', 'Jefe de producción con permisos para gestionar tarimas', 1, '2025-09-29 12:17:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_permisos`
--

CREATE TABLE `roles_permisos` (
  `id_rol` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles_permisos`
--

INSERT INTO `roles_permisos` (`id_rol`, `id_permiso`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(3, 3),
(3, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarimas`
--

CREATE TABLE `tarimas` (
  `id_tarima` int(11) NOT NULL,
  `codigo_barras` varchar(30) NOT NULL,
  `numero_tarima` varchar(6) NOT NULL,
  `numero_usuario` varchar(2) NOT NULL,
  `cantidad_cajas` int(11) NOT NULL,
  `peso` decimal(10,2) DEFAULT 0.00,
  `numero_venta` varchar(10) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tarimas`
--

INSERT INTO `tarimas` (`id_tarima`, `codigo_barras`, `numero_tarima`, `numero_usuario`, `cantidad_cajas`, `peso`, `numero_venta`, `descripcion`, `id_usuario`, `fecha_registro`) VALUES
(1, '099999921296599980006045090774', '212965', '06', 45, 907.74, '25-0774', 'Tarima de ejemplo creada con el código de barras completo', 1, '2025-09-29 08:35:00'),
(5, '099999988888899988888888888888', '888888', '88', 888, 8888.88, '25-880000', '', 2, '2025-09-29 09:22:24'),
(6, '099999912345699981212123123456', '123456', '12', 123, 1234.56, '25-230000', '', 2, '2025-09-29 09:26:37'),
(7, '099999955555599985555555555555', '555555', '55', 555, 5555.55, '25-550000', '', 2, '2025-09-29 10:05:34'),
(8, '099999965465499986546654645321', '654654', '46', 654, 6453.21, '25-450000', 'tarima de prueba de edicion 5', 3, '2025-09-29 11:00:40'),
(9, '099999977777799987777777777777', '777777', '77', 777, 7777.77, '25-770000', 'hlo', 2, '2025-09-29 14:17:28'),
(10, '099999988888899988888888888888', '888888', '88', 888, 8888.88, '25-880000', 'recorte', 5, '2025-09-29 14:18:07'),
(11, '099999999999999989999999999999', '999999', '99', 999, 9999.99, '25-990000', '', 3, '2025-09-29 14:22:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `legajo` varchar(20) NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_rol` int(11) DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `username`, `email`, `password`, `first_name`, `last_name`, `legajo`, `department`, `activo`, `created_at`, `updated_at`, `id_rol`) VALUES
(1, 'admin', 'admin@empresa.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'Admin', '001', 'ventas', 0, '2025-09-29 08:35:00', '2025-09-29 11:38:17', 1),
(2, 'nicolas', 'nicolassandoval140692@gmail.com', '$2y$10$.enZGL3iJ1VjvvQGexyROuKpGiRQnWv24a883jewkSyYYdMNQh9My', 'nicolas salomon', 'sandoval', '5099', 'produccion', 1, '2025-09-29 08:37:56', '2025-09-29 09:36:57', 1),
(3, 'produccion', 'produccion@gmail.com', '$2y$10$.enZGL3iJ1VjvvQGexyROuKpGiRQnWv24a883jewkSyYYdMNQh9My', 'produccion', 'produccion', '5000', 'produccion', 1, '2025-09-29 08:37:56', '2025-09-29 09:36:57', 2),
(4, 'antonella', 'antonella@pastorenzi.com', '$2y$10$RdOGOJzjD6/.te7X9sESWed.HV7Iw9l0CcEifMLY8tsKAShwOqs4C', 'antonel', 'pastorenzi', '5044', 'ventas', 1, '2025-09-29 10:51:19', '2025-09-29 10:51:19', 1),
(5, 'jefeproduccion', 'jefe@produccion.com', '$2y$10$oqATMxOReIg4tZLMZ7Yb0eB/Jxr4CVEUejAoKbAoLa4ejds3HVjfq', 'jefe', 'produccion', '100', 'logistica', 1, '2025-09-29 12:57:28', '2025-09-29 14:17:13', 3);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_tarimas_con_legajo`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_tarimas_con_legajo` (
`id_tarima` int(11)
,`numero_tarima` varchar(6)
,`numero_usuario` varchar(2)
,`cantidad_cajas` int(11)
,`peso` decimal(10,2)
,`numero_venta` varchar(10)
,`descripcion` text
,`fecha_registro` timestamp
,`legajo` varchar(20)
,`nombre_usuario` varchar(101)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_tarimas_con_legajo`
--
DROP TABLE IF EXISTS `vista_tarimas_con_legajo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_tarimas_con_legajo`  AS SELECT `t`.`id_tarima` AS `id_tarima`, `t`.`numero_tarima` AS `numero_tarima`, `t`.`numero_usuario` AS `numero_usuario`, `t`.`cantidad_cajas` AS `cantidad_cajas`, `t`.`peso` AS `peso`, `t`.`numero_venta` AS `numero_venta`, `t`.`descripcion` AS `descripcion`, `t`.`fecha_registro` AS `fecha_registro`, `u`.`legajo` AS `legajo`, concat(`u`.`first_name`,' ',`u`.`last_name`) AS `nombre_usuario` FROM (`tarimas` `t` left join `usuarios` `u` on(`t`.`id_usuario` = `u`.`id_usuario`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id_permiso`),
  ADD UNIQUE KEY `nombre_permiso` (`nombre_permiso`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `nombre_rol` (`nombre_rol`);

--
-- Indices de la tabla `roles_permisos`
--
ALTER TABLE `roles_permisos`
  ADD PRIMARY KEY (`id_rol`,`id_permiso`),
  ADD KEY `id_permiso` (`id_permiso`);

--
-- Indices de la tabla `tarimas`
--
ALTER TABLE `tarimas`
  ADD PRIMARY KEY (`id_tarima`),
  ADD KEY `idx_codigo_barras` (`codigo_barras`),
  ADD KEY `idx_numero_tarima` (`numero_tarima`),
  ADD KEY `idx_fecha_registro` (`fecha_registro`),
  ADD KEY `idx_id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tarimas`
--
ALTER TABLE `tarimas`
  MODIFY `id_tarima` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `roles_permisos`
--
ALTER TABLE `roles_permisos`
  ADD CONSTRAINT `roles_permisos_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_permisos_ibfk_2` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id_permiso`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tarimas`
--
ALTER TABLE `tarimas`
  ADD CONSTRAINT `fk_tarima_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
