-- MySQL Workbench Forward Engineering

-- -----------------------------------------------------
-- Preparación del Entorno
-- -----------------------------------------------------
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema db_sigedra
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `db_sigedra`;
CREATE SCHEMA `db_sigedra` DEFAULT CHARACTER SET utf8mb4 ;
USE `db_sigedra` ;

-- -----------------------------------------------------
-- Definición de Tablas (Estructura)
-- -----------------------------------------------------

CREATE TABLE `usuario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `cedula` VARCHAR(30) NOT NULL,
  `contrasena` VARCHAR(255) NOT NULL,
  `requiere_cambio_contrasena` TINYINT(1) DEFAULT 1,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cedula_UNIQUE` (`cedula`)
) ENGINE=InnoDB;

CREATE TABLE `maestro` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` INT(11) NOT NULL,
  `primer_nombre` VARCHAR(50) NOT NULL,
  `segundo_nombre` VARCHAR(50) DEFAULT NULL,
  `primer_apellido` VARCHAR(50) NOT NULL,
  `telefono` VARCHAR(20) DEFAULT NULL,
  `correo` VARCHAR(100) DEFAULT NULL,
  `nacionalidad` VARCHAR(50) DEFAULT NULL,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario_id_UNIQUE` (`usuario_id`),
  CONSTRAINT `fk_maestro_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `materia` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tipo` TINYINT(1) NOT NULL COMMENT '0 para general y 1 para especialidad',
  `nombre` VARCHAR(50) NOT NULL,
  `descripcion` VARCHAR(255) DEFAULT NULL,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `maestro_competencia` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `maestro_id` INT(11) NOT NULL,
  `materia_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_maestro_materia_unique` (`maestro_id`,`materia_id`),
  CONSTRAINT `fk_maestro_competencia_maestro` FOREIGN KEY (`maestro_id`) REFERENCES `maestro` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_maestro_competencia_materia` FOREIGN KEY (`materia_id`) REFERENCES `materia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `anio_lectivo` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `anio` SMALLINT(6) NOT NULL,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `anio_UNIQUE` (`anio`)
) ENGINE=InnoDB;

CREATE TABLE `niveles_academicos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  `orden` TINYINT(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `grado` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `anio_lectivo_id` INT(11) NOT NULL,
  `nivel_academico_id` INT(11) NOT NULL,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_anio_nivel_unique` (`anio_lectivo_id`,`nivel_academico_id`),
  CONSTRAINT `fk_grado_anio_lectivo` FOREIGN KEY (`anio_lectivo_id`) REFERENCES `anio_lectivo` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_grado_niveles_academicos` FOREIGN KEY (`nivel_academico_id`) REFERENCES `niveles_academicos` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `carga_academica` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `maestro_id` INT(11) NOT NULL,
  `materia_id` INT(11) NOT NULL,
  `grado_id` INT(11) NOT NULL,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_carga_academica_grado` FOREIGN KEY (`grado_id`) REFERENCES `grado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_carga_academica_maestro_competencia` FOREIGN KEY (`maestro_id`, `materia_id`) REFERENCES `maestro_competencia` (`maestro_id`, `materia_id`) ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `tipo_ciclo` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `ciclo` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `grado_id` INT(11) NOT NULL,
  `tipo_ciclo_id` INT(11) NOT NULL,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_ciclo_grado` FOREIGN KEY (`grado_id`) REFERENCES `grado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ciclo_tipo_ciclo` FOREIGN KEY (`tipo_ciclo_id`) REFERENCES `tipo_ciclo` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `estudiante` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `cedula` VARCHAR(30) NOT NULL,
  `primer_nombre` VARCHAR(50) NOT NULL,
  `segundo_nombre` VARCHAR(50) DEFAULT NULL,
  `primer_apellido` VARCHAR(50) NOT NULL,
  `fecha_nacimiento` DATE NOT NULL,
  `genero` CHAR(1) DEFAULT NULL,
  `nacionalidad` VARCHAR(50) DEFAULT NULL,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cedula_UNIQUE` (`cedula`)
) ENGINE=InnoDB;

