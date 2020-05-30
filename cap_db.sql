-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 30, 2020 at 07:27 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cap_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `control`
--

CREATE TABLE `control` (
  `codigo_control` int(11) NOT NULL,
  `creacion_caja` date NOT NULL,
  `fecha_corte` date DEFAULT NULL,
  `entrada` double NOT NULL,
  `salida` double NOT NULL,
  `caja` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `control`
--

INSERT INTO `control` (`codigo_control`, `creacion_caja`, `fecha_corte`, `entrada`, `salida`, `caja`) VALUES
(332216, '2020-05-30', NULL, 100000, 37500, 112500);

-- --------------------------------------------------------

--
-- Table structure for table `estudiante`
--

CREATE TABLE `estudiante` (
  `identificacion` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `fecha_nacimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `estudiante`
--

INSERT INTO `estudiante` (`identificacion`, `nombre`, `apellidos`, `fecha_nacimiento`) VALUES
(1069493466, 'Gian Carlos', 'Calle', '1994-04-24');

-- --------------------------------------------------------

--
-- Table structure for table `horario`
--

CREATE TABLE `horario` (
  `codigo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `identificacion_tutor_horario` int(11) NOT NULL,
  `semana` varchar(60) NOT NULL,
  `asistencia` tinyint(4) NOT NULL,
  `est_identificacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inscripcion`
--

CREATE TABLE `inscripcion` (
  `codigo_registro` int(11) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `acuerdo_pago` text NOT NULL,
  `horario` varchar(50) NOT NULL,
  `grado` int(11) NOT NULL,
  `costo` double NOT NULL,
  `fecha_pago` date NOT NULL,
  `acudiente_nombre` varchar(70) NOT NULL,
  `acudiente_telefono` varchar(15) NOT NULL,
  `colegio` varchar(500) NOT NULL,
  `estudiante_identificacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inscripcion`
--

INSERT INTO `inscripcion` (`codigo_registro`, `fecha_ingreso`, `acuerdo_pago`, `horario`, `grado`, `costo`, `fecha_pago`, `acudiente_nombre`, `acudiente_telefono`, `colegio`, `estudiante_identificacion`) VALUES
(86674, '2020-05-05', 'Mensual', '14:50', 5, 50000, '2020-06-29', 'Evianys Marcela', '+573013321481', 'Normal Superior L.A.I', 1069493466);

-- --------------------------------------------------------

--
-- Table structure for table `materias`
--

CREATE TABLE `materias` (
  `codigo_materia` int(11) NOT NULL,
  `nombre_materia` varchar(60) NOT NULL,
  `identificacion_estudiante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pagos`
--

CREATE TABLE `pagos` (
  `codigo_pago` int(11) NOT NULL,
  `fecha_pago` date NOT NULL,
  `hora_pago` time NOT NULL,
  `valor_pagado` double NOT NULL,
  `valor_restante` double DEFAULT NULL,
  `codigo_registro_inscripcion` int(11) NOT NULL,
  `codigo_control_pago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pagos`
--

INSERT INTO `pagos` (`codigo_pago`, `fecha_pago`, `hora_pago`, `valor_pagado`, `valor_restante`, `codigo_registro_inscripcion`, `codigo_control_pago`) VALUES
(100020, '2020-05-30', '00:16:00', 50000, 0, 86674, 332216),
(487420, '2020-05-30', '00:17:00', 50000, 0, 86674, 332216);

--
-- Triggers `pagos`
--
DELIMITER $$
CREATE TRIGGER `pagos_after_insert` AFTER INSERT ON `pagos` FOR EACH ROW BEGIN
	UPDATE `control` SET `entrada`= entrada + NEW.valor_pagado, `caja`= entrada + NEW.valor_pagado WHERE `creacion_caja` = (SELECT CURRENT_DATE);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pagos_tutores`
--

CREATE TABLE `pagos_tutores` (
  `control_codigo_control` int(11) NOT NULL,
  `tutor_identificacion` int(11) NOT NULL,
  `valor_pagado` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pagos_tutores`
--

INSERT INTO `pagos_tutores` (`control_codigo_control`, `tutor_identificacion`, `valor_pagado`) VALUES
(332216, 24324234, 37500);

--
-- Triggers `pagos_tutores`
--
DELIMITER $$
CREATE TRIGGER `pagos_tutores_after_insert` AFTER INSERT ON `pagos_tutores` FOR EACH ROW BEGIN
	UPDATE `control` SET `salida`= (salida + NEW.valor_pagado), `caja`= (caja - NEW.valor_pagado) WHERE `creacion_caja` = (SELECT CURRENT_DATE);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tutores`
--

CREATE TABLE `tutores` (
  `identificacion` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `correo` varchar(500) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `direccion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tutores`
--

INSERT INTO `tutores` (`identificacion`, `nombre`, `apellidos`, `correo`, `telefono`, `direccion`) VALUES
(24324234, 'Fernando Jose', 'Mestra Garcia', 'fafayoc696@ximtyl.com', '+573013321481', 'B Renacer Cra 8W 19-46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `control`
--
ALTER TABLE `control`
  ADD PRIMARY KEY (`codigo_control`),
  ADD UNIQUE KEY `creacion_caja_UNIQUE` (`creacion_caja`);

--
-- Indexes for table `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`identificacion`);

--
-- Indexes for table `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `fk_HORARIO_TUTORES_idx` (`identificacion_tutor_horario`),
  ADD KEY `fk_HORARIO_ESTUDIANTE1_idx` (`est_identificacion`);

--
-- Indexes for table `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`codigo_registro`),
  ADD KEY `fk_REGISTRO_INGRESO_ESTUDIANTE1_idx` (`estudiante_identificacion`);

--
-- Indexes for table `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`codigo_materia`),
  ADD KEY `fk_MATERIAS_ESTUDIANTE1_idx` (`identificacion_estudiante`);

--
-- Indexes for table `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`codigo_pago`),
  ADD KEY `fk_PAGOS_INSCRIPCION1_idx` (`codigo_registro_inscripcion`),
  ADD KEY `fk_PAGOS_CONTROL1_idx` (`codigo_control_pago`);

--
-- Indexes for table `pagos_tutores`
--
ALTER TABLE `pagos_tutores`
  ADD KEY `fk_PAGOS_TUTORES_CONTROL1_idx` (`control_codigo_control`),
  ADD KEY `fk_PAGOS_TUTORES_TUTORES1_idx` (`tutor_identificacion`);

--
-- Indexes for table `tutores`
--
ALTER TABLE `tutores`
  ADD PRIMARY KEY (`identificacion`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `control`
--
ALTER TABLE `control`
  MODIFY `codigo_control` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=332217;

--
-- AUTO_INCREMENT for table `horario`
--
ALTER TABLE `horario`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `codigo_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86675;

--
-- AUTO_INCREMENT for table `materias`
--
ALTER TABLE `materias`
  MODIFY `codigo_materia` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `fk_HORARIO_ESTUDIANTE1` FOREIGN KEY (`est_identificacion`) REFERENCES `estudiante` (`identificacion`),
  ADD CONSTRAINT `fk_HORARIO_TUTORES` FOREIGN KEY (`identificacion_tutor_horario`) REFERENCES `tutores` (`identificacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD CONSTRAINT `fk_REGISTRO_INGRESO_ESTUDIANTE1` FOREIGN KEY (`estudiante_identificacion`) REFERENCES `estudiante` (`identificacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `fk_MATERIAS_ESTUDIANTE1` FOREIGN KEY (`identificacion_estudiante`) REFERENCES `estudiante` (`identificacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `fk_PAGOS_CONTROL1` FOREIGN KEY (`codigo_control_pago`) REFERENCES `control` (`codigo_control`),
  ADD CONSTRAINT `fk_PAGOS_INSCRIPCION1` FOREIGN KEY (`codigo_registro_inscripcion`) REFERENCES `inscripcion` (`codigo_registro`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pagos_tutores`
--
ALTER TABLE `pagos_tutores`
  ADD CONSTRAINT `fk_PAGOS_TUTORES_CONTROL1` FOREIGN KEY (`control_codigo_control`) REFERENCES `control` (`codigo_control`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_PAGOS_TUTORES_TUTORES1` FOREIGN KEY (`tutor_identificacion`) REFERENCES `tutores` (`identificacion`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
