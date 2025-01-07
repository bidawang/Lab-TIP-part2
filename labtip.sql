-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2024 at 04:54 PM
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
-- Database: `labtip`
--

-- --------------------------------------------------------

--
-- Table structure for table `alat`
--

CREATE TABLE `alat` (
  `id_alat` int(4) NOT NULL,
  `nama_alat` varchar(50) NOT NULL,
  `stok` int(11) NOT NULL,
  `status` enum('baik','rusak') DEFAULT NULL,
  `foto_alat` varchar(100) NOT NULL,
  `satuan` enum('ml','gram') NOT NULL,
  `id_pembelian` int(11) DEFAULT NULL,
  `google_id` int(11) DEFAULT NULL,
  `id_alat_pinjam` int(11) DEFAULT NULL,
  `updated_at` date NOT NULL,
  `created_at` date NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alat`
--

INSERT INTO `alat` (`id_alat`, `nama_alat`, `stok`, `status`, `foto_alat`, `satuan`, `id_pembelian`, `google_id`, `id_alat_pinjam`, `updated_at`, `created_at`, `keterangan`) VALUES
(1, 'Timbangan', 4, NULL, '', 'gram', NULL, NULL, NULL, '2024-05-12', '2024-05-12', ''),
(2, 'Blender', 7, NULL, '2023-04-25.png', 'gram', NULL, NULL, NULL, '2024-05-12', '2024-05-12', ''),
(3, 'Surya 12', 3, NULL, 'Screenshot (103).png', 'ml', NULL, NULL, NULL, '2024-05-12', '2024-05-12', ''),
(4, 'Surya 12', 3, NULL, 'C:\\xampp\\tmp\\phpDBBD.tmp', 'gram', NULL, NULL, NULL, '2024-05-12', '2024-05-12', ''),
(5, 'Udang Garam', 120, NULL, '6640b8e34edfd.png', 'ml', NULL, NULL, NULL, '2024-05-12', '2024-05-12', ''),
(6, 'dfsgfds', 34, NULL, '66667af56c498.PNG', 'ml', NULL, NULL, NULL, '2024-06-10', '2024-06-10', '');

-- --------------------------------------------------------

--
-- Table structure for table `alat_pinjam`
--

CREATE TABLE `alat_pinjam` (
  `id_alat_pinjam` int(8) NOT NULL,
  `tempat_peminjaman` varchar(30) NOT NULL,
  `jumlah` int(7) NOT NULL,
  `satuan` enum('ml','gram','buah') NOT NULL,
  `tanggal_peminjaman` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_akhir` time NOT NULL,
  `nama_peminjam` varchar(40) NOT NULL,
  `nama_alat` varchar(40) NOT NULL,
  `status` enum('tunggu','terima','tolak') NOT NULL,
  `keperluan` varchar(100) NOT NULL,
  `google_id` text NOT NULL,
  `updated_at` date NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alat_pinjam`
--

INSERT INTO `alat_pinjam` (`id_alat_pinjam`, `tempat_peminjaman`, `jumlah`, `satuan`, `tanggal_peminjaman`, `waktu_mulai`, `waktu_akhir`, `nama_peminjam`, `nama_alat`, `status`, `keperluan`, `google_id`, `updated_at`, `created_at`) VALUES
(1, 'asdfasf', 342, 'buah', '2024-06-11', '11:11:00', '11:11:00', 'Danang Dwi Jatmiko', 'sdadfa', 'tunggu', '1werwrqt', '113703462371426360272', '2024-06-10', '2024-06-10');

-- --------------------------------------------------------

--
-- Table structure for table `alat_rusak`
--

CREATE TABLE `alat_rusak` (
  `id_alat_rusak` int(8) NOT NULL,
  `penanggungjawab` varchar(100) NOT NULL,
  `penyebab_kerusakan` varchar(50) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `tingkat_kerusakan` enum('berat','sedang','ringan') NOT NULL,
  `google_id` int(11) DEFAULT NULL,
  `id_alat` int(11) DEFAULT NULL,
  `updated_at` date NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bahan`
--

CREATE TABLE `bahan` (
  `id_bahan` int(1) NOT NULL,
  `nama_bahan` varchar(40) NOT NULL,
  `satuan` enum('ml','gram') NOT NULL,
  `foto_bahan` varchar(100) NOT NULL,
  `stok` int(8) NOT NULL,
  `google_id` text NOT NULL,
  `id_pembelian` int(11) DEFAULT NULL,
  `id_bahan_pakai` int(11) DEFAULT NULL,
  `updated_at` date NOT NULL,
  `created_at` date NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bahan`
--

INSERT INTO `bahan` (`id_bahan`, `nama_bahan`, `satuan`, `foto_bahan`, `stok`, `google_id`, `id_pembelian`, `id_bahan_pakai`, `updated_at`, `created_at`, `keterangan`) VALUES
(2, 'Tepung', 'ml', '6667df118bbdf.png', 5, '', NULL, NULL, '2024-06-11', '2024-06-11', 'Nothing'),
(3, 'Bullyan di kantin', 'ml', '6667e04091db5.png', 7, '113751997573404637999', NULL, NULL, '2024-06-11', '2024-06-11', '');

-- --------------------------------------------------------

--
-- Table structure for table `bahan_pakai`
--

CREATE TABLE `bahan_pakai` (
  `id_bahan_pakai` int(8) NOT NULL,
  `nama_bahan` varchar(40) NOT NULL,
  `jumlah` int(8) NOT NULL,
  `satuan` enum('gram','ml') NOT NULL,
  `keperluan` varchar(100) NOT NULL,
  `nama_pemakai` varchar(40) NOT NULL,
  `tanggal_pemakaian` date NOT NULL,
  `status` enum('tunggu','terima','tolak') NOT NULL,
  `google_id` text DEFAULT NULL,
  `updated_at` date NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bahan_pakai`
--

INSERT INTO `bahan_pakai` (`id_bahan_pakai`, `nama_bahan`, `jumlah`, `satuan`, `keperluan`, `nama_pemakai`, `tanggal_pemakaian`, `status`, `google_id`, `updated_at`, `created_at`) VALUES
(1, 'Bahan Apa Hayo', 3, 'gram', 'asfgasdfgaf', 'Danang Dwi Jatmiko', '2024-06-06', 'terima', '113703462371426360272', '2024-06-11', '2024-06-10'),
(2, 'adsfas', 3424, 'gram', 'dafdsgdf', 'Danang Dwi Jatmiko', '2024-06-13', 'tolak', '113703462371426360272', '2024-06-10', '2024-06-10'),
(6, 'Tepung', 6, 'ml', 'hh', 'Yuliana Kartini', '2024-06-13', 'terima', '113751997573404637999', '2024-06-11', '2024-06-11');

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
(2, '0001_01_01_000001_create_cache_table', 2),
(3, '0001_01_01_000002_create_jobs_table', 2);

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
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `nama_barang` varchar(60) NOT NULL,
  `harga` int(8) NOT NULL,
  `jenis` enum('alat','bahan') NOT NULL,
  `satuan` enum('gram','ml','buah') NOT NULL,
  `foto_pembelian` varchar(100) NOT NULL,
  `nama_toko` varchar(60) NOT NULL,
  `jumlah` int(7) NOT NULL,
  `keterangan` text NOT NULL,
  `google_id` text DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pinjam_ruangan`
--

CREATE TABLE `pinjam_ruangan` (
  `id_pinjam_ruangan` int(8) NOT NULL,
  `keperluan` varchar(100) NOT NULL,
  `waktu_mulai` datetime NOT NULL,
  `waktu_akhir` datetime NOT NULL,
  `penanggungjawab` varchar(40) DEFAULT NULL,
  `nama_peminjam` varchar(40) NOT NULL,
  `tanggal_peminjaman` date NOT NULL,
  `status` enum('tunggu','terima','tolak') NOT NULL,
  `id_ruangan` int(11) DEFAULT NULL,
  `google_id` int(11) DEFAULT NULL,
  `updated_at` date NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` int(8) NOT NULL,
  `nama_ruangan` varchar(40) NOT NULL,
  `foto_ruangan` varchar(100) NOT NULL,
  `lantai` int(1) NOT NULL,
  `gedung` varchar(40) NOT NULL,
  `laboran` varchar(40) NOT NULL,
  `status` enum('dipakai','kosong') DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `google_id` int(11) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `nama_ruangan`, `foto_ruangan`, `lantai`, `gedung`, `laboran`, `status`, `keterangan`, `google_id`, `updated_at`, `created_at`) VALUES
(1, 'Meting rum', '6640d54ec137e.png', 1, 'Gedung lah pokoknya', 'Mr Stipen bin kardon', NULL, NULL, NULL, '2024-05-12', '2024-05-12');

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
('BDS3oIkNK26Z9nNWaDdfi5sZXC8weFLF1q7KIE1l', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibXVraTZHdWNPcEduYjhxUk53YXZ6Q0RpZmFHVmRNWk9NakdRWmNQUyI7czo1OiJzdGF0ZSI7czo0MDoiT3l5NFBDSjBOQjg5a2pqNzhWZjV2elZLU1BDdDFKMDhKWUxIeEZHbiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hdXRoL3JlZGlyZWN0Ijt9fQ==', 1718981353),
('d6v03RuGyuKSKDWp3Fn3ucZFO6fDOaNT2EjWz02P', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicHZ6R3Q4aTI4aTN6U3lCZElwVVZRRXd0eVVDWEk5VzdjR21zalE2QSI7czo1OiJzdGF0ZSI7czo0MDoibHl5d1J3dEhzSFZnYjl0OFV1elZBelVsTXJwMkxtOEYyY2NHOFFMVCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hdXRoL3JlZGlyZWN0Ijt9fQ==', 1718886965),
('ILXiolh0bTRf1aILLRZKMXnQGX7d7fDdYG1nVvAy', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQzZYMXZDdUxXTUNFM2NzdGxXSlRwRzFFUUFmZmFSNk5OZFRwcHljSyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzYyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXV0aC9jYWxsYmFjaz9hdXRodXNlcj0wJmNvZGU9NCUyRjBBVHgzTFk0WW1rX29Ed1dlNE4wMzJ3MG1LdUQ0UkJ3bHV0VUxNV1lmaXo1UXZzTjQ4cG1Ycm1sdlJIVEtRU1l6MGExQWJ3JmhkPW1ocy5wb2xpdGFsYS5hYy5pZCZwcm9tcHQ9Y29uc2VudCZzY29wZT1lbWFpbCUyMHByb2ZpbGUlMjBvcGVuaWQlMjBodHRwcyUzQSUyRiUyRnd3dy5nb29nbGVhcGlzLmNvbSUyRmF1dGglMkZ1c2VyaW5mby5wcm9maWxlJTIwaHR0cHMlM0ElMkYlMkZ3d3cuZ29vZ2xlYXBpcy5jb20lMkZhdXRoJTJGdXNlcmluZm8uZW1haWwmc3RhdGU9QTNjdTBsb2lGbUZkeVA5akJQaU84MWVoek56QTh5NnFpc0ViM20zNiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1718981377),
('jUj12NpWT18w6el02TRLVRyFfIK9saKSRG9uh4ly', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid3VLRjkxSlRsWGQxOUZhYmRmbTFxczlzcXVUYkptNEpESWZ5TGxEcSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ydWFuZ3BqbS90cnVhbmdwam0iO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1718890897),
('PMqA2gaIOK3cnHRuoSj4LWka0dq6bkXNHYSxDbWB', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidThCT2xaeFRPNVZnbU5nSkFnUHFKVVkzR2dFcGtoOEtTSDVEY1hhWSI7czo1OiJzdGF0ZSI7czo0MDoiMFBpRk1GeThNb1hDRldEcEJ4NFdlSWxCdFJhb2phendINjJneThSaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hdXRoL3JlZGlyZWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1718886229),
('vrq3tlcYUa70tXUPMIW75lssXpYtDt5MJNahybnN', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQXdMUkFRZzJrVEFUcnBjeUxieWNFVjZCT0FhY00xamZ1cDY2cXJVZSI7czo1OiJzdGF0ZSI7czo0MDoiTU9kcFlYbFcyTG1CQkFpVVlJTm1MV3BFUDJHempVOXRoMGhqTFJIcCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hdXRoL3JlZGlyZWN0Ijt9fQ==', 1718886949);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `google_id` text NOT NULL,
  `NIM` bigint(10) DEFAULT NULL,
  `level` enum('Developer','Dosen','Laboran','Mahasiswa') DEFAULT NULL,
  `semester` int(1) DEFAULT NULL,
  `avatar` varchar(200) NOT NULL,
  `no_hp` bigint(13) DEFAULT NULL,
  `prodi` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `google_id`, `NIM`, `level`, `semester`, `avatar`, `no_hp`, `prodi`) VALUES
(2, '2201301176 DANANG DWI JATMIKO', 'danang.dwi.jatmiko@mhs.politala.ac.id', NULL, NULL, NULL, '2024-06-09 17:26:14', '2024-06-09 20:55:54', '113703462371426360272', NULL, 'Mahasiswa', NULL, '113703462371426360272.jpg', NULL, NULL),
(3, '2201301058 YULIANA KARTINI', 'yuliana.kartini@mhs.politala.ac.id', NULL, NULL, NULL, '2024-06-09 21:06:36', '2024-06-10 23:49:58', '113751997573404637999', 2201301058, 'Laboran', 4, '113751997573404637999.jpg', 85668947486, 'Teknologi Informasi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alat`
--
ALTER TABLE `alat`
  ADD PRIMARY KEY (`id_alat`),
  ADD KEY `id_pembelian` (`id_pembelian`),
  ADD KEY `google_id` (`google_id`),
  ADD KEY `id_alat_pinjam` (`id_alat_pinjam`);

--
-- Indexes for table `alat_pinjam`
--
ALTER TABLE `alat_pinjam`
  ADD PRIMARY KEY (`id_alat_pinjam`),
  ADD KEY `google_id` (`google_id`(768));

--
-- Indexes for table `alat_rusak`
--
ALTER TABLE `alat_rusak`
  ADD PRIMARY KEY (`id_alat_rusak`);

--
-- Indexes for table `bahan`
--
ALTER TABLE `bahan`
  ADD PRIMARY KEY (`id_bahan`);

--
-- Indexes for table `bahan_pakai`
--
ALTER TABLE `bahan_pakai`
  ADD PRIMARY KEY (`id_bahan_pakai`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

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
  ADD KEY `jobs_queue_index` (`queue`);

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
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `google_id` (`google_id`(768));

--
-- Indexes for table `pinjam_ruangan`
--
ALTER TABLE `pinjam_ruangan`
  ADD PRIMARY KEY (`id_pinjam_ruangan`),
  ADD KEY `google_id` (`google_id`),
  ADD KEY `id_ruangan` (`id_ruangan`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `alat`
--
ALTER TABLE `alat`
  MODIFY `id_alat` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `alat_pinjam`
--
ALTER TABLE `alat_pinjam`
  MODIFY `id_alat_pinjam` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `alat_rusak`
--
ALTER TABLE `alat_rusak`
  MODIFY `id_alat_rusak` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bahan`
--
ALTER TABLE `bahan`
  MODIFY `id_bahan` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bahan_pakai`
--
ALTER TABLE `bahan_pakai`
  MODIFY `id_bahan_pakai` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pinjam_ruangan`
--
ALTER TABLE `pinjam_ruangan`
  MODIFY `id_pinjam_ruangan` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id_ruangan` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
