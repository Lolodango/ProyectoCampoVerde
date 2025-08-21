-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 21-08-2025 a las 10:31:57
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyectoresidencial`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_comunicado_sp` (IN `p_id_comunicado` INT, IN `p_titulo` VARCHAR(100), IN `p_contenido` VARCHAR(300), IN `p_fecha_publicacion` DATE, IN `p_cedula` INT, IN `p_id_estado` INT)   BEGIN
    UPDATE Comunicados
    SET titulo = p_titulo,
        contenido = p_contenido,
        fecha_publicacion = p_fecha_publicacion,
        cedula = p_cedula,
        id_estado = p_id_estado
    WHERE id_comunicado = p_id_comunicado;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_estado_sp` (IN `p_id_estado` INT, IN `p_estado` VARCHAR(50))   BEGIN
    UPDATE Estados SET estado = p_estado WHERE id_estado = p_id_estado;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_mantenimiento_sp` (IN `p_id_mantenimiento` INT, IN `p_mes` VARCHAR(20), IN `p_año` INT, IN `p_descripcion` VARCHAR(300), IN `p_monto` DECIMAL(10,2), IN `p_fecha_vencimiento` DATE, IN `p_cedula` INT, IN `p_id_estado` INT)   BEGIN
    UPDATE Mantenimientos
    SET mes = p_mes,
        año = p_año,
        descripcion = p_descripcion,
        monto = p_monto,
        fecha_vencimiento = p_fecha_vencimiento,
        cedula = p_cedula,
        id_estado = p_id_estado
    WHERE id_mantenimiento = p_id_mantenimiento;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_metodopago_sp` (IN `p_id_metodo_pago` INT, IN `p_metodo_pago` VARCHAR(50), IN `p_id_estado` INT)   BEGIN
    UPDATE MetodoPago
    SET metodo_pago = p_metodo_pago,
        id_estado = p_id_estado
    WHERE id_metodo_pago = p_id_metodo_pago;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_notificacion_sp` (IN `p_id_notificacion` INT, IN `p_mensaje` VARCHAR(300), IN `p_tipo` VARCHAR(50), IN `p_fecha_envio` TIMESTAMP, IN `p_cedula` INT, IN `p_id_pago` INT, IN `p_id_estado` INT)   BEGIN
    UPDATE Notificaciones
    SET mensaje = p_mensaje,
        tipo = p_tipo,
        fecha_envio = p_fecha_envio,
        cedula = p_cedula,
        id_pago = p_id_pago,
        id_estado = p_id_estado
    WHERE id_notificacion = p_id_notificacion;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_pago_sp` (IN `p_id_pago` INT, IN `p_fecha_pago` TIMESTAMP, IN `p_monto_total` DECIMAL(10,2), IN `p_cedula` INT, IN `p_id_mantenimiento` INT, IN `p_id_estado` INT)   BEGIN
    UPDATE Pago
    SET fecha_pago = p_fecha_pago,
        monto_total = p_monto_total,
        cedula = p_cedula,
        id_mantenimiento = p_id_mantenimiento,
        id_estado = p_id_estado
    WHERE id_pago = p_id_pago;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_queja_sp` (IN `p_id_queja` INT, IN `p_titulo` VARCHAR(100), IN `p_descripcion` VARCHAR(300), IN `p_fecha` TIMESTAMP, IN `p_cedula` INT, IN `p_id_estado` INT)   BEGIN
    UPDATE Quejas
    SET titulo = p_titulo,
        descripcion = p_descripcion,
        fecha = p_fecha,
        cedula = p_cedula,
        id_estado = p_id_estado
    WHERE id_queja = p_id_queja;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_reporte_sp` (IN `p_id_reporte` INT, IN `p_titulo` VARCHAR(100), IN `p_descripcion` VARCHAR(300), IN `p_fecha` TIMESTAMP, IN `p_cedula` INT, IN `p_id_estado` INT)   BEGIN
    UPDATE Reportes
    SET titulo = p_titulo,
        descripcion = p_descripcion,
        fecha = p_fecha,
        cedula = p_cedula,
        id_estado = p_id_estado
    WHERE id_reporte = p_id_reporte;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_rol_sp` (IN `p_id_rol` INT, IN `p_nombre_rol` VARCHAR(50), IN `p_id_estado` INT)   BEGIN
    UPDATE Rol SET nombre_rol = p_nombre_rol, id_estado = p_id_estado WHERE id_rol = p_id_rol;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_usuario_sp` (IN `p_cedula` INT, IN `p_nombre` VARCHAR(50), IN `p_primer_apellido` VARCHAR(50), IN `p_segundo_apellido` VARCHAR(50), IN `p_nombre_usuario` VARCHAR(50), IN `p_contrasena` VARCHAR(100), IN `p_correo` VARCHAR(100), IN `p_fecha_nacimiento` DATE, IN `p_id_rol` INT, IN `p_id_estado` INT)   BEGIN
    UPDATE Usuarios
    SET nombre = p_nombre,
        primer_apellido = p_primer_apellido,
        segundo_apellido = p_segundo_apellido,
        nombre_usuario = p_nombre_usuario,
        contrasena = p_contrasena,
        correo = p_correo,
        fecha_nacimiento = p_fecha_nacimiento,
        id_rol = p_id_rol,
        id_estado = p_id_estado
    WHERE cedula = p_cedula;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminar_comunicado_sp` (IN `p_id_comunicado` INT)   BEGIN
    UPDATE Comunicados SET id_estado = 2 WHERE id_comunicado = p_id_comunicado; -- Eliminación lógica
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminar_estado_sp` (IN `p_id_estado` INT)   BEGIN
    -- Ejemplo: no se elimina físicamente, solo se podría marcar inactivo o impedir eliminación
    DELETE FROM Estados WHERE id_estado = p_id_estado;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminar_mantenimiento_sp` (IN `p_id_mantenimiento` INT)   BEGIN
    UPDATE Mantenimientos SET id_estado = 2 WHERE id_mantenimiento = p_id_mantenimiento; -- Eliminación lógica
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminar_metodopago_sp` (IN `p_id_metodo_pago` INT)   BEGIN
    UPDATE MetodoPago SET id_estado = 2 WHERE id_metodo_pago = p_id_metodo_pago; -- Eliminación lógica
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminar_notificacion_sp` (IN `p_id_notificacion` INT)   BEGIN
    UPDATE Notificaciones SET id_estado = 2 WHERE id_notificacion = p_id_notificacion; -- Eliminación lógica
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminar_pago_sp` (IN `p_id_pago` INT)   BEGIN
    UPDATE Pago SET id_estado = 2 WHERE id_pago = p_id_pago; -- Eliminación lógica
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminar_queja_sp` (IN `p_id_queja` INT)   BEGIN
    UPDATE Quejas SET id_estado = 2 WHERE id_queja = p_id_queja; -- Eliminación lógica
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminar_reporte_sp` (IN `p_id_reporte` INT)   BEGIN
    UPDATE Reportes SET id_estado = 2 WHERE id_reporte = p_id_reporte; -- Eliminación lógica
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminar_rol_sp` (IN `p_id_rol` INT)   BEGIN
    UPDATE Rol SET id_estado = 2 WHERE id_rol = p_id_rol; -- Eliminación lógica
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminar_usuario_sp` (IN `p_cedula` INT)   BEGIN
    UPDATE Usuarios SET id_estado = 2 WHERE cedula = p_cedula; -- Eliminación lógica
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_comunicado_sp` (IN `p_titulo` VARCHAR(100), IN `p_contenido` VARCHAR(300), IN `p_fecha_publicacion` DATE, IN `p_cedula` INT)   BEGIN
    INSERT INTO Comunicados (titulo, contenido, fecha_publicacion, cedula)
    VALUES (p_titulo, p_contenido, p_fecha_publicacion, p_cedula);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_estado_sp` (IN `p_estado` VARCHAR(50))   BEGIN
    INSERT INTO Estados (estado) VALUES (p_estado);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_mantenimiento_sp` (IN `p_mes` VARCHAR(20), IN `p_año` INT, IN `p_descripcion` VARCHAR(300), IN `p_monto` DECIMAL(10,2), IN `p_fecha_vencimiento` DATE, IN `p_cedula` INT)   BEGIN
    INSERT INTO Mantenimientos (
        mes, año, descripcion, monto, fecha_vencimiento, cedula
    )
    VALUES (
        p_mes, p_año, p_descripcion, p_monto, p_fecha_vencimiento, p_cedula
    );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_metodopago_sp` (IN `p_metodo_pago` VARCHAR(50))   BEGIN
    INSERT INTO MetodoPago (metodo_pago)
    VALUES (p_metodo_pago);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_notificacion_sp` (IN `p_mensaje` VARCHAR(300), IN `p_tipo` VARCHAR(50), IN `p_fecha_envio` TIMESTAMP, IN `p_cedula` INT, IN `p_id_pago` INT)   BEGIN
    INSERT INTO Notificaciones (mensaje, tipo, fecha_envio, cedula, id_pago)
    VALUES (p_mensaje, p_tipo, p_fecha_envio, p_cedula, p_id_pago);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_pago_sp` (IN `p_fecha_pago` TIMESTAMP, IN `p_monto_total` DECIMAL(10,2), IN `p_cedula` INT, IN `p_id_mantenimiento` INT)   BEGIN
    INSERT INTO Pago (fecha_pago, monto_total, cedula, id_mantenimiento)
    VALUES (p_fecha_pago, p_monto_total, p_cedula, p_id_mantenimiento);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_queja_sp` (IN `p_titulo` VARCHAR(100), IN `p_descripcion` VARCHAR(300), IN `p_fecha` TIMESTAMP, IN `p_cedula` INT)   BEGIN
    INSERT INTO Quejas (titulo, descripcion, fecha, cedula)
    VALUES (p_titulo, p_descripcion, p_fecha, p_cedula);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_reporte_sp` (IN `p_titulo` VARCHAR(100), IN `p_descripcion` VARCHAR(300), IN `p_fecha` TIMESTAMP, IN `p_cedula` INT)   BEGIN
    INSERT INTO Reportes (titulo, descripcion, fecha, cedula)
    VALUES (p_titulo, p_descripcion, p_fecha, p_cedula);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_rol_sp` (IN `p_nombre_rol` VARCHAR(50))   BEGIN
    INSERT INTO Rol (nombre_rol) VALUES (p_nombre_rol);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_usuario_sp` (IN `p_cedula` INT, IN `p_nombre` VARCHAR(50), IN `p_primer_apellido` VARCHAR(50), IN `p_segundo_apellido` VARCHAR(50), IN `p_nombre_usuario` VARCHAR(50), IN `p_contrasena` VARCHAR(100), IN `p_correo` VARCHAR(100), IN `p_fecha_nacimiento` DATE, IN `p_id_rol` INT)   BEGIN
    INSERT INTO Usuarios (
        cedula, nombre, primer_apellido, segundo_apellido,
        nombre_usuario, contrasena, correo, fecha_nacimiento,
        id_rol
    )
    VALUES (
        p_cedula, p_nombre, p_primer_apellido, p_segundo_apellido,
        p_nombre_usuario, p_contrasena, p_correo, p_fecha_nacimiento,
        p_id_rol
    );
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comunicados`
--

