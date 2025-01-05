-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 10, 2024 at 03:15 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hsl_kebaya`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(2, 'admin', 'sukakaryaofstrong@gmail.com', '$2y$10$5nZxEowJembfCqLtRKvuiOY1gMIppAO8TfwS3CR7MeIPXG4i1DTuS', '2024-12-04 16:09:55'),
(3, 'amirul', 'karawang@gmail.com', '$2y$10$0qtx/y./HRy2BFfx571.fuX/Csvhf.MrA6xLcDw407plL/gZfHbDS', '2024-12-08 08:21:43'),
(4, 'arif', 'www@gmail.com', '$2y$10$2XCvmgjn/31EFz8f6LTpGOGKUY1injesUONeHhAir1oapd0LUydDi', '2024-12-08 08:29:48'),
(5, 'nurdin', 'mixuekarawang@gmail.com', '$2y$10$BN6TCq8IeXzbNYF6e0.g0OClbgM/12q8z5IFnBKdc4/MlMdU2hcBC', '2024-12-09 12:36:23'),
(6, 'abu', 'abu@gmail.com', '$2y$10$jjgl3.Yjr/ioeRO6M8iy6eV.KTFQHGUByO130.n5PZmou5.JdMw2W', '2024-12-10 15:12:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
