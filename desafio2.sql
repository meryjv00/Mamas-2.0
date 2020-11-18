-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2020 a las 10:33:40
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
-- Estructura de tabla para la tabla `asignacionopciones`
--

CREATE TABLE `asignacionopciones` (
  `idPregunta` int(11) NOT NULL,
  `idOpcion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `asignacionopciones`
--

INSERT INTO `asignacionopciones` (`idPregunta`, `idOpcion`) VALUES
(2, 1),
(2, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacionpreguntas`
--

CREATE TABLE `asignacionpreguntas` (
  `idExamen` int(11) NOT NULL,
  `idPregunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `asignacionpreguntas`
--

INSERT INTO `asignacionpreguntas` (`idExamen`, `idPregunta`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes`
--

CREATE TABLE `examenes` (
  `idExamen` int(11) NOT NULL,
  `mailProfesor` varchar(35) NOT NULL,
  `descripcion` varchar(30) NOT NULL,
  `asignatura` varchar(30) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `examenes`
--

INSERT INTO `examenes` (`idExamen`, `mailProfesor`, `descripcion`, `asignatura`, `activo`) VALUES
(1, 'maria.juan.vi@gmail.com', 'Exámen inicial', 'DWEC', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `idEvaluacion` int(11) NOT NULL,
  `mail` varchar(35) NOT NULL,
  `idExamen` int(11) NOT NULL,
  `mailProfesor` varchar(35) NOT NULL,
  `nota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones`
--

CREATE TABLE `opciones` (
  `idOpcion` int(11) NOT NULL,
  `idPregunta` int(11) NOT NULL COMMENT 'Pregunta/respueta enlazada',
  `respuesta` varchar(100) NOT NULL,
  `correcto` int(1) NOT NULL DEFAULT 0 COMMENT '0- invalid 1-Valid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `opciones`
--

INSERT INTO `opciones` (`idOpcion`, `idPregunta`, `respuesta`, `correcto`) VALUES
(1, 0, 'Respuesta 1', 0),
(2, 0, 'Respuesta 2', 1),
(3, 0, 'Respuesta 3', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `idPregunta` int(11) NOT NULL,
  `enunciado` text NOT NULL COMMENT 'Enunciado de la pregunta',
  `tipo` int(2) NOT NULL COMMENT '0-Txt 1-Test 2-Chck',
  `puntuacion` int(2) NOT NULL COMMENT 'Puntuacion 1 a 99',
  `asignatura` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`idPregunta`, `enunciado`, `tipo`, `puntuacion`, `asignatura`) VALUES
(1, '¿Qué es el DOM?', 0, 0, 'DWEC'),
(2, 'Pregunta prueba', 1, 0, 'DWES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `mail` varchar(35) NOT NULL,
  `dni` varchar(15) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `contrasenia` varchar(32) NOT NULL COMMENT 'Cifrado MD5',
  `telefono` varchar(9) NOT NULL,
  `rol` int(1) NOT NULL DEFAULT 0 COMMENT '0-Alu 1-Prof 2-Adm',
  `activo` int(1) NOT NULL DEFAULT 0 COMMENT '0-desactivado 1-activado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`mail`, `dni`, `nombre`, `apellidos`, `contrasenia`, `telefono`, `rol`, `activo`) VALUES
('belen@gmail.com', '06280000c', 'belen', 'navarroi', 'eccb65165b7a4aafdd69cb8dfa564fbd', '659478888', 0, 1),
('fernando@gmail.com', '06280823M', 'fernando', 'aranzabe', 'eccb65165b7a4aafdd69cb8dfa564fbd', '123456789', 0, 0),
('isra9shadow@gmail.com', '05950348Q', 'Israel', 'Molina Pulpon', 'Chubaca2020', '685111156', 0, 1),
('maria.juan.vi@gmail.com', '05980367E', 'María', 'Juan Viñas', 'Chubaca2020', '656877754', 0, 1),
('rebeca@gmail.com', '06280888m', 'rebeca', 'molina', 'eccb65165b7a4aafdd69cb8dfa564fbd', '659888777', 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignacionopciones`
--
ALTER TABLE `asignacionopciones`
  ADD KEY `fk_preguntaEx` (`idPregunta`),
  ADD KEY `fk_opcionEx` (`idOpcion`);

--
-- Indices de la tabla `asignacionpreguntas`
--
ALTER TABLE `asignacionpreguntas`
  ADD KEY `fk_examen` (`idExamen`),
  ADD KEY `fk_preguntaExamen` (`idPregunta`);

--
-- Indices de la tabla `examenes`
--
ALTER TABLE `examenes`
  ADD PRIMARY KEY (`idExamen`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`idEvaluacion`),
  ADD KEY `fk_mailusu` (`mail`),
  ADD KEY `fk_exusu` (`idExamen`);

--
-- Indices de la tabla `opciones`
--
ALTER TABLE `opciones`
  ADD PRIMARY KEY (`idOpcion`),
  ADD KEY `idPregunta` (`idPregunta`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`idPregunta`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`mail`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `examenes`
--
ALTER TABLE `examenes`
  MODIFY `idExamen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `idEvaluacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `opciones`
--
ALTER TABLE `opciones`
  MODIFY `idOpcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `idPregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignacionopciones`
--
ALTER TABLE `asignacionopciones`
  ADD CONSTRAINT `fk_opcionEx` FOREIGN KEY (`idOpcion`) REFERENCES `opciones` (`idOpcion`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_preguntaEx` FOREIGN KEY (`idPregunta`) REFERENCES `preguntas` (`idPregunta`) ON DELETE CASCADE;

--
-- Filtros para la tabla `asignacionpreguntas`
--
ALTER TABLE `asignacionpreguntas`
  ADD CONSTRAINT `fk_examen` FOREIGN KEY (`idExamen`) REFERENCES `examenes` (`idExamen`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_preguntaExamen` FOREIGN KEY (`idPregunta`) REFERENCES `preguntas` (`idPregunta`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `fk_exusu` FOREIGN KEY (`idExamen`) REFERENCES `examenes` (`idExamen`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_mailusu` FOREIGN KEY (`mail`) REFERENCES `usuarios` (`mail`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
