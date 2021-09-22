-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2021 at 11:06 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reskara-admin-kit-ci3`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `sequence` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `path`, `parent`, `icon`, `sequence`) VALUES
(1, 'Dashboard', 'admin/dashboard', NULL, '<i class=\"fa fa-tachometer-alt text-blue\"></i>', 0),
(2, 'Master', '#', NULL, '<i class=\"fa fa-dharmachakra text-orange\"></i>', 1),
(3, 'Users', 'admin/master/user', 2, '', 2),
(4, 'Setting', '#', NULL, '<i class=\"fa fa-cogs text-black\"></i>', 3),
(5, 'Password', 'admin/setting/password', 4, '', 4),
(6, 'Privilege', 'admin/setting/privilege', 4, '', 5);

-- --------------------------------------------------------

--
-- Table structure for table `privilege`
--

CREATE TABLE `privilege` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privilege`
--

INSERT INTO `privilege` (`id`, `name`) VALUES
(1, 'developer'),
(2, 'Admin'),
(3, 'Employee');

-- --------------------------------------------------------

--
-- Table structure for table `privilege_menu`
--

CREATE TABLE `privilege_menu` (
  `id` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `id_privilege` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privilege_menu`
--

INSERT INTO `privilege_menu` (`id`, `id_menu`, `id_privilege`) VALUES
(3, 3, 1),
(13, 1, 3),
(14, 1, 1),
(15, 2, 1),
(18, 4, 1),
(20, 5, 1),
(39, 4, 3),
(41, 4, 3),
(42, 3, 3),
(43, 2, 3),
(44, 6, 3),
(45, 4, 3),
(46, 5, 3),
(47, 4, 3),
(48, 6, 1),
(49, 3, 2),
(50, 2, 2),
(51, 6, 2),
(52, 4, 2),
(53, 5, 2),
(54, 4, 2),
(55, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_privilege` int(11) DEFAULT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `full_name`, `username`, `password`, `id_privilege`, `phone_number`, `address`, `email`, `avatar`) VALUES
(1, 'Gilang Pratama', 'developer', '21232f297a57a5a743894a0e4a801fc3', 1, '0822983928', 'Jln. jln-saja', 'paijo@email.domain', 'public/img/user-avatar/gp-white.jpg'),
(31, 'Administrator', 'admin', '21232f297a57a5a743894a0e4a801fc3', 2, '', '', 'admin@gmail.com', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privilege`
--
ALTER TABLE `privilege`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privilege_menu`
--
ALTER TABLE `privilege_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_privilege_menu_menu` (`id_menu`),
  ADD KEY `FK_privilege_menu_privilege` (`id_privilege`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_privilege` (`id_privilege`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `privilege`
--
ALTER TABLE `privilege`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `privilege_menu`
--
ALTER TABLE `privilege_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `privilege_menu`
--
ALTER TABLE `privilege_menu`
  ADD CONSTRAINT `FK_privilege_menu_menu` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_privilege_menu_privilege` FOREIGN KEY (`id_privilege`) REFERENCES `privilege` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_user_privilege` FOREIGN KEY (`id_privilege`) REFERENCES `privilege` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
