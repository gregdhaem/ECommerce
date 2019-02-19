-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2018 at 05:09 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--
CREATE DATABASE IF NOT EXISTS `ecommerce` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ecommerce`;

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `membre_id` int(3) DEFAULT NULL,
  `montant` int(3) DEFAULT NULL,
  `date_enregistrement` datetime DEFAULT NULL,
  `etat` enum('en_cours_de_traitement','envoye','livre') DEFAULT NULL,
  PRIMARY KEY (`id_commande`),
  KEY `membre_id` (`membre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `details_commande`
--

DROP TABLE IF EXISTS `details_commande`;
CREATE TABLE IF NOT EXISTS `details_commande` (
  `id_details_commande` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `quantite` int(3) DEFAULT NULL,
  `prix` int(3) DEFAULT NULL,
  `produit_id` int(3) DEFAULT NULL,
  `commande_id` int(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_details_commande`),
  KEY `fk_details_commande_produit1_idx` (`produit_id`),
  KEY `details_commande_ibfk_1` (`commande_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id_membre` int(3) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) DEFAULT NULL,
  `mdp` varchar(60) DEFAULT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `prenom` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `civilite` enum('m','f') DEFAULT NULL,
  `ville` varchar(20) DEFAULT NULL,
  `code_postal` int(5) UNSIGNED ZEROFILL DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `statut` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_membre`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `ville`, `code_postal`, `adresse`, `statut`) VALUES(20, 'user', '123', 'Dupond', 'Albert', 'alD@gmail.com', 'm', 'Paris ', 75010, 'Place de la nuit', 0);
INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `ville`, `code_postal`, `adresse`, `statut`) VALUES(21, 'admin', 'admin', 'Admin', 'Admin', 'admin@gmail.com', 'f', 'Nice', 06000, 'rue de la plage', 1);
INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `ville`, `code_postal`, `adresse`, `statut`) VALUES(23, 'gregd', '123', 'D\'Haem', 'Greg', 'gregdhaem@gmail.com', '', '92190', 00000, '55 rue de St Cloud', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id_produit` int(3) NOT NULL AUTO_INCREMENT,
  `reference` varchar(20) DEFAULT NULL,
  `categorie` varchar(20) DEFAULT NULL,
  `titre` varchar(100) DEFAULT NULL,
  `description` text,
  `couleur` varchar(20) DEFAULT NULL,
  `taille` varchar(5) DEFAULT NULL,
  `public` enum('homme','femme','mixte') DEFAULT NULL,
  `photo` varchar(250) DEFAULT NULL,
  `prix` int(3) DEFAULT NULL,
  `stock` int(3) DEFAULT NULL,
  PRIMARY KEY (`id_produit`),
  UNIQUE KEY `reference_UNIQUE` (`reference`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`id_produit`, `reference`, `categorie`, `titre`, `description`, `couleur`, `taille`, `public`, `photo`, `prix`, `stock`) VALUES(10, 'iop123', 'T Shirt Humour Femme', 'Ne pas lire la phrase', 'T Shirt Humour Femme Ne pas lire la phrase', 'noir', 's', 'femme', 'http://localhost/PhP/10 - boutique/photo/iop123-ts1.webp', 54, 113);
INSERT INTO `produit` (`id_produit`, `reference`, `categorie`, `titre`, `description`, `couleur`, `taille`, `public`, `photo`, `prix`, `stock`) VALUES(11, 'iop456', 'T Shirt Humour Mixte', 'Ne pas lire la phrase', 'T Shirt Humour Mixte Ne pas lire la phrase', 'gris', 'xl', 'mixte', 'http://localhost/PhP/10 - boutique/photo/iop456-ts1.webp', 59, 45);
INSERT INTO `produit` (`id_produit`, `reference`, `categorie`, `titre`, `description`, `couleur`, `taille`, `public`, `photo`, `prix`, `stock`) VALUES(12, 'iop741', 'T Shirt Humour Femme', 'Ne pas lire la phrase', 'T Shirt Humour Femme Ne pas lire la phrase', 'gris', 'm', 'femme', 'http://localhost/PhP/10 - boutique/photo/iop741-ts1.webp', 50, 45);
INSERT INTO `produit` (`id_produit`, `reference`, `categorie`, `titre`, `description`, `couleur`, `taille`, `public`, `photo`, `prix`, `stock`) VALUES(13, 'iop789', 'T Shirt Humour Homme', 'Ne pas lire la phrase', 'T Shirt Humour Homme Ne pas lire la phrase', 'noir', 'xl', 'homme', 'http://localhost/PhP/10 - boutique/photo/iop789-ts1.webp', 57, 45);
INSERT INTO `produit` (`id_produit`, `reference`, `categorie`, `titre`, `description`, `couleur`, `taille`, `public`, `photo`, `prix`, `stock`) VALUES(14, 'iop713', 'T Shirt Humour Femme', 'Ne pas lire la phrase', 'T Shirt Humour Femme Ne pas lire la phrase', 'noir', 's', 'femme', 'http://localhost/PhP/10 - boutique/photo/iop713-ts1.webp', 48, 45);
INSERT INTO `produit` (`id_produit`, `reference`, `categorie`, `titre`, `description`, `couleur`, `taille`, `public`, `photo`, `prix`, `stock`) VALUES(16, 'iop159', 'T Shirt Humour Femme', 'Ne pas lire la phrase', 'T Shirt humour \"Promo\"', 'gris', 'xxl', 'femme', 'http://localhost/PhP/10 - boutique/photo/iop159-ts1.webp', 17, 48);
INSERT INTO `produit` (`id_produit`, `reference`, `categorie`, `titre`, `description`, `couleur`, `taille`, `public`, `photo`, `prix`, `stock`) VALUES(17, 'iop558', 'T Shirt Uni', 'T Shirt uni rouge', '100 % Cotton. Tee Shirt Rouge', 'Rouge', 'l', 'homme', 'http://localhost/PhP/10 - boutique/photo/iop558-red.jpg', 19, 200);
INSERT INTO `produit` (`id_produit`, `reference`, `categorie`, `titre`, `description`, `couleur`, `taille`, `public`, `photo`, `prix`, `stock`) VALUES(18, 'iop656', 'T Shirt Uni', 'T Shirt uni noir', '100 % Cotton. Couleur Noir. Made in Hong Kong.', 'Noir', 'l', 'homme', 'http://localhost/PhP/10 - boutique/photo/iop656-black.jpg', 18, 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
