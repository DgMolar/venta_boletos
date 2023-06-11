-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-06-2023 a las 04:06:10
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

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AsientosDisponiblesViaje` (IN `idViaje` INT)   BEGIN
    DECLARE capacidad INT;
    DECLARE ocupados INT;
    DECLARE disponibles INT;

    -- Obtener la capacidad de asientos
    SELECT capacidad_asientos INTO capacidad
    FROM autobuses
    WHERE id_autobus = (
        SELECT id_autobus
        FROM viajes
        WHERE id_viaje = idViaje
    );

    -- Contar los asientos ocupados
    SELECT COUNT(numero_asiento) INTO ocupados
    FROM boletos
    WHERE id_viaje = idViaje;

    -- Calcular los asientos disponibles
    SET disponibles = capacidad - ocupados;

    -- Obtener los asientos ocupados
    SELECT b.id_viaje, b.numero_asiento, capacidad AS capacidad_asientos
    FROM viajes v
    INNER JOIN boletos b ON b.id_viaje = v.id_viaje
    INNER JOIN autobuses a ON a.id_autobus = v.id_autobus
    WHERE v.id_viaje = idViaje
    GROUP BY b.id_viaje, b.numero_asiento, capacidad_asientos;

    -- Devolver los resultados
    SELECT disponibles AS asientos_disponibles, capacidad AS capacidad_asientos;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `BuscarVentaPorDestino` (`palabra_ciudad` VARCHAR(50))   BEGIN
    SELECT V.id_venta, V.id_cliente, V.fecha_venta, V.total, V.id_metodo_pago, VT.id_viaje, VT.fecha_salida, VT.fecha_llegada, VT.costo, VT.id_autobus
    FROM Ventas V
    INNER JOIN Boletos B ON V.id_venta = B.id_venta
    INNER JOIN Viajes VT ON B.id_viaje = VT.id_viaje
    INNER JOIN Destinos D ON VT.id_destino = D.id_destino
    WHERE D.ciudad LIKE CONCAT('%', palabra_ciudad, '%');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `BuscarViajePorDestino` (`palabra_ciudad` VARCHAR(50))   BEGIN
    SELECT V.id_viaje, V.id_destino, D.nombre, D.direccion, D.ciudad, V.fecha_salida, V.fecha_llegada, V.costo, A.id_autobus, A.placa, A.modelo, A.estado, A.capacidad_asientos
    FROM Viajes V
    INNER JOIN Destinos D ON V.id_destino = D.id_destino
    INNER JOIN Autobuses A ON V.id_autobus = A.id_autobus
    WHERE D.ciudad LIKE CONCAT('%', palabra_ciudad, '%') AND V.estado_viaje = "venta" ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CapacidadBusViaje` (IN `param_idViaje` INT)   BEGIN
  SELECT viajes.id_viaje, autobuses.id_autobus, capacidad_asientos
  FROM venta_boletos.viajes, venta_boletos.autobuses
  WHERE viajes.id_viaje = param_idViaje
    AND autobuses.id_autobus = viajes.id_autobus
    AND estado_viaje = "venta";
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerAsientosOcupados` (IN `idViaje` INT)   BEGIN
    SELECT b.id_viaje, b.numero_asiento, a.capacidad_asientos
    FROM viajes v
    INNER JOIN boletos b ON b.id_viaje = v.id_viaje
    INNER JOIN autobuses a ON a.id_autobus = v.id_autobus
    WHERE v.id_viaje = idViaje
    GROUP BY b.numero_asiento;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerInformacionVentas` (IN `fechaInicioParam` DATE, IN `fechaFinParam` DATE, IN `orderParam` VARCHAR(20))   BEGIN
    SET @query = CONCAT('
    SELECT v.id_venta, b.id_boleto, b.id_viaje, b.numero_asiento, v.total, mp.nombre_metodo, e.correo_empleado, v.fecha_venta
    FROM ventas v
    INNER JOIN boletos b ON v.id_venta = b.id_venta
    INNER JOIN metodospago mp ON v.id_metodo_pago = mp.id_metodo_pago
    INNER JOIN empleados e ON v.id_empleado = e.id_empleado
    WHERE v.fecha_venta BETWEEN ? AND ?');

    IF orderParam = 'id_boleto' THEN
        SET @query = CONCAT(@query, ' ORDER BY b.id_boleto');
    ELSEIF orderParam = 'correo_empleado' THEN
        SET @query = CONCAT(@query, ' ORDER BY e.correo_empleado');
    ELSE
        SET @query = CONCAT(@query, ' ORDER BY v.id_venta');
    END IF;

    PREPARE stmt FROM @query;
    SET @fechaInicioParam = fechaInicioParam;
    SET @fechaFinParam = fechaFinParam;
    EXECUTE stmt USING @fechaInicioParam, @fechaFinParam;
    DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerVentasPorFecha` (`fecha_venta` DATE)   BEGIN
    SELECT V.*, E.*, M.*
    FROM Ventas V
    INNER JOIN Empleados E ON V.id_empleado = E.id_empleado
    INNER JOIN MetodosPago M ON V.id_metodo_pago = M.id_metodo_pago
    WHERE DATE(V.fecha_venta) = fecha_venta;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RealizarVentaConBoleto` (IN `nombre_cliente` VARCHAR(50), IN `apellido_cliente` VARCHAR(50), IN `correo_cliente` VARCHAR(100), IN `telefono_cliente` VARCHAR(20), IN `id_viaje` INT, IN `numero_asiento` INT, IN `id_empleado` INT, IN `total` DECIMAL(7,2), IN `id_metodo_pago` INT)   BEGIN
  DECLARE id_cliente INT;
  DECLARE id_venta INT;

  -- Insertar datos del cliente
  INSERT INTO Clientes (nombre, apellido, correo, telefono)
  VALUES (nombre_cliente, apellido_cliente, correo_cliente, telefono_cliente);

  -- Obtener el último ID insertado del cliente
  SET id_cliente = LAST_INSERT_ID();

  -- Crear la venta
  INSERT INTO Ventas (id_cliente, id_empleado, fecha_venta, total, id_metodo_pago)
  VALUES (id_cliente, id_empleado, CURDATE(), total, id_metodo_pago);

  -- Obtener el último ID insertado de la venta
  SET id_venta = LAST_INSERT_ID();

  -- Crear el boleto
  INSERT INTO Boletos (id_venta, id_viaje, numero_asiento)
  VALUES (id_venta, id_viaje, numero_asiento);

END$$

--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `CalcularTotalVentas` (`fecha_inicio` DATE, `fecha_fin` DATE) RETURNS DECIMAL(10,2)  BEGIN
    DECLARE total_ventas DECIMAL(10, 2);

    SELECT SUM(total) INTO total_ventas
    FROM venta_boletos.ventas
    WHERE fecha_venta >= fecha_inicio AND fecha_venta <= fecha_fin
    ORDER BY total DESC;

    RETURN total_ventas;
END$$

DELIMITER ;

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

--
-- Volcado de datos para la tabla `autobuses`
--

INSERT INTO `autobuses` (`id_autobus`, `placa`, `modelo`, `estado`, `capacidad_asientos`) VALUES
(1, 'PlacaA', 'ModeloA', 'disponible', 40),
(2, 'PlacaB', 'ModeloB', 'ocupado', 50),
(3, 'PlacaC', 'ModeloC', 'disponible', 40),
(4, 'HRU846', 'Magno', 'disponible', 40),
(5, 'JGUE43', 'Magno', 'ocupado', 48),
(6, 'JNFIK245', 'Zafiro', 'disponible', 40),
(7, 'JFHYWB4', 'Boxer', 'disponible', 52);

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

--
-- Volcado de datos para la tabla `boletos`
--

INSERT INTO `boletos` (`id_boleto`, `id_venta`, `id_viaje`, `numero_asiento`) VALUES
(1, 1, 1, 4),
(2, 2, 1, 12),
(3, 3, 1, 5),
(4, 4, 1, 32),
(5, 5, 4, 4),
(6, 6, 4, 5),
(7, 7, 3, 22),
(8, 8, 3, 9),
(9, 9, 3, 39),
(10, 10, 4, 50);

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

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `apellido`, `correo`, `telefono`) VALUES
(1, 'ClienteA', 'ApelidoA', 'ClienteA@gmail.com', '1234567890'),
(2, 'ClienteB', 'ApellidoB', 'ClienteB@gmail.com', '0987654321'),
(3, 'ClienteC', 'ApellidoC', 'ClienteC@gmail.com', '7463528573'),
(4, 'ClienteD', 'ApellidoD', 'ClienteD@gmail.com', '8462548376'),
(5, 'ClienteE', 'apellidoE', 'ClienteE@gmail.com', '7563856362'),
(6, 'Diego', 'Molar', 'dgmol@gmail.com', '12337264'),
(7, 'peronsa1', 'cruz', 'deifheu@gmail.com', '8463524475832'),
(8, 'Eduardo', 'Gonzales Mata', 'gon@gmail.com', '9726384736'),
(9, 'Diego', 'Molar', 'diego.molardlcr@uanl.edu.mx', '1234567890'),
(10, 'Emmanuel', 'Lopez', 'emmalop@gmail.com', '7653427482'),
(11, 'Maria', 'Ramirez del angel', 'mariangel23@gmail.com', '7654364728');

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

