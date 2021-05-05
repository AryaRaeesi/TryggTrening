CREATE DATABASE  IF NOT EXISTS `Nettbutikk` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `Nettbutikk`;
-- MySQL dump 10.13  Distrib 5.7.32, for osx10.12 (x86_64)
--
-- Host: 127.0.0.1    Database: Nettbutikk
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
-- Table structure for table `Kunde`
--

DROP TABLE IF EXISTS `Kunde`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Kunde` (
  `idKunde` int(11) NOT NULL,
  `Fornavn` varchar(45) NOT NULL,
  `Etternavn` varchar(45) NOT NULL,
  `By` varchar(45) NOT NULL,
  `Gate` varchar(45) NOT NULL,
  `Gatenummer` int(11) NOT NULL,
  `E-post` varchar(45) NOT NULL,
  `Poststed_Postnummer` varchar(4) NOT NULL,
  PRIMARY KEY (`idKunde`),
  KEY `fk_Kunde_Poststed1_idx` (`Poststed_Postnummer`),
  CONSTRAINT `fk_Kunde_Poststed1` FOREIGN KEY (`Poststed_Postnummer`) REFERENCES `Poststed` (`Postnummer`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Kunde`
--

LOCK TABLES `Kunde` WRITE;
/*!40000 ALTER TABLE `Kunde` DISABLE KEYS */;
/*!40000 ALTER TABLE `Kunde` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Ordre`
--

DROP TABLE IF EXISTS `Ordre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Ordre` (
  `idOrdre` int(11) NOT NULL,
  `Kunde_idKunde` int(11) NOT NULL,
  PRIMARY KEY (`idOrdre`),
  KEY `fk_Ordre_Kunde1_idx` (`Kunde_idKunde`),
  CONSTRAINT `fk_Ordre_Kunde1` FOREIGN KEY (`Kunde_idKunde`) REFERENCES `Kunde` (`idKunde`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Ordre`
--

LOCK TABLES `Ordre` WRITE;
/*!40000 ALTER TABLE `Ordre` DISABLE KEYS */;
/*!40000 ALTER TABLE `Ordre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Ordrelinje`
--

DROP TABLE IF EXISTS `Ordrelinje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Ordrelinje` (
  `idOrdrelinje` int(11) NOT NULL,
  `Ordre_idOrdre` int(11) NOT NULL,
  `Produkt_idProdukt` int(11) NOT NULL,
  `Antall varer` int(11) NOT NULL,
  PRIMARY KEY (`idOrdrelinje`),
  KEY `fk_Ordrelinje_Ordre1_idx` (`Ordre_idOrdre`),
  KEY `fk_Ordrelinje_Produkt1_idx` (`Produkt_idProdukt`),
  CONSTRAINT `fk_Ordrelinje_Ordre1` FOREIGN KEY (`Ordre_idOrdre`) REFERENCES `Ordre` (`idOrdre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Ordrelinje_Produkt1` FOREIGN KEY (`Produkt_idProdukt`) REFERENCES `Produkt` (`idProdukt`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Ordrelinje`
--

LOCK TABLES `Ordrelinje` WRITE;
/*!40000 ALTER TABLE `Ordrelinje` DISABLE KEYS */;
/*!40000 ALTER TABLE `Ordrelinje` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Poststed`
--

DROP TABLE IF EXISTS `Poststed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Poststed` (
  `Poststed` varchar(45) NOT NULL,
  `Postnummer` varchar(4) NOT NULL,
  PRIMARY KEY (`Postnummer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Poststed`
--

LOCK TABLES `Poststed` WRITE;
/*!40000 ALTER TABLE `Poststed` DISABLE KEYS */;
/*!40000 ALTER TABLE `Poststed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Produkt`
--

DROP TABLE IF EXISTS `Produkt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Produkt` (
  `idProdukt` int(11) NOT NULL,
  `Produkt_navn` varchar(45) NOT NULL,
  `Merke` varchar(45) NOT NULL,
  `Bilde` varchar(45) NOT NULL,
  `Pris` int(11) NOT NULL,
  PRIMARY KEY (`idProdukt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Produkt`
--

LOCK TABLES `Produkt` WRITE;
/*!40000 ALTER TABLE `Produkt` DISABLE KEYS */;
INSERT INTO `Produkt` VALUES (1,'Sko','Nike','',999),(2,'T-skjorte','Adidas','',299),(3,'Bukse','Puma','',199),(4,'Lue','Reebok','',99);
/*!40000 ALTER TABLE `Produkt` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-29 15:18:24
