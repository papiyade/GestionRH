-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 14 juil. 2025 à 19:51
-- Version du serveur : 11.6.2-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet-rh`
--

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_exemple9@example.com|127.0.0.1', 'i:1;', 1751556064),
('laravel_cache_exemple9@example.com|127.0.0.1:timer', 'i:1751556064;', 1751556064),
('laravel_cache_malickwane26@gmail.com|127.0.0.1', 'i:1;', 1752100330),
('laravel_cache_malickwane26@gmail.com|127.0.0.1:timer', 'i:1752100329;', 1752100329);

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `candidatures`
--

CREATE TABLE `candidatures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_offer_id` bigint(20) UNSIGNED NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `cv_path` varchar(255) NOT NULL,
  `lettre_path` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `disponibilite` varchar(255) DEFAULT NULL,
  `pretention` varchar(255) DEFAULT NULL,
  `status_demande` varchar(255) NOT NULL DEFAULT 'En attente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `candidatures`
--

INSERT INTO `candidatures` (`id`, `job_offer_id`, `prenom`, `nom`, `email`, `telephone`, `linkedin`, `cv_path`, `lettre_path`, `message`, `disponibilite`, `pretention`, `status_demande`, `created_at`, `updated_at`) VALUES
(1, 3, 'example', 'e', 'exemple@gmail.com', '77777777', 'google.com', 'cvs/vIZ1GvUZuRnvobMbyaB7r9VRJiTCbQoWb3QnG3Bt.pdf', NULL, 'tt', 'Immédiate', '50', 'rejete', '2025-07-01 22:21:38', '2025-07-02 21:16:19'),
(2, 3, 'example', 'test', 'exemple@gmail.com', '77777777', NULL, 'cvs/tUIVz3L9dCWTKCvWgDC9KsV6aTHMFBnZqKiU9rDW.pdf', NULL, NULL, 'À négocier', '500000', 'En attente', '2025-07-03 15:32:39', '2025-07-03 15:32:39'),
(3, 3, 'malick', 'wane', 'malickwane26@gmail.com', '77777777', NULL, 'cvs/e98AtuKDYoF08wtbUmwpBh6yCYoEWhzvsg67SjN3.pdf', NULL, 'message', 'Immédiate', '500000', 'En attente', '2025-07-08 00:03:47', '2025-07-08 00:03:47');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `task_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `content`, `task_id`, `user_id`, `project_id`, `created_at`, `updated_at`) VALUES
(1, 'test', NULL, 17, 1, '2025-07-10 23:53:30', '2025-07-10 23:53:30');

-- --------------------------------------------------------

--
-- Structure de la table `employee_details`
--

CREATE TABLE `employee_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `matricule` varchar(255) NOT NULL,
  `salaire` decimal(10,2) DEFAULT NULL,
  `type_contrat` varchar(255) DEFAULT NULL,
  `description_poste` text DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `statut_employe` varchar(255) NOT NULL DEFAULT 'actif',
  `genre` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `nationalite` varchar(255) DEFAULT NULL,
  `niveau_etude` varchar(255) DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `employee_details`
--

INSERT INTO `employee_details` (`id`, `user_id`, `matricule`, `salaire`, `type_contrat`, `description_poste`, `date_naissance`, `date_debut`, `date_fin`, `adresse`, `telephone`, `statut_employe`, `genre`, `ville`, `nationalite`, `niveau_etude`, `experience`, `created_at`, `updated_at`) VALUES
(1, 9, '1234567', 250000.00, 'CDD', 'qqqqqqqqqqqqqqqqqqqqq', '1997-01-28', '2025-06-02', '2028-01-28', 'dalifort', '77 777 77 77', 'actif', NULL, NULL, NULL, NULL, NULL, '2025-06-28 01:59:20', '2025-06-28 01:59:20'),
(2, 7, '12345671', 50000.00, 'CDI', 'p', '2025-07-01', '2025-07-17', '2025-07-30', 'dalifort', NULL, 'actif', NULL, NULL, NULL, NULL, NULL, '2025-07-07 23:08:20', '2025-07-07 23:08:20');

-- --------------------------------------------------------

--
-- Structure de la table `employee_documents`
--

CREATE TABLE `employee_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type_document` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `employee_documents`
--

INSERT INTO `employee_documents` (`id`, `user_id`, `type_document`, `file_path`, `created_at`, `updated_at`) VALUES
(1, 9, 'CV', 'documents/L58ZTxMtnhjRQUb246NSafEMEdLe2RJyEq0EkZM7.png', '2025-06-28 02:09:56', '2025-06-28 02:09:56');

-- --------------------------------------------------------

--
-- Structure de la table `entreprises`
--

CREATE TABLE `entreprises` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `entreprise_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_actif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `entreprises`
--

