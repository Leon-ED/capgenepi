-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  sqletud.u-pem.fr
-- Généré le :  Mer 14 Décembre 2022 à 16:07
-- Version du serveur :  5.7.30-log
-- Version de PHP :  7.0.33-0+deb9u7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;



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
  `role` varchar(50) DEFAULT 'CLIENT'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `b__compte`
--

INSERT INTO `b__compte` (`id`, `login`, `password`, `email`, `nom`, `prenom`, `role`) VALUES
(1, '2001458436', '$2y$10$7xldYUDD6EVmjAPjg/UzBOYl/cjRSoYckiHP5ji7o0aojp/9EKNJG', 'admin@bank.eu', 'Admin', 'nistrateur', 'ADMIN'),
(2, '4526452419', '$2y$10$9y16F6Qmt5.uR8MY8k2jNOTOhw77AdyRzL9zWs3Qj1dbBNRyYUGM2', 'PO@cap-gemi.ni', 'Product', 'Owner', 'PO'),
(3, '8755269857', '$2y$10$mcEyY9CCt0US1mOwrxXFAOCjr8AU7JmLLlaVbZgD3NbBMFQ.PVzm.', 'pastille-vomitive@mc.do', 'Ronald', 'McDonald', 'CLIENT'),
(4, '7745511214', '$2y$10$3iH9qViwGHBjr8V.QnATsOEIWaivRukzVOjvaypvSzf00FUp/r3Lq', 'leroy-sane@arnaq.ue', 'Leroy', 'Merlin', 'CLIENT'),
(9, '123456789', '$2y$10$Oam.y9mB735mO2u8byzuWOBrKJ3vkqCGjFBaRodC915waTSVedPLa', 'eee@ee.fr', '123456789', '123456789', 'CLIENT'),
(10, '789456123', '$2y$10$yl.4Bi1DAVhNO6ZN8lNqgO/d4PV3/XCQDe1GfLRD/Uo9nCEAUfs/a', 'ee.aaa@ee.fr', '789456123', '789456123', 'CLIENT'),
(11, 'eeeeeeeee', '$2y$10$UbgMmvRi0a9tZjiKMTs.0u6NSQMkB9cnY2NqlwBd1hlMtkJo1wDzi', 'eee@a.fr', 'eeeeeeeee', 'eeeeeeeee', 'CLIENT'),
(13, 'asxcderfg', '$2y$10$lWsMuwmXGvXF2jXSp9kJnexHqz0OVpEyKJy7CJTAWWbSO07/3f8qK', 'a@b.c', 'asxcderfg', 'asxcderfg', 'CLIENT'),
(14, '/////////', '$2y$10$At3sfmIMmoSYYpbCM.5WW.fAt/3MhOrYFAzwnqb6ljDC3rIYDzcX6', 'r@r.r', '/////////', '/////////', 'CLIENT'),
(15, '////////p', '$2y$10$DDg.SL390JeXiOzpNQZPjOXKKqJAJWrm1i.6N0zcKNYdReOnl1/Y2', '////////p', '////////p', '////////p', 'CLIENT'),
(16, 'ACTION_LOGEMENT', '$2y$10$Fd72.5uKyzQ2QY..qzGiYeffqrkJmp.EChD04erwkhWR/MeCc48.q', 'contact@actionlogement.org', 'ACTION', 'LOGEMENT', 'CLIENT'),
(17, 'ACTION_LOGEMENTS', '$2y$10$NqIKWsXrqVwLD2sUPeSYU.PePKNhKq.uvU3Y.pME45pxExpL3fuN2', 'contact@actionlogement.orge', 'ACTION', 'LOGEMENT', 'CLIENT'),
(18, 'ACTION_LOGEMENTSS', '$2y$10$t1/93o6UYvL3RPl7hY7cc.PyavHB9KjLANLQE0486/rp7TEg5KitC', 'conEtact@actionlogement.orge', 'ACTION', 'LOGEMENT', 'CLIENT'),
(19, '789987789', '$2y$10$wJn5Xu3eFx3OliByMSXcHeL/iZuhsAhcV5o3F7g4baZNwVekPWKxW', '789987789@ee.fr', '789987789', '789987789', 'CLIENT'),
(20, '789987781', '$2y$10$Itm3Yi7mR8aGuyzKyQk5o.8COv6kPvBcgueLuujlQL1Uk8eKXaK.G', '789987789@ee.fre', '789987789', '789987789', 'CLIENT'),
(21, '789987777', '$2y$10$vEeJ1g38yxlQHOqwepWYvOY157uJaORX9b41lyRQz0WvgHYE5rix6', 'ee.ee@78.fr', '789987777', '789987777', 'CLIENT'),
(22, '789987774', '$2y$10$sSMlA41RWrxJSl8r74RxIub/qlZrfaieChvI1d9kvDfa5.NPVJOiC', 'ee.ee@78.fre', '789987774', '789987774', 'CLIENT'),
(23, '189987774', '$2y$10$tnng50EIbpQQqnKfLNg1E.uT.7J2KKeZ8AQ7YjXvAX6g1nA9OBcaO', 'ee.ee@78.free', '189987774', '189987774', 'CLIENT'),
(24, '            $(\"form\").trigger(\"reset\");', '$2y$10$EMxmxHuQNScpgp1KlWjeYeW3pxLga.ruTVxqvoGD6jcGwp/21Tv8.', 'e@ee.fr', '            $(\"form\").trigger(\"reset\");', '            $(\"form\").trigger(\"reset\");', 'CLIENT'),
(25, 'tonton', '$2y$10$o48rqynC/0ozEgywIildbuO9c32EIHKVVz6r4pN5R4ZIggO0qM6fO', 'tonton@ee.fr', 'tonton', 'tonton', 'CLIENT'),
(26, 'tata', '$2y$10$VGzNUEiHJJYXRAAISR7sPe8m8u5XoPe8c/YhVeJyQNI33vmKegK2C', 'tata@ee.fr', 'tata', 'tata', 'CLIENT'),
(27, 'tatat', '$2y$10$udMdxsZvM3ssgMNSuPmTeOJqKtA8ZGufSMsviBFWaUWuJEg8NiZ4W', 'tatat@pooe.fr', 'tatat', 'tatat', 'CLIENT'),
(28, 'tatatp', '$2y$10$l.eqcD3undI9.L91O2z4JOkkxpqgLZgUBITq7XnhM1kqY0Ogxtb06', 'tatatp@xn--eeee-uv7a.fr', 'tatatp', 'tatatp', 'CLIENT'),
(29, '987', '$2y$10$D8VHAk1GSkDnl7sLWWUKzOAahvNbTbhYFnH2lAFJzgXWalahik8AW', '987@ae.fr', '987', '987', 'CLIENT');

