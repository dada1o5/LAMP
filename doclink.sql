-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 02 avr. 2018 à 20:46
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `doclink`
--

-- --------------------------------------------------------

--
-- Structure de la table `allergies`
--

DROP TABLE IF EXISTS `allergies`;
CREATE TABLE IF NOT EXISTS `allergies` (
  `id_allergie` int(11) NOT NULL AUTO_INCREMENT,
  `nom_allergie` varchar(50) DEFAULT NULL,
  `commentaire` text,
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id_allergie`),
  KEY `allergie_1` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `allergies`
--

INSERT INTO `allergies` (`id_allergie`, `nom_allergie`, `commentaire`, `id_utilisateur`) VALUES
(1, 'acariens', 'gratte beaucoup', 10),
(6, 'poils de chien', '', 10),
(7, 'pollen', '', 13);

-- --------------------------------------------------------

--
-- Structure de la table `analyse`
--

DROP TABLE IF EXISTS `analyse`;
CREATE TABLE IF NOT EXISTS `analyse` (
  `commentaire` char(255) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `analyse`
--

INSERT INTO `analyse` (`commentaire`, `id`, `id_utilisateur`) VALUES
('test', 1, 0),
('jzed', 2, 0),
('', 3, 0),
('', 4, 0),
('lk,f\r\n', 5, 0),
('', 6, 14),
('opkdez\r\n\r\n', 7, 14);

-- --------------------------------------------------------

--
-- Structure de la table `follow`
--

DROP TABLE IF EXISTS `follow`;
CREATE TABLE IF NOT EXISTS `follow` (
  `id_abonnement` int(11) NOT NULL AUTO_INCREMENT,
  `id_abonne` int(11) NOT NULL,
  `id_suivi` int(11) NOT NULL,
  PRIMARY KEY (`id_abonnement`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `follow`
--

INSERT INTO `follow` (`id_abonnement`, `id_abonne`, `id_suivi`) VALUES
(1, 7, 4),
(2, 9, 12);

-- --------------------------------------------------------

--
-- Structure de la table `graphique`
--

DROP TABLE IF EXISTS `graphique`;
CREATE TABLE IF NOT EXISTS `graphique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `col1` varchar(255) NOT NULL,
  `col2` date NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `graphique`
--

INSERT INTO `graphique` (`id`, `col1`, `col2`, `id_utilisateur`) VALUES
(1, '345', '0000-00-00', 15),
(2, '300', '0000-00-00', 0),
(3, '200', '0000-00-00', 0),
(4, '345', '0000-00-00', 15),
(5, '356', '0000-00-00', 15),
(6, '356', '0000-00-00', 15);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `id_exp` int(11) NOT NULL,
  `id_dest` int(11) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id_message`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id_message`, `id_exp`, `id_dest`, `message`) VALUES
(1, 9, 12, 'Bonjour ! Serait-ce possible de prendre RDV pour demain ?'),
(2, 12, 9, 'Bien sur ! A demain !');

-- --------------------------------------------------------

--
-- Structure de la table `ordonnances`
--

