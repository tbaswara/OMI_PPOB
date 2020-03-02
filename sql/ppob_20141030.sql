CREATE DATABASE  IF NOT EXISTS `ppob_v2` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ppob_v2`;
-- MySQL dump 10.13  Distrib 5.6.19, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: ppob_v2
-- ------------------------------------------------------
-- Server version	5.6.19

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
  `agent_id` varchar(20) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1' COMMENT '1=access;\r\n2=blocked',
  `balance` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_ag` (`agent_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agent`
--

LOCK TABLES `agent` WRITE;
/*!40000 ALTER TABLE `agent` DISABLE KEYS */;
INSERT INTO `agent` VALUES (11,'000001','Salman El Farisi','2014-09-15 16:55:30',NULL,1,2500000),(12,'000002','Topan Bayu Kusuma','2014-09-15 16:55:30',NULL,1,2750000);
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
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bailout`
--

LOCK TABLES `bailout` WRITE;
/*!40000 ALTER TABLE `bailout` DISABLE KEYS */;
/*!40000 ALTER TABLE `bailout` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `daily_bailout` AFTER UPDATE ON `bailout`
 FOR EACH ROW insert into bailout_log (outlet_id, outlet_type, bailout_type, date_created, amount) value (new.outlet_id, new.outlet_type, new.bailout_type, now(), new.bailout)
; */;;
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
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `balance_log`
--

LOCK TABLES `balance_log` WRITE;
/*!40000 ALTER TABLE `balance_log` DISABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deposit`
--

LOCK TABLES `deposit` WRITE;
/*!40000 ALTER TABLE `deposit` DISABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `neraca`
--

LOCK TABLES `neraca` WRITE;
/*!40000 ALTER TABLE `neraca` DISABLE KEYS */;
INSERT INTO `neraca` VALUES (20,'001BDGPP','2014-09-15 17:10:00',1,1,80,1000000,936500,2,2,63500),(21,'001BDGPP','2014-09-15 17:13:00',1,1,82,936500,873000,2,2,63500),(22,'001BDGPP','2014-09-15 17:25:00',1,1,92,873000,809500,2,2,63500),(23,'001BDGPP','2014-09-17 06:00:00',1,1,1,809500,1109500,1,2,300000),(24,'001BDGPP','2014-09-17 06:33:00',1,1,80,1109500,986000,2,2,123500),(25,'001BDGPP','2014-09-17 11:00:00',1,1,92,986000,847500,2,2,138500);
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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `outlet_log`
--

LOCK TABLES `outlet_log` WRITE;
/*!40000 ALTER TABLE `outlet_log` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `outlet_product`
--

LOCK TABLES `outlet_product` WRITE;
/*!40000 ALTER TABLE `outlet_product` DISABLE KEYS */;
INSERT INTO `outlet_product` VALUES (1,'001BDGPP',2,1,3500),(2,'001BDGPP',2,2,3500),(3,'001BDGPP',2,3,3500),(4,'001BDGPP',2,4,3500),(5,'001BDGPP',2,5,3500),(6,'001BDGPP',2,6,3500),(7,'001BDGPP',2,7,3500),(8,'001BDGPP',2,8,3500),(9,'001BDGPP',2,9,3500),(10,'001BDGPP',2,10,3500);
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
  `pp_id` varchar(20) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1=access;\r\n2=blocked',
  `balance` double DEFAULT NULL,
  `agent_id` varchar(20) DEFAULT NULL,
  `agent_name` varchar(100) DEFAULT NULL,
  `ip_address` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_point`
--

LOCK TABLES `payment_point` WRITE;
/*!40000 ALTER TABLE `payment_point` DISABLE KEYS */;
INSERT INTO `payment_point` VALUES (6,'001BDGPP','Big Zaman','2014-09-15 17:05:22',NULL,1,500000,'11','Salman El Farisi','127.0.0.1'),(7,'022DPKPP','Pulung Ragil','2014-09-15 17:05:22',NULL,1,600000,'12','Topan Bayu Kusuma','127.0.0.1');
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pp_user`
--

LOCK TABLES `pp_user` WRITE;
/*!40000 ALTER TABLE `pp_user` DISABLE KEYS */;
INSERT INTO `pp_user` VALUES (1,'001BDGPP','demo','cbfdac6008f9cab4083784cbd1874f76618d2a97','b4083784cb');
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'TELKOM',3500,'02009'),(2,'SMARTFREN-PRE',3500,'02005'),(3,'XL',3500,'02004'),(4,'TELKOMSEL',3500,'02002'),(5,'SMARTFREN-POST',3500,'02006'),(6,'ESIA-POST',3500,'02008'),(7,'ESIA-PRE',3500,'02007'),(8,'STARONE',3500,'02020'),(9,'THREE',3500,'02018'),(10,'INDOSAT',3500,'02013');
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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subproduct`
--

LOCK TABLES `subproduct` WRITE;
/*!40000 ALTER TABLE `subproduct` DISABLE KEYS */;
INSERT INTO `subproduct` VALUES (1,1,'0001','TELKOM GROUP',0),(2,1,'0002','TELKOM SPEEDY',0),(3,1,'0003','TELKOM SOLUTION',0),(4,2,'0001','SMARTFREN 25K',25000),(5,2,'0002','SMARTFREN 50K',50000),(6,2,'0002','SMARTFREN 100K',100000),(7,3,'0001','XL POST PAID',0),(8,5,'0001','SMARTFREN POSTPAID',0),(9,6,'0001','ESIA POSTPAID',0),(10,8,'0002','STARONE 10K',10000),(11,8,'0003','STARONE 50K',50000),(12,8,'0004','STARONE 100K',100000),(13,10,'0001','MENTARI REGULAR 5K',5000),(14,10,'0002','MENTARI REGULAR 10K',10000),(15,10,'0004','MENTARI REGULAR 25K',25000),(16,10,'0005','MENTARI REGULAR 50K',50000),(17,10,'0006','MENTARI REGULAR 100K',100000),(18,10,'0011','IM3 REGULAR 5K',5000),(19,10,'0012','IM3 REGULAR 10K',10000),(20,10,'0014','IM3 REGULAR 25K',25000),(21,10,'0015','IM3 REGULAR 50K',50000),(22,10,'0016','IM3 REGULAR 100K',100000),(23,10,'0017','IM3 SMS 5K',5000),(24,7,'0001','ESIA PREPAID 25K',25000),(25,7,'0002','ESIA PREPAID 50K',50000),(26,7,'0003','ESIA PREPAID 100K',100000),(27,7,'0004','ESIA PREPAID 150K',150000),(28,7,'0005','ESIA PREPAID 250K',250000),(29,7,'0008','ESIA PREPAID 5K',5000),(30,7,'0009','ESIA PREPAID 10K',10000),(31,7,'0010','ESIA PREPAID 20K',20000),(32,9,'0001','THREE PREPAID 10K',10000),(33,9,'0003','THREE PREPAID 50K',50000),(34,9,'0004','THREE PREPAID 100K',100000),(35,9,'0009','THREE PREPAID 20K',20000),(36,9,'0010','THREE PREPAID 30K',30000);
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
  `nomor_rekening` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_log`
--

LOCK TABLES `transaction_log` WRITE;
/*!40000 ALTER TABLE `transaction_log` DISABLE KEYS */;
INSERT INTO `transaction_log` VALUES (2,2,'1BJMI0001BDGPP','000001','127.0.0.1','XX:XX:XX:XX','2014-09-15 17:10:00',60000,3500,'',1,1,'555300200'),(3,2,'1BJMI0001BDGPP','000001','127.0.0.1','XX:XX:XX:XX','2014-08-15 17:11:00',60000,3500,'',1,1,'555300200'),(4,2,'1BJMI0001BDGPP','000001','127.0.0.1','XX:XX:XX:XX','2014-07-15 17:10:00',60000,3500,'',1,1,'555300200');
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'salman.farisi','password123',1,'Salman El Farisi','2014-09-14 12:30:00',0,1,1,'ASDF12345');
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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_access`
--

LOCK TABLES `user_access` WRITE;
/*!40000 ALTER TABLE `user_access` DISABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
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

-- Dump completed on 2014-10-30 16:50:33
