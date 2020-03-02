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
  `alamat` text,
  `kota` varchar(50) DEFAULT NULL,
  `nama_pemilik` varchar(50) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_ag` (`agent_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agent`
--

LOCK TABLES `agent` WRITE;
/*!40000 ALTER TABLE `agent` DISABLE KEYS */;
INSERT INTO `agent` VALUES (6,'12345678','Agent 1','2014-11-14 05:35:55','2014-11-14 05:35:55',1,9000000,'Bandung','Bandung','Owner Agent 1','08978286741'),(7,'00000swi','Sriwijaya','2014-11-14 15:23:13','2014-11-14 15:23:13',1,0,'Kalidoni','Palembang','Ifan Fachrudin','');
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bailout`
--

LOCK TABLES `bailout` WRITE;
/*!40000 ALTER TABLE `bailout` DISABLE KEYS */;
INSERT INTO `bailout` VALUES (11,'12345678',0,0,1,0,0,0,NULL),(12,'87654321',0,0,2,0,0,0,NULL),(13,'00000swi',0,0,1,0,0,0,NULL),(14,'swi00001',0,0,2,0,0,0,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `balance_log`
--

LOCK TABLES `balance_log` WRITE;
/*!40000 ALTER TABLE `balance_log` DISABLE KEYS */;
INSERT INTO `balance_log` VALUES (44,1,'12345678',1,0,10000000,2,NULL,'2014-11-14 05:36:14','2014-11-14 05:36:26','indonesia','indonesia',NULL),(45,1,'87654321',2,0,1000000,2,NULL,'2014-11-14 05:37:42','2014-11-14 05:37:51','indonesia','indonesia','12345678');
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deposit`
--

LOCK TABLES `deposit` WRITE;
/*!40000 ALTER TABLE `deposit` DISABLE KEYS */;
INSERT INTO `deposit` VALUES (11,'12345678',10000000,9000000,1),(12,'87654321',1000000,186500,2),(13,'00000swi',0,0,1),(14,'swi00001',0,0,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `neraca`
--

LOCK TABLES `neraca` WRITE;
/*!40000 ALTER TABLE `neraca` DISABLE KEYS */;
INSERT INTO `neraca` VALUES (87,'12345678','2014-11-14 05:36:26',0,0,1,0,10000000,1,1,10000000),(88,'87654321','2014-11-14 05:37:51',0,0,1,0,1000000,1,2,1000000),(89,'12345678','2014-11-14 05:37:51',0,0,5,10000000,9000000,2,1,-1000000),(90,'87654321','2014-11-14 09:45:16',1,1,82,1000000,871500,2,2,128500),(91,'87654321','2014-11-14 13:17:59',1,1,82,743000,614500,2,2,128500),(92,'87654321','2014-11-14 05:52:56',1,1,82,486000,357500,2,2,128500);
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
  `alamat` text,
  `kota` varchar(50) DEFAULT NULL,
  `nama_pemilik` varchar(50) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `outlet_log`
--

LOCK TABLES `outlet_log` WRITE;
/*!40000 ALTER TABLE `outlet_log` DISABLE KEYS */;
INSERT INTO `outlet_log` VALUES (22,'12345678',1,'Agent 1',2,'2014-11-14 05:35:44','2014-11-14 05:35:55','indonesia','indonesia',NULL,'Bandung','Bandung','Owner Agent 1','08978286741'),(23,'87654321',2,'PP Agent 1',2,'2014-11-14 05:37:00','2014-11-14 05:37:16','indonesia','indonesia','12345678','Bandung','Bandung','Owner PP Agent 1','08978286741'),(24,'00000swi',1,'Sriwijaya',2,'2014-11-14 15:22:55','2014-11-14 15:23:12','indonesia','indonesia',NULL,'Kalidoni','Palembang','Ifan Fachrudin',''),(25,'swi00001',2,'Swriwijaya 01',2,'2014-11-14 15:24:37','2014-11-14 15:25:13','indonesia','indonesia','00000swi','Kalidoni','Palembang','Muhammad Chotami','');
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
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `outlet_product`
--

LOCK TABLES `outlet_product` WRITE;
/*!40000 ALTER TABLE `outlet_product` DISABLE KEYS */;
INSERT INTO `outlet_product` VALUES (68,'12345678',1,1,3500),(69,'12345678',1,2,3500),(70,'12345678',1,3,3500),(71,'12345678',1,4,3500),(72,'12345678',1,5,3500),(73,'12345678',1,6,3500),(74,'12345678',1,7,3500),(75,'12345678',1,8,3500),(76,'12345678',1,9,3500),(77,'12345678',1,10,3500),(78,'12345678',1,11,3500),(79,'12345678',1,12,3500),(80,'12345678',1,13,3500),(81,'87654321',2,1,3500),(82,'87654321',2,2,3500),(83,'87654321',2,3,3500),(84,'87654321',2,4,3500),(85,'87654321',2,5,3500),(86,'87654321',2,6,3500),(87,'87654321',2,7,3500),(88,'87654321',2,8,3500),(89,'87654321',2,9,3500),(90,'87654321',2,10,3500),(91,'87654321',2,11,3500),(92,'87654321',2,12,3500),(93,'87654321',2,13,3500);
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
  `alamat` text,
  `kota` varchar(50) DEFAULT NULL,
  `nama_pemilik` varchar(50) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_point`
--

LOCK TABLES `payment_point` WRITE;
/*!40000 ALTER TABLE `payment_point` DISABLE KEYS */;
INSERT INTO `payment_point` VALUES (6,'87654321','PP Agent 1','2014-11-14 05:37:16','2014-11-14 05:37:16',1,1000000,'12345678','Agent 1',NULL,'Bandung','Bandung','Owner PP Agent 1','08978286741'),(7,'swi00001','Swriwijaya 01','2014-11-14 15:25:14','2014-11-14 15:25:14',1,0,'00000swi','Sriwijaya',NULL,'Kalidoni','Palembang','Muhammad Chotami','');
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
  `is_used` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pp_user`
--

LOCK TABLES `pp_user` WRITE;
/*!40000 ALTER TABLE `pp_user` DISABLE KEYS */;
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
INSERT INTO `product` VALUES (1,'PDAM',3500,'00001',1),(2,'Telkomsel Postpaid',3500,'02002',1),(3,'Excelcomindo Postpaid',3500,'02004',1),(4,'Smartfren Prepaid',3500,'02005',0),(5,'Smartfren Postpaid',3500,'02006',1),(6,'Esia Prepaid',3500,'02007',0),(7,'Esia Postpaid',3500,'02008',1),(8,'Telkom',3500,'02009',1),(9,'Flexi Prepaid',3500,'02010',0),(10,'Indosat Prepaid',3500,'02013',0),(11,'Axis Prepaid',3500,'02014',0),(12,'Three Prepaid',3500,'02018',0),(13,'Indosat Prepaid',3500,'02020',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_log`
--

LOCK TABLES `transaction_log` WRITE;
/*!40000 ALTER TABLE `transaction_log` DISABLE KEYS */;
INSERT INTO `transaction_log` VALUES (187,1,'87654321','12345678','152.118.24.10','','2014-11-14 09:45:04',0,0,'00',1,1,'002192345600  '),(188,2,'87654321','12345678','152.118.24.10','','2014-11-14 09:45:15',125000,3500,'00',1,1,'002192345600  '),(189,1,'87654321','12345678','152.118.24.10','','2014-11-14 09:45:45',0,0,'00',1,1,'088812345600  '),(190,2,'87654321','12345678','152.118.24.10','','2014-11-14 09:45:57',125000,3500,'BB',1,1,'088812345600  '),(191,1,'87654321','12345678','152.118.24.10','','2014-11-14 09:50:22',0,0,'BB',0,0,'00367855561    '),(192,1,'87654321','12345678','152.118.24.10','','2014-11-14 09:51:58',0,0,'00',1,1,'00367855561    '),(193,1,'87654321','12345678','152.118.24.10','','2014-11-14 09:53:06',0,0,'00',1,1,'00367855561    '),(194,1,'87654321','12345678','203.130.228.18','','2014-11-14 13:17:29',0,0,'00',1,1,'002192345600  '),(195,2,'87654321','12345678','203.130.228.18','','2014-11-14 13:17:47',125000,3500,'00',1,1,'002192345600  '),(196,1,'87654321','12345678','203.130.228.18','','2014-11-14 13:19:08',0,0,'00',1,1,'088812345600  '),(197,2,'87654321','12345678','203.130.228.18','','2014-11-14 13:19:33',125000,3500,'BB',1,1,'088812345600  '),(198,1,'87654321','12345678','203.130.228.18','','2014-11-14 13:22:14',0,0,'00',1,1,'088812345600  '),(199,1,'87654321','12345678','203.130.228.18','','2014-11-14 13:24:59',0,0,'00',1,1,'00367855561    '),(200,1,'87654321','12345678','203.130.228.18','','2014-11-14 13:26:45',0,0,'00',1,1,'00367855561    '),(201,1,'87654321','12345678','203.130.228.18','','2014-11-14 05:50:23',0,0,'BB',0,0,'002192345600  '),(202,1,'87654321','12345678','203.130.228.18','','2014-11-14 05:52:41',0,0,'00',1,1,'002192345600  '),(203,2,'87654321','12345678','203.130.228.18','','2014-11-14 05:52:54',125000,3500,'00',1,1,'002192345600  '),(204,1,'87654321','12345678','203.130.228.18','','2014-11-14 05:55:41',0,0,'69',1,1,'02192345600    '),(205,1,'87654321','12345678','203.130.228.18','','2014-11-14 05:56:57',0,0,'00',1,1,'00367855561    '),(206,1,'87654321','12345678','203.130.228.18','','2014-11-14 05:58:20',0,0,'00',1,1,'00367855561    '),(207,1,'87654321','12345678','203.130.228.18','','2014-11-14 06:02:07',0,0,'00',1,1,'00367855561    '),(208,2,'87654321','12345678','203.130.228.18','','2014-11-14 06:02:16',0,0,'15',1,0,'367855561    d'),(209,1,'87654321','12345678','203.130.228.18','','2014-11-14 06:08:11',0,0,'BB',0,0,'00367855561    '),(210,1,'87654321','12345678','203.130.228.18','','2014-11-14 06:09:52',0,0,'00',1,1,'00367855561    '),(211,2,'87654321','12345678','203.130.228.18','','2014-11-14 06:10:11',0,0,'BB',1,0,'367855561    d'),(212,1,'87654321','12345678','203.130.228.18','','2014-11-14 06:12:44',0,0,'00',1,1,'00367855561    '),(213,2,'87654321','12345678','203.130.228.18','','2014-11-14 06:13:02',0,0,'15',1,0,'367855561    d'),(214,1,'87654321','12345678','203.130.228.18','','2014-11-14 06:14:21',0,0,'00',1,1,'00367855561    '),(215,2,'87654321','12345678','203.130.228.18','','2014-11-14 06:14:29',0,0,'15',1,0,'367855561    d'),(216,1,'87654321','12345678','203.130.228.18','','2014-11-14 06:17:51',0,0,'00',1,1,'00367855561    '),(217,2,'87654321','12345678','203.130.228.18','','2014-11-14 06:18:03',0,0,'15',1,0,'367855561    d'),(218,1,'87654321','12345678','203.130.228.18','','2014-11-14 06:23:55',0,0,'00',1,1,'60076343112    '),(219,2,'87654321','12345678','203.130.228.18','','2014-11-14 06:24:10',0,0,'15',1,0,'076343112    F'),(220,1,'87654321','12345678','203.130.228.18','','2014-11-14 06:29:46',0,0,'48',1,1,'113000100561   '),(221,1,'87654321','12345678','203.130.228.18','','2014-11-14 06:30:14',0,0,'00',1,1,'00367855561    '),(222,1,'87654321','12345678','203.130.228.18','','2014-11-14 06:31:13',0,0,'47',1,1,'0051111111     '),(223,1,'87654321','12345678','203.130.228.18','','2014-11-14 06:31:29',0,0,'90',1,1,'16010002       '),(224,1,'87654321','12345678','203.130.228.18','','2014-11-14 06:31:54',0,0,'00',1,1,'00411850001    '),(225,2,'87654321','12345678','203.130.228.18','','2014-11-14 06:32:35',0,0,'15',1,0,'411850001    M'),(226,1,'87654321','12345678','203.130.228.18','','2014-11-14 15:07:42',0,0,'BB',0,0,'002198765100  '),(227,2,'87654321','12345678','203.130.228.18','','2014-11-14 15:28:06',25000,3500,'BB',1,0,'002198765100  '),(228,2,'87654321','12345678','203.130.228.18','','2014-11-14 15:32:43',25000,3500,'BB',1,0,'002198765100  '),(229,1,'87654321','12345678','203.130.228.18','','2014-11-14 15:37:59',0,0,'BB',0,0,'002192345600  '),(230,2,'87654321','12345678','203.130.228.18','','2014-11-14 15:38:30',25000,3500,'BB',1,0,'002198765100  '),(231,2,'87654321','12345678','203.130.228.18','','2014-11-14 15:45:08',25000,3500,'BB',1,0,'002198765100  '),(232,1,'87654321','12345678','203.130.228.18','','2014-11-14 15:46:19',0,0,'BB',0,0,'002192345600  '),(233,1,'87654321','12345678','203.130.228.18','','2014-11-14 15:49:43',0,0,'BB',0,0,'002192345600  '),(234,1,'87654321','12345678','203.130.228.18','','2014-11-14 16:17:50',0,0,'BB',0,0,'002192345600  '),(235,2,'87654321','12345678','203.130.228.18','','2014-11-14 16:23:46',25000,3500,'BB',1,0,'002198765100  '),(236,2,'87654321','12345678','203.130.228.18','','2014-11-14 16:26:37',25000,3500,'BB',1,0,'002198765100  ');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'indonesia','cbfdac6008f9cab4083784cbd1874f76618d2a97',1,'Administrator','2014-09-14 12:30:00',1,1,1,'ASDF12345');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_access`
--

LOCK TABLES `user_access` WRITE;
/*!40000 ALTER TABLE `user_access` DISABLE KEYS */;
INSERT INTO `user_access` VALUES (1,1,'_all_');
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

-- Dump completed on 2014-11-15  5:28:54
