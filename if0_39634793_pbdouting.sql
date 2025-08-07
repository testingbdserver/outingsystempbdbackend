-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql206.byetcluster.com
-- Generation Time: Aug 07, 2025 at 02:42 AM
-- Server version: 11.4.7-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_39634793_pbdouting`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(12, 'PUAN TS. DR. IZWAH BINTI ISMAIL', 'admin123'),
(1, 'TUAN MOHAMMAD IZWAN BIN AZMI', 'admin123'),
(11, 'admin', 'admin123'),
(2, 'PUAN NOR ADLINA BINTI OTHMAN', 'admin123'),
(3, 'TUAN AHMAD SYAIFUL HAKIM BIN ISMAIL', 'admin123'),
(4, 'TUAN SAEDUL KHUDRI BIN AHMAD HUSSAIN', 'admin123'),
(5, 'TUAN AIZUDDIN HANIS BIN AHMAD@AWANG', 'admin123'),
(6, 'TUAN AHMAD AFFAN BIN ROSLAN', 'admin123'),
(7, 'TUAN AHMAD MUSTAQIM BIN ABDUL RAHIM', 'admin123'),
(8, 'TUAN TS. MOHD NAIM BIN AWANG', 'admin123'),
(9, 'PUAN NOR HATINI BINTI BAHARIN', 'admin123'),
(10, 'PUAN UZAIRAH BINTI MOHD ALI', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `date` date NOT NULL,
  `tarikh_keluar` date DEFAULT NULL,
  `tarikh_masuk` date DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `approved_by` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `student_id`, `student_name`, `destination`, `reason`, `date`, `tarikh_keluar`, `tarikh_masuk`, `status`, `approved_by`) VALUES
(1, 2, 'test', 'Perak', 'Tidur kt umah surrr', '2025-08-08', NULL, NULL, 'Approved', 'admin'),
(2, 2, 'test', 'johor', 'balik turuu dekkk', '2025-08-30', NULL, NULL, 'Approved', 'admin'),
(3, 5, 'tiktok', 'indomaret', 'balik raya', '2025-08-09', NULL, NULL, 'Rejected', 'admin'),
(4, 3, 'student', 'penang', 'mc', '2025-08-07', NULL, NULL, 'Rejected', 'admin'),
(5, 2, 'test', 'selekoh', 'make ini org', '2025-08-07', '2025-08-07', '2025-08-12', 'Rejected', 'admin'),
(6, 4, 'hehe', 'bagan serai', 'kelik', '2025-08-08', '2025-08-08', '2025-08-09', 'Approved', 'TUAN TS. MOHD NAIM BIN AWANG'),
(7, 2, 'test', 'perak', 'makan', '2025-08-07', '2025-08-09', '2025-08-16', 'Approved', 'TUAN TS. MOHD NAIM BIN AWANG'),
(8, 3, 'student', 'perak', 'turu', '2025-08-07', '2025-08-08', '2025-08-08', 'Approved', 'TUAN TS. MOHD NAIM BIN AWANG'),
(9, 3, 'student', 'perak', 'dewdwf', '2025-08-09', '2025-08-30', '2025-08-21', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `semester` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `device_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `course`, `semester`, `password`, `device_token`, `created_at`) VALUES
(3, 'student', 'student', 'student', '$2y$10$BDBt7vKwSQh.qiLThBR6i.IQmRO3GetUaJjgJ6zbnWdfbrxQBOD2i', NULL, '2025-08-05 08:12:03'),
(2, 'test', 'test', 'test', '$2y$10$J4NWdFrWsrlpROU.T3v/sOnr7rriDfZ43hpXrrHcB6J50yuDPoLyG', 'e85d7c0cd3518f64d4522924ed4543b5', '2025-08-05 04:35:12'),
(4, 'hehe', 'hehe', 'hehe', '$2y$10$ZwV0/8SPvWY/hKAc43/nJ.mji/XvhOoC98rwUxC5ZpvVWsPRlIeru', NULL, '2025-08-06 02:01:31'),
(5, 'tiktok', 'tiktok', 'tiktok', '$2y$10$iewawCr/GmW7SD8GI6YBxuvGcmDkjkregFEb/ZQzO99ztJ0/99.Py', NULL, '2025-08-06 08:30:07');

-- --------------------------------------------------------

--
-- Table structure for table `student_log`
--

CREATE TABLE `student_log` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `status` enum('IN','OUT') NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student_log`
--

INSERT INTO `student_log` (`id`, `student_id`, `status`, `location`, `timestamp`) VALUES
(1, 2, 'OUT', '3.9747405, 100.784754', '2025-08-05 19:21:07'),
(2, 3, 'IN', '3.9747769, 100.7847912', '2025-08-05 19:28:39'),
(3, 3, 'OUT', '3.9747433, 100.7847575', '2025-08-05 20:29:52'),
(4, 5, 'IN', 'Unknown', '2025-08-06 01:30:37'),
(5, 5, 'OUT', 'Unknown', '2025-08-06 01:31:23'),
(6, 5, 'OUT', 'Unknown', '2025-08-06 01:34:29'),
(7, 5, 'IN', 'Unknown', '2025-08-06 01:34:38'),
(8, 5, 'OUT', 'Unknown', '2025-08-06 01:36:13'),
(9, 3, 'OUT', '3.97463919094, 100.785154351', '2025-08-06 01:42:23'),
(10, 2, 'OUT', 'Unknown', '2025-08-06 18:19:46'),
(11, 2, 'IN', 'Unknown', '2025-08-06 18:19:56'),
(12, 2, 'OUT', 'Unknown', '2025-08-06 18:23:00'),
(13, 2, 'IN', 'Unknown', '2025-08-06 18:24:30'),
(14, 2, 'OUT', '3.9747388, 100.7847683', '2025-08-06 18:25:48'),
(15, 2, 'IN', '3.9747341, 100.7847583', '2025-08-06 18:33:00'),
(16, 2, 'OUT', '3.9748003, 100.784747', '2025-08-06 18:59:35'),
(17, 5, 'OUT', '3.9748258, 100.7847436', '2025-08-06 19:17:49'),
(18, 5, 'IN', '3.9747294, 100.7847625', '2025-08-06 19:20:19'),
(19, 3, 'IN', '3.9747393, 100.7847646', '2025-08-06 19:43:16'),
(20, 2, 'IN', 'Unknown', '2025-08-06 19:49:09'),
(21, 2, 'OUT', '3.9747004, 100.7848012', '2025-08-06 19:51:32'),
(22, 5, 'OUT', '3.9747602, 100.7847534', '2025-08-06 21:27:47'),
(23, 4, 'IN', '3.9747432, 100.7847397', '2025-08-06 21:32:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_log`
--
ALTER TABLE `student_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_log`
--
ALTER TABLE `student_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
