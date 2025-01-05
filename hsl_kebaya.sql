-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 05, 2025 at 09:27 AM
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
-- Table structure for table `charts`
--

CREATE TABLE `charts` (
  `keranjang_id` int NOT NULL,
  `id_produk` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `durasi` int DEFAULT NULL,
  `total_harga` int DEFAULT NULL,
  `tanggal_reservasi` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallerys`
--

CREATE TABLE `gallerys` (
  `id` int NOT NULL,
  `kebaya_id` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gallerys`
--

INSERT INTO `gallerys` (`id`, `kebaya_id`, `nama`, `model`, `description`, `image`) VALUES
(7, 'test', 'Kebaya tarian', 'wewef', 'efarf', '123.jpg'),
(8, 'B', 'B', 'TEST', 'rgsg', 'Amirulhakim - 23416255201273 - IF23G.jpg'),
(9, 'A', 'A', 'Karpuc', 'wefarf', 'gal.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int NOT NULL,
  `kode_reservasi` varchar(50) NOT NULL,
  `payment_method` enum('transfer_bank','qris','cash') NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `payment_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','success') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `kode_reservasi`, `payment_method`, `total_harga`, `payment_date`, `status`) VALUES
(14, 'R2024122905025712', 'transfer_bank', '200000.00', '2025-01-01 10:48:34', 'success'),
(15, 'R2024123119054927', 'cash', '200000.00', '2025-01-01 10:55:26', 'success'),
(17, 'R2025010105100728', 'cash', '200000.00', '2025-01-01 12:10:39', 'success'),
(18, 'R2025010315125428', 'qris', '200000.00', '2025-01-03 22:13:23', 'success'),
(19, 'R2025010505402928', 'transfer_bank', '100000.00', '2025-01-05 12:42:51', 'success'),
(20, 'R2025010506000912', 'cash', '200000.00', '2025-01-05 13:04:35', 'success'),
(21, 'R2025010508181012', 'qris', '200000.00', '2025-01-05 15:18:21', 'success');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int NOT NULL,
  `kebaya_id` varchar(50) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `ukuran` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `jenis` enum('Kebaya','Jas','Aksesoris') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `stock` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `kebaya_id`, `nama`, `ukuran`, `deskripsi`, `foto`, `harga`, `jenis`, `stock`, `created_at`) VALUES
(34, 'K01', 'Kebaya Pengantin', 'Dewasa', 'santai qawanku', '5.jpg', '100000.00', 'Kebaya', 6, '2024-12-28 17:53:34'),
(35, 'M01', 'Kebaya zigaer', 'Dewasa', 'Sangat cocok untuk bersantai qawan', '8.jpg', '100000.00', 'Kebaya', 7, '2024-12-28 17:54:05');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservasi_id` int NOT NULL,
  `id_produk` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `kode_reservasi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `durasi` int DEFAULT NULL,
  `total_harga` int DEFAULT NULL,
  `tanggal_reservasi` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Pending','Booked','Paid','Completed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservasi_id`, `id_produk`, `user_id`, `kode_reservasi`, `tanggal_mulai`, `tanggal_selesai`, `durasi`, `total_harga`, `tanggal_reservasi`, `created_at`, `status`) VALUES
(62, 16, 13, 'R2024122814295413', '2024-12-28', '2024-12-29', 1, 230000, '2024-12-28', '2024-12-28 14:29:54', 'Pending'),
(63, 23, 13, 'R2024122814295413', '2024-12-28', '2024-12-29', 1, 145000, '2024-12-28', '2024-12-28 14:29:54', 'Pending'),
(75, 34, 12, 'R2024122905025712', '2024-12-29', '2024-12-30', 1, 100000, '2024-12-29', '2024-12-29 05:02:57', 'Completed'),
(76, 35, 12, 'R2024122905025712', '2024-12-29', '2024-12-30', 1, 100000, '2024-12-29', '2024-12-29 05:02:57', 'Completed'),
(77, 34, 27, 'R2024123119054927', '2025-01-01', '2025-01-02', 1, 100000, '2024-12-31', '2024-12-31 19:05:49', 'Completed'),
(78, 35, 27, 'R2024123119054927', '2025-01-01', '2025-01-02', 1, 100000, '2024-12-31', '2024-12-31 19:05:49', 'Completed'),
(82, 34, 28, 'R2025010105100728', '2025-01-01', '2025-01-02', 1, 100000, '2025-01-01', '2025-01-01 05:10:07', 'Completed'),
(83, 35, 28, 'R2025010105100728', '2025-01-01', '2025-01-02', 1, 100000, '2025-01-01', '2025-01-01 05:10:07', 'Completed'),
(84, 34, 28, 'R2025010315125428', '2025-01-03', '2025-01-04', 1, 100, '2025-01-03', '2025-01-03 15:12:54', 'Completed'),
(85, 35, 28, 'R2025010315125428', '2025-01-03', '2025-01-04', 1, 100, '2025-01-03', '2025-01-03 15:12:54', 'Completed'),
(86, 34, 28, 'R2025010505402928', '2025-01-04', '2025-01-05', 1, 100, '2025-01-05', '2025-01-05 05:40:29', 'Completed'),
(87, 34, 12, 'R2025010506000912', '2025-01-04', '2025-01-05', 1, 100, '2025-01-05', '2025-01-05 06:00:09', 'Completed'),
(88, 35, 12, 'R2025010506000912', '2025-01-04', '2025-01-05', 1, 100, '2025-01-05', '2025-01-05 06:00:09', 'Completed'),
(94, 35, 12, 'R2025010508181012', '2025-01-05', '2025-01-06', 1, 100, '2025-01-05', '2025-01-05 08:18:10', 'Completed'),
(95, 34, 12, 'R2025010508181012', '2025-01-05', '2025-01-06', 1, 100, '2025-01-05', '2025-01-05 08:18:10', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `phone` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `foto_profil` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `created_at`, `phone`, `address`, `foto_profil`, `role`) VALUES
(7, 'Amirul Hakim', 'if23.amirulhakim@mhs.ubpkarawang.ac.id', '$2y$10$C.7/1pstpqKlAdWde26.pOKHcuPChRDmQv4xsoGD5ElM6AjCpADNa', '2024-12-15 14:49:36', '088295532520', 'Dk. sidamukti adisana', '../../img/uploads/676d2731ed6a5_WhatsApp Image 2024-07-20 at 17.10.06_abd8db34.jpg', 'admin'),
(12, 'Ghaitsa Salsabila Zahra', 'amirul@gmail.com', '$2y$10$/WIInNhEHT6It5SdXPkwzepbs52hJwGk8wN893FtdV0w06aBZYzIq', '2024-12-25 16:45:52', '+6288295532520', 'Dk. Sidamukti, Adisana, rt/05, rw/05, bumiayu, brebes, jawa tengah, indonesia', '../../img/uploads/676c4172a5334_IMG20240919081148.jpg', 'user'),
(27, 'sasti', 'sasti@gmail.com', '$2y$10$ILStUFlzXjoNWn1NioznHeRuidDy06/D00XHQrf5QAU/tbKMsTRHi', '2024-12-31 19:04:51', '08973849823', 'ksjrhfiuhrf', '67744053b7332_IMG_6776.JPG', 'user'),
(28, 'sasti', 'sastu@gmail.com', '$2y$10$q2pXUd8DTb7bXQ8pJVs2Ru2RQw1APTHB0CnP7Fou0jW2/Xog.5LLO', '2024-12-31 19:04:51', '08973849823', 'ksjrhfiuhrf', '67744053dec50_IMG_6776.JPG', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `charts`
--
ALTER TABLE `charts`
  ADD PRIMARY KEY (`keranjang_id`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `gallerys`
--
ALTER TABLE `gallerys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `kode_reservasi` (`kode_reservasi`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservasi_id`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `fk_user` (`user_id`),
  ADD KEY `idx_kode_reservasi` (`kode_reservasi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `charts`
--
ALTER TABLE `charts`
  MODIFY `keranjang_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `gallerys`
--
ALTER TABLE `gallerys`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservasi_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `charts`
--
ALTER TABLE `charts`
  ADD CONSTRAINT `charts_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`kode_reservasi`) REFERENCES `reservations` (`kode_reservasi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
