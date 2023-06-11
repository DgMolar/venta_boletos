-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-06-2023 a las 04:05:38
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `venta_boletos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id_administrador` int(11) NOT NULL,
  `nombre_admin` varchar(45) NOT NULL,
  `apellido_admin` varchar(45) NOT NULL,
  `correo_admin` varchar(45) NOT NULL,
  `password_admin` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id_administrador`, `nombre_admin`, `apellido_admin`, `correo_admin`, `password_admin`) VALUES
(1, 'Diego', 'Molar', 'dgmolar@admin.com', 'abc123'),
(2, 'Fatima', 'Gonzales', 'fatima20@gmail.com', 'fatadmin20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autobuses`
--

CREATE TABLE `autobuses` (
  `id_autobus` int(11) NOT NULL,
  `placa` varchar(20) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `capacidad_asientos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boletos`
--

CREATE TABLE `boletos` (
  `id_boleto` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_viaje` int(11) NOT NULL,
  `numero_asiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destinos`
--

CREATE TABLE `destinos` (
  `id_destino` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `ciudad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `nombre_empleado` varchar(50) NOT NULL,
  `apellido_empleado` varchar(50) NOT NULL,
  `correo_empleado` varchar(100) NOT NULL,
  `contrasena_empleado` varchar(45) NOT NULL,
  `id_puesto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `nombre_empleado`, `apellido_empleado`, `correo_empleado`, `contrasena_empleado`, `id_puesto`) VALUES
(1, 'EmpleadoA', 'ApellidoA', 'EmpleadoA@gmail.com', '12345', 2),
(3, 'Fatima', 'Gonzales', 'fatima20@gmail.com', 'fat2023', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodospago`
--

CREATE TABLE `metodospago` (
  `id_metodo_pago` int(11) NOT NULL,
  `nombre_metodo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puestos`
--

CREATE TABLE `puestos` (
  `id_puesto` int(11) NOT NULL,
  `nombre_puesto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `fecha_venta` date NOT NULL,
  `total` decimal(7,2) NOT NULL,
  `id_metodo_pago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viajes`
--

CREATE TABLE `viajes` (
  `id_viaje` int(11) NOT NULL,
  `id_destino` int(11) NOT NULL,
  `fecha_salida` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_llegada` timestamp NULL DEFAULT NULL,
  `estado_viaje` varchar(45) NOT NULL DEFAULT 'venta',
  `costo` decimal(7,2) NOT NULL,
  `id_autobus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Disparadores `viajes`
--
DELIMITER $$
CREATE TRIGGER `EstadoAutobusDelete` AFTER DELETE ON `viajes` FOR EACH ROW BEGIN
    UPDATE venta_boletos.autobuses SET estado = 'disponible' WHERE id_autobus = OLD.id_autobus;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `EstadoAutobusInsert` AFTER INSERT ON `viajes` FOR EACH ROW BEGIN
    UPDATE venta_boletos.autobuses SET estado = 'ocupado' WHERE id_autobus = NEW.id_autobus;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `EstadoAutobusUpdate` AFTER UPDATE ON `viajes` FOR EACH ROW BEGIN
    IF NEW.id_autobus <> OLD.id_autobus THEN
        UPDATE Autobuses SET estado = 'disponible' WHERE id_autobus = OLD.id_autobus;
        UPDATE Autobuses SET estado = 'ocupado' WHERE id_autobus = NEW.id_autobus;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `EstadoAutobusViaje` AFTER UPDATE ON `viajes` FOR EACH ROW BEGIN
    IF NEW.estado_viaje = 'finalizado' AND OLD.estado_viaje <> 'finalizado' THEN
        UPDATE Autobuses SET estado = 'disponible' WHERE id_autobus = NEW.id_autobus;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_boletos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_boletos` (
`id_boleto` int(11)
,`id_viaje` int(11)
,`nombre` varchar(50)
,`apellido` varchar(50)
,`fecha_salida` timestamp
,`destino` varchar(50)
,`numero_asiento` int(11)
,`costo` decimal(7,2)
,`nombre_empleado` varchar(50)
,`placa` varchar(20)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_viajes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_viajes` (
`id_viaje` int(11)
,`id_destino` int(11)
,`nombre` varchar(50)
,`direccion` varchar(100)
,`ciudad` varchar(50)
,`fecha_salida` timestamp
,`fecha_llegada` timestamp
,`estado_viaje` varchar(45)
,`costo` decimal(7,2)
,`id_autobus` int(11)
,`placa` varchar(20)
,`modelo` varchar(50)
,`estado_autobus` varchar(45)
,`capacidad_asientos` int(11)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_boletos`
--
DROP TABLE IF EXISTS `vista_boletos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_boletos`  AS SELECT `b`.`id_boleto` AS `id_boleto`, `vj`.`id_viaje` AS `id_viaje`, `c`.`nombre` AS `nombre`, `c`.`apellido` AS `apellido`, `vj`.`fecha_salida` AS `fecha_salida`, `d`.`nombre` AS `destino`, `b`.`numero_asiento` AS `numero_asiento`, `vj`.`costo` AS `costo`, `emp`.`nombre_empleado` AS `nombre_empleado`, `a`.`placa` AS `placa` FROM ((((((`boletos` `b` join `ventas` `v` on(`b`.`id_venta` = `v`.`id_venta`)) join `clientes` `c` on(`v`.`id_cliente` = `c`.`id_cliente`)) join `viajes` `vj` on(`b`.`id_viaje` = `vj`.`id_viaje`)) join `destinos` `d` on(`vj`.`id_destino` = `d`.`id_destino`)) join `empleados` `emp` on(`v`.`id_empleado` = `emp`.`id_empleado`)) join `autobuses` `a` on(`vj`.`id_autobus` = `a`.`id_autobus`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_viajes`
--
DROP TABLE IF EXISTS `vista_viajes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_viajes`  AS SELECT `v`.`id_viaje` AS `id_viaje`, `v`.`id_destino` AS `id_destino`, `d`.`nombre` AS `nombre`, `d`.`direccion` AS `direccion`, `d`.`ciudad` AS `ciudad`, `v`.`fecha_salida` AS `fecha_salida`, `v`.`fecha_llegada` AS `fecha_llegada`, `v`.`estado_viaje` AS `estado_viaje`, `v`.`costo` AS `costo`, `v`.`id_autobus` AS `id_autobus`, `a`.`placa` AS `placa`, `a`.`modelo` AS `modelo`, `a`.`estado` AS `estado_autobus`, `a`.`capacidad_asientos` AS `capacidad_asientos` FROM ((`viajes` `v` join `autobuses` `a` on(`v`.`id_autobus` = `a`.`id_autobus`)) join `destinos` `d` on(`v`.`id_destino` = `d`.`id_destino`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id_administrador`);

--
-- Indices de la tabla `autobuses`
--
ALTER TABLE `autobuses`
  ADD PRIMARY KEY (`id_autobus`);

--
-- Indices de la tabla `boletos`
--
ALTER TABLE `boletos`
  ADD PRIMARY KEY (`id_boleto`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_viaje` (`id_viaje`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `destinos`
--
ALTER TABLE `destinos`
  ADD PRIMARY KEY (`id_destino`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD KEY `id_puesto` (`id_puesto`);

--
-- Indices de la tabla `metodospago`
--
ALTER TABLE `metodospago`
  ADD PRIMARY KEY (`id_metodo_pago`);

--
-- Indices de la tabla `puestos`
--
ALTER TABLE `puestos`
  ADD PRIMARY KEY (`id_puesto`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_empleado` (`id_empleado`),
  ADD KEY `id_metodo_pago` (`id_metodo_pago`);

--
-- Indices de la tabla `viajes`
--
ALTER TABLE `viajes`
  ADD PRIMARY KEY (`id_viaje`),
  ADD KEY `id_destino` (`id_destino`),
  ADD KEY `id_autobus` (`id_autobus`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id_administrador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `autobuses`
--
ALTER TABLE `autobuses`
  MODIFY `id_autobus` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `boletos`
--
ALTER TABLE `boletos`
  MODIFY `id_boleto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `destinos`
--
ALTER TABLE `destinos`
  MODIFY `id_destino` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `metodospago`
--
ALTER TABLE `metodospago`
  MODIFY `id_metodo_pago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `puestos`
--
ALTER TABLE `puestos`
  MODIFY `id_puesto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `viajes`
--
ALTER TABLE `viajes`
  MODIFY `id_viaje` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `boletos`
--
ALTER TABLE `boletos`
  ADD CONSTRAINT `boletos_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`),
  ADD CONSTRAINT `boletos_ibfk_2` FOREIGN KEY (`id_viaje`) REFERENCES `viajes` (`id_viaje`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`id_puesto`) REFERENCES `puestos` (`id_puesto`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`),
  ADD CONSTRAINT `ventas_ibfk_3` FOREIGN KEY (`id_metodo_pago`) REFERENCES `metodospago` (`id_metodo_pago`);

--
-- Filtros para la tabla `viajes`
--
ALTER TABLE `viajes`
  ADD CONSTRAINT `viajes_ibfk_1` FOREIGN KEY (`id_destino`) REFERENCES `destinos` (`id_destino`),
  ADD CONSTRAINT `viajes_ibfk_2` FOREIGN KEY (`id_autobus`) REFERENCES `autobuses` (`id_autobus`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
