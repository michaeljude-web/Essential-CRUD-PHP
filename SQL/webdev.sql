-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2024 at 02:17 AM
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
-- Database: `webdev`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `ID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`ID`, `email`, `password`) VALUES
(1, 'garde@admin.com', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `myguest`
--

CREATE TABLE `myguest` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `myguest`
--

INSERT INTO `myguest` (`id`, `firstname`, `lastname`, `email`, `reg_date`) VALUES
(12, 'Juan', 'Dela Cruz', 'juan1@wgail.com', '2024-09-03 13:40:28'),
(18, 'Bea', 'Ramirez', 'bea@gmail.com', '2024-09-04 14:19:47'),
(20, 'Layla', 'Cruz', 'layla0@user.com', '2024-09-04 12:42:27'),
(21, 'Mia', 'Kp', 'm@gmail.com', '2024-09-04 23:58:08'),
(22, 'trizzle', 'balais', 'trizzle@gmail.com', '2024-09-06 11:56:45'),
(25, 'haron', 'lostania', 'hlostania@gmail.com', '2024-09-07 06:57:10'),
(30, 'Alena', 'Cruz', 'alena@gmail.com', '2024-09-09 12:22:43'),
(31, 'Celine', 'Drilon', 'cd2@gmail.com', '2024-09-09 12:23:41'),
(32, 'Dianna', 'Rodrigez', 'rodrigez7@gmail.com', '2024-09-09 12:24:48'),
(33, 'Zian', 'Rodrigo', 'zian1199@gmail.com', '2024-09-09 12:26:13'),
(34, 'Zian', 'Rodrigo', 'zian119S9@gmail.com', '2024-09-09 22:58:48'),
(35, 'Zian', 'Rodrigo', 'zian11d9S9@gmail.com', '2024-09-10 11:21:17'),
(36, 'Zian', 'Rodrigo', 'zian11dd9S9@gmail.com', '2024-09-10 11:22:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `myguest`
--
ALTER TABLE `myguest`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `myguest`
--
ALTER TABLE `myguest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
