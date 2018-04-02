-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  lun. 02 avr. 2018 à 22:55
-- Version du serveur :  10.1.31-MariaDB
-- Version de PHP :  7.2.3

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

CREATE TABLE `allergies` (
  `id_allergie` int(11) NOT NULL,
  `nom_allergie` varchar(50) DEFAULT NULL,
  `commentaire` text,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `analyse` (
  `commentaire` char(255) NOT NULL,
  `id` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `follow` (
  `id_abonnement` int(11) NOT NULL,
  `id_abonne` int(11) NOT NULL,
  `id_suivi` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `graphique` (
  `id` int(11) NOT NULL,
  `col1` varchar(255) NOT NULL,
  `col2` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `graphique`
--

INSERT INTO `graphique` (`id`, `col1`, `col2`, `id_utilisateur`) VALUES
(1, '345', '0000-00-00 00:00:00', 15),
(2, '300', '0000-00-00 00:00:00', 0),
(3, '200', '0000-00-00 00:00:00', 0),
(4, '345', '0000-00-00 00:00:00', 15),
(5, '356', '0000-00-00 00:00:00', 15),
(6, '356', '0000-00-00 00:00:00', 15);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id_message` int(11) NOT NULL,
  `id_exp` int(11) NOT NULL,
  `id_dest` int(11) NOT NULL,
  `message` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `ordonnances` (
  `id_ordonnance` int(11) NOT NULL,
  `nom_ordonnance` varchar(50) DEFAULT NULL,
  `commentaire` text NOT NULL,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `pathologies` (
  `id_pathologie` int(11) NOT NULL,
  `nom_pathologie` varchar(50) DEFAULT NULL,
  `commentaire` text NOT NULL,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `sexe` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `date`, `email`, `mdp`, `conf_mdp`, `statut`, `avatar`, `lieu_naissance`, `numero_secu`, `sexe`) VALUES
(1, 'Forner', 'Camille', '1996-05-14', 'cff@hotmail.fr', 'f78b64c9e0f2ea24fddce2b0d809cb2855fed1a6', 'f78b64c9e0f2ea24fddce2b0d809cb2855fed1a6', 'Patient', '1.jpg', NULL, NULL, NULL),
(2, 'Lin', 'Jade', '1996-05-01', 'jl@hotmail.fr', '9f0d208cf30f99c24f65de1bc3fbe5d25526ac82', '9f0d208cf30f99c24f65de1bc3fbe5d25526ac82', 'Patient', '2.png', NULL, NULL, NULL),
(3, 'Arnaud', 'Alice', '1996-11-24', 'aa@hotmail.fr', 'e0c9035898dd52fc65c41454cec9c4d2611bfb37', 'e0c9035898dd52fc65c41454cec9c4d2611bfb37', 'Docteur', NULL, NULL, NULL, NULL),
(4, 'Chouf', 'Nassim', '1995-07-26', 'nc@hotmail.fr', 'e04227249fdfdd11253d2eef9789589a54d09a93', 'e04227249fdfdd11253d2eef9789589a54d09a93', 'Docteur', NULL, NULL, NULL, NULL),
(5, 'Lopez', 'Eva', '1996-05-21', 'el@hotmail.fr', '4f1ea4f09db2aaafb0a92c0b9e57751121ed6647', '4f1ea4f09db2aaafb0a92c0b9e57751121ed6647', 'Patient', NULL, NULL, NULL, NULL),
(6, 'Tournade', 'Alienor', '1996-01-03', 'at@hotmail.fr', '27e90dfa57c358acfaf470860f6f72c9282ce995', '27e90dfa57c358acfaf470860f6f72c9282ce995', 'Docteur', NULL, NULL, NULL, NULL),
(7, 'Forner', 'Marine', '1993-10-20', 'mf@hotmail.fr', '5d838ec8c2c344259f3c8540e98ed35f35d69aac', '5d838ec8c2c344259f3c8540e98ed35f35d69aac', 'Patient', NULL, NULL, NULL, NULL),
(8, 'Audrain', 'Morgane', '1996-04-26', 'ma@hotmail.fr', '1382244e1784be148fb78b24983c206ebc95928f', '1382244e1784be148fb78b24983c206ebc95928f', 'Patient', NULL, NULL, NULL, 'Femme'),
(9, 'Magadis', 'Aida', '1996-11-15', 'am@hotmail.fr', '96e8155732e8324ae26f64d4516eb6fe696ac84f', '96e8155732e8324ae26f64d4516eb6fe696ac84f', 'Patient', NULL, NULL, NULL, 'Femme'),
(10, 'Tabel', 'Eugenie', '1996-01-22', 'et@hotmail.fr', 'bc19273ea1ff6d750da7631f9aece71d49940e3f', 'a5bc1d9b2ae74e7a8a249659c13b14f5c2eac13f', 'Patient', NULL, 'Paris', 1887348785, 'Femme'),
(11, 'Potter', 'Harry', '1920-10-10', 'hp@hotmail.fr', 'e68b072303e1c28c4073630daeb803737a761e06', 'e68b072303e1c28c4073630daeb803737a761e06', 'Patient', NULL, NULL, NULL, 'Homme'),
(12, 'Hallyday', 'Johnny', '1940-10-10', 'jh@hotmail.fr', 'a454492e42fd9810e577ebee548c7e59bd883bca', 'a454492e42fd9810e577ebee548c7e59bd883bca', 'Docteur', NULL, NULL, NULL, 'Homme'),
(13, 'THEBAUD', 'David', '1996-10-15', 'da.thebaud@outlook.fr', '356a192b7913b04c54574d18c28d46e6395428ab', '356a192b7913b04c54574d18c28d46e6395428ab', 'Patient', NULL, NULL, NULL, NULL),
(14, 'audri', 'momo', '1996-09-26', 'ma@gmail.com', '1382244e1784be148fb78b24983c206ebc95928f', '1382244e1784be148fb78b24983c206ebc95928f', 'Docteur', NULL, NULL, NULL, 'Femme'),
(15, 'Audrain', 'Morgane', '1996-09-26', 'morgane.audrain@edu.ece.fr', 'd08cd6d1a8299aa4a1ff8d4f7223289a81f8ed83', 'd08cd6d1a8299aa4a1ff8d4f7223289a81f8ed83', 'Patient', NULL, NULL, NULL, 'Femme');

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
-- Déchargement des données de la table `vaccins`
--

INSERT INTO `vaccins` (`id_vaccin`, `nom_vaccin`, `commentaire`, `id_utilisateur`, `date_vaccin`) VALUES
(1, 'HÃ©patite A', 'trÃ¨s douloureux', 10, NULL),
(3, 'tuberculose', 'douloureux', 5, NULL),
(4, 'HÃ©patite B', 'douloureux', 10, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `allergies`
--
ALTER TABLE `allergies`
  ADD PRIMARY KEY (`id_allergie`),
  ADD KEY `allergie_1` (`id_utilisateur`);

--
-- Index pour la table `analyse`
--
ALTER TABLE `analyse`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`id_abonnement`);

--
-- Index pour la table `graphique`
--
ALTER TABLE `graphique`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id_message`);

--
-- Index pour la table `ordonnances`
--
ALTER TABLE `ordonnances`
  ADD PRIMARY KEY (`id_ordonnance`),
  ADD KEY `ordonnance_1` (`id_utilisateur`);

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
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `allergies`
--
ALTER TABLE `allergies`
  MODIFY `id_allergie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `analyse`
--
ALTER TABLE `analyse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `follow`
--
ALTER TABLE `follow`
  MODIFY `id_abonnement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `graphique`
--
ALTER TABLE `graphique`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `ordonnances`
--
ALTER TABLE `ordonnances`
  MODIFY `id_ordonnance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `pathologies`
--
ALTER TABLE `pathologies`
  MODIFY `id_pathologie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `vaccins`
--
ALTER TABLE `vaccins`
  MODIFY `id_vaccin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