DROP TABLE IF EXISTS `ordonnances`;
CREATE TABLE IF NOT EXISTS `ordonnances` (
  `id_ordonnance` int(11) NOT NULL AUTO_INCREMENT,
  `nom_ordonnance` varchar(50) DEFAULT NULL,
  `commentaire` text NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id_ordonnance`),
  KEY `ordonnance_1` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ordonnances`
--

INSERT INTO `ordonnances` (`id_ordonnance`, `nom_ordonnance`, `commentaire`, `id_utilisateur`) VALUES
(19, 'Doliprane', '1 boite', 13),
(20, 'paracÃ©tamol', '2', 13);

-- --------------------------------------------------------

--
-- Structure de la table `pathologies`
--

DROP TABLE IF EXISTS `pathologies`;
CREATE TABLE IF NOT EXISTS `pathologies` (
  `id_pathologie` int(11) NOT NULL AUTO_INCREMENT,
  `nom_pathologie` varchar(50) DEFAULT NULL,
  `commentaire` text NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id_pathologie`),
  KEY `pathologie1` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `pathologies`
--

INSERT INTO `pathologies` (`id_pathologie`, `nom_pathologie`, `commentaire`, `id_utilisateur`) VALUES
(1, 'mucovisidose', 'mÃ©dicaments toutes les 2 heures', 10),
(2, 'sida', '', 10);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `mdp` varchar(60) NOT NULL,
  `conf_mdp` varchar(60) NOT NULL,
  `statut` varchar(15) NOT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `lieu_naissance` varchar(20) DEFAULT NULL,
  `numero_secu` int(11) DEFAULT NULL,
  `sexe` varchar(20) DEFAULT NULL,
  `numero_cps` int(11) DEFAULT NULL,
  `specialites` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `date`, `email`, `mdp`, `conf_mdp`, `statut`, `avatar`, `lieu_naissance`, `numero_secu`, `sexe`, `numero_cps`, `specialites`) VALUES
(5, 'Lopez', 'Eva', '1996-05-21', 'el@hotmail.fr', '4f1ea4f09db2aaafb0a92c0b9e57751121ed6647', '4f1ea4f09db2aaafb0a92c0b9e57751121ed6647', 'Patient', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Audrain', 'Morgane', '1996-04-26', 'ma@hotmail.fr', '1382244e1784be148fb78b24983c206ebc95928f', '1382244e1784be148fb78b24983c206ebc95928f', 'Patient', NULL, NULL, NULL, 'Femme', NULL, NULL),
(9, 'Magadis', 'Aida', '1996-11-15', 'am@hotmail.fr', '96e8155732e8324ae26f64d4516eb6fe696ac84f', '96e8155732e8324ae26f64d4516eb6fe696ac84f', 'Patient', NULL, NULL, NULL, 'Femme', NULL, NULL),
(10, 'Tabel', 'Eugenie', '1996-01-22', 'et@hotmail.fr', 'bc19273ea1ff6d750da7631f9aece71d49940e3f', 'a5bc1d9b2ae74e7a8a249659c13b14f5c2eac13f', 'Patient', NULL, 'Paris', 1887348785, 'Femme', NULL, NULL),
(11, 'Potter', 'Harry', '1920-10-10', 'hp@hotmail.fr', 'e68b072303e1c28c4073630daeb803737a761e06', 'e68b072303e1c28c4073630daeb803737a761e06', 'Patient', NULL, NULL, NULL, 'Homme', NULL, NULL),
(12, 'Hallyday', 'Johnny', '1940-10-10', 'jh@hotmail.fr', 'a454492e42fd9810e577ebee548c7e59bd883bca', 'a454492e42fd9810e577ebee548c7e59bd883bca', 'Docteur', NULL, NULL, NULL, 'Homme', NULL, NULL),
(14, 'audri', 'momo', '1996-09-26', 'ma@gmail.com', '1382244e1784be148fb78b24983c206ebc95928f', '1382244e1784be148fb78b24983c206ebc95928f', 'Docteur', NULL, NULL, NULL, 'Femme', NULL, NULL),
(15, 'Audrain', 'Morgane', '1996-09-26', 'morgane.audrain@edu.ece.fr', 'd08cd6d1a8299aa4a1ff8d4f7223289a81f8ed83', 'd08cd6d1a8299aa4a1ff8d4f7223289a81f8ed83', 'Patient', NULL, NULL, NULL, 'Femme', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `vaccins`
--

DROP TABLE IF EXISTS `vaccins`;
CREATE TABLE IF NOT EXISTS `vaccins` (
  `id_vaccin` int(11) NOT NULL AUTO_INCREMENT,
  `nom_vaccin` varchar(50) DEFAULT NULL,
  `commentaire` text NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `date_vaccin` date DEFAULT NULL,
  PRIMARY KEY (`id_vaccin`),
  KEY `vaccins1` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `vaccins`
--

INSERT INTO `vaccins` (`id_vaccin`, `nom_vaccin`, `commentaire`, `id_utilisateur`, `date_vaccin`) VALUES
(1, 'HÃ©patite A', 'trÃ¨s douloureux', 10, NULL),
(3, 'tuberculose', 'douloureux', 5, NULL),
(4, 'HÃ©patite B', 'douloureux', 10, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `vaccins`
--
ALTER TABLE `vaccins`
  ADD CONSTRAINT `vaccins1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
