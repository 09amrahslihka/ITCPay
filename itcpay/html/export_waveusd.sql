-- MySQL dump 10.13  Distrib 5.7.13, for Linux (x86_64)
--
-- Host: localhost    Database: db_paymentshub
-- ------------------------------------------------------
-- Server version	5.7.13-0ubuntu0.16.04.2

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
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `bank_name` varchar(200) DEFAULT NULL,
  `branch_address` varchar(500) DEFAULT NULL,
  `branch_city` varchar(45) DEFAULT NULL,
  `swift` varchar(200) DEFAULT NULL,
  `account_number` varchar(200) DEFAULT NULL,
  `bic` varchar(255) DEFAULT NULL,
  `iban` varchar(255) DEFAULT NULL,
  `sort_code` varchar(255) DEFAULT NULL,
  `account_number_uk` varchar(255) DEFAULT NULL,
  `account_type` varchar(255) DEFAULT NULL,
  `routing_number` varchar(255) DEFAULT NULL,
  `account_number_us` varchar(255) DEFAULT NULL,
  `ifsc_code` varchar(255) DEFAULT NULL,
  `account_number_india` varchar(255) DEFAULT NULL,
  `transit_number` varchar(255) DEFAULT NULL,
  `institution_number` varchar(255) DEFAULT NULL,
  `account_number_canada` varchar(255) DEFAULT NULL,
  `bsb` varchar(255) DEFAULT NULL,
  `account_number_australia` varchar(255) DEFAULT NULL,
  `account_number_nz` varchar(255) DEFAULT NULL,
  `bank_code` varchar(255) DEFAULT NULL,
  `branch_code` varchar(255) DEFAULT NULL,
  `account_number_japan` varchar(255) DEFAULT NULL,
  `meps` varchar(255) DEFAULT NULL,
  `account_number_malaysia` varchar(255) DEFAULT NULL,
  `brstn_code` varchar(255) DEFAULT NULL,
  `account_number_philippines` varchar(255) DEFAULT NULL,
  `clabe` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `country` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`swift`,`account_number`),
  KEY `account_user_id_fk_idx` (`user_id`),
  CONSTRAINT `account_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES (1,6,'Naman Attri','HDFC','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'India');
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account_balance`
--

DROP TABLE IF EXISTS `account_balance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `card_id` int(11) DEFAULT NULL,
  `balance` int(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_balance`
--

