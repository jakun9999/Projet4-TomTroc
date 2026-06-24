-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : tomtroc_db:3306
-- Généré le : jeu. 14 mai 2026 à 05:54
-- Version du serveur : 8.0.36
-- Version de PHP : 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tomtroc`
--
CREATE DATABASE IF NOT EXISTS `tomtroc` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `tomtroc`;

-- --------------------------------------------------------

--
-- Structure de la table `book`
--

CREATE TABLE `book` (
  `id` int NOT NULL,
  `title` varchar(128) NOT NULL,
  `author` varchar(128) NOT NULL,  
  `author_pseudo` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `creation_date` datetime NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `discussion`
--

CREATE TABLE `discussion` (
  `id` int NOT NULL,
  `user_1_id` int NOT NULL,
  `user_2_id` int NOT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `creation_date` datetime NOT NULL,
  `discussion_id` int NOT NULL,
  `content` text NOT NULL,
  `is_read` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `pseudo` varchar(128) NOT NULL UNIQUE,
  `email` varchar(255) NOT NULL UNIQUE,
  `photo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `discussion`
--
ALTER TABLE `discussion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_1_id` (`user_1_id`),
  ADD KEY `user_2_id` (`user_2_id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `discussion_id` (`discussion_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `book`
--
ALTER TABLE `book`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `discussion`
--
ALTER TABLE `discussion`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `discussion`
--
ALTER TABLE `discussion`
  ADD CONSTRAINT `discussion_ibfk_1` 
  FOREIGN KEY (`user_1_id`) 
  REFERENCES `user` (`id`)
  ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_ibfk_2` 
  FOREIGN KEY (`user_2_id`) 
  REFERENCES `user` (`id`)
  ON DELETE CASCADE;

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` 
  FOREIGN KEY (`user_id`) 
  REFERENCES `user` (`id`)
  ON DELETE CASCADE,
  ADD CONSTRAINT `message_ibfk_2` 
  FOREIGN KEY (`discussion_id`) 
  REFERENCES `discussion` (`id`)
  ON DELETE CASCADE;

--
-- Contraintes pour la table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` 
  FOREIGN KEY (`user_id`) 
  REFERENCES `user` (`id`)
  ON DELETE CASCADE;

--
-- Demo data upload
--
INSERT INTO `user` (`id`, `pseudo`, `email`, `photo`, `password`, `creation_date`) VALUES
(1, 'john', 'john@demo.com', '', '$argon2id$v=19$m=65536,t=4,p=1$MGNkSHF0TW5qZjhiVFlRTg$Lev74Tz1srxoXoVZTTwQPASmkctvooYkk/LneQncLyY', '2026-06-12 19:10:29'),
(2, 'stephanie', 'stephanie@demo.com', '', '$argon2id$v=19$m=65536,t=4,p=1$RHVDdnU1QTFxUmg0MDVRZA$oqbM0csyatGs7UNfiBL7m78sCvuj4C1z/vBSHKuoMnA', '2026-06-12 19:10:57'),
(3, 'demo', 'demo@demo.com', '', '$argon2id$v=19$m=65536,t=4,p=1$dktSUmZIbnNFLnNuUFhyQQ$85QHYb2M9sdjNKUYs8HVr875y4JlwJsNFZNIilzFbjA', '2026-06-14 10:07:45');

INSERT INTO `book` (`id`, `title`, `author`, `author_pseudo`, `description`, `image_url`, `status`, `creation_date`, `user_id`) VALUES
(1, 'Les règles de l’art', 'M.C Beaton', '', 'Vous aimez Agathe Raisin, vous allez adorer', '', 1, '2026-06-12 19:26:29', 2),
(2, 'L\'alchimiste', 'Paulo Coelho', '', 'L\'Alchimiste conte le voyage initiatique de Santiago, un jeune berger andalou parti à la recherche d\'un trésor enfoui près des Pyramides d’Égypte. À travers ses rencontres, il apprend à écouter son cœur, à lire les signes du destin et à accomplir sa « Légende Personnelle » pour trouver sa propre vérité.', '', 1, '2026-06-12 19:38:19', 1),
(3, 'One Punch-Man', 'Yusuke Murata', '', 'Dans le tome 27 de One-Punch Man, l\'affrontement contre l\'Association des Monstres atteint un sommet d\'intensité. Psykos fusionne avec Orochi, le Roi des Monstres, pour donner naissance à une entité d\'une puissance colossale, forçant la redoutable Tatsumaki à repousser ses limites dans un duel dantesque. En parallèle, le terrifiant Garoh continue sa mutation et brise la volonté de Super Black Brillant, terrassé par la peur face à cette force brute. Pendant ce temps, fidèle à lui-même, Saitama reste comiquement à l\'écart de la crise majeure, se retrouvant piégé et enseveli sous un éboulement au fond du labyrinthe souterrain.', '', 0, '2026-06-12 19:40:49', 1),
(4, 'J\'irai cracher sur vos tombes', 'Boris Vian', '', 'J\'irai cracher sur vos tombes de Boris Vian (écrit sous le pseudonyme de Vernon Sullivan) suit Lee Anderson, un homme noir à la peau blanche. Pour venger le lynchage de son frère, il s\'infiltre dans la jeunesse dorée et raciste d\'une petite ville américaine. Dissimulant son identité, Lee séduit, manipule puis assassine sauvagement deux riches sœurs blanches. Ce roman noir, violent et provocateur, dénonce la ségrégation et le racisme systémique de l\'Amérique des années 1940 à travers une trajectoire de vengeance destructrice qui mènera le protagoniste à sa propre perte.', '', 1, '2026-06-12 19:42:39', 1),
(5, 'Dracula', 'Bram Stocker', '', 'Dracula n\'est pas le premier roman fantastique à exploiter le thème du vampire. Il marque pourtant une étape cruciale dans la littérature fantastique et en particulier celle abordant le thème des vampires ; le succès du livre et la popularité du personnage l\'attestent encore aujourd\'hui. Plus que le sens du récit et la maîtrise du suspense de Stoker, c\'est la personnalité de son personnage principal qui fonde le mythe. Le comte Dracula, au-delà de la créature d\'épouvante aux pouvoirs surnaturels, est avant tout un être humain damné, un non-mort, et c\'est cette dimension complexe qui assure son charme.', '', 1, '2026-06-14 10:17:23', 3),
(6, 'Les Vitamines du bonheur', 'Raymond Carver', '', 'Douze nouvelles de Raymond Carver ; Douze univers clos, douze fascinantes variations sur la condition humaine.', '', 0, '2026-06-14 10:20:46', 3);

INSERT INTO `discussion` (`id`, `user_1_id`, `user_2_id`, `creation_date`) VALUES
(1, 1, 2, '2026-06-12 19:31:16'),
(2, 3, 1, '2026-06-14 10:09:46');

INSERT INTO `message` (`id`, `user_id`, `creation_date`, `discussion_id`, `content`, `is_read`) VALUES
(1, 1, '2026-06-12 19:31:16', 1, 'Bonjour, ce livre m\'intéresse beaucoup, on peut prévoir un échange ?', 1),
(2, 2, '2026-06-12 19:32:03', 1, 'Oui, quel livre me proposez-vous ?', 1),
(3, 1, '2026-06-12 19:48:08', 1, 'Si vous aimez les policiers, je peux vous conseiller le Boris Vian dont je dispose.', 0),
(4, 3, '2026-06-14 10:09:46', 2, 'Bonjour, ce livre m\'intéresse.', 1),
(5, 1, '2026-06-14 10:33:27', 2, 'Top, de mon côté les vitamines du bonheur m\'intéresse, on peut les échanger si vous le souhaitez', 0);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
