-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para gestion_clinica
DROP DATABASE IF EXISTS `gestion_clinica`;
CREATE DATABASE IF NOT EXISTS `gestion_clinica` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `gestion_clinica`;

-- Volcando estructura para tabla gestion_clinica.camas
DROP TABLE IF EXISTS `camas`;
CREATE TABLE IF NOT EXISTS `camas` (
  `cama_id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_cama` varchar(10) DEFAULT NULL,
  `ubicacion` varchar(100) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cama_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gestion_clinica.camas: ~0 rows (aproximadamente)

-- Volcando estructura para tabla gestion_clinica.citas
DROP TABLE IF EXISTS `citas`;
CREATE TABLE IF NOT EXISTS `citas` (
  `cita_id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `hora` int(11) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `medico_id` int(11) DEFAULT NULL,
  `paciente_id` int(11) DEFAULT NULL,
  `servicio_id` int(11) DEFAULT NULL,
  `id_turno` int(11) DEFAULT NULL,
  `transaccion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cita_id`),
  UNIQUE KEY `unica_cita` (`fecha`,`hora`) USING BTREE,
  KEY `servicio_id` (`servicio_id`),
  KEY `citas_ibfk_1` (`paciente_id`),
  KEY `FK_citas_medicos` (`medico_id`),
  KEY `FK_citas_horas` (`hora`),
  KEY `id_turno` (`id_turno`),
  CONSTRAINT `FK_citas_horas` FOREIGN KEY (`hora`) REFERENCES `horas` (`id_hora`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_citas_medicos` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_citas_pacientes` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`paciente_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_citas_servicios_medicos` FOREIGN KEY (`servicio_id`) REFERENCES `servicios_medicos` (`servicio_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_citas_turno` FOREIGN KEY (`id_turno`) REFERENCES `turno` (`id_turno`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gestion_clinica.citas: ~7 rows (aproximadamente)
INSERT INTO `citas` (`cita_id`, `fecha`, `hora`, `estado`, `medico_id`, `paciente_id`, `servicio_id`, `id_turno`, `transaccion`) VALUES
	(1, '2024-11-09', 3, 'Agendado', 16, 8, 1, 1, NULL),
	(2, '2024-11-09', 1, 'Agendado', 16, 8, 1, 1, NULL),
	(3, '2024-11-09', 2, 'Agendado', 16, 8, 1, 1, NULL),
	(4, '2024-11-09', NULL, 'No Agendada', NULL, 8, 1, 1, NULL),
	(5, '2024-11-09', NULL, 'No Agendada', NULL, 8, 1, 1, NULL),
	(6, '2024-11-18', 3, 'Agendado', 19, 9, 1, 1, 'No Pagado'),
	(7, '2024-11-19', NULL, 'No Agendada', NULL, 9, 1, 1, NULL);

-- Volcando estructura para procedimiento gestion_clinica.ConsultarCitas
DROP PROCEDURE IF EXISTS `ConsultarCitas`;
DELIMITER //
CREATE PROCEDURE `ConsultarCitas`()
BEGIN
	SELECT citas.cita_id,
      pacientes.paciente_id,
      usuarios.nombre AS Paciente,
      servicios_medicos.nombre_servicio AS Servicio
      FROM citas
      LEFT JOIN pacientes ON pacientes.paciente_id = citas.paciente_id
      LEFT JOIN servicios_medicos ON servicios_medicos.servicio_id = citas.servicio_id
		LEFT JOIN usuarios ON usuarios.usuario_id = pacientes.usuario_id 
		WHERE estado LIKE 'No Agendada';
END//
DELIMITER ;

-- Volcando estructura para procedimiento gestion_clinica.ConsultarCitasPorPaciente
DROP PROCEDURE IF EXISTS `ConsultarCitasPorPaciente`;
DELIMITER //
CREATE PROCEDURE `ConsultarCitasPorPaciente`(
	IN `_cedula` VARCHAR(50)
)
BEGIN
	SELECT s.nombre_servicio AS Servicio,
	c.fecha AS Fecha,
	h.hora AS Hora,
	c.cita_id,
	u.nombre AS Paciente
	FROM pacientes AS p
	LEFT JOIN citas AS c ON c.paciente_id = p.paciente_id
	LEFT JOIN servicios_medicos AS s ON s.servicio_id = c.servicio_id
	LEFT JOIN usuarios AS u ON u.usuario_id = p.usuario_id
	LEFT JOIN horas AS h ON h.id_hora = c.hora
	WHERE p.cedula LIKE _cedula AND c.estado LIKE 'Agendado';
END//
DELIMITER ;

-- Volcando estructura para procedimiento gestion_clinica.ConsultarHorasDisponibles
DROP PROCEDURE IF EXISTS `ConsultarHorasDisponibles`;
DELIMITER //
CREATE PROCEDURE `ConsultarHorasDisponibles`(
	IN `_id_medico` INT,
	IN `_id_turno` INT
)
BEGIN
	SELECT 
	t.turno,
	h.hora,
	h.id_hora
	FROM horas AS h
	LEFT JOIN turno AS t ON t.id_turno = h.id_turno
	LEFT JOIN citas AS c ON c.hora = h.id_hora AND c.medico_id = _id_medico
	WHERE h.id_turno = _id_turno AND c.hora IS NULL;
END//
DELIMITER ;

-- Volcando estructura para procedimiento gestion_clinica.ConsultarMedicoDisponible
DROP PROCEDURE IF EXISTS `ConsultarMedicoDisponible`;
DELIMITER //
CREATE PROCEDURE `ConsultarMedicoDisponible`(
	IN `_turno` INT,
	IN `_dia` DATE
)
BEGIN
	SELECT distinct
	u.usuario_id, 
	u.nombre
	FROM medicos AS m
	LEFT JOIN usuarios AS u ON u.usuario_id = m.usuario_id
	LEFT JOIN horario AS h ON h.id_medico = m.usuario_id
	LEFT JOIN citas AS c ON c.medico_id = m.usuario_id
	WHERE h.id_turno = _turno AND h.dia = _dia;
END//
DELIMITER ;

-- Volcando estructura para procedimiento gestion_clinica.Consultar_Citas_Del_Dia
DROP PROCEDURE IF EXISTS `Consultar_Citas_Del_Dia`;
DELIMITER //
CREATE PROCEDURE `Consultar_Citas_Del_Dia`(
	IN `_medico_id` INT
)
BEGIN
    SELECT 
        pacientes.paciente_id AS paciente_id, -- Agregar el paciente_id
        pacientes.cedula AS Cedula,
        usuarios.nombre AS Paciente,
        citas.hora
    FROM citas
    LEFT JOIN pacientes ON pacientes.paciente_id = citas.paciente_id
    LEFT JOIN usuarios ON usuarios.usuario_id = pacientes.usuario_id 
    WHERE medico_id = _medico_id 
	 AND citas.fecha = CURDATE()
	 AND citas.estado = 'Agendado';
END//
DELIMITER ;

-- Volcando estructura para procedimiento gestion_clinica.Consultar_Proximas_Citas
DROP PROCEDURE IF EXISTS `Consultar_Proximas_Citas`;
DELIMITER //
CREATE PROCEDURE `Consultar_Proximas_Citas`(
	IN `_medico_id` INT
)
BEGIN
SELECT 
    pacientes.cedula AS Cedula,
    usuarios.nombre AS Paciente,
    citas.hora
FROM citas
LEFT JOIN pacientes ON pacientes.paciente_id = citas.paciente_id
LEFT JOIN usuarios ON usuarios.usuario_id = pacientes.usuario_id
WHERE citas.medico_id = _medico_id 
  AND citas.fecha > CURDATE()
  AND citas.estado = 'Agendado'
ORDER BY citas.fecha ASC, citas.hora ASC;
END//
DELIMITER ;

-- Volcando estructura para tabla gestion_clinica.datos_medicos
DROP TABLE IF EXISTS `datos_medicos`;
CREATE TABLE IF NOT EXISTS `datos_medicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paciente_id` int(11) NOT NULL,
  `altura` decimal(5,2) DEFAULT NULL,
  `peso` decimal(5,2) DEFAULT NULL,
  `tipo_sangre` varchar(3) DEFAULT NULL,
  `alergias` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `paciente_id` (`paciente_id`),
  CONSTRAINT `datos_medicos_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`paciente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gestion_clinica.datos_medicos: ~3 rows (aproximadamente)
INSERT INTO `datos_medicos` (`id`, `paciente_id`, `altura`, `peso`, `tipo_sangre`, `alergias`) VALUES
	(19, 8, 120.00, 3.00, 'O+', 'al queso'),
	(20, 8, 120.00, 3.00, 'O+', 'al queso'),
	(21, 8, 120.00, 3.00, 'O+', 'al queso');

-- Volcando estructura para tabla gestion_clinica.diagnosticos
DROP TABLE IF EXISTS `diagnosticos`;
CREATE TABLE IF NOT EXISTS `diagnosticos` (
  `diagnostico_id` int(11) NOT NULL AUTO_INCREMENT,
  `historial_id` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_diagnostico` datetime DEFAULT current_timestamp(),
  `paciente_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`diagnostico_id`),
  KEY `historial_id` (`historial_id`),
  KEY `fk_paciente` (`paciente_id`),
  CONSTRAINT `diagnosticos_ibfk_1` FOREIGN KEY (`historial_id`) REFERENCES `historial_clinico` (`historial_id`),
  CONSTRAINT `fk_paciente` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`paciente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gestion_clinica.diagnosticos: ~3 rows (aproximadamente)
INSERT INTO `diagnosticos` (`diagnostico_id`, `historial_id`, `descripcion`, `fecha_diagnostico`, `paciente_id`) VALUES
	(21, 20, 'dolor de muelas', '2024-11-01 02:04:33', 8),
	(22, 21, 'dolor de muelas', '2024-11-06 14:07:25', 8),
	(23, 22, 'dolor de muelas', '2024-11-06 14:08:48', 8);

-- Volcando estructura para tabla gestion_clinica.facturas
DROP TABLE IF EXISTS `facturas`;
CREATE TABLE IF NOT EXISTS `facturas` (
  `factura_id` int(11) NOT NULL AUTO_INCREMENT,
  `paciente_id` int(11) DEFAULT NULL,
  `fecha_emision` datetime DEFAULT current_timestamp(),
  `monto` decimal(10,2) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`factura_id`),
  KEY `paciente_id` (`paciente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gestion_clinica.facturas: ~1 rows (aproximadamente)
INSERT INTO `facturas` (`factura_id`, `paciente_id`, `fecha_emision`, `monto`, `estado`) VALUES
	(5, 8, '2024-11-02 19:13:13', 30.00, 'Pagado');

-- Volcando estructura para tabla gestion_clinica.farmacia
DROP TABLE IF EXISTS `farmacia`;
CREATE TABLE IF NOT EXISTS `farmacia` (
  `suministro_id` int(11) NOT NULL AUTO_INCREMENT,
  `medicamento_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha_suministro` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`suministro_id`),
  KEY `medicamento_id` (`medicamento_id`),
  CONSTRAINT `farmacia_ibfk_1` FOREIGN KEY (`medicamento_id`) REFERENCES `medicamentos` (`medicamento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gestion_clinica.farmacia: ~0 rows (aproximadamente)

-- Volcando estructura para tabla gestion_clinica.historial_clinico
DROP TABLE IF EXISTS `historial_clinico`;
CREATE TABLE IF NOT EXISTS `historial_clinico` (
  `historial_id` int(11) NOT NULL AUTO_INCREMENT,
  `paciente_id` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`historial_id`),
  KEY `paciente_id` (`paciente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gestion_clinica.historial_clinico: ~3 rows (aproximadamente)
INSERT INTO `historial_clinico` (`historial_id`, `paciente_id`, `fecha_creacion`) VALUES
	(20, 8, '2024-11-01 02:04:33'),
	(21, 8, '2024-11-06 14:07:25'),
	(22, 8, '2024-11-06 14:08:48');

-- Volcando estructura para tabla gestion_clinica.horario
DROP TABLE IF EXISTS `horario`;
CREATE TABLE IF NOT EXISTS `horario` (
  `id_horario` int(11) NOT NULL AUTO_INCREMENT,
  `dia` date DEFAULT NULL,
  `id_medico` int(11) DEFAULT NULL,
  `id_turno` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_horario`),
  UNIQUE KEY `unico_dia_turno` (`id_turno`,`dia`) USING BTREE,
  KEY `id_medico` (`id_medico`),
  KEY `id_turno` (`id_turno`) USING BTREE,
  CONSTRAINT `FK_horario_medicos` FOREIGN KEY (`id_medico`) REFERENCES `medicos` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_horario_turno` FOREIGN KEY (`id_turno`) REFERENCES `turno` (`id_turno`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gestion_clinica.horario: ~3 rows (aproximadamente)
INSERT INTO `horario` (`id_horario`, `dia`, `id_medico`, `id_turno`) VALUES
	(1, '2024-11-09', 16, 1),
	(11, '2024-11-09', 16, 2),
	(15, '2024-11-18', 19, 1);

-- Volcando estructura para tabla gestion_clinica.horas
DROP TABLE IF EXISTS `horas`;
CREATE TABLE IF NOT EXISTS `horas` (
  `id_hora` int(11) NOT NULL AUTO_INCREMENT,
  `hora` varchar(50) DEFAULT NULL,
  `id_turno` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_hora`),
  KEY `id_turno` (`id_turno`),
  CONSTRAINT `FK__turno` FOREIGN KEY (`id_turno`) REFERENCES `turno` (`id_turno`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gestion_clinica.horas: ~10 rows (aproximadamente)
INSERT INTO `horas` (`id_hora`, `hora`, `id_turno`) VALUES
	(1, '8:00', 1),
	(2, '9:00', 1),
	(3, '10:00', 1),
	(4, '11:00', 1),
	(5, '12:00', 1),
	(6, '1:00', 2),
	(7, '2:00', 2),
	(8, '3:00', 2),
	(9, '4:00', 2),
	(10, '5:00', 2);

-- Volcando estructura para tabla gestion_clinica.insumos
DROP TABLE IF EXISTS `insumos`;
CREATE TABLE IF NOT EXISTS `insumos` (
  `insumo_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `unidad` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`insumo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gestion_clinica.insumos: ~5 rows (aproximadamente)
INSERT INTO `insumos` (`insumo_id`, `nombre`, `cantidad`, `unidad`) VALUES
	(1, 'Jeringas', 100, 'unidad'),
	(4, 'Mascarillas quirúrgicas', 100, 'unidades'),
	(5, 'Batas desechables', 100, 'unidades'),
	(6, 'Guantes de látex', 100, 'pares'),
	(7, 'Suturas', 20, 'unidades');

-- Volcando estructura para tabla gestion_clinica.medicamentos
DROP TABLE IF EXISTS `medicamentos`;
CREATE TABLE IF NOT EXISTS `medicamentos` (
  `medicamento_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `unidad` varchar(50) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `tratamiento` varchar(50) DEFAULT NULL,
  `id_padecimiento` int(11) DEFAULT NULL,
  PRIMARY KEY (`medicamento_id`),
  KEY `id_padecimiento` (`id_padecimiento`),
  CONSTRAINT `FK_medicamentos_padecimiento` FOREIGN KEY (`id_padecimiento`) REFERENCES `padecimiento` (`id_padecimiento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gestion_clinica.medicamentos: ~4 rows (aproximadamente)
INSERT INTO `medicamentos` (`medicamento_id`, `nombre`, `cantidad`, `unidad`, `tipo`, `tratamiento`, `id_padecimiento`) VALUES
	(1, 'Paracetamol', 100, 'mg', NULL, NULL, 1),
	(2, 'Ibuprofeno', 20, 'mg', NULL, NULL, 1),
	(3, 'Amoxilicina', 50, 'mg', NULL, NULL, 1),
	(4, 'Aspirina', 20, 'mg', NULL, NULL, 1);

-- Volcando estructura para tabla gestion_clinica.medicos
DROP TABLE IF EXISTS `medicos`;
CREATE TABLE IF NOT EXISTS `medicos` (
  `medico_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `especialidad` int(11) DEFAULT NULL,
  `no_licencia_medica` varchar(100) DEFAULT NULL,
  `anio_experiencia` int(11) DEFAULT NULL,
  `institucion` varchar(100) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`medico_id`),
  KEY `especialidad` (`especialidad`),
  KEY `medicos_ibfk_1` (`usuario_id`),
  CONSTRAINT `FK_medicos_servicios_medicos` FOREIGN KEY (`especialidad`) REFERENCES `servicios_medicos` (`servicio_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `medicos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gestion_clinica.medicos: ~2 rows (aproximadamente)
INSERT INTO `medicos` (`medico_id`, `usuario_id`, `especialidad`, `no_licencia_medica`, `anio_experiencia`, `institucion`, `fecha_registro`) VALUES
	(5, 16, 1, '2020-1236', 7, 'Universidad Interamericana de Panamá', '2024-10-29 22:22:54'),
	(10, 19, 1, '2021-1234', 13, 'Universidad Interamericana de Panamá', '2024-11-18 14:30:08');

-- Volcando estructura para procedimiento gestion_clinica.PacienteConsultarCita
DROP PROCEDURE IF EXISTS `PacienteConsultarCita`;
DELIMITER //
CREATE PROCEDURE `PacienteConsultarCita`(
	IN `_usuario_id` INT
)
BEGIN
	SELECT 
	sub.Especialidad,
	sub.Fecha,
	sub.Hora,
	u.nombre AS Medico,
	sub.cita_id
	FROM (
		SELECT 
		s.nombre_servicio AS "Especialidad",
		c.fecha AS Fecha,
		c.hora AS Hora,
		c.medico_id,
		c.cita_id
		FROM citas AS c
		LEFT JOIN servicios_medicos AS s ON s.servicio_id = c.servicio_id
		WHERE c.paciente_id = _usuario_id AND c.estado LIKE "Agendada"
	)AS sub
	LEFT JOIN medicos AS m ON m.usuario_id = sub.medico_id
	LEFT JOIN usuarios AS u ON u.usuario_id = sub.medico_id;
END//
DELIMITER ;

-- Volcando estructura para procedimiento gestion_clinica.PacienteConsultarCitas
DROP PROCEDURE IF EXISTS `PacienteConsultarCitas`;
DELIMITER //
CREATE PROCEDURE `PacienteConsultarCitas`(
	IN `_usuario_id` INT
)
BEGIN
	SELECT 
	sub.Especialidad,
	sub.Fecha,
	sub.Hora,
	u.nombre AS Medico,
	sub.cita_id
	FROM (
		SELECT 
		s.nombre_servicio AS "Especialidad",
		c.fecha AS Fecha,
		c.hora AS Hora,
		c.medico_id,
		c.cita_id
		FROM usuarios AS u
		LEFT JOIN pacientes AS p ON p.usuario_id = u.usuario_id
		LEFT JOIN citas AS c ON c.paciente_id = p.paciente_id
		LEFT JOIN servicios_medicos AS s ON s.servicio_id = c.servicio_id
		WHERE u.usuario_id = _usuario_id AND c.estado LIKE "Agendada"
	)AS sub
	LEFT JOIN medicos AS m ON m.usuario_id = sub.medico_id
	LEFT JOIN usuarios AS u ON u.usuario_id = sub.medico_id;
END//
DELIMITER ;

-- Volcando estructura para tabla gestion_clinica.pacientes
DROP TABLE IF EXISTS `pacientes`;
CREATE TABLE IF NOT EXISTS `pacientes` (
  `paciente_id` int(11) NOT NULL AUTO_INCREMENT,
  `cedula` varchar(50) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` varchar(10) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`paciente_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `FK_pacientes_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gestion_clinica.pacientes: ~2 rows (aproximadamente)
INSERT INTO `pacientes` (`paciente_id`, `cedula`, `fecha_nacimiento`, `genero`, `telefono`, `direccion`, `fecha_registro`, `usuario_id`) VALUES
	(8, '8-974-110', '2001-06-13', 'masculino', '61744815', 'El Valle San Isidro Sector 2', '2024-10-31 19:16:06', 13),
	(9, '8-1040-3020', '2024-11-30', 'masculino', '164', 'Samaria despues del puente rojo', '2024-11-18 14:06:08', 20);

-- Volcando estructura para tabla gestion_clinica.padecimiento
DROP TABLE IF EXISTS `padecimiento`;
CREATE TABLE IF NOT EXISTS `padecimiento` (
  `id_padecimiento` int(11) NOT NULL AUTO_INCREMENT,
  `padecimiento` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_padecimiento`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gestion_clinica.padecimiento: ~1 rows (aproximadamente)
INSERT INTO `padecimiento` (`id_padecimiento`, `padecimiento`) VALUES
	(1, 'Dolor de Cabeza');

-- Volcando estructura para tabla gestion_clinica.recetas
DROP TABLE IF EXISTS `recetas`;
CREATE TABLE IF NOT EXISTS `recetas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paciente_id` int(11) NOT NULL,
  `medicamento` varchar(100) DEFAULT NULL,
  `tratamiento` text DEFAULT NULL,
  `fecha_prescripcion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `paciente_id` (`paciente_id`),
  CONSTRAINT `recetas_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`paciente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gestion_clinica.recetas: ~3 rows (aproximadamente)
INSERT INTO `recetas` (`id`, `paciente_id`, `medicamento`, `tratamiento`, `fecha_prescripcion`) VALUES
	(13, 8, 'panadol', 'una cada 8 horas', '2024-11-01 07:04:33'),
	(14, 8, 'panadol', '1 cada 8 horas', '2024-11-06 19:07:25'),
	(15, 8, 'panadol', '1 cada 8 horas', '2024-11-06 19:08:48');

-- Volcando estructura para procedimiento gestion_clinica.RegistrarPaciente
DROP PROCEDURE IF EXISTS `RegistrarPaciente`;
DELIMITER //
CREATE PROCEDURE `RegistrarPaciente`(
	IN `_nombre` VARCHAR(50),
	IN `_email` VARCHAR(50),
	IN `_contrasena` VARCHAR(255),
	IN `_cedula` VARCHAR(50),
	IN `_fecha_nacimiento` VARCHAR(50),
	IN `_genero` VARCHAR(50),
	IN `_telefono` VARCHAR(50),
	IN `_direccion` VARCHAR(50)
)
BEGIN
	DECLARE ultimo_id INT;
	INSERT INTO usuarios (nombre, email, contrasena, rol) 
	VALUES(_nombre, _email, _contrasena, 'Paciente');
	
	SET ultimo_id = LAST_INSERT_ID();
	
	INSERT INTO pacientes (cedula, fecha_nacimiento, genero, telefono, direccion, usuario_id)
	VALUES(_cedula, _fecha_nacimiento, _genero, _telefono, _direccion, ultimo_id);
END//
DELIMITER ;

-- Volcando estructura para tabla gestion_clinica.resultados_analisis
DROP TABLE IF EXISTS `resultados_analisis`;
CREATE TABLE IF NOT EXISTS `resultados_analisis` (
  `resultado_id` int(11) NOT NULL AUTO_INCREMENT,
  `historial_id` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_resultado` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`resultado_id`),
  KEY `historial_id` (`historial_id`),
  CONSTRAINT `resultados_analisis_ibfk_1` FOREIGN KEY (`historial_id`) REFERENCES `historial_clinico` (`historial_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gestion_clinica.resultados_analisis: ~0 rows (aproximadamente)

-- Volcando estructura para tabla gestion_clinica.roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `rol` varchar(50) NOT NULL,
  PRIMARY KEY (`rol`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gestion_clinica.roles: ~10 rows (aproximadamente)
INSERT INTO `roles` (`rol`) VALUES
	('Administrador'),
	('Apoyo'),
	('Emergencias'),
	('Enfermería'),
	('Farmacéuticos'),
	('Limpieza y Mantenimiento'),
	('Médico'),
	('Paciente'),
	('Recepcionista'),
	('Recursos Humanos');

-- Volcando estructura para tabla gestion_clinica.servicios_medicos
DROP TABLE IF EXISTS `servicios_medicos`;
CREATE TABLE IF NOT EXISTS `servicios_medicos` (
  `servicio_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_servicio` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `costo` double DEFAULT NULL,
  PRIMARY KEY (`servicio_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gestion_clinica.servicios_medicos: ~3 rows (aproximadamente)
INSERT INTO `servicios_medicos` (`servicio_id`, `nombre_servicio`, `descripcion`, `costo`) VALUES
	(1, 'Medicina General', NULL, 30),
	(2, 'Laboratorio', NULL, 50),
	(3, 'Neurocirujano', NULL, 13000);

-- Volcando estructura para procedimiento gestion_clinica.SolicitarCita
DROP PROCEDURE IF EXISTS `SolicitarCita`;
DELIMITER //
CREATE PROCEDURE `SolicitarCita`(
	IN `_fecha` DATE,
	IN `_estado` VARCHAR(50),
	IN `_paciente_id` INT,
	IN `_servicio_id` INT,
	IN `_id_turno` INT
)
BEGIN
	-- Verificar que no haya más de 5 citas para la misma fecha
    IF (SELECT COUNT(*) 
        FROM Citas
        WHERE fecha = _fecha) < 5 THEN

        -- Si hay menos de 5 citas, insertamos la nueva cita
        INSERT INTO Citas (fecha, estado, paciente_id, servicio_id, id_turno)
        VALUES (_fecha, _estado, _paciente_id, _servicio_id, _id_turno);
    ELSE
        -- Si ya hay 5 citas, no hacer nada (o devolver un mensaje de error, si es necesario)
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El máximo de 5 citas para este día ya ha sido alcanzado';
    END IF;
END//
DELIMITER ;

-- Volcando estructura para tabla gestion_clinica.turno
DROP TABLE IF EXISTS `turno`;
CREATE TABLE IF NOT EXISTS `turno` (
  `id_turno` int(11) NOT NULL AUTO_INCREMENT,
  `turno` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_turno`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gestion_clinica.turno: ~2 rows (aproximadamente)
INSERT INTO `turno` (`id_turno`, `turno`) VALUES
	(1, '8-12'),
	(2, '1-5');

-- Volcando estructura para tabla gestion_clinica.usuarios
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `rol` varchar(50) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`usuario_id`),
  KEY `FK_usuarios_roles` (`rol`),
  CONSTRAINT `FK_usuarios_roles` FOREIGN KEY (`rol`) REFERENCES `roles` (`rol`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla gestion_clinica.usuarios: ~7 rows (aproximadamente)
INSERT INTO `usuarios` (`usuario_id`, `nombre`, `email`, `contrasena`, `rol`, `fecha_creacion`) VALUES
	(4, 'Pedrito', 'didiervillalaz04@gmail.com', '$2y$10$RzmqVBekNoYqP8X5ZUHKDOTRm6ovyShL9oIa.aYjcCKjetYCKRkQG', 'Administrador', '2024-10-09 01:44:47'),
	(13, 'Alberto', 'prueba1234@gmail.com', '$2y$10$7b1EnmHLFZomz7wxJ9v8/u1sNPWhahQQ4z9i/y0T1xXAny6qJ0Hsu', 'Paciente', '2024-10-31 19:16:06'),
	(14, 'Luis', 'luismurcia0106@gmail.com', '$2y$10$wfC05QY.gONYAYbndQSCeOPKs9UkdcCtKSVwM/TgRoVGiELlDKoPO', 'Administrador', '2024-11-02 20:07:30'),
	(16, 'Carlos Alberto', 'carv2012@gmail.com', '$2y$10$V4XMD3n8vuTmPYowXjnqT.iXKMgflVEzpNfn.ouHl9Q3TzDtehXjq', 'Médico', '2024-11-09 16:08:57'),
	(18, 'Jaider Rico', 'jaider.rico@gmail.com', '$2y$10$G9Pp6s7xiTkiq8XgSfjojulie4lR21ur88ko07PKYA2LikgqkQw1q', 'Recepcionista', '2024-11-09 16:26:07'),
	(19, 'Zacayoyo', 'zacayoyo.1@gmail.com', '$2y$10$1lHZM5TuzqnsL5Dq5q/6qupJO.sXLoe27iS79xRwIhlO7r0D5iPp.', 'Médico', '2024-11-18 14:02:26'),
	(20, 'Chicheme Chorrerano', 'chichemito.chorrerano@gmail.com', '$2y$10$wNWOlSe/d17Hvu7HQUgP3eh2WKI0Ia1qLAe7qxpPuYwoOsGqtXmLG', 'Paciente', '2024-11-18 14:06:08');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
