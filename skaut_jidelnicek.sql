-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: skautsky_jidelnicek
-- ------------------------------------------------------
-- Server version	5.7.17-0ubuntu0.16.04.1

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
-- Table structure for table `jidlo`
--

DROP TABLE IF EXISTS `jidlo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jidlo` (
  `id_jidlo` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(60) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_jidlo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jidlo`
--

LOCK TABLES `jidlo` WRITE;
/*!40000 ALTER TABLE `jidlo` DISABLE KEYS */;
INSERT INTO `jidlo` VALUES (1,'Grenadýr'),(2,'Bramborový guláš');
/*!40000 ALTER TABLE `jidlo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jidlo_typ`
--

DROP TABLE IF EXISTS `jidlo_typ`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jidlo_typ` (
  `id_jidlo` int(11) NOT NULL,
  `id_typ` int(11) NOT NULL,
  PRIMARY KEY (`id_jidlo`,`id_typ`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jidlo_typ`
--

LOCK TABLES `jidlo_typ` WRITE;
/*!40000 ALTER TABLE `jidlo_typ` DISABLE KEYS */;
INSERT INTO `jidlo_typ` VALUES (1,3),(1,4),(2,3),(2,4);
/*!40000 ALTER TABLE `jidlo_typ` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receptura`
--

DROP TABLE IF EXISTS `receptura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `receptura` (
  `id_jidlo` int(11) NOT NULL,
  `id_surovina` int(11) NOT NULL,
  `mnozstvi` int(11) NOT NULL,
  PRIMARY KEY (`id_jidlo`,`id_surovina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receptura`
--

LOCK TABLES `receptura` WRITE;
/*!40000 ALTER TABLE `receptura` DISABLE KEYS */;
INSERT INTO `receptura` VALUES (2,1,4000),(2,2,2),(2,3,2000),(2,4,5),(2,5,200),(2,6,1),(2,7,1);
/*!40000 ALTER TABLE `receptura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surovina`
--

DROP TABLE IF EXISTS `surovina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surovina` (
  `id_surovina` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(60) COLLATE utf8_czech_ci NOT NULL,
  `jednotka` varchar(5) COLLATE utf8_czech_ci NOT NULL,
  `typ` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_surovina`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surovina`
--

LOCK TABLES `surovina` WRITE;
/*!40000 ALTER TABLE `surovina` DISABLE KEYS */;
INSERT INTO `surovina` VALUES (1,'brambory','g','zelenina'),(2,'chleba','ks','pečivo'),(3,'točeňák','g','maso'),(4,'cibule','ks','zelenina'),(5,'mouka','g','ostatní'),(6,'majoránka','ks','koření'),(7,'mrkev','ks','zelenina'),(9,'červená paprika','ks','koření'),(11,'mleko','l','mléčné výrobky');
/*!40000 ALTER TABLE `surovina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `typ`
--

DROP TABLE IF EXISTS `typ`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `typ` (
  `id_typ` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_typ`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typ`
--

LOCK TABLES `typ` WRITE;
/*!40000 ALTER TABLE `typ` DISABLE KEYS */;
INSERT INTO `typ` VALUES (1,'snídaně'),(2,'svačina'),(3,'oběd'),(4,'večeře');
/*!40000 ALTER TABLE `typ` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-15 19:40:25