-- --------------------------------------------------------

--
-- Structure de la table `b__controle`
--

CREATE TABLE `b__controle` (
  `id` int(11) NOT NULL,
  `SIREN` char(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `b__controle`
--

INSERT INTO `b__controle` (`id`, `SIREN`) VALUES
(14, '/////////'),
(15, '////////p'),
(9, '123456789'),
(23, '189987774'),
(10, '789456123'),
(22, '789987774'),
(21, '789987777'),
(20, '789987781'),
(19, '789987789'),
(18, '824541144'),
(17, '824541147'),
(16, '824541148'),
(29, '987'),
(13, 'asxcderfg'),
(11, 'eeeeeeeee'),
(26, 'tata'),
(27, 'tatat'),
(28, 'tatatp'),
(25, 'tonton');

-- --------------------------------------------------------

--
-- Structure de la table `b__entreprise`
--

CREATE TABLE `b__entreprise` (
  `SIREN` char(9) NOT NULL,
  `Raison_sociale` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `b__entreprise`
--

INSERT INTO `b__entreprise` (`SIREN`, `Raison_sociale`) VALUES
('/////////', '/////////'),
('////////p', '////////p'),
('120027016', 'Carrefour Banque'),
('120027017', 'ACTION'),
('123456789', '123456789'),
('189987774', '189987774'),
('784587458', 'INACTION CONTRE LA FAIM'),
('789456123', '789456123'),
('789987774', '789987774'),
('789987777', '789987777'),
('789987781', '789987789'),
('789987789', '789987789'),
('824541144', 'ACTION LOGEMENT'),
('824541147', 'ACTION LOGEMENT'),
('824541148', 'ACTION LOGEMENT'),
('987', '987'),
('asxcderfg', 'asxcderfg'),
('eeeeeeeee', 'eeeeeeeee'),
('tata', 'tata'),
('tatat', 'tatat'),
('tatatp', 'tatatp'),
('tonton', 'tonton');

-- --------------------------------------------------------

--
-- Structure de la table `b__impaye`
--

CREATE TABLE `b__impaye` (
  `numero_dossier_impaye` int(11) NOT NULL,
  `code` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `b__impaye`
--

INSERT INTO `b__impaye` (`numero_dossier_impaye`, `code`) VALUES
(1, '01');

-- --------------------------------------------------------

--
-- Structure de la table `b__motifs_impayes`
--

CREATE TABLE `b__motifs_impayes` (
  `code` varchar(2) NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `b__motifs_impayes`
--

INSERT INTO `b__motifs_impayes` (`code`, `libelle`) VALUES
('01', 'Fraude à la carte');

-- --------------------------------------------------------

--
-- Structure de la table `b__remise`
--

CREATE TABLE `b__remise` (
  `id` int(11) NOT NULL,
  `SIREN` char(9) CHARACTER SET utf8mb4 NOT NULL,
  `date_traitement` date NOT NULL,
  `devise` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `b__remise`
--

INSERT INTO `b__remise` (`id`, `SIREN`, `date_traitement`, `devise`) VALUES
(1, '120027016', '2022-12-10', 'EUR'),
(2, '120027017', '2022-12-08', 'USD'),
(3, '120027016', '2022-12-10', 'EUR'),
(4, '120027017', '2022-12-08', 'USD');

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
-- Index pour la table `b__remise`
--
ALTER TABLE `b__remise`
  ADD PRIMARY KEY (`id`),
  ADD KEY `SIREN` (`SIREN`);

--
-- Index pour la table `b__role`
--
ALTER TABLE `b__role`
  ADD PRIMARY KEY (`role`),
  ADD UNIQUE KEY `libelle` (`libelle`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `b__compte`
--
ALTER TABLE `b__compte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT pour la table `b__impaye`
--
ALTER TABLE `b__impaye`
  MODIFY `numero_dossier_impaye` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `b__remise`
--
ALTER TABLE `b__remise`
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
-- Contraintes pour la table `b__remise`
--
ALTER TABLE `b__remise`
  ADD CONSTRAINT `b__remise_ibfk_1` FOREIGN KEY (`SIREN`) REFERENCES `b__entreprise` (`SIREN`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
