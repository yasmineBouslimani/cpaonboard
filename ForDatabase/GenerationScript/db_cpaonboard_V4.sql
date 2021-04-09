-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 07 avr. 2021 à 23:40
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE DATABASE  IF NOT EXISTS `cpaonboard` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */ ;
USE `cpaonboard`;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cpaonboard`
--

-- --------------------------------------------------------

--
-- Structure de la table `acquisition`
--
DROP TABLE IF EXISTS `acquisition`;
CREATE TABLE `acquisition` (
                               `id_acquisition` int(11) NOT NULL,
                               `date_acquisition` datetime DEFAULT NULL,
                               `date_reception` datetime DEFAULT NULL,
                               `global_price` decimal(10,0) DEFAULT NULL,
                               `fk_id_users` int(11) DEFAULT NULL,
                               `fk_id_statusAcquisition` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `acquisition`
--

LOCK TABLES `acquisition` WRITE;
INSERT INTO `acquisition` (`id_acquisition`, `date_acquisition`, `date_reception`, `global_price`, `fk_id_users`, `fk_id_statusAcquisition`) VALUES
(1, '2021-02-25 00:00:00', '2021-03-02 00:00:00', '200', 1, 1),
(2, '2021-02-25 00:00:00', '2021-03-01 00:00:00', '135', 2, 2);
UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Structure de la table `contact`
--
DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
                           `id_contact` int(11) NOT NULL,
                           `first_name` varchar(25) COLLATE utf8_bin DEFAULT NULL,
                           `last_name` varchar(25) COLLATE utf8_bin DEFAULT NULL,
                           `corporate_name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
                           `address_street_number` int(11) DEFAULT NULL,
                           `address_street` varchar(100) COLLATE utf8_bin DEFAULT NULL,
                           `professional_email_address` varchar(50) COLLATE utf8_bin DEFAULT NULL,
                           `personal_email_address` varchar(50) COLLATE utf8_bin DEFAULT NULL,
                           `cellphone_number` varchar(10) COLLATE utf8_bin DEFAULT NULL,
                           `phone_number` varchar(10) COLLATE utf8_bin DEFAULT NULL,
                           `address_city` varchar(25) COLLATE utf8_bin DEFAULT NULL,
                           `address_zip_code` int(11) DEFAULT NULL,
                           `address_addition` varchar(100) COLLATE utf8_bin DEFAULT NULL,
                           `fk_id_provider2` int(11) DEFAULT NULL,
                           `fk_id_employee2` int(11) DEFAULT NULL,
                           `fk_id_customer2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `contact`
--
LOCK TABLES `contact` WRITE;
INSERT INTO `contact` (`id_contact`, `first_name`, `last_name`, `corporate_name`, `address_street_number`, `address_street`, `professional_email_address`, `personal_email_address`, `cellphone_number`, `phone_number`, `address_city`, `address_zip_code`, `address_addition`, `fk_id_provider2`, `fk_id_employee2`, `fk_id_customer2`) VALUES
(1, 'Henri', 'Delauret', NULL, 34, 'Rue du Temple', 'henri@gmail.com', NULL, '0656784539', NULL, 'BORDEAUX', 33000, NULL, NULL, 1, NULL),
(2, 'Elise', 'Lunet', NULL, 106, 'Cours Verdun', 'elise@gmail.com', NULL, '0563456785', NULL, 'BORDEAUX', 33300, '2° étage', NULL, NULL, 1),
(3, 'Anna', 'Bonnet', 'LEADER PIECES AUTO', 67, 'Rue Gennet', 'anna@gmail.com', NULL, '0767867647', '0567854368', 'LANGON', 45000, NULL, 1, NULL, NULL),
(4, 'Marie', 'Berthelot', NULL, 45, 'Rue André Gardon', 'anff@cpaonboard.com', '', '', '0675782736', 'BORDEAUX', 33000, '', NULL, 2, NULL),
(5, 'Myriam', 'Mitier', NULL, 67, 'Rue du Noyer', '', 'm.mitter@gmail.com', '0675376847', NULL, 'Bordeaux', 33400, '4e étage - Bat C', NULL, 3, NULL),
(7, 'Eric', 'Dupont', 'HergéInc', 12, 'rue Edmond Rostand', 'edupont@gmail.com', NULL, '0553782222', NULL, 'MERIGNAC', 33700, 'NULL', NULL, NULL, 3),
(8, 'Frédérick', 'Dupond', 'HergéInc', 13, 'rue Edmond Rostand', 'edupond@gmail.com', NULL, '0553783333', NULL, 'MERIGNAC', 33700, 'NULL', NULL, NULL, 4),
(9, 'Nathalie', 'Perlet', NULL, 27, 'rue de la rose', 'nperlet@gmail.com', '', '055585672', '', 'PESSAC', 33600, 'NULL', NULL, 4, NULL),
(10, 'Laurent', 'Dupuis', NULL, 43, 'rue des jonquilles', 'ldpuis@gmail.com', NULL, '055665653', NULL, 'PESSAC', 33600, 'NULL', NULL, 5, NULL),
(11, 'Chloé', 'Laforge', NULL, 4, 'avenue de Paris', 'claforge@gmail.com', NULL, '056545682', '511853268', 'BORDEAUX', 33300, 'NULL', NULL, 6, NULL),
(12, 'Pauline', 'Perlet', NULL, 0, '', NULL, '', '', '', '', 0, '', NULL, NULL, 5);
UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Structure de la table `contacttype`
--
DROP TABLE IF EXISTS `contacttype`;
CREATE TABLE `contacttype` (
                               `id_contactType` int(11) NOT NULL,
                               `label` varchar(100) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `contacttype_contact`
--
DROP TABLE IF EXISTS `contacttype_contact`;
CREATE TABLE `contacttype_contact` (
                                       `fk_id_contactType` int(11) NOT NULL,
                                       `fk_id_contact` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `contract`
--
DROP TABLE IF EXISTS `contract`;
CREATE TABLE `contract` (
                            `id_contract` int(11) NOT NULL,
                            `type_contract` enum('CDI','CDD','Contrat pro','Contrat d''apprentissage','Interim','Stage') COLLATE utf8_bin DEFAULT NULL,
                            `starting_date` date DEFAULT NULL,
                            `wage_first_year` int(11) DEFAULT NULL,
                            `wage_second_year` int(11) DEFAULT NULL,
                            `wage_third_year` int(11) DEFAULT NULL,
                            `on_going` tinyint(1) DEFAULT NULL,
                            `fk_employee` int(11) DEFAULT NULL,
                            `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `contract`
