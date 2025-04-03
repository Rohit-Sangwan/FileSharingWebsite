-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 03, 2025 at 02:31 AM
-- Server version: 10.11.10-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u438205861_xxxxxxxxxxxxxx`
--

-- --------------------------------------------------------

--
-- Table structure for table `ad_settings`
--

CREATE TABLE `ad_settings` (
  `id` int(11) NOT NULL,
  `enable_ads` tinyint(1) NOT NULL DEFAULT 0,
  `ad_code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ad_settings`
--

INSERT INTO `ad_settings` (`id`, `enable_ads`, `ad_code`) VALUES
(1, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `shared_links`
--

CREATE TABLE `shared_links` (
  `id` int(11) NOT NULL,
  `file_url` text NOT NULL,
  `short_code` varchar(10) NOT NULL,
  `expires_at` datetime NOT NULL,
  `clicks` int(11) DEFAULT 0,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shared_links`
--

INSERT INTO `shared_links` (`id`, `file_url`, `short_code`, `expires_at`, `clicks`, `ip_address`, `user_agent`, `created_at`) VALUES
(10, 'https://darksalmon-ibis-974395.hostingersite.com/index.php?code=lbJzSY', 'EFcr0f', '0000-00-00 00:00:00', 2, '', '', '2025-04-03 01:08:52'),
(11, 'https://auth-db1823.hstgr.io/index.php?route=/sql&pos=0&db=u438205861_xxxxxxxxxxxxxx&table=shared_links', '19QdLx', '0000-00-00 00:00:00', 0, '', '', '2025-04-03 01:33:03'),
(12, 'https://auth-db1823.hstgr.io/index.php?route=/sql&pos=0&db=u438205861_xxxxxxxxxxxxxx&table=shared_links', 'F8KDH6', '0000-00-00 00:00:00', 0, '', '', '2025-04-03 01:36:41'),
(13, 'https://auth-db1823.hstgr.io/index.php?route=/sql&pos=0&db=u438205861_xxxxxxxxxxxxxx&table=shared_links', 'XZIlJa', '0000-00-00 00:00:00', 7, '', '', '2025-04-03 01:36:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ad_settings`
--
ALTER TABLE `ad_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shared_links`
--
ALTER TABLE `shared_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `short_code` (`short_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ad_settings`
--
ALTER TABLE `ad_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shared_links`
--
ALTER TABLE `shared_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
