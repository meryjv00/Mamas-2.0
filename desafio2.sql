-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-11-2020 a las 00:51:41
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `desafio2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacionasignatura`
--

CREATE TABLE `asignacionasignatura` (
  `idUsuario` int(11) NOT NULL COMMENT 'usuario',
  `idAsignatura` int(11) NOT NULL COMMENT 'asignatura'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `asignacionasignatura`
--

INSERT INTO `asignacionasignatura` (`idUsuario`, `idAsignatura`) VALUES
(4, 4),
(5, 5),
(1, 1),
(2, 2),
(6, 1),
(3, 3),
(7, 2),
(6, 2),
(6, 3),
(6, 4),
(7, 1),
(7, 3),
(7, 4),
(7, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacionpregunta`
--

CREATE TABLE `asignacionpregunta` (
  `idExamen` int(11) NOT NULL,
  `idPregunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacionrespuesta`
--

CREATE TABLE `asignacionrespuesta` (
  `idSolucion` int(11) NOT NULL,
  `idRespuesta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacionrol`
--

CREATE TABLE `asignacionrol` (
  `idUsuario` int(11) NOT NULL,
  `idRol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `asignacionrol`
--

INSERT INTO `asignacionrol` (`idUsuario`, `idRol`) VALUES
(4, 1),
(5, 1),
(1, 2),
(2, 1),
(3, 1),
(6, 0),
(7, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignatura`
--

CREATE TABLE `asignatura` (
  `idAsignatura` int(10) NOT NULL COMMENT 'Id asignatura',
  `nombre` varchar(40) NOT NULL COMMENT 'nombre asignatura',
  `imagen` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `asignatura`
--

INSERT INTO `asignatura` (`idAsignatura`, `nombre`, `imagen`) VALUES
(1, 'Desarrollo Web Entorno Servidor', NULL),
(2, 'Desarrollo Web Entorno Cliente', NULL),
(3, 'Despliegue Aplicaciones Web', NULL),
(4, 'Diseño Interfaces Web', NULL),
(5, 'Empresa Iniciativa Emprendedora', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correccion`
--

CREATE TABLE `correccion` (
  `idSolucion` int(11) NOT NULL COMMENT 'solucion del alumno',
  `idUsuario` int(11) NOT NULL COMMENT 'profesor',
  `nota` int(3) NOT NULL COMMENT 'nota numerica 0 100',
  `anotacion` text NOT NULL COMMENT 'comentario del profesor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen`
--

CREATE TABLE `examen` (
  `idExamen` int(11) NOT NULL,
  `idAsignatura` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL COMMENT 'profesor',
  `contenido` varchar(40) NOT NULL,
  `descripcion` varchar(40) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 1 COMMENT '0-desactivado 1- activado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `idPregunta` int(11) NOT NULL,
  `idAsignatura` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL COMMENT 'profesor',
  `enunciado` varchar(50) NOT NULL,
  `tipo` int(1) NOT NULL COMMENT '0-texto 1-check 2-drag',
  `ponderacion` int(3) NOT NULL COMMENT '0 - 100'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `idRespuesta` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL COMMENT 'Creador Respuesta',
  `idPregunta` int(11) NOT NULL,
  `respuesta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idRol` int(1) NOT NULL,
  `descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `descripcion`) VALUES
(0, 'Alumno'),
(1, 'Profesor'),
(2, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solucion`
--

CREATE TABLE `solucion` (
  `idSolucion` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL COMMENT 'Alumno',
  `idExamen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(40) NOT NULL COMMENT 'id usuario',
  `email` varchar(50) NOT NULL COMMENT ' ',
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `contrasenia` varchar(32) NOT NULL COMMENT 'MD5',
  `telefono` int(11) NOT NULL,
  `imagen` longblob DEFAULT NULL,
  `activo` int(1) NOT NULL DEFAULT 0 COMMENT '0- desactivado 1-activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `email`, `dni`, `nombre`, `apellidos`, `contrasenia`, `telefono`, `imagen`, `activo`) VALUES
(1, 'fernando@gmail.com', '11111111F', 'Fernando D.', 'Gomez Aranzabe', 'ec89208a20651307b38c51bd4797be60', 111111111, NULL, 0),
(2, 'inmaculada@gmail.com', '22222222I', 'Inmaculada', 'Gijon Cardos', 'ec89208a20651307b38c51bd4797be60', 222222222, NULL, 0),
(3, 'joseLuis@gmail.com', '33333333J', 'Jose Luis', 'Gonzalez Sanchez', 'ec89208a20651307b38c51bd4797be60', 333333333, NULL, 0),
(4, 'diego@gmail.com', '44444444D', 'Diego', 'Cordoba Aguirre', 'ec89208a20651307b38c51bd4797be60', 444444444, NULL, 0),
(5, 'empresas@gmail.com', '55555555E', 'Empresas', 'Iniciativa apellido', 'ec89208a20651307b38c51bd4797be60', 555555555, NULL, 0),
(6, 'isra9movil@hotmail.com', '06280822M', 'Israel', 'Molina Pulpon', 'ec89208a20651307b38c51bd4797be60', 662141178, NULL, 0),
(7, 'maria.juan.vi@gmail.com', '44123254M', 'Maria ', 'Juan Viñas', 'ec89208a20651307b38c51bd4797be60', 456789123, NULL, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignacionasignatura`
--
ALTER TABLE `asignacionasignatura`
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idAsignatura` (`idAsignatura`);

--
-- Indices de la tabla `asignacionpregunta`
--
ALTER TABLE `asignacionpregunta`
  ADD KEY `idExamen` (`idExamen`),
  ADD KEY `idPregunta` (`idPregunta`);

--
-- Indices de la tabla `asignacionrespuesta`
--
ALTER TABLE `asignacionrespuesta`
  ADD KEY `idSolucion` (`idSolucion`),
  ADD KEY `idRespuesta` (`idRespuesta`);

--
-- Indices de la tabla `asignacionrol`
--
ALTER TABLE `asignacionrol`
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idRol` (`idRol`);

--
-- Indices de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD PRIMARY KEY (`idAsignatura`);

--
-- Indices de la tabla `correccion`
--
ALTER TABLE `correccion`
  ADD KEY `idSolucion` (`idSolucion`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `examen`
--
ALTER TABLE `examen`
  ADD PRIMARY KEY (`idExamen`),
  ADD KEY `idAsignatura` (`idAsignatura`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`idPregunta`),
  ADD KEY `idAsignatura` (`idAsignatura`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`idRespuesta`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idPregunta` (`idPregunta`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `solucion`
--
ALTER TABLE `solucion`
  ADD PRIMARY KEY (`idSolucion`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idExamen` (`idExamen`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  MODIFY `idAsignatura` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Id asignatura', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `examen`
--
ALTER TABLE `examen`
  MODIFY `idExamen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `idPregunta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `idRespuesta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idRol` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `solucion`
--
ALTER TABLE `solucion`
  MODIFY `idSolucion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(40) NOT NULL AUTO_INCREMENT COMMENT 'id usuario', AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignacionasignatura`
--
ALTER TABLE `asignacionasignatura`
  ADD CONSTRAINT `asignacionasignatura_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asignacionasignatura_ibfk_2` FOREIGN KEY (`idAsignatura`) REFERENCES `asignatura` (`idAsignatura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `asignacionpregunta`
--
ALTER TABLE `asignacionpregunta`
  ADD CONSTRAINT `asignacionpregunta_ibfk_1` FOREIGN KEY (`idExamen`) REFERENCES `examen` (`idExamen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asignacionpregunta_ibfk_2` FOREIGN KEY (`idPregunta`) REFERENCES `pregunta` (`idPregunta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `asignacionrespuesta`
--
ALTER TABLE `asignacionrespuesta`
  ADD CONSTRAINT `asignacionrespuesta_ibfk_1` FOREIGN KEY (`idRespuesta`) REFERENCES `respuesta` (`idRespuesta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asignacionrespuesta_ibfk_2` FOREIGN KEY (`idSolucion`) REFERENCES `solucion` (`idSolucion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `asignacionrol`
--
ALTER TABLE `asignacionrol`
  ADD CONSTRAINT `asignacionrol_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asignacionrol_ibfk_2` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `correccion`
--
ALTER TABLE `correccion`
  ADD CONSTRAINT `correccion_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `correccion_ibfk_2` FOREIGN KEY (`idSolucion`) REFERENCES `solucion` (`idSolucion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `examen`
--
ALTER TABLE `examen`
  ADD CONSTRAINT `examen_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `examen_ibfk_2` FOREIGN KEY (`idAsignatura`) REFERENCES `asignatura` (`idAsignatura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `pregunta_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pregunta_ibfk_2` FOREIGN KEY (`idAsignatura`) REFERENCES `asignatura` (`idAsignatura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD CONSTRAINT `respuesta_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `respuesta_ibfk_2` FOREIGN KEY (`idPregunta`) REFERENCES `pregunta` (`idPregunta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `solucion`
--
ALTER TABLE `solucion`
  ADD CONSTRAINT `solucion_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `solucion_ibfk_2` FOREIGN KEY (`idExamen`) REFERENCES `examen` (`idExamen`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
