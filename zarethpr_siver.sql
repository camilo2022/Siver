-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 04-01-2023 a las 11:40:08
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
-- Base de datos: `zarethpr_siver`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `telefono` char(60) NOT NULL COMMENT 'telefono de la persona',
  `nombres` char(60) NOT NULL COMMENT 'nombres de la persona',
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'relaciona el usuario de la tabla users que creo el cliente.',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conteoPrendas`
--

CREATE TABLE `conteoPrendas` (
  `id` int(11) NOT NULL,
  `referencia` varchar(120) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 0 COMMENT '0:Espera - 1:Terminado.',
  `tipo` char(25) NOT NULL DEFAULT 'NORMAL',
  `obs` text DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `t04` int(11) NOT NULL DEFAULT 0,
  `t06` int(11) NOT NULL DEFAULT 0,
  `t08` int(11) NOT NULL DEFAULT 0,
  `t10` int(11) NOT NULL DEFAULT 0,
  `t12` int(11) NOT NULL DEFAULT 0,
  `t14` int(11) NOT NULL DEFAULT 0,
  `t16` int(11) NOT NULL DEFAULT 0,
  `t18` int(11) NOT NULL DEFAULT 0,
  `t20` int(11) NOT NULL DEFAULT 0,
  `t22` int(11) NOT NULL DEFAULT 0,
  `t24` int(11) NOT NULL DEFAULT 0,
  `t26` int(11) NOT NULL DEFAULT 0,
  `t28` int(11) NOT NULL DEFAULT 0,
  `t30` int(11) NOT NULL DEFAULT 0,
  `t32` int(11) NOT NULL DEFAULT 0,
  `t34` int(11) NOT NULL DEFAULT 0,
  `t36` int(11) NOT NULL DEFAULT 0,
  `t38` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `restante` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuotas_libranza`
--

