-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 27, 2026 at 01:17 PM
-- Server version: 5.7.44
-- PHP Version: 8.1.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `igipess_r261172`
--

-- --------------------------------------------------------

--
-- Table structure for table `daily_room_reports`
--

CREATE TABLE `daily_room_reports` (
  `id` int(11) NOT NULL,
  `report_date` date NOT NULL,
  `room_id` int(11) NOT NULL,
  `room_no` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `floor` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `media_type` enum('photo','video') COLLATE utf8mb4_unicode_ci DEFAULT 'photo',
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original_size` int(11) DEFAULT NULL,
  `compressed_size` int(11) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `geo_address` text COLLATE utf8mb4_unicode_ci,
  `equipment_status` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daily_room_reports`
--

INSERT INTO `daily_room_reports` (`id`, `report_date`, `room_id`, `room_no`, `floor`, `media_type`, `file_name`, `original_size`, `compressed_size`, `latitude`, `longitude`, `geo_address`, `equipment_status`, `notes`, `created_at`) VALUES
(1, '2026-05-27', 9, '6', 'Ground Floor', 'photo', 'uploads/2026/05/27/20260527_055505_6a168739da3aa.', 114313, 114313, 28.63095490, 77.07214360, '28.6309549, 77.0721436', '', '', '2026-05-27 05:55:05'),
(2, '2026-05-27', 9, '6', 'Ground Floor', 'photo', 'uploads/2026/05/27/20260527_060315_6a1689236143b.', 86793, 86793, 28.63093590, 77.07213630, '28.6309359, 77.0721363', '', '', '2026-05-27 06:03:15'),
(3, '2026-05-27', 9, '6', 'Ground Floor', 'video', 'uploads/2026/05/27/20260527_060351_6a16894759561.', 91702, 91702, 28.63063063, 77.06228060, '28.63063063063063, 77.06228059542788', '', '', '2026-05-27 06:03:51'),
(4, '2026-05-27', 9, '6', 'Ground Floor', 'photo', 'uploads/2026/05/27/20260527_062052_6a168d4422cd5.', 64179, 64179, 28.63093370, 77.07214450, '28.6309337, 77.0721445', 'Ok', '', '2026-05-27 06:20:52'),
(5, '2026-05-27', 1, '1', 'Ground Floor', 'photo', 'uploads/2026/05/27/20260527_064533_6a16930d4fbea.jpg', 237052, 208710, 28.63095790, 77.07214760, '28.630958, 77.072148', '', '', '2026-05-27 06:45:33'),
(6, '2026-05-27', 1, '1', 'Ground Floor', 'photo', 'uploads/2026/05/27/20260527_065431_6a16952741ba6.jpg', 167831, 150250, 28.63094150, 77.07215600, '28.630941, 77.072156', '', '', '2026-05-27 06:54:31'),
(7, '2026-05-27', 1, '1', 'Ground Floor', 'photo', 'uploads/2026/05/27/20260527_070402_6a169762e56ec.mp4', 1612565, 1612565, 28.63094110, 77.07213440, '28.630941, 77.072134', '', '', '2026-05-27 07:04:02'),
(8, '2026-05-27', 1, '1', 'Ground Floor', 'photo', 'uploads/2026/05/27/20260527_072918_6a169d4e79d3e.mp4', 1644451, 1644451, 28.63096200, 77.07215720, '28.630962, 77.072157', '', '', '2026-05-27 07:29:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daily_room_reports`
--
ALTER TABLE `daily_room_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_date` (`report_date`),
  ADD KEY `idx_room` (`room_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daily_room_reports`
--
ALTER TABLE `daily_room_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daily_room_reports`
--
ALTER TABLE `daily_room_reports`
  ADD CONSTRAINT `daily_room_reports_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `igpess_network` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
