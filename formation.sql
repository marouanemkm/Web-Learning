-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 14 mars 2021 à 22:08
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
-- Base de données :  `formation`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cours_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `commentaire` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cours_id` (`cours_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `cours_id`, `user_id`, `commentaire`) VALUES
(60, 17, 23, 'test de commentaire');

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

DROP TABLE IF EXISTS `cours`;
CREATE TABLE IF NOT EXISTS `cours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` longtext NOT NULL,
  `video` text NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `vues` int(11) NOT NULL DEFAULT 0,
  `commentaires` int(11) NOT NULL DEFAULT 0,
  `rank` int(11) NOT NULL DEFAULT 0,
  `note` decimal(2,1) NOT NULL DEFAULT 0.0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id`, `name`, `description`, `video`, `likes`, `vues`, `commentaires`, `rank`, `note`) VALUES
(17, 'Machine Learning', 'Cours de machine learning', 'https://www.youtube.com/embed/BLZo9QLt0UY', 1, 2, 1, 0, '1.0');

-- --------------------------------------------------------

--
-- Structure de la table `liked`
--

DROP TABLE IF EXISTS `liked`;
CREATE TABLE IF NOT EXISTS `liked` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_cours` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_cours` (`id_cours`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `liked`
--

INSERT INTO `liked` (`id`, `id_user`, `id_cours`) VALUES
(17, 23, 17);

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

DROP TABLE IF EXISTS `notes`;
CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_cours` int(11) NOT NULL,
  `note` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_cours` (`id_cours`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `notes`
--

INSERT INTO `notes` (`id`, `id_user`, `id_cours`, `note`) VALUES
(18, 23, 17, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `admin` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `pass`, `admin`) VALUES
(1, 'marouane@marouane.fr', 'marouane', 'marouane', 0),
(3, 'marouane@marou.fr', 'ma', 'ma', 0),
(4, 'marouane@gmail.com', 'marouane', 'marouane', 0),
(5, 'marouane@test.Fr', 'test', 'test', 0),
(6, 'ma@ma.fr', 'fr', 'fr', 0),
(7, 'ma@test.fr', 'marouane', 'ma', 0),
(8, 'test@test.fr', 'test', 'test', 0),
(9, 'test@te.fr', 'test', 'test', 0),
(10, 'te@test.fr', 'test', 'test', 0),
(11, 'ayoub@ayoub.fr', 'ayoub', 'ayoub', 0),
(12, 'ayoub@ayoub.fr', 'ayoub', 'ayoub', 0),
(13, 'ayoub@ayoub.fr', 'ayoub', 'ayoub', 0),
(14, 'azerty@az.fr', 'azerty', 'azerty', 0),
(15, 'az@az.fr', 'az', 'az', 0),
(16, 'az@az.fr', 'az', 'az', 0),
(17, 'az@az.fr', 'az', 'az', 0),
(18, 'az@az.fr', 'az', 'az', 0),
(19, 'az@az.fr', 'az', 'az', 0),
(20, 'az@az.fr', 'az', 'az', 0),
(21, 'jo@jo.fr', 'jo', 'jo', 0),
(22, 'mar@mar.fr', 'marouane', 'mar', 0),
(23, 'admin@admin.fr', 'admin', 'admin', 1),
(24, 'ayoub@ayoub.fr', 'ayoub', 'ayoub', 0),
(25, 'a@a.fr', 'a', 'azerty', 0),
(26, 'marouane@live.fr', 'Marouane', 'marouane', 0),
(27, 'live@live.fr', 'live', 'live', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_1` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commentaires_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `liked`
--
ALTER TABLE `liked`
  ADD CONSTRAINT `liked_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `liked_ibfk_2` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
