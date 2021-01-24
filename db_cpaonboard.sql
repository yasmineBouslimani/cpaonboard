CREATE DATABASE  IF NOT EXISTS `cpaonboard` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cpaonboard`;
-- MySQL dump 10.13  Distrib 8.0.21, for Win64 (x86_64)
--
-- Host: localhost    Database: cpaonboard
-- ------------------------------------------------------
-- Server version	8.0.21

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
-- Table structure for table `contract`
--

DROP TABLE IF EXISTS `contract`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contract` (
  `id_contract` int NOT NULL,
  `type_contract` enum('CDI','CDD','Contrat pro','Contrat d''apprentissage','Interim','Stage') DEFAULT NULL,
  `starting_date` date DEFAULT NULL,
  `wage_firt_year` int DEFAULT NULL,
  `wage_second_year` int DEFAULT NULL,
  `wage_third_year` int DEFAULT NULL,
  `on_going` tinyint(1) DEFAULT NULL,
  `fk_employee` int DEFAULT NULL,
  PRIMARY KEY (`id_contract`),
  KEY `FK_employee` (`fk_employee`),
  CONSTRAINT `FK_employee` FOREIGN KEY (`fk_employee`) REFERENCES `employee` (`id_employee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contract`
--

LOCK TABLES `contract` WRITE;
/*!40000 ALTER TABLE `contract` DISABLE KEYS */;
INSERT INTO `contract` VALUES (1,'CDI','2019-05-12',1,1,1,NULL,1),(2,'CDI','2020-01-24',1,1,1,NULL,2),(3,'CDD','2020-10-10',1,1,1,NULL,3),(4,'CDI','2009-02-24',1,1,1,NULL,4),(5,'Stage','2000-03-24',1,1,1,NULL,5);
/*!40000 ALTER TABLE `contract` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer` (
  `id_customer` int NOT NULL,
  `fk_customerType` int DEFAULT NULL,
  PRIMARY KEY (`id_customer`),
  KEY `FK_customerType` (`fk_customerType`),
  CONSTRAINT `FK_customerType` FOREIGN KEY (`fk_customerType`) REFERENCES `customertype` (`id_customerType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,1),(2,1),(3,1),(5,1),(4,2),(6,2),(7,2);
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_vehicle`
--

DROP TABLE IF EXISTS `customer_vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_vehicle` (
  `fk_id_vehicle` int NOT NULL,
  `fk_id_customer` int NOT NULL,
  PRIMARY KEY (`fk_id_customer`,`fk_id_vehicle`),
  KEY `FK_id_vehicle` (`fk_id_vehicle`),
  CONSTRAINT `FK_id_customer` FOREIGN KEY (`fk_id_customer`) REFERENCES `customer` (`id_customer`),
  CONSTRAINT `FK_id_vehicle` FOREIGN KEY (`fk_id_vehicle`) REFERENCES `vehicle` (`id_vehicle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_vehicle`
--

LOCK TABLES `customer_vehicle` WRITE;
/*!40000 ALTER TABLE `customer_vehicle` DISABLE KEYS */;
INSERT INTO `customer_vehicle` VALUES (1,2),(2,5),(3,1),(4,3),(5,6),(6,4);
/*!40000 ALTER TABLE `customer_vehicle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customertype`
--

DROP TABLE IF EXISTS `customertype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customertype` (
  `id_customerType` int NOT NULL,
  `label` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_customerType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customertype`
--

LOCK TABLES `customertype` WRITE;
/*!40000 ALTER TABLE `customertype` DISABLE KEYS */;
INSERT INTO `customertype` VALUES (1,'Professionnel '),(2,'Particulier');
/*!40000 ALTER TABLE `customertype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dependancy`
--

DROP TABLE IF EXISTS `dependancy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dependancy` (
  `id_dependancy` int NOT NULL,
  PRIMARY KEY (`id_dependancy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dependancy`
--

LOCK TABLES `dependancy` WRITE;
/*!40000 ALTER TABLE `dependancy` DISABLE KEYS */;
/*!40000 ALTER TABLE `dependancy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee` (
  `id_employee` int NOT NULL,
  `employee_hr_id` varchar(100) DEFAULT NULL,
  `gender` enum('F','M','NC') DEFAULT NULL,
  `civility` enum('Mme','Mr','NC') DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `birth_place` varchar(100) DEFAULT NULL,
  `social_security_number` int DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_city` varchar(100) DEFAULT NULL,
  `bank_iban` varchar(34) DEFAULT NULL,
  `bank_bic` varchar(11) DEFAULT NULL,
  `wage_ratio` int DEFAULT NULL,
  `wage_hiring` int DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_employee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES (1,'BDX2389','M','Mr','2020-09-04',NULL,1,'SG','BDX','FR152678827748','VCG67922JL',NULL,NULL,'33'),(2,'BDX78JU','F','Mme','1993-10-30',NULL,1,'ING','BDX','FR152678867589','VCG67922JL',NULL,NULL,'33'),(3,'BDX6783','F','NC','1964-03-02',NULL,1,'BNP','BDX','FR152678867567','VCG67922JL',NULL,NULL,'33'),(4,'BDXYH89','M','Mr','1956-01-20',NULL,1,'ING','BDX','FR152678867567','VCG67922JL',NULL,NULL,'33'),(5,'BDX4624','F','Mme','1975-10-20',NULL,1,'CAE','BDX','FR152678867545','VCG67922JL',NULL,NULL,'33'),(6,'BDX6784','F','Mr','1999-02-09',NULL,1,'BP','BDX','FR152678867510','VCG73922JL',NULL,NULL,'33'),(7,'BDX5638','NC','NC','2001-01-04',NULL,1,'SG','BDX','FR152678867573','VHY67922BT',NULL,NULL,'33');
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `energytype`
--

DROP TABLE IF EXISTS `energytype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `energytype` (
  `id_energyType` int NOT NULL,
  `label` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_energyType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `energytype`
--

LOCK TABLES `energytype` WRITE;
/*!40000 ALTER TABLE `energytype` DISABLE KEYS */;
INSERT INTO `energytype` VALUES (1,'Diesel'),(2,'Essence'),(3,'GPL'),(4,'Electrique'),(5,'Gaz Naturel');
/*!40000 ALTER TABLE `energytype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gearboxtype`
--

DROP TABLE IF EXISTS `gearboxtype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gearboxtype` (
  `id_gearBoxType` int NOT NULL,
  `label` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_gearBoxType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gearboxtype`
--

LOCK TABLES `gearboxtype` WRITE;
/*!40000 ALTER TABLE `gearboxtype` DISABLE KEYS */;
INSERT INTO `gearboxtype` VALUES (1,'Manuelle'),(2,'Automatique');
/*!40000 ALTER TABLE `gearboxtype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `location` (
  `id_location` int NOT NULL,
  `label` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_location`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location`
--

LOCK TABLES `location` WRITE;
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
/*!40000 ALTER TABLE `location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `id_product` int NOT NULL,
  `label` varchar(100) DEFAULT NULL,
  `stock` int DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `comment_product` varchar(255) DEFAULT NULL,
  `fk_productType` int DEFAULT NULL,
  `fk_dependancy` int DEFAULT NULL,
  `fk_tva` int DEFAULT NULL,
  PRIMARY KEY (`id_product`),
  KEY `FK_productType` (`fk_productType`),
  KEY `FK_dependancy` (`fk_dependancy`),
  KEY `FK_tva` (`fk_tva`),
  CONSTRAINT `FK_dependancy` FOREIGN KEY (`fk_dependancy`) REFERENCES `dependancy` (`id_dependancy`),
  CONSTRAINT `FK_productType` FOREIGN KEY (`fk_productType`) REFERENCES `producttype` (`id_productType`),
  CONSTRAINT `FK_tva` FOREIGN KEY (`fk_tva`) REFERENCES `tva` (`id_tva`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'Pare-Brise',1,13,NULL,NULL,NULL,3),(2,'Boite de vitesse manuelle - 6 rapports',23,799,NULL,NULL,NULL,3),(3,'Disque de frein avant',3,191,NULL,NULL,NULL,3),(4,'Volant',16,79,NULL,NULL,NULL,2),(5,'Roue',56,45,NULL,NULL,NULL,1),(6,'Amortisseur avant',7,120,NULL,NULL,NULL,3),(7,'Rotule de direction',6,130,NULL,NULL,NULL,3),(8,'Courroie de distribution',3,159,NULL,NULL,NULL,3);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_sale`
--

DROP TABLE IF EXISTS `product_sale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_sale` (
  `fk_id_product` int NOT NULL,
  `fk_id_sale` int NOT NULL,
  `original_price` decimal(10,0) DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `discount` decimal(10,0) DEFAULT NULL,
  `finalised_price` decimal(10,0) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`fk_id_sale`,`fk_id_product`),
  KEY `FK_id_product` (`fk_id_product`),
  CONSTRAINT `FK_id_product` FOREIGN KEY (`fk_id_product`) REFERENCES `product` (`id_product`),
  CONSTRAINT `FK_id_sale` FOREIGN KEY (`fk_id_sale`) REFERENCES `sale` (`id_sale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_sale`
--

LOCK TABLES `product_sale` WRITE;
/*!40000 ALTER TABLE `product_sale` DISABLE KEYS */;
INSERT INTO `product_sale` VALUES (1,1,23,1,NULL,NULL,'2020-10-03 00:00:00'),(2,2,120,2,50,60,'2020-12-23 00:00:00'),(3,3,20,1,NULL,NULL,'2020-11-03 00:00:00'),(1,5,10,3,NULL,NULL,'2020-12-01 00:00:00'),(2,6,100,1,10,90,'2020-09-02 00:00:00');
/*!40000 ALTER TABLE `product_sale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productlocation`
--

DROP TABLE IF EXISTS `productlocation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productlocation` (
  `fk_id_product` int NOT NULL,
  `fk_id_location` int NOT NULL,
  PRIMARY KEY (`fk_id_product`,`fk_id_location`),
  KEY `FK_id_location` (`fk_id_location`),
  CONSTRAINT `FK_id_location` FOREIGN KEY (`fk_id_location`) REFERENCES `location` (`id_location`),
  CONSTRAINT `FK_id_product_location` FOREIGN KEY (`fk_id_product`) REFERENCES `product` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productlocation`
--

LOCK TABLES `productlocation` WRITE;
/*!40000 ALTER TABLE `productlocation` DISABLE KEYS */;
/*!40000 ALTER TABLE `productlocation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producttype`
--

DROP TABLE IF EXISTS `producttype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producttype` (
  `id_productType` int NOT NULL,
  `label` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_productType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producttype`
--

LOCK TABLES `producttype` WRITE;
/*!40000 ALTER TABLE `producttype` DISABLE KEYS */;
/*!40000 ALTER TABLE `producttype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sale`
--

DROP TABLE IF EXISTS `sale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sale` (
  `id_sale` int NOT NULL,
  `date_sale` date DEFAULT NULL,
  `global_price_original` decimal(10,0) DEFAULT NULL,
  `discount` decimal(10,0) DEFAULT NULL,
  `global_price_finalised` decimal(10,0) DEFAULT NULL,
  `to_deliver` tinyint(1) DEFAULT NULL,
  `status_sale` enum('En cours','En attente') DEFAULT NULL,
  `fk_users` int DEFAULT NULL,
  `fk_customer` int DEFAULT NULL,
  PRIMARY KEY (`id_sale`),
  KEY `FK_users` (`fk_users`),
  KEY `FK_customer` (`fk_customer`),
  CONSTRAINT `FK_customer` FOREIGN KEY (`fk_customer`) REFERENCES `customer` (`id_customer`),
  CONSTRAINT `FK_users` FOREIGN KEY (`fk_users`) REFERENCES `users` (`id_users`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sale`
--

LOCK TABLES `sale` WRITE;
/*!40000 ALTER TABLE `sale` DISABLE KEYS */;
INSERT INTO `sale` VALUES (1,'2020-12-24',180,NULL,NULL,1,NULL,1,1),(2,'2020-12-10',1560,NULL,NULL,1,NULL,2,3),(3,'2020-12-09',12,NULL,NULL,1,NULL,1,5),(4,'2020-12-02',134,NULL,NULL,1,NULL,1,6),(5,'2020-11-29',30,NULL,NULL,1,NULL,2,4),(6,'2020-11-12',13,NULL,NULL,1,NULL,2,7);
/*!40000 ALTER TABLE `sale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tva`
--

DROP TABLE IF EXISTS `tva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tva` (
  `id_tva` int NOT NULL,
  `code_tva` varchar(100) DEFAULT NULL,
  `ratio` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id_tva`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tva`
--

LOCK TABLES `tva` WRITE;
/*!40000 ALTER TABLE `tva` DISABLE KEYS */;
INSERT INTO `tva` VALUES (1,'TN',20),(2,'TI',10),(3,'TR',6),(4,'TP',2);
/*!40000 ALTER TABLE `tva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id_users` int NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `login` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fk_id_userType` int DEFAULT NULL,
  `fk_id_employee` int DEFAULT NULL,
  PRIMARY KEY (`id_users`),
  KEY `FK_id_employee` (`fk_id_employee`),
  KEY `FK_id_userType` (`fk_id_userType`),
  CONSTRAINT `FK_id_employee` FOREIGN KEY (`fk_id_employee`) REFERENCES `employee` (`id_employee`),
  CONSTRAINT `FK_id_userType` FOREIGN KEY (`fk_id_userType`) REFERENCES `usertype` (`id_userType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'john.doe@example.fr','secret',1,1),(2,1,'admin@example.fr','secret',1,2);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usertype`
--

DROP TABLE IF EXISTS `usertype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usertype` (
  `id_userType` int NOT NULL,
  `label` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_userType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usertype`
--

LOCK TABLES `usertype` WRITE;
/*!40000 ALTER TABLE `usertype` DISABLE KEYS */;
INSERT INTO `usertype` VALUES (1,'ADMIN');
/*!40000 ALTER TABLE `usertype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle` (
  `id_vehicle` int NOT NULL,
  `manufacture_year` date DEFAULT NULL,
  `license_plate` varchar(12) DEFAULT NULL,
  `fiscal_horse_power` int DEFAULT NULL,
  `door_number` int DEFAULT NULL,
  `fk_energyType` int DEFAULT NULL,
  `fk_gearBoxType` int DEFAULT NULL,
  PRIMARY KEY (`id_vehicle`),
  KEY `FK_energyType` (`fk_energyType`),
  KEY `FK_gearBoxType` (`fk_gearBoxType`),
  CONSTRAINT `FK_energyType` FOREIGN KEY (`fk_energyType`) REFERENCES `energytype` (`id_energyType`),
  CONSTRAINT `FK_gearBoxType` FOREIGN KEY (`fk_gearBoxType`) REFERENCES `gearboxtype` (`id_gearBoxType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle`
--

LOCK TABLES `vehicle` WRITE;
/*!40000 ALTER TABLE `vehicle` DISABLE KEYS */;
INSERT INTO `vehicle` VALUES (1,'1997-02-01','AH-151-HY',4,5,1,1),(2,'2000-10-12','HB-567-AS',2,5,3,1),(3,'2015-12-27','HB-008-TG',7,5,2,1),(4,'2017-05-06','CR-156-GV',5,5,5,2),(5,'2020-01-24','GT-678-YH',5,5,1,1),(6,'2019-03-30','BH-187-AQ',3,3,4,1),(7,'2018-08-21','NJ-765-YH',6,5,1,1);
/*!40000 ALTER TABLE `vehicle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehiclemodel`
--

DROP TABLE IF EXISTS `vehiclemodel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehiclemodel` (
  `id_vehicleModel` int NOT NULL,
  `model` varchar(100) DEFAULT NULL,
  `make` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_vehicleModel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehiclemodel`
--

LOCK TABLES `vehiclemodel` WRITE;
/*!40000 ALTER TABLE `vehiclemodel` DISABLE KEYS */;
INSERT INTO `vehiclemodel` VALUES (1,'CLIO III','RENAULT'),(2,'GOLF','VOLKSWAGEN'),(3,'DS3','DS'),(4,'ASTRA','OPEL'),(5,'SPORTAGE','KIA'),(6,'POLO','VOLKSWAGEN'),(7,'A3','AUDI');
/*!40000 ALTER TABLE `vehiclemodel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehiclemodel_product`
--

DROP TABLE IF EXISTS `vehiclemodel_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehiclemodel_product` (
  `fk_id_product` int NOT NULL,
  `fk_id_vehicleModel` int NOT NULL,
  PRIMARY KEY (`fk_id_product`,`fk_id_vehicleModel`),
  KEY `FK_vehicleModel` (`fk_id_vehicleModel`),
  CONSTRAINT `FK_product` FOREIGN KEY (`fk_id_product`) REFERENCES `product` (`id_product`),
  CONSTRAINT `FK_vehicleModel` FOREIGN KEY (`fk_id_vehicleModel`) REFERENCES `vehiclemodel` (`id_vehicleModel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehiclemodel_product`
--

LOCK TABLES `vehiclemodel_product` WRITE;
/*!40000 ALTER TABLE `vehiclemodel_product` DISABLE KEYS */;
INSERT INTO `vehiclemodel_product` VALUES (1,1),(2,2),(3,3),(1,4),(2,5),(3,6),(1,7);
/*!40000 ALTER TABLE `vehiclemodel_product` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-24 20:25:19
