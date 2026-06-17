-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2026 at 05:45 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projekta_2026`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_name` varchar(255) DEFAULT NULL,
  `action` varchar(20) NOT NULL,
  `entity_type` varchar(60) NOT NULL,
  `entity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `before_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`before_data`)),
  `after_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`after_data`)),
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `admin_name`, `action`, `entity_type`, `entity_id`, `before_data`, `after_data`, `changed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 'create', 'destinations', 1, NULL, '{\"name\":\"Candi Borobudur\",\"place_address\":\"Candi Borobudur, Jl. Badrawati, Kw. Candi Borobudur, Borobudur, Kec. Borobudur, Kabupaten Magelang, Jawa Tengah\",\"city\":\"Magelang\",\"province\":\"Jawa Tengah\",\"latitude\":\"-7.7970680\",\"longitude\":\"110.3705290\",\"price\":\"300000\",\"description\":\"Candi Borobudur adalah\\u00a0candi Buddha terbesar di dunia yang terletak di Magelang, Jawa Tengah, Indonesia. Dibangun pada abad ke-8 dan ke-9 Masehi oleh Dinasti Syailendra, situs warisan dunia UNESCO ini terkenal dengan arsitektur menakjubkan berupa punden berundak, ribuan relief, dan stupa yang melambangkan kosmologi Buddha\",\"category\":\"tempat prasejarah\",\"image_url\":\"https:\\/\\/fatek.umsu.ac.id\\/wp-content\\/uploads\\/2023\\/06\\/Candi-Borobudur-Makna-Yang-Terkandung-di-Dalamnya.jpg\",\"hiddengem\":\"bukanhiddengem\",\"transport_modes\":[\"mobil\",\"motor\",\"jalan kaki\",\"bus\"],\"location\":\"Candi Borobudur, Jl. Badrawati, Kw. Candi Borobudur, Borobudur, Kec. Borobudur, Kabupaten Magelang, Jawa Tengah, Magelang, Jawa Tengah\",\"updated_at\":\"2026-03-29T06:43:59.000000Z\",\"created_at\":\"2026-03-29T06:43:59.000000Z\",\"id_destinations\":1}', '2026-03-28 23:43:59', '2026-03-28 23:43:59', '2026-03-28 23:43:59'),
(2, 1, 'admin', 'update', 'destinations', 1, '{\"id_destinations\":1,\"name\":\"Candi Borobudur\",\"location\":\"Candi Borobudur, Jl. Badrawati, Kw. Candi Borobudur, Borobudur, Kec. Borobudur, Kabupaten Magelang, Jawa Tengah, Magelang, Jawa Tengah\",\"place_address\":\"Candi Borobudur, Jl. Badrawati, Kw. Candi Borobudur, Borobudur, Kec. Borobudur, Kabupaten Magelang, Jawa Tengah\",\"city\":\"Magelang\",\"province\":\"Jawa Tengah\",\"latitude\":\"-7.7970680\",\"longitude\":\"110.3705290\",\"latitude_south\":null,\"latitude_north\":null,\"transport_modes\":[\"mobil\",\"motor\",\"jalan kaki\",\"bus\"],\"price\":\"300000.00\",\"rating\":null,\"description\":\"Candi Borobudur adalah\\u00a0candi Buddha terbesar di dunia yang terletak di Magelang, Jawa Tengah, Indonesia. Dibangun pada abad ke-8 dan ke-9 Masehi oleh Dinasti Syailendra, situs warisan dunia UNESCO ini terkenal dengan arsitektur menakjubkan berupa punden berundak, ribuan relief, dan stupa yang melambangkan kosmologi Buddha\",\"category\":\"tempat prasejarah\",\"image_url\":\"https:\\/\\/fatek.umsu.ac.id\\/wp-content\\/uploads\\/2023\\/06\\/Candi-Borobudur-Makna-Yang-Terkandung-di-Dalamnya.jpg\",\"hiddengem\":\"bukanhiddengem\",\"created_at\":\"2026-03-29T06:43:59.000000Z\",\"updated_at\":\"2026-03-29T06:43:59.000000Z\"}', '{\"id_destinations\":1,\"name\":\"Candi Borobudur\",\"location\":\"Candi Borobudur, Jl. Badrawati, Kw. Candi Borobudur, Borobudur, Kec. Borobudur, Kabupaten Magelang, Jawa Tengah, Magelang, Jawa Tengah\",\"place_address\":\"Candi Borobudur, Jl. Badrawati, Kw. Candi Borobudur, Borobudur, Kec. Borobudur, Kabupaten Magelang, Jawa Tengah\",\"city\":\"Magelang\",\"province\":\"Jawa Tengah\",\"latitude\":\"-7.7970680\",\"longitude\":\"110.3705290\",\"latitude_south\":null,\"latitude_north\":null,\"transport_modes\":[\"mobil\",\"motor\",\"jalan kaki\",\"bus\"],\"price\":\"300000.00\",\"rating\":null,\"description\":\"Candi Borobudur adalah\\u00a0candi Buddha terbesar di dunia yang terletak di Magelang, Jawa Tengah, Indonesia. Dibangun pada abad ke-8 dan ke-9 Masehi oleh Dinasti Syailendra, situs warisan dunia UNESCO ini terkenal dengan arsitektur menakjubkan berupa punden berundak, ribuan relief, dan stupa yang melambangkan kosmologi Buddha\",\"category\":\"tempat prasejarah\",\"image_url\":\"uploads\\/4TeSiqRfGJGOQs8fF6ve6SAHYe37jZDkKrJDXqTU.jpg\",\"hiddengem\":\"bukanhiddengem\",\"created_at\":\"2026-03-29T06:43:59.000000Z\",\"updated_at\":\"2026-03-29T07:14:58.000000Z\"}', '2026-03-29 00:14:58', '2026-03-29 00:14:58', '2026-03-29 00:14:58'),
(3, 1, 'admin', 'create', 'destinations', 2, NULL, '{\"name\":\"Taman Suropati\",\"place_address\":\"Jl. Taman Suropati No.5, RT.5\\/RW.5, Menteng, Kec. Menteng, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10310\",\"city\":\"Jakarta Pusat\",\"province\":\"DKI Jakarta\",\"latitude\":\"-6.199120\",\"longitude\":\"106.832676\",\"operational_days\":\"Senin - Minggu\",\"operational_hours\":\"06:30 - 17:00\",\"price\":\"15000\",\"description\":\"Taman Suropati adalah nama sebuah taman di Jakarta. Pada awalnya nama taman ini diambil dari nama wali kota Batavia pertama, G.J. Bisshop. Taman ini merupakan pusat kawasan Menteng, berada tepat di antara pertemuan tiga jalan utama, yaitu Menteng Boulevard, Orange Boulevard, dan Nassau Boulevard\",\"category\":\"wisata alam\",\"hiddengem\":\"bukanhiddengem\",\"transport_modes\":[\"mobil\",\"motor\",\"jalan kaki\",\"bus\"],\"location\":\"Jl. Taman Suropati No.5, RT.5\\/RW.5, Menteng, Kec. Menteng, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10310, Jakarta Pusat, DKI Jakarta\",\"image_url\":\"uploads\\/YOMtaxegBB1dfyr4TTbF08uiTcGMNxvZtZTTrYop.jpg\",\"updated_at\":\"2026-03-31T12:39:30.000000Z\",\"created_at\":\"2026-03-31T12:39:30.000000Z\",\"id_destinations\":2}', '2026-03-31 05:39:30', '2026-03-31 05:39:30', '2026-03-31 05:39:30'),
(4, 1, 'admin', 'update', 'destinations', 2, '{\"id_destinations\":2,\"name\":\"Taman Suropati\",\"location\":\"Jl. Taman Suropati No.5, RT.5\\/RW.5, Menteng, Kec. Menteng, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10310, Jakarta Pusat, DKI Jakarta\",\"place_address\":\"Jl. Taman Suropati No.5, RT.5\\/RW.5, Menteng, Kec. Menteng, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10310\",\"city\":\"Jakarta Pusat\",\"province\":\"DKI Jakarta\",\"latitude\":\"-6.1991200\",\"longitude\":\"106.8326760\",\"latitude_south\":null,\"latitude_north\":null,\"transport_modes\":[\"mobil\",\"motor\",\"jalan kaki\",\"bus\"],\"price\":\"15000.00\",\"rating\":null,\"description\":\"Taman Suropati adalah nama sebuah taman di Jakarta. Pada awalnya nama taman ini diambil dari nama wali kota Batavia pertama, G.J. Bisshop. Taman ini merupakan pusat kawasan Menteng, berada tepat di antara pertemuan tiga jalan utama, yaitu Menteng Boulevard, Orange Boulevard, dan Nassau Boulevard\",\"category\":\"wisata alam\",\"image_url\":\"uploads\\/YOMtaxegBB1dfyr4TTbF08uiTcGMNxvZtZTTrYop.jpg\",\"status_lokasi\":\"terkenal\",\"created_at\":\"2026-03-31T12:39:30.000000Z\",\"updated_at\":\"2026-03-31T12:39:30.000000Z\",\"operational_days\":\"Senin - Minggu\",\"operational_hours\":\"06:30 - 17:00\"}', '{\"id_destinations\":2,\"name\":\"Taman Suropati\",\"location\":\"Jl. Taman Suropati No.5, RT.5\\/RW.5, Menteng, Kec. Menteng, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10310, Jakarta Pusat, DKI Jakarta\",\"place_address\":\"Jl. Taman Suropati No.5, RT.5\\/RW.5, Menteng, Kec. Menteng, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10310\",\"city\":\"Jakarta Pusat\",\"province\":\"DKI Jakarta\",\"latitude\":\"-6.1991200\",\"longitude\":\"106.8326760\",\"latitude_south\":null,\"latitude_north\":null,\"transport_modes\":[\"mobil\",\"motor\",\"jalan kaki\",\"bus\"],\"price\":\"15000.00\",\"rating\":null,\"description\":\"Taman Suropati adalah nama sebuah taman di Jakarta. Pada awalnya nama taman ini diambil dari nama wali kota Batavia pertama, G.J. Bisshop. Taman ini merupakan pusat kawasan Menteng, berada tepat di antara pertemuan tiga jalan utama, yaitu Menteng Boulevard, Orange Boulevard, dan Nassau Boulevard\",\"category\":\"wisata alam\",\"image_url\":\"uploads\\/YOMtaxegBB1dfyr4TTbF08uiTcGMNxvZtZTTrYop.jpg\",\"status_lokasi\":\"terkenal\",\"created_at\":\"2026-03-31T12:39:30.000000Z\",\"updated_at\":\"2026-03-31T14:21:27.000000Z\",\"operational_days\":\"setiap hari\",\"operational_hours\":\"06:30 - 17:00\"}', '2026-03-31 07:21:27', '2026-03-31 07:21:27', '2026-03-31 07:21:27');

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bookmarkable_type` varchar(255) NOT NULL,
  `bookmarkable_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` (`id`, `user_id`, `bookmarkable_type`, `bookmarkable_id`, `created_at`, `updated_at`) VALUES
(1, 2, 'App\\Models\\Destination', 1, '2026-03-29 01:29:49', '2026-03-29 01:29:49');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `culinaries`
--

CREATE TABLE `culinaries` (
  `id_culinaries` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `place_address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `transport_modes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`transport_modes`)),
  `price` decimal(10,2) NOT NULL,
  `rating` decimal(3,2) NOT NULL,
  `cuisine_type` varchar(255) NOT NULL,
  `amenities` text DEFAULT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status_lokasi` enum('terkenal','hidden gem') NOT NULL DEFAULT 'terkenal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `operational_days` varchar(255) DEFAULT NULL,
  `operational_hours` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id_destinations` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `place_address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `transport_modes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`transport_modes`)),
  `price` decimal(10,2) NOT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status_lokasi` enum('terkenal','hidden gem') NOT NULL DEFAULT 'terkenal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `operational_days` varchar(255) DEFAULT NULL,
  `operational_hours` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id_destinations`, `name`, `location`, `place_address`, `city`, `province`, `latitude`, `longitude`, `transport_modes`, `price`, `rating`, `description`, `category`, `image_url`, `status_lokasi`, `created_at`, `updated_at`, `operational_days`, `operational_hours`) VALUES
(1, 'Candi Borobudur', 'Candi Borobudur, Jl. Badrawati, Kw. Candi Borobudur, Borobudur, Kec. Borobudur, Kabupaten Magelang, Jawa Tengah, Magelang, Jawa Tengah', 'Candi Borobudur, Jl. Badrawati, Kw. Candi Borobudur, Borobudur, Kec. Borobudur, Kabupaten Magelang, Jawa Tengah', 'Magelang', 'Jawa Tengah', -7.7970680, 110.3705290, '[\"mobil\",\"motor\",\"jalan kaki\",\"bus\"]', 300000.00, NULL, 'Candi Borobudur adalah candi Buddha terbesar di dunia yang terletak di Magelang, Jawa Tengah, Indonesia. Dibangun pada abad ke-8 dan ke-9 Masehi oleh Dinasti Syailendra, situs warisan dunia UNESCO ini terkenal dengan arsitektur menakjubkan berupa punden berundak, ribuan relief, dan stupa yang melambangkan kosmologi Buddha', 'tempat prasejarah', 'uploads/4TeSiqRfGJGOQs8fF6ve6SAHYe37jZDkKrJDXqTU.jpg', 'terkenal', '2026-03-28 23:43:59', '2026-03-29 00:14:58', NULL, NULL),
(2, 'Taman Suropati', 'Jl. Taman Suropati No.5, RT.5/RW.5, Menteng, Kec. Menteng, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10310, Jakarta Pusat, DKI Jakarta', 'Jl. Taman Suropati No.5, RT.5/RW.5, Menteng, Kec. Menteng, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10310', 'Jakarta Pusat', 'DKI Jakarta', -6.1991200, 106.8326760, '[\"mobil\",\"motor\",\"jalan kaki\",\"bus\"]', 15000.00, NULL, 'Taman Suropati adalah nama sebuah taman di Jakarta. Pada awalnya nama taman ini diambil dari nama wali kota Batavia pertama, G.J. Bisshop. Taman ini merupakan pusat kawasan Menteng, berada tepat di antara pertemuan tiga jalan utama, yaitu Menteng Boulevard, Orange Boulevard, dan Nassau Boulevard', 'wisata alam', 'uploads/YOMtaxegBB1dfyr4TTbF08uiTcGMNxvZtZTTrYop.jpg', 'terkenal', '2026-03-31 05:39:30', '2026-03-31 07:21:27', 'setiap hari', '06:30 - 17:00');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_29_015808_destination_table', 1),
(5, '2026_03_29_020344_culinary_table', 1),
(6, '2026_03_29_020441_stays_table', 1),
(7, '2026_03_29_120000_create_ratings_table', 2),
(8, '2026_03_29_121000_add_review_to_ratings_table', 3),
(9, '2026_03_29_122000_add_latitudes_to_core_tables', 4),
(10, '2026_03_29_123000_create_audit_logs_table', 5),
(11, '2026_03_29_124000_add_transport_modes_to_core_tables', 6),
(12, '2026_03_29_125000_add_address_city_province_to_core_tables', 7),
(13, '2026_03_29_130000_add_latitude_longitude_to_core_tables', 8),
(14, '2026_03_29_140000_create_bookmarks_table', 9),
(15, '2026_03_30_000100_add_operational_schedule_to_core_tables', 10),
(16, '2026_03_31_150000_replace_hiddengem_with_status_lokasi', 11),
(17, '2026_04_01_000000_cleanup_legacy_coordinates_and_add_destination_foreign_keys', 12),
(18, '2026_04_01_010000_remove_destination_parent_from_culinary_and_stays', 12),
(19, '2026_04_01_020000_add_amenities_to_culinaries_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rateable_type` varchar(255) NOT NULL,
  `rateable_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `user_id`, `rateable_type`, `rateable_id`, `rating`, `review`, `created_at`, `updated_at`) VALUES
(1, 2, 'App\\Models\\Destination', 1, 5, 'mantap', '2026-03-29 00:15:41', '2026-03-29 00:15:41');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('BPLphey4wGDjV0ccJk36vLh7cjGhmPXKkZ3UZKYe', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSmh1enFMYnFzRWxUSTlsSDA5QjZ2dW16VWtsNFRQQzRWUHpJNHVBdiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vdXNlcnMiO3M6NToicm91dGUiO3M6MTc6ImFkbWluLnVzZXJzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1776358372),
('vhevwVFw8GUWM4k6mNYewdZ3ZAIp5LQ9axSkQOQE', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRnRPUXVBRHhZQnNqN0ZvTzJ0MHcyWUllUmplYmttRWw1WHViN0pRbCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1776346884);

-- --------------------------------------------------------

--
-- Table structure for table `stays`
--

CREATE TABLE `stays` (
  `id_stays` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `place_address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `transport_modes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`transport_modes`)),
  `price` decimal(10,2) NOT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `amenities` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status_lokasi` enum('terkenal','hidden gem') NOT NULL DEFAULT 'terkenal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `operational_days` varchar(255) DEFAULT NULL,
  `operational_hours` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','member') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'admin', 'admin@example.com', NULL, '$2y$12$EK33NZR5EeZTeesmOplu8uZt3jHUirszXQ.QW/baODXdnEZiHOiuq', NULL, '2026-03-28 19:38:28', '2026-03-28 19:38:28', 'admin'),
