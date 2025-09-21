-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 34.132.141.129    Database: db_sigedra
-- ------------------------------------------------------
-- Server version	8.0.41-google

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '5a790116-95f4-11f0-b40c-42010a400004:1-172,
950fa219-9657-11f0-b499-42010a400005:1-454';

--
-- Table structure for table `anio_lectivo`
--

DROP TABLE IF EXISTS `anio_lectivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `anio_lectivo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `anio` smallint NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `anio_UNIQUE` (`anio`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anio_lectivo`
--

LOCK TABLES `anio_lectivo` WRITE;
/*!40000 ALTER TABLE `anio_lectivo` DISABLE KEYS */;
INSERT INTO `anio_lectivo` VALUES (1,2024,0),(2,2025,1);
/*!40000 ALTER TABLE `anio_lectivo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asignacion_estudiante_grado`
--

DROP TABLE IF EXISTS `asignacion_estudiante_grado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asignacion_estudiante_grado` (
  `id` int NOT NULL AUTO_INCREMENT,
  `estudiante_id` int NOT NULL,
  `grado_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_estudiante_grado_unique` (`estudiante_id`,`grado_id`),
  KEY `fk_asignacion_estudiante_grado_grado` (`grado_id`),
  CONSTRAINT `fk_asignacion_estudiante_grado_estudiante` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiante` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_asignacion_estudiante_grado_grado` FOREIGN KEY (`grado_id`) REFERENCES `grado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asignacion_estudiante_grado`
--

LOCK TABLES `asignacion_estudiante_grado` WRITE;
/*!40000 ALTER TABLE `asignacion_estudiante_grado` DISABLE KEYS */;
INSERT INTO `asignacion_estudiante_grado` VALUES (78,1,9),(1,2,7),(11,3,12),(39,4,8),(5,5,10),(85,6,10),(51,7,9),(83,8,8),(25,9,8),(72,10,12),(24,11,8),(29,12,11),(66,13,11),(75,14,12),(82,15,11),(28,16,9),(61,17,10),(12,18,9),(97,19,10),(94,20,12),(77,21,10),(23,22,12),(59,23,9),(70,24,11),(48,25,10),(38,26,8),(73,27,11),(30,28,11),(2,29,11),(93,30,11),(44,31,12),(4,32,7),(14,33,9),(46,34,10),(91,35,12),(27,36,7),(62,37,11),(50,38,10),(40,39,10),(67,40,7),(33,41,12),(35,42,9),(69,43,12),(71,44,8),(3,45,7),(41,46,12),(36,47,8),(74,48,7),(26,49,8),(13,50,8),(32,51,11),(68,52,8),(42,53,7),(53,54,9),(31,55,7),(7,56,11),(20,57,11),(98,58,9),(15,59,12),(54,60,10),(90,61,7),(99,62,10),(55,63,9),(63,64,8),(81,65,10),(84,66,12),(34,67,12),(8,68,12),(65,69,8),(57,70,11),(10,71,7),(47,72,10),(80,73,7),(17,74,8),(76,75,8),(37,76,12),(56,77,12),(21,78,12),(6,79,8),(45,80,10),(18,81,10),(16,82,10),(49,83,12),(92,84,10),(87,85,12),(19,86,9),(86,87,9),(64,88,10),(22,89,7),(60,90,11),(88,91,9),(96,92,7),(52,93,7),(9,94,7),(100,95,8),(43,96,10),(79,97,8),(95,98,10),(58,99,8),(89,100,9);
/*!40000 ALTER TABLE `asignacion_estudiante_grado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asistencia`
--

DROP TABLE IF EXISTS `asistencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asistencia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sesion_asistencia_id` int NOT NULL,
  `estudiante_id` int NOT NULL,
  `estado_asistencia_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_asistencia_estados_asistencia` (`estado_asistencia_id`),
  KEY `fk_asistencia_estudiante` (`estudiante_id`),
  KEY `fk_asistencia_sesion_asistencia` (`sesion_asistencia_id`),
  CONSTRAINT `fk_asistencia_estados_asistencia` FOREIGN KEY (`estado_asistencia_id`) REFERENCES `estados_asistencia` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_asistencia_estudiante` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_asistencia_sesion_asistencia` FOREIGN KEY (`sesion_asistencia_id`) REFERENCES `sesion_asistencia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=833 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asistencia`
--

LOCK TABLES `asistencia` WRITE;
/*!40000 ALTER TABLE `asistencia` DISABLE KEYS */;
INSERT INTO `asistencia` VALUES (1,23,63,3),(2,36,90,3),(3,15,99,3),(4,28,81,2),(5,34,90,2),(6,17,47,3),(7,7,94,4),(8,1,36,3),(9,48,85,2),(10,49,66,1),(11,8,61,1),(12,24,91,1),(13,49,10,4),(14,25,38,2),(15,42,12,4),(16,15,26,2),(17,2,92,3),(18,6,36,3),(19,27,65,1),(20,26,88,3),(21,30,62,4),(22,9,11,3),(23,47,14,2),(24,13,99,1),(25,11,95,3),(26,8,71,2),(27,7,89,1),(28,25,88,2),(29,2,53,3),(30,33,72,3),(31,11,8,4),(32,35,57,3),(33,33,60,4),(34,7,40,4),(35,16,8,3),(36,7,36,1),(37,44,37,3),(38,35,13,2),(39,33,80,4),(40,21,23,2),(41,4,40,1),(42,27,60,3),(43,43,13,1),(44,44,57,4),(45,27,38,4),(46,10,69,4),(47,15,44,3),(48,30,65,1),(49,26,5,1),(50,33,82,3),(51,36,12,3),(52,21,42,3),(53,45,43,4),(54,30,6,1),(55,1,40,2),(56,47,43,2),(57,34,28,1),(58,10,79,4),(59,38,56,2),(60,20,23,2),(61,47,59,4),(62,32,19,3),(63,16,79,1),(64,33,65,1),(65,10,47,2),(66,17,79,4),(67,26,81,3),(68,48,46,2),(69,4,2,3),(70,13,95,1),(71,18,95,2),(72,37,90,3),(73,28,6,3),(74,42,13,4),(75,29,88,1),(76,16,95,2),(77,27,6,2),(78,48,67,3),(79,31,80,4),(80,50,67,4),(81,47,85,4),(82,24,33,2),(83,38,13,4),(84,2,36,4),(85,31,62,3),(86,5,71,2),(87,17,64,2),(88,8,53,2),(89,34,37,1),(90,44,28,4),(91,31,96,4),(92,41,70,2),(93,24,100,4),(94,13,26,1),(95,12,44,1),(96,14,44,3),(97,16,69,3),(98,27,19,2),(99,37,37,3),(100,36,15,1),(101,24,63,3),(102,11,52,2),(103,18,9,4),(104,26,39,3),(105,9,50,4),(106,22,58,2),(107,48,3,1),(108,50,77,1),(109,23,42,1),(110,10,11,3),(111,40,57,4),(112,39,29,2),(113,26,19,3),(114,16,52,3),(115,25,17,2),(116,42,27,3),(117,28,19,2),(118,32,25,2),(119,35,56,2),(120,8,93,1),(121,25,65,1),(122,17,11,3),(123,13,47,1),(124,32,21,2),(125,42,70,3),(126,44,29,2),(127,23,23,4),(128,32,96,3),(129,8,73,2),(130,20,33,4),(131,18,75,3),(132,28,60,2),(133,46,76,2),(134,18,99,1),(135,34,12,3),(136,49,14,2),(137,45,85,4),(138,15,4,3),(139,8,32,2),(140,41,27,1),(141,20,18,4),(142,42,90,3),(143,9,4,4),(144,22,86,3),(145,25,34,1),(146,23,86,4),(147,25,6,3),(148,17,44,2),(149,40,13,2),(150,11,97,1),(151,25,84,2),(152,31,84,2),(153,38,90,2),(154,16,11,2),(155,36,30,3),(156,38,28,3),(157,30,60,2),(158,28,38,1),(159,25,39,4),(160,45,66,4),(161,36,24,1),(162,18,97,2),(163,33,5,3),(164,43,28,3),(165,9,97,3),(166,44,24,3),(167,33,88,3),(168,37,27,4),(169,19,91,1),(170,8,2,4),(171,50,41,3),(172,40,28,1),(173,46,85,4),(174,29,62,4),(175,30,21,3),(176,35,28,1),(177,9,8,2),(178,28,80,3),(179,30,88,4),(180,1,61,3),(181,50,10,2),(182,14,95,2),(183,15,52,3),(184,32,5,1),(185,24,42,2),(186,3,89,4),(187,4,89,1),(188,46,83,3),(189,17,52,1),(190,26,98,4),(191,50,68,3),(192,14,74,1),(193,11,74,3),(194,32,38,1),(195,45,77,1),(196,32,82,3),(197,15,47,3),(198,14,4,1),(199,3,55,2),(200,26,65,1),(201,13,50,3),(202,24,23,3),(203,28,17,1),(204,28,39,3),(205,17,99,2),(206,34,30,1),(207,15,74,2),(208,44,90,3),(209,31,21,1),(210,5,36,1),(211,47,35,3),(212,5,92,4),(213,27,80,3),(214,14,52,4),(215,49,46,3),(216,15,95,2),(217,40,56,3),(218,9,44,4),(219,36,29,1),(220,32,80,1),(221,4,45,2),(222,18,47,1),(223,9,49,3),(224,35,29,2),(225,46,20,2),(226,9,95,2),(227,40,90,2),(228,23,33,1),(229,6,61,4),(230,3,61,4),(231,44,27,3),(232,31,98,2),(233,36,57,3),(234,20,7,2),(235,9,64,4),(236,41,90,3),(237,19,7,1),(238,30,81,4),(239,29,65,3),(240,28,98,4),(241,5,61,4),(242,6,48,1),(243,26,62,2),(244,4,48,2),(245,36,51,2),(246,33,81,2),(247,48,22,2),(248,24,16,1),(249,17,95,2),(250,47,20,3),(251,9,74,4),(252,16,64,3),(253,10,74,1),(254,25,96,2),(255,25,25,1),(256,40,24,3),(257,12,79,4),(258,30,39,1),(259,31,17,4),(260,21,86,3),(261,33,19,1),(262,9,79,1),(263,32,88,2),(264,17,75,3),(265,45,22,2),(266,10,97,1),(267,40,29,2),(268,3,92,1),(269,1,45,2),(270,3,73,4),(271,12,74,1),(272,14,11,4),(273,18,8,3),(274,4,94,2),(275,32,60,1),(276,40,30,1),(277,27,72,3),(278,23,18,2),(279,12,47,3),(280,24,18,1),(281,18,69,2),(282,25,5,1),(283,8,45,2),(284,12,99,2),(285,26,6,4),(286,32,72,2),(287,37,56,4),(288,37,70,1),(289,46,3,1),(290,46,46,4),(291,10,4,3),(292,33,6,3),(293,37,15,3),(294,27,84,4),(295,37,30,2),(296,25,60,2),(297,22,100,1),(298,7,2,3),(299,12,75,3),(300,12,97,2),(301,11,69,1),(302,18,49,1),(303,45,20,3),(304,1,92,1),(305,7,73,3),(306,44,13,2),(307,16,47,1),(308,7,92,4),(309,14,64,3),(310,6,55,4),(311,48,78,1),(312,31,81,1),(313,43,56,1),(314,22,18,2),(315,9,75,2),(316,13,74,1),(317,42,28,2),(318,16,97,4),(319,32,98,2),(320,39,12,1),(321,31,65,4),(322,30,72,4),(323,26,25,3),(324,45,35,1),(325,46,41,4),(326,14,26,3),(327,48,41,2),(328,16,75,3),(329,37,13,2),(330,29,60,4),(331,7,93,2),(332,28,88,2),(333,11,49,2),(334,1,53,1),(335,25,80,2),(336,28,82,2),(337,24,86,1),(338,36,13,2),(339,6,53,2),(340,27,82,3),(341,29,82,2),(342,50,83,2),(343,45,78,1),(344,3,94,4),(345,22,7,1),(346,12,50,3),(347,33,25,1),(348,27,17,1),(349,39,13,3),(350,15,11,4),(351,20,86,2),(352,18,11,4),(353,5,53,2),(354,14,79,2),(355,4,92,3),(356,46,43,4),(357,6,89,2),(358,20,100,4),(359,9,47,2),(360,30,34,4),(361,13,97,2),(362,39,24,3),(363,48,83,4),(364,10,75,3),(365,47,10,2),(366,34,70,4),(367,37,51,3),(368,29,25,4),(369,16,9,1),(370,47,31,2),(371,35,37,2),(372,10,95,2),(373,50,31,3),(374,11,4,1),(375,10,64,1),(376,8,36,1),(377,17,26,1),(378,23,100,3),(379,40,37,3),(380,22,91,4),(381,46,10,1),(382,49,59,1),(383,36,28,3),(384,27,96,3),(385,43,29,4),(386,42,29,1),(387,31,6,3),(388,49,68,4),(389,49,78,4),(390,45,3,2),(391,10,9,3),(392,19,33,2),(393,29,21,4),(394,1,71,4),(395,17,69,2),(396,34,24,2),(397,14,97,3),(398,38,15,4),(399,13,11,4),(400,43,57,1),(401,6,32,3),(402,7,55,1),(403,25,81,3),(404,18,52,2),(405,1,89,2),(406,47,66,3),(407,50,43,4),(408,50,78,2),(409,7,45,2),(410,2,2,1),(411,25,21,3),(412,31,72,2),(413,29,6,2),(414,27,98,3),(415,35,12,2),(416,16,44,4),(417,19,16,3),(418,4,93,3),(419,14,49,1),(420,32,39,2),(421,33,39,1),(422,27,81,4),(423,30,96,2),(424,34,15,2),(425,20,63,2),(426,44,51,2),(427,12,52,1),(428,10,99,2),(429,31,82,3),(430,20,58,2),(431,46,59,1),(432,13,9,3),(433,24,7,2),(434,3,71,4),(435,2,93,1),(436,34,29,4),(437,13,44,3),(438,2,61,1),(439,41,29,2),(440,1,2,4),(441,27,25,1),(442,43,30,3),(443,38,12,4),(444,36,37,3),(445,38,70,1),(446,1,73,1),(447,42,57,3),(448,3,45,4),(449,9,9,3),(450,46,78,1),(451,27,62,3),(452,40,27,2),(453,34,57,2),(454,43,12,4),(455,6,93,3),(456,5,94,2),(457,46,77,4),(458,22,63,1),(459,49,20,3),(460,40,70,2),(461,15,64,2),(462,21,87,3),(463,45,68,3),(464,38,37,3),(465,17,74,2),(466,39,30,2),(467,47,83,3),(468,2,55,3),(469,35,51,3),(470,11,9,1),(471,5,40,1),(472,25,72,4),(473,20,87,2),(474,30,98,1),(475,17,9,1),(476,10,44,1),(477,18,74,2),(478,3,40,2),(479,37,29,1),(480,47,41,3),(481,1,48,4),(482,19,23,2),(483,20,1,4),(484,41,15,2),(485,4,55,2),(486,33,84,2),(487,19,87,4),(488,15,69,1),(489,40,15,1),(490,34,56,2),(491,22,87,2),(492,14,75,2),(493,26,21,2),(494,4,73,1),(495,12,4,4),(496,19,100,4),(497,3,48,3),(498,10,8,3),(499,3,2,2),(500,9,69,2),(501,4,36,4),(502,26,80,3),(503,12,95,2),(504,32,81,1),(505,39,27,2),(506,48,68,1),(507,15,50,3),(508,4,53,2),(509,48,14,2),(510,32,62,2),(511,42,51,1),(512,13,49,1),(513,35,90,3),(514,4,61,4),(515,41,30,2),(516,46,67,4),(517,5,48,4),(518,46,68,2),(519,32,65,4),(520,14,47,2),(521,10,26,1),(522,15,49,1),(523,39,56,4),(524,43,70,1),(525,29,39,2),(526,6,73,4),(527,12,64,1),(528,11,26,1),(529,21,63,3),(530,3,36,3),(531,50,66,1),(532,17,4,3),(533,23,54,4),(534,45,76,4),(535,32,6,3),(536,47,78,2),(537,16,50,4),(538,19,54,4),(539,22,1,3),(540,44,30,3),(541,23,58,2),(542,20,91,2),(543,38,24,4),(544,26,72,2),(545,26,96,3),(546,14,9,1),(547,48,43,2),(548,12,9,4),(549,25,82,4),(550,25,62,2),(551,41,28,3),(552,29,17,2),(553,19,42,2),(554,9,99,4),(555,2,71,2),(556,4,32,2),(557,12,26,3),(558,21,91,2),(559,49,77,3),(560,7,61,3),(561,19,18,3),(562,21,16,1),(563,35,24,2),(564,35,27,2),(565,6,94,3),(566,38,57,2),(567,30,84,4),(568,39,15,3),(569,31,38,1),(570,2,73,3),(571,31,25,1),(572,26,34,4),(573,37,28,4),(574,13,52,2),(575,46,66,1),(576,38,51,3),(577,6,40,2),(578,18,4,2),(579,27,21,1),(580,5,45,2),(581,42,30,2),(582,39,28,4),(583,13,79,4),(584,19,58,4),(585,44,12,1),(586,32,17,1),(587,5,2,2),(588,3,93,1),(589,6,71,4),(590,49,67,1),(591,31,5,2),(592,11,11,3),(593,45,46,4),(594,28,21,2),(595,18,64,3),(596,36,56,2),(597,45,14,3),(598,42,24,3),(599,11,44,2),(600,1,93,3),(601,5,73,4),(602,49,22,1),(603,13,4,1),(604,45,41,3),(605,34,51,1),(606,23,87,2),(607,28,84,4),(608,49,85,1),(609,20,54,4),(610,41,51,1),(611,47,77,3),(612,30,19,2),(613,8,55,3),(614,17,49,2),(615,8,40,1),(616,31,34,2),(617,44,15,3),(618,37,12,1),(619,49,41,1),(620,15,8,2),(621,35,30,4),(622,29,84,2),(623,26,17,4),(624,41,37,1),(625,11,50,3),(626,4,71,3),(627,43,90,2),(628,30,38,4),(629,33,17,3),(630,14,8,4),(631,46,31,3),(632,50,22,3),(633,22,23,3),(634,41,13,1),(635,50,76,2),(636,29,96,4),(637,8,89,4),(638,47,68,1),(639,46,14,4),(640,19,1,4),(641,14,69,1),(642,10,50,3),(643,49,83,3),(644,43,37,3),(645,16,99,2),(646,15,97,4),(647,48,20,1),(648,30,17,1),(649,47,46,4),(650,2,94,1),(651,30,80,1),(652,23,1,2),(653,29,19,3),(654,5,89,3),(655,24,1,4),(656,47,67,2),(657,2,89,4),(658,14,50,3),(659,46,35,2),(660,39,51,1),(661,49,31,2),(662,6,92,1),(663,21,54,1),(664,34,13,2),(665,46,22,4),(666,12,49,4),(667,43,51,1),(668,40,51,4),(669,38,27,1),(670,30,25,3),(671,28,96,3),(672,19,63,1),(673,1,55,2),(674,48,59,4),(675,16,26,1),(676,26,84,3),(677,26,60,3),(678,2,40,4),(679,33,98,1),(680,43,27,1),(681,23,16,3),(682,11,75,4),(683,42,56,1),(684,18,79,2),(685,34,27,2),(686,48,76,2),(687,36,70,1),(688,28,25,4),(689,28,34,3),(690,6,45,3),(691,50,3,1),(692,10,52,1),(693,21,33,4),(694,50,59,1),(695,18,50,4),(696,27,39,3),(697,47,3,1),(698,2,48,3),(699,37,57,4),(700,41,24,3),(701,28,62,2),(702,1,32,1),(703,39,70,1),(704,8,92,3),(705,17,50,4),(706,43,24,3),(707,27,5,1),(708,13,69,1),(709,45,67,2),(710,21,18,1),(711,12,69,4),(712,10,49,2),(713,32,84,3),(714,2,45,1),(715,11,47,1),(716,45,31,4),(717,22,54,1),(718,38,30,3),(719,26,38,2),(720,8,94,4),(721,29,98,1),(722,25,98,3),(723,33,96,1),(724,48,10,2),(725,45,59,1),(726,19,86,3),(727,7,53,1),(728,36,27,1),(729,48,35,2),(730,12,11,4),(731,44,70,3),(732,35,15,2),(733,3,53,2),(734,11,99,2),(735,21,100,2),(736,41,12,2),(737,23,91,1),(738,12,8,2),(739,16,74,1),(740,39,57,3),(741,28,5,3),(742,13,8,4),(743,49,43,3),(744,24,58,4),(745,24,87,4),(746,15,75,3),(747,18,26,1),(748,40,12,4),(749,44,56,1),(750,11,79,1),(751,33,34,1),(752,50,46,1),(753,11,64,3),(754,7,32,4),(755,47,22,2),(756,29,38,1),(757,22,16,3),(758,29,81,2),(759,5,93,2),(760,26,82,3),(761,2,32,2),(762,29,5,1),(763,31,60,3),(764,48,66,3),(765,39,90,2),(766,27,88,2),(767,49,3,1),(768,50,14,3),(769,22,42,1),(770,31,19,3),(771,35,70,2),(772,49,76,3),(773,23,7,2),(774,30,82,1),(775,27,34,2),(776,41,57,3),(777,22,33,2),(778,5,55,2),(779,50,35,3),(780,42,15,3),(781,5,32,2),(782,6,2,3),(783,30,5,1),(784,20,16,4),(785,37,24,2),(786,15,79,2),(787,47,76,2),(788,38,29,4),(789,45,83,1),(790,33,62,1),(791,17,97,4),(792,1,94,2),(793,13,64,3),(794,7,71,2),(795,48,31,2),(796,16,4,3),(797,9,26,1),(798,49,35,1),(799,31,88,2),(800,45,10,2),(801,50,20,1),(802,13,75,3),(803,21,7,4),(804,28,72,3),(805,3,32,1),(806,29,72,2),(807,16,49,3),(808,21,58,4),(809,25,19,2),(810,18,44,2),(811,15,9,2),(812,28,65,3),(813,42,37,4),(814,14,99,2),(815,48,77,2),(816,31,39,1),(817,7,48,2),(818,39,37,4),(819,20,42,1),(820,41,56,4),(821,50,85,2),(822,9,52,4),(823,24,54,1),(824,8,48,4),(825,17,8,1),(826,32,34,2),(827,33,21,2),(828,21,1,3),(829,29,34,4),(830,29,80,2),(831,33,38,4),(832,43,15,3);
/*!40000 ALTER TABLE `asistencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carga_academica`
--

DROP TABLE IF EXISTS `carga_academica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carga_academica` (
  `id` int NOT NULL AUTO_INCREMENT,
  `maestro_id` int NOT NULL,
  `materia_id` int NOT NULL,
  `grado_id` int NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_carga_academica_grado` (`grado_id`),
  KEY `fk_carga_academica_maestro_competencia` (`maestro_id`,`materia_id`),
  CONSTRAINT `fk_carga_academica_grado` FOREIGN KEY (`grado_id`) REFERENCES `grado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_carga_academica_maestro_competencia` FOREIGN KEY (`maestro_id`, `materia_id`) REFERENCES `maestro_competencia` (`maestro_id`, `materia_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carga_academica`
--

LOCK TABLES `carga_academica` WRITE;
/*!40000 ALTER TABLE `carga_academica` DISABLE KEYS */;
INSERT INTO `carga_academica` VALUES (1,10,8,8,1),(2,9,3,11,1),(3,10,7,10,1),(4,7,2,10,1),(5,5,7,10,1),(6,7,3,7,1),(7,6,1,7,1),(8,10,8,12,1),(9,2,4,9,1),(10,9,5,8,1),(11,8,4,9,1),(12,2,2,10,1),(13,7,3,8,1),(14,3,5,11,1),(15,9,3,8,1),(16,8,5,12,1),(17,2,2,11,1),(18,6,1,11,1),(19,1,3,9,1),(20,9,1,9,1),(21,6,1,10,1),(22,7,2,11,1),(23,4,8,11,1),(24,10,6,7,1),(25,9,3,7,1),(26,6,1,12,1),(27,8,4,7,1),(28,9,5,11,1),(29,4,6,11,1),(30,7,3,12,1),(31,3,5,7,1),(32,2,2,8,1),(33,10,6,9,1),(34,9,2,12,1),(35,10,8,10,1),(36,4,8,10,1),(37,5,7,7,1),(38,7,2,8,1),(39,2,4,11,1),(40,10,7,8,1),(41,8,5,11,1),(42,7,3,9,1),(43,7,3,10,1),(44,4,6,7,1),(45,8,4,8,1),(46,8,4,10,1),(47,9,1,8,1),(48,5,7,11,1),(49,9,2,8,1),(50,9,5,12,1);
/*!40000 ALTER TABLE `carga_academica` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ciclo`
--

DROP TABLE IF EXISTS `ciclo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ciclo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `grado_id` int NOT NULL,
  `tipo_ciclo_id` int NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_ciclo_grado` (`grado_id`),
  KEY `fk_ciclo_tipo_ciclo` (`tipo_ciclo_id`),
  CONSTRAINT `fk_ciclo_grado` FOREIGN KEY (`grado_id`) REFERENCES `grado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ciclo_tipo_ciclo` FOREIGN KEY (`tipo_ciclo_id`) REFERENCES `tipo_ciclo` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciclo`
--

LOCK TABLES `ciclo` WRITE;
/*!40000 ALTER TABLE `ciclo` DISABLE KEYS */;
INSERT INTO `ciclo` VALUES (1,1,1,1),(2,7,1,1),(3,2,1,1),(4,8,1,1),(5,3,1,1),(6,9,1,1),(7,4,1,1),(8,10,1,1),(9,5,1,1),(10,11,1,1),(11,6,1,1),(12,12,1,1),(16,1,2,1),(17,7,2,1),(18,2,2,1),(19,8,2,1),(20,3,2,1),(21,9,2,1),(22,4,2,1),(23,10,2,1),(24,5,2,1),(25,11,2,1),(26,6,2,1),(27,12,2,1);
/*!40000 ALTER TABLE `ciclo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `encargado`
--

DROP TABLE IF EXISTS `encargado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `encargado` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int unsigned NOT NULL,
  `cedula` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `nombre_completo` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `correo` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `direccion` text COLLATE utf8mb4_general_ci,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cedula_UNIQUE` (`cedula`),
  KEY `fk_encargado_usuario_id_idx` (`usuario_id`),
  CONSTRAINT `fk_encargado_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `encargado`
--

LOCK TABLES `encargado` WRITE;
/*!40000 ALTER TABLE `encargado` DISABLE KEYS */;
/*!40000 ALTER TABLE `encargado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados_asistencia`
--

DROP TABLE IF EXISTS `estados_asistencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados_asistencia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados_asistencia`
--

LOCK TABLES `estados_asistencia` WRITE;
/*!40000 ALTER TABLE `estados_asistencia` DISABLE KEYS */;
INSERT INTO `estados_asistencia` VALUES (1,'Presente'),(2,'Ausente'),(3,'Tardía'),(4,'Justificada');
/*!40000 ALTER TABLE `estados_asistencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estudiante`
--

DROP TABLE IF EXISTS `estudiante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estudiante` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cedula` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `primer_nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `segundo_nombre` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `primer_apellido` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `segundo_apellido` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_nacimiento` date NOT NULL,
  `direccion` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `genero` char(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nacionalidad` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `edad` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cedula_UNIQUE` (`cedula`),
  KEY `estudiante_fecha_nacimiento_index` (`fecha_nacimiento`),
  KEY `idx_estudiante_primer_nombre` (`primer_nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiante`
--

LOCK TABLES `estudiante` WRITE;
/*!40000 ALTER TABLE `estudiante` DISABLE KEYS */;
INSERT INTO `estudiante` VALUES (1,'504902127718','Diego',NULL,'Torres',NULL,'2014-09-19',NULL,'M','Colombiano',1,11),(2,'117183916','Valentina',NULL,'Gomez',NULL,'2016-09-19',NULL,'M','Costarricense',1,9),(3,'157163698','Diego',NULL,'Torres',NULL,'2012-09-19',NULL,'F','Costarricense',1,13),(4,'354115378','Camila',NULL,'Perez',NULL,'2019-09-19',NULL,'M','Costarricense',1,6),(5,'130489150','Luis',NULL,'Sanchez',NULL,'2018-09-19',NULL,'M','Costarricense',1,7),(6,'660843781','Luis',NULL,'Rodriguez',NULL,'2016-09-19',NULL,'F','Costarricense',1,9),(7,'433096873','Luis',NULL,'Gomez',NULL,'2014-09-19',NULL,'M','Costarricense',1,11),(8,'646588797','Juan',NULL,'Flores',NULL,'2016-09-19',NULL,'F','Costarricense',1,NULL),(9,'280392190','Pedro',NULL,'Ramirez',NULL,'2014-09-19',NULL,'F','Costarricense',1,NULL),(10,'504258367485','Valentina',NULL,'Rodriguez',NULL,'2016-09-19',NULL,'F','Costarricense',1,NULL),(11,'270106347','Maria',NULL,'Rodriguez',NULL,'2016-09-19',NULL,'F','Costarricense',1,NULL),(12,'310608115','Camila',NULL,'Perez',NULL,'2015-09-19',NULL,'M','Costarricense',1,NULL),(13,'552364967','Javier',NULL,'Rodriguez',NULL,'2017-09-19',NULL,'M','Panameño',1,NULL),(14,'504607612124','Sofia',NULL,'Vargas',NULL,'2016-09-19',NULL,'F','Nicaragüense',1,NULL),(15,'629958144','Diego',NULL,'Diaz',NULL,'2013-09-19',NULL,'F','Nicaragüense',1,NULL),(16,'291728462','Pedro',NULL,'Rodriguez',NULL,'2019-09-19',NULL,'M','Costarricense',1,NULL),(17,'530123020','Ana',NULL,'Sanchez',NULL,'2016-09-19',NULL,'F','Costarricense',1,NULL),(18,'160736298','Javier',NULL,'Diaz',NULL,'2012-09-19',NULL,'F','Costarricense',1,NULL),(19,'777198199','Diego',NULL,'Vargas',NULL,'2013-09-19',NULL,'M','Costarricense',1,NULL),(20,'734044380','Camila',NULL,'Sanchez',NULL,'2012-09-19',NULL,'F','Costarricense',1,NULL),(21,'504771818712','Juan',NULL,'Diaz',NULL,'2018-09-19',NULL,'F','Costarricense',1,NULL),(22,'263965424','Luis',NULL,'Diaz',NULL,'2012-09-19',NULL,'F','Costarricense',1,NULL),(23,'521609148','Juan',NULL,'Sanchez',NULL,'2016-09-19',NULL,'M','Costarricense',1,NULL),(24,'504010086807','Ana',NULL,'Diaz',NULL,'2012-09-19',NULL,'M','Costarricense',1,NULL),(25,'421572492','Javier',NULL,'Sanchez',NULL,'2015-09-19',NULL,'F','Costarricense',1,NULL),(26,'340846524','Valentina',NULL,'Flores',NULL,'2018-09-19',NULL,'F','Costarricense',1,NULL),(27,'504371482805','Camila',NULL,'Perez',NULL,'2016-09-19',NULL,'M','Costarricense',1,NULL),(28,'315431367','Juan',NULL,'Rodriguez',NULL,'2018-09-19',NULL,'F','Costarricense',1,NULL),(29,'121404205','Valentina',NULL,'Gomez',NULL,'2013-09-19',NULL,'F','Costarricense',1,NULL),(30,'726911188','Ana',NULL,'Gomez',NULL,'2015-09-19',NULL,'M','Costarricense',1,NULL),(31,'379759977','Camila',NULL,'Gomez',NULL,'2017-09-19',NULL,'F','Costarricense',1,NULL),(32,'127496220','Diego',NULL,'Ramirez',NULL,'2012-09-19',NULL,'M','Colombiano',1,NULL),(33,'171754395','Maria',NULL,'Gomez',NULL,'2018-09-19',NULL,'M','Costarricense',1,NULL),(34,'415149065','Javier',NULL,'Flores',NULL,'2013-09-19',NULL,'M','Costarricense',1,NULL),(35,'698275075','Maria',NULL,'Perez',NULL,'2016-09-19',NULL,'F','Costarricense',1,NULL),(36,'287395470','Diego',NULL,'Vargas',NULL,'2016-09-19',NULL,'M','Costarricense',1,NULL),(37,'533793298','Javier',NULL,'Flores',NULL,'2013-09-19',NULL,'M','Costarricense',1,NULL),(38,'428517191','Camila',NULL,'Gomez',NULL,'2012-09-19',NULL,'M','Costarricense',1,NULL),(39,'355073571','Luis',NULL,'Rodriguez',NULL,'2014-09-19',NULL,'F','Costarricense',1,NULL),(40,'573866136','Sofia',NULL,'Ramirez',NULL,'2012-09-19',NULL,'F','Costarricense',1,NULL),(41,'329191356','Valentina',NULL,'Rodriguez',NULL,'2014-09-19',NULL,'F','Costarricense',1,NULL),(42,'334912745','Diego',NULL,'Torres',NULL,'2013-09-19',NULL,'F','Costarricense',1,NULL),(43,'591027518','Sofia',NULL,'Flores',NULL,'2013-09-19',NULL,'M','Costarricense',1,NULL),(44,'504223509681','Ana',NULL,'Sanchez',NULL,'2011-09-19',NULL,'F','Costarricense',1,NULL),(45,'124586985','Camila',NULL,'Diaz',NULL,'2011-09-19',NULL,'F','Costarricense',1,NULL),(46,'368801371','Pedro',NULL,'Sanchez',NULL,'2017-09-19',NULL,'M','Costarricense',1,NULL),(47,'337303146','Sofia',NULL,'Rodriguez',NULL,'2017-09-19',NULL,'F','Panameño',1,NULL),(48,'504432495575','Ana',NULL,'Gomez',NULL,'2018-09-19',NULL,'F','Nicaragüense',1,NULL),(49,'282044018','Ana',NULL,'Flores',NULL,'2017-09-19',NULL,'F','Costarricense',1,NULL),(50,'168271444','Valentina',NULL,'Gomez',NULL,'2016-09-19',NULL,'F','Costarricense',1,NULL),(51,'329111447','Javier',NULL,'Rodriguez',NULL,'2019-09-19',NULL,'F','Costarricense',1,NULL),(52,'578928234','Pedro',NULL,'Ramirez',NULL,'2018-09-19',NULL,'M','Costarricense',1,NULL),(53,'369862601','Luis',NULL,'Gomez',NULL,'2019-09-19',NULL,'F','Costarricense',1,NULL),(54,'439242523','Valentina',NULL,'Vargas',NULL,'2012-09-19',NULL,'F','Costarricense',1,NULL),(55,'316384960','Luis',NULL,'Sanchez',NULL,'2011-09-19',NULL,'F','Costarricense',1,NULL),(56,'137043594','Ana',NULL,'Gomez',NULL,'2015-09-19',NULL,'M','Costarricense',1,NULL),(57,'245403851','Maria',NULL,'Sanchez',NULL,'2018-09-19',NULL,'M','Costarricense',1,NULL),(58,'780212028','Diego',NULL,'Perez',NULL,'2011-09-19',NULL,'M','Costarricense',1,NULL),(59,'191965592','Ana',NULL,'Rodriguez',NULL,'2013-09-19',NULL,'F','Costarricense',1,NULL),(60,'446556116','Camila',NULL,'Vargas',NULL,'2017-09-19',NULL,'F','Costarricense',1,NULL),(61,'697994091','Valentina',NULL,'Vargas',NULL,'2014-09-19',NULL,'F','Costarricense',1,NULL),(62,'788997946','Javier',NULL,'Ramirez',NULL,'2016-09-19',NULL,'M','Costarricense',1,NULL),(63,'453698420','Diego',NULL,'Sanchez',NULL,'2011-09-19',NULL,'F','Costarricense',1,NULL),(64,'539407914','Maria',NULL,'Perez',NULL,'2016-09-19',NULL,'M','Costarricense',1,NULL),(65,'621772487','Luis',NULL,'Rodriguez',NULL,'2016-09-19',NULL,'F','Costarricense',1,NULL),(66,'650469070','Juan',NULL,'Torres',NULL,'2019-09-19',NULL,'F','Costarricense',1,NULL),(67,'333941866','Pedro',NULL,'Martinez',NULL,'2014-09-19',NULL,'F','Costarricense',1,NULL),(68,'137521986','Camila',NULL,'Torres',NULL,'2011-09-19',NULL,'F','Costarricense',1,NULL),(69,'551215278','Juan',NULL,'Torres',NULL,'2017-09-19',NULL,'F','Costarricense',1,NULL),(70,'484695289','Maria',NULL,'Diaz',NULL,'2018-09-19',NULL,'F','Costarricense',1,NULL),(71,'152639641','Maria',NULL,'Perez',NULL,'2016-09-19',NULL,'M','Costarricense',1,NULL),(72,'419059868','Maria',NULL,'Vargas',NULL,'2011-09-19',NULL,'F','Costarricense',1,NULL),(73,'504974923698','Valentina',NULL,'Torres',NULL,'2016-09-19',NULL,'M','Colombiano',1,NULL),(74,'196866183','Luis',NULL,'Diaz',NULL,'2012-09-19',NULL,'M','Costarricense',1,NULL),(75,'504702523716','Pedro',NULL,'Ramirez',NULL,'2014-09-19',NULL,'F','Costarricense',1,NULL),(76,'337616357','Ana',NULL,'Perez',NULL,'2013-09-19',NULL,'F','Costarricense',1,NULL),(77,'459652416','Valentina',NULL,'Ramirez',NULL,'2013-09-19',NULL,'F','Costarricense',1,NULL),(78,'245905890','Valentina',NULL,'Vargas',NULL,'2014-09-19',NULL,'F','Costarricense',1,NULL),(79,'135373656','Maria',NULL,'Sanchez',NULL,'2015-09-19',NULL,'M','Costarricense',1,NULL),(80,'395729018','Pedro',NULL,'Rodriguez',NULL,'2012-09-19',NULL,'F','Panameño',1,NULL),(81,'230276295','Luis',NULL,'Rodriguez',NULL,'2014-09-19',NULL,'F','Costarricense',1,NULL),(82,'194717025','Javier',NULL,'Sanchez',NULL,'2015-09-19',NULL,'F','Costarricense',1,NULL),(83,'424193212','Camila',NULL,'Martinez',NULL,'2012-09-19',NULL,'F','Costarricense',1,NULL),(84,'719369515','Luis',NULL,'Flores',NULL,'2019-09-19',NULL,'F','Costarricense',1,NULL),(85,'664037448','Pedro',NULL,'Perez',NULL,'2017-09-19',NULL,'M','Costarricense',1,NULL),(86,'240589584','Sofia',NULL,'Flores',NULL,'2011-09-19',NULL,'M','Costarricense',1,NULL),(87,'663027827','Juan',NULL,'Gomez',NULL,'2012-09-19',NULL,'M','Costarricense',1,NULL),(88,'540448112','Sofia',NULL,'Martinez',NULL,'2011-09-19',NULL,'M','Panameño',1,NULL),(89,'246344136','Diego',NULL,'Martinez',NULL,'2016-09-19',NULL,'M','Costarricense',1,NULL),(90,'524328059','Luis',NULL,'Perez',NULL,'2016-09-19',NULL,'M','Costarricense',1,NULL),(91,'666429581','Sofia',NULL,'Vargas',NULL,'2011-09-19',NULL,'M','Costarricense',1,NULL),(92,'754928135','Ana',NULL,'Ramirez',NULL,'2012-09-19',NULL,'F','Costarricense',1,NULL),(93,'437522188','Valentina',NULL,'Gomez',NULL,'2015-09-19',NULL,'F','Costarricense',1,NULL),(94,'152573503','Maria',NULL,'Ramirez',NULL,'2015-09-19',NULL,'M','Costarricense',1,NULL),(95,'790026125','Valentina',NULL,'Torres',NULL,'2015-09-19',NULL,'F','Costarricense',1,NULL),(96,'373635679','Ana',NULL,'Rodriguez',NULL,'2019-09-19',NULL,'F','Costarricense',1,NULL),(97,'504964398830','Valentina',NULL,'Torres',NULL,'2017-09-19',NULL,'F','Costarricense',1,NULL),(98,'750923905','Pedro',NULL,'Rodriguez',NULL,'2015-09-19',NULL,'M','Nicaragüense',1,NULL),(99,'494623988','Sofia',NULL,'Torres',NULL,'2016-09-19',NULL,'M','Costarricense',1,NULL),(100,'671041852','Sofia',NULL,'Gomez',NULL,'2012-09-19',NULL,'F','Costarricense',1,NULL);
/*!40000 ALTER TABLE `estudiante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estudiante_encargado`
--

DROP TABLE IF EXISTS `estudiante_encargado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estudiante_encargado` (
  `estudiante_id` int NOT NULL,
  `encargado_id` int NOT NULL,
  PRIMARY KEY (`estudiante_id`,`encargado_id`),
  KEY `fk_estudiante_encargado_encargado` (`encargado_id`),
  CONSTRAINT `fk_estudiante_encargado_encargado` FOREIGN KEY (`encargado_id`) REFERENCES `encargado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_estudiante_encargado_estudiante` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiante_encargado`
--

LOCK TABLES `estudiante_encargado` WRITE;
/*!40000 ALTER TABLE `estudiante_encargado` DISABLE KEYS */;
/*!40000 ALTER TABLE `estudiante_encargado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluacion`
--

DROP TABLE IF EXISTS `evaluacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluacion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo_evaluacion_id` int NOT NULL,
  `ciclo_id` int NOT NULL,
  `nombre` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `puntos_totales` tinyint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_evaluacion_ciclo` (`ciclo_id`),
  KEY `fk_evaluacion_tipo_evaluacion` (`tipo_evaluacion_id`),
  CONSTRAINT `fk_evaluacion_ciclo` FOREIGN KEY (`ciclo_id`) REFERENCES `ciclo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_evaluacion_tipo_evaluacion` FOREIGN KEY (`tipo_evaluacion_id`) REFERENCES `tipo_evaluacion` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluacion`
--

LOCK TABLES `evaluacion` WRITE;
/*!40000 ALTER TABLE `evaluacion` DISABLE KEYS */;
INSERT INTO `evaluacion` VALUES (1,2,2,'Evaluación #3',48),(2,4,4,'Evaluación #3',29),(3,4,6,'Evaluación #5',21),(4,3,8,'Evaluación #1',33),(5,4,10,'Evaluación #4',28),(6,2,12,'Evaluación #3',33);
/*!40000 ALTER TABLE `evaluacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grado`
--

DROP TABLE IF EXISTS `grado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grado` (
  `id` int NOT NULL AUTO_INCREMENT,
  `anio_lectivo_id` int NOT NULL,
  `nivel_academico_id` int NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_anio_nivel_unique` (`anio_lectivo_id`,`nivel_academico_id`),
  KEY `fk_grado_nivel_academico` (`nivel_academico_id`),
  CONSTRAINT `fk_grado_anio_lectivo` FOREIGN KEY (`anio_lectivo_id`) REFERENCES `anio_lectivo` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_grado_nivel_academico` FOREIGN KEY (`nivel_academico_id`) REFERENCES `nivel_academico` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grado`
--

LOCK TABLES `grado` WRITE;
/*!40000 ALTER TABLE `grado` DISABLE KEYS */;
INSERT INTO `grado` VALUES (1,1,1,1),(2,1,2,1),(3,1,3,1),(4,1,4,1),(5,1,5,1),(6,1,6,1),(7,2,1,1),(8,2,2,1),(9,2,3,1),(10,2,4,1),(11,2,5,1),(12,2,6,1);
/*!40000 ALTER TABLE `grado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `maestro`
--

DROP TABLE IF EXISTS `maestro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `maestro` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int unsigned NOT NULL,
  `primer_nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `segundo_nombre` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `primer_apellido` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `correo` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nacionalidad` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_maestro_usuario_id_idx` (`usuario_id`),
  CONSTRAINT `fk_maestro_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maestro`
--

LOCK TABLES `maestro` WRITE;
/*!40000 ALTER TABLE `maestro` DISABLE KEYS */;
INSERT INTO `maestro` VALUES (1,3,'Carlos',NULL,'Rojas',NULL,'c.rojas@example.com','Costarricense',1),(2,4,'Luisa',NULL,'Fernandez',NULL,'l.fernandez@example.com','Costarricense',1),(3,5,'Ana',NULL,'Brenes',NULL,'a.brenes@example.com','Panameña',1),(4,6,'Jorge',NULL,'Solis',NULL,'j.solis@example.com','Costarricense',1),(5,7,'Marta',NULL,'Ugalde',NULL,'m.ugalde@example.com','Nicaragüense',1),(6,8,'Pedro',NULL,'Campos',NULL,'p.campos@example.com','Costarricense',1),(7,9,'Sofia',NULL,'Mora',NULL,'s.mora@example.com','Costarricense',1),(8,10,'Ricardo',NULL,'Jimenez',NULL,'r.jimenez@example.com','Salvadoreño',1),(9,11,'Elena',NULL,'Villalobos',NULL,'e.villalobos@example.com','Costarricense',1),(10,12,'Mario',NULL,'Quesada',NULL,'m.quesada@example.com','Costarricense',1);
/*!40000 ALTER TABLE `maestro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `maestro_competencia`
--

DROP TABLE IF EXISTS `maestro_competencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `maestro_competencia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `maestro_id` int NOT NULL,
  `materia_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_maestro_materia_unique` (`maestro_id`,`materia_id`),
  KEY `fk_maestro_competencia_materia` (`materia_id`),
  CONSTRAINT `fk_maestro_competencia_maestro` FOREIGN KEY (`maestro_id`) REFERENCES `maestro` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_maestro_competencia_materia` FOREIGN KEY (`materia_id`) REFERENCES `materia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maestro_competencia`
--

LOCK TABLES `maestro_competencia` WRITE;
/*!40000 ALTER TABLE `maestro_competencia` DISABLE KEYS */;
INSERT INTO `maestro_competencia` VALUES (1,1,1),(2,1,3),(3,2,2),(4,2,4),(5,3,5),(6,4,6),(7,4,8),(8,5,7),(9,6,1),(10,6,7),(11,7,2),(12,7,3),(13,8,4),(14,8,5),(15,9,1),(16,9,2),(17,9,3),(18,9,4),(19,9,5),(20,10,6),(21,10,7),(22,10,8);
/*!40000 ALTER TABLE `maestro_competencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materia`
--

DROP TABLE IF EXISTS `materia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `materia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo` tinyint(1) NOT NULL COMMENT '0 para general y 1 para especialidad',
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materia`
--

LOCK TABLES `materia` WRITE;
/*!40000 ALTER TABLE `materia` DISABLE KEYS */;
INSERT INTO `materia` VALUES (1,0,'Matemáticas',NULL,1),(2,0,'Español',NULL,1),(3,0,'Ciencias',NULL,1),(4,0,'Estudios Sociales',NULL,1),(5,0,'Inglés',NULL,1),(6,1,'Música',NULL,1),(7,1,'Informática',NULL,1),(8,1,'Religión',NULL,1);
/*!40000 ALTER TABLE `materia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_09_19_213542_add_remember_token_to_usuario_table',1),(5,'2025_09_20_232533_update_users_table_for_custom_fields',2),(6,'2025_09_21_011718_add_indexes_to_estudiante_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nivel_academico`
--

DROP TABLE IF EXISTS `nivel_academico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nivel_academico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `orden` tinyint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nivel_academico`
--

LOCK TABLES `nivel_academico` WRITE;
/*!40000 ALTER TABLE `nivel_academico` DISABLE KEYS */;
INSERT INTO `nivel_academico` VALUES (1,'Primer Grado',1),(2,'Segundo Grado',2),(3,'Tercer Grado',3),(4,'Cuarto Grado',4),(5,'Quinto Grado',5),(6,'Sexto Grado',6);
/*!40000 ALTER TABLE `nivel_academico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nota`
--

DROP TABLE IF EXISTS `nota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nota` (
  `id` int NOT NULL AUTO_INCREMENT,
  `evaluacion_id` int NOT NULL,
  `estudiante_id` int NOT NULL,
  `puntos_obtenidos` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_nota_evaluacion` (`evaluacion_id`),
  KEY `fk_nota_estudiante` (`estudiante_id`),
  CONSTRAINT `fk_nota_estudiante` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiante` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_nota_evaluacion` FOREIGN KEY (`evaluacion_id`) REFERENCES `evaluacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nota`
--

LOCK TABLES `nota` WRITE;
/*!40000 ALTER TABLE `nota` DISABLE KEYS */;
INSERT INTO `nota` VALUES (1,2,8,22.93),(2,1,73,36.02),(3,3,42,18.23),(4,3,91,13.98),(5,4,82,32.06),(6,1,92,35.43),(7,1,36,42.61),(8,5,70,18.27),(9,3,18,13.89),(10,2,50,28.72),(11,4,98,27.02),(12,5,13,25.92),(13,5,30,27.33),(14,5,56,22.33),(15,2,11,24.90),(16,6,68,22.90),(17,3,86,14.91),(18,3,7,13.33),(19,2,49,26.52),(20,2,47,27.48),(21,4,72,23.70),(22,2,64,25.06),(23,4,96,29.38),(24,4,88,31.11),(25,4,19,29.31),(26,3,58,19.76),(27,4,84,25.18),(28,2,4,20.68),(29,5,15,23.80),(30,1,93,34.57),(31,1,94,46.69),(32,2,75,28.46),(33,1,55,39.51),(34,6,59,30.54),(35,6,14,26.60),(36,2,95,22.55),(37,6,10,21.14),(38,5,12,19.24),(39,5,90,23.58),(40,4,5,25.77),(41,1,2,44.78),(42,6,76,24.90),(43,4,39,26.66),(44,4,65,32.99),(45,4,21,30.02),(46,4,81,27.36),(47,1,89,46.10),(48,6,35,22.53),(49,2,99,23.63),(50,3,33,20.41),(51,3,1,16.39),(52,6,66,31.40),(53,5,29,18.22),(54,6,22,19.84),(55,6,83,25.59),(56,1,40,40.57),(57,2,79,23.56),(58,6,31,19.97),(59,2,44,24.20),(60,6,41,28.35),(61,2,74,26.21),(62,2,69,25.72),(63,6,3,32.95),(64,1,48,46.88),(65,5,24,22.49),(66,6,20,25.04),(67,4,6,20.08),(68,6,46,31.26),(69,2,26,22.35),(70,6,67,23.42),(71,4,38,32.27),(72,1,71,38.19),(73,3,100,19.82),(74,2,9,22.65),(75,6,77,22.73),(76,4,25,29.94),(77,3,16,19.74),(78,2,97,27.20),(79,1,53,31.14),(80,1,61,41.66),(81,5,27,20.45),(82,4,60,20.27),(83,3,54,17.82),(84,3,63,12.86),(85,4,62,29.95),(86,3,87,18.45),(87,3,23,20.88),(88,5,37,20.49),(89,4,17,22.01),(90,1,32,39.93),(91,4,80,21.32),(92,1,45,46.05),(93,5,51,25.36),(94,5,28,27.25),(95,6,85,20.58),(96,5,57,19.55),(97,2,52,25.36),(98,6,78,26.28),(99,6,43,23.34),(100,4,34,28.37);
/*!40000 ALTER TABLE `nota` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador'),(3,'Encargado'),(2,'Profesor');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sesion_asistencia`
--

DROP TABLE IF EXISTS `sesion_asistencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sesion_asistencia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `carga_academica_id` int NOT NULL,
  `ciclo_id` int NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sesion_asistencia_carga_academica` (`carga_academica_id`),
  KEY `fk_sesion_asistencia_ciclo` (`ciclo_id`),
  CONSTRAINT `fk_sesion_asistencia_carga_academica` FOREIGN KEY (`carga_academica_id`) REFERENCES `carga_academica` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_sesion_asistencia_ciclo` FOREIGN KEY (`ciclo_id`) REFERENCES `ciclo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sesion_asistencia`
--

LOCK TABLES `sesion_asistencia` WRITE;
/*!40000 ALTER TABLE `sesion_asistencia` DISABLE KEYS */;
INSERT INTO `sesion_asistencia` VALUES (1,6,2,'2025-02-27'),(2,7,2,'2025-05-14'),(3,24,2,'2025-06-15'),(4,25,2,'2025-04-06'),(5,27,2,'2025-04-10'),(6,31,2,'2025-06-29'),(7,37,2,'2025-04-28'),(8,44,2,'2025-06-20'),(9,1,4,'2025-06-17'),(10,10,4,'2025-05-24'),(11,13,4,'2025-02-06'),(12,15,4,'2025-06-19'),(13,32,4,'2025-04-18'),(14,38,4,'2025-05-29'),(15,40,4,'2025-03-31'),(16,45,4,'2025-05-01'),(17,47,4,'2025-06-03'),(18,49,4,'2025-03-18'),(19,9,6,'2025-02-08'),(20,11,6,'2025-03-26'),(21,19,6,'2025-05-04'),(22,20,6,'2025-02-05'),(23,33,6,'2025-03-17'),(24,42,6,'2025-03-29'),(25,3,8,'2025-02-03'),(26,4,8,'2025-06-22'),(27,5,8,'2025-05-13'),(28,12,8,'2025-04-23'),(29,21,8,'2025-05-16'),(30,35,8,'2025-06-09'),(31,36,8,'2025-02-28'),(32,43,8,'2025-03-27'),(33,46,8,'2025-03-09'),(34,2,10,'2025-02-23'),(35,14,10,'2025-02-02'),(36,17,10,'2025-05-03'),(37,18,10,'2025-02-02'),(38,22,10,'2025-03-04'),(39,23,10,'2025-02-04'),(40,28,10,'2025-04-14'),(41,29,10,'2025-03-26'),(42,39,10,'2025-03-23'),(43,41,10,'2025-05-01'),(44,48,10,'2025-06-27'),(45,8,12,'2025-02-15'),(46,16,12,'2025-04-24'),(47,26,12,'2025-04-10'),(48,30,12,'2025-05-07'),(49,34,12,'2025-06-02'),(50,50,12,'2025-02-24');
/*!40000 ALTER TABLE `sesion_asistencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('A7fddCBmI13qK8gQLyEvqLibXh9TSnDnBYZaMj2w',NULL,'10.204.232.148','Go-http-client/2.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWnNvS21ONHZBOVFvZW1EcU5FVEE1bDlVank2TWFoVm85M2g4dmtieSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vc2lnZWRyYS5vbnJlbmRlci5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1758438081),('DRPjXeJprv11gfXOH9KWrKOSk0qTqTJpEd9aVvhR',NULL,'127.0.0.1','Go-http-client/1.1','YToyOntzOjY6Il90b2tlbiI7czo0MDoiek9vZFNuQjZuNm9QdGNlV1JPeko1SGlqZHQ1dU11bkVydHllV25GZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1758441245),('FrvsvICAtZsNiHYuMTe8M4HaRNnxF3eyrFplsfBt',NULL,'10.204.232.148','Go-http-client/2.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaFowNVNwdGJnaGdoQjZYYXVCcXYwNXVSSVB6Ulo4ZjMyMU84WVhvYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vc2lnZWRyYS5vbnJlbmRlci5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1758438082),('moGyj7TWYhieI9m8HHm0AmS2KReRiMQFwpYzrDvw',NULL,'10.204.44.75','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ3dGN0VRYzREa3BqZFBDVEc5cGtXdWZvTDdHSUtIRG1yUWpqMWpEOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vc2lnZWRyYS5vbnJlbmRlci5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1758441226),('PL10mMoajWxBtaEIFQ6pwOB4bGgo3wcS1RrnqpT9',NULL,'10.204.232.148','Go-http-client/2.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTmNZVUU2VTR1dWtQTnFUczZSd3NkcHNJZFhWbWtLSmR3TXlBeUZTciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vc2lnZWRyYS5vbnJlbmRlci5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1758441131),('PtVdCMQTLB5zxZE5G2IyypgVukO4oqgy5W4MlsB1',NULL,'127.0.0.1','Go-http-client/1.1','YToyOntzOjY6Il90b2tlbiI7czo0MDoiQXFYVmhQN1JCeE9XanJsYkpneEpVQlA3clFuUkpPWlVlMWZ1cDJiUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1758438077),('UK11zSYNSDF1E2HsXhMdrKERVXSagZ5WI5OW9IGc',NULL,'10.204.232.148','Go-http-client/2.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoieDVIQTZ4ZVNrT2tZcjZTV01TSWRHdk84MG1kckcxNkNWZlRjN3RHUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vc2lnZWRyYS5vbnJlbmRlci5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1758441252),('vR1R64IrgYQnNi0en9BqR5mZ9c2qLXOLC1gQl4w6',NULL,'10.204.232.148','Go-http-client/2.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNlJjZlJZTnNobm5xSzI2THpMczMwT1pqV29QWUxyZ0x4WkxER0thWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vc2lnZWRyYS5vbnJlbmRlci5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1758441251),('xfsy4MWFlp8WyZEU5Wd4T796MWeeK2ANdOUEcYAc',NULL,'10.204.232.148','Go-http-client/2.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNmtzdWlFeDZCUmNreFJWNld5RGVMMEhEVmU2a1ZJOEdveWkyRWI4OCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vc2lnZWRyYS5vbnJlbmRlci5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1758441132),('z6gT3IkBExPaL59iwFHogztrHKThkdLugu2CmcKm',NULL,'127.0.0.1','Go-http-client/1.1','YToyOntzOjY6Il90b2tlbiI7czo0MDoiajM5UGZvRGcyeGU2UWVOVWQxeFhxNUdOV0JNSWhEaTZMcmZqOVM5eCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1758441122);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_ciclo`
--

DROP TABLE IF EXISTS `tipo_ciclo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_ciclo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_ciclo`
--

LOCK TABLES `tipo_ciclo` WRITE;
/*!40000 ALTER TABLE `tipo_ciclo` DISABLE KEYS */;
INSERT INTO `tipo_ciclo` VALUES (1,'I Semestre'),(2,'II Semestre');
/*!40000 ALTER TABLE `tipo_ciclo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_evaluacion`
--

DROP TABLE IF EXISTS `tipo_evaluacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_evaluacion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `activo` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_evaluacion`
--

LOCK TABLES `tipo_evaluacion` WRITE;
/*!40000 ALTER TABLE `tipo_evaluacion` DISABLE KEYS */;
INSERT INTO `tipo_evaluacion` VALUES (1,'Examen',1),(2,'Tarea',1),(3,'Proyecto',1),(4,'Cotidiano',1);
/*!40000 ALTER TABLE `tipo_evaluacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `cedula` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `requiere_cambio_contrasena` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_cedula_unique` (`cedula`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'703030132','Deibis Admin',NULL,NULL,'$2y$12$JD/9prdnorDJPo4lbBk4ZumwUnY8TK2U2G528m88TKIpvUV1tUpna',1,1,NULL,'2025-09-20 23:40:05','2025-09-21 00:50:03'),(2,'201230987','Usuario 201230987',NULL,NULL,'$2y$12$ReK.U1phzyYlfBfnBoc87.P2dRDS.LH2r4wS8YLLMEC0u7u29pBxe',1,1,NULL,'2025-09-20 23:40:06','2025-09-20 23:40:06'),(3,'304560789','Carlos Rojas',NULL,NULL,'$2y$12$XanwLg/rf9kxqxaWQ54eS.qvK5pWx1wvr/AEFgMCJEOe.ZvEPtC4.',1,1,NULL,'2025-09-20 23:40:07','2025-09-20 23:40:07'),(4,'401110222','Luisa Fernandez',NULL,NULL,'$2y$12$LCfurETkEoInY.isDA0B4.mDBJPE1RnmGletJCUhBTFIb5t.rf9we',1,1,NULL,'2025-09-20 23:40:09','2025-09-20 23:40:09'),(5,'503330444','Ana Brenes',NULL,NULL,'$2y$12$7fl6PVu3uokRxlXvK8j7/efDZiaGcavY1s/dCfvh02OFMJ6CNjgc.',1,1,NULL,'2025-09-20 23:40:10','2025-09-20 23:40:10'),(6,'605550666','Jorge Solis',NULL,NULL,'$2y$12$/RSkiusrVQNi9W.38JwOF.5z8ve4sAvYtwlfJMjDur7JS3rZV4cx2',1,1,NULL,'2025-09-20 23:40:12','2025-09-20 23:40:12'),(7,'707770888','Marta Ugalde',NULL,NULL,'$2y$12$fV/.YGdbVwcEDX3HHCocEONCpWb7jLETRAjVyIJ/QG6oaCPQpNgF6',1,1,NULL,'2025-09-20 23:40:13','2025-09-20 23:40:13'),(8,'109990110','Pedro Campos',NULL,NULL,'$2y$12$rKJSfQy9B10yMzmq//vRzeiApsrdbhUk.AuLGqbthWyGaAIUJAv6.',1,1,NULL,'2025-09-20 23:40:15','2025-09-20 23:40:15'),(9,'201210343','Sofia Mora',NULL,NULL,'$2y$12$35EYNPfuyRnQcyDoIk/V5e.lq56FWoivmvmF0HBnn.Spj2qQBQvum',1,1,NULL,'2025-09-20 23:40:16','2025-09-20 23:40:16'),(10,'305650787','Ricardo Jimenez',NULL,NULL,'$2y$12$ZpBpcJdkWoPx6TQTQPCbGOp/g3vE0HUdPiGIyJf50ZatSfd43xFCW',1,1,NULL,'2025-09-20 23:40:18','2025-09-20 23:40:18'),(11,'408980121','Elena Villalobos',NULL,NULL,'$2y$12$fRuf23obeU4qMAXjxiJ4zeyh6m/GGBXEBSJW5g5qwprzL6cohJhHG',1,1,NULL,'2025-09-20 23:40:20','2025-09-20 23:40:20'),(12,'503450678','Mario Quesada',NULL,NULL,'$2y$12$vkjTxgcUOndFQ/UzwVNfT.1xprVioDP1bow6RP3o.pRNaDKYddfdK',1,1,NULL,'2025-09-20 23:40:21','2025-09-20 23:40:21');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_roles`
--

DROP TABLE IF EXISTS `usuario_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario_roles` (
  `usuario_id` int unsigned NOT NULL,
  `rol_id` int NOT NULL,
  PRIMARY KEY (`usuario_id`,`rol_id`),
  KEY `fk_usuario_roles_rol_idx` (`rol_id`),
  KEY `fk_usuario_roles_usuario_idx` (`usuario_id`),
  CONSTRAINT `fk_usuario_roles_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_usuario_roles_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_roles`
--

LOCK TABLES `usuario_roles` WRITE;
/*!40000 ALTER TABLE `usuario_roles` DISABLE KEYS */;
INSERT INTO `usuario_roles` VALUES (1,1),(2,1),(3,2),(4,2),(5,2),(6,2),(7,2),(8,2),(9,2),(10,2),(11,2),(12,2);
/*!40000 ALTER TABLE `usuario_roles` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-21  2:07:08
