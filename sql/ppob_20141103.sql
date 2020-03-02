CREATE DATABASE  IF NOT EXISTS `ppob_v2` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ppob_v2`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: ppob_v2
-- ------------------------------------------------------
-- Server version	5.1.73

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
-- Table structure for table `agent`
--

DROP TABLE IF EXISTS `agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` varchar(8) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1' COMMENT '1=access;\r\n2=blocked',
  `balance` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_ag` (`agent_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agent`
--

LOCK TABLES `agent` WRITE;
/*!40000 ALTER TABLE `agent` DISABLE KEYS */;
INSERT INTO `agent` VALUES (1,'00000OMI','Online Media Indonesia','2014-11-01 16:00:23','2014-11-01 16:00:23',1,1000000),(2,'agentOMI','Iwan','2014-11-01 16:00:26','2014-11-01 16:00:26',1,3000000),(3,'SWI00001','Sriwijaya Indah','2014-11-02 21:49:23','2014-11-02 21:49:23',1,10000000),(4,'00000ola','ola','2014-11-02 23:50:02','2014-11-02 23:50:02',1,0),(5,'12345678','ABCD','2014-11-03 12:33:12','2014-11-03 12:33:12',1,500000);
/*!40000 ALTER TABLE `agent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bailout`
--

DROP TABLE IF EXISTS `bailout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bailout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outlet_id` varchar(20) NOT NULL COMMENT 'merujuk id agent atau payment point',
  `opening_bailout` double DEFAULT NULL,
  `bailout` double DEFAULT NULL,
  `outlet_type` int(5) NOT NULL COMMENT '1=agent 2=paymentpoint',
  `daily_bailout` double DEFAULT '0',
  `weekly_bailout` double DEFAULT '0',
  `monthly_bailout` double DEFAULT '0',
  `bailout_type` int(11) DEFAULT NULL COMMENT '1=manual;\r\n2=daily;\r\n3=weekly;\r\n4=monthly;',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bailout`
--

LOCK TABLES `bailout` WRITE;
/*!40000 ALTER TABLE `bailout` DISABLE KEYS */;
INSERT INTO `bailout` VALUES (1,'00000OMI',0,0,1,0,0,0,NULL),(2,'agentOMI',0,0,1,0,0,0,NULL),(3,'00IwanPP',0,0,2,0,0,0,NULL),(4,'IWAN0001',0,0,2,0,0,0,NULL),(5,'SWI00001',0,0,1,0,0,0,NULL),(6,'SWI00001',0,0,2,0,0,0,NULL),(7,'SWI00002',0,0,2,0,0,0,NULL),(8,'00000ola',0,0,1,0,0,0,NULL),(9,'12345678',0,0,1,0,0,0,NULL),(10,'00000ABC',0,0,2,0,0,0,NULL);
/*!40000 ALTER TABLE `bailout` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `daily_bailout` AFTER UPDATE ON `bailout`
 FOR EACH ROW insert into bailout_log (outlet_id, outlet_type, bailout_type, date_created, amount) value (new.outlet_id, new.outlet_type, new.bailout_type, now(), new.bailout) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `bailout_log`
--

DROP TABLE IF EXISTS `bailout_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bailout_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bailout_type` int(11) DEFAULT NULL COMMENT '1=manual;\r\n2=daily;\r\n3=weekly;\r\n4=monthly;',
  `outlet_id` varchar(20) DEFAULT NULL,
  `outlet_type` int(11) DEFAULT NULL COMMENT '1=agent;\r\n2=payment-point;',
  `date_created` datetime DEFAULT NULL,
  `amount` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bailout_log`
--

LOCK TABLES `bailout_log` WRITE;
/*!40000 ALTER TABLE `bailout_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `bailout_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `balance_log`
--

DROP TABLE IF EXISTS `balance_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `balance_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `balance_type` int(11) DEFAULT NULL COMMENT '1=deposit;\r\n2=talangan;\r\n3=talangan-harian;\r\n4=talangan-mingguan;\r\n5=talangan-bulanan;',
  `outlet_id` varchar(20) DEFAULT NULL,
  `outlet_type` int(11) DEFAULT NULL COMMENT '1=agent;\r\n2=payment_point',
  `opening_balance` double DEFAULT NULL,
  `balance_change` double DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1=added;\r\n2=approved;\r\n3=rejected',
  `ip_address` double DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `user_requested` varchar(50) DEFAULT NULL,
  `user_approved` varchar(50) DEFAULT NULL,
  `agent_id` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `balance_log`
--

LOCK TABLES `balance_log` WRITE;
/*!40000 ALTER TABLE `balance_log` DISABLE KEYS */;
INSERT INTO `balance_log` VALUES (1,2,'agentOMI',1,0,100000,2,NULL,'2014-11-01 16:02:00','2014-11-01 16:07:24','indonesia','indonesia',NULL),(2,2,'agentOMI',1,0,10000000,2,NULL,'2014-11-01 16:09:03','2014-11-01 16:10:41','indonesia','indonesia',NULL),(3,1,'agentOMI',1,0,5000000,2,NULL,'2014-11-01 16:22:52','2014-11-01 16:23:27','indonesia','indonesia',NULL),(4,1,'00IwanPP',2,0,1000000,2,NULL,'2014-11-01 16:23:57','2014-11-01 16:24:16','indonesia','indonesia','agentOMI'),(5,2,'00000OMI',1,0,10000000,2,NULL,'2014-11-01 16:35:03','2014-11-01 16:35:19','indonesia','indonesia',NULL),(6,1,'IWAN0001',2,0,1000000,2,NULL,'2014-11-01 15:52:45','2014-11-01 15:52:56','indonesia','indonesia','agentOMI'),(7,2,'agentOMI',1,0,1000000,2,NULL,'2014-11-01 15:53:52','2014-11-01 15:54:43','indonesia','indonesia',NULL),(8,2,'agentOMI',1,0,1000000,1,NULL,'2014-11-01 15:56:54',NULL,'indonesia',NULL,NULL),(9,1,'00000OMI',1,0,1000000,2,NULL,'2014-11-01 19:14:52','2014-11-01 19:22:59','indonesia','indonesia',NULL),(10,1,'SWI00001',1,0,5000000,2,NULL,'2014-11-02 21:51:32','2014-11-02 21:51:44','indonesia','indonesia',NULL),(11,1,'IWAN0001',2,1000000,2000000,1,NULL,'2014-11-02 22:03:11',NULL,'indonesia',NULL,'agentOMI'),(12,1,'SWI00001',1,5000000,5000000,2,NULL,'2014-11-02 22:03:32','2014-11-02 22:04:40','indonesia','indonesia',NULL),(13,1,'00000ola',1,0,1000000,1,NULL,'2014-11-03 12:22:36',NULL,'indonesia',NULL,NULL),(14,1,'12345678',1,0,1000000,2,NULL,'2014-11-03 12:41:00','2014-11-03 12:41:29','indonesia','indonesia',NULL),(15,1,'00000ABC',2,0,500000,2,NULL,'2014-11-03 12:56:32','2014-11-03 12:56:49','indonesia','indonesia','12345678'),(16,2,'00000ola',1,0,1000000,2,NULL,'2014-11-03 12:57:20','2014-11-03 12:57:35','indonesia','indonesia',NULL);
/*!40000 ALTER TABLE `balance_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deposit`
--

DROP TABLE IF EXISTS `deposit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deposit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outlet_id` varchar(20) NOT NULL COMMENT 'merujuk ke id agent/payment_point',
  `opening_deposit` double DEFAULT '0',
  `deposit` double DEFAULT NULL,
  `outlet_type` int(5) NOT NULL COMMENT '1=agent 2=paymentpoint',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deposit`
--

LOCK TABLES `deposit` WRITE;
/*!40000 ALTER TABLE `deposit` DISABLE KEYS */;
INSERT INTO `deposit` VALUES (1,'00000OMI',1000000,1000000,1),(2,'agentOMI',5000000,3000000,1),(3,'00IwanPP',1000000,1000000,2),(4,'IWAN0001',1000000,1000000,2),(5,'SWI00001',10000000,10000000,1),(6,'SWI00001',0,0,2),(7,'SWI00002',0,0,2),(8,'00000ola',0,0,1),(9,'12345678',1000000,500000,1),(10,'00000ABC',500000,500000,2);
/*!40000 ALTER TABLE `deposit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `neraca`
--

DROP TABLE IF EXISTS `neraca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `neraca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outlet_id` varchar(20) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `account` int(11) DEFAULT NULL,
  `sheet` int(11) DEFAULT NULL,
  `note` int(11) DEFAULT NULL COMMENT '1=kredit;\r\n2=debet-prepaid electricity;\r\n3=debet-postpaid electricity;\r\n4=debet-postpaid telephone;\r\n5=debet-pp;',
  `opening_balance` double DEFAULT NULL,
  `balance` double DEFAULT NULL,
  `debet_credit` double DEFAULT NULL,
  `outlet_type` int(11) DEFAULT NULL,
  `balance_change` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `neraca`
--

LOCK TABLES `neraca` WRITE;
/*!40000 ALTER TABLE `neraca` DISABLE KEYS */;
INSERT INTO `neraca` VALUES (1,'agentOMI','2014-11-01 16:23:27',0,0,1,0,5000000,1,1,5000000),(2,'00IwanPP','2014-11-01 16:24:16',0,0,1,0,1000000,1,2,1000000),(3,'agentOMI','2014-11-01 16:24:16',0,0,1,5000000,4000000,1,1,-1000000),(4,'IWAN0001','2014-11-01 15:52:56',0,0,1,0,1000000,1,2,1000000),(5,'agentOMI','2014-11-01 15:52:56',0,0,1,4000000,3000000,1,1,-1000000),(6,'00000OMI','2014-11-01 19:22:59',0,0,1,0,1000000,1,1,1000000),(7,'SWI00001','2014-11-02 21:51:44',0,0,1,0,5000000,1,1,5000000),(8,'SWI00001','2014-11-02 22:04:40',0,0,1,5000000,10000000,1,1,5000000),(9,'12345678','2014-11-03 12:41:29',0,0,1,0,1000000,1,1,1000000),(10,'00000ABC','2014-11-03 12:56:49',0,0,1,0,500000,1,2,500000),(11,'12345678','2014-11-03 12:56:49',0,0,1,1000000,500000,1,1,-500000);
/*!40000 ALTER TABLE `neraca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `outlet_log`
--

DROP TABLE IF EXISTS `outlet_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `outlet_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outlet_id` varchar(20) DEFAULT NULL,
  `outlet_type` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1=added;2=approved;3=rejected',
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `user_requested` varchar(50) DEFAULT NULL,
  `user_approved` varchar(50) DEFAULT NULL,
  `agent_id` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `outlet_log`
--

LOCK TABLES `outlet_log` WRITE;
/*!40000 ALTER TABLE `outlet_log` DISABLE KEYS */;
INSERT INTO `outlet_log` VALUES (1,'agentOMI',1,'Iwan',3,'2014-11-01 15:57:28','2014-11-01 16:00:28','indonesia','indonesia',NULL),(2,'agentOMI',1,'Iwan',2,'2014-11-01 15:58:19','2014-11-01 16:00:26','indonesia','indonesia',NULL),(3,'00000OMI',1,'Online Media Indonesia',2,'2014-11-01 15:58:39','2014-11-01 16:00:23','indonesia','indonesia',NULL),(4,NULL,2,'Online Media 01',2,'2014-11-01 16:02:15','2014-11-01 16:02:40','indonesia','indonesia','00000OMI'),(5,NULL,2,'IWAN 01',2,'2014-11-01 16:06:48','2014-11-01 16:07:24','indonesia','indonesia','agentOMI'),(6,'00IwanPP',2,'Payment Point Iwan',2,'2014-11-01 16:19:16','2014-11-01 16:20:00','indonesia','indonesia','agentOMI'),(7,'',1,'Online Media 01',1,'2014-11-01 16:19:53','2014-11-01 16:19:53','staff',NULL,NULL),(8,'cobaonli',2,'mediaonline',1,'2014-11-01 16:22:40','2014-11-01 16:22:40','indonesia',NULL,'agentOMI'),(9,'cobaonli',2,'mediaonline',1,'2014-11-01 16:22:57','2014-11-01 16:22:57','indonesia',NULL,'agentOMI'),(10,NULL,2,'IWAN 01',1,'2014-11-01 16:28:14','2014-11-01 16:28:14','staff',NULL,'agentOMI'),(11,'',1,'Online Media 01',1,'2014-11-01 16:44:31','2014-11-01 16:44:31','indonesia',NULL,NULL),(12,'000omi01',1,'Online Media 01',1,'2014-11-01 08:45:20','2014-11-01 08:45:20','indonesia',NULL,NULL),(13,'0omi0001',1,'Online Media 01',1,'2014-11-01 08:46:03','2014-11-01 08:46:03','indonesia',NULL,NULL),(14,'IWAN0001',2,'IWAN 01',2,'2014-11-01 15:51:48','2014-11-01 15:52:09','indonesia','indonesia','agentOMI'),(15,'SWI00001',1,'Sriwijaya Indah',2,'2014-11-02 21:49:03','2014-11-02 21:49:23','indonesia','indonesia',NULL),(16,'SWI00001',2,'Sriwijaya Indah',2,'2014-11-02 21:49:48','2014-11-02 21:49:58','indonesia','indonesia','SWI00001'),(17,'SWI00002',2,'SWI 02',2,'2014-11-02 22:05:55','2014-11-02 22:06:57','indonesia','indonesia','SWI00001'),(18,'00000ola',1,'ola',2,'2014-11-02 23:49:37','2014-11-02 23:50:02','ifan','ifan',NULL),(19,'12345678',1,'ABCD',2,'2014-11-03 12:32:50','2014-11-03 12:33:12','indonesia','indonesia',NULL),(20,'ABCDEFGH',1,'Adzar Karomy',1,'2014-11-03 12:37:52','2014-11-03 12:37:52','indonesia',NULL,NULL),(21,'00000ABC',2,'Loket ABC',2,'2014-11-03 12:44:14','2014-11-03 12:44:24','indonesia','indonesia','12345678');
/*!40000 ALTER TABLE `outlet_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `outlet_product`
--

DROP TABLE IF EXISTS `outlet_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `outlet_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outlet_id` varchar(100) NOT NULL,
  `outlet_type` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `admin_value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `outlet_product`
--

LOCK TABLES `outlet_product` WRITE;
/*!40000 ALTER TABLE `outlet_product` DISABLE KEYS */;
INSERT INTO `outlet_product` VALUES (1,'00000OMI',1,1,3500),(2,'00000OMI',1,2,3500),(3,'00000OMI',1,3,3500),(4,'00000OMI',1,4,3500),(5,'00000OMI',1,5,3500),(6,'00000OMI',1,6,3500),(7,'00000OMI',1,7,3500),(8,'00000OMI',1,8,3500),(9,'00000OMI',1,9,3500),(10,'00000OMI',1,10,3500),(11,'00000OMI',1,11,3500),(12,'00000OMI',1,12,3500),(13,'00000OMI',1,13,3500),(14,'agentOMI',1,1,3500),(15,'agentOMI',1,2,3500),(16,'agentOMI',1,3,3500),(17,'agentOMI',1,4,3500),(18,'agentOMI',1,5,3500),(19,'agentOMI',1,6,3500),(20,'agentOMI',1,7,3500),(21,'agentOMI',1,8,3500),(22,'agentOMI',1,9,3500),(23,'agentOMI',1,10,3500),(27,'agentOMI',1,11,3500),(28,'agentOMI',1,12,3500),(29,'agentOMI',1,13,3500),(30,'00IwanPP',2,1,3500),(31,'00IwanPP',2,2,3500),(32,'00IwanPP',2,3,3500),(33,'00IwanPP',2,4,3500),(34,'00IwanPP',2,5,3500),(35,'00IwanPP',2,6,3500),(36,'00IwanPP',2,7,3500),(37,'00IwanPP',2,8,3500),(38,'00IwanPP',2,9,3500),(39,'00IwanPP',2,10,3500),(40,'00IwanPP',2,11,3500),(41,'00IwanPP',2,12,3500),(42,'00IwanPP',2,13,3500),(43,'SWI00001',1,1,3500),(44,'SWI00001',1,2,3500),(45,'SWI00001',1,3,3500),(46,'SWI00001',1,4,3500),(47,'SWI00001',1,5,3500),(48,'SWI00001',1,6,3500),(49,'SWI00001',1,7,3500),(50,'SWI00001',1,9,3500),(51,'SWI00001',1,10,3500),(52,'SWI00001',1,11,3500),(53,'SWI00001',1,12,3500),(54,'SWI00001',1,13,3500),(55,'SWI00001',2,1,3500),(56,'SWI00001',2,2,3500),(57,'SWI00001',2,3,3500),(58,'SWI00001',2,4,3500),(59,'SWI00001',2,5,3500),(60,'SWI00001',2,6,3500),(61,'SWI00001',2,7,3500),(62,'SWI00001',2,9,3500),(63,'SWI00001',2,10,3500),(64,'SWI00001',2,11,3500),(65,'SWI00001',2,12,3500),(66,'SWI00001',2,13,3500),(67,'00000ola',1,1,2500);
/*!40000 ALTER TABLE `outlet_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_point`
--

DROP TABLE IF EXISTS `payment_point`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_point` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pp_id` varchar(8) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1=access;\r\n2=blocked',
  `balance` double DEFAULT NULL,
  `agent_id` varchar(8) DEFAULT NULL,
  `agent_name` varchar(100) DEFAULT NULL,
  `ip_address` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_point`
--

LOCK TABLES `payment_point` WRITE;
/*!40000 ALTER TABLE `payment_point` DISABLE KEYS */;
INSERT INTO `payment_point` VALUES (1,'00IwanPP','Payment Point Iwan','2014-11-01 16:20:00','2014-11-01 16:20:00',1,1000000,'agentOMI','Iwan',NULL),(2,'IWAN0001','IWAN 01','2014-11-01 15:52:09','2014-11-01 15:52:09',1,1000000,'agentOMI','Iwan',NULL),(3,'SWI00001','Sriwijaya Indah','2014-11-02 21:49:58','2014-11-02 21:49:58',1,0,'SWI00001','Sriwijaya Indah',NULL),(4,'SWI00002','SWI 02','2014-11-02 22:06:57','2014-11-02 22:06:57',1,0,'SWI00001','Sriwijaya Indah',NULL),(5,'00000ABC','Loket ABC','2014-11-03 12:44:24','2014-11-03 12:44:24',1,500000,'12345678','ABCD',NULL);
/*!40000 ALTER TABLE `payment_point` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pp_user`
--

DROP TABLE IF EXISTS `pp_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pp_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pp_id` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `auth_token` varchar(100) DEFAULT NULL,
  `is_use` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pp_user`
--

LOCK TABLES `pp_user` WRITE;
/*!40000 ALTER TABLE `pp_user` DISABLE KEYS */;
INSERT INTO `pp_user` VALUES (1,'00IwanPP','adzar','f21f652466b6e55a455e0749260ef8ae66e60290','12345678',0),(2,'00IwanPP','adzar','643fec50e79c69bc6bbb7616afd3904acf40867c','12345',0),(3,'00IwanPP','topan','7c4a8d09ca3762af61e59520943dc26494f8941b','98765',0),(4,'SWI00001','swi','8cb2237d0679ca88db6464eac60da96345513964','123456',0);
/*!40000 ALTER TABLE `pp_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `default_admin_value` int(11) NOT NULL,
  `product_code` varchar(5) NOT NULL,
  `is_postpaid` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'PDAM',3500,'00001',0),(2,'Telkomsel Postpaid',3500,'02002',0),(3,'Excelcomindo Postpaid',3500,'02004',0),(4,'Smartfren Prepaid',3500,'02005',0),(5,'Smartfren Postpaid',3500,'02006',0),(6,'Esia Prepaid',3500,'02007',0),(7,'Esia Postpaid',3500,'02008',0),(8,'Telkom',3500,'02009',0),(9,'Flexi Prepaid',3500,'02010',0),(10,'Indosat Prepaid',3500,'02013',0),(11,'Axis Prepaid',3500,'02014',0),(12,'Three Prepaid',3500,'02018',0),(13,'Indosat Prepaid',3500,'02020',0);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subproduct`
--

DROP TABLE IF EXISTS `subproduct`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subproduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(5) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `nominal` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fg_subproduct_product_idx` (`product_id`),
  CONSTRAINT `fg_subproduct_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subproduct`
--

LOCK TABLES `subproduct` WRITE;
/*!40000 ALTER TABLE `subproduct` DISABLE KEYS */;
INSERT INTO `subproduct` VALUES (1,1,'0001','PDAM Palembang',0),(2,1,'0002','PDAM Lampung',0),(3,1,'0004','PAM Aetra Jakarta',0),(4,1,'0005','PAM Palyja Jakarta',0),(5,1,'0006','PDAM Kota Bekasi',0),(6,1,'0009','PDAM Jambi',0),(7,1,'0011','PDAM Kota Bandung',0),(8,1,'0013','PDAM Malang',0),(9,1,'0021','PDAM Kota Bogor',0),(10,1,'0022','PDAM Kab Bogor',0),(11,2,'0001','Kartu Halo',0),(12,3,'0001','XL Pasca Bayar',0),(13,4,'0001','Smartfren Pra Bayar 25K',25000),(14,4,'0002','Smartfren Pra Bayar 50K',50000),(15,4,'0003','Smartfren Pra Bayar 100K',100000),(16,4,'0004','Smartfren Pra Bayar 150K',150000),(17,4,'0005','Smartfren Pra Bayar 200K',200000),(18,4,'0006','Smartfren Pra Bayar 300K',300000),(19,4,'0007','Smartfren Pra Bayar 500K',500000),(20,4,'0008','Smartfren Pra Bayar 10K',10000),(21,4,'0009','Smartfren Pra Bayar 20K',20000),(22,4,'0010','Smartfren Pra Bayar 5K',5000),(23,5,'0001','Smartfren Pasca Bayar',0),(24,6,'0001','Esia Pra Bayar 25K',25000),(25,6,'0002','Esia Pra Bayar 50K',50000),(26,6,'0003','Esia Pra Bayar 100K',100000),(27,6,'0004','Esia Pra Bayar 150K',150000),(28,6,'0005','Esia Pra Bayar 250K',250000),(29,6,'0008','Esia Pra Bayar 5K',5000),(30,6,'0009','Esia Pra Bayar 10K',10000),(31,6,'0010','Esia Pra Bayar 20K',20000),(32,7,'0010','Esia Pasca Bayar',0),(33,8,'0001','Telkom Group',0),(34,8,'0001','Telkom Speedy',0),(35,8,'0001','Telkom Solution',0),(36,9,'0002','Flexi Pra Bayar 50K',50000),(37,9,'0003','Flexi Pra Bayar 100K',100000),(38,9,'0004','Flexi Pra Bayar 150K',150000),(39,9,'0005','Flexi Pra Bayar 250K',250000),(40,9,'0006','Flexi Pra Bayar 5K',5000),(41,9,'0007','Flexi Pra Bayar 10K',10000),(42,9,'0008','Flexi Pra Bayar 20K',20000),(43,9,'0009','Flexi Pra Bayar 200K',200000),(44,9,'0010','Flexi Pra Bayar 300K',300000),(45,9,'0011','Flexi Pra Bayar 350K',350000),(46,9,'0012','Flexi Pra Bayar 500K',500000),(47,10,'0001','Mentari Regular 5K',5000),(48,10,'0002','Mentari Regular 10K',10000),(49,10,'0004','Mentari Regular 25K',25000),(50,10,'0005','Mentari Regular 50K',50000),(51,10,'0006','Mentari Regular 100K',100000),(52,10,'0011','IM3 Regular 5K',5000),(53,10,'0012','IM3 Regular 10K',10000),(54,10,'0014','IM3 Regular 25K',25000),(55,10,'0015','IM3 Regular 50K',50000),(56,10,'0016','IM3 Regular 100K',100000),(57,10,'0017','IM3 SMS 5K',5000),(58,11,'0001','Axis Prabayar 10K',10000),(59,11,'0002','Axis Prabayar 25K',25000),(60,11,'0003','Axis Prabayar 50K',50000),(61,11,'0004','Axis Prabayar 100K',100000),(62,11,'0007','Axis Prabayar 5K',5000),(63,12,'0001','Three Prabayar 10K',10000),(64,12,'0003','Three Prabayar 50K',50000),(65,12,'0004','Three Prabayar 100K',100000),(66,12,'0009','Three Prabayar 20K',20000),(67,12,'0010','Three Prabayar 30K',30000),(68,13,'0002','STARONE 10K',10000),(69,13,'0004','STARONE 50K',50000),(70,13,'0005','STARONE 100K',100000);
/*!40000 ALTER TABLE `subproduct` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_log`
--

DROP TABLE IF EXISTS `transaction_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_type` int(11) DEFAULT NULL COMMENT '1=inquiry;\r\n2=paryment;',
  `pp_id` varchar(20) DEFAULT NULL,
  `agent_id` varchar(20) DEFAULT NULL,
  `ip_address` varchar(20) DEFAULT NULL,
  `mac_address` varchar(20) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `trans_value` double DEFAULT NULL,
  `admin_value` double DEFAULT NULL,
  `feedback` varchar(10) DEFAULT NULL COMMENT '00=success;\r\n68=timeout;\r\n51=defisit balance',
  `total_rekening` int(11) DEFAULT NULL,
  `total_bulan` int(11) DEFAULT NULL,
  `nomor_rekening` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_log`
--

LOCK TABLES `transaction_log` WRITE;
/*!40000 ALTER TABLE `transaction_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaction_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_summary`
--

DROP TABLE IF EXISTS `transaction_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction_summary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pp_id` varchar(20) DEFAULT NULL,
  `total_rekening` int(11) DEFAULT NULL,
  `total_bulan` int(11) DEFAULT NULL,
  `total_tagihan` double DEFAULT NULL,
  `total_admin` double DEFAULT NULL,
  `agent_id` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_summary`
--

LOCK TABLES `transaction_summary` WRITE;
/*!40000 ALTER TABLE `transaction_summary` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaction_summary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` int(11) DEFAULT NULL COMMENT '1=maker;2=viewer;3=checker',
  `name` varchar(200) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `is_admin` int(1) DEFAULT '0',
  `is_checker` int(1) DEFAULT '0',
  `is_maker` int(1) DEFAULT '0',
  `auth_token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_1` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'indonesia','cbfdac6008f9cab4083784cbd1874f76618d2a97',1,'Administrator','2014-09-14 12:30:00',1,1,1,'ASDF12345'),(2,'staff','f21f652466b6e55a455e0749260ef8ae66e60290',NULL,'OMI Staff','2014-11-01 15:57:29',0,0,1,NULL),(3,'staff2','f21f652466b6e55a455e0749260ef8ae66e60290',NULL,'OMI Staff 2','2014-11-01 15:51:17',0,1,1,NULL),(4,'sriwijaya','df2ab971fd2c72f2271a4b43ae640068bf52df76',NULL,'Sriwijaya Indah','2014-11-02 22:54:45',1,1,1,NULL),(6,'ifan','fc7b723efed862126a689402ef8a85e80e0d9059',NULL,'Ifan Fachrudin','2014-11-02 22:59:21',1,1,1,NULL),(7,'ame','61b12f20b071d7eef4c99aeaf1c6c77cc999bd9c',NULL,'Muhammad Chotami','2014-11-02 23:05:30',1,1,1,NULL),(8,'azaola','22d0e6582e710aced3057682af3bf2c51b236b1e',NULL,'azaola','2014-11-02 23:47:59',1,0,0,NULL),(9,'abcd','81fe8bfe87576c3ecb22426f8e57847382917acf',NULL,'ABCD','2014-11-03 12:46:46',1,1,1,NULL),(10,'abcdmaker','04fc7f9d271f125944a44e28b3e84948c686abc8',NULL,'ABCD Maker','2014-11-03 12:50:03',0,0,1,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_access`
--

DROP TABLE IF EXISTS `user_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `access_id` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_access`
--

LOCK TABLES `user_access` WRITE;
/*!40000 ALTER TABLE `user_access` DISABLE KEYS */;
INSERT INTO `user_access` VALUES (1,1,'_all_'),(2,2,'_all_'),(3,3,'_all_'),(4,4,'_all_'),(5,6,'_all_'),(6,7,'_all_'),(7,8,'_all_'),(8,9,'_all_'),(9,10,'12345678');
/*!40000 ALTER TABLE `user_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_log`
--

DROP TABLE IF EXISTS `user_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` int(11) DEFAULT NULL COMMENT '1=created;\r\n2=modified;\r\n3=deleted',
  `date_created` datetime DEFAULT NULL,
  `user_requested` varchar(50) DEFAULT NULL,
  `user_approved` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_log`
--

LOCK TABLES `user_log` WRITE;
/*!40000 ALTER TABLE `user_log` DISABLE KEYS */;
INSERT INTO `user_log` VALUES (13,2,1,'2014-11-01 15:57:29',NULL,NULL),(14,3,1,'2014-11-01 15:51:17',NULL,NULL),(15,4,1,'2014-11-02 22:54:45',NULL,NULL),(16,6,1,'2014-11-02 22:59:21',NULL,NULL),(17,7,1,'2014-11-02 23:05:30',NULL,NULL),(18,8,1,'2014-11-02 23:47:59',NULL,NULL),(19,9,1,'2014-11-03 12:46:46',NULL,NULL),(20,10,1,'2014-11-03 12:50:03',NULL,NULL);
/*!40000 ALTER TABLE `user_log` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-11-03 18:20:20