--
-- Volcado de datos para la tabla `destinos`
--

INSERT INTO `destinos` (`id_destino`, `nombre`, `direccion`, `ciudad`) VALUES
(1, 'Destino A', 'Direccion A', 'Ciudad A'),
(2, 'Destino B', 'Direccion B', 'Ciudad B'),
(3, 'DestinoC', 'DireccionC', 'CiudadC'),
(4, 'DestinoD', 'DireccionD', 'CiudadD'),
(5, 'Destino E', 'Direccion E', 'Ciudad E'),
(6, 'Destino F', 'Destino F', 'Ciudad F');

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

--
-- Volcado de datos para la tabla `metodospago`
--

INSERT INTO `metodospago` (`id_metodo_pago`, `nombre_metodo`) VALUES
(1, 'efectivo'),
(2, 'tarjeta credito'),
(3, 'tarjeta debito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puestos`
--

CREATE TABLE `puestos` (
  `id_puesto` int(11) NOT NULL,
  `nombre_puesto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `puestos`
--

INSERT INTO `puestos` (`id_puesto`, `nombre_puesto`) VALUES
(1, 'Gerente'),
(2, 'Vendedor');

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

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `id_cliente`, `id_empleado`, `fecha_venta`, `total`, `id_metodo_pago`) VALUES
(1, 2, 1, '2023-06-03', 0.00, 1),
(2, 3, 1, '2023-06-03', 1200.00, 1),
(3, 4, 1, '2023-06-03', 1430.00, 2),
(4, 5, 1, '2023-06-03', 1200.00, 1),
(5, 6, 1, '2023-06-07', 1100.00, 1),
(6, 7, 1, '2023-06-07', 1100.00, 2),
(7, 8, 1, '2023-06-08', 1500.00, 2),
(8, 9, 1, '2023-06-08', 1566.00, 1),
(9, 10, 1, '2023-06-08', 2000.00, 3),
(10, 11, 1, '2023-06-08', 1100.00, 3);

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
-- Volcado de datos para la tabla `viajes`
--

INSERT INTO `viajes` (`id_viaje`, `id_destino`, `fecha_salida`, `fecha_llegada`, `estado_viaje`, `costo`, `id_autobus`) VALUES
(1, 1, '2023-06-04 00:06:25', '2023-06-06 02:00:00', 'finalizado', 1200.00, 3),
(2, 2, '2023-06-04 00:06:57', '2023-07-05 08:30:00', 'finalizado', 1020.50, 1),
(3, 3, '2023-06-04 07:11:30', '2023-06-04 08:11:30', 'finalizado', 1500.00, 3),
(4, 4, '2023-06-09 22:17:01', '2023-06-07 05:38:17', 'venta', 1100.00, 2),
(13, 5, '2023-06-09 22:08:31', '2023-06-10 20:57:00', 'venta', 1460.00, 5);

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
  MODIFY `id_autobus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `boletos`
--
ALTER TABLE `boletos`
  MODIFY `id_boleto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `destinos`
--
ALTER TABLE `destinos`
  MODIFY `id_destino` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `metodospago`
--
ALTER TABLE `metodospago`
  MODIFY `id_metodo_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `puestos`
--
ALTER TABLE `puestos`
  MODIFY `id_puesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `viajes`
--
ALTER TABLE `viajes`
  MODIFY `id_viaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
