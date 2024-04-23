-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: fisiohumana
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `annexes`
--

DROP TABLE IF EXISTS `annexes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `annexes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url_image` varchar(45) NOT NULL,
  `clinic_historys` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `annexes_FK` (`clinic_historys`),
  CONSTRAINT `annexes_FK` FOREIGN KEY (`clinic_historys`) REFERENCES `clinic_historys` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `annexes`
--

LOCK TABLES `annexes` WRITE;
/*!40000 ALTER TABLE `annexes` DISABLE KEYS */;
/*!40000 ALTER TABLE `annexes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `appointment`
--

DROP TABLE IF EXISTS `appointment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `appointment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `diagnostic` varchar(100) NOT NULL,
  `cost` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `appointment_FK` (`person_id`),
  CONSTRAINT `appointment_FK` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment`
--

LOCK TABLES `appointment` WRITE;
/*!40000 ALTER TABLE `appointment` DISABLE KEYS */;
/*!40000 ALTER TABLE `appointment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clinic_historys`
--

DROP TABLE IF EXISTS `clinic_historys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clinic_historys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emergency_number` varchar(10) NOT NULL,
  `diagnostic` varchar(50) NOT NULL,
  `background` varchar(100) NOT NULL,
  `referring_physician` varchar(45) DEFAULT NULL,
  `medical_evaluation` mediumtext NOT NULL,
  `recommended_sessions` int(11) NOT NULL,
  `attending_physician` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clinic_historys`
--

LOCK TABLES `clinic_historys` WRITE;
/*!40000 ALTER TABLE `clinic_historys` DISABLE KEYS */;
/*!40000 ALTER TABLE `clinic_historys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clinical_evolutions`
--

DROP TABLE IF EXISTS `clinical_evolutions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clinical_evolutions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `description` mediumtext NOT NULL,
  `attending_physycian` varchar(45) NOT NULL,
  `clinic_history` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `clinical_evolutions_FK` (`clinic_history`),
  CONSTRAINT `clinical_evolutions_FK` FOREIGN KEY (`clinic_history`) REFERENCES `clinic_historys` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clinical_evolutions`
--

LOCK TABLES `clinical_evolutions` WRITE;
/*!40000 ALTER TABLE `clinical_evolutions` DISABLE KEYS */;
/*!40000 ALTER TABLE `clinical_evolutions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `identification_types`
--

DROP TABLE IF EXISTS `identification_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `identification_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `identification_types`
--

LOCK TABLES `identification_types` WRITE;
/*!40000 ALTER TABLE `identification_types` DISABLE KEYS */;
INSERT INTO `identification_types` VALUES (1,'cedula de ciudadania'),(2,'tarjeta de identidad'),(3,'cedula de extranjeria'),(4,'registro civil'),(5,'permiso especial de permanencia');
/*!40000 ALTER TABLE `identification_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `people`
--

DROP TABLE IF EXISTS `people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `identification_number` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `cell_phone` varchar(10) NOT NULL,
  `identification_type` int(11) NOT NULL,
  `residence_address` varchar(45) DEFAULT NULL,
  `occupation` varchar(50) DEFAULT NULL,
  `birthdate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `people_FK` (`identification_type`),
  CONSTRAINT `people_FK` FOREIGN KEY (`identification_type`) REFERENCES `identification_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `people`
--

LOCK TABLES `people` WRITE;
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
INSERT INTO `people` VALUES (15,'Jesse','torres','000','jesse@gmail.com','3112728638',1,'kr 10 20','hogar','2023-03-29 00:00:00'),(16,'Sara','Rincon','89562','SaraR@gmail.com','111111',4,'bog  137','Estudiante','2023-03-29 00:00:00'),(17,'Claudia ','torres','52','claudia2@gmail.com','000312',3,'kr 10 20','oo','2023-03-29 00:00:00');
/*!40000 ALTER TABLE `people` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `profile` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,'Shelsy Angelica ','garcia','Paciente','shelsy1110@hotmail.com','222'),(5,'santiago','torres','Funcionario','ys99torres@gmail.com','111'),(6,'Sara','Torres','Paciente','saraT@gmailcom','111');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'fisiohumana'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-07-31 11:11:22