INSERT INTO `entreprises` (`id`, `id_user`, `logo_path`, `adresse`, `entreprise_name`, `email`, `description`, `is_actif`, `created_at`, `updated_at`) VALUES
(1, 3, 'logos/U0gaczjyrm1uA5LzX1wxDdSSr4WDtsOSLayulz9x.png', 'Grand Yoff', 'WMA', 'wma@example.com', 'Entreprise de solution informatique xxx cxx cree a dakar le xxxx xx xx etc', 1, '2025-06-16 13:10:30', '2025-06-16 13:10:30'),
(2, 3, 'logos/dQFk2kHQzv48eDjzeUAerwVVeyxeBYrLW1x0Y4wB.png', 'Grand Yoff', 'WMA', 'wma@example.com', 'Entreprise de solution informatique xxx cxx cree a dakar le xxxx xx xx etc', 1, '2025-06-16 13:25:41', '2025-06-16 13:25:41'),
(3, 3, 'logos/T49reG1HA73CBBRIswZmh2VjXFxa9sta37wSV2tv.png', 'Grand Yoff', 'WMA', 'wma@example.com', 'papapaapapap', 1, '2025-06-16 13:32:40', '2025-06-16 13:32:40'),
(4, 3, 'logos/C1ihWdPNcfQdUSDLPXycSH3m2fS6bYxy7HbcEEEv.png', 'Grand Yoff', 'WMA', 'exemple1@gmail.com', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 1, '2025-06-16 13:53:38', '2025-06-16 13:53:38'),
(5, 5, 'logos/Xh0N2cScpH5gxTfarz5vnLYLlEI31SQvu1VDccEF.png', 'Grand Yoff', 'WMA', 'wma@example.com', 'informatique', 1, '2025-06-16 21:39:53', '2025-06-16 21:39:53'),
(6, 10, 'logos/LwKkkCn5M6sMqc72YGA044iqrn5ladVOVeEoZMSD.jpg', 'Grand Yoff', 'test', 'entreprise@gmail.com', 'test description', 1, '2025-07-03 15:19:18', '2025-07-03 15:19:18'),
(7, 12, 'logos/ImbF3VUBifG1RXVnRjnOJePn4uYkQ9m1usUujsbg.jpg', 'dalifort', 'wma test', 'entreprise@gmail.com', 'bb', 0, '2025-07-04 19:11:56', '2025-07-07 20:29:33'),
(8, 14, 'logos/Re3nJddCIq9wUez1CKn14YsTLXSeBIGtbyQhQAVC.png', 'grand yoff', 'ma wma', 'wma2@gmail.com', 'test', 1, '2025-07-07 23:46:49', '2025-07-07 23:46:49');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `files`
--

CREATE TABLE `files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `task_id` bigint(20) UNSIGNED DEFAULT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `files`
--

INSERT INTO `files` (`id`, `file_name`, `file_path`, `task_id`, `project_id`, `created_at`, `updated_at`) VALUES
(1, 'test.pdf', 'project_files/T1RjUYwQt5LKkHrdaKuiLw3mFbx4cJP1kie7JoQG.pdf', NULL, 1, '2025-07-10 23:45:58', '2025-07-10 23:45:58');

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_offers`
--

CREATE TABLE `job_offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `entreprise_id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `equipe` varchar(255) NOT NULL,
  `secteur` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `type_contrat` varchar(255) NOT NULL,
  `date_limite` date NOT NULL,
  `salaire` int(11) DEFAULT NULL,
  `devise` varchar(255) DEFAULT NULL,
  `periode_salaire` varchar(255) DEFAULT NULL,
  `experience_requise` varchar(255) NOT NULL,
  `statut` varchar(255) NOT NULL,
  `teletravail` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `job_offers`
