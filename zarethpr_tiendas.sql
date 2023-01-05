-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 04-01-2023 a las 11:43:16
-- Versión del servidor: 10.3.37-MariaDB
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `zarethpr_tiendas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'id del cliente',
  `nombres` varchar(191) NOT NULL COMMENT 'nombre del cliente',
  `apellidos` varchar(191) NOT NULL COMMENT 'apellidos del cliente',
  `documento` varchar(191) NOT NULL COMMENT 'numero de documento del cliente',
  `cargo` varchar(150) DEFAULT NULL,
  `direccion` varchar(191) NOT NULL COMMENT 'dirección del cliente',
  `telefono` varchar(191) NOT NULL COMMENT 'telefono del cliente',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'fecha donde se creo la fila',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'fecha de actualizacion de la fila',
  `fecha_nacimiento` date NOT NULL COMMENT 'fecha de nacimiento del cliente',
  `correo` varchar(191) DEFAULT NULL COMMENT 'correo del cliente',
  `id_zona` int(11) UNSIGNED DEFAULT NULL COMMENT 'id de la zona del cliente',
  `id_tienda` int(11) UNSIGNED DEFAULT NULL COMMENT 'id de la tienda a la que pertence el cliente',
  `configuraciones` int(10) UNSIGNED DEFAULT NULL COMMENT '1 es minorista y 2 es mayorista',
  `puntos` int(10) NOT NULL DEFAULT 0 COMMENT 'puntos que almacenan los clientes',
  `aplica_libranza` int(10) UNSIGNED DEFAULT 1,
  `monto_libranza` double(16,0) DEFAULT 150000,
  `cupo` double(16,0) DEFAULT 150000,
  `porcentaje_descuento` double(16,2) DEFAULT NULL,
  `entidad` int(11) UNSIGNED DEFAULT 2,
  `estado_empresa` int(11) NOT NULL DEFAULT 2 COMMENT '1:Activo(es Empleado) 2:Inactivo(No es empleado)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zonas_id_zona_foreign` (`id_zona`),
  ADD KEY `clientes_configuraciones_foreign` (`configuraciones`),
  ADD KEY `clientes_id_tienda_foreign` (`id_tienda`),
  ADD KEY `aplica_libranza` (`aplica_libranza`),
  ADD KEY `entidad` (`entidad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id del cliente';

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_configuraciones_foreign` FOREIGN KEY (`configuraciones`) REFERENCES `config_usuarios` (`id`),
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`aplica_libranza`) REFERENCES `siyno` (`id`),
  ADD CONSTRAINT `clientes_ibfk_2` FOREIGN KEY (`entidad`) REFERENCES `empresas_cuotas` (`id`),
  ADD CONSTRAINT `clientes_id_tienda_foreign` FOREIGN KEY (`id_tienda`) REFERENCES `tiendas` (`id`),
  ADD CONSTRAINT `zonas_id_zona_foreign` FOREIGN KEY (`id_zona`) REFERENCES `zonas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
