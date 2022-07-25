-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-04-2022 a las 17:17:47
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `base_final`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egreso`
--

CREATE TABLE `egreso` (
  `codigo` varchar(40) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `receptor` varchar(10) NOT NULL,
  `user` int(11) NOT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egreso_producto`
--

CREATE TABLE `egreso_producto` (
  `codigo_egreso` varchar(40) NOT NULL,
  `codigo_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egreso_producto2`
--

CREATE TABLE `egreso_producto2` (
  `codigo_egreso` varchar(40) NOT NULL,
  `codigo_producto2` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `proname` varchar(30) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` int(11) DEFAULT NULL,
  `medida` varchar(85) DEFAULT NULL,
  `id_proovedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product2`
--

CREATE TABLE `product2` (
  `id` int(11) NOT NULL,
  `proname` varchar(30) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` int(11) DEFAULT NULL,
  `medida` varchar(85) DEFAULT NULL,
  `id_proovedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proovedores`
--

CREATE TABLE `proovedores` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `email` text DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `direccion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receptores`
--

CREATE TABLE `receptores` (
  `cedula` varchar(10) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `apellido` varchar(80) NOT NULL,
  `cargo` varchar(45) DEFAULT NULL,
  `bodega` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `permission` int(11) DEFAULT NULL,
  `asignacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `egreso`
--
ALTER TABLE `egreso`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `Fkreceptor_idx` (`receptor`),
  ADD KEY `Fkuser_idx` (`user`);

--
-- Indices de la tabla `egreso_producto`
--
ALTER TABLE `egreso_producto`
  ADD PRIMARY KEY (`codigo_egreso`,`codigo_producto`),
  ADD KEY `Fkcodigo_producto` (`codigo_producto`);

--
-- Indices de la tabla `egreso_producto2`
--
ALTER TABLE `egreso_producto2`
  ADD PRIMARY KEY (`codigo_egreso`,`codigo_producto2`),
  ADD KEY `Fkcodigo_producto2_idx` (`codigo_producto2`);

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Fkey_id_proovedor_idx` (`id_proovedor`);

--
-- Indices de la tabla `product2`
--
ALTER TABLE `product2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Fk_id_proovedores2_idx` (`id_proovedor`);

--
-- Indices de la tabla `proovedores`
--
ALTER TABLE `proovedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `receptores`
--
ALTER TABLE `receptores`
  ADD PRIMARY KEY (`cedula`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `product2`
--
ALTER TABLE `product2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proovedores`
--
ALTER TABLE `proovedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `egreso`
--
ALTER TABLE `egreso`
  ADD CONSTRAINT `Fkreceptor` FOREIGN KEY (`receptor`) REFERENCES `receptores` (`cedula`),
  ADD CONSTRAINT `Fkuser` FOREIGN KEY (`user`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `egreso_producto`
--
ALTER TABLE `egreso_producto`
  ADD CONSTRAINT `Fkcodigo_egreso` FOREIGN KEY (`codigo_egreso`) REFERENCES `egreso` (`codigo`),
  ADD CONSTRAINT `Fkcodigo_producto` FOREIGN KEY (`codigo_producto`) REFERENCES `product` (`id`);

--
-- Filtros para la tabla `egreso_producto2`
--
ALTER TABLE `egreso_producto2`
  ADD CONSTRAINT `FKcodigo_egreso2` FOREIGN KEY (`codigo_egreso`) REFERENCES `egreso` (`codigo`),
  ADD CONSTRAINT `Fkcodigo_producto2` FOREIGN KEY (`codigo_producto2`) REFERENCES `product2` (`id`);

--
-- Filtros para la tabla `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `Fkey_id_proovedor` FOREIGN KEY (`id_proovedor`) REFERENCES `proovedores` (`id`);

--
-- Filtros para la tabla `product2`
--
ALTER TABLE `product2`
  ADD CONSTRAINT `Fk_id_proovedores2` FOREIGN KEY (`id_proovedor`) REFERENCES `proovedores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
