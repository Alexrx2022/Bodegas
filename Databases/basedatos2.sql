-- MySQL dump 10.13  Distrib 8.0.25, for Win64 (x86_64)
--
-- Host: localhost    Database: peroject
-- ------------------------------------------------------
-- Server version	8.0.25

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

--
-- Table structure for table `egreso`
--

DROP TABLE IF EXISTS `egreso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `egreso` (
  `codigo` varchar(40) NOT NULL,
  `fecha` timestamp NOT NULL,
  `receptor` varchar(10) NOT NULL,
  `user` int NOT NULL,
  `estado` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `Fkreceptor_idx` (`receptor`),
  KEY `Fkuser_idx` (`user`),
  CONSTRAINT `Fkreceptor` FOREIGN KEY (`receptor`) REFERENCES `receptores` (`cedula`),
  CONSTRAINT `Fkuser` FOREIGN KEY (`user`) REFERENCES `user` (`id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `egreso`
--

LOCK TABLES `egreso` WRITE;
/*!40000 ALTER TABLE `egreso` DISABLE KEYS */;
/*!40000 ALTER TABLE `egreso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `egreso_producto`
--

DROP TABLE IF EXISTS `egreso_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `egreso_producto` (
  `codigo_egreso` varchar(40) NOT NULL,
  `codigo_producto` int NOT NULL,
  `cantidad` int NOT NULL,
  PRIMARY KEY (`codigo_egreso`,`codigo_producto`),
  KEY `Fkcodigo_producto` (`codigo_producto`),
  CONSTRAINT `Fkcodigo_egreso` FOREIGN KEY (`codigo_egreso`) REFERENCES `egreso` (`codigo`),
  CONSTRAINT `Fkcodigo_producto` FOREIGN KEY (`codigo_producto`) REFERENCES `product` (`id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `egreso_producto`
--

LOCK TABLES `egreso_producto` WRITE;
/*!40000 ALTER TABLE `egreso_producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `egreso_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `egreso_producto2`
--

DROP TABLE IF EXISTS `egreso_producto2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `egreso_producto2` (
  `codigo_egreso` varchar(40) NOT NULL,
  `codigo_producto2` int NOT NULL,
  `cantidad` int NOT NULL,
  PRIMARY KEY (`codigo_egreso`,`codigo_producto2`),
  KEY `Fkcodigo_producto2_idx` (`codigo_producto2`),
  CONSTRAINT `FKcodigo_egreso2` FOREIGN KEY (`codigo_egreso`) REFERENCES `egreso` (`codigo`),
  CONSTRAINT `Fkcodigo_producto2` FOREIGN KEY (`codigo_producto2`) REFERENCES `product2` (`id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `egreso_producto2`
--

LOCK TABLES `egreso_producto2` WRITE;
/*!40000 ALTER TABLE `egreso_producto2` DISABLE KEYS */;
/*!40000 ALTER TABLE `egreso_producto2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `proname` varchar(30) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` int DEFAULT NULL,
  `medida` varchar(85) DEFAULT NULL,
  `id_proovedor` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Fkey_id_proovedor_idx` (`id_proovedor`),
  CONSTRAINT `Fkey_id_proovedor` FOREIGN KEY (`id_proovedor`) REFERENCES `proovedores` (`id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product2`
--

DROP TABLE IF EXISTS `product2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product2` (
  `id` int NOT NULL AUTO_INCREMENT,
  `proname` varchar(30) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` int DEFAULT NULL,
  `medida` varchar(85) DEFAULT NULL,
  `id_proovedor` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Fk_id_proovedores2_idx` (`id_proovedor`),
  CONSTRAINT `Fk_id_proovedores2` FOREIGN KEY (`id_proovedor`) REFERENCES `proovedores` (`id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product2`
--

LOCK TABLES `product2` WRITE;
/*!40000 ALTER TABLE `product2` DISABLE KEYS */;
/*!40000 ALTER TABLE `product2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proovedores`
--

DROP TABLE IF EXISTS `proovedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proovedores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` text NOT NULL,
  `email` text,
  `telefono` varchar(45) DEFAULT NULL,
  `direccion` text,
  PRIMARY KEY (`id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proovedores`
--

LOCK TABLES `proovedores` WRITE;
/*!40000 ALTER TABLE `proovedores` DISABLE KEYS */;
/*!40000 ALTER TABLE `proovedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receptores`
--

DROP TABLE IF EXISTS `receptores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `receptores` (
  `cedula` varchar(10) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `apellido` varchar(80) NOT NULL,
  `cargo` varchar(45) DEFAULT NULL,
  `bodega` int DEFAULT NULL,
  PRIMARY KEY (`cedula`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receptores`
--

LOCK TABLES `receptores` WRITE;
/*!40000 ALTER TABLE `receptores` DISABLE KEYS */;
/*!40000 ALTER TABLE `receptores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `permission` int DEFAULT NULL,
  `asignacion` int DEFAULT NULL,
  PRIMARY KEY (`id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-22 19:35:24