CREATE TABLE `cuotas_libranza` (
  `id` int(11) NOT NULL,
  `historial_libranza_id` bigint(20) NOT NULL COMMENT 'Relaciona la libranza a la cual esta relacionada la cuota',
  `fechaCuota` date NOT NULL DEFAULT current_timestamp() COMMENT 'fecha estimada de pago de la cuota',
  `monto` double NOT NULL COMMENT 'monto de pago',
  `fechaPago` timestamp NULL DEFAULT NULL COMMENT 'fecha en que se realiza el pago',
  `estado` int(11) NOT NULL DEFAULT 0 COMMENT '0:No se ha realizado pago 1: Ya esta paga',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuentos_libranza`
--

CREATE TABLE `descuentos_libranza` (
  `id` int(11) NOT NULL,
  `historial_libranza_id` int(11) NOT NULL COMMENT 'id de la libranza de la tabla historial_libranza',
  `monto` double NOT NULL DEFAULT 0 COMMENT 'monto de descuento',
  `users_id` int(11) NOT NULL COMMENT 'el usuario que realiza el descuento (relacionado con la tabla users)',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallesolicitud`
--

CREATE TABLE `detallesolicitud` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `solicitud_id` bigint(20) UNSIGNED NOT NULL,
  `refItem` char(155) NOT NULL,
  `codbarras` char(155) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ecommerce`
--

CREATE TABLE `ecommerce` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `ventaconcreta` int(11) NOT NULL COMMENT '	1:Si 2:No',
  `tiporequerimiento` int(11) NOT NULL COMMENT '1:TipoA 2:TipoB 3:Otro	',
  `observacion` text NOT NULL COMMENT 'observaciones del usuario',
  `clasificacion` int(11) NOT NULL COMMENT '1::Al Mayor 2:Intermedio 3:Detal',
  `talla` char(12) NOT NULL COMMENT 'talla del cliente',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ensamble`
--

CREATE TABLE `ensamble` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `turno` int(10) UNSIGNED NOT NULL,
  `modulo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_empleado` int(10) UNSIGNED NOT NULL,
  `id_referencia` int(10) UNSIGNED NOT NULL,
  `tallas` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tc` int(10) UNSIGNED NOT NULL,
  `tipo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hora` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `tiempo_req_h` double(8,2) NOT NULL,
  `meta_produccion` int(10) UNSIGNED NOT NULL,
  `eficiencia` double(8,2) NOT NULL,
  `n_operarios` double(8,2) NOT NULL,
  `id_parada_prg` int(11) DEFAULT NULL,
  `id_parada_noprg` int(11) DEFAULT NULL,
  `tiempo_noprg` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id` int(11) NOT NULL COMMENT 'identificador unico',
  `estado` char(100) NOT NULL COMMENT '1:Creada 2:Cancelada por el usuario 3:Aceptada 4:Impresas 5:No aprobada',
  `descripcion` varchar(180) NOT NULL COMMENT 'descripción del estado',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delete_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_libranza`
--

CREATE TABLE `historial_libranza` (
  `id` int(11) NOT NULL,
  `clientes_id` int(11) NOT NULL COMMENT 'id del empleado',
  `users_id` bigint(20) UNSIGNED NOT NULL COMMENT 'usuario que crea la libranza',
  `valormonto` varchar(100) NOT NULL COMMENT 'valor total de la libranza',
  `numfactura` varchar(120) NOT NULL COMMENT 'identificador de la factura',
  `codigo` varchar(100) NOT NULL COMMENT 'codigo firma de libranza',
  `smsID` varchar(250) NOT NULL COMMENT 'log descriptivo de la api de mensajería',
  `estado` int(11) NOT NULL COMMENT '1:Enviado; 5:CanceladoTotal; 2:Usado; 3:Cancelado ; 4:Reenviado; 6: Relizando Pagos',
  `cuotas` int(11) NOT NULL DEFAULT 4 COMMENT 'cantidad de cuotas a las que debe pagar el monto',
  `fechaCuota1` datetime DEFAULT NULL COMMENT 'fecha de pago de la cuota 1',
  `fechaCuota2` datetime DEFAULT NULL COMMENT 'fecha de pago de la cuota 2',
  `fechaCuota3` datetime DEFAULT NULL COMMENT 'fecha de pago de la cuota 3',
  `fechaCuota4` datetime DEFAULT NULL COMMENT 'fecha de pago de la cuota 4',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `id` bigint(11) NOT NULL COMMENT 'identificador unico',
  `codigobarras` char(155) NOT NULL,
  `pathimg1` char(255) NOT NULL,
  `pathimg2` char(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delete_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `turno` int(10) UNSIGNED NOT NULL,
  `modulo` int(10) UNSIGNED NOT NULL,
  `id_referencia` int(10) UNSIGNED NOT NULL,
  `tallas` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tc` int(10) UNSIGNED NOT NULL,
  `tipo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hora` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `tiempo_req_h` double(8,2) NOT NULL,
  `meta_produccion` int(10) UNSIGNED NOT NULL,
  `eficiencia` double(8,2) NOT NULL,
  `n_operarios` double(8,2) NOT NULL,
  `id_parada_prg` int(11) DEFAULT NULL,
  `id_parada_noprg` int(11) DEFAULT NULL,
  `tiempo_noprg` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos_stara`
--

CREATE TABLE `modulos_stara` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `turno` int(10) UNSIGNED NOT NULL,
  `modulo` int(10) UNSIGNED NOT NULL,
  `id_referencia` int(10) UNSIGNED NOT NULL,
  `tallas` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tc` int(10) UNSIGNED NOT NULL,
  `tipo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hora` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `tiempo_req_h` double(8,2) NOT NULL,
  `meta_produccion` int(10) UNSIGNED NOT NULL,
  `eficiencia` double(8,2) NOT NULL,
  `n_operarios` double(8,2) NOT NULL,
  `id_parada_prg` int(11) DEFAULT NULL,
  `id_parada_noprg` int(11) DEFAULT NULL,
  `tiempo_noprg` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion`
--

CREATE TABLE `notificacion` (
  `id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` char(189) NOT NULL,
  `descripcion` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delete_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_de_cortes`
--

CREATE TABLE `orden_de_cortes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coleccion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ncorte` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `referencia` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `letra` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `diseñador` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `porc` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_tela` int(10) UNSIGNED NOT NULL,
  `ancho` double(8,2) DEFAULT NULL,
  `tela_bolsillo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `largot2_tela_bolsillo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tendida2_tela_bolsillo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tela_dos` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `largot2_tela_dos` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tendida2_tela_dos` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ribete` double(8,2) DEFAULT NULL,
  `trazo_pasadores` double(8,2) DEFAULT NULL,
  `trazo_aletillones` double(8,2) DEFAULT NULL,
  `tendidos_1` double(8,2) DEFAULT NULL,
  `tendidos_2` double(8,2) DEFAULT NULL,
  `tendidos_3` double(8,2) DEFAULT NULL,
  `foto_D` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_T` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `marca` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `especificacion1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `especificacion2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info_tallas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `tallas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `ids_rollos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `estado` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas_no_programadas`
--

CREATE TABLE `paradas_no_programadas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo_parada_noprg` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas_programadas`
--

CREATE TABLE `paradas_programadas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo_parada_prg` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tiempo` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `picking`
--

CREATE TABLE `picking` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `referencia` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pickingConteoPrendas`
--

CREATE TABLE `pickingConteoPrendas` (
  `id` int(11) NOT NULL,
  `idconteoprendas` int(11) NOT NULL DEFAULT 0,
  `tipo` int(11) NOT NULL DEFAULT 0 COMMENT '0:Normal - 1:Saldo - 2:Marras',
  `t04` int(11) NOT NULL DEFAULT 0,
  `t06` int(11) NOT NULL DEFAULT 0,
  `t08` int(11) NOT NULL DEFAULT 0,
  `t10` int(11) NOT NULL DEFAULT 0,
  `t12` int(11) NOT NULL DEFAULT 0,
  `t14` int(11) DEFAULT 0,
  `t16` int(11) NOT NULL DEFAULT 0,
  `t18` int(11) NOT NULL DEFAULT 0,
  `t20` int(11) NOT NULL DEFAULT 0,
  `t22` int(11) NOT NULL DEFAULT 0,
  `t24` int(11) NOT NULL DEFAULT 0,
  `t26` int(11) NOT NULL DEFAULT 0,
  `t28` int(11) NOT NULL DEFAULT 0,
  `t30` int(11) NOT NULL DEFAULT 0,
  `t32` int(11) NOT NULL DEFAULT 0,
  `t34` int(11) NOT NULL DEFAULT 0,
  `t36` int(11) NOT NULL DEFAULT 0,
  `t38` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `picking_bodega`
--

CREATE TABLE `picking_bodega` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_orden_picking` int(11) NOT NULL,
  `item` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `picking_historial`
--

CREATE TABLE `picking_historial` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proceso` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int(10) UNSIGNED DEFAULT NULL,
  `id_orden_picking` int(11) NOT NULL,
  `item` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `picking_historial_orden`
--

CREATE TABLE `picking_historial_orden` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `orden_picking` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_referencia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `referencia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_picking_terminacion` datetime DEFAULT NULL,
  `id_user_terminacion` int(10) UNSIGNED DEFAULT NULL,
  `observacion_terminacion` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_picking_bodega` datetime DEFAULT NULL,
  `id_user_bodega` int(10) UNSIGNED DEFAULT NULL,
  `observacion_bodega` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `picking_orden`
--

CREATE TABLE `picking_orden` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `orden_picking` int(11) NOT NULL,
  `tipo_referencia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `referencia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `observacion` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_picking_terminacion` datetime DEFAULT NULL,
  `id_user_terminacion` int(10) UNSIGNED DEFAULT NULL,
  `observacion_terminacion` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_picking_bodega` datetime DEFAULT NULL,
  `id_user_bodega` int(10) UNSIGNED DEFAULT NULL,
  `observacion_bodega` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `picking_terminacion`
--

CREATE TABLE `picking_terminacion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_orden_picking` int(11) NOT NULL,
  `item` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `picking_tipo_prenda`
--

CREATE TABLE `picking_tipo_prenda` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_referencia` int(11) NOT NULL,
  `tipo_prenda` varchar(191) NOT NULL,
  `talla` varchar(191) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prendas_no_conformes_confeccion`
--

CREATE TABLE `prendas_no_conformes_confeccion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `modulo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_referencia` int(10) UNSIGNED NOT NULL,
  `cant_lote` int(10) UNSIGNED NOT NULL,
  `cant_muestra_rev` int(10) UNSIGNED NOT NULL,
  `text_marra` int(11) DEFAULT NULL,
  `text_mancha` int(11) DEFAULT NULL,
  `text_dos_tonos` int(11) DEFAULT NULL,
  `patro_t_piezas` int(11) DEFAULT NULL,
  `corte_piezas_mcor` int(11) DEFAULT NULL,
  `maqui_bota` int(11) DEFAULT NULL,
  `maqui_pretina` int(11) DEFAULT NULL,
  `maqui_presilla` int(11) DEFAULT NULL,
  `maqui_ojal` int(11) DEFAULT NULL,
  `maqui_mol` int(11) DEFAULT NULL,
  `maqui_cotilla` int(11) DEFAULT NULL,
  `maqui_cola` int(11) DEFAULT NULL,
  `prepa_pinza` int(11) DEFAULT NULL,
  `prepa_relojera` int(11) DEFAULT NULL,
  `prepa_parche` int(11) DEFAULT NULL,
  `prepa_cerra` int(11) DEFAULT NULL,
  `prepa_parcha` int(11) DEFAULT NULL,
  `patin_caida_parche` int(11) DEFAULT NULL,
  `patin_marc_parche` int(11) DEFAULT NULL,
  `patin_marc_pinza` int(11) DEFAULT NULL,
  `patin_marc_moda` int(11) DEFAULT NULL,
  `patin_sumn_ins` int(11) DEFAULT NULL,
  `mod_cierre` int(11) DEFAULT NULL,
  `mod_cola` int(11) DEFAULT NULL,
  `mod_cos_bolsillo_pos` int(11) DEFAULT NULL,
  `mod_cos_costado` int(11) DEFAULT NULL,
  `mod_cos_cotilla` int(11) DEFAULT NULL,
  `mod_cos_pretina` int(11) DEFAULT NULL,
  `mod_cos_jota` int(11) DEFAULT NULL,
  `mod_cos_parche` int(11) DEFAULT NULL,
  `mod_cos_pinza` int(11) DEFAULT NULL,
  `mod_cos_reboque` int(11) DEFAULT NULL,
  `mod_cos_ribete` int(11) DEFAULT NULL,
  `mod_cos_vista` int(11) DEFAULT NULL,
  `mod_embonado_parche` int(11) DEFAULT NULL,
  `mod_filete_costado` int(11) DEFAULT NULL,
  `mod_filete_entrepierna` int(11) DEFAULT NULL,
  `mod_punta` int(11) DEFAULT NULL,
  `mod_relojera` int(11) DEFAULT NULL,
  `mod_roto` int(11) DEFAULT NULL,
  `mod_tiro` int(11) DEFAULT NULL,
  `total_pno_conforme` int(10) UNSIGNED NOT NULL,
  `total_arreglos_mod` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preparacion`
--

CREATE TABLE `preparacion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `turno` int(10) UNSIGNED NOT NULL,
  `modulo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_empleado` int(10) UNSIGNED NOT NULL,
  `id_referencia` int(10) UNSIGNED NOT NULL,
  `tallas` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tc` int(10) UNSIGNED NOT NULL,
  `tipo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hora` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `tiempo_req_h` double(8,2) NOT NULL,
  `meta_produccion` int(10) UNSIGNED NOT NULL,
  `eficiencia` double(8,2) NOT NULL,
  `n_operarios` double(8,2) NOT NULL,
  `id_parada_prg` int(11) DEFAULT NULL,
  `id_parada_noprg` int(11) DEFAULT NULL,
  `tiempo_noprg` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referencias`
--

CREATE TABLE `referencias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `referencia` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lote_referencia` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad_lote` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_preparacion_emb_prc` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_preparacion_emb_rlj` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_preparacion_pin` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_preparacion_cot` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_preparacion_col` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_preparacion_prc` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_confeccion` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_ensamble_prt` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_ensamble_pnt` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_ensamble_bot` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_ensamble_bot_pln` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_ensamble_prs` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_ensamble_pas_prs` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_ensamble_pas_mol` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_ensamble_ojal` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_ensamble_rvs` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_ensamble_rvs_ext` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_ensamble_rvs_prs` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_terminacion_des` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_terminacion_tac` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_terminacion_pla` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_terminacion_mes` int(10) UNSIGNED NOT NULL,
  `tc` int(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referencias_stara`
--

CREATE TABLE `referencias_stara` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `referencia` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lote_referencia` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad_lote` int(10) UNSIGNED NOT NULL,
  `cantidad_disponible_confeccion` int(10) UNSIGNED NOT NULL,
  `tc` int(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `RefTranslados`
--

CREATE TABLE `RefTranslados` (
  `id` int(11) NOT NULL,
  `referencia` varchar(45) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `esmarra` tinyint(1) NOT NULL,
  `essaldo` tinyint(1) NOT NULL,
  `numTransferencia` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reprogramacionlorena`
--

CREATE TABLE `reprogramacionlorena` (
  `id` int(11) NOT NULL,
  `reprogramacion` varchar(120) DEFAULT NULL,
  `categoria` varchar(120) DEFAULT NULL,
  `descripcionref` varchar(120) DEFAULT NULL,
  `mes` int(11) DEFAULT NULL,
  `undxmes` int(11) DEFAULT 0,
  `undxref` int(11) DEFAULT 0,
  `nref` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `revisionsolicitud`
--

CREATE TABLE `revisionsolicitud` (
  `id` int(11) NOT NULL,
  `solicitud_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delete_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `slug` char(155) NOT NULL,
  `descripcion` char(155) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `delete_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `slug`, `descripcion`, `created_at`, `updated_at`, `delete_at`) VALUES
(1, 'AD', 'Administrador', '2021-08-02 13:29:39', NULL, NULL),
(2, 'INS', 'Area de Insumos', '2021-08-06 14:08:53', NULL, NULL),
(3, 'SOL', 'Area de solicitantes', '2021-08-06 14:08:53', NULL, NULL),
(4, 'SENA', 'Practicante SENA', '2021-08-13 20:40:23', NULL, NULL),
(5, 'GEN', 'Rol General', '2021-08-19 22:27:02', NULL, NULL),
(6, 'QR', 'Digitador QR', '2021-08-27 19:47:54', NULL, NULL),
(7, 'QRC', 'Commander QR Despacho', '2021-09-14 15:24:08', NULL, NULL),
(8, 'EP', 'Empacador', '2021-09-17 13:15:03', NULL, NULL),
(9, 'DE', 'Despachador', '2021-09-17 13:15:03', NULL, NULL),
(10, 'DP', 'Jefe de Logistica', '2021-09-17 13:15:16', NULL, NULL),
(11, 'FC', 'Facturador', '2021-10-04 16:10:32', NULL, NULL),
(12, 'OA', 'Operario Alistador', '2021-10-04 16:10:32', NULL, NULL),
(13, 'OE', 'Operario Empacado\r\n', '2021-10-04 22:09:23', NULL, NULL),
(14, 'EC', 'Ecommerce', '2021-11-04 21:36:50', NULL, NULL),
(15, 'CEC', 'Coordinador Ecommerce', '2021-11-09 13:15:06', NULL, NULL),
(16, 'AB', 'Administrativo Bless', '2021-12-21 20:13:25', NULL, NULL),
(17, 'TD', 'Tiendas', '2021-12-21 20:13:25', NULL, NULL),
(18, 'LO', 'Comercial STARA', '2022-01-04 16:31:30', NULL, NULL),
(19, 'CP', 'Contador de Prendas', '2022-02-19 13:18:41', NULL, NULL),
(20, 'VP', 'Verificador de Prendas', '2022-02-19 13:18:41', NULL, NULL),
(21, 'AU', 'Auditor', '2022-03-14 13:44:36', NULL, NULL),
(22, 'ADOC', 'Admin Orden de Corte', '2022-05-31 13:30:15', NULL, NULL),
(23, 'ADPRD', 'Administrador de Produccion', '2022-08-05 13:30:15', NULL, NULL),
(24, 'ANCON', 'Analista de Confeccion', '2022-08-05 13:30:15', NULL, NULL),
(25, 'RVREF', 'Revisión de Referencias', '2022-08-09 13:30:15', NULL, NULL),
(26, 'ADCPC', 'Administrador de Control Calidad de Prendas', '2022-08-10 13:30:15', NULL, NULL),
(27, 'CPC', 'Control Calidad de Prendas', '2022-08-10 13:40:15', NULL, NULL),
(28, 'ANTER', 'Analista de Terminacion', '2022-08-17 19:39:25', NULL, NULL),
(29, 'ADR', 'Admin Rollos', '2022-08-24 21:30:15', NULL, NULL),
(30, 'ADPICKING', 'Admin Picking', '2022-09-02 21:30:15', NULL, NULL),
(31, 'PICKING', 'Usuario que hace Picking', '2022-09-02 21:30:15', NULL, NULL),
(32, 'AOP', 'Administrador Orden de Picking', '2022-10-05 21:30:49', NULL, NULL),
(33, 'OPT', 'Operario Picking Terminacion', '2022-10-05 21:30:49', NULL, NULL),
(34, 'OPB', 'Operario Picking Bodega', '2022-10-05 21:30:49', NULL, NULL),
(35, 'CI', 'Control Interno', '2022-10-05 21:30:49', NULL, NULL),
(36, 'GPB', 'Gestion Picking Bodega', '2022-10-05 21:30:49', NULL, NULL),
(37, 'RP', 'Reportes Picking', '2022-10-05 21:30:49', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rollos`
--

CREATE TABLE `rollos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proveedor` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_entrada` date NOT NULL,
  `tela` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rollo` double(8,2) NOT NULL,
  `ancho` double(8,2) NOT NULL,
  `metros` double(8,2) NOT NULL,
  `tono` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_salida` date DEFAULT NULL,
  `salida` int(10) UNSIGNED NOT NULL,
  `observacion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `smc_picking`
--

CREATE TABLE `smc_picking` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

CREATE TABLE `solicitud` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `solicituduid` char(32) DEFAULT NULL,
  `tiposolicitud_id` bigint(20) UNSIGNED NOT NULL,
  `estado_id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `observacion` text DEFAULT NULL,
  `cantidadtotal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telas`
--

CREATE TABLE `telas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tela` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tercero`
--

CREATE TABLE `tercero` (
  `id` int(10) UNSIGNED NOT NULL,
  `centrooperacion` int(11) NOT NULL,
  `nit` varchar(12) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `razonsocial` varchar(255) NOT NULL,
  `idsucursal` varchar(255) NOT NULL,
  `descsucursal` varchar(255) NOT NULL,
  `departamento` varchar(255) NOT NULL,
  `ciudad` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono` varchar(34) NOT NULL,
  `direcciondespacho` varchar(255) NOT NULL,
  `correo` varchar(223) NOT NULL,
  `zona` varchar(120) NOT NULL,
  `celulartercero` varchar(15) NOT NULL,
  `celularsucursal` varchar(15) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `terminacion`
--

CREATE TABLE `terminacion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `turno` int(10) UNSIGNED NOT NULL,
  `modulo` int(10) UNSIGNED NOT NULL,
  `id_referencia` int(10) UNSIGNED NOT NULL,
  `tallas` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tc` int(10) UNSIGNED NOT NULL,
  `tipo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hora` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `tiempo_req_h` double(8,2) NOT NULL,
  `meta_produccion` int(10) UNSIGNED NOT NULL,
  `eficiencia` double(8,2) NOT NULL,
  `n_operarios` double(8,2) NOT NULL,
  `id_parada_prg` int(11) DEFAULT NULL,
  `id_parada_noprg` int(11) DEFAULT NULL,
  `tiempo_noprg` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposolicitud`
--

CREATE TABLE `tiposolicitud` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` char(255) NOT NULL,
  `csv` char(155) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `names` varchar(255) NOT NULL,
  `documento` varchar(25) DEFAULT NULL,
  `apellidos` varchar(200) NOT NULL,
  `rol_id` int(11) NOT NULL DEFAULT 17,
  `email` varchar(255) NOT NULL,
  `tiendacargo` varchar(124) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `names`, `documento`, `apellidos`, `rol_id`, `email`, `tiendacargo`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(44, 'Admin', NULL, 'Star', 1, 'y@y.com', 'SISTEMAS', NULL, '$2y$10$f3FGbt2zIuA2oT8myPu8Du.Y8URvTOVN9WQef0fM4X7.0Ayozwb1e', 'Im9rctk88q8GWx1ajXneC8XWkT5qzHa078h0740ojNKfwYluzUYsr90Fba3s', '2021-11-09 20:04:58', '2021-11-09 20:04:58');
--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `conteoPrendas`
--
ALTER TABLE `conteoPrendas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuotas_libranza`
--
ALTER TABLE `cuotas_libranza`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `descuentos_libranza`
--
ALTER TABLE `descuentos_libranza`
  ADD PRIMARY KEY (`id`),
  ADD KEY `historial_libranza_id` (`historial_libranza_id`);

--
-- Indices de la tabla `detallesolicitud`
--
ALTER TABLE `detallesolicitud`
  ADD PRIMARY KEY (`id`),
  ADD KEY `INDICE` (`solicitud_id`);

--
-- Indices de la tabla `ecommerce`
--
ALTER TABLE `ecommerce`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcliente` (`cliente_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `ensamble`
--
ALTER TABLE `ensamble`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `historial_libranza`
--
ALTER TABLE `historial_libranza`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientes_id` (`clientes_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigobarras` (`codigobarras`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modulos_stara`
--
ALTER TABLE `modulos_stara`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol_id` (`rol_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `orden_de_cortes`
--
ALTER TABLE `orden_de_cortes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paradas_no_programadas`
--
ALTER TABLE `paradas_no_programadas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paradas_programadas`
--
ALTER TABLE `paradas_programadas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `picking`
--
ALTER TABLE `picking`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pickingConteoPrendas`
--
ALTER TABLE `pickingConteoPrendas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `picking_bodega`
--
ALTER TABLE `picking_bodega`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `picking_historial`
--
ALTER TABLE `picking_historial`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `picking_historial_orden`
--
ALTER TABLE `picking_historial_orden`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `picking_orden`
--
ALTER TABLE `picking_orden`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `picking_terminacion`
--
ALTER TABLE `picking_terminacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `picking_tipo_prenda`
--
ALTER TABLE `picking_tipo_prenda`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prendas_no_conformes_confeccion`
--
ALTER TABLE `prendas_no_conformes_confeccion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `preparacion`
--
ALTER TABLE `preparacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `referencias`
--
ALTER TABLE `referencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `referencias_stara`
--
ALTER TABLE `referencias_stara`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `RefTranslados`
--
ALTER TABLE `RefTranslados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reprogramacionlorena`
--
ALTER TABLE `reprogramacionlorena`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `revisionsolicitud`
--
ALTER TABLE `revisionsolicitud`
  ADD PRIMARY KEY (`id`),
  ADD KEY `solicitud_id` (`solicitud_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rollos`
--
ALTER TABLE `rollos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `smc_picking`
--
ALTER TABLE `smc_picking`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tiposolicitud_id` (`tiposolicitud_id`),
  ADD KEY `estado_id` (`estado_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `telas`
--
ALTER TABLE `telas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `tercero`
--
ALTER TABLE `tercero`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `terminacion`
--
ALTER TABLE `terminacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tiposolicitud`
--
ALTER TABLE `tiposolicitud`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `documento` (`documento`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `conteoPrendas`
--
ALTER TABLE `conteoPrendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuotas_libranza`
--
ALTER TABLE `cuotas_libranza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `descuentos_libranza`
--
ALTER TABLE `descuentos_libranza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detallesolicitud`
--
ALTER TABLE `detallesolicitud`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ecommerce`
--
ALTER TABLE `ecommerce`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ensamble`
--
ALTER TABLE `ensamble`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico';

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_libranza`
--
ALTER TABLE `historial_libranza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico';

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modulos_stara`
--
ALTER TABLE `modulos_stara`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orden_de_cortes`
--
ALTER TABLE `orden_de_cortes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `paradas_no_programadas`
--
ALTER TABLE `paradas_no_programadas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `paradas_programadas`
--
ALTER TABLE `paradas_programadas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `picking`
--
ALTER TABLE `picking`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pickingConteoPrendas`
--
ALTER TABLE `pickingConteoPrendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `picking_bodega`
--
ALTER TABLE `picking_bodega`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `picking_historial`
--
ALTER TABLE `picking_historial`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `picking_historial_orden`
--
ALTER TABLE `picking_historial_orden`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `picking_orden`
--
ALTER TABLE `picking_orden`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `picking_terminacion`
--
ALTER TABLE `picking_terminacion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `picking_tipo_prenda`
--
ALTER TABLE `picking_tipo_prenda`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `prendas_no_conformes_confeccion`
--
ALTER TABLE `prendas_no_conformes_confeccion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `preparacion`
--
ALTER TABLE `preparacion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `referencias`
--
ALTER TABLE `referencias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `referencias_stara`
--
ALTER TABLE `referencias_stara`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `RefTranslados`
--
ALTER TABLE `RefTranslados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reprogramacionlorena`
--
ALTER TABLE `reprogramacionlorena`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `revisionsolicitud`
--
ALTER TABLE `revisionsolicitud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `rollos`
--
ALTER TABLE `rollos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `smc_picking`
--
ALTER TABLE `smc_picking`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `telas`
--
ALTER TABLE `telas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tercero`
--
ALTER TABLE `tercero`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `terminacion`
--
ALTER TABLE `terminacion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tiposolicitud`
--
ALTER TABLE `tiposolicitud`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `descuentos_libranza`
--
ALTER TABLE `descuentos_libranza`
  ADD CONSTRAINT `descuentos_libranza_ibfk_1` FOREIGN KEY (`historial_libranza_id`) REFERENCES `historial_libranza` (`id`);

--
-- Filtros para la tabla `detallesolicitud`
--
ALTER TABLE `detallesolicitud`
  ADD CONSTRAINT `detallesolicitud_ibfk_1` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitud` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ecommerce`
--
ALTER TABLE `ecommerce`
  ADD CONSTRAINT `ecommerce_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `ecommerce_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `historial_libranza`
--
ALTER TABLE `historial_libranza`
  ADD CONSTRAINT `historial_libranza_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD CONSTRAINT `notificacion_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notificacion_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `revisionsolicitud`
--
ALTER TABLE `revisionsolicitud`
  ADD CONSTRAINT `revisionsolicitud_ibfk_1` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitud` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `revisionsolicitud_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD CONSTRAINT `solicitud_ibfk_1` FOREIGN KEY (`tiposolicitud_id`) REFERENCES `tiposolicitud` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `solicitud_ibfk_2` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `solicitud_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
