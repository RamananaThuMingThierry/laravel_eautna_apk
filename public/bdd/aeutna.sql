-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 15 avr. 2024 à 13:07
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
-- Structure de la table `axes`
--

DROP TABLE IF EXISTS `axes`;
CREATE TABLE IF NOT EXISTS `axes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_axes` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `axes`
--

INSERT INTO `axes` (`id`, `nom_axes`, `created_at`, `updated_at`) VALUES
(1, 'Andrarony', '2024-04-09 05:11:33', '2024-04-09 05:11:33'),
(2, 'Ankavanana', '2024-04-09 05:11:40', '2024-04-09 05:11:40'),
(3, 'Andempona', '2024-04-09 05:11:48', '2024-04-09 05:11:48'),
(4, 'Centre ville', '2024-04-09 05:11:56', '2024-04-09 05:11:56'),
(5, 'Ankavia', '2024-04-09 05:12:09', '2024-04-09 05:12:09'),
(6, 'Cap-Est', '2024-04-09 05:12:18', '2024-04-09 05:12:18');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `filieres`
--

INSERT INTO `filieres` (`id`, `nom_filieres`, `created_at`, `updated_at`) VALUES
(1, 'Droit', '2024-04-09 05:13:45', '2024-04-09 05:13:45'),
(2, 'Informatique', '2024-04-09 05:13:53', '2024-04-09 05:13:53'),
(3, 'Gestion', '2024-04-09 05:14:03', '2024-04-09 05:14:03'),
(4, 'Anglais', '2024-04-09 05:14:09', '2024-04-09 05:14:09'),
(5, 'Français', '2024-04-09 05:14:17', '2024-04-09 05:14:17'),
(6, 'Sociologie', '2024-04-09 05:14:29', '2024-04-09 05:14:29'),
(7, 'Malagasy', '2024-04-09 05:17:23', '2024-04-09 05:17:23'),
(8, 'Géographie', '2024-04-09 05:17:29', '2024-04-09 05:17:42'),
(9, 'Génie Électrique', '2024-04-09 05:19:56', '2024-04-09 05:19:56'),
(10, 'Langue et culture chinoise', '2024-04-09 05:20:18', '2024-04-09 05:20:18'),
(11, 'Paramède', '2024-04-09 05:20:28', '2024-04-09 05:20:28'),
(12, 'Administration', '2024-04-09 05:20:45', '2024-04-09 05:20:45'),
(13, 'Economie', '2024-04-09 05:21:00', '2024-04-09 05:27:01'),
(14, 'Comptable', '2024-04-09 05:21:19', '2024-04-09 05:21:19'),
(15, 'Infermier Généraliste', '2024-04-09 05:23:07', '2024-04-09 05:23:07'),
(16, 'Génie Civil et Architecture', '2024-04-09 05:23:32', '2024-04-09 05:23:32'),
(17, 'Commerce et marketing', '2024-04-09 05:23:50', '2024-04-09 05:23:50'),
(18, 'STE', '2024-04-09 05:24:35', '2024-04-09 05:24:35'),
(19, 'Tourisme', '2024-04-09 05:24:48', '2024-04-09 05:24:48'),
(20, 'Tourisme et Hôtellerie', '2024-04-09 05:24:58', '2024-04-09 05:24:58'),
(21, 'Finance et comptable', '2024-04-09 05:25:20', '2024-04-09 05:25:20'),
(22, 'Commerce international', '2024-04-09 05:25:59', '2024-04-09 05:25:59'),
(23, 'Environnement', '2024-04-09 05:26:29', '2024-04-09 05:26:29'),
(24, 'Communication', '2024-04-09 05:27:26', '2024-04-09 05:27:26'),
(25, 'Banque', '2024-04-09 05:28:19', '2024-04-09 05:28:19'),
(26, 'Physique', '2024-04-09 05:28:42', '2024-04-09 05:28:42'),
(27, 'Chimie', '2024-04-09 05:28:56', '2024-04-09 05:28:56'),
(28, 'Médecine Humaine', '2024-04-09 05:30:36', '2024-04-09 05:32:09'),
(29, 'Anthropologie', '2024-04-09 05:31:45', '2024-04-09 05:31:45'),
(30, 'Management des organisations', '2024-04-09 05:32:52', '2024-04-09 05:32:52');

