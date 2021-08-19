-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  jeu. 19 août 2021 à 14:50
-- Version du serveur :  5.7.35-0ubuntu0.18.04.1
-- Version de PHP :  7.2.24-0ubuntu0.18.04.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `admin_livraison`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `IDCLIENT` int(11) NOT NULL,
  `IDUTILISATEUR` int(11) NOT NULL,
  `IDTYPE` int(11) DEFAULT NULL,
  `NOM` varchar(100) DEFAULT NULL,
  `PRENOM` varchar(100) DEFAULT NULL,
  `TEL` varchar(255) DEFAULT NULL,
  `EMAIL` varchar(255) DEFAULT NULL,
  `PWD` varchar(255) DEFAULT NULL,
  `CONFIRMPWD` varchar(255) DEFAULT NULL,
  `DATEAJOUT` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`IDCLIENT`, `IDUTILISATEUR`, `IDTYPE`, `NOM`, `PRENOM`, `TEL`, `EMAIL`, `PWD`, `CONFIRMPWD`, `DATEAJOUT`) VALUES
(1, 1, NULL, 'Abalo1', 'Amen', '232343744', 'salom.zonou@yahoo.fr', '$2y$10$OUrduApug9k4piOAykZveOcLtNfPEJbWX3a9klXSjG7GYC02hUlWK', NULL, '2021-07-06');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `IDCOMMANDE` int(11) NOT NULL,
  `IDUTILISATEUR` int(11) DEFAULT NULL,
  `IDCLIENT` int(11) DEFAULT NULL,
  `IDGEO` int(11) DEFAULT NULL,
  `LATITUDE` decimal(11,8) DEFAULT NULL,
  `LONGITUDE` decimal(11,8) DEFAULT NULL,
  `NOMDESTINATAIRE` varchar(150) DEFAULT NULL,
  `PRENOMDESTINATAIRE` varchar(150) DEFAULT NULL,
  `ADRESSEDESTINATAIRE` varchar(255) DEFAULT NULL,
  `TELDESTINATAIRE` varchar(255) DEFAULT NULL,
  `NOTE` mediumtext,
  `TYPEPAIEMENT` int(11) DEFAULT NULL,
  `DATEAJOUT` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`IDCOMMANDE`, `IDUTILISATEUR`, `IDCLIENT`, `IDGEO`, `LATITUDE`, `LONGITUDE`, `NOMDESTINATAIRE`, `PRENOMDESTINATAIRE`, `ADRESSEDESTINATAIRE`, `TELDESTINATAIRE`, `NOTE`, `TYPEPAIEMENT`, `DATEAJOUT`) VALUES
(26, 68, NULL, NULL, '40.60703460', '-74.41175960', 'Hh', 'Aa', 'Kégué cap', '(00228) 12 - 34 - 56 - 78', 'null', 1, '2021-08-14'),
(25, 77, NULL, NULL, '6.19653940', '1.18723180', 'Roro', 'Coco', 'Rue vakpo', '(00228) 99 - 51 - 68 - 10', 'null', 2, '2021-08-13'),
(24, 72, NULL, NULL, '6.26006250', '1.14280000', 'Test', 'Test', 'Test', '(00228) 12 - 34 - 56 - 78', 'null', 2, '2021-08-13'),
(23, 68, NULL, NULL, '40.60702740', '-74.41176460', 'Hh', 'Gg', 'Rff', '(00228) 56 - 66 - 56 - 55', 'null', 1, '2021-08-12'),
(22, 66, NULL, NULL, '6.16559270', '1.23889930', 'Kok', 'Ju', '45', '(00228) 91 - 93 - 39 - 24', 'null', 1, '2021-08-12'),
(21, 62, NULL, NULL, '6.19657290', '1.18734040', 'Touka', 'Komigan', 'Lomégan', '(00228) 90 - 90 - 11 - 11', 'null', 1, '2021-08-12');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `IDCONTACT` int(11) NOT NULL,
  `IDUTILISATEUR` int(11) DEFAULT NULL,
  `OBJET` varchar(255) DEFAULT NULL,
  `MESSAGE1` varchar(255) DEFAULT NULL,
  `REPONSE` varchar(255) DEFAULT NULL,
  `DATEAJOUT` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`IDCONTACT`, `IDUTILISATEUR`, `OBJET`, `MESSAGE1`, `REPONSE`, `DATEAJOUT`) VALUES
