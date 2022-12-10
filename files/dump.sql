-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  sqletud.u-pem.fr
-- Généré le :  Sam 10 Décembre 2022 à 10:14
-- Version du serveur :  5.7.30-log
-- Version de PHP :  7.0.33-0+deb9u7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `leon.edmee_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `b__compte`
--

CREATE TABLE `b__compte` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `b__compte`
--

INSERT INTO `b__compte` (`id`, `login`, `password`, `email`, `nom`, `prenom`, `role`) VALUES
(1, '2001458436', '$2y$10$7xldYUDD6EVmjAPjg/UzBOYl/cjRSoYckiHP5ji7o0aojp/9EKNJG', 'admin@bank.eu', 'Admin', 'nistrateur', 'ADMIN'),
(2, '4526452419', '$2y$10$9y16F6Qmt5.uR8MY8k2jNOTOhw77AdyRzL9zWs3Qj1dbBNRyYUGM2', 'PO@cap-gemi.ni', 'Product', 'Owner', 'PO'),
(3, '8755269857', '$2y$10$mcEyY9CCt0US1mOwrxXFAOCjr8AU7JmLLlaVbZgD3NbBMFQ.PVzm.', 'pastille-vomitive@mc.do', 'Ronald', 'McDonald', 'CLIENT'),
(4, '7745511214', '$2y$10$3iH9qViwGHBjr8V.QnATsOEIWaivRukzVOjvaypvSzf00FUp/r3Lq', 'leroy-sane@arnaq.ue', 'Leroy', 'Merlin', 'CLIENT');

-- --------------------------------------------------------

--
-- Structure de la table `b__controle`
--

CREATE TABLE `b__controle` (
  `id` int(11) NOT NULL,
  `SIREN` char(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `b__entreprise`
--

CREATE TABLE `b__entreprise` (
  `SIREN` char(9) NOT NULL,
  `Raison_sociale` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `b__entreprise`
--

INSERT INTO `b__entreprise` (`SIREN`, `Raison_sociale`) VALUES
('111111111', 'Carrefour Banque'),
('111111112', 'Pivoteau SARL');

-- --------------------------------------------------------

--
-- Structure de la table `b__impaye`
--

CREATE TABLE `b__impaye` (
  `numero_dossier_impaye` varchar(50) NOT NULL,
  `code` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `b__motifs_impayes`
--

CREATE TABLE `b__motifs_impayes` (
  `code` varchar(2) NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `b__role`
--

CREATE TABLE `b__role` (
  `role` varchar(50) NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `b__role`
--

INSERT INTO `b__role` (`role`, `libelle`) VALUES
('ADMIN', 'Administrateur'),
('CLIENT', 'Client'),
('PO', 'Product Owner');

-- --------------------------------------------------------

--
-- Structure de la table `b__transaction`
--

CREATE TABLE `b__transaction` (
  `numero_transaction` int(11) NOT NULL,
  `devise` char(3) NOT NULL,
  `montant` int(11) NOT NULL,
  `date_transaction` date NOT NULL,
  `sens` char(1) NOT NULL,
  `numero_carte` char(16) NOT NULL,
  `numero_dossier_impaye` varchar(50) DEFAULT NULL,
  `SIREN` char(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `b__transaction`
--

INSERT INTO `b__transaction` (`numero_transaction`, `devise`, `montant`, `date_transaction`, `sens`, `numero_carte`, `numero_dossier_impaye`, `SIREN`) VALUES
(1, 'EUR', 10, '2022-12-08', '-', '1111111111111111', NULL, '111111111');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `b__compte`
--
ALTER TABLE `b__compte`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role` (`role`);

--
-- Index pour la table `b__controle`
--
ALTER TABLE `b__controle`
  ADD PRIMARY KEY (`id`,`SIREN`),
  ADD KEY `SIREN` (`SIREN`);

--
-- Index pour la table `b__entreprise`
--
ALTER TABLE `b__entreprise`
  ADD PRIMARY KEY (`SIREN`);

--
-- Index pour la table `b__impaye`
--
ALTER TABLE `b__impaye`
  ADD PRIMARY KEY (`numero_dossier_impaye`),
  ADD KEY `code` (`code`);

--
-- Index pour la table `b__motifs_impayes`
--
ALTER TABLE `b__motifs_impayes`
  ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `libelle` (`libelle`);

--
-- Index pour la table `b__role`
--
ALTER TABLE `b__role`
  ADD PRIMARY KEY (`role`),
  ADD UNIQUE KEY `libelle` (`libelle`);

--
-- Index pour la table `b__transaction`
--
ALTER TABLE `b__transaction`
  ADD PRIMARY KEY (`numero_transaction`),
  ADD KEY `numero_dossier_impaye` (`numero_dossier_impaye`),
  ADD KEY `SIREN` (`SIREN`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `b__compte`
--
ALTER TABLE `b__compte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `b__compte`
--
ALTER TABLE `b__compte`
  ADD CONSTRAINT `b__compte_ibfk_1` FOREIGN KEY (`role`) REFERENCES `b__role` (`role`);

--
-- Contraintes pour la table `b__controle`
--
ALTER TABLE `b__controle`
  ADD CONSTRAINT `b__controle_ibfk_2` FOREIGN KEY (`SIREN`) REFERENCES `b__entreprise` (`SIREN`),
  ADD CONSTRAINT `b__controle_ibfk_3` FOREIGN KEY (`id`) REFERENCES `b__compte` (`id`);

--
-- Contraintes pour la table `b__impaye`
--
ALTER TABLE `b__impaye`
  ADD CONSTRAINT `b__impaye_ibfk_1` FOREIGN KEY (`code`) REFERENCES `b__motifs_impayes` (`code`);

--
-- Contraintes pour la table `b__transaction`
--
ALTER TABLE `b__transaction`
  ADD CONSTRAINT `b__transaction_ibfk_1` FOREIGN KEY (`numero_dossier_impaye`) REFERENCES `b__impaye` (`numero_dossier_impaye`),
  ADD CONSTRAINT `b__transaction_ibfk_2` FOREIGN KEY (`SIREN`) REFERENCES `b__entreprise` (`SIREN`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