CREATE TABLE `comunicados` (
  `id_comunicado` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `contenido` varchar(300) DEFAULT NULL,
  `fecha_publicacion` date DEFAULT NULL,
  `cedula` int(11) DEFAULT NULL,
  `id_estado` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comunicados`
--

INSERT INTO `comunicados` (`id_comunicado`, `titulo`, `contenido`, `fecha_publicacion`, `cedula`, `id_estado`) VALUES
(1, 'Corte de agua', 'Habrá un corte de agua el lunes.', '2025-07-25', 101010101, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id_estado` int(11) NOT NULL,
  `estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id_estado`, `estado`) VALUES
(1, 'Activo'),
(2, 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimientos`
--

CREATE TABLE `mantenimientos` (
  `id_mantenimiento` int(11) NOT NULL,
  `mes` varchar(20) DEFAULT NULL,
  `año` int(11) DEFAULT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `cedula` int(11) DEFAULT NULL,
  `id_estado` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mantenimientos`
--

INSERT INTO `mantenimientos` (`id_mantenimiento`, `mes`, `año`, `descripcion`, `monto`, `fecha_vencimiento`, `cedula`, `id_estado`) VALUES
(1, 'Julio', 2025, 'Mantenimiento mensual general', 50000.00, '2025-07-31', 101010101, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodopago`
--

CREATE TABLE `metodopago` (
  `id_metodo_pago` int(11) NOT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `id_estado` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metodopago`
--

INSERT INTO `metodopago` (`id_metodo_pago`, `metodo_pago`, `id_estado`) VALUES
(1, 'Transferencia Bancaria', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id_notificacion` int(11) NOT NULL,
  `mensaje` varchar(300) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cedula` int(11) DEFAULT NULL,
  `id_pago` int(11) DEFAULT NULL,
  `id_estado` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id_notificacion`, `mensaje`, `tipo`, `fecha_envio`, `cedula`, `id_pago`, `id_estado`) VALUES
(1, 'Pago recibido', 'Pago', '2025-08-20 07:22:57', 101010101, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id_pago` int(11) NOT NULL,
  `fecha_pago` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `monto_total` decimal(10,2) DEFAULT NULL,
  `cedula` int(11) DEFAULT NULL,
  `id_mantenimiento` int(11) DEFAULT NULL,
  `id_estado` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`id_pago`, `fecha_pago`, `monto_total`, `cedula`, `id_mantenimiento`, `id_estado`) VALUES
(1, '2025-08-20 07:22:57', 50000.00, 101010101, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `quejas`
--

CREATE TABLE `quejas` (
  `id_queja` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` enum('pendiente','en_revision','resuelta') NOT NULL DEFAULT 'pendiente',
  `numero_casa` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `quejas`
--

INSERT INTO `quejas` (`id_queja`, `titulo`, `descripcion`, `fecha`, `estado`, `numero_casa`) VALUES
(1, 'Basura acumulada', 'Hay basura en la entrada del edificio', '2025-08-21 06:59:54', 'pendiente', 'TEMP-101010101'),
(2, 'Vecinos Gritando en la manana', 'Prueba De queja numero 1', '2025-08-21 08:25:46', 'en_revision', 'TEMP-202020202');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `id_reporte` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cedula` int(11) DEFAULT NULL,
  `id_estado` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reportes`
--

INSERT INTO `reportes` (`id_reporte`, `titulo`, `descripcion`, `fecha`, `cedula`, `id_estado`) VALUES
(1, 'Fuga de agua', 'Se reporta fuga en el segundo piso', '2025-08-20 07:22:57', 202020202, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) DEFAULT NULL,
  `id_estado` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre_rol`, `id_estado`) VALUES
(1, 'Administrador', 1),
(2, 'Cliente', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `cedula` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `primer_apellido` varchar(50) DEFAULT NULL,
  `segundo_apellido` varchar(50) DEFAULT NULL,
  `nombre_usuario` varchar(50) DEFAULT NULL,
  `contrasena` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_rol` int(11) DEFAULT NULL,
  `id_estado` int(11) DEFAULT 1,
  `numero_casa` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`cedula`, `nombre`, `primer_apellido`, `segundo_apellido`, `nombre_usuario`, `contrasena`, `correo`, `fecha_nacimiento`, `fecha_registro`, `id_rol`, `id_estado`, `numero_casa`) VALUES
(101010101, 'Carlos', 'Ramírez', 'González', 'carlosrg', '$2y$10$JCnHYFiuTJHsdSgrwmlZUuSrF/rT7t5dRiNaFov3E2jNUvGwkntTu', 'carlos.rg@email.com', '1995-04-23', '2025-08-20 07:22:57', 1, 1, 'TEMP-101010101'),
(202020202, 'María', 'Fernández', 'Solano', 'mfernandez', '$2y$10$d7SsMHWYOvtl1LpdG.vg0eUh9rSfKV60IN2.RJ8qSlzFqy9DKiveW', 'maria.f@email.com', '1998-10-12', '2025-08-20 07:22:57', 2, 1, 'TEMP-202020202'),
(303030303, 'Luis', 'Mora', 'Alfaro', 'lmora', '$2y$10$yXQuuyZm/9bSZJIjt346Ze5zHCbWHoKymAn6qw3kgmBhwW3VzPbp6', 'luis.mora@email.com', '2000-01-01', '2025-08-20 07:22:57', 2, 1, 'TEMP-303030303'),
(404040404, 'Ana', 'Sánchez', 'Vargas', 'anasv', '$2y$10$L1hJHuZzWvAqCPVL4WSBv.WkVDQOE8Nzlz0YaJfbuCvGMvgnFuwky', 'ana.sv@email.com', '1992-07-15', '2025-08-20 07:22:57', 1, 1, 'TEMP-404040404');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comunicados`
--
ALTER TABLE `comunicados`
  ADD PRIMARY KEY (`id_comunicado`),
  ADD KEY `fk_comunicados_cedula` (`cedula`),
  ADD KEY `fk_comunicados_estado` (`id_estado`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  ADD PRIMARY KEY (`id_mantenimiento`),
  ADD KEY `fk_mantenimientos_cedula` (`cedula`),
  ADD KEY `fk_mantenimientos_estado` (`id_estado`);

--
-- Indices de la tabla `metodopago`
--
ALTER TABLE `metodopago`
  ADD PRIMARY KEY (`id_metodo_pago`),
  ADD KEY `fk_metodopago_estado` (`id_estado`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `fk_notificaciones_cedula` (`cedula`),
  ADD KEY `fk_notificaciones_pago` (`id_pago`),
  ADD KEY `fk_notificaciones_estado` (`id_estado`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `fk_pago_cedula` (`cedula`),
  ADD KEY `fk_pago_mantenimiento` (`id_mantenimiento`),
  ADD KEY `fk_pago_estado` (`id_estado`);

--
-- Indices de la tabla `quejas`
--
ALTER TABLE `quejas`
  ADD PRIMARY KEY (`id_queja`),
  ADD KEY `fk_quejas_usuario_casa` (`numero_casa`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`id_reporte`),
  ADD KEY `fk_reportes_cedula` (`cedula`),
  ADD KEY `fk_reportes_estado` (`id_estado`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`),
  ADD KEY `fk_rol_estado` (`id_estado`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cedula`),
  ADD UNIQUE KEY `uq_usuarios_numero_casa` (`numero_casa`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD UNIQUE KEY `contrasena` (`contrasena`),
  ADD KEY `fk_usuarios_rol` (`id_rol`),
  ADD KEY `fk_usuarios_estado` (`id_estado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comunicados`
--
ALTER TABLE `comunicados`
  MODIFY `id_comunicado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  MODIFY `id_mantenimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `metodopago`
--
ALTER TABLE `metodopago`
  MODIFY `id_metodo_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `quejas`
--
ALTER TABLE `quejas`
  MODIFY `id_queja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comunicados`
--
ALTER TABLE `comunicados`
  ADD CONSTRAINT `fk_comunicados_cedula` FOREIGN KEY (`cedula`) REFERENCES `usuarios` (`cedula`),
  ADD CONSTRAINT `fk_comunicados_estado` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`);

--
-- Filtros para la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  ADD CONSTRAINT `fk_mantenimientos_cedula` FOREIGN KEY (`cedula`) REFERENCES `usuarios` (`cedula`),
  ADD CONSTRAINT `fk_mantenimientos_estado` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`);

--
-- Filtros para la tabla `metodopago`
--
ALTER TABLE `metodopago`
  ADD CONSTRAINT `fk_metodopago_estado` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`);

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `fk_notificaciones_cedula` FOREIGN KEY (`cedula`) REFERENCES `usuarios` (`cedula`),
  ADD CONSTRAINT `fk_notificaciones_estado` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `fk_notificaciones_pago` FOREIGN KEY (`id_pago`) REFERENCES `pago` (`id_pago`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `fk_pago_cedula` FOREIGN KEY (`cedula`) REFERENCES `usuarios` (`cedula`),
  ADD CONSTRAINT `fk_pago_estado` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `fk_pago_mantenimiento` FOREIGN KEY (`id_mantenimiento`) REFERENCES `mantenimientos` (`id_mantenimiento`);

--
-- Filtros para la tabla `quejas`
--
ALTER TABLE `quejas`
  ADD CONSTRAINT `fk_quejas_usuario_casa` FOREIGN KEY (`numero_casa`) REFERENCES `usuarios` (`numero_casa`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD CONSTRAINT `fk_reportes_cedula` FOREIGN KEY (`cedula`) REFERENCES `usuarios` (`cedula`),
  ADD CONSTRAINT `fk_reportes_estado` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`);

--
-- Filtros para la tabla `rol`
--
ALTER TABLE `rol`
  ADD CONSTRAINT `fk_rol_estado` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_estado` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `fk_usuarios_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
