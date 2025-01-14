-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table hsl_kebaya.charts
CREATE TABLE IF NOT EXISTS `charts` (
  `keranjang_id` int NOT NULL AUTO_INCREMENT,
  `id_produk` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `durasi` int DEFAULT NULL,
  `total_harga` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `tanggal_reservasi` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`keranjang_id`),
  KEY `id_produk` (`id_produk`),
  KEY `fk_user` (`user_id`),
  CONSTRAINT `charts_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `products` (`product_id`),
  CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table hsl_kebaya.charts: ~0 rows (approximately)

-- Dumping structure for table hsl_kebaya.gallerys
CREATE TABLE IF NOT EXISTS `gallerys` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kebaya_id` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table hsl_kebaya.gallerys: ~3 rows (approximately)
INSERT INTO `gallerys` (`id`, `kebaya_id`, `nama`, `model`, `description`, `image`) VALUES
	(7, 'test', 'Kebaya', 'Kebaya', 'Untuk Wisuda', '123.jpg'),
	(8, 'B', 'Kebaya Adat', 'Kebaya', 'Adat sunda', 'aksesoris.jpg'),
	(9, 'A', 'Gaun Kebaya', 'Gaun', 'Untuk resepsi pernikahan', 'gal.jpg');

-- Dumping structure for table hsl_kebaya.payments
CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `kode_reservasi` varchar(50) NOT NULL,
  `payment_method` enum('transfer_bank','qris','cash') NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `payment_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','success') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `kode_reservasi` (`kode_reservasi`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`kode_reservasi`) REFERENCES `reservations` (`kode_reservasi`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table hsl_kebaya.payments: ~0 rows (approximately)
INSERT INTO `payments` (`payment_id`, `kode_reservasi`, `payment_method`, `total_harga`, `payment_date`, `status`) VALUES
	(22, 'R2025011211244829', 'transfer_bank', 900000.00, '2025-01-12 18:33:47', 'success');

-- Dumping structure for table hsl_kebaya.products
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `kebaya_id` varchar(50) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `ukuran` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `jenis` enum('Kebaya','Jas','Aksesoris') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `stock` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table hsl_kebaya.products: ~5 rows (approximately)
INSERT INTO `products` (`product_id`, `kebaya_id`, `nama`, `ukuran`, `deskripsi`, `foto`, `harga`, `jenis`, `stock`, `created_at`) VALUES
	(34, 'K01', 'Kebaya Pengantin', 'Dewasa', 'santai qawanku', '5.jpg', 100000.00, 'Kebaya', 184, '2024-12-28 17:53:34'),
	(35, 'M01', 'Kebaya zigaer', 'Dewasa', 'Sangat cocok untuk bersantai qawan', '8.jpg', 100000.00, 'Kebaya', 187, '2024-12-28 17:54:05'),
	(36, '32', 'Kebaya abaya', 'Dewasa', 'Untuk wisuda', '2.jpg', 200000.00, 'Kebaya', 190, '2025-01-12 10:47:48'),
	(37, '11', 'JAS', 'XL', 'Untuk acara formal', 'IMG_0383.jpg', 150000.00, 'Jas', 3, '2025-01-13 14:35:23'),
	(38, '12', 'AKSESORIS', '-', 'Cocok untuk tambahan aksesoris kebaya ', 'IMG_0424.jpg', 50000.00, 'Aksesoris', 19, '2025-01-13 14:36:23');

-- Dumping structure for table hsl_kebaya.reservations
CREATE TABLE IF NOT EXISTS `reservations` (
  `reservasi_id` int NOT NULL AUTO_INCREMENT,
  `id_produk` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `kode_reservasi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `durasi` int DEFAULT NULL,
  `total_harga` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `tanggal_reservasi` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Pending','Booked','Paid','Completed') NOT NULL,
  PRIMARY KEY (`reservasi_id`),
  KEY `id_produk` (`id_produk`),
  KEY `fk_user` (`user_id`),
  KEY `idx_kode_reservasi` (`kode_reservasi`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table hsl_kebaya.reservations: ~10 rows (approximately)
INSERT INTO `reservations` (`reservasi_id`, `id_produk`, `user_id`, `kode_reservasi`, `tanggal_mulai`, `tanggal_selesai`, `durasi`, `total_harga`, `quantity`, `tanggal_reservasi`, `created_at`, `status`) VALUES
	(113, 34, 29, 'R2025011211244829', '2025-01-12', '2025-01-13', 1, 200, 2, '2025-01-12', '2025-01-12 11:24:48', 'Paid'),
	(114, 35, 29, 'R2025011211244829', '2025-01-12', '2025-01-13', 1, 300, 3, '2025-01-12', '2025-01-12 11:24:48', 'Paid'),
	(115, 36, 29, 'R2025011211244829', '2025-01-12', '2025-01-13', 1, 400, 2, '2025-01-12', '2025-01-12 11:24:48', 'Paid'),
	(116, 35, 29, 'R2025011412512929', '2025-01-13', '2025-01-14', 1, 200, 2, '2025-01-13', '2025-01-14 12:51:29', 'Pending'),
	(117, 34, 29, 'R2025011412512929', '2025-01-13', '2025-01-20', 1, 100, 1, '2025-01-13', '2025-01-14 12:51:29', 'Pending'),
	(118, 34, 29, 'R2025011412512929', '2025-01-13', '2025-01-14', 1, 100, 1, '2025-01-13', '2025-01-14 12:51:29', 'Pending'),
	(119, 34, 29, 'R2025011412512929', '2025-01-13', '2025-01-14', 1, 100, 1, '2025-01-13', '2025-01-14 12:51:29', 'Pending'),
	(120, 35, 29, 'R2025011412512929', '2025-01-13', '2025-01-14', 1, 100, 1, '2025-01-13', '2025-01-14 12:51:29', 'Pending'),
	(121, 35, 29, 'R2025011412512929', '2025-01-13', '2025-01-14', 1, 100, 1, '2025-01-13', '2025-01-14 12:51:29', 'Pending'),
	(122, 35, 29, 'R2025011412512929', '2025-01-14', '2025-01-15', 1, 100, 1, '2025-01-14', '2025-01-14 12:51:29', 'Pending');

-- Dumping structure for table hsl_kebaya.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `phone` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `foto_profil` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table hsl_kebaya.users: ~4 rows (approximately)
INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `created_at`, `phone`, `address`, `foto_profil`, `role`) VALUES
	(7, 'Amirul Hakim', 'if23.amirulhakim@mhs.ubpkarawang.ac.id', '$2y$10$C.7/1pstpqKlAdWde26.pOKHcuPChRDmQv4xsoGD5ElM6AjCpADNa', '2024-12-15 14:49:36', '088295532520', 'Dk. sidamukti adisana', '../../img/uploads/676d2731ed6a5_WhatsApp Image 2024-07-20 at 17.10.06_abd8db34.jpg', 'admin'),
	(12, 'Ghaitsa Salsabila Zahra', 'amirul@gmail.com', '$2y$10$/WIInNhEHT6It5SdXPkwzepbs52hJwGk8wN893FtdV0w06aBZYzIq', '2024-12-25 16:45:52', '+6288295532520', 'Dk. Sidamukti, Adisana, rt/05, rw/05, bumiayu, brebes, jawa tengah, indonesia', '../../img/uploads/676c4172a5334_IMG20240919081148.jpg', 'user'),
	(27, 'sasti', 'sasti@gmail.com', '$2y$10$ILStUFlzXjoNWn1NioznHeRuidDy06/D00XHQrf5QAU/tbKMsTRHi', '2024-12-31 19:04:51', '08973849823', 'ksjrhfiuhrf', '67744053b7332_IMG_6776.JPG', 'user'),
	(28, 'sasti', 'sastu@gmail.com', '$2y$10$q2pXUd8DTb7bXQ8pJVs2Ru2RQw1APTHB0CnP7Fou0jW2/Xog.5LLO', '2024-12-31 19:04:51', '08973849823', 'ksjrhfiuhrf', '67744053dec50_IMG_6776.JPG', 'user'),
	(29, 'yaya', 'yaya@gmail.com', '$2y$10$b0OITav9Cyq1IYuyXpAQnOjd9CPHhj9u.CNdE0EBEuebckRzY/4L2', '2025-01-09 14:06:50', '08871447537', 'Karawang', '', 'user');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
