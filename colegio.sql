-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-04-2025 a las 23:00:20
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `colegio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id_curso` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `horario` varchar(50) DEFAULT NULL,
  `cupo_maximo` int(11) DEFAULT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id_curso`, `nombre`, `descripcion`, `horario`, `cupo_maximo`, `estado`) VALUES
(1, 'Matemáticas Avanzadas', 'Estudio avanzado de álgebra y geometría', 'Lunes 9:00-11:00', 25, 'activo'),
(2, 'Historia Contemporánea', 'Análisis de los eventos recientes en la historia mundial', 'Martes 10:00-12:00', 30, 'activo'),
(3, 'Biología Molecular', 'Estudio de la biología a nivel celular y molecular', 'Miércoles 8:00-10:00', 20, 'activo'),
(4, 'Química Orgánica', 'Introducción a los compuestos orgánicos y sus reacciones', 'Jueves 11:00-13:00', 25, 'activo'),
(5, 'Física Aplicada', 'Aplicación de conceptos de física a problemas reales', 'Viernes 9:00-11:00', 20, 'activo'),
(6, 'Educación Ambiental', 'Estudio de prácticas sostenibles y conservación del medioambiente', 'Lunes 11:00-13:00', 30, 'activo'),
(7, 'Programación Básica', 'Curso introductorio a lenguajes de programación como Python', 'Martes 13:00-15:00', 20, 'activo'),
(8, 'Arte Digital', 'Diseño y creación de contenido digital', 'Miércoles 10:00-12:00', 15, 'activo'),
(9, 'Economía General', 'Conceptos básicos de economía y su aplicación', 'Jueves 9:00-11:00', 25, 'activo'),
(10, 'Psicología Social', 'Exploración del comportamiento humano en contextos sociales', 'Viernes 10:00-12:00', 20, 'activo'),
(11, 'Inglés Intermedio', 'Desarrollo de habilidades de comunicación en inglés', 'Lunes 8:00-10:00', 20, 'activo'),
(12, 'Redacción y Escritura', 'Técnicas para escribir textos creativos y académicos', 'Martes 12:00-14:00', 25, 'activo'),
(13, 'Geografía Física', 'Estudio de características físicas del planeta', 'Miércoles 8:00-10:00', 20, 'activo'),
(14, 'Química Inorgánica', 'Estudio de elementos y compuestos inorgánicos', 'Jueves 10:00-12:00', 25, 'activo'),
(15, 'Filosofía Moderna', 'Análisis de los pensadores modernos y su impacto', 'Viernes 11:00-13:00', 20, 'activo'),
(16, 'Astronomía Básica', 'Introducción al estudio del universo', 'Lunes 14:00-16:00', 30, 'activo'),
(17, 'Música y Ritmo', 'Exploración de instrumentos y teoría musical', 'Martes 11:00-13:00', 20, 'activo'),
(18, 'Historia de Bolivia', 'Análisis de los eventos históricos en Bolivia', 'Miércoles 13:00-15:00', 25, 'activo'),
(19, 'Matemáticas Básicas', 'Fundamentos de cálculo y aritmética', 'Jueves 9:00-11:00', 30, 'activo'),
(20, 'Sociología Básica', 'Estudio de sociedades y estructuras sociales', 'Viernes 14:00-16:00', 20, 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id_estudiante` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`id_estudiante`, `nombre`, `apellido`, `fecha_nacimiento`, `direccion`, `telefono`, `fecha_registro`) VALUES
(1, 'Carlos', 'Lopez', '2009-06-25', 'Av. Principal 123, La Paz', '7654321', '2025-04-15 20:37:07'),
(2, 'Sofia', 'Martinez', '2010-03-15', 'Calle Secundaria 45, El Alto', '7345612', '2025-04-15 20:37:07'),
(3, 'Luis', 'Rodriguez', '2011-09-07', 'Av. Sucre 91, Cochabamba', '7432156', '2025-04-15 20:37:07'),
(4, 'Ana', 'Fernandez', '2008-12-20', 'Av. Montes 33, Santa Cruz', '7654328', '2025-04-15 20:37:07'),
(5, 'Javier', 'Gonzalez', '2009-07-10', 'Calle Bolívar 19, Tarija', '7345196', '2025-04-15 20:37:07'),
(6, 'Mariana', 'Gutierrez', '2010-02-28', 'Av. América 71, La Paz', '7654325', '2025-04-15 20:37:07'),
(7, 'Pedro', 'Quiroga', '2011-11-13', 'Av. Pando 101, Cochabamba', '7432159', '2025-04-15 20:37:07'),
(8, 'Carmen', 'Sanchez', '2009-05-30', 'Av. Ayacucho 15, El Alto', '7345114', '2025-04-15 20:37:07'),
(9, 'Alejandro', 'Flores', '2008-10-11', 'Av. Central 50, La Paz', '7654311', '2025-04-15 20:37:07'),
(10, 'Lucía', 'Vargas', '2011-04-17', 'Av. Colón 44, Potosí', '7456123', '2025-04-15 20:37:07'),
(11, 'Victoria', 'Ramirez', '2010-08-24', 'Calle Real 98, Sucre', '7345123', '2025-04-15 20:37:07'),
(12, 'Ismael', 'Guzman', '2009-01-06', 'Av. Independencia 73, Oruro', '7654332', '2025-04-15 20:37:07'),
(13, 'Andrea', 'Velasco', '2008-09-29', 'Av. Primavera 31, Santa Cruz', '7345987', '2025-04-15 20:37:07'),
(14, 'Oscar', 'Delgado', '2010-06-14', 'Calle Comercio 15, Tarija', '7654123', '2025-04-15 20:37:07'),
(15, 'Gabriela', 'Hernandez', '2009-04-22', 'Av. Camacho 22, La Paz', '7345234', '2025-04-15 20:37:07'),
(16, 'Daniel', 'Rivera', '2011-07-05', 'Calle Murillo 17, Cochabamba', '7432579', '2025-04-15 20:37:07'),
(17, 'Paola', 'Arce', '2009-02-13', 'Av. República 60, El Alto', '7345194', '2025-04-15 20:37:07'),
(18, 'Miguel', 'Muñoz', '2008-11-21', 'Av. Melchor 88, Oruro', '7456121', '2025-04-15 20:37:07'),
(19, 'Verónica', 'Villalobos', '2010-03-09', 'Av. Centenario 23, Potosí', '7345125', '2025-04-15 20:37:07'),
(20, 'Ricardo', 'Espinoza', '2009-09-18', 'Calle Progreso 11, Sucre', '7345178', '2025-04-15 20:37:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `id_inscripcion` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `fecha_inscripcion` date NOT NULL,
  `estado` enum('activa','cancelada') DEFAULT 'activa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `inscripciones`
--

INSERT INTO `inscripciones` (`id_inscripcion`, `id_estudiante`, `id_curso`, `fecha_inscripcion`, `estado`) VALUES
(1, 1, 1, '2023-01-15', 'cancelada'),
(2, 2, 2, '2023-01-16', 'activa'),
(3, 3, 3, '2023-01-17', 'activa'),
(4, 4, 4, '2023-01-18', 'activa'),
(5, 5, 5, '2023-01-19', 'cancelada'),
(6, 6, 6, '2023-01-20', 'activa'),
(7, 7, 7, '2023-01-21', 'cancelada'),
(8, 8, 8, '2023-01-22', 'activa'),
(9, 9, 9, '2023-01-23', 'activa'),
(10, 10, 10, '2023-01-24', 'cancelada'),
(11, 11, 1, '2023-02-01', 'activa'),
(12, 12, 2, '2023-02-02', 'activa'),
(13, 13, 3, '2023-02-03', 'activa'),
(14, 14, 4, '2023-02-04', 'cancelada'),
(15, 15, 5, '2023-02-05', 'activa'),
(16, 16, 6, '2023-02-06', 'activa'),
(17, 17, 7, '2023-02-07', 'activa'),
(18, 18, 8, '2023-02-08', 'activa'),
(19, 19, 9, '2023-02-09', 'activa'),
(20, 20, 10, '2023-02-10', 'cancelada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `id_nota` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `nota` decimal(5,2) NOT NULL,
  `fecha_nota` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `notas`
--

INSERT INTO `notas` (`id_nota`, `id_estudiante`, `id_curso`, `nota`, `fecha_nota`) VALUES
(1, 1, 1, '87.50', '2023-03-10'),
(2, 2, 2, '92.00', '2023-03-12'),
(3, 3, 3, '85.25', '2023-03-14'),
(4, 4, 4, '78.00', '2023-03-15'),
(5, 5, 5, '89.50', '2023-03-16'),
(6, 6, 6, '95.00', '2023-03-18'),
(7, 7, 7, '74.25', '2023-03-20'),
(8, 8, 8, '88.75', '2023-03-22'),
(9, 9, 9, '91.00', '2023-03-24'),
(10, 10, 10, '76.50', '2023-03-26'),
(11, 11, 1, '83.00', '2023-03-28'),
(12, 12, 2, '85.75', '2023-03-30'),
(13, 13, 3, '88.00', '2023-04-01'),
(14, 14, 4, '72.50', '2023-04-03'),
(15, 15, 5, '90.00', '2023-04-05'),
(16, 16, 6, '75.25', '2023-04-07'),
(17, 17, 7, '82.00', '2023-04-09'),
(18, 18, 8, '78.75', '2023-04-11'),
(19, 19, 9, '85.00', '2023-04-13'),
(20, 20, 10, '93.25', '2023-04-15');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id_curso`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id_estudiante`);

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`id_inscripcion`),
  ADD KEY `id_estudiante` (`id_estudiante`),
  ADD KEY `id_curso` (`id_curso`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id_nota`),
  ADD KEY `id_estudiante` (`id_estudiante`),
  ADD KEY `id_curso` (`id_curso`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id_estudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `id_inscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD CONSTRAINT `inscripciones_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id_estudiante`) ON DELETE CASCADE,
  ADD CONSTRAINT `inscripciones_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id_estudiante`) ON DELETE CASCADE,
  ADD CONSTRAINT `notas_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