--

INSERT INTO `job_offers` (`id`, `entreprise_id`, `titre`, `equipe`, `secteur`, `description`, `type_contrat`, `date_limite`, `salaire`, `devise`, `periode_salaire`, `experience_requise`, `statut`, `teletravail`, `created_at`, `updated_at`) VALUES
(2, 5, 'dev full stack', 'it', 'Informatique', 'test description', 'CDI', '2025-07-26', 350000, 'XOF', 'monthly', 'Non spécifiée', 'En cours', 1, '2025-07-01 00:25:15', '2025-07-01 00:25:15'),
(3, 5, 'dev full stack edit', 'it edit', 'Informatique', 'test devise edit', 'Stage', '2025-07-06', 60000, 'EUR', 'annual', '3-5 ans', 'En cours', 1, '2025-07-01 00:28:47', '2025-07-01 01:17:51'),
(4, 7, 'dev full stack', 'it', 'Informatique', 'test', 'CDI', '2025-07-12', 50000, 'XOF', 'monthly', '1-3 ans', 'En cours', 1, '2025-07-04 20:12:36', '2025-07-04 20:12:36');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_12_235151_create_entreprises_table', 2),
(5, '2025_06_16_154156_add_entreprise_id_to_users_table', 3),
(6, '2025_06_19_001549_create_teams_table', 4),
(7, '2025_06_19_010444_create_team_user_table', 5),
(8, '2025_06_28_005149_create_employee_details_table', 6),
(9, '2025_06_28_020338_create_employee_documents_table', 7),
(10, '2025_06_30_231940_create_job_offers_table', 8),
(11, '2025_07_01_215516_create_candidatures_table', 9),
(12, '2025_07_01_222100_add_timestamps_to_candidatures_table', 10),
(13, '2025_07_09_194613_create_projects_table', 11),
(15, '2025_07_09_214310_create_tasks_table', 12),
(16, '2025_07_09_224649_create_comments_table', 13),
(17, '2025_07_09_225413_create_files_table', 14),
(18, '2025_07_09_230528_create_files_table', 15),
(19, '2025_07_10_222156_create_project_user_table', 16),
(20, '2025_07_10_234451_make_task_id_nullable_in_files_table', 17),
(21, '2025_07_10_235101_create_task_user_table', 18);

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('not_started','in_progress','completed') NOT NULL DEFAULT 'not_started',
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `entreprise_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `status`, `team_id`, `entreprise_id`, `created_at`, `updated_at`) VALUES
(1, 'test non debute', 'test description non debute', 'not_started', 4, 6, '2025-07-09 21:22:09', '2025-07-09 21:22:09'),
(2, 'test en cours', 'test en cours', 'in_progress', 4, 6, '2025-07-09 21:34:44', '2025-07-09 21:34:44'),
(3, 'test terminer', 'test terminer', 'completed', 4, 6, '2025-07-09 21:36:49', '2025-07-09 21:36:49'),
(4, 'test non debute', 'malick', 'not_started', 4, 6, '2025-07-11 20:17:06', '2025-07-11 20:17:06');

-- --------------------------------------------------------

--
-- Structure de la table `project_user`
--

CREATE TABLE `project_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `is_lead` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `project_user`
--

