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


-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 03, 2026 at 02:31 PM
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
--

-- --------------------------------------------------------

--
-- Table structure for table `igpess_network`
--

CREATE TABLE `igpess_network` (
  `id` int(11) NOT NULL,
  `floor` varchar(50) NOT NULL,
  `room_no` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `icon` varchar(50) DEFAULT 'fa-door-open',
  `networking` varchar(10) DEFAULT NULL,
  `interactive_board` varchar(10) DEFAULT NULL,
  `wifi_router` varchar(10) DEFAULT NULL,
  `cctv` varchar(10) DEFAULT NULL,
  `ups` varchar(10) DEFAULT NULL,
  `audio_video` varchar(10) DEFAULT NULL,
  `room_image` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `width` decimal(10,2) DEFAULT NULL,
  `length` decimal(10,2) DEFAULT NULL,
  `room_members` text,
  `seating_plan` text,
  `in_charge_id` int(11) DEFAULT NULL,
  `facility_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `igpess_network`
--

INSERT INTO `igpess_network` (`id`, `floor`, `room_no`, `description`, `icon`, `networking`, `interactive_board`, `wifi_router`, `cctv`, `ups`, `audio_video`, `room_image`, `remarks`, `latitude`, `longitude`, `width`, `length`, `room_members`, `seating_plan`, `in_charge_id`, `facility_id`) VALUES
(1, 'Ground Floor', '1', 'Principal\'s Office', 'fa-door-open', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', '1778739447_20260514090421.jpg', '192.168.0.1', NULL, NULL, 19.60, 23.90, '[\"-45008\",\"31\",\"-31001\",\"-31004\"]', '{\"type\":\"open\",\"total\":10}', 22, NULL),
(2, 'Ground Floor', '1 A', 'Photocopy Area', 'fa-door-open', 'Yes', 'No', 'Yes', 'No', 'Yes', NULL, '1778651641_20260513091327.jpg', 'Adjurn to principal room', NULL, NULL, 6.00, 4.30, NULL, NULL, 29, NULL),
(3, 'Ground Floor', '2', 'Accounts Section', 'fa-door-open', 'Yes', 'No', 'Yes', 'No', 'Yes', NULL, '1778740731_20260514090653.jpg', NULL, NULL, NULL, 19.35, 22.90, '[\"35\",\"37\",\"-37001\",\"38\",\"-45005\"]', NULL, 35, NULL),
(4, 'Ground Floor', '3', 'Sr. P.A. to Principal\'s Office', 'fa-door-open', 'Yes', NULL, 'Yes', 'Yes', 'Yes', NULL, '1778740760_20260514090708.jpg', NULL, NULL, NULL, 19.60, 9.78, '[\"36\",\"28\",\"-45003\",\"-45011\"]', NULL, 36, NULL),
(5, 'Ground Floor', '4', 'Administrative Officer\'s Office', 'fa-door-open', 'Yes', 'No', 'Yes', 'Yes', 'Yes', NULL, '1778740947_20260514090718.jpg', NULL, NULL, NULL, 19.60, 9.80, '[\"40\",\"44\"]', NULL, 40, NULL),
(6, 'Ground Floor', '4 A', 'Despatch Section', 'fa-door-open', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, '1778651924_20260513091327.jpg', NULL, NULL, NULL, 10.50, 12.10, NULL, NULL, NULL, NULL),
(7, 'Ground Floor', '4 B', 'Bursar Room', 'fa-door-open', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, '1778651891_20260513091746.jpg', NULL, NULL, NULL, 10.50, 12.10, '[\"23\"]', '{\"type\":\"open\",\"total\":4}', 23, NULL),
(8, 'Ground Floor', '5', 'Badminton Court', 'fa-door-open', 'Yes', 'Yes', 'Yes', 'Yes', '', '', '1778652008_20260513092419.jpg', '', '', '', 15.00, 39.98, '[-54006,-44004,-45006,69]', '', 69, NULL),
(9, 'Ground Floor', '6', 'Library', 'fa-door-open', 'Yes', 'No', 'Yes', 'Yes', 'Yes', '', '1778652036_20260513092314.jpg', '', '', '', 57.70, 9.80, '[50,51,53,-53001]', '{\"type\":\"open\",\"total\":62}', NULL, NULL),
(10, 'Ground Floor', '7-8', 'Computer Lab', 'fa-desktop', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', '1778652128_20260513093103.jpg', '', '28.631052', '77.071868', 55.70, 8.80, '[42,-44005,45,-45004]', '{\"type\":\"grid\",\"r\":4,\"c\":10,\"p\":\"CL\",\"b\":[]}', 42, NULL),
(11, 'Ground Floor', '8 A', 'Class Room B.Sc. Part-I Sec. A', 'fa-chalkboard-teacher', 'No', 'No', 'Yes', 'Yes', 'No', 'No', '1778652169_20260513093038.jpg', NULL, NULL, NULL, 36.00, 21.30, NULL, '{\"type\":\"grid\",\"r\":5,\"c\":12,\"p\":\"\",\"b\":[\"1-3\",\"1-4\",\"1-5\",\"1-6\",\"1-7\",\"1-8\",\"1-9\",\"1-10\"]}', NULL, NULL),
(12, 'Ground Floor', '9', 'Teacher\'s Room', 'fa-users', 'Yes', 'No', 'Yes', 'Yes', 'No', 'No', '1778652257_20260513091929.jpg', NULL, NULL, NULL, 23.95, 19.60, '[\"55\",\"56\",\"65\",\"71\"]', NULL, NULL, NULL),
(13, 'Ground Floor', '10', 'Teacher\'s Room', 'fa-users', 'Yes', 'No', 'Yes', 'Yes', 'No', 'No', '1778652386_20260513093431.jpg', NULL, NULL, NULL, 23.85, 19.60, '[\"64\",\"66\",\"70\"]', NULL, NULL, NULL),
(14, 'Ground Floor', '11', 'Multi-Utility Gym (MUG) - Basement', 'fa-door-open', 'Yes', 'No', 'Yes', 'Yes', 'No', 'Yes', '1778652431_20260513093949.jpg', 'Multimedia Projector Available', '', '', 98.42, 50.52, '[-54007,43]', '', 43, NULL),
(15, 'Ground Floor', '12', 'Teacher\'s Room', 'fa-users', 'Yes', 'No', 'Yes', 'Yes', 'No', 'No', '1778652622_20260513093528.jpg', NULL, NULL, NULL, 23.85, 19.60, '[\"57\",\"68\",\"72\"]', NULL, NULL, NULL),
(17, 'Ground Floor', '14', 'Main Store', 'fa-door-open', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, '1778652661_20260513093245.jpg', NULL, NULL, NULL, 23.85, 19.60, '[\"-44002\"]', NULL, -44002, NULL),
(18, 'Ground Floor', '15', 'Teacher\'s Room', 'fa-door-open', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, '1778652776_20260513093327.jpg', NULL, NULL, NULL, 23.85, 19.60, '[\"73\",\"74\"]', NULL, NULL, NULL),
(19, 'Ground Floor', '15 A', 'Class Room B.Sc. Part I Sec. B', 'fa-chalkboard', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, '1778652947_WhatsAppImage20260513at11.45.04AM.jpeg', 'Multimedia Projector', NULL, NULL, 36.00, 21.00, NULL, '{\"type\":\"grid\",\"r\":6,\"c\":12,\"p\":\"\",\"b\":[\"1-3\",\"1-4\",\"1-5\",\"1-6\",\"1-7\",\"1-8\",\"1-9\",\"1-10\"]}', NULL, NULL),
(20, 'Ground Floor', '16', 'Biomechanics Lab', 'fa-chalkboard-teacher', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'Yes', '1778653101_20260513092752.jpg', NULL, NULL, NULL, 23.85, 19.60, '[\"-44003\"]', NULL, NULL, NULL),
(21, 'Ground Floor', '17', 'New Seminar Hall', 'fa-bullhorn', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'Yes', '1778653122_roomno17.jpg', NULL, NULL, NULL, 40.60, 19.60, NULL, '{\"type\":\"grid\",\"r\":14,\"c\":7,\"p\":\"\",\"b\":[\"1-2\",\"1-6\",\"2-3\",\"2-4\",\"2-5\",\"3-5\",\"3-4\",\"3-3\",\"4-3\",\"4-4\",\"4-5\",\"5-5\",\"5-4\",\"5-3\",\"6-3\",\"6-4\",\"6-5\",\"7-5\",\"7-4\",\"7-3\",\"8-3\",\"8-4\",\"8-5\",\"9-5\",\"9-4\",\"9-3\",\"10-3\",\"10-4\",\"10-5\",\"11-5\",\"11-4\",\"11-3\",\"12-3\",\"12-4\",\"12-5\",\"13-5\",\"13-4\",\"13-3\",\"14-3\",\"14-4\",\"14-5\",\"14-6\",\"14-2\"]}', NULL, NULL),
(22, 'First Floor', '18', 'Exercise Physiology Lab', 'fa-chalkboard-teacher', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'Yes', '1778653380_20260513102450.jpg', NULL, NULL, NULL, 23.85, 19.60, '[\"-44002\"]', NULL, NULL, NULL),
(23, 'First Floor', '19', 'Guest Room', 'fa-door-open', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, '1778653453_20260513095521.jpg', NULL, NULL, NULL, 12.00, 8.00, NULL, NULL, NULL, NULL),
(24, 'First Floor', '20', 'Teacher\'s Room', 'fa-users', 'Yes', NULL, 'Yes', 'No', NULL, NULL, '1778653501_20260513095447.jpg', NULL, NULL, NULL, 23.95, 19.60, '[\"60\",\"63\"]', NULL, NULL, NULL),
(25, 'First Floor', '21', 'Staff Room', 'fa-users', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, '1778653605_20260513100242.jpg', NULL, NULL, NULL, 36.00, 21.00, NULL, NULL, NULL, NULL),
(26, 'First Floor', '22', 'Conference Room', 'fa-bullhorn', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'Yes', '1778663478_20260513102558.jpg', NULL, NULL, NULL, 23.85, 19.60, NULL, NULL, NULL, NULL),
(27, 'First Floor', '23', 'Dept. of Physical Education and Sports Sciences (D.U.)', 'fa-door-open', 'Yes', 'No', 'Yes', 'Yes', NULL, NULL, '1778664918_20260513100337.jpg', 'Multimedia Projector', NULL, NULL, 36.00, 21.00, '[\"58\"]', NULL, 58, NULL),
(28, 'First Floor', '24', 'Teacher\'s Room', 'fa-users', 'Yes', NULL, 'Yes', NULL, NULL, NULL, '1778668559_20260513095214.jpg', NULL, NULL, NULL, 36.00, 20.99, '[\"61\",\"62\"]', NULL, NULL, NULL),
(29, 'First Floor', '25', 'Class Room B.Sc. Part II (A)', 'fa-chalkboard', 'Yes', '', 'Yes', 'Yes', '', '', '1778668915_20260513094511.jpg', 'Multimedia Projector', '', '', 23.85, 19.60, NULL, '{\"type\":\"grid\",\"r\":5,\"c\":6,\"p\":\"R-25/\",\"b\":[]}', NULL, NULL),
(30, 'First Floor', '25 A', 'Class Room B.Sc. Part II (C)', 'fa-chalkboard', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, '1778669402_20260513094439.jpg', NULL, NULL, NULL, 36.00, 21.00, NULL, NULL, NULL, NULL),
(31, 'First Floor', '26', 'Class Room B.Sc. Part II (B)', 'fa-chalkboard', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, NULL, 'Multimedia Projector', NULL, NULL, 23.85, 19.60, NULL, NULL, NULL, NULL),
(32, 'First Floor', '27', 'Class Room B.P.Ed. Part-II (B)', 'fa-chalkboard', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, NULL, 'Multimedia Projector', NULL, NULL, 23.85, 19.60, NULL, NULL, NULL, NULL),
(33, 'First Floor', '28', 'Class Room B.P.Ed. Part- II (A)', 'fa-chalkboard', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, NULL, 'Multimedia Projector', NULL, NULL, 23.85, 19.60, NULL, NULL, NULL, NULL),
(34, 'First Floor', '29', 'Class Room M.P.Ed. Part I', 'fa-chalkboard', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, NULL, 'Multimedia Projector', NULL, NULL, 23.85, 19.60, NULL, NULL, NULL, NULL),
(35, 'First Floor', '30', 'Class Room M.P.Ed. Part II', 'fa-chalkboard', 'Yes', 'No', 'Yes', 'Yes', NULL, NULL, NULL, 'Multimedia Projector', NULL, NULL, 23.85, 19.60, NULL, NULL, NULL, NULL),
(36, 'First Floor', '31', 'Class Room B.P.Ed. Part- I (A)', 'fa-chalkboard', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, NULL, 'Multimedia Projector', NULL, NULL, 23.85, 19.60, NULL, NULL, NULL, NULL),
(37, 'First Floor', '32', 'Class Room B.P.Ed. Part- I (B)', 'fa-chalkboard', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, NULL, 'Multimedia Projector', NULL, NULL, 23.85, 19.60, NULL, NULL, NULL, NULL),
(38, 'First Floor', '32 A', 'Class Room B.Sc. I Sec (C)', 'fa-chalkboard', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, NULL, 'Multimedia Projector', NULL, NULL, 23.85, 19.60, NULL, NULL, NULL, NULL),
(39, 'First Floor', '33', 'Anatomy & Physiology Lab', 'fa-chalkboard-teacher', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'Yes', NULL, NULL, NULL, NULL, 36.00, 21.00, '[\"-44001\"]', NULL, NULL, NULL),
(40, 'Second Floor', '34', 'Psychology Lab', 'fa-chalkboard-teacher', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'Yes', NULL, NULL, NULL, NULL, 36.00, 21.00, '[\"65\"]', NULL, 65, NULL),
(41, 'Second Floor', '35', 'Teacher\'s Room', 'fa-users', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, 23.85, 19.60, '[\"58\"]', NULL, 58, NULL),
(42, 'Second Floor', '36', 'Sub-Store', 'fa-chalkboard', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, 23.85, 19.60, NULL, NULL, NULL, NULL),
(43, 'Second Floor', '37', 'Class Room', 'fa-chalkboard', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, 23.85, 19.60, NULL, NULL, NULL, NULL),
(44, 'Second Floor', '38', 'Class Room B.Sc. Part-III (A)', 'fa-chalkboard', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, 23.85, 19.60, NULL, NULL, NULL, NULL),
(45, 'Second Floor', '39', 'Class Room B.Sc. Part-III (B)', 'fa-chalkboard', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, 23.85, 19.60, NULL, NULL, NULL, NULL),
(46, 'Second Floor', '40', 'Audio-Visual Lab', 'fa-chalkboard-teacher', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, NULL, 'Overhead & Multimedia Projector', NULL, NULL, 23.85, 19.60, NULL, NULL, NULL, NULL),
(47, 'Second Floor', '41', 'Audio Visual Lab', 'fa-chalkboard-teacher', 'Yes', NULL, 'Yes', NULL, NULL, NULL, NULL, 'Multimedia & overhead Projector', NULL, NULL, 23.85, 19.60, NULL, NULL, NULL, NULL),
(48, 'Second Floor', '42', 'Class Room B.Sc. Class-III (C)', 'fa-chalkboard', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, 23.85, 19.60, NULL, NULL, NULL, NULL),
(49, 'Second Floor', '43', 'Class Room', 'fa-chalkboard', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, 23.85, 19.60, NULL, NULL, NULL, NULL),
(50, 'Second Floor', '44', 'Class Room', 'fa-chalkboard', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, 36.00, 21.00, NULL, NULL, NULL, NULL),
(51, 'Second Floor', '45', 'Behavioural Science Lab', 'fa-chalkboard', 'Yes', NULL, 'Yes', 'Yes', NULL, NULL, NULL, 'Multimedia Projector', NULL, NULL, 36.00, 21.00, NULL, NULL, NULL, NULL),
(52, 'Ground Floor', 'Main', 'Main Enterance Hall', 'fa-door-open', 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'Yes', '1778650789_20260513091120.jpg', '', '', '', 56.40, 55.70, NULL, '{\"type\":\"grid\",\"r\":5,\"c\":5,\"p\":\"S\",\"b\":[]}', NULL, 1),
(54, 'Ground Floor', '13', 'Medical Centre & Physiotherapy Lab', 'fa-door-open', 'Yes', 'No', 'Yes', 'Yes', 'No', 'No', '1778652542_20260513093604.jpg', NULL, '28.630937', '77.072337', 23.85, 19.60, '[\"97\",\"48\",\"-31002\"]', NULL, 97, NULL),
(55, 'Ground Floor', 'SDS', 'Student Dealing Section', 'fa-door-open', 'Yes', '', 'Yes', 'Yes', 'Yes', '', 'IMG_20260601_120817.jpg', '', '', '', 16.00, 32.00, '[41,27,-28001,29,-45002,-45010,-31003]', '', 41, NULL),
(56, 'Ground Floor', '5A', 'Yoga Lab', 'fa-door-open', '', '', '', '', '', '', '', '', '', '', 15.00, 40.00, NULL, '', NULL, NULL),
(57, 'Ground Floor', 'Hall', 'Gymnasium Hall', 'fa-door-open', '', '', '', '', '', '', '', '', '', '', 75.00, 64.00, NULL, '', NULL, NULL),
(58, 'Ground Floor', 'Hall', 'Multipurpose Hall', 'fa-door-open', '', '', '', '', '', '', '', '', '', '', 40.00, 80.00, NULL, '', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `igpess_network`
--
ALTER TABLE `igpess_network`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `igpess_network`
--
ALTER TABLE `igpess_network`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

