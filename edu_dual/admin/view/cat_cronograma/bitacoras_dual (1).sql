-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-02-2025 a las 22:20:09
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `aulanet`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacoras_dual`
--

CREATE TABLE `bitacoras_dual` (
  `idbitacora` int(11) NOT NULL,
  `idinscripcion_dual` int(11) NOT NULL,
  `no_semana` int(11) NOT NULL,
  `fecha1` date NOT NULL,
  `descripcion1` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha2` date NOT NULL,
  `descripcion2` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha3` date NOT NULL,
  `descripcion3` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha4` date NOT NULL,
  `descripcion4` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha5` date NOT NULL,
  `descripcion5` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `vobo_empresa` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Los valores son: AUTORIZADO, NO AUTORIZADO',
  `observaciones_empresa` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `indicador_empresa` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'los valores son: EXCELENTE, BUENO, REGULAR, MALO',
  `vobo_tutordual` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Los valores son: AUTORIZADO, NO AUTORIZADO',
  `observaciones_tutor` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `indicador_tutor` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'los valores son: EXCELENTE, BUENO, REGULAR, MALO',
  `dias_trabajados` int(11) NOT NULL,
  `puesto` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observaciones_alumno` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `estatus_semana` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'seran PENDIENTE,FINALIZADO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `bitacoras_dual`
--

