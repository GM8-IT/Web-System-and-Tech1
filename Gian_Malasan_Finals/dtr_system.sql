-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2025 at 10:35 AM
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
-- Database: `dtr_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_type` enum('admin','faculty') DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `user_type`, `picture`, `created_at`) VALUES
(4, 'Boss Seth', 'Boseth', '$2y$10$oHDOlDmqu6LrFPX7oTIrkuilYdNwNX182JMvSKOvm07scmiGd7vPy', 'admin', 'pic_69353757637ad.png', '2025-12-07 16:14:15'),
(5, 'Gian Sample', 'Gian', '$2y$10$9B00LNOBegfZHr3oINGzRuxzAFEKI0RYTTZganQoQkClBiozcI2lK', 'faculty', 'pic_69353ab334aa1.png', '2025-12-07 16:28:35'),
(7, 'Monkey Luffy', 'Luffy', '$2y$10$s8MZAoje3nLOb/.j0ndqXOPobKPN5Qxh3SljojBPyJUtW2WMiJLwG', 'faculty', NULL, '2025-12-07 16:29:17'),
(8, 'Shanks', 'Shanks', '$2y$10$Z6emCLVMevX7LCMJpf4cAus3D9uzfk59QBOJp3G3VyAKQ21iVNtrm', 'faculty', NULL, '2025-12-07 16:29:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
