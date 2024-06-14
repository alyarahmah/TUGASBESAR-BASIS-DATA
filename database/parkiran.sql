-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2024 at 08:55 AM
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
-- Database: `parkiran`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `roles` enum('admin','owners') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama_admin`, `email`, `roles`) VALUES
(1, 'Dila', '$2y$10$CwXsHLU7ks8UplWv1dKHFOrRaBHsYwyWGRI8X2KhtQiv.EYXN6YFy', 'Dila', 'dila@parkir.garut', 'admin'),
(2, 'Ujang', '$2y$10$sM/hBlzc5aUFE1nxZElr.ut6ldSuBvO71t4wF.WD/WPxPl3ptIxi2', 'Ujang', 'ujang@parkir.garut', 'admin'),
(3, 'Alya', '$2y$10$HA9gdeHCrM1PDqiWfl5fc.K46zV.Uvwsurq4bxkIZlITepmSRssFq', 'Alya', 'alya@owner.com', 'owners');

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id_kendaraan` int(11) NOT NULL,
  `jenis_kendaraan` enum('Roda 2','Roda 4','Lainnya') DEFAULT NULL,
  `merk_kendaraan` varchar(50) DEFAULT NULL,
  `status` enum('masuk','keluar') DEFAULT 'masuk',
  `nama_pemilik` varchar(100) DEFAULT NULL,
  `plat` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kendaraan`
--

INSERT INTO `kendaraan` (`id_kendaraan`, `jenis_kendaraan`, `merk_kendaraan`, `status`, `nama_pemilik`, `plat`) VALUES
(101, 'Roda 2', 'HONDA', 'masuk', 'delia', 'E 3453 UI'),
(103, 'Roda 2', 'HONDA BEAT', 'masuk', 'sean', 'D 8975 OI'),
(105, 'Roda 2', 'HONDA', 'masuk', 'jui', 'Z 8497 JU');

-- --------------------------------------------------------

--
-- Table structure for table `parkir`
--

CREATE TABLE `parkir` (
  `id_parkir` int(11) NOT NULL,
  `id_kendaraan` int(11) DEFAULT NULL,
  `jam_masuk` datetime DEFAULT NULL,
  `jam_keluar` datetime DEFAULT NULL,
  `total_bayar` decimal(10,2) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parkir`
--

INSERT INTO `parkir` (`id_parkir`, `id_kendaraan`, `jam_masuk`, `jam_keluar`, `total_bayar`, `id_admin`) VALUES
(85, 101, '2024-06-14 13:10:00', NULL, NULL, 1),
(87, 103, '2024-06-14 13:12:00', NULL, NULL, 1),
(89, 105, '2024-06-14 13:32:00', NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id_kendaraan`),
  ADD UNIQUE KEY `plat` (`plat`);

--
-- Indexes for table `parkir`
--
ALTER TABLE `parkir`
  ADD PRIMARY KEY (`id_parkir`),
  ADD KEY `id_kendaraan` (`id_kendaraan`),
  ADD KEY `id_admin` (`id_admin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id_kendaraan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `parkir`
--
ALTER TABLE `parkir`
  MODIFY `id_parkir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `parkir`
--
ALTER TABLE `parkir`
  ADD CONSTRAINT `parkir_ibfk_1` FOREIGN KEY (`id_kendaraan`) REFERENCES `kendaraan` (`id_kendaraan`),
  ADD CONSTRAINT `parkir_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