LOCK TABLES `account_balance` WRITE;
/*!40000 ALTER TABLE `account_balance` DISABLE KEYS */;
/*!40000 ALTER TABLE `account_balance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apps_countries`
--

DROP TABLE IF EXISTS `apps_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apps_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=247 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apps_countries`
--

LOCK TABLES `apps_countries` WRITE;
/*!40000 ALTER TABLE `apps_countries` DISABLE KEYS */;
INSERT INTO `apps_countries` VALUES (1,'AF','Afghanistan'),(2,'AL','Albania'),(3,'DZ','Algeria'),(4,'DS','American Samoa'),(5,'AD','Andorra'),(6,'AO','Angola'),(7,'AI','Anguilla'),(8,'AQ','Antarctica'),(9,'AG','Antigua and Barbuda'),(10,'AR','Argentina'),(11,'AM','Armenia'),(12,'AW','Aruba'),(13,'AU','Australia'),(14,'AT','Austria'),(15,'AZ','Azerbaijan'),(16,'BS','Bahamas'),(17,'BH','Bahrain'),(18,'BD','Bangladesh'),(19,'BB','Barbados'),(20,'BY','Belarus'),(21,'BE','Belgium'),(22,'BZ','Belize'),(23,'BJ','Benin'),(24,'BM','Bermuda'),(25,'BT','Bhutan'),(26,'BO','Bolivia'),(27,'BA','Bosnia and Herzegovina'),(28,'BW','Botswana'),(29,'BV','Bouvet Island'),(30,'BR','Brazil'),(31,'IO','British Indian Ocean Territory'),(32,'BN','Brunei Darussalam'),(33,'BG','Bulgaria'),(34,'BF','Burkina Faso'),(35,'BI','Burundi'),(36,'KH','Cambodia'),(37,'CM','Cameroon'),(38,'CA','Canada'),(39,'CV','Cape Verde'),(40,'KY','Cayman Islands'),(41,'CF','Central African Republic'),(42,'TD','Chad'),(43,'CL','Chile'),(44,'CN','China'),(45,'CX','Christmas Island'),(46,'CC','Cocos (Keeling) Islands'),(47,'CO','Colombia'),(48,'KM','Comoros'),(49,'CG','Congo'),(50,'CK','Cook Islands'),(51,'CR','Costa Rica'),(52,'HR','Croatia (Hrvatska)'),(53,'CU','Cuba'),(54,'CY','Cyprus'),(55,'CZ','Czech Republic'),(56,'DK','Denmark'),(57,'DJ','Djibouti'),(58,'DM','Dominica'),(59,'DO','Dominican Republic'),(60,'TP','East Timor'),(61,'EC','Ecuador'),(62,'EG','Egypt'),(63,'SV','El Salvador'),(64,'GQ','Equatorial Guinea'),(65,'ER','Eritrea'),(66,'EE','Estonia'),(67,'ET','Ethiopia'),(68,'FK','Falkland Islands (Malvinas)'),(69,'FO','Faroe Islands'),(70,'FJ','Fiji'),(71,'FI','Finland'),(72,'FR','France'),(73,'FX','France, Metropolitan'),(74,'GF','French Guiana'),(75,'PF','French Polynesia'),(76,'TF','French Southern Territories'),(77,'GA','Gabon'),(78,'GM','Gambia'),(79,'GE','Georgia'),(80,'DE','Germany'),(81,'GH','Ghana'),(82,'GI','Gibraltar'),(83,'GK','Guernsey'),(84,'GR','Greece'),(85,'GL','Greenland'),(86,'GD','Grenada'),(87,'GP','Guadeloupe'),(88,'GU','Guam'),(89,'GT','Guatemala'),(90,'GN','Guinea'),(91,'GW','Guinea-Bissau'),(92,'GY','Guyana'),(93,'HT','Haiti'),(94,'HM','Heard and Mc Donald Islands'),(95,'HN','Honduras'),(96,'HK','Hong Kong'),(97,'HU','Hungary'),(98,'IS','Iceland'),(99,'IN','India'),(100,'IM','Isle of Man'),(101,'ID','Indonesia'),(102,'IR','Iran (Islamic Republic of)'),(103,'IQ','Iraq'),(104,'IE','Ireland'),(105,'IL','Israel'),(106,'IT','Italy'),(107,'CI','Ivory Coast'),(108,'JE','Jersey'),(109,'JM','Jamaica'),(110,'JP','Japan'),(111,'JO','Jordan'),(112,'KZ','Kazakhstan'),(113,'KE','Kenya'),(114,'KI','Kiribati'),(115,'KP','Korea, Democratic People\'s Republic of'),(116,'KR','Korea, Republic of'),(117,'XK','Kosovo'),(118,'KW','Kuwait'),(119,'KG','Kyrgyzstan'),(120,'LA','Lao People\'s Democratic Republic'),(121,'LV','Latvia'),(122,'LB','Lebanon'),(123,'LS','Lesotho'),(124,'LR','Liberia'),(125,'LY','Libyan Arab Jamahiriya'),(126,'LI','Liechtenstein'),(127,'LT','Lithuania'),(128,'LU','Luxembourg'),(129,'MO','Macau'),(130,'MK','Macedonia'),(131,'MG','Madagascar'),(132,'MW','Malawi'),(133,'MY','Malaysia'),(134,'MV','Maldives'),(135,'ML','Mali'),(136,'MT','Malta'),(137,'MH','Marshall Islands'),(138,'MQ','Martinique'),(139,'MR','Mauritania'),(140,'MU','Mauritius'),(141,'TY','Mayotte'),(142,'MX','Mexico'),(143,'FM','Micronesia, Federated States of'),(144,'MD','Moldova, Republic of'),(145,'MC','Monaco'),(146,'MN','Mongolia'),(147,'ME','Montenegro'),(148,'MS','Montserrat'),(149,'MA','Morocco'),(150,'MZ','Mozambique'),(151,'MM','Myanmar'),(152,'NA','Namibia'),(153,'NR','Nauru'),(154,'NP','Nepal'),(155,'NL','Netherlands'),(156,'AN','Netherlands Antilles'),(157,'NC','New Caledonia'),(158,'NZ','New Zealand'),(159,'NI','Nicaragua'),(160,'NE','Niger'),(161,'NG','Nigeria'),(162,'NU','Niue'),(163,'NF','Norfolk Island'),(164,'MP','Northern Mariana Islands'),(165,'NO','Norway'),(166,'OM','Oman'),(167,'PK','Pakistan'),(168,'PW','Palau'),(169,'PS','Palestine'),(170,'PA','Panama'),(171,'PG','Papua New Guinea'),(172,'PY','Paraguay'),(173,'PE','Peru'),(174,'PH','Philippines'),(175,'PN','Pitcairn'),(176,'PL','Poland'),(177,'PT','Portugal'),(178,'PR','Puerto Rico'),(179,'QA','Qatar'),(180,'RE','Reunion'),(181,'RO','Romania'),(182,'RU','Russian Federation'),(183,'RW','Rwanda'),(184,'KN','Saint Kitts and Nevis'),(185,'LC','Saint Lucia'),(186,'VC','Saint Vincent and the Grenadines'),(187,'WS','Samoa'),(188,'SM','San Marino'),(189,'ST','Sao Tome and Principe'),(190,'SA','Saudi Arabia'),(191,'SN','Senegal'),(192,'RS','Serbia'),(193,'SC','Seychelles'),(194,'SL','Sierra Leone'),(195,'SG','Singapore'),(196,'SK','Slovakia'),(197,'SI','Slovenia'),(198,'SB','Solomon Islands'),(199,'SO','Somalia'),(200,'ZA','South Africa'),(201,'GS','South Georgia South Sandwich Islands'),(202,'ES','Spain'),(203,'LK','Sri Lanka'),(204,'SH','St. Helena'),(205,'PM','St. Pierre and Miquelon'),(206,'SD','Sudan'),(207,'SR','Suriname'),(208,'SJ','Svalbard and Jan Mayen Islands'),(209,'SZ','Swaziland'),(210,'SE','Sweden'),(211,'CH','Switzerland'),(212,'SY','Syrian Arab Republic'),(213,'TW','Taiwan'),(214,'TJ','Tajikistan'),(215,'TZ','Tanzania, United Republic of'),(216,'TH','Thailand'),(217,'TG','Togo'),(218,'TK','Tokelau'),(219,'TO','Tonga'),(220,'TT','Trinidad and Tobago'),(221,'TN','Tunisia'),(222,'TR','Turkey'),(223,'TM','Turkmenistan'),(224,'TC','Turks and Caicos Islands'),(225,'TV','Tuvalu'),(226,'UG','Uganda'),(227,'UA','Ukraine'),(228,'AE','United Arab Emirates'),(229,'GB','United Kingdom'),(230,'US','United States'),(231,'UM','United States minor outlying islands'),(232,'UY','Uruguay'),(233,'UZ','Uzbekistan'),(234,'VU','Vanuatu'),(235,'VA','Vatican City State'),(236,'VE','Venezuela'),(237,'VN','Vietnam'),(238,'VG','Virgin Islands (British)'),(239,'VI','Virgin Islands (U.S.)'),(240,'WF','Wallis and Futuna Islands'),(241,'EH','Western Sahara'),(242,'YE','Yemen'),(243,'YU','Yugoslavia'),(244,'ZR','Zaire'),(245,'ZM','Zambia'),(246,'ZW','Zimbabwe');
/*!40000 ALTER TABLE `apps_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `balance`
--

DROP TABLE IF EXISTS `balance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `balance` (
  `id` int(11) NOT NULL,
  `balance` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `balance_fk` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `balance`
--

LOCK TABLES `balance` WRITE;
/*!40000 ALTER TABLE `balance` DISABLE KEYS */;
INSERT INTO `balance` VALUES (6,706.00),(7,0.00),(9,90.00),(10,250.00),(13,0.00);
/*!40000 ALTER TABLE `balance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `business`
--

DROP TABLE IF EXISTS `business`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(500) DEFAULT NULL,
  `country` varchar(500) DEFAULT NULL,
  `address_one` varchar(500) DEFAULT NULL,
  `address_two` varchar(500) DEFAULT NULL,
  `city` varchar(500) DEFAULT NULL,
  `state` varchar(500) DEFAULT NULL,
  `postal` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `b_fk_user_id_idx` (`user_id`),
  CONSTRAINT `b_fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business`
--

LOCK TABLES `business` WRITE;
/*!40000 ALTER TABLE `business` DISABLE KEYS */;
INSERT INTO `business` VALUES (1,11,'test','India','test','test','test','test','91110'),(2,10,'My Business','United States','2108 Star Trek Drive','','Mobile','Florida','36602'),(3,12,'Thomas Company','Syria','Business address','','Business city','Business state','Business postal code');
/*!40000 ALTER TABLE `business` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cards`
--

DROP TABLE IF EXISTS `cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `card_number` varchar(20) DEFAULT NULL,
  `expiry` varchar(500) DEFAULT NULL,
  `security_code` varchar(45) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `address_one` varchar(1000) DEFAULT NULL,
  `address_two` varchar(1000) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `state` varchar(200) DEFAULT NULL,
  `country` varchar(200) DEFAULT NULL,
  `postal` varchar(45) DEFAULT NULL,
  `card_statement_img` varchar(255) DEFAULT NULL,
  `card_front_img` varchar(255) DEFAULT NULL,
  `card_back_img` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL COMMENT '1=removed ,2=active,3=notactive',
  PRIMARY KEY (`id`),
  UNIQUE KEY `card_number` (`card_number`),
  KEY `cards_user_id_fk_idx` (`user_id`),
  CONSTRAINT `cards_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cards`
--

LOCK TABLES `cards` WRITE;
/*!40000 ALTER TABLE `cards` DISABLE KEYS */;
INSERT INTO `cards` VALUES (1,6,'Visa','4111111111111134','5/2019','231','Naman Attri','Mohali',NULL,'Mohali',NULL,'India','160063',NULL,NULL,NULL,'3');
/*!40000 ALTER TABLE `cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contactus`
--

DROP TABLE IF EXISTS `contactus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contactus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `service_provider` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` mediumtext NOT NULL,
  `status` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactus`
--

LOCK TABLES `contactus` WRITE;
/*!40000 ALTER TABLE `contactus` DISABLE KEYS */;
INSERT INTO `contactus` VALUES (1,7,'','sachin.sharma@it7solutions.com','0000-00-00','test','test','test',1,'2016-08-24 09:58:49'),(2,0,'test test','test@gmail.com','0000-00-00','test','test','hi test',1,'2016-08-24 10:05:47'),(3,0,'test test','test@gmail.com','0000-00-00','test','test','hi test',1,'2016-08-24 10:09:44'),(4,7,'','sachin.sharma@it7solutions.com','0000-00-00','test','test','hi',1,'2016-08-24 10:21:57'),(5,7,'','sachin.sharma@it7solutions.com','0000-00-00','test','test','hi',1,'2016-08-24 11:02:01'),(6,0,'naval kshor','test@gmail.com','0000-00-00','naval','test','dsfsdafsdaf',1,'2016-08-24 12:47:31'),(7,0,'naval test','test123@gmail.com','0000-00-00','12','12','dfsdaf',1,'2016-08-24 12:49:27'),(8,0,'test test','test@gmail.com','0000-00-00','test','test','test',1,'2016-08-25 06:05:58'),(9,0,'test test','test@gmail.com','0000-00-00','test','test','test',1,'2016-08-25 06:40:42'),(10,0,'naval test','test@gmail.com','0000-00-00','test','test','dfgg',1,'2016-08-25 06:46:55'),(11,0,'final test final test','naval@it7solutions.com','0000-00-00','test','test','hi sir',1,'2016-08-25 06:53:31'),(12,0,'final test test','navalkishor2005@gmail.com','0000-00-00','test','test','test test',1,'2016-08-25 06:59:08'),(13,0,'naval kshor','navalkishor2005@gmail.com','0000-00-00','naval','test','asdf ',1,'2016-08-25 07:53:43'),(14,0,'test test','navalkishor2005@gmail.com','0000-00-00','test','test','fdasdf',1,'2016-08-25 07:57:59'),(15,0,'test test','navalkishor2005@gmail.com','0000-00-00','test','test','fdasdf',1,'2016-08-25 07:59:00'),(16,0,'naval test','naval.kishor02@gmail.com','0000-00-00','test','test','test',1,'2016-08-25 08:01:04'),(17,0,'naval test','naval.kishor02@gmail.com','0000-00-00','test','test','test',1,'2016-08-25 08:02:12');
/*!40000 ALTER TABLE `contactus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `currency` varchar(45) DEFAULT NULL,
  KEY `currency_user_id_fk_idx` (`id`),
  CONSTRAINT `currency_userid_fk` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fees_bank_withdrawal`
--

DROP TABLE IF EXISTS `fees_bank_withdrawal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fees_bank_withdrawal` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(250) DEFAULT NULL,
  `fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fees_bank_withdrawal`
--

LOCK TABLES `fees_bank_withdrawal` WRITE;
/*!40000 ALTER TABLE `fees_bank_withdrawal` DISABLE KEYS */;
INSERT INTO `fees_bank_withdrawal` VALUES (1,'United States',0.00),(2,'Canada',0.00),(3,'United Kingdom',0.00),(4,'New Zealand',0.00),(5,'others',4.50),(6,'India',1.50),(7,'Philippines',1.50),(8,'Mexico',1.50),(9,'Japan',1.50),(10,'Malaysia',1.50),(11,'Andorra',0.00),(12,'Austria',0.00),(13,'Belgium',0.00),(14,'Bulgaria',0.00),(15,'Croatia',0.00),(16,'Cyprus',0.00),(17,'Czech Republic',0.00),(18,'Denmark',0.00),(19,'Estonia',0.00),(20,'Finland',0.00),(21,'France',0.00),(22,'Germany',0.00),(23,'Gibraltar',0.00),(24,'Greece',0.00),(25,'Hungary',0.00),(26,'Iceland',0.00),(27,'Ireland',0.00),(28,'Italy',0.00),(29,'Latvia',0.00),(30,'Liechtenstein',0.00),(31,'Lithuania',0.00),(32,'Luxembourg',0.00),(33,'Malta',0.00),(34,'Monaco',0.00),(35,'Netherlands',0.00),(36,'Norway',0.00),(37,'Poland',0.00),(38,'Portugal',0.00),(39,'Romania',0.00),(40,'Saint Marino',0.00),(41,'Slovakia',0.00),(42,'Slovenia',0.00),(43,'Spain',0.00),(44,'Sweden',0.00),(45,'Switzerland',0.00);
/*!40000 ALTER TABLE `fees_bank_withdrawal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nonsepa_countries`
--

DROP TABLE IF EXISTS `nonsepa_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nonsepa_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(255) NOT NULL,
  `iban` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nonsepa_countries`
--

LOCK TABLES `nonsepa_countries` WRITE;
/*!40000 ALTER TABLE `nonsepa_countries` DISABLE KEYS */;
INSERT INTO `nonsepa_countries` VALUES (48,'Albania',28),(49,'Azerbaijan',28),(50,'Bahrain',22),(51,'Faroe Islands',18),(52,'Georgia',22),(53,'Greenland',18),(54,'Israel',23),(55,'Jordan',30),(56,'Kuwait',30),(57,'Lebanon',28),(58,'Mauritania',27),(59,'Moldova',24),(60,'Pakistan',24),(61,'Palestine',29),(62,'Qatar',29),(63,'Saudi Arabia',24),(64,'Tunisia',24),(65,'Turkey',26),(66,'UAE',23),(67,'Albania',28),(68,'Azerbaijan',28),(69,'Bahrain',22),(70,'Faroe Islands',18),(71,'Georgia',22),(72,'Greenland',18),(73,'Israel',23),(74,'Jordan',30),(75,'Kuwait',30),(76,'Lebanon',28),(77,'Mauritania',27),(78,'Moldova',24),(79,'Pakistan',24),(80,'Palestine',29),(81,'Qatar',29),(82,'Saudi Arabia',24),(83,'Tunisia',24),(84,'Turkey',26),(85,'UAE',23);
/*!40000 ALTER TABLE `nonsepa_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile` (
  `id` int(11) DEFAULT NULL,
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(200) DEFAULT NULL,
  `lname` varchar(200) DEFAULT NULL,
  `mname` varchar(200) DEFAULT NULL,
  `address_one` varchar(500) DEFAULT NULL,
  `address_two` varchar(500) DEFAULT NULL,
  `country` varchar(200) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `state` varchar(200) DEFAULT NULL,
  `postal` varchar(200) DEFAULT NULL,
  `mobile` varchar(200) DEFAULT NULL,
  `dob` varchar(200) DEFAULT NULL,
  `nationality` varchar(200) DEFAULT NULL,
  `timezone` varchar(200) DEFAULT NULL,
  `ssn` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`profile_id`),
  KEY `profile_user_id_fk_idx` (`id`),
  CONSTRAINT `profile_fk` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile`
--

LOCK TABLES `profile` WRITE;
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;
INSERT INTO `profile` VALUES (6,6,'Naman','Attri','','Mohali','Mohali','India','Mohali','Punjab','160063','91-9988776655','21/1/2006','India','Asia/Kolkata',NULL),(7,7,'Sachin','Sharma','','KMG Towers, Ground Floor','','India','Greater Mohali','Mohali','160062','91-9914029205','1/1/1979','India','Asia/Kolkata',NULL),(9,9,'Pawandeep','Kaur','','Mohali','','India','Mohali','','160062','91-9988776655','1/1/2003','India','Asia/Kolkata',NULL),(10,10,'Thomas','Campbell','M.','3473 South Street','','United States','Midland','Texas','79701','359-8432697416','28/9/1975','Suriname','Africa/Nairobi','543901257'),(11,11,'test1234','test','test1234','test','test','India','test','test','91110','919780058719','2/2/1988','India','Asia/Kolkata',NULL),(12,12,'Thomas','Campbell','M.','Thomas address','','United States','Thomas city','Thomas state','Thomas postal code','556287913459','12/6/1970','Germany','Asia/Jakarta','843190129'),(13,13,'Ninja','Hatori','','102','','India','Jaipur','','302005','91-9876543234','29/2/1986','India','Asia/Kolkata',NULL);
/*!40000 ALTER TABLE `profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `search_settings`
--

DROP TABLE IF EXISTS `search_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `history_entries` int(10) unsigned NOT NULL DEFAULT '25',
  `home_entries` int(10) unsigned NOT NULL DEFAULT '25',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `search_settings`
--

LOCK TABLES `search_settings` WRITE;
/*!40000 ALTER TABLE `search_settings` DISABLE KEYS */;
INSERT INTO `search_settings` VALUES (1,6,50,25),(2,10,25,25),(3,9,25,25),(4,7,25,25),(5,11,25,25),(6,13,25,25);
/*!40000 ALTER TABLE `search_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sepa_countries`
--

DROP TABLE IF EXISTS `sepa_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sepa_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(100) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `iban` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sepa_countries`
--

LOCK TABLES `sepa_countries` WRITE;
/*!40000 ALTER TABLE `sepa_countries` DISABLE KEYS */;
INSERT INTO `sepa_countries` VALUES (4,'AN','Andorra',24),(5,'AT','Austria',20),(6,'BE','Belgium',16),(7,'BG','Bulgaria',22),(9,'HR','Croatia',21),(10,'CY','Cyprus',28),(11,'CZ','Czech Republic',24),(12,'DK','Denmark',18),(13,'EE','Estonia',20),(14,'FI','Finland',18),(15,'FR','France',27),(17,'DE','Germany',22),(18,'GI','Gibraltar',23),(19,'GR','Greece',27),(21,'HU','Hungary',28),(22,'IS','Iceland',26),(23,'IE','Ireland',22),(24,'IT','Italy',27),(25,'LV','Latvia',21),(26,'LI','Liechtenstein',21),(27,'LT','Lithuania',20),(28,'LU','Luxembourg',20),(29,'MT','Malta',31),(32,'MC','Monaco',27),(33,'NL','Netherlands',18),(34,'NO','Norway',15),(35,'PL','Poland',28),(36,'PT','Portugal',25),(38,'RO','Romania',24),(40,'MF','Saint Marino',27),(42,'SK','Slovakia',24),(43,'SI','Slovenia',19),(44,'ES','Spain',24),(45,'SE','Sweden',24),(46,'CH','Switzerland',21);
/*!40000 ALTER TABLE `sepa_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `type` int(11) DEFAULT NULL COMMENT '1:personal,2:goods',
  `ptype` int(11) DEFAULT NULL COMMENT '1:send,2:receive,3 withdraw',
  `name` varchar(1000) DEFAULT NULL,
  `message` text,
  `status` varchar(45) DEFAULT NULL,
  `gross` decimal(15,2) DEFAULT NULL,
  `fee` decimal(15,2) DEFAULT NULL,
  `netamount` decimal(15,2) DEFAULT NULL,
  `balance` decimal(15,2) DEFAULT NULL,
  `currency` varchar(45) DEFAULT NULL,
  `from` varchar(500) DEFAULT NULL,
  `to` varchar(500) DEFAULT NULL,
  `withdraw_to` int(11) DEFAULT NULL COMMENT '1:account,2:card',
  `withdraw_id` int(11) DEFAULT NULL COMMENT 'account or card id',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`user_id`),
  KEY `transactions_userid_fk_idx` (`user_id`),
  CONSTRAINT `transactions_userid_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1,'WHpvezphCZatDtKEKyR2',6,1,1,'Pawandeep Kaur','','Completed',12.00,0.00,12.00,988.00,NULL,'naman@it7solutions.com','pawandeep@it7solutions.com',NULL,NULL,'2016-08-24 13:43:43'),(2,'WHpvezphCZatDtKEKyR2',9,1,2,'Naman Attri','','Completed',12.00,0.00,12.00,12.00,NULL,'naman@it7solutions.com','pawandeep@it7solutions.com',NULL,NULL,'2016-08-24 13:43:43'),(3,'BW3lrSWYiD2doJKLHOk3',6,1,1,'Pawandeep Kaur','','Completed',11.00,0.00,11.00,977.00,NULL,'naman@it7solutions.com','pawandeep@it7solutions.com',NULL,NULL,'2016-08-24 14:03:22'),(4,'BW3lrSWYiD2doJKLHOk3',9,1,2,'Naman Attri','','Completed',11.00,0.00,11.00,23.00,NULL,'naman@it7solutions.com','pawandeep@it7solutions.com',NULL,NULL,'2016-08-24 14:03:22'),(5,'JZqB8HA5TawpbL4ekuBB',6,1,1,'Pawandeep Kaur','','Completed',13.00,0.00,13.00,964.00,NULL,'naman@it7solutions.com','pawandeep@it7solutions.com',NULL,NULL,'2016-08-24 14:03:38'),(6,'JZqB8HA5TawpbL4ekuBB',9,1,2,'Naman Attri','','Completed',13.00,0.00,13.00,36.00,NULL,'naman@it7solutions.com','pawandeep@it7solutions.com',NULL,NULL,'2016-08-24 14:03:38'),(7,'uGNQWLlvqzJXIq9vGI3e',6,1,1,'Pawandeep Kaur','','Completed',56.00,0.00,56.00,908.00,NULL,'naman@it7solutions.com','pawandeep@it7solutions.com',NULL,NULL,'2016-08-24 14:03:49'),(8,'uGNQWLlvqzJXIq9vGI3e',9,1,2,'Naman Attri','','Completed',56.00,0.00,56.00,92.00,NULL,'naman@it7solutions.com','pawandeep@it7solutions.com',NULL,NULL,'2016-08-24 14:03:49'),(9,'Gbkn7uGBtvRtySKXHqG7',9,1,1,'Naman Attri','','Completed',2.00,0.00,2.00,90.00,NULL,'pawandeep@it7solutions.com','naman@it7solutions.com',NULL,NULL,'2016-08-25 04:21:55'),(10,'Gbkn7uGBtvRtySKXHqG7',6,1,2,'Pawandeep Kaur','','Completed',2.00,0.00,2.00,910.00,NULL,'pawandeep@it7solutions.com','naman@it7solutions.com',NULL,NULL,'2016-08-25 04:21:55'),(11,'TVQ69OEAJATMZVOZYXHW',6,0,3,'{\"cardType\":\"Visa\",\"cardNumber\":\"4111111111111134\"}',NULL,'Under Processing',11.00,4.50,15.50,910.00,NULL,NULL,NULL,2,1,'2016-08-25 14:38:45'),(12,'CMwg3lNRYo9xVJL0QI5T',6,1,1,'Thomas Campbell','Test money transfer.','Completed',200.00,4.00,204.00,706.00,NULL,'naman@it7solutions.com','thomasmcampbell@yandex.com',NULL,NULL,'2016-08-25 14:46:00'),(13,'CMwg3lNRYo9xVJL0QI5T',10,1,2,'Naman Attri','Test money transfer.','Completed',200.00,0.00,200.00,200.00,NULL,'naman@it7solutions.com','thomasmcampbell@yandex.com',NULL,NULL,'2016-08-25 14:46:00'),(14,'Z2IKZZDTGPW6C8QDFURV',6,0,3,'{\"bankName\":\"HDFC\",\"accountNumber\":null}',NULL,'Under Processing',20.00,1.50,21.50,706.00,NULL,NULL,NULL,1,1,'2016-08-25 14:46:25'),(15,'MBS58X1YRPMOHHEGIZOP',10,0,3,'{\"bankName\":\"Bank of America\",\"accountNumber\":null}',NULL,'Under Processing',30.00,0.00,30.00,200.00,NULL,NULL,NULL,1,2,'2016-08-26 09:21:25'),(16,'kjYvnYwfH3ALiUNi8DCW',10,1,1,'Thomas Campbell','no','Completed',50.00,0.00,50.00,150.00,NULL,'thomasmcampbell@yandex.com','thomasmcampbell@yandex.com',NULL,NULL,'2016-08-26 12:55:29'),(17,'kjYvnYwfH3ALiUNi8DCW',10,1,2,'Thomas Campbell','no','Completed',50.00,0.00,50.00,250.00,NULL,'thomasmcampbell@yandex.com','thomasmcampbell@yandex.com',NULL,NULL,'2016-08-26 12:55:29');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactionstests`
--

DROP TABLE IF EXISTS `transactionstests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactionstests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `type` varchar(100) DEFAULT NULL COMMENT '1:personal,2:goods',
  `ptype` varchar(1000) DEFAULT NULL COMMENT '1:send,2:receive,3 withdraw',
  `name` varchar(1000) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `gross` decimal(15,2) DEFAULT NULL,
  `fee` decimal(15,2) DEFAULT NULL,
  `netamount` decimal(15,2) DEFAULT NULL,
  `balance` decimal(15,2) DEFAULT NULL,
  `currency` varchar(45) DEFAULT NULL,
  `from` varchar(500) DEFAULT NULL,
  `to` varchar(500) DEFAULT NULL,
  `withdraw_to` int(11) DEFAULT NULL COMMENT '1:account,2:credit',
  `withdrwa_id` int(11) DEFAULT NULL COMMENT 'account or credit id',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`user_id`),
  KEY `transactions_userid_fk_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactionstests`
--

LOCK TABLES `transactionstests` WRITE;
/*!40000 ALTER TABLE `transactionstests` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactionstests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(500) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `remember_token` varchar(200) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `confirmation_code` varchar(200) DEFAULT NULL,
  `active` varchar(45) DEFAULT NULL,
  `verify` int(11) NOT NULL,
  `account_type` varchar(255) DEFAULT NULL,
  `tmp_password` varchar(1000) DEFAULT NULL,
  `callus_reference` int(11) NOT NULL,
  `callus_reference_create_time` datetime DEFAULT NULL,
  `tmp_email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (6,'naman@it7solutions.com','$2y$10$ZEFLGyGThjh2ik7Y3b/b9eCnetfIhHZIyqqXvYDDS6DSKPSoOph9u','W8wJgp3Oi2ITHo6jPb5EdejlMqR1cSXP8ko5EAKM0ORTJh3WQYCR5BYxzPXP','2016-08-26 04:56:53','2016-08-24 07:35:48','0',NULL,'','1',0,'personal',NULL,0,NULL,NULL),(7,'sachin.sharma@it7solutions.com','$2y$10$O/r55fOfPv7XC0wHkhKH3u2sIV/cxHGtQeCMYYwpND/wyIt06S/7O','jVOCz4PKY9CNropIfa0Af3iMbCMQyFbZgOej9QzI5dRnGVSQTYegCAPBrpyo','2016-08-26 09:14:15','2016-08-24 07:43:21','0',NULL,'','1',0,'personal',NULL,625082,'2016-08-25 07:47:51',NULL),(9,'pawandeep@it7solutions.com','$2y$10$J0wU0m.zcWzf9CeZPjdIjOoWZnOEhQdy1QQkFj02yq8je0Rod5UwK','LuurgR3ytRYy6wKwFgVrSYQQYoiOHgAblMCAjdFRWiLusyW6U9kemdZjNp6b','2016-08-25 16:11:21','2016-08-24 08:04:21','0',NULL,'','1',0,'personal',NULL,0,NULL,NULL),(10,'thomasmcampbell@yandex.com','$2y$10$3HgYB7SX.BNanCuNvUNcceljo62woZBRu50VNABtPIzaiYmX2vGhO','pID3tnWV6REAfPpK4rEl9tgr99Sdp68yXX3bhVZVAFDcXU6md2RXlAVPCsk4','2016-08-26 10:19:45','2016-08-24 12:22:26','0',NULL,'','1',0,'business',NULL,645513,'2016-08-25 14:46:29',NULL),(11,'navalkishor2005@gmail.com','$2y$10$4d7pCV6PnXg7xmiQcnwd7ewoXJI0j.IPWEFBxrXG9NwJDuJoiJdw2','WtK2IAorRyXndoMwR7GcmKxTwE1eEWGl2rl70BzB1f0dn6ryc73FBVFjnbbS','2016-08-26 13:54:15','2016-08-26 09:09:27','0',NULL,'','1',0,'business','58b74ERlu81pfe3JSWQz',0,NULL,''),(12,'thomasmcampbell01@xemaps.com','$2y$10$EfjuqcE26M8whsUlWqbB7uKMimGfuePTsZYwtthG61lbE0SDVNZiq',NULL,'2016-08-26 10:13:29','2016-08-26 10:11:07','0',NULL,'','1',0,'business',NULL,0,NULL,NULL),(13,'megav.v51@gmail.com','$2y$10$ni3taTkN7G9zFRBWnKFu5.qFw.cysxbII8FEghCbkkFGKYN2wZEXW',NULL,'2016-08-26 10:58:35','2016-08-26 10:57:54','0',NULL,'','1',0,'personal',NULL,0,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verificationdoc`
--

DROP TABLE IF EXISTS `verificationdoc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `verificationdoc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` enum('personal','business') NOT NULL,
  `id_type` varchar(50) NOT NULL,
  `id_num` varchar(50) NOT NULL,
  `photo_id` varchar(100) NOT NULL,
  `document_type` varchar(50) NOT NULL,
  `document` varchar(100) NOT NULL,
  `utility_type` varchar(50) NOT NULL,
  `expiration_date` date NOT NULL,
  `issuing_authority` varchar(255) NOT NULL,
  `issuing_date` date NOT NULL,
  `company_type` varchar(255) NOT NULL,
  `employees` int(11) NOT NULL,
  `company_registration_no` varchar(100) NOT NULL,
  `registration_date` varchar(255) NOT NULL,
  `registration_country` varchar(50) NOT NULL,
  `text_id` varchar(255) NOT NULL,
  `license_no` varchar(255) NOT NULL,
  `company_registration_document` varchar(255) NOT NULL,
  `company_address_proof` varchar(255) NOT NULL,
  `business_addproof_issue_date` varchar(255) NOT NULL,
  `business_details` varchar(255) NOT NULL,
  `authorization_letter` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verificationdoc`
--

LOCK TABLES `verificationdoc` WRITE;
/*!40000 ALTER TABLE `verificationdoc` DISABLE KEYS */;
/*!40000 ALTER TABLE `verificationdoc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verificationidentity`
--

DROP TABLE IF EXISTS `verificationidentity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `verificationidentity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `personal_document` varchar(255) NOT NULL,
  `business_document` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verificationidentity`
--

LOCK TABLES `verificationidentity` WRITE;
/*!40000 ALTER TABLE `verificationidentity` DISABLE KEYS */;
/*!40000 ALTER TABLE `verificationidentity` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-08-26 14:08:27