INSERT INTO `project_user` (`id`, `project_id`, `user_id`, `is_lead`, `created_at`, `updated_at`) VALUES
(2, 1, 11, 0, NULL, '2025-07-11 20:20:54');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('tFvXVbAnOKVjg7L8GbCdCimiLbP18ZXmdbfGZu12', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYXJ4R2JrZ1hIUTVOSERraFVFaldOcUZpSUw4ZXpXYUZtOHpSWVVqOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1752185269),
('vOzVXGptXoBD0nXj1Xtt59lM52WtbZcp43xtUh6o', 17, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWUVsSWFtcWxESFdoN0lhWDVtTWF0RlppRWlLcHdCTGJkallSd2pUTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9qZWN0cy8xIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTc7fQ==', 1752265255),
('ZYbHa6RZ3CGfneQdoJlckzBSUq1MNrVT6P6RtFVs', 17, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiemE2d3hPdXlPbjJoRFJQWExNVWZJbHlJeUN0RHpXZzFzV3ZBT2tYYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVmLXByb2pldC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNzt9', 1752192511);

-- --------------------------------------------------------

--
-- Structure de la table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `priority` enum('low','medium','high') NOT NULL DEFAULT 'medium',
  `status` enum('not_started','in_progress','completed') NOT NULL DEFAULT 'not_started',
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `deadline` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `priority`, `status`, `project_id`, `deadline`, `created_at`, `updated_at`) VALUES
(1, 'test', 'test', 'low', 'not_started', 1, '2025-07-10 02:47:00', '2025-07-10 23:47:58', '2025-07-10 23:47:58');

-- --------------------------------------------------------

--
-- Structure de la table `task_user`
--

CREATE TABLE `task_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `task_user`
--

INSERT INTO `task_user` (`id`, `task_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 11, '2025-07-10 23:53:59', '2025-07-10 23:53:59');

-- --------------------------------------------------------

--
-- Structure de la table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `entreprise_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `teams`
--

INSERT INTO `teams` (`id`, `name`, `description`, `owner_id`, `entreprise_id`, `created_at`, `updated_at`) VALUES
(1, 'team1', 'test team one', 6, 1, '2025-06-19 01:02:05', '2025-06-19 01:02:05'),
(2, 'test2', 'test team', 6, 1, '2025-06-19 01:08:26', '2025-06-19 01:31:06'),
(3, 'test 3', 'marketing', 7, 5, '2025-07-02 21:12:57', '2025-07-02 21:12:57'),
(4, 'team it', 'tout ce qui est informatique', 11, 6, '2025-07-03 15:23:43', '2025-07-03 15:23:43');

-- --------------------------------------------------------

--
-- Structure de la table `team_user`
--

CREATE TABLE `team_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `team_user`
--

