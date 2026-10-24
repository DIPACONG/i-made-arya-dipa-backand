-- ==============================================================
-- DATABASE: jepret_db
-- Project: Toko Foto Jepret (RESTful API & Database)
-- Mahasiswa: I Made Arya Dipa
-- Modul: BAB III Backend Web Programming
-- Dioptimasi untuk MySQL 8.0+ / 8.4+ (Bebas Warning)
-- ==============================================================

CREATE DATABASE IF NOT EXISTS `jepret_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `jepret_db`;

-- -------------------------------------------------------------
-- 1. Table structure for table `users`
-- -------------------------------------------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `photos`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `users`
-- Password admin: admin123
-- Password test: password
INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Admin Jepret', 'admin@jepret.id', '$2y$10$.XQpc.lH29obocbac0V1E.LH2gD3YGu9RYphrVBsrAJf1M0vFfUPy', NOW(), NOW()),
(2, 'Test User', 'test@example.com', '$2y$10$.XQpc.lH29obocbac0V1E.LH2gD3YGu9RYphrVBsrAJf1M0vFfUPy', NOW(), NOW());

-- -------------------------------------------------------------
-- 2. Table structure for table `personal_access_tokens` (Sanctum)
-- -------------------------------------------------------------
CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 3. Table structure for table `categories`
-- -------------------------------------------------------------
CREATE TABLE `categories` (
  `category_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `categories`
INSERT INTO `categories` (`category_id`, `category`, `created_at`, `updated_at`) VALUES
(1, 'Pasar', NOW(), NOW()),
(2, 'Pelabuhan', NOW(), NOW()),
(3, 'Jalanan', NOW(), NOW()),
(4, 'Budaya', NOW(), NOW()),
(5, 'Alam', NOW(), NOW());

