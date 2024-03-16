-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 16 mars 2024 à 07:31
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `aeutna`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `message` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `avis_users_id_foreign` (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `axes`
--

DROP TABLE IF EXISTS `axes`;
CREATE TABLE IF NOT EXISTS `axes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_axes` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `axes_users_id_foreign` (`users_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `axes`
--

INSERT INTO `axes` (`id`, `nom_axes`, `users_id`, `created_at`, `updated_at`) VALUES
(1, 'Ankavanana', 1, '2024-03-15 17:41:21', '2024-03-15 17:41:21'),
(2, 'Andempona', 1, '2024-03-15 15:04:15', '2024-03-15 15:04:15'),
(3, 'Ankavia', 1, '2024-03-15 15:04:24', '2024-03-15 15:04:24'),
(4, 'Cap-Est', 1, '2024-03-15 15:04:38', '2024-03-15 15:04:38'),
(5, 'Centre Ville', 1, '2024-03-15 15:04:53', '2024-03-15 15:04:53'),
(6, 'Andrarony', 1, '2024-03-15 15:05:34', '2024-03-15 15:05:34');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `users_id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  `commentaires` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commentaires_users_id_foreign` (`users_id`),
  KEY `commentaires_post_id_foreign` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `connection` text COLLATE utf8mb4_general_ci NOT NULL,
  `queue` text COLLATE utf8mb4_general_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `filieres`
--

DROP TABLE IF EXISTS `filieres`;
CREATE TABLE IF NOT EXISTS `filieres` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_filieres` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `filieres_users_id_foreign` (`users_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `filieres`
--

INSERT INTO `filieres` (`id`, `nom_filieres`, `users_id`, `created_at`, `updated_at`) VALUES
(1, 'Informatique', 1, '2024-03-15 17:42:23', '2024-03-15 17:42:23'),
(2, 'Gestion', 1, '2024-03-15 15:08:51', '2024-03-15 15:08:51'),
(3, 'Sociologie', 1, '2024-03-15 15:09:06', '2024-03-15 15:09:06'),
(4, 'Droit', 1, '2024-03-15 15:09:38', '2024-03-15 15:09:38'),
(5, 'Anglais', 1, '2024-03-15 15:09:55', '2024-03-15 15:09:55'),
(6, 'Français', 1, '2024-03-15 15:10:03', '2024-03-15 15:10:03'),
(7, 'Allemand', 1, '2024-03-15 15:10:12', '2024-03-15 15:10:12'),
(8, 'Histoire', 1, '2024-03-15 15:10:19', '2024-03-15 15:10:19'),
(9, 'Géographique', 1, '2024-03-15 15:10:27', '2024-03-15 15:10:27'),
(10, 'Malagasy', 1, '2024-03-15 15:10:42', '2024-03-15 15:10:42'),
(11, 'Tourisme et Hôtellerie', 1, '2024-03-15 15:12:17', '2024-03-15 15:24:49'),
(12, 'Comptabilité', 1, '2024-03-15 15:13:31', '2024-03-15 15:13:31'),
(13, 'Commerce', 1, '2024-03-15 15:13:44', '2024-03-15 15:13:44'),
(14, 'Paramède', 1, '2024-03-15 15:14:41', '2024-03-15 15:14:41'),
(15, 'Médecine Humaine', 1, '2024-03-15 15:25:14', '2024-03-15 15:25:14'),
(16, 'Économie Gestion Sociologie', 1, '2024-03-15 15:31:45', '2024-03-15 15:31:45'),
(17, 'Génie électrique', 1, '2024-03-15 15:38:41', '2024-03-15 15:38:41'),
(18, 'Langue et culture chinoise', 1, '2024-03-15 15:39:13', '2024-03-15 15:39:13'),
(19, 'Administration', 1, '2024-03-15 15:39:43', '2024-03-15 15:39:43'),
(20, 'Economie', 1, '2024-03-15 15:40:08', '2024-03-15 15:40:08'),
(21, 'Gestion comptable', 1, '2024-03-15 15:40:24', '2024-03-15 15:40:24'),
(22, 'Infirmier généraliste', 1, '2024-03-15 15:41:22', '2024-03-15 15:41:22'),
(23, 'Génie civil et architecture', 1, '2024-03-15 15:41:50', '2024-03-15 15:41:50'),
(24, 'Commerce et Marketing', 1, '2024-03-15 15:42:04', '2024-03-15 15:42:04'),
(25, 'Finance et comptable', 1, '2024-03-15 15:43:36', '2024-03-15 15:43:36'),
(26, 'commerce international', 1, '2024-03-15 15:44:21', '2024-03-15 15:44:21'),
(27, 'Environnement', 1, '2024-03-15 15:44:48', '2024-03-15 15:44:48'),
(28, 'Communication', 1, '2024-03-15 15:45:32', '2024-03-15 15:45:32'),
(29, 'banque', 1, '2024-03-15 15:46:35', '2024-03-15 15:46:35'),
(30, 'physique', 1, '2024-03-15 15:46:53', '2024-03-15 15:46:53'),
(31, 'chimie', 1, '2024-03-15 15:47:07', '2024-03-15 15:47:07'),
(32, 'Faculté de science', 1, '2024-03-15 16:29:16', '2024-03-15 16:29:16'),
(33, 'Tourisme', 1, '2024-03-16 01:40:55', '2024-03-16 01:40:55');

-- --------------------------------------------------------

--
-- Structure de la table `fonctions`
--

DROP TABLE IF EXISTS `fonctions`;
CREATE TABLE IF NOT EXISTS `fonctions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `fonctions` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fonctions_users_id_foreign` (`users_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `fonctions`
--

INSERT INTO `fonctions` (`id`, `fonctions`, `users_id`, `created_at`, `updated_at`) VALUES
(1, 'Communications', 1, '2024-03-15 17:42:51', '2024-03-15 17:42:51'),
(2, 'Président', 1, '2024-03-15 15:15:03', '2024-03-15 15:15:03'),
(3, 'Membre', 1, '2024-03-15 15:15:29', '2024-03-15 15:15:29'),
(4, 'Trésorier', 1, '2024-03-15 15:16:13', '2024-03-15 15:16:13'),
(5, 'Vice Président', 1, '2024-03-15 15:32:00', '2024-03-15 15:32:00'),
(6, 'Bureau', 1, '2024-03-16 00:49:16', '2024-03-16 00:49:16'),
(7, 'Responsable Sport', 1, '2024-03-16 00:49:34', '2024-03-16 00:49:34'),
(8, 'Commissaire au compte', 1, '2024-03-16 01:16:23', '2024-03-16 01:16:23');

-- --------------------------------------------------------

--
-- Structure de la table `levels`
--

DROP TABLE IF EXISTS `levels`;
CREATE TABLE IF NOT EXISTS `levels` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `niveau` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `levels_users_id_foreign` (`users_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `levels`
--

INSERT INTO `levels` (`id`, `niveau`, `users_id`, `created_at`, `updated_at`) VALUES
(1, 'Master 2', 1, '2024-03-15 17:43:16', '2024-03-15 17:43:16'),
(2, 'Licence 1', 1, '2024-03-15 15:06:18', '2024-03-15 15:06:18'),
(3, 'Licence 2', 1, '2024-03-15 15:06:28', '2024-03-15 15:06:28'),
(4, 'Licence 3', 1, '2024-03-15 15:06:37', '2024-03-15 15:06:37'),
(5, 'Master 1', 1, '2024-03-15 15:06:44', '2024-03-15 15:06:44');

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `users_id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `likes_users_id_foreign` (`users_id`),
  KEY `likes_post_id_foreign` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `numero_carte` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_de_naissance` date NOT NULL,
  `lieu_de_naissance` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `cin` varchar(12) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `genre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `contact_personnel` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `contact_tuteur` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `sympathisant` tinyint(1) NOT NULL,
  `date_inscription` date NOT NULL,
  `sections_id` bigint UNSIGNED NOT NULL,
  `fonctions_id` bigint UNSIGNED NOT NULL,
  `filieres_id` bigint UNSIGNED NOT NULL,
  `levels_id` bigint UNSIGNED NOT NULL,
  `axes_id` bigint UNSIGNED DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `lien_membre_id` int DEFAULT '0',
  `facebook` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `membres_sections_id_foreign` (`sections_id`),
  KEY `membres_fonctions_id_foreign` (`fonctions_id`),
  KEY `membres_filieres_id_foreign` (`filieres_id`),
  KEY `membres_levels_id_foreign` (`levels_id`),
  KEY `membres_axes_id_foreign` (`axes_id`),
  KEY `membres_users_id_foreign` (`users_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`id`, `image`, `numero_carte`, `nom`, `prenom`, `date_de_naissance`, `lieu_de_naissance`, `cin`, `genre`, `contact_personnel`, `contact_tuteur`, `sympathisant`, `date_inscription`, `sections_id`, `fonctions_id`, `filieres_id`, `levels_id`, `axes_id`, `adresse`, `users_id`, `lien_membre_id`, `facebook`, `created_at`, `updated_at`) VALUES
(2, 'http://192.168.1.107:8000/storage/membres/1710526850.png', 1, 'RAMANANA', 'Thu Ming Thierry', '1999-03-03', 'Antalaha', '710011057416', 'Masculin', '0327563770', '0327339964', 0, '2024-03-15', 2, 1, 1, 1, 1, 'VT 29 RAI bis Ampahateza', 1, 1, 'RAMANANA Thu Ming Thierry', '2024-03-15 17:44:12', '2024-03-15 15:51:15'),
(3, 'http://192.168.1.107:8000/storage/membres/1710527464.png', 4, 'ZAVALAHY', 'Johnny Keita', '1994-02-22', 'Vohemar', '303011018528', 'Masculin', '0327240254', '0328137227', 0, '2024-02-04', 2, 5, 16, 1, 5, 'CU Ambohipo Bloc 80 Porte C2', 1, 0, 'Keita Johnny', '2024-03-15 15:31:04', '2024-03-15 16:06:18'),
(4, 'http://192.168.1.107:8000/storage/membres/1710528901.png', 8, 'TADAHY', 'kenyo', '2001-12-24', 'Antalaha', '710011065269', 'Masculin', '0325471195', '0325471195', 0, '2024-01-23', 4, 3, 18, 4, 4, 'CU ANKATSO 2', 1, 0, 'Kennyo', '2024-03-15 15:55:01', '2024-03-15 16:01:04'),
(5, 'http://192.168.1.107:8000/storage/membres/1710529225.png', 9, 'Bezamany', 'Juvella', '2001-09-26', 'Antalaha', '710012065260', 'Feminin', '0325875796', '0325875796', 0, '2024-02-04', 2, 3, 14, 4, 2, 'CU Ambohipo Bloc 58 porte A1', 1, 0, 'Juvella Bezamany', '2024-03-15 16:00:25', '2024-03-15 16:00:25'),
(6, 'http://192.168.1.107:8000/storage/membres/1710529465.png', 10, 'Zara Fania', 'Anastazie', '1999-03-21', 'Antalaha', '710012059365', 'Feminin', '0322446415', '0322446415', 0, '2024-02-04', 1, 3, 19, 4, 3, '67 ha Sud', 1, 0, 'Daniah Munez', '2024-03-15 16:04:25', '2024-03-15 16:04:25'),
(7, 'http://192.168.1.107:8000/storage/membres/1710529725.png', 12, 'Bemaheva', 'Noelin Ferlys', '2004-12-25', 'Antalaha', '710011073436', 'Masculin', '0324094298', '0328921580', 0, '2024-02-04', 6, 3, 20, 2, 5, 'CU Ambolokandrina', 1, 0, 'Ferlys Smith', '2024-03-15 16:08:45', '2024-03-15 16:08:45'),
(8, 'http://192.168.1.107:8000/storage/membres/1710529965.png', 13, 'Rasolofoniaina', 'Ritchiano', '2001-12-21', 'Antalaha', '710011066340', 'Masculin', '0320448603', '0324930358', 0, '2024-02-04', 4, 3, 5, 2, 1, 'ANKATSO 2', 1, 0, 'Ritchiano', '2024-03-15 16:12:45', '2024-03-15 16:12:45'),
(9, 'http://192.168.1.107:8000/storage/membres/1710530201.png', 14, 'Botrazara', 'Emmanuel Joelardo', '1998-01-21', 'Antalaha', '710011059031', 'Masculin', '0329770870', '0329770870', 0, '2024-02-04', 2, 3, 21, 2, 4, 'Ambohipo Bloc 66 porte c2', 1, 0, 'Emmanuel Haris Joelardinho', '2024-03-15 16:16:41', '2024-03-15 16:16:41'),
(10, 'http://192.168.1.107:8000/storage/membres/1710530437.png', 15, 'Laivao', 'Samelos', '1999-11-25', 'Antalaha', '710011060283', 'Masculin', '0322876522', '0328276522', 0, '2024-02-04', 7, 3, 2, 1, 4, 'itaosy', 1, 0, 'Samelos Raguêt', '2024-03-15 16:20:37', '2024-03-15 16:20:37'),
(11, 'http://192.168.1.107:8000/storage/membres/1710530659.png', 17, 'Tovoniaina', 'Waximan Bienvenu Socé', '1992-10-16', 'Antalaha', '710011044722', 'Masculin', '0320493542', '0320493542', 0, '2024-02-04', 6, 3, 19, 1, 1, 'CU Ambolokandrina porte C3', 1, 0, 'Waximan Bienvenu Socé', '2024-03-15 16:24:19', '2024-03-15 16:24:19'),
(12, 'http://192.168.1.107:8000/storage/membres/1710530933.png', 31, 'Arison', 'Younes Adjey', '2002-03-22', 'Antalaha', '710011067165', 'Masculin', '0326751865', '0326751865', 0, '2024-03-15', 3, 3, 32, 2, 2, 'CU ANKATSO 1 bloc paradise porte 376', 1, 0, 'Younes Adjey', '2024-03-15 16:28:53', '2024-03-15 16:29:39'),
(13, 'http://192.168.1.107:8000/storage/membres/1710561403.png', 16, 'RAZANAMARIA', 'Tiana Adriane', '2004-12-17', 'Antalaha', '710012069110', 'Feminin', '0326414221', '0327732855', 0, '2024-02-04', 6, 6, 4, 2, 5, 'CU Ambolikandrina Bloc D1', 1, 0, 'R. Tiana Adriane', '2024-03-16 00:56:44', '2024-03-16 00:56:44'),
(14, 'http://192.168.1.107:8000/storage/membres/1710561829.png', 6, 'SIAKA', 'Doness', '1995-07-30', 'Antalaha', '710011041225', 'Masculin', '0324492020', '0326660334', 0, '2024-02-04', 4, 6, 17, 1, 5, 'Ankatso 2', 1, 0, 'Doness Masiaka', '2024-03-16 01:03:49', '2024-03-16 01:03:49'),
(15, 'http://192.168.1.107:8000/storage/membres/1710562302.png', 18, 'RASOA', 'Armela Baosampy', '1995-12-28', 'Antalaha', '103112017175', 'Feminin', '0329387618', '0340104148', 0, '2024-02-04', 4, 6, 3, 5, 1, 'CU Ankatso 2 Bloc 58 Porte 1C', 1, 0, 'Erm\'icka Ermy Guitt\'s', '2024-03-16 01:11:42', '2024-03-16 01:11:42'),
(16, 'http://192.168.1.107:8000/storage/membres/1710562520.png', 20, 'DAMIEN', 'RALAIMAROVITA', '1999-12-25', 'Ambodirafia', '710011069865', 'Masculin', '0329169131', '0329169131', 0, '2024-03-16', 4, 7, 22, 4, 4, 'Ambolikandrina', 1, 0, 'Damien Rochat', '2024-03-16 01:15:20', '2024-03-16 01:15:20'),
(17, 'http://192.168.1.107:8000/storage/membres/1710562867.png', 22, 'RAJOELINA', 'Tordella Emmanuella', '2004-04-06', 'Antalaha', '710012071996', 'Feminin', '0326689359', '0329770870', 0, '2024-02-24', 2, 8, 24, 4, 4, 'CU Ambohipo Bloc 66 Porte C2', 1, 0, 'Rajoelinirina Tordella béci', '2024-03-16 01:21:07', '2024-03-16 01:21:07'),
(18, 'http://192.168.1.107:8000/storage/membres/1710563206.png', 34, 'NIRINARISON', 'Andy Angelico', '1997-07-12', 'Tamatave', '710011056979', 'Masculin', '0328186380', '0320482624', 0, '2024-02-04', 4, 3, 3, 4, 3, 'CU Ankatso 2 Bloc Atelier Porte 6', 1, 0, 'Angelico NIRINARISON', '2024-03-16 01:26:46', '2024-03-16 01:26:46'),
(19, 'http://192.168.1.107:8000/storage/membres/1710563656.png', 35, 'VETY', 'Faniny Anaël', '1998-11-20', 'Antalaha', '710012056623', 'Feminin', '0328944466', '0320427008', 0, '2024-02-04', 2, 3, 33, 1, 5, 'Ambohipo', 1, 0, 'Anaël Betty', '2024-03-16 01:34:16', '2024-03-16 01:41:16'),
(20, 'http://192.168.1.107:8000/storage/membres/1710563930.png', 36, 'JAOTIANA', 'Jocylin', '1996-03-03', 'Antalaha', '710011054190', 'Masculin', '0320427008', '0320481463', 0, '2024-02-04', 2, 3, 25, 1, 4, 'Ambohipo Andohaniato', 1, 0, 'Jocy Jaotiana', '2024-03-16 01:38:50', '2024-03-16 01:41:35'),
(21, 'http://192.168.1.107:8000/storage/membres/1710565141.png', 38, 'BEZAFY', 'Danielle', '2000-12-04', 'Antalaha', '101232172520', 'Feminin', '0326077288', '0324721289', 0, '2024-02-04', 3, 3, 4, 2, 5, 'Ankatso I', 1, 0, 'Danï Chérie', '2024-03-16 01:59:02', '2024-03-16 01:59:02'),
(22, 'http://192.168.1.107:8000/storage/membres/1710565354.png', 40, 'TSIMAKOA', 'Emerencia Mbotihely', '2002-04-27', 'Antalaha', '710012066296', 'Feminin', '0323852694', '0329745967', 0, '2024-02-04', 3, 3, 5, 2, 5, 'CU Ankatso 1 Porte 16', 1, 0, 'Eme Rencia', '2024-03-16 02:02:34', '2024-03-16 02:02:34'),
(23, 'http://192.168.1.107:8000/storage/membres/1710565795.png', 41, 'ZARAVELO Marissa', 'Bachele Carolle', '2006-02-27', 'Antalaha', 'null', 'Feminin', '0327150763', '0320440349', 0, '2024-02-04', 5, 3, 3, 2, 5, 'Ambohimirary', 1, 0, 'chan Ley', '2024-03-16 02:09:55', '2024-03-16 02:09:55'),
(24, 'http://192.168.1.107:8000/storage/membres/1710566383.png', 42, 'KALO', 'Staelline', '1999-09-09', 'Antalaha', '710012060607', 'Feminin', '0326198299', '0326198299', 0, '2024-02-04', 3, 3, 25, 5, 4, 'CU Ankatso I Bloc Amitié Porte 174', 1, 0, 'Casmirah Zaza Gasy', '2024-03-16 02:19:43', '2024-03-16 02:19:43'),
(25, 'http://192.168.1.107:8000/storage/membres/1710566916.png', 44, 'BEVOAVY', 'Cecilio', '2002-04-26', 'Antalaha', '710011066030', 'Masculin', '0327170458', '0328669144', 0, '2024-02-04', 4, 3, 3, 2, 4, 'Lot VS 54 Ambolikandrina', 1, 0, 'Cecilio Froste Harden', '2024-03-16 02:28:36', '2024-03-16 02:28:36'),
(26, 'http://192.168.1.107:8000/storage/membres/1710567368.png', 45, 'RAZANABOLOLONA', 'Tiannà Maria', '2000-07-08', 'Antalaha', 'null', 'Feminin', '0329918973', '0324194837', 0, '2024-03-16', 1, 3, 25, 5, 6, 'Lot 153 à 67h Sud', 1, 0, 'Tianna Maria', '2024-03-16 02:36:08', '2024-03-16 02:36:08'),
(27, 'http://192.168.1.107:8000/storage/membres/1710568516.png', 46, 'RAVAO', 'NANDRASANA Angelinah', '2004-05-18', 'Mahafidinaha II', 'null', 'Feminin', '0321804986', '0321804986', 0, '2024-02-04', 1, 3, 2, 2, 5, '67h Nord', 1, 0, 'Angelinah Aslhey', '2024-03-16 02:55:16', '2024-03-16 02:55:16'),
(28, 'http://192.168.1.107:8000/storage/membres/1710568906.png', 47, 'DIMASY', 'Patanau Joëlot', '2006-04-15', 'Antalaha', 'null', 'Masculin', '0326953475', '0324089593', 0, '2024-02-04', 2, 3, 2, 2, 5, 'VT 85 UFX Andohanimandroseza', 1, 0, 'Patanau Roi', '2024-03-16 03:01:46', '2024-03-16 03:01:46'),
(29, 'http://192.168.1.107:8000/storage/membres/1710569394.png', 48, 'RASENDRA', 'Gilda Anthomiah', '1999-08-17', 'Marofinaritra', '710012059536', 'Feminin', '0323861310', '0328041443', 0, '2024-02-16', 8, 3, 2, 5, 3, 'Ivato', 1, 0, 'Julie dane rase', '2024-03-16 03:09:54', '2024-03-16 03:09:54'),
(30, 'http://192.168.1.107:8000/storage/membres/1710569719.png', 75, 'HERINIAINA', 'Marie Hannah', '1994-02-22', 'Sambava', '710012045786', 'Feminin', '0327418312', '0324061924', 0, '2024-03-11', 8, 3, 2, 2, 1, 'Ivato K2 014 Ter', 1, 0, 'Mane Hannah', '2024-03-16 03:15:19', '2024-03-16 03:15:19'),
(31, 'http://192.168.1.107:8000/storage/membres/1710569743.png', 74, 'Rafaliharimanana', 'Sodina Guino', '1998-11-06', 'Antalaha', '101221124198', 'Masculin', '0327462875', '0387169120', 0, '2024-03-07', 2, 3, 20, 5, 3, 'CU Ambohipo Bloc 66 porte D1', 1, 0, 'Guino Sodina', '2024-03-16 03:15:43', '2024-03-16 03:15:43'),
(32, 'http://192.168.1.107:8000/storage/membres/1710570095.png', 60, 'Riziky', 'Jeremie Luckaël', '1999-08-27', 'Antalaha', '710077060990', 'Masculin', '0327983386', '0327983386', 0, '2024-02-24', 3, 3, 3, 2, 2, 'CU ANKATSO 1 porte 389 Bloc Paradise', 1, 0, 'Iakov de Bossieu', '2024-03-16 03:21:35', '2024-03-16 03:22:07'),
(33, 'http://192.168.1.107:8000/storage/membres/1710570291.png', 61, 'Razafindranambo', 'Jean Maxelin', '1997-09-29', 'Antalaha', '710011057503', 'Masculin', '0322215327', '0325297940', 0, '2024-02-24', 4, 3, 1, 4, 1, 'ANKATSO 2 bloc 42 porte 6 c', 1, 0, 'Jean Maxelin', '2024-03-16 03:24:51', '2024-03-16 03:24:51');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `users_receive` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_users_id_foreign` (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_01_07_063903_create_sections_table', 1),
(6, '2024_01_13_023853_create_filieres_table', 1),
(7, '2024_01_13_023928_create_axes_table', 1),
(8, '2024_01_13_024022_create_levels_table', 1),
(9, '2024_01_13_024122_create_fonctions_table', 1),
(10, '2024_01_13_024248_create_membres_table', 1),
(11, '2024_01_13_025907_create_avis_table', 1),
(12, '2024_01_13_030038_create_posts_table', 1),
(13, '2024_01_13_030241_create_commentaires_table', 1),
(14, '2024_01_13_030430_create_likes_table', 1),
(15, '2024_01_13_030540_create_messages_table', 1),
(16, '2024_02_04_075931_create_post_images_table', 1);

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_general_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'ramananathumingthierry@gmail.com_Token', '8960857b597792c9f0b4b60323555ec5818dd6b3e42e5fad20e7f0c58fe4dfaf', '[\"*\"]', '2024-03-16 04:10:23', NULL, '2024-03-15 14:35:25', '2024-03-16 04:10:23'),
(2, 'App\\Models\\User', 1, 'ramananathumingthierry@gmail.com_Token', '631bf0344227243779841f96a420375f1c961da9bb542eb6933759a7398e39c2', '[\"*\"]', '2024-03-16 03:24:52', NULL, '2024-03-15 15:38:02', '2024-03-16 03:24:52');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_users_id_foreign` (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `post_images`
--

DROP TABLE IF EXISTS `post_images`;
CREATE TABLE IF NOT EXISTS `post_images` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id` bigint UNSIGNED NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_images_post_id_foreign` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sections`
--

DROP TABLE IF EXISTS `sections`;
CREATE TABLE IF NOT EXISTS `sections` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_sections` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sections`
--

INSERT INTO `sections` (`id`, `nom_sections`, `created_at`, `updated_at`) VALUES
(1, '67 h', '2024-03-15 17:43:50', '2024-03-15 17:43:50'),
(2, 'Ambohipo', '2024-03-15 18:44:12', '2024-03-15 18:44:12'),
(3, 'Ankatso I', '2024-03-15 18:44:33', '2024-03-15 18:44:33'),
(4, 'Ankatso II', '2024-03-15 18:44:33', '2024-03-15 18:44:33'),
(5, 'Centre Ville', '2024-03-15 18:46:36', '2024-03-15 18:46:36'),
(6, 'Ravitoto', '2024-03-15 18:46:36', '2024-03-15 18:46:36'),
(7, 'Itaosy', '2024-03-15 18:47:24', '2024-03-15 18:47:24'),
(8, 'Ivato', '2024-03-15 18:47:24', '2024-03-15 18:47:24'),
(9, 'Votovorona', '2024-03-15 18:49:39', '2024-03-15 18:49:39');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `roles` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Utilisateurs',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1: valide (True)  & 0 : Non autorisé (False)',
  `remember_token` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `image`, `contact`, `adresse`, `email`, `email_verified_at`, `mot_de_passe`, `roles`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'RAMANANA Thu Ming Thierry', NULL, '0327563770', 'VT 29 RAI BIS Ampahateza', 'ramananathumingthierry@gmail.com', NULL, '$2y$10$.LYvOwMRrJt88vIeXxPHge1olz785gtkR5ig8GCjRDETpe8ZQqVsm', 'Administrateurs', 1, NULL, '2024-03-15 14:35:25', '2024-03-15 14:35:25');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `axes`
--
ALTER TABLE `axes`
  ADD CONSTRAINT `axes_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commentaires_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `filieres`
--
ALTER TABLE `filieres`
  ADD CONSTRAINT `filieres_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `fonctions`
--
ALTER TABLE `fonctions`
  ADD CONSTRAINT `fonctions_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `levels`
--
ALTER TABLE `levels`
  ADD CONSTRAINT `levels_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `membres`
--
ALTER TABLE `membres`
  ADD CONSTRAINT `membres_axes_id_foreign` FOREIGN KEY (`axes_id`) REFERENCES `axes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `membres_filieres_id_foreign` FOREIGN KEY (`filieres_id`) REFERENCES `filieres` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `membres_fonctions_id_foreign` FOREIGN KEY (`fonctions_id`) REFERENCES `fonctions` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `membres_levels_id_foreign` FOREIGN KEY (`levels_id`) REFERENCES `levels` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `membres_sections_id_foreign` FOREIGN KEY (`sections_id`) REFERENCES `sections` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `membres_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `post_images`
--
ALTER TABLE `post_images`
  ADD CONSTRAINT `post_images_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