(22, 64, 'null', 'null', 'HH', '2021-08-13'),
(21, 72, 'null', 'null', NULL, '2021-08-13'),
(20, 72, 'null', 'null', NULL, '2021-08-13'),
(19, 72, 'null', 'null', NULL, '2021-08-13'),
(18, 72, 'null', 'Je suis oci', NULL, '2021-08-13'),
(17, 72, 'null', 'Togo', NULL, '2021-08-13'),
(16, 72, 'null', 'Bxhdb', NULL, '2021-08-13'),
(15, 72, 'Jejej', 'Hdhsg', NULL, '2021-08-13'),
(12, 66, 'null', 'Bonjour ', NULL, '2021-08-12'),
(13, 72, 'Jejej', 'Hdhsg', NULL, '2021-08-13'),
(14, 72, 'Jejej', 'Hdhsg', NULL, '2021-08-13'),
(11, 62, 'Un test', 'Un test', 'merci, on arrive demain', '2021-08-12'),
(23, 68, 'null', 'Ccccc', NULL, '2021-08-14'),
(24, 68, 'null', 'Hgfgvgxcvv', 'GG', '2021-08-14'),
(25, 69, 'Demande d&#039;information', 'Bjr\nComment se passe vos courses ?\nJ&#039;aimerais livrer un client de b&eacute; kpota a kegue.\n&Ccedil;a me co&ucirc;tera combien?', NULL, '2021-08-14');

-- --------------------------------------------------------

--
-- Structure de la table `contactlivreur`
--

