-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2025 at 10:35 AM
-- Server version: 9.4.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `posyandu`
--

-- --------------------------------------------------------

--
-- Table structure for table `lansia`
--

CREATE TABLE `lansia` (
  `id` int NOT NULL,
  `id_unik` varchar(16) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_telp` varchar(30) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pemeriksaan`
--

CREATE TABLE `pemeriksaan` (
  `id` int NOT NULL,
  `lansia_id` int NOT NULL,
  `petugas_id` int DEFAULT NULL,
  `tgl_periksa` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tinggi_cm` tinyint UNSIGNED DEFAULT NULL,
  `berat_kg` decimal(5,2) DEFAULT NULL,
  `sistolik` smallint UNSIGNED DEFAULT NULL,
  `diastolik` smallint UNSIGNED DEFAULT NULL,
  `tekanan_darah_kategori` enum('NORMAL','BATAS_WASPADA','HIPERTENSI_TAHAP_1','HIPERTENSI_TAHAP_2','KRISIS_HIPERTENSI') DEFAULT NULL,
  `bmi` decimal(4,1) DEFAULT NULL,
  `bmi_kategori` enum('SANGAT_KURANG','KURANG','NORMAL','LEBIH','OBESITAS_I','OBESITAS_II') DEFAULT NULL,
  `asam_urat_mgdl` decimal(4,1) DEFAULT NULL,
  `asam_urat_kategori` enum('RENDAH','NORMAL','TINGGI') DEFAULT NULL,
  `gula_tipe` enum('puasa','sewaktu','2jpp') DEFAULT NULL,
  `gula_kategori` enum('NORMAL','PRA_DIABETES','DIABETES','CURIGA_DIABETES') DEFAULT NULL,
  `gula_mgdl` smallint UNSIGNED DEFAULT NULL,
  `kolesterol_total_mgdl` smallint UNSIGNED DEFAULT NULL,
  `kolesterol_total_kategori` enum('NORMAL','BATAS_TINGGI','TINGGI') DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `no_telp` varchar(30) DEFAULT NULL,
  `role` enum('admin','petugas') NOT NULL DEFAULT 'petugas',
  `password_hash` varchar(255) NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lansia`
--
ALTER TABLE `lansia`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_unik` (`id_unik`);

--
-- Indexes for table `pemeriksaan`
--
ALTER TABLE `pemeriksaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pem_petugas` (`petugas_id`),
  ADD KEY `idx_pem_lansia_tgl` (`lansia_id`,`tgl_periksa`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lansia`
--
ALTER TABLE `lansia`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pemeriksaan`
--
ALTER TABLE `pemeriksaan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pemeriksaan`
--
ALTER TABLE `pemeriksaan`
  ADD CONSTRAINT `fk_pem_lansia` FOREIGN KEY (`lansia_id`) REFERENCES `lansia` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pem_petugas` FOREIGN KEY (`petugas_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
