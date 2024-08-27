-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-08-2024 a las 04:26:29
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
-- Base de datos: `reclamos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id` int(11) NOT NULL,
  `Usename` varchar(50) NOT NULL,
  `contrasena` varchar(50) NOT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id`, `Usename`, `contrasena`, `estado`) VALUES
(1, 'admin', 'qwerty', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `idEstado` int(11) NOT NULL,
  `nomEstado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`idEstado`, `nomEstado`) VALUES
(1, 1),
(2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facultad`
--

CREATE TABLE `facultad` (
  `idFacultad` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facultad`
--

INSERT INTO `facultad` (`idFacultad`, `nombre`) VALUES
(1, 'Facultad de Ingeniería'),
(2, 'Facultad de Ciencias Sociales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario`
--

CREATE TABLE `formulario` (
  `idForm` int(11) NOT NULL,
  `calificacion` varchar(50) NOT NULL,
  `tiempoRespuesta` int(11) DEFAULT NULL,
  `resuelto` varchar(10) DEFAULT NULL,
  `dificultad` varchar(250) DEFAULT NULL,
  `sugerenciasMejora` text DEFAULT NULL,
  `informado` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `formulario`
--

INSERT INTO `formulario` (`idForm`, `calificacion`, `tiempoRespuesta`, `resuelto`, `dificultad`, `sugerenciasMejora`, `informado`) VALUES
(4, 'Poco Satisfecho', 8, 'S', 'si', 'todo', 'N'),
(5, 'Neutral', 6, 'S', 'ninguna', 'nada', 'N'),
(6, 'Poco Satisfecho', 8, 'Si', 'ninguna', 'nada', 'No'),
(7, 'Nada Satisfecho', 4, 'Si', 'ninguna', 'su sistema de tramites', 'Si'),
(8, 'Nada Satisfecho', 4, 'Si', 'ninguna', 'aea', 'Si'),
(9, 'Poco Satisfecho', 20, 'No', 'ninguna', 'aea', 'No'),
(10, 'Poco Satisfecho', 20, 'Si', 'ninguna', 'qwerty', 'No'),
(11, 'Poco Satisfecho', 20, 'No', 'ninguna', 'asd', 'Si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivo`
--

CREATE TABLE `motivo` (
  `idMotivo` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `motivo`
--

INSERT INTO `motivo` (`idMotivo`, `nombre`) VALUES
(1, 'Error administrativo'),
(2, 'Mal servicio'),
(3, 'Desacuerdo con nota');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitante`
--

CREATE TABLE `solicitante` (
  `dni` varchar(8) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `domicilio` varchar(255) DEFAULT NULL,
  `codigoEstudiante` varchar(20) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitante`
--

INSERT INTO `solicitante` (`dni`, `nombre`, `apellidos`, `correo`, `telefono`, `domicilio`, `codigoEstudiante`, `contrasena`) VALUES
('12345678', 'Carlos', 'Lopez', 'carlos@example.com', '987654321', 'Av. Siempre Viva 123', 'U20210001', 'pass123'),
('45678901', 'Juan', 'Garcia', 'juan@example.com', '987654323', 'Av. Siempre Viva 125', 'U20210003', 'pass789'),
('87654321', 'Maria', 'Perez', 'maria@example.com', '987654322', 'Av. Siempre Viva 124', 'U20210002', 'pass456');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

CREATE TABLE `solicitud` (
  `idSolicitud` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud`
--

INSERT INTO `solicitud` (`idSolicitud`, `nombre`) VALUES
(1, 'Cambio de horario de clase'),
(2, 'Revisión de nota final'),
(3, 'Reclamo por servicio académico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariosolicitante`
--

CREATE TABLE `usuariosolicitante` (
  `idSolicitante` int(11) NOT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `idSolicitud` int(11) DEFAULT NULL,
  `idFacultad` int(11) DEFAULT NULL,
  `idMotivo` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `idEstado` int(11) DEFAULT NULL,
  `Codigo` varchar(8) DEFAULT NULL,
  `evidencia` longblob DEFAULT NULL,
  `Observacion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuariosolicitante`
--

INSERT INTO `usuariosolicitante` (`idSolicitante`, `dni`, `idSolicitud`, `idFacultad`, `idMotivo`, `descripcion`, `fecha`, `hora`, `idEstado`, `Codigo`, `evidencia`, `Observacion`) VALUES
(1, '12345678', 1, 1, 1, 'Solicito cambio de horario por superposición de materias.', '2022-03-15', '10:00:00', 1, 'A1001', NULL, ''),
(2, '12345678', 2, 2, 2, 'La nota final no coincide con la nota publicada.', '2023-04-20', '11:00:00', 2, 'A1002', NULL, ''),
(3, '87654321', 3, 1, 3, 'Reclamo por mal servicio en la administración.', '2021-05-10', '09:30:00', 1, 'A1003', NULL, ''),
(4, '45678901', 1, 2, 1, 'Error en el registro de asignaturas.', '2024-01-25', '08:15:00', 2, 'A1004', NULL, ''),
(5, '87654321', 3, 1, 2, 'Desacuerdo con la nota final.', '2024-02-14', '12:45:00', 1, 'A1005', NULL, ''),
(6, '12345678', 2, 2, 1, 'Falta de información sobre el proceso.', '2020-08-07', '14:00:00', 2, 'A1006', NULL, ''),
(7, '45678901', 1, 1, 3, 'Problema con la asignación de horarios.', '2019-07-12', '13:30:00', 1, 'A1007', NULL, ''),
(8, '87654321', 2, 2, 2, 'Error en la inscripción de cursos.', '2020-09-03', '15:00:00', 2, 'A1008', NULL, ''),
(9, '45678901', 3, 1, 1, 'Reclamo por demora en la atención.', '2021-10-05', '16:30:00', 1, 'A1009', NULL, ''),
(10, '12345678', 1, 2, 3, 'Cambio de turno no procesado.', '2019-11-21', '17:45:00', 2, 'A1010', NULL, ''),
(11, '87654321', 2, 1, 1, 'Reclamo por nota injusta.', '2023-06-18', '18:00:00', 1, 'A1011', NULL, ''),
(12, '45678901', 3, 2, 2, 'Queja por falta de respuesta.', '2022-07-23', '19:15:00', 2, 'A1012', NULL, ''),
(13, '12345678', 1, 1, 3, 'Problema con el registro de notas.', '2024-08-30', '20:30:00', 1, 'A1013', NULL, ''),
(14, '87654321', 2, 2, 1, 'Error en la matrícula.', '2022-02-19', '21:45:00', 2, 'A1014', NULL, ''),
(15, '45678901', 3, 1, 2, 'Reclamo por mal servicio en la secretaría.', '2023-03-27', '22:00:00', 1, 'A1015', NULL, '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`idEstado`);

--
-- Indices de la tabla `facultad`
--
ALTER TABLE `facultad`
  ADD PRIMARY KEY (`idFacultad`);

--
-- Indices de la tabla `formulario`
--
ALTER TABLE `formulario`
  ADD PRIMARY KEY (`idForm`);

--
-- Indices de la tabla `motivo`
--
ALTER TABLE `motivo`
  ADD PRIMARY KEY (`idMotivo`);

--
-- Indices de la tabla `solicitante`
--
ALTER TABLE `solicitante`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD PRIMARY KEY (`idSolicitud`);

--
-- Indices de la tabla `usuariosolicitante`
--
ALTER TABLE `usuariosolicitante`
  ADD PRIMARY KEY (`idSolicitante`),
  ADD KEY `dni` (`dni`),
  ADD KEY `idSolicitud` (`idSolicitud`),
  ADD KEY `idFacultad` (`idFacultad`),
  ADD KEY `idEstado` (`idEstado`),
  ADD KEY `idMotivo` (`idMotivo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `idEstado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `facultad`
--
ALTER TABLE `facultad`
  MODIFY `idFacultad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `formulario`
--
ALTER TABLE `formulario`
  MODIFY `idForm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `motivo`
--
ALTER TABLE `motivo`
  MODIFY `idMotivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  MODIFY `idSolicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuariosolicitante`
--
ALTER TABLE `usuariosolicitante`
  MODIFY `idSolicitante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuariosolicitante`
--
ALTER TABLE `usuariosolicitante`
  ADD CONSTRAINT `usuariosolicitante_ibfk_1` FOREIGN KEY (`dni`) REFERENCES `solicitante` (`dni`),
  ADD CONSTRAINT `usuariosolicitante_ibfk_2` FOREIGN KEY (`idSolicitud`) REFERENCES `solicitud` (`idSolicitud`),
  ADD CONSTRAINT `usuariosolicitante_ibfk_3` FOREIGN KEY (`idFacultad`) REFERENCES `facultad` (`idFacultad`),
  ADD CONSTRAINT `usuariosolicitante_ibfk_4` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`),
  ADD CONSTRAINT `usuariosolicitante_ibfk_5` FOREIGN KEY (`idMotivo`) REFERENCES `motivo` (`idMotivo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