CREATE TABLE `contactlivreur` (
  `IDCONTACT` int(11) NOT NULL,
  `IDLIVREUR` int(11) DEFAULT NULL,
  `OBJET` varchar(255) DEFAULT NULL,
  `MESSAGE1` varchar(255) DEFAULT NULL,
  `DATEAJOUT` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `course`
--

CREATE TABLE `course` (
  `IDCOURSE` int(11) NOT NULL,
  `IDUTILISATEUR` int(11) DEFAULT NULL,
  `IDLIVREUR` int(11) DEFAULT NULL,
  `ADRESSEDEPART` varchar(255) DEFAULT NULL,
  `ADRESSEARRIVE` varchar(255) DEFAULT NULL,
  `DATELIVRAISON` date DEFAULT NULL,
  `PRIX` int(200) DEFAULT NULL,
  `SOLDE` int(200) DEFAULT NULL,
  `DATEAJOUT` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `course`
--

INSERT INTO `course` (`IDCOURSE`, `IDUTILISATEUR`, `IDLIVREUR`, `ADRESSEDEPART`, `ADRESSEARRIVE`, `DATELIVRAISON`, `PRIX`, `SOLDE`, `DATEAJOUT`) VALUES
(14, 65, NULL, 'Rue de Bodjona', 'lampapa', '2021-08-13', 5000, 5000, '2021-08-12');

-- --------------------------------------------------------

--
-- Structure de la table `geolocalisation`
--

CREATE TABLE `geolocalisation` (
  `IDGEO` int(11) NOT NULL,
  `LONGITUDE` decimal(11,8) DEFAULT NULL,
  `LATITUDE` decimal(11,8) DEFAULT NULL,
  `DATEAJOUT` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `livreur`
--

CREATE TABLE `livreur` (
  `IDLIVREUR` int(11) NOT NULL,
  `IDUTILISATEUR` int(11) NOT NULL,
  `IDGEO` int(11) DEFAULT NULL,
  `IDTYPE` int(11) DEFAULT NULL,
  `NOM` varchar(100) DEFAULT NULL,
  `PRENOM` varchar(100) DEFAULT NULL,
  `TEL` varchar(255) DEFAULT NULL,
  `EMAIL` varchar(255) DEFAULT NULL,
  `PWD` varchar(255) DEFAULT NULL,
  `CONFIRMPWD` varchar(255) DEFAULT NULL,
  `DATEAJOUT` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `livreur`
--

INSERT INTO `livreur` (`IDLIVREUR`, `IDUTILISATEUR`, `IDGEO`, `IDTYPE`, `NOM`, `PRENOM`, `TEL`, `EMAIL`, `PWD`, `CONFIRMPWD`, `DATEAJOUT`) VALUES
(1, 1, NULL, NULL, 'Abalo1', 'Amen', '232343744', 'salom.zonou@yahoo.fr', '$2y$10$4Dv3bQqt4YW0jWFa68te2eLrzGDSB8cqP6sW02XRqjhKLE4mNSCt2', NULL, '2021-07-06');

-- --------------------------------------------------------

--
-- Structure de la table `permission`
--

CREATE TABLE `permission` (
  `IDPERMISSION` int(11) NOT NULL,
  `LIBELLE` varchar(200) DEFAULT NULL,
  `DATEAJOUT` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `permission`
--

INSERT INTO `permission` (`IDPERMISSION`, `LIBELLE`, `DATEAJOUT`) VALUES
(1, 'utilisateur.client.add', '2020-06-12 17:02:00'),
(2, 'utilisateur.client.update', '2020-06-12 17:02:25'),
(3, 'utilisateur.client.delete', '2020-06-12 17:05:31'),
(4, 'utilisateur.commande.add', '2020-06-12 17:06:12'),
(5, 'utilisateur.commande.update', '2020-06-12 17:06:36'),
(6, 'utilisateur.commande.delete', '2020-06-12 17:06:36'),
(7, 'utilisateur.contactclient.add', '2020-06-12 17:09:39'),
(8, 'utilisateur.contactclient.update', '2020-06-16 00:00:00'),
(9, 'utilisateur.contactclient.delete', '2020-06-16 00:00:00'),
(10, 'utilisateur.contactlivreur.add', '2020-06-16 00:00:00'),
(11, 'utilisateur.contactlivreur.update', '2020-06-16 00:00:00'),
(12, 'utilisateur.contactlivreur.delete', '2020-06-16 00:00:00'),
(13, 'utilisateur.course.add', '2020-06-16 00:00:00'),
(14, 'utilisateur.course.update', '2020-06-16 00:00:00'),
(15, 'utilisateur.course.delete', '2020-06-16 00:00:00'),
(16, 'utilisateur.geolocalisation.add', '2020-06-17 00:00:00'),
(17, 'utilisateur.geolocalisation.update', '2020-06-17 00:00:00'),
(18, 'utilisateur.geolocalisation.delete', '2020-06-17 00:00:00'),
(19, 'utilisateur.livreur.add', '2020-06-19 00:00:00'),
(20, 'utilisateur.livreur.update', '2020-06-19 00:00:00'),
(21, 'utilisateur.livreur.delete', '2020-06-19 00:00:00'),
(22, 'utilisateur.typepaiement.add', '2020-06-19 00:00:00'),
(23, 'utilisateur.typepaiement.update', '2020-06-19 00:00:00'),
(24, 'utilisateur.typepaiement.delete', '2020-06-19 00:00:00'),
(25, 'utilisateur.statuutilisateur.add', '2020-06-19 00:00:00'),
(26, 'utilisateur.statuutilisateur.update', '2020-06-19 00:00:00'),
(27, 'utilisateur.statuutilisateur.delete', '2020-06-19 00:00:00'),
(28, 'utilisateur.s_abonner.add', '2020-06-19 00:00:00'),
(29, 'utilisateur.s_abonner.update', '2020-06-19 00:00:00'),
(30, 'utilisateur.s_abonner.delete', '2020-06-19 00:00:00'),
(31, 'utilisateur.typeabonnement.add', '2020-06-19 00:00:00'),
(32, 'utilisateur.typeabonnement.update', '2020-06-19 00:00:00'),
(33, 'utilisateur.typeabonnement.delete', '2020-06-19 00:00:00'),
(34, 'utilisateur.typecode.add', '2020-06-19 00:00:00'),
(35, 'utilisateur.typecode.update', '2020-06-19 00:00:00'),
(36, 'utilisateur.typecode.delete', '2020-06-19 00:00:00'),
(37, 'utilisateur.typepaiement.add', '2020-06-19 00:00:00'),
(38, 'utilisateur.typepaiement.update', '2020-06-19 00:00:00'),
(39, 'utilisateur.typepaiement.delete', '2020-06-19 00:00:00'),
(40, 'utilisateur.typepiece.add', '2020-06-19 00:00:00'),
(41, 'utilisateur.typepiece.update', '2020-06-19 00:00:00'),
(42, 'utilisateur.typepiece.delete', '2020-06-19 00:00:00'),
(43, 'utilisateur.utilisateur.add', '2020-06-19 00:00:00'),
(44, 'utilisateur.utilisateur.update', '2020-06-19 00:00:00'),
(45, 'utilisateur.ville.add', '2020-06-19 00:00:00'),
(46, 'utilisateur.ville.update', '2020-06-19 00:00:00'),
(47, 'utilisateur.ville.delete', '2020-06-19 00:00:00'),
(48, 'admin.client.add', '2020-06-19 00:00:00'),
(49, 'admin.client.update', '2020-06-19 00:00:00'),
(50, 'admin.autorisation.add', '2020-06-19 00:00:00'),
(51, 'admin.autorisation.update', '2020-06-19 00:00:00'),
(52, 'admin.client.delete', '2020-06-19 00:00:00'),
(53, 'admin.autorisation.delete', '2020-06-19 00:00:00'),
(54, 'admin.commande.add', '2020-06-19 00:00:00'),
(55, 'admin.commande.update', '2020-06-19 00:00:00'),
(56, 'admin.commande.delete', '2020-06-19 00:00:00'),
(57, 'admin.contactclient.add', '2020-06-19 00:00:00'),
(58, 'admin.contactclient.update', '2020-06-19 00:00:00'),
(59, 'admin.contactclient.delete', '2020-06-19 00:00:00'),
(60, 'admin.geolocalisation.add', '2020-06-19 00:00:00'),
(61, 'admin.geolocalisation.update', '2020-06-19 00:00:00'),
(62, 'admin.geolocalisation.delete', '2020-06-19 00:00:00'),
(63, 'admin.historiqueposition.add', '2020-06-19 00:00:00'),
(64, 'admin.historiqueposition.update', '2020-06-19 00:00:00'),
(65, 'admin.historiqueposition.delete', '2020-06-19 00:00:00'),
(66, 'admin.log.add', '2020-06-19 00:00:00'),
(67, 'admin.log.update', '2020-06-19 00:00:00'),
(68, 'admin.log.delete', '2020-06-19 00:00:00'),
(69, 'admin.contactlivreur.add', '2020-06-19 00:00:00'),
(70, 'admin.contactlivreur.update', '2020-06-19 00:00:00'),
(71, 'admin.contactlivreur.delete', '2020-06-19 00:00:00'),
(72, 'admin.permission.add', '2020-06-19 00:00:00'),
(73, 'admin.permission.update', '2020-06-19 00:00:00'),
(74, 'admin.permission.delete', '2020-06-19 00:00:00'),
(75, 'admin.role.add', '2020-06-23 00:00:00'),
(76, 'admin.role.update', '2020-06-23 00:00:00'),
(77, 'admin.role.delete', '2020-06-23 00:00:00'),
(78, 'admin.rolepermission.add', '2020-06-23 00:00:00'),
(79, 'admin.rolepermission.update', '2020-06-23 00:00:00'),
(80, 'admin.rolepermission.delete', '2020-06-23 00:00:00'),
(81, 'admin.course.add', '2020-06-23 00:00:00'),
(82, 'admin.course.update', '2020-06-23 00:00:00'),
(83, 'admin.course.delete', '2020-06-23 00:00:00'),
(84, 'admin.livreur.add', '2020-06-23 00:00:00'),
(85, 'admin.livreur.update', '2020-06-23 00:00:00'),
(86, 'admin.statucode.delete', '2020-06-23 00:00:00'),
(87, 'admin.statuutilisateur.add', '2020-06-23 00:00:00'),
(88, 'admin.statuutilisateur.update', '2020-06-23 00:00:00'),
(89, 'admin.s_abonner.add', '2020-06-23 00:00:00'),
(90, 'admin.s_abonner.update', '2020-06-23 00:00:00'),
(91, 'admin.s_abonner.delete', '2020-06-23 00:00:00'),
(92, 'admin.typeabonnement.add', '2020-06-23 00:00:00'),
(93, 'admin.typeabonnement.update', '2020-06-23 00:00:00'),
(94, 'admin.typeabonnement.delete', '2020-06-23 00:00:00'),
(95, 'admin.typecode.add', '2020-06-23 00:00:00'),
(96, 'admin.typecode.update', '2020-06-23 00:00:00'),
(97, 'admin.typecode.delete', '2020-06-23 00:00:00'),
(98, 'admin.typepaiement.add', '2020-06-23 00:00:00'),
(99, 'admin.typepaiement.update', '2020-06-23 00:00:00'),
(100, 'admin.typepaiement.delete', '2020-06-23 00:00:00'),
(101, 'admin.typepiece.add', '2020-06-23 00:00:00'),
(102, 'admin.typepiece.update', '2020-06-23 00:00:00'),
(103, 'admin.typepiece.delete', '2020-06-23 00:00:00'),
(104, 'admin.utilisateur.add', '2020-06-23 00:00:00'),
(105, 'admin.utilisateur.update', '2020-06-23 00:00:00'),
(106, 'admin.utilisateur.delete', '2020-06-23 00:00:00'),
(107, 'admin.utilisateurtoken.add', '2020-06-23 00:00:00'),
(108, 'admin.utilisateurtoken.update', '2020-06-23 00:00:00'),
(109, 'admin.utilisateurtoken.delete', '2020-06-23 00:00:00'),
(110, 'admin.ville.add', '2020-06-23 00:00:00'),
(111, 'admin.ville.update', '2020-06-23 00:00:00'),
(112, 'admin.ville.delete', '2020-06-23 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `IDROLE` int(11) NOT NULL,
  `LIBELLE` char(20) DEFAULT NULL,
  `DATEAJOUT` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`IDROLE`, `LIBELLE`, `DATEAJOUT`) VALUES
(4, 'utilisateur', '2020-06-05 13:34:37'),
(5, 'admin', '2020-06-08 16:12:50');

-- --------------------------------------------------------

--
-- Structure de la table `rolepermission`
--

CREATE TABLE `rolepermission` (
  `IDROLEPERM` int(11) NOT NULL,
  `IDPERMISSION` int(11) NOT NULL,
  `IDROLE` int(11) NOT NULL,
  `DATEAJOUT` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `rolepermission`
--

INSERT INTO `rolepermission` (`IDROLEPERM`, `IDPERMISSION`, `IDROLE`, `DATEAJOUT`) VALUES
(1, 7, 4, '2020-06-12 17:12:15');

-- --------------------------------------------------------

--
-- Structure de la table `typeclient`
--

CREATE TABLE `typeclient` (
  `IDTYPE` int(11) NOT NULL,
  `LIBELLE` varchar(255) DEFAULT NULL,
  `DATEAJOUT` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `typeclient`
--

INSERT INTO `typeclient` (`IDTYPE`, `LIBELLE`, `DATEAJOUT`) VALUES
(1, 'Client', '2021-07-14'),
(2, 'Livreur', '2021-07-14');

-- --------------------------------------------------------

--
-- Structure de la table `typepaiement`
--

CREATE TABLE `typepaiement` (
  `IDPAIEMENT` int(11) NOT NULL,
  `LIBELLE` varchar(255) DEFAULT NULL,
  `DATEAJOUT` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `typepaiement`
--

INSERT INTO `typepaiement` (`IDPAIEMENT`, `LIBELLE`, `DATEAJOUT`) VALUES
(1, 'En esp&egrave;ce', '2021-07-07'),
(2, 'Tmoney/Flooz', '2021-07-07'),
(3, 'Par chèque', '2021-07-07');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `IDUTILISATEUR` int(11) NOT NULL,
  `IDROLE` int(11) DEFAULT NULL,
  `IDTYPE` int(11) DEFAULT NULL,
  `NOM` varchar(100) DEFAULT NULL,
  `PRENOM` varchar(100) DEFAULT NULL,
  `TEL` varchar(255) DEFAULT NULL,
  `EMAIL` varchar(255) DEFAULT NULL,
  `PWD` varchar(255) DEFAULT NULL,
  `LAST_LOGIN` datetime DEFAULT NULL,
  `DATEAJOUT` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`IDUTILISATEUR`, `IDROLE`, `IDTYPE`, `NOM`, `PRENOM`, `TEL`, `EMAIL`, `PWD`, `LAST_LOGIN`, `DATEAJOUT`) VALUES
(76, 4, 2, 'Kokouvi', 'Mawuli', '(00228) 99 - 67 - 40 - 29', 'mawuli12@yahoo.fr', '$2y$10$6xd39dmOQCXpVHjyefGONOXbT71i5w4px7JsG5LQFE8Vm4QzTe/YO', '2021-08-16 22:02:17', '2021-08-13'),
(77, 4, 1, 'Amouzou ', 'Brolin', '(00228) 90 - 34 - 36 - 82', 'excellenceson@yahoo.fr', '$2y$10$G5rNkU5W.H1iqOewPBkwGujhnL07Eq3mkEoXpj442Z.R3axh1cTa6', '2021-08-13 20:56:50', '2021-08-13'),
(73, 4, 1, 'Akouma', 'Kodjogan', '(00228) 67 - 67 - 67 - 67', 'kodjogan@gmail.com', '$2y$10$/AD.S8uTc8nfmpgWTidEZuoN6sO.PcdqYU9OyZA2esIATvV6EYIO6', '2021-08-13 08:32:17', '2021-08-13'),
(74, 4, 1, 'Akouma', 'Kodjogan', '(00228) 67 - 67 - 67 - 67', 'kodjogan@gmail.com', '$2y$10$edHaCoLtIKFz7vmmQA3/uelo.j5.Cp.9IlbYyxdVnmWbyk2.4iNUi', NULL, '2021-08-13'),
(72, 4, 1, 'Test', 'Testprenom', '(00228) 12 - 34 - 56 - 78', 'test@gmail.com', '$2y$10$PxoXeVN9GLJTUvU5EXCAseEG70IC8cwZCuLKVhMqYvMXdaqtQXJ2m', '2021-08-13 05:44:54', '2021-08-13'),
(71, 4, 1, 'Test', 'Testprenom', '(00228) 91 - 44 - 61 - 68', 'test@gmail.com', '$2y$10$2z09exkxhfgFzpIWCBZw2OgpZWNSo9/X4vPQo22uioKFmtqr7RTJO', NULL, '2021-08-13'),
(70, 4, 1, 'Samon ', 'Atana ', '(00228) 92 - 26 - 36 - 03', 'magloiresamon@gmail.com', '$2y$10$LVojZQeNSVri94D7jFAvNeJu3XCzuNzpr.HyirI0nJWOJ3EKgHXRy', NULL, '2021-08-12'),
(69, 4, 1, 'Denoo', 'Kossivi', '(00228) 91 - 57 - 52 - 32', 'kossivinyatepe@gmail.com', '$2y$10$fx2aRqBQYiPdFPVJx//SUO14Bc3SnIupJ1bsVd9fjmpxrTJqhntF.', '2021-08-15 02:39:14', '2021-08-12'),
(68, 4, 1, 'Samon ', 'Magloire ', '(00228) 92 - 25 - 36 - 03', 'magloiresamon@gmail.com', '$2y$10$tNdJPa0UezBxM3x.nHZ4renLiHNBMsyOCnMCt0EV0Ue6y2OszhBG.', '2021-08-14 23:28:15', '2021-08-12'),
(67, 4, 1, 'DENOO', 'Kossivi', '(00228) 91 - 57 - 52 - 32', 'kossivinyatepe@gmail.com', '$2y$10$W3/JnbkrZIm3YqAd1lbVbeL4SCMtvdKnaixKWPbcetjg7r2XnPyGS', NULL, '2021-08-12'),
(66, 4, 1, 'Mawuli', 'Kokou', '(00228) 91 - 93 - 39 - 24', 'assematsua@yahoo.fr', '$2y$10$1D6uCpC3VsO0VLOlnUXK.e2lE5QcHlwkYJyOtao1Nrmq4Thzhic/u', '2021-08-13 03:56:03', '2021-08-12'),
(64, 4, 1, 'DSTECH', 'Admin', '(00228) 70 - 00 - 00 - 00', 'admin1@dstech.com', '$2y$10$AS26kEKKXigNQkwQsTYnu.mMmb7jzIp4GH0Y1ZftpY7tvuuKZ37Y6', '2021-08-13 08:04:17', '2021-08-12'),
(65, 4, 2, 'livreur1', 'Komivi', '(00228) 90 - 90 - 77 - 00', 'komivilivreur@contact.com', '$2y$10$bwr30gDla/1s6LNHV66hNuhUCT/qfw3KmGW4Awj6agfe04jsLmunm', '2021-08-13 01:45:02', '2021-08-12'),
(62, 4, 1, 'AZONKO', 'Kokougan', '(00228) 90 - 90 - 90 - 90', 'test@test1.com', '$2y$10$frCC14G4D8hM.Te5U.OSnuRU3s9IC1/tCMNrR7NJIKfgca.gt0Uvi', '2021-08-13 01:46:55', '2021-08-12');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurtoken`
--

CREATE TABLE `utilisateurtoken` (
  `IDTOKEN` int(11) NOT NULL,
  `IDUTILISATEUR` int(11) NOT NULL,
  `TOKEN` varchar(255) NOT NULL,
  `DATEAJOUT` datetime NOT NULL,
  `DATEEXPIRATION` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurtoken`
--

INSERT INTO `utilisateurtoken` (`IDTOKEN`, `IDUTILISATEUR`, `TOKEN`, `DATEAJOUT`, `DATEEXPIRATION`) VALUES
(133, 76, '$2y$10$2QxckZUby9u0jwj9eL9QL.t1SQrzPi.m7Y4h9POtIbVRn5j3h6Pg.', '2021-08-16 22:02:17', '2021-08-17 10:02:17'),
(132, 76, '$2y$10$gaNOZhEDXRVDAZo4tk6tkOzB6jvGGQLznVgIuBSVVG4NzD8ko8x2W', '2021-08-16 21:55:41', '2021-08-17 09:55:41'),
(131, 69, '$2y$10$1rGQ98x1EAkcVgtOdruaSOw.rsunx3EOLpjTIsx6InXRqJOPgG.d.', '2021-08-15 02:39:14', '2021-08-15 14:39:14'),
(130, 68, '$2y$10$yqg.CCXHe66r99J8p7UTl.OLcEUsF3oCvMWtxz/YSwFdipPSyLRFu', '2021-08-14 23:28:15', '2021-08-15 11:28:15'),
(129, 68, '$2y$10$jYUYJLhIAN3YvoYKl//jt.Hf/J4cIe2TztX5zIWpR5WZx7DucqthW', '2021-08-14 05:06:34', '2021-08-14 17:06:34'),
(128, 78, '$2y$10$287x0frKg.S4LPs/An88BuNIlAcf/DboYpn4YaK6qcUrJBV20FWFW', '2021-08-13 21:06:25', '2021-08-14 09:06:25'),
(127, 77, '$2y$10$HhcAXwFciA8brrQkaU1uqOzbptDppH7rKcXkzqLxmFg4OGYYqrBAu', '2021-08-13 20:56:50', '2021-08-14 08:56:51'),
(126, 76, '$2y$10$ojHMUmt/xVpR4KuI.R2uXODYk.bgUX0EbD3WFIZ.vag9Tn5ohiLH6', '2021-08-13 20:49:22', '2021-08-14 08:49:22'),
(125, 76, '$2y$10$THpf9l0W5/8PphIDqvZPc.9/iF320RVqdMkGhvKcWNVPNlrzqLFBi', '2021-08-13 20:30:24', '2021-08-14 08:30:24'),
(124, 69, '$2y$10$.JNtmRIV/R5pcJPBqTWfQO1h1BU3rfqg8mg8oPKSZ3JI9ktzsnU66', '2021-08-13 18:16:22', '2021-08-14 06:16:22'),
(123, 75, '$2y$10$VabTj7zGlNGOHNX7gmJWfueUD/9p6geslHV/NWPCk1rmdwNstqTUG', '2021-08-13 14:11:42', '2021-08-14 02:11:42'),
(122, 73, '$2y$10$HISkG4bHmSkLVV8steidg.KWbtBkor8jCpCM7pkS9yr4GtUDJHt2y', '2021-08-13 08:32:17', '2021-08-13 20:32:17'),
(121, 64, '$2y$10$WpzjG4iIecqwGqREKwQKgOkm19qQdBafFTAcruVBDuKIUMeM9HEnm', '2021-08-13 08:04:17', '2021-08-13 20:04:17'),
(120, 72, '$2y$10$YLTBBzMvrpDJUYdbJMcSsuq1hPcFaFL2PEQ9tjDyj.l61vSxJIABK', '2021-08-13 05:44:54', '2021-08-13 17:44:54'),
(119, 72, '$2y$10$WmVNlrLumd5MqS5GnDBSAu0AN.81Nfs5XOm5G3NTaD9GgVbEwsc6C', '2021-08-13 05:34:43', '2021-08-13 17:34:43'),
(118, 68, '$2y$10$kyrmZgyxKH2ibbUy78tcieu/b5LnYW0FZNjCTsrON0vEwkifA88qC', '2021-08-13 04:14:56', '2021-08-13 16:14:56'),
(117, 69, '$2y$10$LC28DxsaWaD/eVsyLFE9ReOftFX1eB1OVQu7YpkYgcwyOJSGHgxbq', '2021-08-13 04:04:32', '2021-08-13 16:04:32'),
(116, 66, '$2y$10$H286zvbVU6lwZ4ShdaeDTu2MHuEAJzB5g.C.2DrcP1SDhP1ahWmmO', '2021-08-13 03:56:03', '2021-08-13 15:56:03'),
(115, 66, '$2y$10$s0r26EVRG5kMk4SkPswDUOVPSQfH4wMRY8LqUNjyjFGRIp6TMJAD2', '2021-08-13 01:48:40', '2021-08-13 13:48:40'),
(114, 62, '$2y$10$X/0HmR8uS1lCfXdeEgwRWOcN4602oqwr/bGuWRqNqKVYBjhsPOeRC', '2021-08-13 01:46:55', '2021-08-13 13:46:55'),
(113, 65, '$2y$10$ks7nQCprcLAvpS9UOjspp.hbac3KNhGIOnZhDteo3RAOq3GFqqOm2', '2021-08-13 01:45:02', '2021-08-13 13:45:02'),
(112, 64, '$2y$10$HMIhSCl4eYb.o8yedNbUAOTtmau6rpl4wui1IP21ggYBRhjLufFie', '2021-08-13 01:41:21', '2021-08-13 13:41:21'),
(111, 63, '$2y$10$IgO9ea3cFjZKKjyPxJWtveGIL/52nFZQLM1/N/IDfd7TlrS6zRLia', '2021-08-13 01:29:57', '2021-08-13 13:29:57'),
(110, 62, '$2y$10$3JEGTyNdBdkPXmZPAH/xge4laf.jjzKA8UQPTL9Un76bDAdeYsXLG', '2021-08-13 01:25:09', '2021-08-13 13:25:09'),
(109, 62, '$2y$10$sPa1Ko5z0BbhEpaYQGPcaOdMYGHvSVMB/0DxOWFRGNIkg.EjNJ06O', '2021-08-13 01:22:53', '2021-08-13 13:22:53');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`IDCLIENT`),
  ADD KEY `FK_CLIENT_ETRE1_UTILISAT` (`IDUTILISATEUR`),
  ADD KEY `fk_client_type` (`IDTYPE`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`IDCOMMANDE`),
  ADD KEY `FK_COMMANDE_COMMANDER_CLIENT` (`IDCLIENT`),
  ADD KEY `fk_geo_idgeo` (`IDGEO`),
  ADD KEY `fk_comm_paie` (`TYPEPAIEMENT`),
  ADD KEY `fk_commande_utilisateur` (`IDUTILISATEUR`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`IDCONTACT`),
  ADD KEY `fk_contact_utilisateur` (`IDUTILISATEUR`);

--
-- Index pour la table `contactlivreur`
--
ALTER TABLE `contactlivreur`
  ADD PRIMARY KEY (`IDCONTACT`),
  ADD KEY `fk_contact_liv` (`IDLIVREUR`);

--
-- Index pour la table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`IDCOURSE`),
  ADD KEY `FK_COURSE_FAIRE_LIVREUR` (`IDLIVREUR`),
  ADD KEY `fk_course_utilisateur` (`IDUTILISATEUR`);

--
-- Index pour la table `geolocalisation`
--
ALTER TABLE `geolocalisation`
  ADD PRIMARY KEY (`IDGEO`);

--
-- Index pour la table `livreur`
--
ALTER TABLE `livreur`
  ADD PRIMARY KEY (`IDLIVREUR`),
  ADD KEY `FK_LIVREUR_ETRE_UTILISAT` (`IDUTILISATEUR`),
  ADD KEY `fk_geo_liv` (`IDGEO`),
  ADD KEY `fk_livreur_type` (`IDTYPE`);

--
-- Index pour la table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`IDPERMISSION`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`IDROLE`);

--
-- Index pour la table `rolepermission`
--
ALTER TABLE `rolepermission`
  ADD PRIMARY KEY (`IDROLEPERM`),
  ADD KEY `fk_rolepermission_permission` (`IDPERMISSION`),
  ADD KEY `fk_rolepermission_role` (`IDROLE`);

--
-- Index pour la table `typeclient`
--
ALTER TABLE `typeclient`
  ADD PRIMARY KEY (`IDTYPE`);

--
-- Index pour la table `typepaiement`
--
ALTER TABLE `typepaiement`
  ADD PRIMARY KEY (`IDPAIEMENT`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`IDUTILISATEUR`),
  ADD KEY `fk_role_idrole` (`IDROLE`);

--
-- Index pour la table `utilisateurtoken`
--
ALTER TABLE `utilisateurtoken`
  ADD PRIMARY KEY (`IDTOKEN`),
  ADD KEY `fk_idutilisateur_token` (`IDUTILISATEUR`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `IDCLIENT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `IDCOMMANDE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `IDCONTACT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `contactlivreur`
--
ALTER TABLE `contactlivreur`
  MODIFY `IDCONTACT` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `course`
--
ALTER TABLE `course`
  MODIFY `IDCOURSE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `geolocalisation`
--
ALTER TABLE `geolocalisation`
  MODIFY `IDGEO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `livreur`
--
ALTER TABLE `livreur`
  MODIFY `IDLIVREUR` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `permission`
--
ALTER TABLE `permission`
  MODIFY `IDPERMISSION` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `IDROLE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `rolepermission`
--
ALTER TABLE `rolepermission`
  MODIFY `IDROLEPERM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `typeclient`
--
ALTER TABLE `typeclient`
  MODIFY `IDTYPE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `typepaiement`
--
ALTER TABLE `typepaiement`
  MODIFY `IDPAIEMENT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `IDUTILISATEUR` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT pour la table `utilisateurtoken`
--
ALTER TABLE `utilisateurtoken`
  MODIFY `IDTOKEN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