--
LOCK TABLES `contract` WRITE;
INSERT INTO `contract` (`id_contract`, `type_contract`, `starting_date`, `wage_first_year`, `wage_second_year`, `wage_third_year`, `on_going`, `fk_employee`, `end_date`) VALUES
(1, 'CDI', '2003-12-03', NULL, NULL, NULL, 1, 1, NULL),
(2, 'CDD', '2003-11-25', NULL, NULL, NULL, 0, 2, '2004-05-14'),
(3, 'CDI', '2004-05-15', 0, 0, 0, 1, 2, '0000-00-00'),
(4, 'CDI', '2020-03-05', NULL, NULL, NULL, 1, 3, NULL),
(5, 'Stage', '2011-02-25', 0, 0, 0, 1, 4, '2011-03-30'),
(6, 'CDI', '2000-12-04', NULL, NULL, NULL, 1, 5, NULL),
(7, 'CDI', '2021-07-26', NULL, NULL, NULL, 1, 6, NULL);
UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Structure de la table `customer`
--
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
                            `id_customer` int(11) NOT NULL,
                            `fk_customerType` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `customer`
--
LOCK TABLES `customer` WRITE;
INSERT INTO `customer` (`id_customer`, `fk_customerType`) VALUES
(1, 1),
(5, 1),
(3, 2),
(4, 2);
UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Structure de la table `customertype`
--
DROP TABLE IF EXISTS `customertype`;
CREATE TABLE `customertype` (
                                `id_customerType` int(11) NOT NULL,
                                `label` varchar(100) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `customertype`
--
LOCK TABLES `customertype` WRITE;
INSERT INTO `customertype` (`id_customerType`, `label`) VALUES
(1, 'Particulier'),
(2, 'Professionnel');
UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Structure de la table `customer_vehicle`
--
DROP TABLE IF EXISTS `customer_vehicle`;
CREATE TABLE `customer_vehicle` (
                                    `fk_id_vehicle` int(11) NOT NULL,
                                    `fk_id_customer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `department`
--
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
                              `id_department` int(11) NOT NULL,
                              `label` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `department`
--
LOCK TABLES `department` WRITE;
INSERT INTO `department` (`id_department`, `label`) VALUES
(1, 'DIRECTION'),
(2, 'COMMERCIAL'),
(3, 'RH'),
(4, 'ACCESSOIRE & ENTRETIENS'),
(5, 'HABITACLE'),
(6, 'MOTEUR & DEPENDANCES'),
(7, 'CARROSSERIE'),
(8, 'CONSOMMABLES'),
(9, 'MAGASIN'),
(10, 'LIVRAISON'),
(11, 'REPARATION');
UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Structure de la table `dependancy`
--
DROP TABLE IF EXISTS `dependancy`;
CREATE TABLE `dependancy` (
                              `id_dependancy` int(11) NOT NULL,
                              `fk_id_product_1` int(11) DEFAULT NULL,
                              `fk_id_product_2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `dependancy`
--
LOCK TABLES `dependancy` WRITE;
INSERT INTO `dependancy` (`id_dependancy`, `fk_id_product_1`, `fk_id_product_2`) VALUES
(1, 1, 2);
UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Structure de la table `employee`
--
DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee` (
                            `id_employee` int(11) NOT NULL,
                            `employee_hr_id` varchar(100) COLLATE utf8_bin DEFAULT NULL,
                            `gender` enum('F','M','NC') COLLATE utf8_bin DEFAULT NULL,
                            `civility` enum('Mme','M','NC') COLLATE utf8_bin DEFAULT NULL,
                            `birth_date` date DEFAULT NULL,
                            `birth_place` varchar(100) COLLATE utf8_bin DEFAULT NULL,
                            `social_security_number` int(11) DEFAULT NULL,
                            `bank_name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
                            `bank_city` varchar(100) COLLATE utf8_bin DEFAULT NULL,
                            `bank_iban` varchar(34) COLLATE utf8_bin DEFAULT NULL,
                            `bank_bic` varchar(11) COLLATE utf8_bin DEFAULT NULL,
                            `wage_ratio` int(11) DEFAULT NULL,
                            `wage_hiring` int(11) DEFAULT NULL,
                            `fk_department` int(11) DEFAULT NULL,
                            `fk_employeeFunction` int(11) DEFAULT NULL,
                            `is_active` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `employee`
--
LOCK TABLES `employee` WRITE;
INSERT INTO `employee` (`id_employee`, `employee_hr_id`, `gender`, `civility`, `birth_date`, `birth_place`, `social_security_number`, `bank_name`, `bank_city`, `bank_iban`, `bank_bic`, `wage_ratio`, `wage_hiring`, `fk_department`, `fk_employeeFunction`, `is_active`) VALUES
(1, 'BDX33', 'M', 'M', '1985-02-25', 'Paris', NULL, 'SG', NULL, NULL, NULL, NULL, NULL, 1, 1, 1),
(2, 'BDX34', 'F', 'Mme', '2000-02-25', 'Agen', 0, 'ING', '', '', '', 0, 0, 2, 2, 0),
(3, 'BDX35', 'F', 'Mme', '1993-02-25', 'Guadeloupe', NULL, 'CE', NULL, NULL, NULL, NULL, NULL, 3, 3, 1),
(4, 'BDX36', 'F', 'Mme', '1987-03-21', 'Bordeaux', 0, 'CE', '', '', '', 0, 0, 3, 3, 0),
(5, 'BDX37', 'F', 'M', '1991-01-02', 'Bordeaux', NULL, 'CE', NULL, NULL, NULL, NULL, NULL, 6, 4, 1),
(6, 'BDX37', 'F', 'Mme', '1997-06-14', 'Lyon', NULL, 'CE', NULL, NULL, NULL, NULL, NULL, 9, 5, 1);
UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Structure de la table `employeefunction`
--
DROP TABLE IF EXISTS `employeeFunction`;
CREATE TABLE `employeefunction` (
                                    `id_employeeFunction` int(11) NOT NULL,
                                    `label` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `employeefunction`
--
LOCK TABLES `employeeFunction` WRITE;
INSERT INTO `employeefunction` (`id_employeeFunction`, `label`) VALUES
(1, 'Directeur général'),
(2, 'Commercial'),
(3, 'Assistant RH'),
(4, 'Vendeur'),
(5, 'Magasinier'),
(6, 'Livreur'),
(7, 'Garagiste');
UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Structure de la table `litigation`
--
DROP TABLE IF EXISTS `litigation`;
CREATE TABLE `litigation` (
                              `id_litigation` int(11) NOT NULL,
                              `date_litigation` datetime DEFAULT NULL,
                              `comment_litigation` varchar(255) COLLATE utf8_bin DEFAULT NULL,
                              `fk_acquisition` int(11) DEFAULT NULL,
                              `fk_sale` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `litigation`
--
LOCK TABLES `litigation` WRITE;
INSERT INTO `litigation` (`id_litigation`, `date_litigation`, `comment_litigation`, `fk_acquisition`, `fk_sale`) VALUES
(1, '2021-02-25 00:00:00', 'Souhaite un geste commercial', 1, 1);
UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Structure de la table `location`
--
DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
                            `id_location` int(11) NOT NULL,
                            `label` varchar(100) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
                           `id_product` int(11) NOT NULL,
                           `label` varchar(100) COLLATE utf8_bin DEFAULT NULL,
                           `stock` int(11) DEFAULT NULL,
                           `price` decimal(10,0) DEFAULT NULL,
                           `comment_product` varchar(255) COLLATE utf8_bin DEFAULT NULL,
                           `fk_productType` int(11) DEFAULT NULL,
                           `fk_tva` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `product`
--
LOCK TABLES `product` WRITE;
INSERT INTO `product` (`id_product`, `label`, `stock`, `price`, `comment_product`, `fk_productType`, `fk_tva`) VALUES
(1, 'Huile moteur', 12, '56', 'Fragile', 1, 1),
(2, 'Huile de frein', 56, '12', NULL, 1, 1),
(3, 'Roue de neige', 34, '55', NULL, 5, 1),
(4, 'Plaquette de frein organique', 2, '156', 'Deuxième main', 3, 1),
(5, 'Vitrage acoustique', 4, '250', NULL, 4, 1),
(6, 'Boite de vitesse V6', 15, '35', NULL, 2, 1);
UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Structure de la table `productlocation`
--
DROP TABLE IF EXISTS `productlocation`;
CREATE TABLE `productlocation` (
                                   `fk_id_product` int(11) NOT NULL,
                                   `fk_id_location` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `producttype`
--
DROP TABLE IF EXISTS `producttype`;
CREATE TABLE `producttype` (
                               `id_productType` int(11) NOT NULL,
                               `type` varchar(100) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `producttype`
--
LOCK TABLES `producttype` WRITE;
INSERT INTO `producttype` (`id_productType`, `type`) VALUES
(1, 'Huiles'),
(2, 'Boites de vitesse'),
(3, 'Plaquettes de frein'),
(4, 'Pare Brise'),
(5, 'Roues de neige');
UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Structure de la table `product_acquisition_provider`
--
DROP TABLE IF EXISTS `product_acquisition_provider`;
CREATE TABLE `product_acquisition_provider` (
                                                `fk_id_product_pap` int(11) NOT NULL,
                                                `fk_id_acquisition` int(11) NOT NULL,
                                                `fk_id_provider` int(11) NOT NULL,
                                                `price` decimal(10,0) NOT NULL,
                                                `quantity` decimal(10,0) NOT NULL,
                                                `hour_pap` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `product_acquisition_provider`
--
LOCK TABLES `product_acquisition_provider` WRITE;
INSERT INTO `product_acquisition_provider` (`fk_id_product_pap`, `fk_id_acquisition`, `fk_id_provider`, `price`, `quantity`, `hour_pap`) VALUES
(1, 1, 1, '200', '1', '2021-02-25 00:00:00');
UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Structure de la table `product_sale`
--
DROP TABLE IF EXISTS `product_sale`;
CREATE TABLE `product_sale` (
                                `fk_id_product` int(11) NOT NULL,
                                `fk_id_sale` int(11) NOT NULL,
                                `original_price` decimal(10,2) DEFAULT NULL,
                                `quantity` int(11) DEFAULT NULL,
                                `discount_percentage` decimal(10,2) DEFAULT NULL,
                                `finalised_price` decimal(10,2) DEFAULT NULL,
                                `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `product_sale`
--
LOCK TABLES `product_sale` WRITE;
INSERT INTO `product_sale` (`fk_id_product`, `fk_id_sale`, `original_price`, `quantity`, `discount_percentage`, `finalised_price`, `created_at`) VALUES
(1, 1, '140.00', 5, '50.00', '196.00', '2021-02-25 00:00:00'),
(2, 1, '38.40', 4, '20.00', '48.00', NULL),
(5, 1, '500.00', 2, '0.00', '600.00', NULL);
UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Structure de la table `provider`
--
DROP TABLE IF EXISTS `provider`;
CREATE TABLE `provider` (
                            `id_provider` int(11) NOT NULL,
                            `corporate_name` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `provider`
--
LOCK TABLES `provider` WRITE;
INSERT INTO `provider` (`id_provider`, `corporate_name`) VALUES
(1, 'LEADER PIECES AUTO'),
(2, 'AUTOMOBILES DISTRIBUTION');
UNLOCK TABLES;

-- --------------------------------------------------------

--
-- Structure de la table `sale`
--
DROP TABLE IF EXISTS `sale`;
CREATE TABLE `sale` (
                        `id_sale` int(11) NOT NULL,
                        `date_sale` date DEFAULT NULL,
                        `global_price_original` decimal(10,2) DEFAULT NULL,
                        `discount_percentage` decimal(10,2) DEFAULT NULL,
                        `global_price_finalised` decimal(10,2) DEFAULT NULL,
                        `to_deliver` tinyint(1) DEFAULT NULL,
                        `status_sale` enum('En cours','En attente') COLLATE utf8_bin DEFAULT NULL,
                        `fk_users` int(11) DEFAULT NULL,
                        `fk_customer` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `sale`
--
LOCK TABLES `sale` WRITE;
INSERT INTO `sale` (`id_sale`, `date_sale`, `global_price_original`, `discount_percentage`, `global_price_finalised`, `to_deliver`, `status_sale`, `fk_users`, `fk_customer`) VALUES
(1, '2021-02-25', '678.40', '45.00', '538.72', 1, 'En cours', 1, 1);
UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Structure de la table `statusacquisition`
--
DROP TABLE IF EXISTS `statusacquisition`;
CREATE TABLE `statusacquisition` (
                                     `id_statusAcquisition` int(11) NOT NULL,
                                     `label` varchar(100) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `statusacquisition`
--
LOCK TABLES `statusacquisition` WRITE;
INSERT INTO `statusacquisition` (`id_statusAcquisition`, `label`) VALUES
(1, 'En cours'),
(2, 'Terminé');
UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Structure de la table `tva`
--
DROP TABLE IF EXISTS `tva`;
CREATE TABLE `tva` (
                       `id_tva` int(11) NOT NULL,
                       `code_tva` varchar(100) COLLATE utf8_bin DEFAULT NULL,
                       `ratio` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `tva`
--
LOCK TABLES `tva` WRITE;
INSERT INTO `tva` (`id_tva`, `code_tva`, `ratio`) VALUES
(1, NULL, '20'),
(2, NULL, '10'),
(3, NULL, '6'),
(4, NULL, '2');
UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Structure de la table `users`
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
                         `id_users` int(11) NOT NULL,
                         `is_active` tinyint(1) DEFAULT NULL,
                         `login` varchar(20) COLLATE utf8_bin DEFAULT NULL,
                         `password` varchar(255) COLLATE utf8_bin DEFAULT NULL,
                         `fk_id_employee` int(11) DEFAULT NULL,
                         `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `users`
--
LOCK TABLES `users` WRITE;
INSERT INTO `users` (`id_users`, `is_active`, `login`, `password`, `fk_id_employee`, `permissions`) VALUES
(1, 1, 'BDX33', 'secret', 1, NULL),
(2, 1, 'BDX34', 'secret', 2, NULL);
UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Structure de la table `vehicle`
--
DROP TABLE IF EXISTS `vehicle`;
CREATE TABLE `vehicle` (
                           `id_vehicle` int(11) NOT NULL,
                           `manufacture_year` date DEFAULT NULL,
                           `license_plate` varchar(12) COLLATE utf8_bin DEFAULT NULL,
                           `fiscal_horse_power` int(11) DEFAULT NULL,
                           `door_number` int(11) DEFAULT NULL,
                           `fk_vehicleModel` int(11) DEFAULT NULL,
                           `energy_type` enum('Diesel','Essence','Superéthanol','Hybride','Electrique') COLLATE utf8_bin DEFAULT NULL,
                           `gearbox_type` enum('Manuelle','Automatique') COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `vehicle`
--
LOCK TABLES `vehicle` WRITE;
INSERT INTO `vehicle` (`id_vehicle`, `manufacture_year`, `license_plate`, `fiscal_horse_power`, `door_number`, `fk_vehicleModel`, `energy_type`, `gearbox_type`) VALUES
(1, '2021-02-25', 'AH-567-TG', 4, 5, 1, 'Diesel', 'Manuelle'),
(2, '2019-06-20', 'AS-675-HU', 3, 3, 3, 'Essence', 'Automatique');
UNLOCK TABLES;
-- --------------------------------------------------------

--
-- Structure de la table `vehiclemodel`
--
DROP TABLE IF EXISTS `vehiclemodel`;
CREATE TABLE `vehiclemodel` (
                                `id_vehicleModel` int(11) NOT NULL,
                                `model` varchar(100) COLLATE utf8_bin DEFAULT NULL,
                                `make` varchar(100) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `vehiclemodel`
--
LOCK TABLES `vehiclemodel` WRITE;
INSERT INTO `vehiclemodel` (`id_vehicleModel`, `model`, `make`) VALUES
(1, 'Renault 5', 'Renault'),
(2, 'Clio', 'Renault'),
(3, 'Golf', 'Volkswagen'),
(4, 'Polo', 'Volkswagen');
UNLOCK TABLES;
--
-- Index pour les tables déchargées
--

--
-- Index pour la table `acquisition`
--
ALTER TABLE `acquisition`
    ADD PRIMARY KEY (`id_acquisition`),
  ADD KEY `FK_id_users` (`fk_id_users`),
  ADD KEY `FK_id_statusAcquisition` (`fk_id_statusAcquisition`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
    ADD PRIMARY KEY (`id_contact`),
  ADD KEY `FK_id_provider2` (`fk_id_provider2`),
  ADD KEY `FK_id_employee2` (`fk_id_employee2`),
  ADD KEY `FK_id_customer2` (`fk_id_customer2`);

--
-- Index pour la table `contacttype`
--
ALTER TABLE `contacttype`
    ADD PRIMARY KEY (`id_contactType`);

--
-- Index pour la table `contacttype_contact`
--
ALTER TABLE `contacttype_contact`
    ADD PRIMARY KEY (`fk_id_contactType`,`fk_id_contact`),
  ADD KEY `FK_id_contact` (`fk_id_contact`);

--
-- Index pour la table `contract`
--
ALTER TABLE `contract`
    ADD PRIMARY KEY (`id_contract`),
  ADD KEY `FK_employee` (`fk_employee`);

--
-- Index pour la table `customer`
--
ALTER TABLE `customer`
    ADD PRIMARY KEY (`id_customer`),
  ADD KEY `FK_customerType` (`fk_customerType`);

--
-- Index pour la table `customertype`
--
ALTER TABLE `customertype`
    ADD PRIMARY KEY (`id_customerType`);

--
-- Index pour la table `customer_vehicle`
--
ALTER TABLE `customer_vehicle`
    ADD PRIMARY KEY (`fk_id_customer`,`fk_id_vehicle`),
  ADD KEY `FK_id_vehicle` (`fk_id_vehicle`);

--
-- Index pour la table `department`
--
ALTER TABLE `department`
    ADD PRIMARY KEY (`id_department`);

--
-- Index pour la table `dependancy`
--
ALTER TABLE `dependancy`
    ADD PRIMARY KEY (`id_dependancy`),
  ADD KEY `FK_id_product_1_idx` (`fk_id_product_1`),
  ADD KEY `FK_id_product_2_idx` (`fk_id_product_2`);

--
-- Index pour la table `employee`
--
ALTER TABLE `employee`
    ADD PRIMARY KEY (`id_employee`),
  ADD KEY `FK_department` (`fk_department`),
  ADD KEY `FK_employeeFunction` (`fk_employeeFunction`);

--
-- Index pour la table `employeefunction`
--
ALTER TABLE `employeefunction`
    ADD PRIMARY KEY (`id_employeeFunction`);

--
-- Index pour la table `litigation`
--
ALTER TABLE `litigation`
    ADD PRIMARY KEY (`id_litigation`),
  ADD KEY `FK_acquisition` (`fk_acquisition`),
  ADD KEY `FK_sale` (`fk_sale`);

--
-- Index pour la table `location`
--
ALTER TABLE `location`
    ADD PRIMARY KEY (`id_location`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
    ADD PRIMARY KEY (`id_product`),
  ADD KEY `FK_productType` (`fk_productType`),
  ADD KEY `FK_tva` (`fk_tva`);

--
-- Index pour la table `productlocation`
--
ALTER TABLE `productlocation`
    ADD PRIMARY KEY (`fk_id_product`,`fk_id_location`),
  ADD KEY `FK_id_location` (`fk_id_location`);

--
-- Index pour la table `producttype`
--
ALTER TABLE `producttype`
    ADD PRIMARY KEY (`id_productType`);

--
-- Index pour la table `product_acquisition_provider`
--
ALTER TABLE `product_acquisition_provider`
    ADD PRIMARY KEY (`fk_id_product_pap`,`fk_id_acquisition`,`fk_id_provider`),
  ADD KEY `FK_id_acquisition` (`fk_id_acquisition`),
  ADD KEY `FK_id_provider` (`fk_id_provider`);

--
-- Index pour la table `product_sale`
--
ALTER TABLE `product_sale`
    ADD PRIMARY KEY (`fk_id_sale`,`fk_id_product`),
  ADD KEY `FK_id_product` (`fk_id_product`);

--
-- Index pour la table `provider`
--
ALTER TABLE `provider`
    ADD PRIMARY KEY (`id_provider`);

--
-- Index pour la table `sale`
--
ALTER TABLE `sale`
    ADD PRIMARY KEY (`id_sale`),
  ADD KEY `FK_users` (`fk_users`),
  ADD KEY `FK_customer` (`fk_customer`);

--
-- Index pour la table `statusacquisition`
--
ALTER TABLE `statusacquisition`
    ADD PRIMARY KEY (`id_statusAcquisition`);

--
-- Index pour la table `tva`
--
ALTER TABLE `tva`
    ADD PRIMARY KEY (`id_tva`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`id_users`),
  ADD KEY `FK_id_employee` (`fk_id_employee`);

--
-- Index pour la table `vehicle`
--
ALTER TABLE `vehicle`
    ADD PRIMARY KEY (`id_vehicle`),
  ADD KEY `FK_vehicleModel` (`fk_vehicleModel`);

--
-- Index pour la table `vehiclemodel`
--
ALTER TABLE `vehiclemodel`
    ADD PRIMARY KEY (`id_vehicleModel`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `acquisition`
--
ALTER TABLE `acquisition`
    MODIFY `id_acquisition` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
    MODIFY `id_contact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `contacttype`
--
ALTER TABLE `contacttype`
    MODIFY `id_contactType` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `contract`
--
ALTER TABLE `contract`
    MODIFY `id_contract` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `customer`
--
ALTER TABLE `customer`
    MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `customertype`
--
ALTER TABLE `customertype`
    MODIFY `id_customerType` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `department`
--
ALTER TABLE `department`
    MODIFY `id_department` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `dependancy`
--
ALTER TABLE `dependancy`
    MODIFY `id_dependancy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `employee`
--
ALTER TABLE `employee`
    MODIFY `id_employee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `employeefunction`
--
ALTER TABLE `employeefunction`
    MODIFY `id_employeeFunction` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `litigation`
--
ALTER TABLE `litigation`
    MODIFY `id_litigation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `location`
--
ALTER TABLE `location`
    MODIFY `id_location` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
    MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `producttype`
--
ALTER TABLE `producttype`
    MODIFY `id_productType` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `provider`
--
ALTER TABLE `provider`
    MODIFY `id_provider` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `sale`
--
ALTER TABLE `sale`
    MODIFY `id_sale` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `statusacquisition`
--
ALTER TABLE `statusacquisition`
    MODIFY `id_statusAcquisition` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `tva`
--
ALTER TABLE `tva`
    MODIFY `id_tva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
    MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `vehicle`
--
ALTER TABLE `vehicle`
    MODIFY `id_vehicle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `vehiclemodel`
--
ALTER TABLE `vehiclemodel`
    MODIFY `id_vehicleModel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `acquisition`
--
ALTER TABLE `acquisition`
    ADD CONSTRAINT `FK_id_statusAcquisition` FOREIGN KEY (`fk_id_statusAcquisition`) REFERENCES `statusacquisition` (`id_statusAcquisition`),
  ADD CONSTRAINT `FK_id_users` FOREIGN KEY (`fk_id_users`) REFERENCES `users` (`id_users`);

--
-- Contraintes pour la table `contact`
--
ALTER TABLE `contact`
    ADD CONSTRAINT `FK_id_customer2` FOREIGN KEY (`fk_id_customer2`) REFERENCES `customer` (`id_customer`),
  ADD CONSTRAINT `FK_id_employee2` FOREIGN KEY (`fk_id_employee2`) REFERENCES `employee` (`id_employee`),
  ADD CONSTRAINT `FK_id_provider2` FOREIGN KEY (`fk_id_provider2`) REFERENCES `provider` (`id_provider`);

--
-- Contraintes pour la table `contacttype_contact`
--
ALTER TABLE `contacttype_contact`
    ADD CONSTRAINT `FK_id_contact` FOREIGN KEY (`fk_id_contact`) REFERENCES `contact` (`id_contact`),
  ADD CONSTRAINT `FK_id_contactType` FOREIGN KEY (`fk_id_contactType`) REFERENCES `contacttype` (`id_contactType`);

--
-- Contraintes pour la table `contract`
--
ALTER TABLE `contract`
    ADD CONSTRAINT `FK_employee` FOREIGN KEY (`fk_employee`) REFERENCES `employee` (`id_employee`);

--
-- Contraintes pour la table `customer`
--
ALTER TABLE `customer`
    ADD CONSTRAINT `FK_customerType` FOREIGN KEY (`fk_customerType`) REFERENCES `customertype` (`id_customerType`);

--
-- Contraintes pour la table `customer_vehicle`
--
ALTER TABLE `customer_vehicle`
    ADD CONSTRAINT `FK_id_customer` FOREIGN KEY (`fk_id_customer`) REFERENCES `customer` (`id_customer`),
  ADD CONSTRAINT `FK_id_vehicle` FOREIGN KEY (`fk_id_vehicle`) REFERENCES `vehicle` (`id_vehicle`);

--
-- Contraintes pour la table `dependancy`
--
ALTER TABLE `dependancy`
    ADD CONSTRAINT `FK_id_product_1` FOREIGN KEY (`fk_id_product_1`) REFERENCES `product` (`id_product`),
  ADD CONSTRAINT `FK_id_product_2` FOREIGN KEY (`fk_id_product_2`) REFERENCES `product` (`id_product`);

--
-- Contraintes pour la table `employee`
--
ALTER TABLE `employee`
    ADD CONSTRAINT `FK_department` FOREIGN KEY (`fk_department`) REFERENCES `department` (`id_department`),
  ADD CONSTRAINT `FK_employeeFunction` FOREIGN KEY (`fk_employeeFunction`) REFERENCES `employeefunction` (`id_employeeFunction`);

--
-- Contraintes pour la table `litigation`
--
ALTER TABLE `litigation`
    ADD CONSTRAINT `FK_acquisition` FOREIGN KEY (`fk_acquisition`) REFERENCES `acquisition` (`id_acquisition`),
  ADD CONSTRAINT `FK_sale` FOREIGN KEY (`fk_sale`) REFERENCES `sale` (`id_sale`);

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
    ADD CONSTRAINT `FK_productType` FOREIGN KEY (`fk_productType`) REFERENCES `producttype` (`id_productType`),
  ADD CONSTRAINT `FK_tva` FOREIGN KEY (`fk_tva`) REFERENCES `tva` (`id_tva`);

--
-- Contraintes pour la table `productlocation`
--
ALTER TABLE `productlocation`
    ADD CONSTRAINT `FK_id_location` FOREIGN KEY (`fk_id_location`) REFERENCES `location` (`id_location`),
  ADD CONSTRAINT `FK_id_product_location` FOREIGN KEY (`fk_id_product`) REFERENCES `product` (`id_product`);

--
-- Contraintes pour la table `product_acquisition_provider`
--
ALTER TABLE `product_acquisition_provider`
    ADD CONSTRAINT `FK_id_acquisition` FOREIGN KEY (`fk_id_acquisition`) REFERENCES `acquisition` (`id_acquisition`),
  ADD CONSTRAINT `FK_id_product_pap` FOREIGN KEY (`fk_id_product_pap`) REFERENCES `product` (`id_product`),
  ADD CONSTRAINT `FK_id_provider` FOREIGN KEY (`fk_id_provider`) REFERENCES `provider` (`id_provider`);

--
-- Contraintes pour la table `product_sale`
--
ALTER TABLE `product_sale`
    ADD CONSTRAINT `FK_id_product` FOREIGN KEY (`fk_id_product`) REFERENCES `product` (`id_product`),
  ADD CONSTRAINT `FK_id_sale` FOREIGN KEY (`fk_id_sale`) REFERENCES `sale` (`id_sale`);

--
-- Contraintes pour la table `sale`
--
ALTER TABLE `sale`
    ADD CONSTRAINT `FK_customer` FOREIGN KEY (`fk_customer`) REFERENCES `customer` (`id_customer`),
  ADD CONSTRAINT `FK_users` FOREIGN KEY (`fk_users`) REFERENCES `users` (`id_users`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
    ADD CONSTRAINT `FK_id_employee` FOREIGN KEY (`fk_id_employee`) REFERENCES `employee` (`id_employee`);

--
-- Contraintes pour la table `vehicle`
--
ALTER TABLE `vehicle`
    ADD CONSTRAINT `FK_vehicleModel` FOREIGN KEY (`fk_vehicleModel`) REFERENCES `vehiclemodel` (`id_vehicleModel`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
