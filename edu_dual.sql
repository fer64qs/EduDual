-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-06-2025 a las 02:08:24
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
-- Base de datos: `edu_dual`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `idalumno` int(100) NOT NULL,
  `apellidop` varchar(250) NOT NULL,
  `apellidom` varchar(250) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `sexo` varchar(100) NOT NULL,
  `num_control` varchar(100) NOT NULL,
  `curp` varchar(250) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `celular` varchar(100) NOT NULL,
  `idcarrera` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`idalumno`, `apellidop`, `apellidom`, `nombre`, `sexo`, `num_control`, `curp`, `correo`, `celular`, `idcarrera`) VALUES
(4, 'SANTAMARIA', 'MAGAÃ‘A', 'JORGE ÃNGEL', 'HOMBRE', '12542526', 'SAMJ8511117HYNNGR06', 'isc.jsantamaria@gmail.com', '9971118771', 4),
(5, 'CHUC', 'CHAN', 'DEYSI CAROLINA', 'MUJER', '12542526', 'CURPDEYSI', 'chuc@gmail.com', '9971118771', 1),
(12, 'SANTAMARIA', 'MAGAÃ‘A', 'FLEUR', 'MUJER', '193', 'CURPDEFLER', 'fleur@gmail.com', '9978885522', 4),
(17, 'SANTAMARIA', 'CHUC', 'SIRUS', 'HOMBRE', '193656', 'CURP SIRIUS', 'jsantamaria@suryucatan.tecnm.mx', '9974562312', 2),
(27, 'LEON', 'CABRERA', 'SAMANTHA GISSELLE', 'MUJER', '652536544', 'CURPS', 'leon@hotmail.com', '99781', 2),
(28, 'ORTIZ', 'MAY', 'REYMUNDO JAVIER', 'HOMBRE', '887Q7YQ', 'CURPREYMUNDO', 'reymundojavierortizmay@gmail.com', '9991452378', 2),
(31, 'SOSAS', 'MEZETA', 'ABREN', 'HOMBRE', '2023193', 'CURPSACANOVA', 'abransosam0331@gmail.com', '9996367284', 4),
(34, 'SANTAMARIA', 'CHUC CHAN', 'RONALDO MESSI', 'HOMBRE', '123', 'SAMJ851117HYNNGR08', 'ronaldo@gmail.com', '9978884552', 1),
(36, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'null', 'null', 0),
(37, 'QUIÑONES', 'SOLIS', 'FERNANDO JESUS', 'HOMBRE', '2023193', 'CURPSQUSF', 'fer64qs@gmail.com', '9971224626', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

CREATE TABLE `asignaturas` (
  `idasignatura` int(11) NOT NULL,
  `nombre_asignatura` varchar(254) NOT NULL,
  `clave` varchar(15) NOT NULL,
  `creditos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `asignaturas`
--

INSERT INTO `asignaturas` (`idasignatura`, `nombre_asignatura`, `clave`, `creditos`) VALUES
(2, 'FISICA', '002', 10),
(3, 'ALGEBRA LINEAL', '0001', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacoras`
--

CREATE TABLE `bitacoras` (
  `idbitacora` int(11) NOT NULL,
  `idinscripcion` int(20) NOT NULL,
  `no_semana` int(11) NOT NULL,
  `fecha1` date NOT NULL,
  `descripcion1` text NOT NULL,
  `fecha2` date NOT NULL,
  `descripcion2` text NOT NULL,
  `fecha3` date NOT NULL,
  `descripcion3` text NOT NULL,
  `fecha4` date NOT NULL,
  `descripcion4` text NOT NULL,
  `fecha5` date NOT NULL,
  `descripcion5` text NOT NULL,
  `vobo_empresa` varchar(20) NOT NULL COMMENT 'Los valores son: AUTORIZADO, NO AUTORIZADO',
  `observaciones_empresa` text NOT NULL,
  `indicador_empresa` varchar(25) NOT NULL COMMENT 'los valores son: EXCELENTE, BUENO, REGULAR, MALO',
  `vobo_tutordual` varchar(20) NOT NULL COMMENT 'Los valores son: AUTORIZADO, NO AUTORIZADO',
  `observaciones_tutor` text NOT NULL,
  `indicador_tutor` varchar(25) NOT NULL COMMENT 'los valores son: EXCELENTE, BUENO, REGULAR, MALO',
  `dias_trabajados` int(11) NOT NULL,
  `puesto` varchar(30) NOT NULL,
  `observaciones_alumno` text NOT NULL,
  `estatus_semana` varchar(30) NOT NULL COMMENT 'seran PENDIENTE,FINALIZADO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `bitacoras`
--

INSERT INTO `bitacoras` (`idbitacora`, `idinscripcion`, `no_semana`, `fecha1`, `descripcion1`, `fecha2`, `descripcion2`, `fecha3`, `descripcion3`, `fecha4`, `descripcion4`, `fecha5`, `descripcion5`, `vobo_empresa`, `observaciones_empresa`, `indicador_empresa`, `vobo_tutordual`, `observaciones_tutor`, `indicador_tutor`, `dias_trabajados`, `puesto`, `observaciones_alumno`, `estatus_semana`) VALUES
(4, 1, 2, '2024-01-22', '<p>gjkjgkjgkg</p>', '2024-01-23', '<p>dasdsada</p>', '2024-01-24', '<p>nueva a<strong>ctividad</strong></p>', '2024-01-25', '', '2024-01-26', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 3, 'FORMACION Y DESARROLLO', '', 'PENDIENTE'),
(78, 8, 4, '2025-03-24', '', '2025-03-25', '', '2025-03-26', '', '2025-03-27', '', '2025-03-28', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(79, 8, 7, '2025-04-14', '', '2025-04-15', '', '2025-04-16', '', '2025-04-17', '', '2025-04-18', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(80, 8, 8, '2025-04-21', '', '2025-04-22', '', '2025-04-23', '', '2025-04-24', '', '2025-04-25', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(81, 8, 6, '2025-04-07', '', '2025-04-08', '', '2025-04-09', '', '2025-04-10', '', '2025-04-11', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(82, 8, 9, '2025-04-28', '', '2025-04-29', '', '2025-04-30', '', '2025-05-01', '', '2025-05-02', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(83, 8, 10, '2025-05-05', '', '2025-05-06', '', '2025-05-07', '', '2025-05-08', '', '2025-05-09', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(84, 8, 12, '2025-05-19', '', '2025-05-20', '', '2025-05-21', '', '2025-05-22', '', '2025-05-23', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(85, 8, 11, '2025-05-12', '', '2025-05-13', '', '2025-05-14', '', '2025-05-15', '', '2025-05-16', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(86, 8, 13, '2025-05-26', '', '2025-05-27', '', '2025-05-28', '', '2025-05-29', '', '2025-05-30', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(87, 9, 2, '2025-02-24', '', '2025-02-25', '', '2025-02-26', '', '2025-02-27', '', '2025-02-28', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(102, 18, 5, '2025-03-24', '', '2025-03-25', '', '2025-03-26', '', '2025-03-27', '', '2025-03-28', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(103, 18, 3, '2025-03-10', '', '2025-03-11', '', '2025-03-12', '', '2025-03-13', '', '2025-03-14', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(107, 19, 1, '2025-02-24', '<p>paso 1</p><p>sistema de prueba</p>', '2025-02-25', '<p>paso 2:<br><br>mantenimiento</p>', '2025-02-26', '<p>paso 3:<br><br>testeo</p>', '2025-02-27', '<p>paso 4&nbsp;<br><br>lanzamiento</p>', '2025-02-28', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 4, 'RECLUTAMIENTO', '<p>aun en prueba</p>', 'PENDIENTE'),
(108, 20, 1, '2025-02-17', '', '2025-02-18', '', '2025-02-19', '', '2025-02-20', '', '2025-02-21', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(109, 20, 2, '2025-02-24', '', '2025-02-25', '', '2025-02-26', '', '2025-02-27', '', '2025-02-28', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(110, 20, 3, '2025-03-03', '', '2025-03-04', '', '2025-03-05', '', '2025-03-06', '', '2025-03-07', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(111, 21, 3, '2025-03-17', '', '2025-03-18', '', '2025-03-19', '', '2025-03-20', '', '2025-03-21', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(112, 21, 1, '2025-03-03', '', '2025-03-04', '', '2025-03-05', '', '2025-03-06', '', '2025-03-07', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(113, 21, 2, '2025-03-10', '', '2025-03-11', '', '2025-03-12', '', '2025-03-13', '', '2025-03-14', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(114, 21, 4, '2025-03-24', '', '2025-03-25', '', '2025-03-26', '', '2025-03-27', '', '2025-03-28', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(115, 22, 2, '2025-03-10', '<p>1</p>', '2025-03-11', '<p>2</p>', '2025-03-12', '<p>3</p>', '2025-03-13', '<p>4</p>', '2025-03-14', '<p>5</p>', 'AUTORIZADO', '<p>drwrffrfrrf</p>', 'NO DEFINIDO', 'AUTORIZADO', '', 'NO DEFINIDO', 5, 'FORMACION Y DESARROLLO', '<p>d6esosd</p>', 'FINALIZADO'),
(116, 22, 3, '2025-03-17', '<p>1</p>', '2025-03-18', '<p>2</p>', '2025-03-19', '<p>3</p>', '2025-03-20', '<p>4</p>', '2025-03-21', '<p>5</p>', 'AUTORIZADO', '<p>version2</p>', 'NO DEFINIDO', 'AUTORIZADO', '<p>version1</p>', 'NO DEFINIDO', 5, 'SEGURIDAD E HIGIENE', '<p>pruebas</p>', 'FINALIZADO'),
(117, 22, 4, '2025-03-24', '<p>1</p>', '2025-03-25', '<p>2</p>', '2025-03-26', '<p>3</p>', '2025-03-27', '<p>4</p>', '2025-03-28', '<p>5</p>', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'AUTORIZADO', '', 'NO DEFINIDO', 5, 'SEGURIDAD E HIGIENE', '', 'FINALIZADO'),
(118, 22, 1, '2025-03-03', '<p>trabajo 1</p>', '2025-03-04', '<p>trabajo 2</p>', '2025-03-05', '<p>dia 3</p>', '2025-03-06', '', '2025-03-07', '', 'AUTORIZADO', '', 'NO DEFINIDO', 'AUTORIZADO', '<p>caster shadows</p>', 'NO DEFINIDO', 3, 'RECLUTAMIENTO', '<p>observaciones del alumno deacuerdo al el diadsdsdsds version1</p>', 'FINALIZADO'),
(119, 29, 4, '2025-05-12', '', '2025-05-13', '', '2025-05-14', '', '2025-05-15', '', '2025-05-16', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(120, 29, 5, '2025-05-19', '', '2025-05-20', '', '2025-05-21', '', '2025-05-22', '', '2025-05-23', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(121, 29, 2, '2025-04-28', '', '2025-04-29', '', '2025-04-30', '', '2025-05-01', '', '2025-05-02', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(122, 29, 3, '2025-05-05', '', '2025-05-06', '', '2025-05-07', '', '2025-05-08', '', '2025-05-09', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(123, 29, 1, '2025-04-21', '', '2025-04-22', '', '2025-04-23', '', '2025-04-24', '', '2025-04-25', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(124, 29, 6, '2025-05-26', '', '2025-05-27', '', '2025-05-28', '', '2025-05-29', '', '2025-05-30', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE'),
(125, 31, 1, '2025-04-28', '<p>1</p>', '2025-04-29', '<p>2</p>', '2025-04-30', '<p>3</p>', '2025-05-01', '<p>4</p>', '2025-05-02', '<p>5</p>', 'AUTORIZADO', '', 'NO DEFINIDO', 'AUTORIZADO', '', 'NO DEFINIDO', 5, 'RECLUTAMIENTO', '<p>24</p>', 'FINALIZADO'),
(126, 31, 4, '2025-05-19', '', '2025-05-20', '', '2025-05-21', '', '2025-05-22', '', '2025-05-23', '', 'AUTORIZADO', '', 'NO DEFINIDO', 'AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'FINALIZADO'),
(127, 31, 3, '2025-05-12', '', '2025-05-13', '', '2025-05-14', '', '2025-05-15', '', '2025-05-16', '', 'AUTORIZADO', '', 'NO DEFINIDO', 'AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'FINALIZADO'),
(128, 31, 5, '2025-05-26', '', '2025-05-27', '', '2025-05-28', '', '2025-05-29', '', '2025-05-30', '', 'AUTORIZADO', '', 'NO DEFINIDO', 'AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'FINALIZADO'),
(129, 31, 2, '2025-05-05', '', '2025-05-06', '', '2025-05-07', '', '2025-05-08', '', '2025-05-09', '', 'AUTORIZADO', '', 'NO DEFINIDO', 'AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'FINALIZADO'),
(130, 30, 1, '2025-04-21', '', '2025-04-22', '', '2025-04-23', '', '2025-04-24', '', '2025-04-25', '', 'NO AUTORIZADO', '', 'NO DEFINIDO', 'NO AUTORIZADO', '', 'NO DEFINIDO', 0, 'NO DEFINIDO', '', 'PENDIENTE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `idcarrera` int(11) NOT NULL,
  `nombre_carrera` varchar(100) NOT NULL,
  `abreviatura` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`idcarrera`, `nombre_carrera`, `abreviatura`) VALUES
(1, 'COMPONENTE BASICO', 'CB'),
(2, 'ADMINISTRACION DE RECURSOS HUMANOS', 'ARH'),
(3, 'MECANICA INDUSTRIAL', 'MI'),
(4, 'PROGRAMACION', 'PRO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id_configuracion` int(11) NOT NULL,
  `nombre_director` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id_configuracion`, `nombre_director`) VALUES
(1, 'EDUARDO EUAN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `iddocente` int(11) NOT NULL,
  `apellido_paterno` varchar(30) NOT NULL,
  `apellido_materno` varchar(30) NOT NULL,
  `nombre_docente` varchar(30) NOT NULL,
  `sexo` varchar(100) NOT NULL,
  `rfc` varchar(50) NOT NULL,
  `num_celular` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `grado_estudios` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`iddocente`, `apellido_paterno`, `apellido_materno`, `nombre_docente`, `sexo`, `rfc`, `num_celular`, `email`, `grado_estudios`, `titulo`) VALUES
(1, 'SANTAMARIA', 'MAGAÃ‘A', 'JORGE ANGEL', 'HOMBRE', 'SAMJ851117CV1', '9971118771', 'isc.jsantamaria@gmail.com', '', ''),
(20, 'ORTIZ', 'MAY', 'REYMUNDO JAVIER', 'HOMBRE', 'RFCREYMUNDO', '9971074821', 'cbtis193.vinculacion@dgeti.sems.gob.mx', '', ''),
(21, 'SANTAMARIA', 'DZIB', 'ABELARDO', 'HOMBRE', 'RFCABELARDO', '9971150762', 'abelardo_aries@hotmail.com', '', ''),
(23, 'MEDINA', 'GUEMEZ', 'CARLOS FELIPE', 'HOMBRE', 'RFCCARLOS', '9979790033', 'carlosf.medinag@hotmail.com', 'LICENCIATURA', 'ING'),
(24, 'SANTOYO', 'KU', 'YENIFER DE LA CRUZ', 'MUJER', 'AUPK8911183X6', '9971229293', 'rhumanos@famarg.com.mx', '', ''),
(25, 'PAT', 'TEC', 'GLADIS GABRIELA', 'MUJER', 'eang6012gu2', '9979739862', 'materialespina@hotmail.com', '', ''),
(31, 'QUIÑONES', 'SOLIS', 'FERNANDO JESUS', 'HOMBRE', 'FER121213', '12312312312', 'fernandoquinonessolis@gmail.com', 'TECNICO SUPERIOR UNIVERSITARIO', 'LIC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `idempresa` int(11) NOT NULL,
  `nombre_empresa` varchar(255) NOT NULL,
  `rfc` varchar(13) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono` varchar(25) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `representante` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`idempresa`, `nombre_empresa`, `rfc`, `direccion`, `telefono`, `email`, `representante`) VALUES
(1, 'SERVICIOS ESPECIALES', 'BACJ0204047C7', 'C 20 X 51 Y 53 COL YOCCHENKAX', '9979790850', 'jachiamarilla@outlook.com', 'JUAN MANUEL TEJERO LOPEZ'),
(2, 'COMERCIALIZADORA FAMARG', 'AUPK8911183X6', 'C 45 X 36 Y 30, COL. MEJORADA, OXKUTZCAB, YUC.', '992124569', 'rhumanos@famarg.com.mx', 'YENIFER DE LA CRUZ SANTOYO KU'),
(3, 'DISTRIBUIDORA DE MATERIALES PIÃ‘A DE TEKAX SA DE C.V.', 'EANG601212GU2', 'C 43 X 54 Y 56 COL. SAN IGNACIO, TEKAX, YUC.', '9979739862', 'MATERIALESPINA@HOTMAIL.COM', 'GLADIS GABRIELA PAT TEC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `idGrupo` int(11) NOT NULL,
  `grupo` varchar(254) NOT NULL,
  `folio` varchar(10) NOT NULL,
  `idcarrera` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`idGrupo`, `grupo`, `folio`, `idcarrera`) VALUES
(1, '6BP', '180', 4),
(3, '12AVS', '181', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `idinscripcion` int(20) NOT NULL,
  `idalumno` int(20) NOT NULL,
  `idempresa` int(20) NOT NULL,
  `idpersonal` int(20) NOT NULL,
  `idtutor_academico` int(20) NOT NULL,
  `id_configuracion` int(20) NOT NULL,
  `idSemestre` int(20) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estatus` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripciones`
--

INSERT INTO `inscripciones` (`idinscripcion`, `idalumno`, `idempresa`, `idpersonal`, `idtutor_academico`, `id_configuracion`, `idSemestre`, `fecha_inicio`, `fecha_fin`, `estatus`) VALUES
(25, 28, 1, 12, 5, 1, 1, '2025-04-25', '2025-05-10', 'INACTIVO'),
(28, 17, 2, 13, 2, 1, 1, '2025-04-23', '2025-05-17', 'ACTIVO'),
(30, 31, 2, 14, 4, 1, 2, '2025-04-26', '2025-04-26', 'INACTIVO'),
(31, 37, 1, 14, 6, 1, 2, '2025-05-02', '2025-05-31', 'ACTIVO'),
(32, 34, 3, 13, 2, 1, 2, '2025-04-24', '2025-06-28', 'INACTIVO'),
(33, 5, 2, 14, 1, 1, 1, '2025-04-24', '2025-05-10', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `id_noticia` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `subtitulo` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`id_noticia`, `titulo`, `subtitulo`, `fecha`, `descripcion`, `imagen`) VALUES
(54, 'Inicio del proceso de selección', 'completada fase de recuperación', '2025-05-02', '<blockquote><p><strong>posibles fallos y errores, serán reportados de acuerdo vayan saliendo</strong></p></blockquote>', '/edu_dual/admin/uploads/684208b9334f3_Ing. Jorge Ángel Santamaría Magaña (1).png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles_usuarios`
--

CREATE TABLE `perfiles_usuarios` (
  `idperfil` int(11) NOT NULL,
  `nombre_perfil` varchar(50) NOT NULL,
  `descripcion` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `perfiles_usuarios`
--

INSERT INTO `perfiles_usuarios` (`idperfil`, `nombre_perfil`, `descripcion`) VALUES
(1, 'ADMINISTRADOR', ''),
(2, 'DOCENTE', ''),
(3, 'COORDINACION', ''),
(4, 'PADRE DE FAMILIA/TUTOR', ''),
(5, 'ALUMNO', ''),
(6, 'INSTRUCTOR DUAL', 'PERFIL QUE TIENEN LOS USUARIOS QUE SON DE LA EMPRESA DUAL'),
(7, 'TUTOR ACADEMICO', 'TUTOR DE GRUPO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_empresas`
--

CREATE TABLE `personal_empresas` (
  `idpersonal` int(11) NOT NULL,
  `papellido_paterno` varchar(50) NOT NULL,
  `papellido_materno` varchar(50) NOT NULL,
  `nombre_personal` varchar(100) NOT NULL,
  `sexo` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `cargo_empresa` varchar(50) NOT NULL,
  `idempresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personal_empresas`
--

INSERT INTO `personal_empresas` (`idpersonal`, `papellido_paterno`, `papellido_materno`, `nombre_personal`, `sexo`, `telefono`, `correo`, `cargo_empresa`, `idempresa`) VALUES
(12, 'PEREZ ', 'CHABLE', 'RODRIGO ALEJANDO', 'HOMBRE', '999284894', 'rodrigofe@gmail.com', 'INSTITUTO TECNOLÓGICO SUPERIOR DEL SUR DEL ESTADO ', 2),
(13, 'BALAM', 'CANCHES', 'GERARDO REYES', 'HOMBRE', '9971283894', 'gerardo@gmail.com', 'RESIDENTE', 3),
(14, 'CHAN', 'EK', 'ALBERTO RODOLFO', 'HOMBRE', '9979790849', 'l.201t0069@suryucatan.tecnm.mx', 'SERVICIOS ESPECIALES', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planteles`
--

CREATE TABLE `planteles` (
  `idplantel` int(11) NOT NULL,
  `nombre_plantel` varchar(100) NOT NULL,
  `ubicacion_plantel` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `planteles`
--

INSERT INTO `planteles` (`idplantel`, `nombre_plantel`, `ubicacion_plantel`) VALUES
(10, 'INSTITUTO TECNOLOGICO SUPERIOR DEL SUR DEL ESTADO DE YUCATAN', 'OXKUTZCAB, YUCATAN CENTRO'),
(11, 'EL INSTITUTO TECNOLÓGICO DE MÉXICO', 'CDMX');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `semestres`
--

CREATE TABLE `semestres` (
  `idSemestre` int(11) NOT NULL,
  `semestre` varchar(50) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `semestres`
--

INSERT INTO `semestres` (`idSemestre`, `semestre`, `fecha_inicio`, `fecha_fin`) VALUES
(1, '2024B', '0000-00-00', '0000-00-00'),
(2, '2025A', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutores_academicos`
--

CREATE TABLE `tutores_academicos` (
  `idtutor_academico` int(11) NOT NULL,
  `apellido_paterno` varchar(30) NOT NULL,
  `apellido_materno` varchar(30) NOT NULL,
  `nombre_tutor` varchar(30) NOT NULL,
  `sexo` varchar(15) DEFAULT NULL,
  `num_celular` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `titulo_academico` varchar(10) NOT NULL,
  `especialidad` varchar(254) NOT NULL,
  `curp` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tutores_academicos`
--

INSERT INTO `tutores_academicos` (`idtutor_academico`, `apellido_paterno`, `apellido_materno`, `nombre_tutor`, `sexo`, `num_celular`, `email`, `titulo_academico`, `especialidad`, `curp`) VALUES
(1, 'SANTAMAMARÍA', 'MAGAÑA', 'JORGE ÁNGEL', 'HOMBRE', '9971118771', 'isc.jsantamaria@gmail.com', 'ISC', 'INGENIERA EN SISTEMAS COMPUTACIONALES', 'SAMJ851117HYNNGR06'),
(2, 'AVILA', 'SANCHEZ', 'ELBA YOLANDA', 'MUJER', '9997898586', 'elbaavila@gmail.com', 'LIC', 'FISICA', 'CURPELBA'),
(4, 'CAMPOS', 'HEREDIA', 'JORGE ANTONIO', 'HOMBRE', '9991234585', 'caemcursos@gmail.com', 'ING', 'ENERGIAS RENOVABLES', 'CURPCAMPOS'),
(5, 'CAB', 'PISTE', 'DIEGO MARTIN', 'HOMBRE', '9971118771', 'diegui@gmail.com', 'DR', 'CIENCIAS DE LA COMPUTACION', 'CURPDIEGUI'),
(6, 'GONZALEZ', 'DIAZ', 'ABELARDO JESUS', 'HOMBRE', '9972893948', 'fernandoquinonessolis@gmail.com', 'ING', 'SISTEMAS COMPUTACIONALES', 'CURPSOLIS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `clave_sie` varchar(100) NOT NULL,
  `contrasenia` varchar(254) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefono` varchar(25) NOT NULL,
  `foto` varchar(254) NOT NULL,
  `idperfil` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `apellidos`, `nombres`, `clave_sie`, `contrasenia`, `email`, `telefono`, `foto`, `idperfil`) VALUES
(1, 'SANTAMARIA MAGAñA', 'JORGE ANGEL', '136', '$2y$10$8.XOiPJ5VKxfIYqwKWlPuutiIy895PrfbRnBofPMcbL5OvKpk90qG', 'isc.jsantamaria@gmail.com', '9971118771', '../profiles_uploads/JAANAL_FOOD (1) (1).png', 2),
(2, 'AVILES POOT', 'DAVID ARIEL', '124', '$2y$10$S4S6k.CJoSf664VoVa5K3e9t1IuaUC9ADBR78GtS1KTaFhqGC3i5a', 'david@gmail.com', '9971452898', '../profiles_uploads/EVA.png', 2),
(3, 'SANTAMARIA MAGAÑA', 'JORGE ANGEL', 'AD001', '$2y$10$2G7busNHk4HQi2YZZhKvwuSJGEfVLMITJE593SyHmeRtYE4vzzlkq', 'buconet@hotmail.com', '9971118771', '../profiles_uploads/PArents.png', 1),
(48, 'ORTIZ MAY', 'REYMUNDO JAVIER', 'reymundojavierortizmay@gmail.com', '$2y$10$mkHUSQEeI7a5XPymBG6/5.S.7cCdr7ZaYg4qyLv/2SRp35qboTK4m', 'reymundojavierortizmay@gmail.com', '9991452378', '../profiles_uploads/1000147217.jpg', 5),
(49, 'SOSA MEZETA', 'ABRAN', 'abransosam0331@gmail.com', '$2y$10$t.BTdp/otdWid8ES3Ykz9uyk6ikreIImfmKplA9qjBAPqgEJJy1Ry', 'abransosam0331@gmail.com', '9996367284', '../profiles_uploads/1000147291.jpg', 5),
(59, 'SANTAMARIA CHUC', 'SIRUS', 'jsantamaria@suryucatan.tecnm.mx', '$2y$10$UBorQaRVl95TlSjJooslvO/7I5KjW3LSpce0kvO6/TN9RqJl7t7UC', 'jsantamaria@suryucatan.tecnm.mx', '9974562312', '../profiles_uploads/cnppe.png', 5),
(60, 'SANTAMARIA MAGAÑA', 'JORGE ÁNGEL', 'isc.jsantamaria@gmail.com', '$2y$10$qLBod0NPXblBYQffRdVq0.mvBeCNmYB8izZf4ygtc7K/mtXDQYgt6', 'isc.jsantamaria@gmail.com', '9971118771', '../profiles_uploads/cnppe.png', 5),
(61, 'SANTAMAMARÍA MAGAÑA', 'JORGE ÁNGEL', 'isc.jsantamaria@gmail.com', '$2y$10$FCIYloNV7PePl88I7zngSuXJI3USsY.tUMkojso785lFJjlaC/EwC', 'isc.jsantamaria@gmail.com', '9971118771', '../profiles_uploads/cnppe.png', 7),
(77, 'QUIÑONES SOLIS', 'FERNANDO JESUS', 'fer64qs@gmail.com', '$2y$10$KOUot.yZf9oRNGY7ji/cqeiic3dvkkguubR2rIgCWo0wu.qwZsJAS', 'fer64qs@gmail.com', '9971224626', '../profiles_uploads/descargar (1).jfif', 5),
(78, 'CHAN EK', 'ALBERTO RODOLFO', 'l.201t0069@suryucatan.tecnm.mx', '$2y$10$BBSjJtC9YAN/1QF2ARDFb.pBjvewLPlW1JTMNcZCShrChuI6AuHci', 'l.201t0069@suryucatan.tecnm.mx', '9979790849', '../profiles_uploads/wp4663188.jpg', 6),
(79, 'GONZALEZ DIAZ', 'ABELARDO JESUS', 'fernandoquinonessolis@gmail.com', '$2y$10$hsL4Si4XDRYRXuw4.KarZ.T7UCndNAS6IHMY74uNSi/yB9WOSaKY6', 'fernandoquinonessolis@gmail.com', '9972893948', '../profiles_uploads/1825133.png', 7),
(80, 'SANTAMARIA MAGAÃ‘A', 'FLEUR', 'fleur@gmail.com', '$2y$10$pOYmWk5cdBX6Px2qLm3h3eaA0TcjKerTzD120GD8WaEYpPYZ3TNsi', 'fleur@gmail.com', '9978885522', '../profiles_uploads/Imagen de WhatsApp 2025-06-03 a las 16.29.13_f3d26e7a.jpg', 5);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`idalumno`);

--
-- Indices de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD PRIMARY KEY (`idasignatura`);

--
-- Indices de la tabla `bitacoras`
--
ALTER TABLE `bitacoras`
  ADD PRIMARY KEY (`idbitacora`);

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`idcarrera`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id_configuracion`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`iddocente`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`idempresa`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`idGrupo`);

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`idinscripcion`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id_noticia`);

--
-- Indices de la tabla `perfiles_usuarios`
--
ALTER TABLE `perfiles_usuarios`
  ADD PRIMARY KEY (`idperfil`);

--
-- Indices de la tabla `personal_empresas`
--
ALTER TABLE `personal_empresas`
  ADD PRIMARY KEY (`idpersonal`);

--
-- Indices de la tabla `planteles`
--
ALTER TABLE `planteles`
  ADD PRIMARY KEY (`idplantel`);

--
-- Indices de la tabla `semestres`
--
ALTER TABLE `semestres`
  ADD PRIMARY KEY (`idSemestre`);

--
-- Indices de la tabla `tutores_academicos`
--
ALTER TABLE `tutores_academicos`
  ADD PRIMARY KEY (`idtutor_academico`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `idalumno` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  MODIFY `idasignatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `bitacoras`
--
ALTER TABLE `bitacoras`
  MODIFY `idbitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `idcarrera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id_configuracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `iddocente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `idempresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `idGrupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `idinscripcion` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id_noticia` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `perfiles_usuarios`
--
ALTER TABLE `perfiles_usuarios`
  MODIFY `idperfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `personal_empresas`
--
ALTER TABLE `personal_empresas`
  MODIFY `idpersonal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `planteles`
--
ALTER TABLE `planteles`
  MODIFY `idplantel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `semestres`
--
ALTER TABLE `semestres`
  MODIFY `idSemestre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tutores_academicos`
--
ALTER TABLE `tutores_academicos`
  MODIFY `idtutor_academico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
