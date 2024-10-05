-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 03, 2024 at 11:09 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mislang_reymel`
--

-- --------------------------------------------------------

--
-- Table structure for table `rrm_users`
--

DROP TABLE IF EXISTS `rrm_users`;
CREATE TABLE IF NOT EXISTS `rrm_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rrm_last_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rrm_first_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rrm_email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rrm_gender` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rrm_address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rrm_password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `rrm_username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rrm_users`
--

INSERT INTO `rrm_users` (`id`, `rrm_last_name`, `rrm_first_name`, `rrm_email`, `rrm_gender`, `rrm_address`, `rrm_password`, `rrm_username`) VALUES
(22, 'Smith,mojioj', 'John', 'john.smith@example.com', 'Male', '123 Main St, Anytown', '', ''),
(23, 'Doe', 'Jane', 'jane.doe@example.com', 'Female', '456 Elm St, Othertown', '', ''),
(24, 'Johnson', 'James', 'james.johnson@example.com', 'Male', '789 Maple St, Elsewhere', '', ''),
(25, 'Brown', 'Emily', 'emily.brown@example.com', 'Female', '101 Pine St, Somewhere', '', ''),
(26, 'Taylor', 'Michael', 'michael.taylor@example.com', 'Male', '202 Cedar St, Anywhere', '', ''),
(27, 'Wilson', 'testity', 'sarah.wilson@example.com', 'Female', '303 Oak St, Overthere', '', ''),
(28, 'Moore', 'Daniel', 'daniel.moore@example.com', 'Male', '404 Birch St, Anywhere', '', ''),
(29, 'Anderson', 'Laura', 'laura.anderson@example.com', 'Female', '505 Spruce St, Somewhere', '', ''),
(30, 'Thomas', 'Robert', 'robert.thomas@example.com', 'Male', '606 Chestnut St, Anytown', '', ''),
(37, 'test', 'test', 'test@gmail.com', 'male', 'Laguna, Naujan Oriental Mindoro', '', ''),
(39, 'MISLANG', 'IMELDA', 'mislangreymel6@gmail.com', 'Female', 'Laguna, Naujan Oriental Mindoro', '', ''),
(41, 'final ', 'testing', 'kasinabura@gmail.com', 'Female', 'mag update ka na', '', ''),
(43, 'pacheck', 'muna', 'pacheck@gmail.com', 'Male', 'kay sir ron', '$2y$10$.0WnBa.ohzA1gPcWURyrieD/WhS4sisHC1ci/7GGl6Ybshonin252', ''),
(44, 'forda', 'validation', 'reymelrey.mislang@gmail.com', 'male', 'Sitio 5 Laguna', '$2y$10$.vPTryzCag4ch4MdDUzcQeS5WLf7XWgKhPElt1FyYbCnh9Zl1ixPm', ''),
(45, '', 'reymel', 'reymelrey.mislang@gmail.com', '', '', '', ''),
(46, '', 'reymel', 'reymelrey.mislang@gmail.com', '', '', '', ''),
(47, '', 'reymelrey20', 'reymelrey.mislang@gmail.com', '', '', '', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