-- --------------------------------------------------------

--
-- Structure de la table `fonctions`
--

DROP TABLE IF EXISTS `fonctions`;
CREATE TABLE IF NOT EXISTS `fonctions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_fonctions` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `fonctions`
--

INSERT INTO `fonctions` (`id`, `nom_fonctions`, `created_at`, `updated_at`) VALUES
(1, 'Membre', '2024-04-09 05:33:07', '2024-04-09 05:33:07'),
(2, 'Président', '2024-04-09 05:33:16', '2024-04-09 05:33:16'),
(3, 'Vice Président', '2024-04-09 05:33:24', '2024-04-09 05:33:24'),
(4, 'Responsable Sport', '2024-04-09 05:33:36', '2024-04-09 05:33:36'),
(5, 'Communication', '2024-04-09 05:34:21', '2024-04-09 05:34:21'),
(6, 'Trésorier', '2024-04-09 05:35:23', '2024-04-09 05:35:23'),
(7, 'Commissaire au compte', '2024-04-09 05:35:33', '2024-04-09 05:35:33'),
(8, 'Bureau', '2024-04-15 02:29:00', '2024-04-15 02:29:00');

-- --------------------------------------------------------

--
-- Structure de la table `levels`
--

DROP TABLE IF EXISTS `levels`;
CREATE TABLE IF NOT EXISTS `levels` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_niveau` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `levels`
--

INSERT INTO `levels` (`id`, `nom_niveau`, `created_at`, `updated_at`) VALUES
(1, 'Licence 1', '2024-04-09 05:12:38', '2024-04-09 05:12:38'),
(2, 'Licence 2', '2024-04-09 05:12:45', '2024-04-09 05:12:45'),
(3, 'Licence 3', '2024-04-09 05:12:54', '2024-04-09 05:12:54'),
(4, 'Master 1', '2024-04-09 05:13:00', '2024-04-09 05:13:00'),
(5, 'Master 2', '2024-04-09 05:13:07', '2024-04-09 05:13:07');

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
  `lieu_de_naissance` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cin` varchar(12) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `genre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `etablissement` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_personnel` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `contact_tuteur` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `sympathisant` tinyint(1) NOT NULL,
  `date_inscription` date NOT NULL,
  `sections_id` bigint UNSIGNED NOT NULL,
  `fonctions_id` bigint UNSIGNED NOT NULL,
  `filieres_id` bigint UNSIGNED NOT NULL,
  `levels_id` bigint UNSIGNED NOT NULL,
  `axes_id` bigint UNSIGNED DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `membres_sections_id_foreign` (`sections_id`),
  KEY `membres_fonctions_id_foreign` (`fonctions_id`),
  KEY `membres_filieres_id_foreign` (`filieres_id`),
  KEY `membres_levels_id_foreign` (`levels_id`),
  KEY `membres_axes_id_foreign` (`axes_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`id`, `image`, `numero_carte`, `nom`, `prenom`, `date_de_naissance`, `lieu_de_naissance`, `cin`, `genre`, `etablissement`, `contact_personnel`, `contact_tuteur`, `sympathisant`, `date_inscription`, `sections_id`, `fonctions_id`, `filieres_id`, `levels_id`, `axes_id`, `adresse`, `facebook`, `created_at`, `updated_at`) VALUES
(1, 'http://192.168.1.107:8000/storage/membres/1713157226.png', 23, 'RAMANANA Thu Ming', 'Thierry', '1999-03-03', 'Antalaha', '710011057416', 'Masculin', 'ISPM', '0327563770', '0329790536', 0, '2024-02-24', 2, 5, 2, 5, 2, 'VT 29 RAI BIS Ampahateza', 'RAMANANA Thu Ming Thierry', '2024-04-15 02:00:27', '2024-04-15 02:00:27'),
(2, 'http://192.168.1.107:8000/storage/membres/1713158200.png', 4, 'ZAVALAHY', 'Johnny Keita', '1994-02-22', 'Vohemar', '303011018528', 'Masculin', 'Ankatso', '0327240254', '0328137227', 0, '2024-02-04', 2, 3, 6, 5, 4, 'CU Ambohipo Bloc 80 Porte C2', 'Keita Johnny', '2024-04-15 02:16:41', '2024-04-15 02:16:41'),
(3, 'http://192.168.1.107:8000/storage/membres/1713158507.png', 5, 'TOTOZAFY', 'Syndjico', '1999-08-15', 'Antalaha', '711991055398', 'Masculin', 'IFT', '0322533239', '0328092295', 0, '2024-04-15', 1, 3, 1, 5, 3, '1203 67h Nord-ouest', 'Syndjico TOTOZAFY', '2024-04-15 02:21:47', '2024-04-15 02:21:47'),
(4, 'http://192.168.1.107:8000/storage/membres/1713158816.png', 8, 'TADAHY', 'Kennyo', '2001-12-24', 'Antalaha', '710011065269', 'Masculin', NULL, '0325471195', '0325471195', 0, '2024-04-15', 4, 8, 10, 1, 1, 'CU ANKATSO Bloc Fanantenana', 'Kennyo', '2024-04-15 02:26:56', '2024-04-15 02:37:57'),
(5, 'http://192.168.1.107:8000/storage/membres/1713162778.png', 9, 'BEZAMANY', 'Juvella', '2001-09-26', 'Antalaha', '710012065260', 'Feminin', 'null', '0325875796', '0325875796', 0, '2024-02-04', 2, 1, 11, 3, 3, 'CU Ambohipo Bloc 58 Porte A1', 'Juvella Bezamany', '2024-04-15 03:32:59', '2024-04-15 03:32:59'),
(6, 'http://192.168.1.107:8000/storage/membres/1713163171.png', 10, 'ZARA Fania', 'Nastezie', '1999-03-21', 'Antalaha', '710012059365', 'Feminin', 'IMGAM', '0322446415', '0346536245', 0, '2024-04-15', 1, 1, 12, 3, 5, '67h Sud', 'Faniah Munez', '2024-04-15 03:39:31', '2024-04-15 03:39:31'),
(7, 'http://192.168.1.107:8000/storage/membres/1713163368.png', 12, 'BEMAHEVA', 'Noël in Ferlys', '2004-12-25', 'Antalaha', '710011073436', 'Masculin', 'Ankatso', '0324094298', '0328921550', 0, '2024-04-15', 6, 1, 13, 1, 4, 'CU Ambolikandrina', 'Ferlys Smith', '2024-04-15 03:42:48', '2024-04-15 03:42:48'),
(8, 'http://192.168.1.107:8000/storage/membres/1713163605.png', 13, 'RASOLOFONIAINA', 'Ritchiano', '2001-12-21', 'Antalaha', '710011066340', 'Masculin', 'LFC Madagascar', '0320448603', '0324930358', 0, '2024-04-15', 1, 1, 4, 1, 2, 'Ankatso II', 'Ritchiano', '2024-04-15 03:46:45', '2024-04-15 03:46:45'),
(9, 'http://192.168.1.107:8000/storage/membres/1713163782.png', 14, 'BOTRAZARA', 'Emmanuel Joelardo', '1998-01-21', 'Antalaha', '710011059031', 'Masculin', 'null', '0329770870', '0329770870', 0, '2024-04-15', 2, 1, 14, 1, 6, 'CU Ambohipo Bloc 66 Porte C2', 'Harris Joelardinho', '2024-04-15 03:49:42', '2024-04-15 03:50:22'),
(10, 'http://192.168.1.107:8000/storage/membres/1713164115.png', 15, 'LAIVAO', 'Samelos', '1999-11-25', 'Antalaha', '710011060283', 'Masculin', 'ISSMI', '0322876522', '0322876522', 0, '2024-04-15', 7, 8, 3, 5, 6, 'Itaosy', 'Samelos Ragûet', '2024-04-15 03:55:15', '2024-04-15 03:55:15'),
(11, 'http://192.168.1.107:8000/storage/membres/1713164366.png', 16, 'RAZANAMARIA', 'Tiana Adriana', '2004-12-17', 'Anatalaha', '710012069110', 'Feminin', 'Ankatso', '0326414221', '0327732855', 0, '2024-04-15', 6, 8, 1, 1, 6, 'CU Ambolikandrina Bloc 81', 'R. Tiana Adriana', '2024-04-15 03:59:26', '2024-04-15 03:59:26'),
(12, 'http://192.168.1.107:8000/storage/membres/1713167542.png', 92, 'TIAFINJARA Nirina', 'Joella', '1999-05-22', 'Befandriana', '710012057635', 'Feminin', 'CNTMAD', '0329790536', '0327563770', 0, '2024-04-15', 2, 1, 19, 4, 4, 'VT 29 RAI BIS Ampahateza', 'TNJ Nirina', '2024-04-15 04:52:22', '2024-04-15 04:52:22'),
(13, 'http://192.168.1.107:8000/storage/membres/1713168251.png', 17, 'TOVONIAINA WAXIMAN', 'Bienvenu Socé', '1992-10-16', 'Antalaha', '710011044722', 'Masculin', 'IMGAM', '0320493542', '0383072733', 0, '2024-04-15', 6, 8, 12, 5, 2, 'CU Ambolikandrina C3', 'Waximan Bienvenu Socé', '2024-04-15 05:04:11', '2024-04-15 05:04:11'),
(14, 'http://192.168.1.107:8000/storage/membres/1713168421.png', 21, 'Kenedy', NULL, '1995-09-29', 'Antalaha', NULL, 'Masculin', 'ISPM', '0326708281', '0326708281', 0, '2024-04-15', 4, 8, 16, 5, 6, 'Ankatso II Bloc Fanantenana Porte 15', 'Kennedy', '2024-04-15 05:07:01', '2024-04-15 05:07:01'),
(15, 'http://192.168.1.107:8000/storage/membres/1713168662.png', 31, 'ARISON', 'Younes Adjey', '2003-03-22', 'Antalaha', '710011067165', 'Masculin', 'ISPM', '0326751885', '0326751885', 0, '2024-04-15', 3, 1, 18, 2, 3, 'CU Ankatso I Bloc Paradasse Porte 376', 'Younes Adjey', '2024-04-15 05:11:02', '2024-04-15 05:11:02'),
(16, 'http://192.168.1.107:8000/storage/membres/1713181071.png', 34, 'NIRINARISON', 'Andy Angelico', '1997-07-12', 'Tamatave', '710011056979', 'Masculin', 'FPTSD', '0328186380', '0320482624', 0, '2024-04-15', 4, 1, 6, 3, 5, 'CU Ankatso II Bloc Atelier Porte 06', 'Angelico NIRINARISON', '2024-04-15 08:37:51', '2024-04-15 08:37:51'),
(17, 'http://192.168.1.107:8000/storage/membres/1713181566.png', 35, 'VETY Faniry', 'Anaël', '1998-11-20', 'Antalaha', '710012056623', 'Feminin', 'INTH', '0328944466', '0320427008', 0, '2024-04-15', 2, 1, 19, 5, 4, 'Ambohipo', 'Anaël Betty', '2024-04-15 08:46:06', '2024-04-15 08:46:06'),
(18, 'http://192.168.1.107:8000/storage/membres/1713182093.png', 36, 'JAOTIANA', 'Jocylin', '1996-03-03', 'Antalaha', '710011054190', 'Masculin', 'Université Privée Hay à 67h', '0320427008', '0328944466', 0, '2024-04-15', 2, 1, 21, 5, 5, 'Ambohipo Andohaniato', 'Jocy Jaotiana', '2024-04-15 08:54:53', '2024-04-15 08:54:53'),
(19, 'http://192.168.1.107:8000/storage/membres/1713182812.png', 44, 'BEVOAVY', 'Cecilio', '2002-04-27', 'Antalaha', '710011066030', 'Masculin', 'Ankatso', '0327170458', '0328669144', 0, '2024-04-15', 6, 1, 6, 1, 6, 'Lot VS 54 Ambolikandrina', 'Cecilio Froste Harden', '2024-04-15 09:06:52', '2024-04-15 09:06:52'),
(20, 'http://192.168.1.107:8000/storage/membres/1713183182.png', 46, 'RAVAO', 'NANDRASANA Angelinah', '2004-05-18', 'Mahafidinaha', 'null', 'Feminin', 'IMGAM', '0321804986', '0321804986', 0, '2024-04-15', 1, 1, 3, 1, 4, '67h Nord', 'Angelinah Ashley', '2024-04-15 09:13:02', '2024-04-15 09:13:02'),
(21, 'http://192.168.1.107:8000/storage/membres/1713184020.png', 47, 'DIMASY', 'Patanau Joëlot', '2006-05-15', 'Antalaha', 'null', 'Masculin', 'ACEEM', '0326953475', '0324089593', 0, '2024-04-15', 3, 1, 3, 1, 4, 'VT 85 Andohanimandroseza', 'Patanau Roi', '2024-04-15 09:27:00', '2024-04-15 09:27:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(10, '2024_01_13_024248_create_membres_table', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'ramananathumingthierry@gmail.com_Token', '35717ad2ba544f18be6e8cefc6da78b6a7b5844e3f0147f3e3ad62aa673d3e9d', '[\"*\"]', '2024-04-15 01:20:46', NULL, '2024-04-09 04:45:43', '2024-04-15 01:20:46'),
(2, 'App\\Models\\User', 1, 'ramananathumingthierry@gmail.com_Token', '4b69633967139ecbed74dbd444f4071e95242dd12b37032a6d9d5a149e6c72ee', '[\"*\"]', '2024-04-15 00:38:15', NULL, '2024-04-15 00:31:23', '2024-04-15 00:38:15'),
(3, 'App\\Models\\User', 1, 'ramananathumingthierry@gmail.com_Token', '6f399b0326da29eacd245282a6a6b1644f7b833fe781749e1b91b0aa54e71196', '[\"*\"]', '2024-04-15 02:38:01', NULL, '2024-04-15 01:28:35', '2024-04-15 02:38:01'),
(4, 'App\\Models\\User', 2, 'tiafinjaran@gmail.com_Token', '54bed027714edbcaf805dfa3451ce0b8149218e055d3b0986ea8b47da9e7117a', '[\"*\"]', NULL, NULL, '2024-04-15 02:39:29', '2024-04-15 02:39:29'),
(5, 'App\\Models\\User', 1, 'ramananathumingthierry@gmail.com_Token', 'e60fcb9daed7cd0a0166704674ff4d35d660037e96dfb1fefad340b846407dda', '[\"*\"]', '2024-04-15 02:59:36', NULL, '2024-04-15 02:39:54', '2024-04-15 02:59:36'),
(6, 'App\\Models\\User', 2, 'tiafinjaran@gmail.com_Token', '3eeab7585224b0bfc63fb55710c5fd0b203ca23d091e7c6013c3666ada6b5d8b', '[\"*\"]', '2024-04-15 03:04:39', NULL, '2024-04-15 03:00:10', '2024-04-15 03:04:39'),
(7, 'App\\Models\\User', 1, 'ramananathumingthierry@gmail.com_Token', '44d10b03af097bbbdc999175d0ce5794a7217b094f3d46dd1f037e4c0d2f7bc2', '[\"*\"]', '2024-04-15 03:59:27', NULL, '2024-04-15 03:05:46', '2024-04-15 03:59:27'),
(8, 'App\\Models\\User', 1, 'ramananathumingthierry@gmail.com_Token', '60fd5e99670beb7b5ec3c4e5b28872f59c26efc11990b3c73b9ab43f14295156', '[\"*\"]', NULL, NULL, '2024-04-15 03:59:57', '2024-04-15 03:59:57'),
(9, 'App\\Models\\User', 2, 'tiafinjaran@gmail.com_Token', 'a078ad6425632db811a8715cb1c8e3099f806d5642846c4b3089916aa04c0247', '[\"*\"]', '2024-04-15 04:24:36', NULL, '2024-04-15 04:00:16', '2024-04-15 04:24:36'),
(10, 'App\\Models\\User', 1, 'ramananathumingthierry@gmail.com_Token', 'b967217f4711a7f8dddb678001212bf967ae87b14549f1f9d2e1283b389fe50a', '[\"*\"]', '2024-04-15 06:36:46', NULL, '2024-04-15 04:47:18', '2024-04-15 06:36:46'),
(11, 'App\\Models\\User', 1, 'ramananathumingthierry@gmail.com_Token', 'c3779d4e97019d43282907ce64974254bca43c81c02ac66c2cc39e6d6128efbf', '[\"*\"]', '2024-04-15 06:55:39', NULL, '2024-04-15 06:37:07', '2024-04-15 06:55:39'),
(12, 'App\\Models\\User', 1, 'ramananathumingthierry@gmail.com_Token', '0ffc76bd030595fa3ad45718e54b04badfae4883e5fe47b1c107c312d16a104c', '[\"*\"]', '2024-04-15 08:26:02', NULL, '2024-04-15 08:25:32', '2024-04-15 08:26:02'),
(13, 'App\\Models\\User', 1, 'ramananathumingthierry@gmail.com_Token', 'b66a2fc6a9df94ca86bea25b9183b0aaa95968581e2b24c3b9d6478f81e610ff', '[\"*\"]', '2024-04-15 09:48:04', NULL, '2024-04-15 08:30:05', '2024-04-15 09:48:04'),
(14, 'App\\Models\\User', 1, 'ramananathumingthierry@gmail.com_Token', 'f3e9c8e8e8f7b64f0821f031e9722a6d9a7c6dbd15e8c7b2fd210978e65f47c9', '[\"*\"]', NULL, NULL, '2024-04-15 10:00:52', '2024-04-15 10:00:52');

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
(1, '67 h', '2024-04-09 07:48:43', '2024-04-09 07:48:43'),
(2, 'Ambohipo', '2024-04-09 07:48:43', '2024-04-09 07:48:43'),
(3, 'Ankatso I', '2024-04-09 07:48:43', '2024-04-09 07:48:43'),
(4, 'Ankatso II', '2024-04-09 07:48:43', '2024-04-09 07:48:43'),
(5, 'Centre Ville', '2024-04-09 07:48:43', '2024-04-09 07:48:43'),
(6, 'Ravitoto', '2024-04-09 07:48:43', '2024-04-09 07:48:43'),
(7, 'Itaosy', '2024-04-09 07:48:43', '2024-04-09 07:48:43'),
(8, 'Ivato', '2024-04-09 07:48:43', '2024-04-09 07:48:43'),
(9, 'Votovorona', '2024-04-09 07:48:43', '2024-04-09 07:48:43');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `image`, `contact`, `adresse`, `email`, `email_verified_at`, `mot_de_passe`, `roles`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'RAMANANA Thu Ming Thierry', 'http://192.168.1.107:8000/storage/users/1713156723.png', '0327563770', 'VT 29 RAI BIS Ampahateza', 'ramananathumingthierry@gmail.com', NULL, '$2y$10$XkEWGeO.ab8Kxqr0EJJz..lXegOSvmlomn/4/x7pK55XNMoJQwTDC', 'Administrateurs', 1, NULL, '2024-04-09 04:45:43', '2024-04-15 10:00:41'),
(2, 'TIAFINJARA Nirina Joella', 'http://192.168.1.107:8000/storage/users/1713160857.png', '0329790536', 'VT 29 RAI BIS Ampahateza', 'tiafinjaran@gmail.com', NULL, '$2y$10$6WjItzXTxJtjzfOa7gn6AuoYV5WWTrt0jdGQcA3o0PosUiL3oBv/2', 'Utilisateurs', 1, NULL, '2024-04-15 02:39:29', '2024-04-15 03:00:57');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `membres`
--
ALTER TABLE `membres`
  ADD CONSTRAINT `membres_axes_id_foreign` FOREIGN KEY (`axes_id`) REFERENCES `axes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `membres_filieres_id_foreign` FOREIGN KEY (`filieres_id`) REFERENCES `filieres` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `membres_fonctions_id_foreign` FOREIGN KEY (`fonctions_id`) REFERENCES `fonctions` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `membres_levels_id_foreign` FOREIGN KEY (`levels_id`) REFERENCES `levels` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `membres_sections_id_foreign` FOREIGN KEY (`sections_id`) REFERENCES `sections` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
