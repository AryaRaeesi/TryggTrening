CREATE DATABASE  IF NOT EXISTS `Nettbutikk2` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `Nettbutikk2`;
-- MySQL dump 10.13  Distrib 5.7.32, for osx10.12 (x86_64)
--
-- Host: 127.0.0.1    Database: Nettbutikk2
-- ------------------------------------------------------
-- Server version	5.7.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Alternativ`
--

DROP TABLE IF EXISTS `Alternativ`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Alternativ` (
  `idAlternativ` int(11) NOT NULL AUTO_INCREMENT,
  `Størrelse` varchar(45) NOT NULL,
  PRIMARY KEY (`idAlternativ`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Alternativ`
--

LOCK TABLES `Alternativ` WRITE;
/*!40000 ALTER TABLE `Alternativ` DISABLE KEYS */;
/*!40000 ALTER TABLE `Alternativ` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Produkt`
--

DROP TABLE IF EXISTS `Produkt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Produkt` (
  `idProdukt` int(11) NOT NULL AUTO_INCREMENT,
  `Navn` varchar(45) NOT NULL,
  `Merke` varchar(45) NOT NULL,
  `Bilde` varchar(45) NOT NULL,
  `Pris` float NOT NULL,
  `Varelager` int(11) DEFAULT NULL,
  PRIMARY KEY (`idProdukt`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Produkt`
--

LOCK TABLES `Produkt` WRITE;
/*!40000 ALTER TABLE `Produkt` DISABLE KEYS */;
INSERT INTO `Produkt` VALUES (1,'Sko','Nike','Nike-sko.jpeg',999.9,150),(2,'T-skjorte','Adidas','T-skjorte-adidas.jpeg',299.9,150),(3,'Bukse','Puma','Bukse-Puma.jpeg',199.9,150),(4,'Lue','Reebok','Lue-Reebok.jpeg',99.9,150);
/*!40000 ALTER TABLE `Produkt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Produktalternativ`
--

DROP TABLE IF EXISTS `Produktalternativ`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Produktalternativ` (
  `idProduktalternativ` int(11) NOT NULL AUTO_INCREMENT,
  `Produkt_idProdukt` int(11) NOT NULL,
  `Alternativ_idAlternativ` int(11) NOT NULL,
  PRIMARY KEY (`idProduktalternativ`),
  KEY `fk_Produktalternativ_Produkt1_idx` (`Produkt_idProdukt`),
  KEY `fk_Produktalternativ_Alternativ1_idx` (`Alternativ_idAlternativ`),
  CONSTRAINT `fk_Produktalternativ_Alternativ1` FOREIGN KEY (`Alternativ_idAlternativ`) REFERENCES `Alternativ` (`idAlternativ`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Produktalternativ_Produkt1` FOREIGN KEY (`Produkt_idProdukt`) REFERENCES `Produkt` (`idProdukt`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Produktalternativ`
--

LOCK TABLES `Produktalternativ` WRITE;
/*!40000 ALTER TABLE `Produktalternativ` DISABLE KEYS */;
/*!40000 ALTER TABLE `Produktalternativ` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-05-02 19:39:47
