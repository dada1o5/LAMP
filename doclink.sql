-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost
-- Généré le :  Lun 02 Avril 2018 à 16:24
-- Version du serveur :  5.6.35
-- Version de PHP :  7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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

CREATE TABLE `allergies` (
  `id_allergie` int(11) NOT NULL,
  `nom_allergie` varchar(50) DEFAULT NULL,
  `commentaire` text,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `allergies`
--

INSERT INTO `allergies` (`id_allergie`, `nom_allergie`, `commentaire`, `id_utilisateur`) VALUES
(1, 'acariens', 'gratte beaucoup', 10),
(6, 'poils de chien', '', 10);

-- --------------------------------------------------------

--
-- Structure de la table `pathologies`
--

CREATE TABLE `pathologies` (
  `id_pathologie` int(11) NOT NULL,
  `nom_pathologie` varchar(50) DEFAULT NULL,
  `commentaire` text NOT NULL,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `pathologies`
--

INSERT INTO `pathologies` (`id_pathologie`, `nom_pathologie`, `commentaire`, `id_utilisateur`) VALUES
(1, 'mucovisidose', 'mÃ©dicaments toutes les 2 heures', 10),
(2, 'sida', '', 10);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL,
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
  `specialites` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `date`, `email`, `mdp`, `conf_mdp`, `statut`, `avatar`, `lieu_naissance`, `numero_secu`, `sexe`, `numero_cps`, `specialites`) VALUES
(1, 'Forner', 'Camille', '1996-05-14', 'cff@hotmail.fr', 'f78b64c9e0f2ea24fddce2b0d809cb2855fed1a6', 'f78b64c9e0f2ea24fddce2b0d809cb2855fed1a6', 'Patient', '1.jpg', NULL, NULL, NULL, 0, NULL),
(2, 'Lin', 'Jade', '1996-05-01', 'jl@hotmail.fr', '9f0d208cf30f99c24f65de1bc3fbe5d25526ac82', '9f0d208cf30f99c24f65de1bc3fbe5d25526ac82', 'Patient', '2.png', NULL, NULL, NULL, 0, NULL),
(3, 'Arnaud', 'Alice', '1996-11-24', 'aa@hotmail.fr', 'e0c9035898dd52fc65c41454cec9c4d2611bfb37', 'e0c9035898dd52fc65c41454cec9c4d2611bfb37', 'Docteur', NULL, NULL, NULL, NULL, 0, NULL),
(4, 'Chouf', 'Nassim', '1995-07-26', 'nc@hotmail.fr', 'e04227249fdfdd11253d2eef9789589a54d09a93', 'e04227249fdfdd11253d2eef9789589a54d09a93', 'Docteur', NULL, NULL, NULL, NULL, 0, NULL),
(5, 'Lopez', 'Eva', '1996-05-21', 'el@hotmail.fr', '4f1ea4f09db2aaafb0a92c0b9e57751121ed6647', '4f1ea4f09db2aaafb0a92c0b9e57751121ed6647', 'Patient', NULL, NULL, NULL, NULL, 0, NULL),
(6, 'Tournade', 'Alienor', '1996-01-03', 'at@hotmail.fr', '27e90dfa57c358acfaf470860f6f72c9282ce995', '27e90dfa57c358acfaf470860f6f72c9282ce995', 'Docteur', NULL, NULL, NULL, NULL, 0, NULL),
(7, 'Forner', 'Marine', '1993-10-20', 'mf@hotmail.fr', '5d838ec8c2c344259f3c8540e98ed35f35d69aac', '5d838ec8c2c344259f3c8540e98ed35f35d69aac', 'Patient', NULL, NULL, NULL, NULL, 0, NULL),
(8, 'Audrain', 'Morgane', '1996-04-26', 'ma@hotmail.fr', '1382244e1784be148fb78b24983c206ebc95928f', '1382244e1784be148fb78b24983c206ebc95928f', 'Patient', NULL, NULL, NULL, 'Femme', 0, NULL),
(9, 'Magadis', 'Aida', '1996-11-15', 'am@hotmail.fr', '96e8155732e8324ae26f64d4516eb6fe696ac84f', '96e8155732e8324ae26f64d4516eb6fe696ac84f', 'Patient', NULL, NULL, NULL, 'Femme', 0, NULL),
(10, 'Tabel', 'Eugenie', '1996-01-22', 'et@hotmail.fr', 'bc19273ea1ff6d750da7631f9aece71d49940e3f', 'a5bc1d9b2ae74e7a8a249659c13b14f5c2eac13f', 'Patient', NULL, 'Paris', 1887348785, 'Femme', 0, NULL),
(11, 'Potter', 'Harry', '1920-10-10', 'hp@hotmail.fr', 'e68b072303e1c28c4073630daeb803737a761e06', 'e68b072303e1c28c4073630daeb803737a761e06', 'Patient', NULL, NULL, NULL, 'Homme', 0, NULL),
(12, 'Hallyday', 'Johnny', '1940-10-10', 'jh@hotmail.fr', 'a454492e42fd9810e577ebee548c7e59bd883bca', 'a454492e42fd9810e577ebee548c7e59bd883bca', 'Docteur', NULL, NULL, NULL, 'Homme', 123, 'Rhumatologue, généraliste');

-- --------------------------------------------------------

--
-- Structure de la table `vaccins`
--

CREATE TABLE `vaccins` (
  `id_vaccin` int(11) NOT NULL,
  `nom_vaccin` varchar(50) DEFAULT NULL,
  `commentaire` text NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `date_vaccin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `vaccins`
--

INSERT INTO `vaccins` (`id_vaccin`, `nom_vaccin`, `commentaire`, `id_utilisateur`, `date_vaccin`) VALUES
(1, 'HÃ©patite A', 'trÃ¨s douloureux', 10, NULL),
(3, 'tuberculose', 'douloureux', 5, NULL),
(4, 'HÃ©patite B', 'douloureux', 10, NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `allergies`
--
ALTER TABLE `allergies`
  ADD PRIMARY KEY (`id_allergie`),
  ADD KEY `allergie_1` (`id_utilisateur`);

--
-- Index pour la table `pathologies`
--
ALTER TABLE `pathologies`
  ADD PRIMARY KEY (`id_pathologie`),
  ADD KEY `pathologie1` (`id_utilisateur`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- Index pour la table `vaccins`
--
ALTER TABLE `vaccins`
  ADD PRIMARY KEY (`id_vaccin`),
  ADD KEY `vaccins1` (`id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `allergies`
--
ALTER TABLE `allergies`
  MODIFY `id_allergie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `pathologies`
--
ALTER TABLE `pathologies`
  MODIFY `id_pathologie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `vaccins`
--
ALTER TABLE `vaccins`
  MODIFY `id_vaccin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `allergies`
--
ALTER TABLE `allergies`
  ADD CONSTRAINT `allergie_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Contraintes pour la table `pathologies`
--
ALTER TABLE `pathologies`
  ADD CONSTRAINT `pathologie1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Contraintes pour la table `vaccins`
--
ALTER TABLE `vaccins`
  ADD CONSTRAINT `vaccins1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