-- -------------------------------------------------------------
-- 4. Table structure for table `photos`
-- -------------------------------------------------------------
CREATE TABLE `photos` (
  `photo_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `photographer` varchar(150) NOT NULL DEFAULT 'I Made Arya Dipa',
  `tags` json DEFAULT NULL,
  `w` int NOT NULL DEFAULT 1600,
  `h` int NOT NULL DEFAULT 1067,
  `price` decimal(12,2) NOT NULL DEFAULT 85000.00,
  `img` varchar(255) DEFAULT NULL,
  `downloads` int NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`photo_id`),
  UNIQUE KEY `photos_slug_unique` (`slug`),
  KEY `photos_category_id_foreign` (`category_id`),
  CONSTRAINT `photos_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `photos`
INSERT INTO `photos` (`photo_id`, `title`, `slug`, `category_id`, `photographer`, `tags`, `w`, `h`, `price`, `img`, `downloads`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Angkutan Pelabuhan', 'angkutan-pelabuhan-1', 2, 'I Made Arya Dipa', '[\"angkutan\", \"pelabuhan\", \"mobil\", \"perbukitan\"]', 1067, 1600, 85000.00, 'photos/angkutan-pelabuhan.jpg', 0, 'Foto suasana angkutan logistik dan lalu lintas di kawasan dermaga pelabuhan.', NOW(), NOW()),
(2, 'Cerobong Asap Kapal', 'cerobong-asap-kapal-2', 2, 'I Made Arya Dipa', '[\"cerobong\", \"asap\", \"kapal\", \"langit\"]', 1067, 1600, 85000.00, 'photos/cerobong-asap-kapal.jpg', 0, 'Cerobong asap kapal feri berlayar melintasi selat dengan latar langit cerah.', NOW(), NOW()),
(3, 'Cerobong', 'cerobong-3', 2, 'I Made Arya Dipa', '[\"cerobong\", \"kapal\", \"biru\"]', 1067, 1600, 85000.00, 'photos/cerobong.jpg', 0, 'Detail struktur cerobong kapal feri berlatar biru cerah.', NOW(), NOW()),
(4, 'Ibuk Penjual', 'ibuk-penjual-4', 1, 'I Made Arya Dipa', '[\"pasar\", \"penjual\", \"payung\", \"motor\"]', 1600, 1067, 85000.00, 'photos/ibuk-penjual.jpg', 0, 'Aktivitas ibu pedagang pasar tradisional di pagi hari dengan payung pelindung.', NOW(), NOW()),
(5, 'Meja Dirumput', 'meja-dirumput-5', 5, 'I Made Arya Dipa', '[\"meja\", \"rumput\", \"taman\", \"pantai\"]', 1067, 1600, 85000.00, 'photos/meja-dirumput.jpg', 0, 'Meja kayu di atas hamparan rumput hijau asri menghadap pesisir.', NOW(), NOW()),
(6, 'Memarkir', 'memarkir-6', 3, 'I Made Arya Dipa', '[\"parkir\", \"motor\", \"hujan\", \"pasar\"]', 1600, 1067, 85000.00, 'photos/memarkir.jpg', 0, 'Deretan motor terparkir rapi di bahu jalan raya saat suasana gerimis.', NOW(), NOW()),
(7, 'Menunggu', 'menunggu-7', 3, 'I Made Arya Dipa', '[\"menunggu\", \"jas hujan\", \"warung\", \"hujan\"]', 1600, 1067, 85000.00, 'photos/menunggu.jpg', 0, 'Warga berteduh di depan ruko pinggir jalan menunggu hujan reda.', NOW(), NOW()),
(8, 'Menyetir', 'menyetir-8', 3, 'I Made Arya Dipa', '[\"menyetir\", \"mobil\", \"pengemudi\", \"hujan\"]', 1600, 1067, 85000.00, 'photos/menyetir.jpg', 0, 'Perspektif dari dalam mobil saat mengemudi di jalanan basah.', NOW(), NOW()),
(9, 'Orang Menggunakan Jas Hujan', 'orang-menggunakan-jas-hujan-9', 3, 'I Made Arya Dipa', '[\"jas hujan\", \"hujan\", \"motor\", \"payung\"]', 1600, 1067, 85000.00, 'photos/orang-menggunakan-jas-hujan.jpg', 0, 'Pengendara motor melaju di tengah rintik hujan dengan jas hujan warna-warni.', NOW(), NOW()),
(10, 'Pedagang Menyebrang', 'pedagang-menyebrang-10', 1, 'I Made Arya Dipa', '[\"pedagang\", \"menyebrang\", \"jalan\", \"hujan\"]', 1600, 1067, 85000.00, 'photos/pedagang-menyebrang.jpg', 0, 'Pedagang pasar tradisional membawa barang dagangan menyeberang jalanan basah.', NOW(), NOW()),
(11, 'Pedagang', 'pedagang-11', 1, 'I Made Arya Dipa', '[\"pedagang\", \"pasar\", \"keranjang\", \"hujan\"]', 1600, 1067, 85000.00, 'photos/pedagang.jpg', 0, 'Potret penjual buah dan sayur di sudut pasar rakyat.', NOW(), NOW()),
(12, 'Pelampung Darurat', 'pelampung-darurat-12', 2, 'I Made Arya Dipa', '[\"pelampung\", \"kapal\", \"laut\", \"darurat\"]', 1067, 1600, 85000.00, 'photos/pelampung-darurat.jpg', 0, 'Pelampung keselamatan oranye yang terpasang di dinding dek kapal penumpang.', NOW(), NOW()),
(13, 'Pembeli', 'pembeli-13', 1, 'I Made Arya Dipa', '[\"pembeli\", \"pasar\", \"payung\", \"motor\"]', 1600, 1067, 85000.00, 'photos/pembeli.jpg', 0, 'Interaksi hangat antara pedagang dan pembeli di pasar tradisional.', NOW(), NOW()),
(14, 'Tempat Pemangku', 'tempat-pemangku-14', 4, 'I Made Arya Dipa', '[\"pemangku\", \"pura\", \"bale\", \"bali\"]', 1067, 1600, 85000.00, 'photos/tempat-pemangku.jpg', 0, 'Bangunan bale pemangku dengan arsitektur ukiran tradisional Bali yang sakral.', NOW(), NOW());

-- -------------------------------------------------------------
-- 5. Table structure for table `orders`
-- -------------------------------------------------------------
CREATE TABLE `orders` (
  `id` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `method` varchar(50) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `status` enum('Pending','Diproses','Selesai') NOT NULL DEFAULT 'Pending',
  `items` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample order data
INSERT INTO `orders` (`id`, `name`, `email`, `method`, `total`, `status`, `items`, `created_at`, `updated_at`) VALUES
('JPR-882190', 'Budi Santoso', 'budi@example.com', 'QRIS', 85000.00, 'Selesai', '[{\"id\": 1, \"title\": \"Angkutan Pelabuhan\", \"price\": 85000, \"license\": \"standard\"}]', NOW(), NOW());
