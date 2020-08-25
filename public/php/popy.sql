-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 25 août 2020 à 14:54
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `popy`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

DROP TABLE IF EXISTS `annonce`;
CREATE TABLE IF NOT EXISTS `annonce` (
  `ann_unique_id` int(11) NOT NULL AUTO_INCREMENT,
  `ann_titre` varchar(100) CHARACTER SET utf8 NOT NULL,
  `ann_description` text CHARACTER SET utf8 NOT NULL,
  `ann_prix` int(11) DEFAULT NULL,
  `ann_image_url` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `ann__est_valide` tinyint(1) NOT NULL,
  `ann_date_ecriture` date NOT NULL,
  `ann_date_validation` date NOT NULL,
  `utilisateur_id` int(11) DEFAULT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`ann_unique_id`),
  KEY `utilisateur_id` (`utilisateur_id`),
  KEY `categorie_id` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `annonce`
--

INSERT INTO `annonce` (`ann_unique_id`, `ann_titre`, `ann_description`, `ann_prix`, `ann_image_url`, `ann__est_valide`, `ann_date_ecriture`, `ann_date_validation`, `utilisateur_id`, `categorie_id`) VALUES
(2, 'Pantalon enfant', 'Vend pantalon enfant de marque petit bateau, taille 2ans, couleur bleu', 5, NULL, 1, '2020-08-25', '2020-08-26', NULL, 3);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_libelle` varchar(45) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`cat_id`, `cat_libelle`) VALUES
(3, 'Vêtement');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_nom` varchar(45) CHARACTER SET utf8 NOT NULL,
  `usr_prenom` varchar(45) CHARACTER SET utf8 NOT NULL,
  `usr_telephone` varchar(20) CHARACTER SET utf8 NOT NULL,
  `usr_courriel` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usr_courriel` (`usr_courriel`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `usr_nom`, `usr_prenom`, `usr_telephone`, `usr_courriel`) VALUES
(2, 'Dupont', 'Alexandre', '0678954128', 'alexandre@orange.fr');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `annonce_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`cat_id`),
  ADD CONSTRAINT `annonce_ibfk_2` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