CREATE TABLE `asignacion_estudiante_grado` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `estudiante_id` INT(11) NOT NULL,
  `grado_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_estudiante_grado_unique` (`estudiante_id`,`grado_id`),
  CONSTRAINT `fk_asignacion_estudiante_grado_estudiante` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiante` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_asignacion_estudiante_grado_grado` FOREIGN KEY (`grado_id`) REFERENCES `grado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `estados_asistencia` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `sesion_asistencia` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `carga_academica_id` INT(11) NOT NULL,
  `ciclo_id` INT(11) NOT NULL,
  `fecha` DATE NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_sesion_asistencia_carga_academica` FOREIGN KEY (`carga_academica_id`) REFERENCES `carga_academica` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_sesion_asistencia_ciclo` FOREIGN KEY (`ciclo_id`) REFERENCES `ciclo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `asistencia` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `sesion_asistencia_id` INT(11) NOT NULL,
  `estudiante_id` INT(11) NOT NULL,
  `estado_asistencia_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_asistencia_estados_asistencia` FOREIGN KEY (`estado_asistencia_id`) REFERENCES `estados_asistencia` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_asistencia_estudiante` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_asistencia_sesion_asistencia` FOREIGN KEY (`sesion_asistencia_id`) REFERENCES `sesion_asistencia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `encargado` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` INT(11) NOT NULL,
  `cedula` VARCHAR(30) NOT NULL,
  `nombre_completo` VARCHAR(200) NOT NULL,
  `telefono` VARCHAR(20) DEFAULT NULL,
  `correo` VARCHAR(100) DEFAULT NULL,
  `direccion` TEXT,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario_id_UNIQUE` (`usuario_id`),
  UNIQUE KEY `cedula_UNIQUE` (`cedula`),
  CONSTRAINT `fk_encargado_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `estudiante_encargado` (
  `estudiante_id` INT(11) NOT NULL,
  `encargado_id` INT(11) NOT NULL,
  PRIMARY KEY (`estudiante_id`,`encargado_id`),
  CONSTRAINT `fk_estudiante_encargado_encargado` FOREIGN KEY (`encargado_id`) REFERENCES `encargado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_estudiante_encargado_estudiante` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `tipo_evaluacion` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `activo` TINYINT(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `evaluacion` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tipo_evaluacion_id` INT(11) NOT NULL,
  `ciclo_id` INT(11) NOT NULL,
  `nombre` VARCHAR(45) DEFAULT NULL,
  `puntos_totales` TINYINT(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_evaluacion_ciclo` FOREIGN KEY (`ciclo_id`) REFERENCES `ciclo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_evaluacion_tipo_evaluacion` FOREIGN KEY (`tipo_evaluacion_id`) REFERENCES `tipo_evaluacion` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `nota` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `evaluacion_id` INT(11) NOT NULL,
  `estudiante_id` INT(11) NOT NULL,
  `puntos_obtenidos` DECIMAL(5,2) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_nota_evaluacion` FOREIGN KEY (`evaluacion_id`) REFERENCES `evaluacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_nota_estudiante` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiante` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `roles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB;

CREATE TABLE `usuario_roles` (
  `usuario_id` INT(11) NOT NULL,
  `rol_id` INT(11) NOT NULL,
  PRIMARY KEY (`usuario_id`,`rol_id`),
  CONSTRAINT `fk_usuario_roles_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_usuario_roles_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- INICIO DE INSERCIÓN DE DATOS (SEEDING)
-- -----------------------------------------------------

SET @PWHASH = '$2a$12$4o5fSc32V5E2aGo9N8J16u2Wgq2i.j.4R.u.tIpllBP9iH84XSCyi';

-- -----------------------------------------------------
-- 1. Poblar Catálogos y Entidades Independientes
-- -----------------------------------------------------

INSERT INTO `roles` (`id`, `nombre`) VALUES (1, 'Administrador'), (2, 'Profesor'), (3, 'Encargado');
INSERT INTO `materia` (`id`, `tipo`, `nombre`, `activo`) VALUES
(1, 0, 'Matemáticas', 1), (2, 0, 'Español', 1), (3, 0, 'Ciencias', 1),
(4, 0, 'Estudios Sociales', 1), (5, 0, 'Inglés', 1), (6, 1, 'Música', 1),
(7, 1, 'Informática', 1), (8, 1, 'Religión', 1);
INSERT INTO `niveles_academicos` (`id`, `nombre`, `orden`) VALUES
(1, 'Primer Grado', 1), (2, 'Segundo Grado', 2), (3, 'Tercer Grado', 3),
(4, 'Cuarto Grado', 4), (5, 'Quinto Grado', 5), (6, 'Sexto Grado', 6);
INSERT INTO `anio_lectivo` (`id`, `anio`, `activo`) VALUES (1, 2024, 0), (2, 2025, 1);
INSERT INTO `tipo_ciclo` (`id`, `nombre`) VALUES (1, 'I Semestre'), (2, 'II Semestre');
INSERT INTO `tipo_evaluacion` (`id`, `nombre`, `activo`) VALUES (1, 'Examen', 1), (2, 'Tarea', 1), (3, 'Proyecto', 1), (4, 'Cotidiano', 1);
INSERT INTO `estados_asistencia` (`id`, `nombre`) VALUES (1, 'Presente'), (2, 'Ausente'), (3, 'Tardía'), (4, 'Justificada');

-- -----------------------------------------------------
-- 2. Crear Usuarios con Cédulas Correctas
-- -----------------------------------------------------

INSERT INTO `usuario` (`id`, `cedula`, `contrasena`) VALUES
(1, '1-0876-0543', @PWHASH), (2, '2-0123-0987', @PWHASH),
(3, '3-0456-0789', @PWHASH), (4, '4-0111-0222', @PWHASH), (5, '5-0333-0444', @PWHASH),
(6, '6-0555-0666', @PWHASH), (7, '7-0777-0888', @PWHASH), (8, '1-0999-0110', @PWHASH),
(9, '2-0121-0343', @PWHASH), (10, '3-0565-0787', @PWHASH), (11, '4-0898-0121', @PWHASH),
(12, '5-0345-0678', @PWHASH);
DROP TEMPORARY TABLE IF EXISTS numbers;
CREATE TEMPORARY TABLE numbers (n INT);
INSERT INTO numbers VALUES (0),(1),(2),(3),(4),(5),(6),(7),(8),(9);
INSERT INTO `usuario` (cedula, contrasena)
SELECT IF(RAND() < 0.9, CONCAT(FLOOR(1 + RAND() * 7), '-', LPAD(FLOOR(RAND() * 10000), 4, '0'), '-', LPAD(FLOOR(RAND() * 10000), 4, '0')), CONCAT('121', LPAD(FLOOR(RAND() * 1000000000), 9, '0'))), @PWHASH
FROM numbers n1, numbers n2, numbers n3 WHERE (n1.n*100 + n2.n*10 + n3.n) < 80;
DROP TEMPORARY TABLE numbers;

-- -----------------------------------------------------
-- 3. Asignar Roles a Usuarios
-- -----------------------------------------------------

INSERT INTO `usuario_roles` (`usuario_id`, `rol_id`) VALUES (1, 1), (2, 1);
INSERT INTO `usuario_roles` (`usuario_id`, `rol_id`) VALUES (3, 2), (4, 2), (5, 2), (6, 2), (7, 2), (8, 2), (9, 2), (10, 2), (11, 2), (12, 2);
INSERT INTO `usuario_roles` (`usuario_id`, `rol_id`) SELECT id, 3 FROM `usuario` WHERE id > 12;

-- -----------------------------------------------------
-- 4. Crear Perfiles (Maestros, Encargados, Estudiantes)
-- -----------------------------------------------------

INSERT INTO `maestro` (`id`, `usuario_id`, `primer_nombre`, `primer_apellido`, `correo`, `nacionalidad`) VALUES
(1, 3, 'Carlos', 'Rojas', 'c.rojas@example.com', 'Costarricense'), (2, 4, 'Luisa', 'Fernandez', 'l.fernandez@example.com', 'Costarricense'),
(3, 5, 'Ana', 'Brenes', 'a.brenes@example.com', 'Panameña'), (4, 6, 'Jorge', 'Solis', 'j.solis@example.com', 'Costarricense'),
(5, 7, 'Marta', 'Ugalde', 'm.ugalde@example.com', 'Nicaragüense'), (6, 8, 'Pedro', 'Campos', 'p.campos@example.com', 'Costarricense'),
(7, 9, 'Sofia', 'Mora', 's.mora@example.com', 'Costarricense'), (8, 10, 'Ricardo', 'Jimenez', 'r.jimenez@example.com', 'Salvadoreño'),
(9, 11, 'Elena', 'Villalobos', 'e.villalobos@example.com', 'Costarricense'), (10, 12, 'Mario', 'Quesada', 'm.quesada@example.com', 'Costarricense');
INSERT INTO `maestro_competencia` (`maestro_id`, `materia_id`) VALUES
(1, 1), (1, 3), (2, 2), (2, 4), (3, 5), (4, 6), (4, 8), (5, 7), (6, 1), (6, 7), (7, 2), (7, 3), (8, 4), (8, 5),
(9, 1), (9, 2), (9, 3), (9, 4), (9, 5), (10, 6), (10, 7), (10, 8);
DROP TEMPORARY TABLE IF EXISTS names;
CREATE TEMPORARY TABLE names (name VARCHAR(50));
INSERT INTO names VALUES ('Juan'),('Maria'),('Luis'),('Ana'),('Pedro'),('Sofia'),('Diego'),('Camila'),('Javier'),('Valentina');
INSERT INTO `estudiante` (cedula, primer_nombre, primer_apellido, fecha_nacimiento, genero, nacionalidad)
SELECT IF(RAND() < 0.9, CONCAT(FLOOR(1 + RAND() * 7), '-', LPAD(FLOOR(1000 + RAND() * 9000), 4, '0'), '-', LPAD(FLOOR(1000 + RAND() * 9000), 4, '0')), CONCAT('504', LPAD(FLOOR(RAND() * 1000000000), 9, '0'))), (SELECT name FROM names ORDER BY RAND() LIMIT 1), ELT(1 + FLOOR(RAND() * 10), 'Perez', 'Gomez', 'Rodriguez', 'Martinez', 'Sanchez', 'Ramirez', 'Flores', 'Torres', 'Diaz', 'Vargas'), DATE_SUB(CURDATE(), INTERVAL FLOOR(6 + RAND() * 9) YEAR), IF(RAND() > 0.5, 'M', 'F'), IF(RAND() > 0.1, 'Costarricense', ELT(1+FLOOR(RAND()*3), 'Nicaragüense', 'Panameño', 'Colombiano'))
FROM information_schema.tables a, information_schema.tables b LIMIT 100;
DROP TEMPORARY TABLE names;
INSERT INTO `encargado` (usuario_id, cedula, nombre_completo, telefono)
SELECT id, cedula, CONCAT(ELT(1 + FLOOR(RAND() * 10), 'Adriana', 'Beatriz', 'Carlos', 'Daniel', 'Esteban', 'Fabiana', 'Gustavo', 'Hilda', 'Ivan', 'Julia'), ' ', ELT(1 + FLOOR(RAND() * 10), 'Alvarado', 'Blanco', 'Cordero', 'Delgado', 'Elizondo', 'Fallas', 'Granados', 'Herrera', 'Infante', 'Jimenez')), CONCAT('8', LPAD(FLOOR(RAND() * 10000000), 7, '0'))
FROM `usuario` WHERE id > 12;

-- -----------------------------------------------------
-- 5. Crear Estructura Académica (Grados, Ciclos)
-- -----------------------------------------------------
INSERT INTO `grado` (anio_lectivo_id, nivel_academico_id) VALUES (1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6);
INSERT INTO `grado` (anio_lectivo_id, nivel_academico_id) VALUES (2, 1), (2, 2), (2, 3), (2, 4), (2, 5), (2, 6);
INSERT INTO `ciclo` (grado_id, tipo_ciclo_id) SELECT id, 1 FROM `grado`; -- I Semestre
INSERT INTO `ciclo` (grado_id, tipo_ciclo_id) SELECT id, 2 FROM `grado`; -- II Semestre

-- -----------------------------------------------------
-- 6. Realizar Asignaciones y Vinculaciones (CORREGIDO)
-- -----------------------------------------------------

INSERT INTO `asignacion_estudiante_grado` (estudiante_id, grado_id) SELECT id, 7 + FLOOR(RAND() * 6) FROM `estudiante`;

-- CORRECCIÓN INICIA AQUÍ: Lógica robusta para evitar duplicados
-- Asignar un encargado principal a los primeros 80 estudiantes
INSERT INTO `estudiante_encargado` (estudiante_id, encargado_id)
SELECT s.id, e.id
FROM
  (SELECT id, ROW_NUMBER() OVER(ORDER BY id) as rn FROM `estudiante` LIMIT 80) s
JOIN
  (SELECT id, ROW_NUMBER() OVER(ORDER BY RAND()) as rn FROM `encargado` LIMIT 80) e
ON s.rn = e.rn;

-- Asignar un SEGUNDO y DIFERENTE encargado a los primeros 20 estudiantes
INSERT INTO `estudiante_encargado` (estudiante_id, encargado_id)
SELECT
    s.id AS estudiante_id,
    (
        SELECT e.id FROM `encargado` e
        -- Se asegura de que el encargado a seleccionar no esté ya asignado a este estudiante
        WHERE e.id NOT IN (SELECT ee.encargado_id FROM `estudiante_encargado` ee WHERE ee.estudiante_id = s.id)
        ORDER BY RAND()
        LIMIT 1
    ) AS encargado_id
FROM `estudiante` s
WHERE s.id <= 20;
-- FIN DE LA CORRECCIÓN

INSERT INTO `carga_academica` (maestro_id, materia_id, grado_id) SELECT DISTINCT mc.maestro_id, mc.materia_id, g.id as grado_id FROM `maestro_competencia` mc, `grado` g WHERE g.anio_lectivo_id = 2 ORDER BY RAND() LIMIT 50;

-- -----------------------------------------------------
-- 7. Crear Evaluaciones, Notas y Asistencia
-- -----------------------------------------------------

INSERT INTO `evaluacion` (tipo_evaluacion_id, ciclo_id, nombre, puntos_totales)
SELECT 1 + FLOOR(RAND() * 4), c.id, CONCAT('Evaluación #', 1 + FLOOR(RAND() * 5)), FLOOR(20 + RAND() * 30)
FROM `ciclo` c JOIN `grado` g ON c.grado_id = g.id
WHERE g.anio_lectivo_id = 2 AND c.tipo_ciclo_id = 1
LIMIT 30;

INSERT INTO `nota` (evaluacion_id, estudiante_id, puntos_obtenidos)
SELECT e.id, aeg.estudiante_id, ROUND(e.puntos_totales * (0.6 + RAND() * 0.4), 2)
FROM `evaluacion` e JOIN `ciclo` c ON e.ciclo_id = c.id JOIN `asignacion_estudiante_grado` aeg ON c.grado_id = aeg.grado_id
ORDER BY RAND() LIMIT 500;

INSERT INTO `sesion_asistencia` (carga_academica_id, ciclo_id, fecha)
SELECT ca.id, c.id, DATE_ADD('2025-02-01', INTERVAL FLOOR(RAND() * 150) DAY)
FROM `carga_academica` ca JOIN `grado` g ON ca.grado_id = g.id JOIN `ciclo` c ON g.id = c.grado_id
WHERE g.anio_lectivo_id = 2 and c.tipo_ciclo_id = 1
LIMIT 100;

INSERT INTO `asistencia` (sesion_asistencia_id, estudiante_id, estado_asistencia_id)
SELECT sa.id, aeg.estudiante_id, 1 + FLOOR(RAND() * 4)
FROM `sesion_asistencia` sa JOIN `carga_academica` ca ON sa.carga_academica_id = ca.id JOIN `asignacion_estudiante_grado` aeg ON ca.grado_id = aeg.grado_id
ORDER BY RAND() LIMIT 1000;

-- -----------------------------------------------------
-- Finalización
-- -----------------------------------------------------
SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;