(2, 'adit17', 'aditajelah@gmail.com', NULL, '$2y$12$zdSK1ie4ZFV2n/xrEPOs7ObOYlfzk3TdTymFWtRlfgDG5CIck1MSa', NULL, '2026-03-28 22:32:27', '2026-03-28 22:32:27', 'member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`),
  ADD KEY `audit_logs_entity_type_entity_id_index` (`entity_type`,`entity_id`),
  ADD KEY `audit_logs_changed_at_index` (`changed_at`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookmarks_unique_user_item` (`user_id`,`bookmarkable_type`,`bookmarkable_id`),
  ADD KEY `bookmarks_bookmarkable_type_bookmarkable_id_index` (`bookmarkable_type`,`bookmarkable_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `culinaries`
--
ALTER TABLE `culinaries`
  ADD PRIMARY KEY (`id_culinaries`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id_destinations`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_reserved_at_available_at_index` (`queue`,`reserved_at`,`available_at`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_rateable_unique` (`user_id`,`rateable_type`,`rateable_id`),
  ADD KEY `ratings_rateable_type_rateable_id_index` (`rateable_type`,`rateable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stays`
--
ALTER TABLE `stays`
  ADD PRIMARY KEY (`id_stays`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `culinaries`
--
ALTER TABLE `culinaries`
  MODIFY `id_culinaries` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id_destinations` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stays`
--
ALTER TABLE `stays`
  MODIFY `id_stays` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
