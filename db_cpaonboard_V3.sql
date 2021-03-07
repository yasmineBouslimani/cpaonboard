CREATE DATABASE  IF NOT EXISTS `cpaonboard` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */ ;
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
-- Table structure for table `acquisition`
--

DROP TABLE IF EXISTS `acquisition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acquisition` (
                               `id_acquisition` int NOT NULL AUTO_INCREMENT,
                               `date_acquisition` datetime DEFAULT NULL,
                               `date_reception` datetime DEFAULT NULL,
                               `global_price` decimal(10,0) DEFAULT NULL,
                               `fk_id_users` int DEFAULT NULL,
                               `fk_id_statusAcquisition` int DEFAULT NULL,
                               PRIMARY KEY (`id_acquisition`),
                               KEY `FK_id_users` (`fk_id_users`),
                               KEY `FK_id_statusAcquisition` (`fk_id_statusAcquisition`),
                               CONSTRAINT `FK_id_statusAcquisition` FOREIGN KEY (`fk_id_statusAcquisition`) REFERENCES `statusacquisition` (`id_statusAcquisition`),
                               CONSTRAINT `FK_id_users` FOREIGN KEY (`fk_id_users`) REFERENCES `users` (`id_users`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acquisition`
--

LOCK TABLES `acquisition` WRITE;
/*!40000 ALTER TABLE `acquisition` DISABLE KEYS */;
INSERT INTO `acquisition` VALUES
(1,'2021-02-25 00:00:00','2021-03-02 00:00:00',200,1,1),
(2,'2021-02-25 00:00:00','2021-03-01 00:00:00',135,2,2);
/*!40000 ALTER TABLE `acquisition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact` (
                           `id_contact` int NOT NULL AUTO_INCREMENT,
                           `first_name` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                           `last_name` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                           `corporate_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                           `address_street_number` int DEFAULT NULL,
                           `address_street` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                           `professional_email_address` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                           `personal_email_address` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                           `cellphone_number` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                           `phone_number` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                           `address_city` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                           `address_zip_code` int DEFAULT NULL,
                           `address_addition` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                           `fk_id_provider2` int DEFAULT NULL,
                           `fk_id_employee2` int DEFAULT NULL,
                           `fk_id_customer2` int DEFAULT NULL,
                           PRIMARY KEY (`id_contact`),
                           KEY `FK_id_provider2` (`fk_id_provider2`),
                           KEY `FK_id_employee2` (`fk_id_employee2`),
                           KEY `FK_id_customer2` (`fk_id_customer2`),
                           CONSTRAINT `FK_id_customer2` FOREIGN KEY (`fk_id_customer2`) REFERENCES `customer` (`id_customer`),
                           CONSTRAINT `FK_id_employee2` FOREIGN KEY (`fk_id_employee2`) REFERENCES `employee` (`id_employee`),
                           CONSTRAINT `FK_id_provider2` FOREIGN KEY (`fk_id_provider2`) REFERENCES `provider` (`id_provider`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` VALUES
(1,'Henri','de Lauret',NULL,34,'Rue du Temple','henri@gmail.com',NULL,'0656784539',NULL,'BORDEAUX',33000,NULL,NULL,1,NULL),
(2,'Elise','Lunet',NULL,106,'Cours Verdun','elise@gmail.com',NULL,'0563456785',NULL,'BORDEAUX',33300,'2° étage',NULL,NULL,1),
(3,'Anna','Bonnet','LEADER PIECES AUTO',67,'Rue Gennet','anna@gmail.com',NULL,'0767867647','0567854368','LANGON',45000,NULL,1,NULL,NULL),
(4,'Marie','Berthelot',NULL,45,'Rue André Gardon','anff@cpaonboard.com',NULL,NULL,'0675782736','BORDEAUX',33000,NULL,NULL,2,NULL),
(5,'Myriam','Mitier',NULL,67,'Rue du Noyer','','m.mitter@gmail.com','0675376847',NULL,'Bordeaux',33400,'4e étage - Bat C',NULL,3,NULL),
(6,'Yann','Kerec','Déménageur breton',76,'Avenue Voltaire','ybarthes@gmail.com',NULL,'0567859687',NULL,'BORDEAUX',33300,'NULL',NULL,NULL,2),
(7,'Eric','Dupont','HergéInc',12,'rue Edmond Rostand','edupont@gmail.com',NULL,'0553782222',NULL,'MERIGNAC',33700,'NULL',NULL,NULL,3),
(8,'Frédérick','Dupond','HergéInc',13,'rue Edmond Rostand','edupont@gmail.com',NULL,'0553783333',NULL,'MERIGNAC',33700,'NULL',NULL,NULL,4),
(9,'Nathalie','Perlet',NULL,27,'rue de la rose','nperlet@gmail.com',NULL,'055585672',NULL,'PESSAC',33600,'NULL',NULL,4,NULL),
(10,'Laurent','Dupuis',NULL,43,'rue des jonquilles','ldpuis@gmail.com',NULL,'055665653',NULL,'PESSAC',33600,'NULL',NULL,5,NULL),
(11,'Chloé','Laforge',NULL,4,'avenue de Paris','claforge@gmail.com',NULL,'056545682',0511853268,'BORDEAUX',33300,'NULL',NULL,6,NULL);
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacttype`
--

DROP TABLE IF EXISTS `contacttype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacttype` (
                               `id_contactType` int NOT NULL AUTO_INCREMENT,
                               `label` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                               PRIMARY KEY (`id_contactType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacttype`
--

LOCK TABLES `contacttype` WRITE;
/*!40000 ALTER TABLE `contacttype` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacttype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacttype_contact`
--

DROP TABLE IF EXISTS `contacttype_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacttype_contact` (
                                       `fk_id_contactType` int NOT NULL,
                                       `fk_id_contact` int NOT NULL,
                                       PRIMARY KEY (`fk_id_contactType`,`fk_id_contact`),
                                       KEY `FK_id_contact` (`fk_id_contact`),
                                       CONSTRAINT `FK_id_contact` FOREIGN KEY (`fk_id_contact`) REFERENCES `contact` (`id_contact`),
                                       CONSTRAINT `FK_id_contactType` FOREIGN KEY (`fk_id_contactType`) REFERENCES `contacttype` (`id_contactType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacttype_contact`
--

LOCK TABLES `contacttype_contact` WRITE;
/*!40000 ALTER TABLE `contacttype_contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacttype_contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contract`
--

DROP TABLE IF EXISTS `contract`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contract` (
                            `id_contract` int NOT NULL AUTO_INCREMENT,
                            `type_contract` enum('CDI','CDD','Contrat pro','Contrat d''apprentissage','Interim','Stage') CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                            `starting_date` date DEFAULT NULL,
                            `wage_first_year` int DEFAULT NULL,
                            `wage_second_year` int DEFAULT NULL,
                            `wage_third_year` int DEFAULT NULL,
                            `on_going` tinyint(1) DEFAULT NULL,
                            `fk_employee` int DEFAULT NULL,
                            `finishing_date` date DEFAULT NULL,
                            PRIMARY KEY (`id_contract`),
                            KEY `FK_employee` (`fk_employee`),
                            CONSTRAINT `FK_employee` FOREIGN KEY (`fk_employee`) REFERENCES `employee` (`id_employee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contract`
--

LOCK TABLES `contract` WRITE;
/*!40000 ALTER TABLE `contract` DISABLE KEYS */;
INSERT INTO `contract` VALUES
(1,'CDI','2003-12-03',NULL,NULL,NULL,1,1,NULL),
(2,'CDD','2003-11-25',NULL,NULL,NULL,0,2,2004-05-14),
(3,'CDI','2004-05-15',NULL,NULL,NULL,1,2,NULL),
(4,'CDI','2020-03-05',NULL,NULL,NULL,1,3,NULL),
(5,'Stage','2011-02-25',NULL,NULL,NULL,1,4,2011-03-30),
(6,'CDI','2000-12-04',NULL,NULL,NULL,1,5,NULL),
(7,'CDI','2021-07-26',NULL,NULL,NULL,1,6,NULL);
/*!40000 ALTER TABLE `contract` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer` (
                            `id_customer` int NOT NULL AUTO_INCREMENT,
                            `fk_customerType` int DEFAULT NULL,
                            PRIMARY KEY (`id_customer`),
                            KEY `FK_customerType` (`fk_customerType`),
                            CONSTRAINT `FK_customerType` FOREIGN KEY (`fk_customerType`) REFERENCES `customertype` (`id_customerType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES
(1,1),
(2,2),
(3,2),
(4,2);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_vehicle`
--

LOCK TABLES `customer_vehicle` WRITE;
/*!40000 ALTER TABLE `customer_vehicle` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_vehicle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customertype`
--

DROP TABLE IF EXISTS `customertype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customertype` (
                                `id_customerType` int NOT NULL AUTO_INCREMENT,
                                `label` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                                PRIMARY KEY (`id_customerType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customertype`
--

LOCK TABLES `customertype` WRITE;
/*!40000 ALTER TABLE `customertype` DISABLE KEYS */;
INSERT INTO `customertype` VALUES
(1,'Particulier'),
(2,'Professionnel');
/*!40000 ALTER TABLE `customertype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dependancy`
--

DROP TABLE IF EXISTS `dependancy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dependancy` (
                              `id_dependancy` int NOT NULL AUTO_INCREMENT,
                              `fk_id_product_1` int DEFAULT NULL,
                              `fk_id_product_2` int DEFAULT NULL,
                              PRIMARY KEY (`id_dependancy`),
                              KEY `FK_id_product_1_idx` (`fk_id_product_1`),
                              KEY `FK_id_product_2_idx` (`fk_id_product_2`),
                              CONSTRAINT `FK_id_product_1` FOREIGN KEY (`fk_id_product_1`) REFERENCES `product` (`id_product`) ON DELETE RESTRICT ON UPDATE RESTRICT,
                              CONSTRAINT `FK_id_product_2` FOREIGN KEY (`fk_id_product_2`) REFERENCES `product` (`id_product`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dependancy`
--

LOCK TABLES `dependancy` WRITE;
/*!40000 ALTER TABLE `dependancy` DISABLE KEYS */;
INSERT INTO `dependancy` VALUES (1,1,2);
/*!40000 ALTER TABLE `dependancy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee` (
                            `id_employee` int NOT NULL AUTO_INCREMENT,
                            `employee_hr_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                            `gender` enum('F','M','NC') CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                            `civility` enum('Mme','M','NC') CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                            `birth_date` date DEFAULT NULL,
                            `birth_place` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                            `social_security_number` int DEFAULT NULL,
                            `bank_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                            `bank_city` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                            `bank_iban` varchar(34) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                            `bank_bic` varchar(11) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                            `wage_ratio` int DEFAULT NULL,
                            `wage_hiring` int DEFAULT NULL,
                            `fk_department` int DEFAULT NULL,
                            `fk_employeeFunction` int DEFAULT NULL,
                            `is_active` int DEFAULT NULL,
                            PRIMARY KEY (`id_employee`),
                            KEY `FK_department` (`fk_department`),
                            KEY `FK_employeeFunction` (`fk_employeeFunction`),
                            CONSTRAINT `FK_department` FOREIGN KEY (`fk_department`) REFERENCES `department` (`id_department`),
                            CONSTRAINT `FK_employeeFunction` FOREIGN KEY (`fk_employeeFunction`) REFERENCES `employeeFunction` (`id_employeeFunction`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES
(1,'BDX33','M','M','1985-02-25','Paris',NULL,'SG',NULL,NULL,NULL,NULL,NULL,1,1,1),
(2,'BDX34','F','Mme','2000-02-25','Agen',NULL,'ING',NULL,NULL,NULL,NULL,NULL,2,2,1),
(3,'BDX35','F','Mme','1993-02-25','Guadeloupe',NULL,'CE',NULL,NULL,NULL,NULL,NULL,3,3,1),
(4,'BDX36','F','Mme','1987-03-21','Bordeaux',NULL,'CE',NULL,NULL,NULL,NULL,NULL,3,3,0),
(5,'BDX37','F','M','1991-01-02','Bordeaux',NULL,'CE',NULL,NULL,NULL,NULL,NULL,6,4,1),
(6,'BDX37','F','Mme','1997-06-14','Lyon',NULL,'CE',NULL,NULL,NULL,NULL,NULL,9,5,1);
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `department` (
                              `id_department` int NOT NULL AUTO_INCREMENT,
                              `label` varchar(100) NOT NULL,
                              PRIMARY KEY (`id_department`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES
(1,'DIRECTION'),
(2,'COMMERCIAL'),
(3,'RH'),
(4,'ACCESSOIRE & ENTRETIENS'),
(5,'HABITACLE'),
(6,'MOTEUR & DEPENDANCES'),
(7,'CARROSSERIE'),
(8,'CONSOMMABLES'),
(9,'MAGASIN'),
(10,'LIVRAISON'),
(11,'REPARATION');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employeeFunction`
--

DROP TABLE IF EXISTS `employeeFunction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employeeFunction` (
                                    `id_employeeFunction` int NOT NULL AUTO_INCREMENT,
                                    `label` varchar(100) NOT NULL,
                                    PRIMARY KEY (`id_employeeFunction`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employeeFunction`
--

LOCK TABLES `employeeFunction` WRITE;
/*!40000 ALTER TABLE `employeeFunction` DISABLE KEYS */;
INSERT INTO `employeeFunction` VALUES
(1,'Directeur général'),
(2,'Commercial'),
(3,'Assistant RH'),
(4,'Vendeur'),
(5,'Magasinier'),
(6,'Livreur'),
(7,'Garagiste');
/*!40000 ALTER TABLE `employeeFunction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `litigation`
--

DROP TABLE IF EXISTS `litigation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `litigation` (
                              `id_litigation` int NOT NULL AUTO_INCREMENT,
                              `date_litigation` datetime DEFAULT NULL,
                              `comment_litigation` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                              `fk_acquisition` int DEFAULT NULL,
                              `fk_sale` int DEFAULT NULL,
                              PRIMARY KEY (`id_litigation`),
                              KEY `FK_acquisition` (`fk_acquisition`),
                              KEY `FK_sale` (`fk_sale`),
                              CONSTRAINT `FK_acquisition` FOREIGN KEY (`fk_acquisition`) REFERENCES `acquisition` (`id_acquisition`),
                              CONSTRAINT `FK_sale` FOREIGN KEY (`fk_sale`) REFERENCES `sale` (`id_sale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `litigation`
--

LOCK TABLES `litigation` WRITE;
/*!40000 ALTER TABLE `litigation` DISABLE KEYS */;
INSERT INTO `litigation` VALUES
(1,'2021-02-25 00:00:00','Souhaite un geste commercial',1,1),
(2,'2021-12-03 00:00:00','Cloturé',2,2);
/*!40000 ALTER TABLE `litigation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `location` (
                            `id_location` int NOT NULL AUTO_INCREMENT,
                            `label` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                            PRIMARY KEY (`id_location`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
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
                           `id_product` int NOT NULL AUTO_INCREMENT,
                           `label` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                           `stock` int DEFAULT NULL,
                           `price` decimal(10,0) DEFAULT NULL,
                           `comment_product` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                           `fk_productType` int DEFAULT NULL,
                           `fk_tva` int DEFAULT NULL,
                           PRIMARY KEY (`id_product`),
                           KEY `FK_productType` (`fk_productType`),
                           KEY `FK_tva` (`fk_tva`),
                           CONSTRAINT `FK_productType` FOREIGN KEY (`fk_productType`) REFERENCES `producttype` (`id_productType`),
                           CONSTRAINT `FK_tva` FOREIGN KEY (`fk_tva`) REFERENCES `tva` (`id_tva`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES
(1,'Huile moteur',12,56,'Fragile',1,1),
(2,'Huile de frein',56,12,NULL,1,1),
(3,'Roue de neige',34,55,NULL,5,1),
(4,'Plaquette de frein organique',2,156,'Deuxième main',3,1),
(5,'Vitrage acoustique',4,250,NULL,4,1),
(6,'Boite de vitesse V6',15,35,NULL,2,1);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_acquisition_provider`
--

DROP TABLE IF EXISTS `product_acquisition_provider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_acquisition_provider` (
                                                `fk_id_product_pap` int NOT NULL,
                                                `fk_id_acquisition` int NOT NULL,
                                                `fk_id_provider` int NOT NULL,
                                                `price` decimal(10,0) NOT NULL,
                                                `quantity` decimal(10,0) NOT NULL,
                                                `hour_pap` datetime DEFAULT NULL,
                                                PRIMARY KEY (`fk_id_product_pap`,`fk_id_acquisition`,`fk_id_provider`),
                                                KEY `FK_id_acquisition` (`fk_id_acquisition`),
                                                KEY `FK_id_provider` (`fk_id_provider`),
                                                CONSTRAINT `FK_id_acquisition` FOREIGN KEY (`fk_id_acquisition`) REFERENCES `acquisition` (`id_acquisition`),
                                                CONSTRAINT `FK_id_product_pap` FOREIGN KEY (`fk_id_product_pap`) REFERENCES `product` (`id_product`),
                                                CONSTRAINT `FK_id_provider` FOREIGN KEY (`fk_id_provider`) REFERENCES `provider` (`id_provider`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_acquisition_provider`
--

LOCK TABLES `product_acquisition_provider` WRITE;
/*!40000 ALTER TABLE `product_acquisition_provider` DISABLE KEYS */;
INSERT INTO `product_acquisition_provider` VALUES (1,1,1,200,1,'2021-02-25 00:00:00');
/*!40000 ALTER TABLE `product_acquisition_provider` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_sale`
--

LOCK TABLES `product_sale` WRITE;
/*!40000 ALTER TABLE `product_sale` DISABLE KEYS */;
INSERT INTO `product_sale` VALUES
(1,1,100,1,NULL,100,'2021-02-25 00:00:00');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
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
                               `id_productType` int NOT NULL AUTO_INCREMENT,
                               `type` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                               PRIMARY KEY (`id_productType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producttype`
--

LOCK TABLES `producttype` WRITE;
/*!40000 ALTER TABLE `producttype` DISABLE KEYS */;
INSERT INTO `producttype` VALUES
(1,'Huiles'),
(2,'Boites de vitesse'),
(3,'Plaquettes de frein'),
(4,'Pare Brise'),
(5,'Roues de neige');
/*!40000 ALTER TABLE `producttype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provider`
--

DROP TABLE IF EXISTS `provider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `provider` (
                            `id_provider` int NOT NULL AUTO_INCREMENT,
                            `corporate_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                            PRIMARY KEY (`id_provider`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provider`
--

LOCK TABLES `provider` WRITE;
/*!40000 ALTER TABLE `provider` DISABLE KEYS */;
INSERT INTO `provider` VALUES
(1,'LEADER PIECES AUTO'),
(2,'AUTOMOBILES DISTRIBUTION');
/*!40000 ALTER TABLE `provider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sale`
--

DROP TABLE IF EXISTS `sale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sale` (
                        `id_sale` int NOT NULL AUTO_INCREMENT,
                        `date_sale` date DEFAULT NULL,
                        `global_price_original` decimal(10,0) DEFAULT NULL,
                        `discount` decimal(10,0) DEFAULT NULL,
                        `global_price_finalised` decimal(10,0) DEFAULT NULL,
                        `to_deliver` tinyint(1) DEFAULT NULL,
                        `status_sale` enum('En cours','En attente') CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                        `fk_users` int DEFAULT NULL,
                        `fk_customer` int DEFAULT NULL,
                        PRIMARY KEY (`id_sale`),
                        KEY `FK_users` (`fk_users`),
                        KEY `FK_customer` (`fk_customer`),
                        CONSTRAINT `FK_customer` FOREIGN KEY (`fk_customer`) REFERENCES `customer` (`id_customer`),
                        CONSTRAINT `FK_users` FOREIGN KEY (`fk_users`) REFERENCES `users` (`id_users`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sale`
--

LOCK TABLES `sale` WRITE;
/*!40000 ALTER TABLE `sale` DISABLE KEYS */;
INSERT INTO `sale` VALUES
(1,'2021-02-25',100,50,50,1,'En cours',1,1),
(2,'2021-02-26',50,NULL,NULL,0,'En attente',1,1);
/*!40000 ALTER TABLE `sale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statusacquisition`
--

DROP TABLE IF EXISTS `statusacquisition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `statusacquisition` (
                                     `id_statusAcquisition` int NOT NULL AUTO_INCREMENT,
                                     `label` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                                     PRIMARY KEY (`id_statusAcquisition`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statusacquisition`
--

LOCK TABLES `statusacquisition` WRITE;
/*!40000 ALTER TABLE `statusacquisition` DISABLE KEYS */;
INSERT INTO `statusacquisition` VALUES
(1,'En cours'),
(2,'Terminé');
/*!40000 ALTER TABLE `statusacquisition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tva`
--

DROP TABLE IF EXISTS `tva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tva` (
                       `id_tva` int NOT NULL AUTO_INCREMENT,
                       `code_tva` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                       `ratio` decimal(10,0) DEFAULT NULL,
                       PRIMARY KEY (`id_tva`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tva`
--

LOCK TABLES `tva` WRITE;
/*!40000 ALTER TABLE `tva` DISABLE KEYS */;
INSERT INTO `tva` VALUES
(1,NULL,20),
(2,NULL,10),
(3,NULL,6),
(4,NULL,2);
/*!40000 ALTER TABLE `tva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
                         `id_users` int NOT NULL AUTO_INCREMENT,
                         `is_active` tinyint(1) DEFAULT NULL,
                         `login` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                         `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                         `fk_id_employee` int DEFAULT NULL,
                         `permissions` json DEFAULT NULL,
                         PRIMARY KEY (`id_users`),
                         KEY `FK_id_employee` (`fk_id_employee`),
                         CONSTRAINT `FK_id_employee` FOREIGN KEY (`fk_id_employee`) REFERENCES `employee` (`id_employee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,1,'BDX33','secret',1,NULL),
(2,1,'BDX34','secret',2,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle` (
                           `id_vehicle` int NOT NULL AUTO_INCREMENT,
                           `manufacture_year` date DEFAULT NULL,
                           `license_plate` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                           `fiscal_horse_power` int DEFAULT NULL,
                           `door_number` int DEFAULT NULL,
                           `fk_vehicleModel` int DEFAULT NULL,
                           `energy_type` enum('Diesel','Essence','Superéthanol','Hybride','Electrique') COLLATE utf8_bin DEFAULT NULL,
                           `gearbox_type` enum('Manuelle','Automatique') COLLATE utf8_bin DEFAULT NULL,
                           PRIMARY KEY (`id_vehicle`),
                           KEY `FK_vehicleModel` (`fk_vehicleModel`),
                           CONSTRAINT `FK_vehicleModel` FOREIGN KEY (`fk_vehicleModel`) REFERENCES `vehiclemodel` (`id_vehicleModel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle`
--

LOCK TABLES `vehicle` WRITE;
/*!40000 ALTER TABLE `vehicle` DISABLE KEYS */;
INSERT INTO `vehicle` VALUES
(1,'2021-02-25','AH-567-TG',4,5,1,'Diesel','Manuelle'),
(2,'2019-06-20','AS-675-HU',3,3,3,'Essence','Automatique');
/*!40000 ALTER TABLE `vehicle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehiclemodel`
--

DROP TABLE IF EXISTS `vehiclemodel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehiclemodel` (
                                `id_vehicleModel` int NOT NULL AUTO_INCREMENT,
                                `model` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                                `make` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                                PRIMARY KEY (`id_vehicleModel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehiclemodel`
--

LOCK TABLES `vehiclemodel` WRITE;
/*!40000 ALTER TABLE `vehiclemodel` DISABLE KEYS */;
INSERT INTO `vehiclemodel` VALUES
(1,'Renault 5','Renault'),
(2,'Clio','Renault'),
(3,'Golf','Volkswagen'),
(4,'Polo','Volkswagen');
/*!40000 ALTER TABLE `vehiclemodel` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-03-03 23:14:24
