-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2020 a las 11:04:30
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdnoodlemoodle`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

CREATE TABLE `asignaturas` (
  `Id` int(11) NOT NULL,
  `NombreAsignatura` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL,
  `CodigoActivacion` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturasmodulos`
--

CREATE TABLE `asignaturasmodulos` (
  `IdAsignatura` int(11) NOT NULL,
  `IdModulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avisos`
--

CREATE TABLE `avisos` (
  `Id` int(11) NOT NULL,
  `IdAlumno` int(11) NOT NULL,
  `IdAsignatura` int(11) NOT NULL,
  `IdModulo` int(11) NOT NULL,
  `IdProfesor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `Id` int(11) NOT NULL,
  `NombreModulo` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `Id` int(11) NOT NULL,
  `NombreRol` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`Id`, `NombreRol`) VALUES
(0, 'administrador'),
(1, 'alumno'),
(2, 'profesor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Apellidos` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Email` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Telefono` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Ciudad` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL,
  `ComunidadAutonoma` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL,
  `IdRol` int(11) NOT NULL,
  `FechaPrimerAcceso` datetime NOT NULL,
  `FechaUltimoAcceso` datetime NOT NULL,
  `Password` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Id`, `Nombre`, `Apellidos`, `Email`, `Telefono`, `Ciudad`, `ComunidadAutonoma`, `IdRol`, `FechaPrimerAcceso`, `FechaUltimoAcceso`, `Password`) VALUES
(36, 'admin', 'admin', 'admin@admin.admin', 'admin', 'admin', 'admin', 0, '2020-11-24 13:42:22', '2020-12-10 10:50:14', '$2y$10$oHoFYHi6uWd9Z8K5SNdWpesYVxSNDYw832tT1lKXlzZgc7YrDQTS.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariosasignaturas`
--

CREATE TABLE `usuariosasignaturas` (
  `IdUsuario` int(11) NOT NULL,
  `IdAsignatura` int(11) NOT NULL,
  `IdModulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariosmodulos`
--

CREATE TABLE `usuariosmodulos` (
  `IdUsuario` int(11) NOT NULL,
  `IdModulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `asignaturasmodulos`
--
ALTER TABLE `asignaturasmodulos`
  ADD PRIMARY KEY (`IdAsignatura`,`IdModulo`),
  ADD KEY `fk_AsignaturasModulos_Modulos` (`IdModulo`),
  ADD KEY `fk_AsignaturasModulos_Asignaturas` (`IdAsignatura`);

--
-- Indices de la tabla `avisos`
--
ALTER TABLE `avisos`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_Avisos_Asignaturas` (`IdAsignatura`),
  ADD KEY `fk_Avisos_Modulos` (`IdModulo`),
  ADD KEY `fk_Avisos_UsuariosA` (`IdAlumno`),
  ADD KEY `fk_Avisos_UsuariosP` (`IdProfesor`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Id`) USING BTREE,
  ADD KEY `fk_Usuarios_Roles` (`IdRol`);

--
-- Indices de la tabla `usuariosasignaturas`
--
ALTER TABLE `usuariosasignaturas`
  ADD PRIMARY KEY (`IdUsuario`,`IdAsignatura`,`IdModulo`),
  ADD KEY `fk_UsuariosAsignaturas_Asignaturas` (`IdAsignatura`),
  ADD KEY `fk_UsuariosAsignaturas_Usuarios` (`IdUsuario`),
  ADD KEY `fk_UsuariosAsignaturas_Modulos` (`IdModulo`);

--
-- Indices de la tabla `usuariosmodulos`
--
ALTER TABLE `usuariosmodulos`
  ADD PRIMARY KEY (`IdUsuario`,`IdModulo`),
  ADD KEY `fk_UsuariosModulos_Modulos` (`IdModulo`),
  ADD KEY `fk_UsuariosModulos_Usuarios` (`IdUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `avisos`
--
ALTER TABLE `avisos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignaturasmodulos`
--
ALTER TABLE `asignaturasmodulos`
  ADD CONSTRAINT `fk_AsignaturasModulos_Asignaturas` FOREIGN KEY (`IdAsignatura`) REFERENCES `asignaturas` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_AsignaturasModulos_Modulos` FOREIGN KEY (`IdModulo`) REFERENCES `modulos` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `avisos`
--
ALTER TABLE `avisos`
  ADD CONSTRAINT `fk_Avisos_Asignaturas` FOREIGN KEY (`IdAsignatura`) REFERENCES `asignaturas` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Avisos_Modulos` FOREIGN KEY (`IdModulo`) REFERENCES `modulos` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Avisos_UsuariosA` FOREIGN KEY (`IdAlumno`) REFERENCES `usuarios` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Avisos_UsuariosP` FOREIGN KEY (`IdProfesor`) REFERENCES `usuarios` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_Usuarios_Roles` FOREIGN KEY (`IdRol`) REFERENCES `roles` (`Id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuariosasignaturas`
--
ALTER TABLE `usuariosasignaturas`
  ADD CONSTRAINT `fk_UsuariosAsignaturas_Asignaturas` FOREIGN KEY (`IdAsignatura`) REFERENCES `asignaturas` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_UsuariosAsignaturas_Modulos` FOREIGN KEY (`idModulo`) REFERENCES `modulos` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_UsuariosAsignaturas_Usuarios` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuariosmodulos`
--
ALTER TABLE `usuariosmodulos`
  ADD CONSTRAINT `fk_UsuariosModulos_Modulos` FOREIGN KEY (`IdModulo`) REFERENCES `modulos` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_UsuariosModulos_Usuarios` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