INSERT INTO `team_user` (`id`, `team_id`, `role`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 1, 'employe', 9, NULL, NULL),
(4, 3, 'employe', 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `entreprise_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'super_admin',
  `telephone` varchar(255) DEFAULT NULL,
  `workstatus` tinyint(1) NOT NULL DEFAULT 1,
  `photo_profile_path` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `entreprise_id`, `name`, `email`, `email_verified_at`, `password`, `role`, `telephone`, `workstatus`, `photo_profile_path`, `remember_token`, `created_at`, `updated_at`, `last_login_at`) VALUES
(1, NULL, 'exemple', 'exemple@gmail.com', NULL, '$2y$12$vKv2sbRJjSwiAjJ.fJO52ecED/r4ElEHvCGlrqrCYQPM6ey43ISwO', 'super_admin', NULL, 1, NULL, NULL, '2025-06-12 14:11:25', '2025-07-07 23:36:09', '2025-07-07 23:36:09'),
(2, NULL, 'exemple1', 'exemple1@gmail.com', NULL, '$2y$12$IvYWsy5W5kM33dG5MK/o4uXCA1Vidz0B0/jt.DFrEbThyPCP7XvSe', 'admin', '777777777', 1, NULL, NULL, '2025-06-12 14:50:32', '2025-06-16 13:31:28', '2025-06-16 13:31:28'),
(3, NULL, 'exemple2', 'exemple2@gmail.com', NULL, '$2y$12$M3.sJAIckD2Rnt3LOyt8ReW/ruA96C8nbPEac9fqBGdhxrvyPvSAi', 'admin', '777777777', 1, NULL, NULL, '2025-06-12 15:56:14', '2025-06-18 23:27:31', '2025-06-18 23:27:31'),
(4, NULL, 'exemple3', 'exemple3@gmail.com', NULL, '$2y$12$9r5p4mZ/xtT9cWA4jcKJmesNkkI83Uvk74.VTM4.wxZuH/abcruVe', 'admin', '777777777', 1, NULL, NULL, '2025-06-12 15:58:21', '2025-06-16 20:13:29', '2025-06-16 20:13:29'),
(5, NULL, 'exemple4', 'exemple4@gmail.com', NULL, '$2y$12$bzoveycJx81dJ3g1/WgfJeYOh95BAv1.m8PzjIrzQZL5KYa1wOmBy', 'admin', '777777777', 1, NULL, NULL, '2025-06-12 15:59:29', '2025-06-16 20:14:28', '2025-06-16 20:14:28'),
(6, 1, 'exemple5', 'exemple5@gmail.com', NULL, '$2y$12$j6IYbfUaR66cqRaHwNnEnOCAengiuZuLtchsaG4ExWjWeW6usF5Oi', 'rh', '777777777', 1, NULL, NULL, '2025-06-16 16:49:26', '2025-07-01 20:34:12', '2025-07-01 20:34:12'),
(7, 5, 'exemple6', 'exemple6@gmail.com', NULL, '$2y$12$UUpBJMvMiWDdIJxOI6gfd.g9wZoy7AVl7v5/mGrKS33kZxlwvNa2y', 'rh', '777777777', 1, NULL, NULL, '2025-06-16 21:44:48', '2025-07-07 22:48:21', '2025-07-07 22:48:21'),
(8, 1, 'exemple7', 'exemple7@gmail.com', NULL, '$2y$12$CoKaoAo3OlbSPKWYex8Xu.W.LwN.8lTLJPL2lMMPyFZfc5vj6ZoOq', 'super_admin', '777777777', 1, NULL, NULL, '2025-06-28 00:11:17', '2025-06-28 00:11:17', NULL),
(9, 1, 'exemple8', 'exemple8@gmail.com', NULL, '$2y$12$dNmrfQcUj6NQrmZDlNSTY.GxJe2XbMoJbZBSAfFex2r1V1hSTw1QC', 'employe', NULL, 1, NULL, NULL, '2025-06-28 00:16:01', '2025-06-28 00:16:01', NULL),
(10, NULL, 'exemple9', 'exemple9@gmail.com', NULL, '$2y$12$4ZCaZmbPfQWbyJyaPi/OcejwAW7BY0u41z6fcLhbaSxEc.rI8rr1u', 'admin', '77 777 77 77', 1, NULL, NULL, '2025-07-03 14:55:57', '2025-07-09 20:54:00', '2025-07-09 20:54:00'),
(11, 6, 'exemple10', 'exemple10@gmail.com', NULL, '$2y$12$yHo6zSBsSupVhmQxI79dGuTNRxC9KjY5ZKWRRnIqamX3X5HlHOClO', 'rh', NULL, 1, NULL, NULL, '2025-07-03 15:22:14', '2025-07-09 21:09:03', '2025-07-09 21:09:03'),
(12, 7, 'exemple11', 'exemple11@gmail.com', NULL, '$2y$12$f9oJLKmOIKgUHZ.1WikkU.eXBhHKEwpBOionpqSMPCDf6tvrDldpq', 'admin', '77777777', 1, NULL, NULL, '2025-07-04 18:47:56', '2025-07-04 19:54:55', '2025-07-04 19:54:55'),
(13, 7, 'exemple', 'test@gmail.com', NULL, '$2y$12$hIOeM/sANP0Pm1UnlxM7feFV8T2BY8NS9C904B/HZMS7VZDHgfdOy', 'rh', '77777777', 1, NULL, NULL, '2025-07-04 20:01:47', '2025-07-04 20:08:10', '2025-07-04 20:08:10'),
(14, 8, 'malick', 'malickwane@gmail.com', NULL, '$2y$12$/Lgb4taDVIfaHxDoTyEsmON.Rw1I7n9CLZ/fhF5CqckV6LNtMW3hi', 'admin', '77777777', 1, NULL, NULL, '2025-07-07 23:36:46', '2025-07-07 23:46:49', '2025-07-07 23:42:48'),
(15, 8, 'malick', 'rh@gmail.com', NULL, '$2y$12$NVVMOull3/7v9J7165MPm.IKpzMiS39DyA9A2YdwTMRYXJAq97OOm', 'rh', '77777777', 1, NULL, NULL, '2025-07-07 23:48:17', '2025-07-07 23:48:17', NULL),
(16, 8, 'malick', 'malickwane26@gmail.com', NULL, '$2y$12$YZOfE5eRyPk7.eb0Lw.sQOMpaMLo8fqzlivedKxlZefDMC3dpGteG', 'rh', '777777777', 1, NULL, NULL, '2025-07-07 23:51:06', '2025-07-07 23:51:06', NULL),
(17, 6, 'chef de projet', 'chefprojet@gmail.com', NULL, '$2y$12$nyvIWO20ehDUcn1a/NOBf.1dDRL4h2ujvy4Ehs1JY.469WONw4wW6', 'chef_projet', '77777777', 1, NULL, NULL, '2025-07-09 20:56:11', '2025-07-11 20:14:05', '2025-07-11 20:14:05');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `candidatures`
--
ALTER TABLE `candidatures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidatures_job_offer_id_foreign` (`job_offer_id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_task_id_foreign` (`task_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_project_id_foreign` (`project_id`);

--
-- Index pour la table `employee_details`
--
ALTER TABLE `employee_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_details_matricule_unique` (`matricule`),
  ADD KEY `employee_details_user_id_foreign` (`user_id`);

--
-- Index pour la table `employee_documents`
--
ALTER TABLE `employee_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_documents_user_id_foreign` (`user_id`);

--
-- Index pour la table `entreprises`
--
ALTER TABLE `entreprises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entreprises_id_user_foreign` (`id_user`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `files_task_id_foreign` (`task_id`),
  ADD KEY `files_project_id_foreign` (`project_id`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `job_offers`
--
ALTER TABLE `job_offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_offers_entreprise_id_foreign` (`entreprise_id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_team_id_foreign` (`team_id`),
  ADD KEY `projects_entreprise_id_foreign` (`entreprise_id`);

--
-- Index pour la table `project_user`
--
ALTER TABLE `project_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_user_project_id_user_id_unique` (`project_id`,`user_id`),
  ADD KEY `project_user_user_id_foreign` (`user_id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_project_id_foreign` (`project_id`);

--
-- Index pour la table `task_user`
--
ALTER TABLE `task_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_user_task_id_foreign` (`task_id`),
  ADD KEY `task_user_user_id_foreign` (`user_id`);

--
-- Index pour la table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teams_entreprise_id_foreign` (`entreprise_id`),
  ADD KEY `teams_owner_id_foreign` (`owner_id`);

--
-- Index pour la table `team_user`
--
ALTER TABLE `team_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_user_team_id_foreign` (`team_id`),
  ADD KEY `team_user_user_id_foreign` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_entreprise_id_foreign` (`entreprise_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `candidatures`
--
ALTER TABLE `candidatures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `employee_details`
--
ALTER TABLE `employee_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `employee_documents`
--
ALTER TABLE `employee_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `entreprises`
--
ALTER TABLE `entreprises`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `files`
--
ALTER TABLE `files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `job_offers`
--
ALTER TABLE `job_offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `project_user`
--
ALTER TABLE `project_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `task_user`
--
ALTER TABLE `task_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `team_user`
--
ALTER TABLE `team_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `candidatures`
--
ALTER TABLE `candidatures`
  ADD CONSTRAINT `candidatures_job_offer_id_foreign` FOREIGN KEY (`job_offer_id`) REFERENCES `job_offers` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `employee_details`
--
ALTER TABLE `employee_details`
  ADD CONSTRAINT `employee_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `employee_documents`
--
ALTER TABLE `employee_documents`
  ADD CONSTRAINT `employee_documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `entreprises`
--
ALTER TABLE `entreprises`
  ADD CONSTRAINT `entreprises_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `files_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `job_offers`
--
ALTER TABLE `job_offers`
  ADD CONSTRAINT `job_offers_entreprise_id_foreign` FOREIGN KEY (`entreprise_id`) REFERENCES `entreprises` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_entreprise_id_foreign` FOREIGN KEY (`entreprise_id`) REFERENCES `entreprises` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `projects_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `project_user`
--
ALTER TABLE `project_user`
  ADD CONSTRAINT `project_user_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `task_user`
--
ALTER TABLE `task_user`
  ADD CONSTRAINT `task_user_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_entreprise_id_foreign` FOREIGN KEY (`entreprise_id`) REFERENCES `entreprises` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teams_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `team_user`
--
ALTER TABLE `team_user`
  ADD CONSTRAINT `team_user_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `team_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_entreprise_id_foreign` FOREIGN KEY (`entreprise_id`) REFERENCES `entreprises` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