INSERT INTO `bitacoras_dual` (`idbitacora`, `idinscripcion_dual`, `no_semana`, `fecha1`, `descripcion1`, `fecha2`, `descripcion2`, `fecha3`, `descripcion3`, `fecha4`, `descripcion4`, `fecha5`, `descripcion5`, `vobo_empresa`, `observaciones_empresa`, `indicador_empresa`, `vobo_tutordual`, `observaciones_tutor`, `indicador_tutor`, `dias_trabajados`, `puesto`, `observaciones_alumno`, `estatus_semana`) VALUES
(1, 1, 1, '2024-01-15', '<p>esta <strong>es</strong>&nbsp;</p>', '2024-01-16', '<p>probando 2 <strong>activi</strong>dad</p>', '2024-01-17', '<p>nue<strong>va activi</strong>dad</p>', '2024-01-18', '<p>nuev activida</p>', '2024-01-19', '<p>ddada<strong>sdad</strong>asdd</p>', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 5, 'RECLUTAMIENTO', '<p>Llenar <strong>Formatos jajajaj</strong></p>', 'PENDIENTE'),
(2, 1, 4, '2024-02-05', '', '2024-02-06', '', '2024-02-07', '', '2024-02-08', '', '2024-02-09', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(3, 1, 3, '2024-01-29', '', '2024-01-30', '', '2024-01-31', '', '2024-02-01', '', '2024-02-02', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(4, 1, 2, '2024-01-22', '<p>gjkjgkjgkg</p>', '2024-01-23', '<p>dasdsada</p>', '2024-01-24', '<p>nueva a<strong>ctividad</strong></p>', '2024-01-25', '', '2024-01-26', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 3, 'FORMACION Y DESARROLLO', '', 'PENDIENTE'),
(5, 1, 6, '2024-02-19', '', '2024-02-20', '', '2024-02-21', '', '2024-02-22', '', '2024-02-23', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(6, 1, 5, '2024-02-12', '', '2024-02-13', '', '2024-02-14', '', '2024-02-15', '', '2024-02-16', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(7, 1, 7, '2024-02-26', '', '2024-02-27', '', '2024-02-28', '', '2024-02-29', '', '2024-03-01', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(8, 1, 9, '2024-03-11', '', '2024-03-12', '', '2024-03-13', '', '2024-03-14', '', '2024-03-15', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(9, 1, 10, '2024-03-18', '', '2024-03-19', '', '2024-03-20', '', '2024-03-21', '', '2024-03-22', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(10, 1, 8, '2024-03-04', '', '2024-03-05', '', '2024-03-06', '', '2024-03-07', '', '2024-03-08', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(11, 1, 12, '2024-04-01', '', '2024-04-02', '', '2024-04-03', '', '2024-04-04', '', '2024-04-05', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(12, 1, 13, '2024-04-08', '', '2024-04-09', '', '2024-04-10', '', '2024-04-11', '', '2024-04-12', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(13, 1, 14, '2024-04-15', '', '2024-04-16', '', '2024-04-17', '', '2024-04-18', '', '2024-04-19', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(14, 1, 15, '2024-04-22', '', '2024-04-23', '', '2024-04-24', '', '2024-04-25', '', '2024-04-26', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(15, 1, 11, '2024-03-25', '', '2024-03-26', '', '2024-03-27', '', '2024-03-28', '', '2024-03-29', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(16, 1, 16, '2024-04-29', '', '2024-04-30', '', '2024-05-01', '', '2024-05-02', '', '2024-05-03', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(17, 1, 17, '2024-05-06', '', '2024-05-07', '', '2024-05-08', '', '2024-05-09', '', '2024-05-10', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(18, 1, 18, '2024-05-13', '', '2024-05-14', '', '2024-05-15', '', '2024-05-16', '', '2024-05-17', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(19, 1, 19, '2024-05-20', '', '2024-05-21', '', '2024-05-22', '', '2024-05-23', '', '2024-05-24', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(20, 1, 20, '2024-05-27', '', '2024-05-28', '', '2024-05-29', '', '2024-05-30', '', '2024-05-31', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(21, 1, 21, '2024-06-03', '', '2024-06-04', '', '2024-06-05', '', '2024-06-06', '', '2024-06-07', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(22, 1, 22, '2024-06-10', '', '2024-06-11', '', '2024-06-12', '', '2024-06-13', '', '2024-06-14', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(23, 1, 25, '2024-07-01', '', '2024-07-02', '', '2024-07-03', '', '2024-07-04', '', '2024-07-05', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(24, 1, 24, '2024-06-24', '', '2024-06-25', '', '2024-06-26', '', '2024-06-27', '', '2024-06-28', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(25, 1, 26, '2024-07-08', '', '2024-07-09', '', '2024-07-10', '', '2024-07-11', '', '2024-07-12', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(26, 1, 27, '2024-07-15', '', '2024-07-16', '', '2024-07-17', '', '2024-07-18', '', '2024-07-19', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(27, 1, 23, '2024-06-17', '', '2024-06-18', '', '2024-06-19', '', '2024-06-20', '', '2024-06-21', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(28, 2, 2, '2024-01-22', '', '2024-01-23', '', '2024-01-24', '', '2024-01-25', '', '2024-01-26', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(29, 2, 6, '2024-02-19', '', '2024-02-20', '', '2024-02-21', '', '2024-02-22', '', '2024-02-23', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(30, 2, 4, '2024-02-05', '', '2024-02-06', '', '2024-02-07', '', '2024-02-08', '', '2024-02-09', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(31, 2, 3, '2024-01-29', '', '2024-01-30', '', '2024-01-31', '', '2024-02-01', '', '2024-02-02', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(32, 2, 5, '2024-02-12', '', '2024-02-13', '', '2024-02-14', '', '2024-02-15', '', '2024-02-16', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(33, 2, 1, '2024-01-15', '', '2024-01-16', '', '2024-01-17', '', '2024-01-18', '', '2024-01-19', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(34, 2, 7, '2024-02-26', '', '2024-02-27', '', '2024-02-28', '', '2024-02-29', '', '2024-03-01', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(35, 2, 11, '2024-03-25', '', '2024-03-26', '', '2024-03-27', '', '2024-03-28', '', '2024-03-29', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(36, 2, 9, '2024-03-11', '', '2024-03-12', '', '2024-03-13', '', '2024-03-14', '', '2024-03-15', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(37, 2, 10, '2024-03-18', '', '2024-03-19', '', '2024-03-20', '', '2024-03-21', '', '2024-03-22', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(38, 2, 8, '2024-03-04', '', '2024-03-05', '', '2024-03-06', '', '2024-03-07', '', '2024-03-08', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(39, 2, 12, '2024-04-01', '', '2024-04-02', '', '2024-04-03', '', '2024-04-04', '', '2024-04-05', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(40, 2, 13, '2024-04-08', '', '2024-04-09', '', '2024-04-10', '', '2024-04-11', '', '2024-04-12', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(41, 2, 14, '2024-04-15', '', '2024-04-16', '', '2024-04-17', '', '2024-04-18', '', '2024-04-19', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(42, 2, 17, '2024-05-06', '', '2024-05-07', '', '2024-05-08', '', '2024-05-09', '', '2024-05-10', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(43, 2, 15, '2024-04-22', '', '2024-04-23', '', '2024-04-24', '', '2024-04-25', '', '2024-04-26', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(44, 2, 18, '2024-05-13', '', '2024-05-14', '', '2024-05-15', '', '2024-05-16', '', '2024-05-17', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(45, 2, 19, '2024-05-20', '', '2024-05-21', '', '2024-05-22', '', '2024-05-23', '', '2024-05-24', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(46, 2, 16, '2024-04-29', '', '2024-04-30', '', '2024-05-01', '', '2024-05-02', '', '2024-05-03', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(47, 2, 21, '2024-06-03', '', '2024-06-04', '', '2024-06-05', '', '2024-06-06', '', '2024-06-07', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(48, 2, 20, '2024-05-27', '', '2024-05-28', '', '2024-05-29', '', '2024-05-30', '', '2024-05-31', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(49, 2, 22, '2024-06-10', '', '2024-06-11', '', '2024-06-12', '', '2024-06-13', '', '2024-06-14', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(50, 2, 23, '2024-06-17', '', '2024-06-18', '', '2024-06-19', '', '2024-06-20', '', '2024-06-21', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(51, 2, 24, '2024-06-24', '', '2024-06-25', '', '2024-06-26', '', '2024-06-27', '', '2024-06-28', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(52, 2, 25, '2024-07-01', '', '2024-07-02', '', '2024-07-03', '', '2024-07-04', '', '2024-07-05', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(53, 2, 27, '2024-07-15', '', '2024-07-16', '', '2024-07-17', '', '2024-07-18', '', '2024-07-19', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(54, 2, 28, '2024-07-22', '', '2024-07-23', '', '2024-07-24', '', '2024-07-25', '', '2024-07-26', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(55, 2, 26, '2024-07-08', '', '2024-07-09', '', '2024-07-10', '', '2024-07-11', '', '2024-07-12', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(56, 2, 29, '2024-07-29', '', '2024-07-30', '', '2024-07-31', '', '2024-08-01', '', '2024-08-02', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bitacoras_dual`
--
ALTER TABLE `bitacoras_dual`
  ADD PRIMARY KEY (`idbitacora`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacoras_dual`
--
ALTER TABLE `bitacoras_dual`
  MODIFY `idbitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
