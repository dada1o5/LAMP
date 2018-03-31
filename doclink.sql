-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 31 mars 2018 à 14:56
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
  `lieu_naissance` int(11) DEFAULT NULL,
  `numero_secu` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `date`, `email`, `mdp`, `conf_mdp`, `statut`, `avatar`, `lieu_naissance`, `numero_secu`) VALUES
(1, 'Forner', 'Camille', '1996-05-14', 'cff@hotmail.fr', 'f78b64c9e0f2ea24fddce2b0d809cb2855fed1a6', 'f78b64c9e0f2ea24fddce2b0d809cb2855fed1a6', 'Patient', '1.jpg', NULL, NULL),
(2, 'Lin', 'Jade', '1996-05-01', 'jl@hotmail.fr', '9f0d208cf30f99c24f65de1bc3fbe5d25526ac82', '9f0d208cf30f99c24f65de1bc3fbe5d25526ac82', 'Patient', '2.png', NULL, NULL),
(3, 'Arnaud', 'Alice', '1996-11-24', 'aa@hotmail.fr', 'e0c9035898dd52fc65c41454cec9c4d2611bfb37', 'e0c9035898dd52fc65c41454cec9c4d2611bfb37', 'Docteur', NULL, NULL, NULL),
(4, 'Chouf', 'Nassim', '1995-07-26', 'nc@hotmail.fr', 'e04227249fdfdd11253d2eef9789589a54d09a93', 'e04227249fdfdd11253d2eef9789589a54d09a93', 'Docteur', NULL, NULL, NULL),
(5, 'Lopez', 'Eva', '1996-05-21', 'el@hotmail.fr', '4f1ea4f09db2aaafb0a92c0b9e57751121ed6647', '4f1ea4f09db2aaafb0a92c0b9e57751121ed6647', 'Patient', NULL, NULL, NULL),
(6, 'Tournade', 'Alienor', '1996-01-03', 'at@hotmail.fr', '27e90dfa57c358acfaf470860f6f72c9282ce995', '27e90dfa57c358acfaf470860f6f72c9282ce995', 'Docteur', NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
