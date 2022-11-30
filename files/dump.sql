-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 30 nov. 2022 à 19:11
-- Version du serveur : 10.9.4-MariaDB-log
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tran`
--

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE `compte` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`id`, `login`, `password`, `email`, `nom`, `prenom`, `role`) VALUES
(1, '2001458436', '$2y$10$7xldYUDD6EVmjAPjg/UzBOYl/cjRSoYckiHP5ji7o0aojp/9EKNJG', 'admin@bank.eu', 'Admin', 'nistrateur', 'ADMIN'),
(2, '4526452419', '$2y$10$9y16F6Qmt5.uR8MY8k2jNOTOhw77AdyRzL9zWs3Qj1dbBNRyYUGM2', 'PO@cap-gemi.ni', 'Product', 'Owner', 'PO'),
(3, '8755269857', '$2y$10$mcEyY9CCt0US1mOwrxXFAOCjr8AU7JmLLlaVbZgD3NbBMFQ.PVzm.', 'pastille-vomitive@mc.do', 'Ronald', 'McDonald', 'CLIENT'),
(4, '7745511214', '$2y$10$3iH9qViwGHBjr8V.QnATsOEIWaivRukzVOjvaypvSzf00FUp/r3Lq', 'leroy-sane@arnaq.ue', 'Leroy', 'Laura', 'CLIENT');

-- --------------------------------------------------------

--
-- Structure de la table `controle`
--

CREATE TABLE `controle` (
  `id` int(11) NOT NULL,
  `SIREN` char(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

CREATE TABLE `entreprise` (
  `SIREN` char(9) NOT NULL,
  `Raison_sociale` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `impaye`
--

CREATE TABLE `impaye` (
  `numero_dossier_impaye` varchar(50) NOT NULL,
  `code` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `motifs_impayes`
--

CREATE TABLE `motifs_impayes` (
  `code` varchar(2) NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `role` varchar(50) NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`role`, `libelle`) VALUES
('ADMIN', 'Administrateur'),
('CLIENT', 'Client'),
('PO', 'Product Owner');

-- --------------------------------------------------------

--
-- Structure de la table `transaction`
--

CREATE TABLE `transaction` (
  `numero_transaction` int(11) NOT NULL,
  `devise` char(3) NOT NULL,
  `montant` int(11) NOT NULL,
  `date_transaction` date NOT NULL,
  `sens` char(1) NOT NULL,
  `numero_carte` char(16) NOT NULL,
  `numero_dossier_impaye` varchar(50) DEFAULT NULL,
  `SIREN` char(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role` (`role`);

--
-- Index pour la table `controle`
--
ALTER TABLE `controle`
  ADD PRIMARY KEY (`id`,`SIREN`),
  ADD KEY `SIREN` (`SIREN`);

--
-- Index pour la table `entreprise`
--
ALTER TABLE `entreprise`
  ADD PRIMARY KEY (`SIREN`);

--
-- Index pour la table `impaye`
--
ALTER TABLE `impaye`
  ADD PRIMARY KEY (`numero_dossier_impaye`),
  ADD KEY `code` (`code`);

--
-- Index pour la table `motifs_impayes`
--
ALTER TABLE `motifs_impayes`
  ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `libelle` (`libelle`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role`),
  ADD UNIQUE KEY `libelle` (`libelle`);

--
-- Index pour la table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`numero_transaction`),
  ADD KEY `numero_dossier_impaye` (`numero_dossier_impaye`),
  ADD KEY `SIREN` (`SIREN`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `compte`
--
ALTER TABLE `compte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `compte`
--
ALTER TABLE `compte`
  ADD CONSTRAINT `compte_ibfk_1` FOREIGN KEY (`role`) REFERENCES `role` (`role`);

--
-- Contraintes pour la table `controle`
--
ALTER TABLE `controle`
  ADD CONSTRAINT `controle_ibfk_2` FOREIGN KEY (`SIREN`) REFERENCES `entreprise` (`SIREN`),
  ADD CONSTRAINT `controle_ibfk_3` FOREIGN KEY (`id`) REFERENCES `compte` (`id`);

--
-- Contraintes pour la table `impaye`
--
ALTER TABLE `impaye`
  ADD CONSTRAINT `impaye_ibfk_1` FOREIGN KEY (`code`) REFERENCES `motifs_impayes` (`code`);

--
-- Contraintes pour la table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`numero_dossier_impaye`) REFERENCES `impaye` (`numero_dossier_impaye`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`SIREN`) REFERENCES `entreprise` (`SIREN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
