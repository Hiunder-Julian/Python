-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 30-09-2024 a las 20:39:51
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
-- Base de datos: `Moragas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Juego`
--

CREATE TABLE `Juego` (
  `id` int(3) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `imagen` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Juego`
--

INSERT INTO `Juego` (`id`, `nombre`, `imagen`) VALUES
(111, 'BENJA', 'niño3.jpeg'),
(123, 'JUANSITO', 'niño.jpeg'),
(213, 'PEDRO', 'niño2.jpeg'),
(222, 'EMILIA', 'niña2.jpeg'),
(321, 'EVELIN', 'niña1.jpeg'),
(333, 'ALFRED', 'niño4.jpeg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Juego`
--
ALTER TABLE `Juego`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
