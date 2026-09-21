-- MySQL Export for InfinityFree / Shared Hosting
SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
START TRANSACTION;
SET time_zone = '+07:00';

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NULL DEFAULT NULL,
  `email` varchar(255) NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NULL DEFAULT NULL,
  `remember_token` varchar(255) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NULL DEFAULT NULL,
  `phone` varchar(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `phone`) VALUES
(1, 'Pelanggan Setia Gacoan', 'user@demo.test', NULL, '$2y$12$4P3McjJN1FYoh3G2jxlIe.xUm5z5XicOgFQ7WYXCZnBdtdGj5BP8K', NULL, '2026-09-21 03:47:43', '2026-09-21 03:47:43', 'user', 081234567890),
(2, 'Kasir Mulyosari', 'kasir@demo.test', NULL, '$2y$12$Z9Ct.m121w8u9cFeIRK88utDm8SxW8OCl2QBEem.mJzCYBKCHMvpK', NULL, '2026-09-21 03:47:43', '2026-09-21 03:47:43', 'kasir', 081234567891),
(3, 'Admin Operasional', 'admin@demo.test', NULL, '$2y$12$TJwnA5TqScjkAEWuHlRM5uOF/ppTcroew4YITmez.gpK6maPVB.Ja', NULL, '2026-09-21 03:47:44', '2026-09-21 03:47:44', 'admin', 081234567899);

DROP TABLE IF EXISTS `branches`;
CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NULL DEFAULT NULL,
  `slug` varchar(255) NULL DEFAULT NULL,
  `address` varchar(255) NULL DEFAULT NULL,
  `city` varchar(255) NULL DEFAULT NULL,
  `phone` varchar(255) NULL DEFAULT NULL,
  `opening_hours` varchar(255) NULL DEFAULT NULL,
  `is_open` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `branches` (`id`, `name`, `slug`, `address`, `city`, `phone`, `opening_hours`, `is_open`, `created_at`, `updated_at`) VALUES
(1, 'Kedai Mie Flagship Mulyosari', 'mulyosari-surabaya', 'Jl. Raya Mulyosari No. 88, Kalisari, Mulyorejo', 'Surabaya', '(031) 5928819', '10.00 - 22.00 WIB', 1, '2026-09-21 03:47:42', '2026-09-21 03:47:42'),
(2, 'Kedai Mie Manyar Kertoarjo', 'manyar-surabaya', 'Jl. Manyar Kertoarjo No. 42, Gubeng', 'Surabaya', '(031) 5942210', '10.00 - 22.00 WIB', 1, '2026-09-21 03:47:42', '2026-09-21 03:47:42'),
(3, 'Kedai Mie Ambengan Pusat', 'ambengan-surabaya', 'Jl. Ambengan No. 12, Genteng', 'Surabaya', '(031) 5319940', '10.00 - 22.00 WIB', 1, '2026-09-21 03:47:42', '2026-09-21 03:47:42');

DROP TABLE IF EXISTS `restaurant_tables`;
CREATE TABLE `restaurant_tables` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `table_number` varchar(255) NULL DEFAULT NULL,
  `capacity` int(11) NOT NULL DEFAULT 0,
  `room` varchar(255) NULL DEFAULT NULL,
  `status` varchar(255) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `restaurant_tables` (`id`, `table_number`, `capacity`, `room`, `status`, `created_at`, `updated_at`) VALUES
(1, 'A01', 4, 'Indoor AC', 'available', '2026-09-21 03:47:43', '2026-09-21 03:47:43'),
(2, 'A02', 4, 'Indoor AC', 'available', '2026-09-21 03:47:43', '2026-09-21 03:47:43'),
(3, 'A03', 2, 'Indoor AC', 'available', '2026-09-21 03:47:43', '2026-09-21 03:47:43'),
(4, 'A04', 6, 'Indoor AC', 'available', '2026-09-21 03:47:43', '2026-09-21 03:47:43'),
(5, 'B01', 4, 'Outdoor', 'available', '2026-09-21 03:47:43', '2026-09-21 03:47:43'),
(6, 'B02', 4, 'Outdoor', 'occupied', '2026-09-21 03:47:43', '2026-09-21 04:10:37'),
(7, 'B03', 6, 'Outdoor', 'available', '2026-09-21 03:47:43', '2026-09-21 03:47:43'),
(8, 'VIP1', 8, 'VIP Room', 'available', '2026-09-21 03:47:43', '2026-09-21 03:47:43'),
(9, 'VIP2', 10, 'VIP Room', 'available', '2026-09-21 03:47:43', '2026-09-21 03:47:43');

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NULL DEFAULT NULL,
  `name` varchar(255) NULL DEFAULT NULL,
  `category` varchar(255) NULL DEFAULT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `image` varchar(255) NULL DEFAULT NULL,
  `has_spicy_level` int(11) NOT NULL DEFAULT 0,
  `max_spicy_level` int(11) NOT NULL DEFAULT 0,
  `is_available` int(11) NOT NULL DEFAULT 0,
  `is_popular` int(11) NOT NULL DEFAULT 0,
  `rating` varchar(255) NULL DEFAULT NULL,
  `rating_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `products` (`id`, `code`, `name`, `category`, `price`, `description`, `image`, `has_spicy_level`, `max_spicy_level`, `is_available`, `is_popular`, `rating`, `rating_count`, `created_at`, `updated_at`) VALUES
(1, 'MIE-HOMPIMPA', 'Mie Hompimpa (Pedas Asin)', 'mie', 12000, 'Mie kenyal gurih dengan racikan cabai rawit segar asli dan taburan ayam cincang berbalut pangsit renyah.', 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?q=80&w=600&auto=format&fit=crop', 1, 8, 1, 1, 4.9, 2450, '2026-09-21 03:47:42', '2026-09-21 03:47:42'),
(2, 'MIE-GACOAN', 'Mie Gacoan (Pedas Manis)', 'mie', 12000, 'Perpaduan kecap premium manis gurih dengan sensasi cabai rawit pedas meledak, ayam cincang, dan pangsit goreng.', 'https://images.unsplash.com/photo-1552611052-33e04de081de?q=80&w=600&auto=format&fit=crop', 1, 8, 1, 1, 4.9, 3120, '2026-09-21 03:47:42', '2026-09-21 03:47:42'),
(3, 'MIE-SUIT', 'Mie Suit (Original Gurih)', 'mie', 11000, 'Pilihan non-pedas gurih aromatik minyak bawang nusantara dengan taburan ayam cincang halus dan 2 pangsit krispi.', 'https://images.unsplash.com/photo-1612927601601-6638404737ce?q=80&w=600&auto=format&fit=crop', 0, 0, 1, 0, 4.7, 980, '2026-09-21 03:47:42', '2026-09-21 03:47:42'),
(4, 'DIM-KEJU', 'Udang Keju Lumer', 'dimsum', 11000, 'Olahan daging udang segar padat dengan lelehan keju mozzarella gurih di dalamnya, digoreng keemasan.', 'https://images.unsplash.com/photo-1496116218417-1a781b1c416c?q=80&w=600&auto=format&fit=crop', 0, 0, 1, 1, 4.9, 1890, '2026-09-21 03:47:42', '2026-09-21 03:47:42'),
(5, 'DIM-RAMBUTAN', 'Udang Rambutan Crispy', 'dimsum', 11000, 'Bola olahan udang dan ayam berbalut kulit pangsit renyah berserabut kriuk, disajikan dengan saus bangkok.', 'https://images.unsplash.com/photo-1541696432-82c6da8ce7bf?q=80&w=600&auto=format&fit=crop', 0, 0, 1, 1, 4.8, 1420, '2026-09-21 03:47:42', '2026-09-21 03:47:42'),
(6, 'DIM-SIOMAY', 'Siomay Ayam Udang Kukus', 'dimsum', 10000, 'Siomay kukus lembut gurih kaya rempah tradisional dengan potongan udang utuh dan minyak wijen harum.', 'https://images.unsplash.com/photo-1526318896980-cf78c088247c?q=80&w=600&auto=format&fit=crop', 0, 0, 1, 0, 4.6, 840, '2026-09-21 03:47:42', '2026-09-21 03:47:42'),
(7, 'MIN-POCONG', 'Es Pocong Segar', 'minuman', 9000, 'Minuman penyejuk dahaga dari campuran sirup markisa tropis, selasih, nata de coco, dan buah jeruk asli.', 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=600&auto=format&fit=crop', 0, 0, 1, 1, 4.8, 1650, '2026-09-21 03:47:43', '2026-09-21 03:47:43'),
(8, 'MIN-GENDERUWO', 'Es Genderuwo Cincau Hitam', 'minuman', 9000, 'Kesegaran susu manis legit berpadu cincau hitam kenyal lembut dan sirup merah penawar pedas sempurna.', 'https://images.unsplash.com/photo-1546173159-315724a31696?q=80&w=600&auto=format&fit=crop', 0, 0, 1, 0, 4.7, 910, '2026-09-21 03:47:43', '2026-09-21 03:47:43');

DROP TABLE IF EXISTS `promos`;
CREATE TABLE `promos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NULL DEFAULT NULL,
  `title` varchar(255) NULL DEFAULT NULL,
  `discount_type` varchar(255) NULL DEFAULT NULL,
  `discount_value` int(11) NOT NULL DEFAULT 0,
  `min_order` int(11) NOT NULL DEFAULT 0,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `promos` (`id`, `code`, `title`, `discount_type`, `discount_value`, `min_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'GACOANHEMAT', 'Diskon 20% Pengguna Baru', 'percent', 20, 25000, 1, '2026-09-21 03:47:43', '2026-09-21 03:47:43'),
(2, 'ANTIRIBET5K', 'Potongan Rp 5.000 Khusus Pickup', 'fixed', 5000, 30000, 1, '2026-09-21 03:47:43', '2026-09-21 03:47:43');

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_code` varchar(255) NULL DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `order_type` varchar(255) NULL DEFAULT NULL,
  `table_number` varchar(255) NULL DEFAULT NULL,
  `pickup_time_slot` varchar(255) NULL DEFAULT NULL,
  `customer_name` varchar(255) NULL DEFAULT NULL,
  `customer_phone` varchar(255) NULL DEFAULT NULL,
  `payment_method` varchar(255) NULL DEFAULT NULL,
  `payment_status` varchar(255) NULL DEFAULT NULL,
  `status` varchar(255) NULL DEFAULT NULL,
  `subtotal` int(11) NOT NULL DEFAULT 0,
  `discount` int(11) NOT NULL DEFAULT 0,
  `tax` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `items` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `orders` (`id`, `order_code`, `branch_id`, `order_type`, `table_number`, `pickup_time_slot`, `customer_name`, `customer_phone`, `payment_method`, `payment_status`, `status`, `subtotal`, `discount`, `tax`, `total`, `items`, `notes`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'KM-PKP-1001', 1, 'pickup_now', NULL, '10-15 Menit', 'Budi Santoso', 081234567890, 'qris', 'paid', 'in_kitchen', 23000, 4600, 1840, 20240, '[{\"name\":\"Mie Hompimpa (Pedas Asin)\",\"price\":12000,\"quantity\":1,\"spicy_level\":3},{\"name\":\"Udang Keju Lumer\",\"price\":11000,\"quantity\":1}]', 'Tolong pangsit dipisah.', '2026-09-21 03:47:44', '2026-09-21 03:47:44', 1),
(2, 'POS-260921-156', 1, 'dine_in', 'B02', NULL, 'Pelanggan Kasir', '-', 'qris', 'paid', 'in_kitchen', 11000, 0, 1100, 12100, '[{\"id\":4,\"code\":\"DIM-KEJU\",\"name\":\"Udang Keju Lumer\",\"price\":11000,\"quantity\":1,\"spicy_level\":null}]', 'Kasir POS', '2026-09-21 04:10:37', '2026-09-21 04:10:37', NULL),
(3, 'KM-K5U-2676', 1, 'pickup_now', NULL, '15 - 20 Menit', 'Admin Operasional', 081234567899, 'qris', 'paid', 'in_kitchen', 11000, 0, 1100, 12100, '[{\"id\":\"4\",\"code\":\"DIM-KEJU\",\"name\":\"Udang Keju Lumer\",\"price\":11000,\"image\":\"https:\\/\\/images.unsplash.com\\/photo-1496116218417-1a781b1c416c?q=80&w=600&auto=format&fit=crop\",\"spicy_level\":null,\"addons\":\"\",\"quantity\":1,\"notes\":\"\"}]', NULL, '2026-09-21 05:39:57', '2026-09-21 05:39:57', NULL);

DROP TABLE IF EXISTS `table_bookings`;
CREATE TABLE `table_bookings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_code` varchar(255) NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `table_id` int(11) NOT NULL DEFAULT 0,
  `customer_name` varchar(255) NULL DEFAULT NULL,
  `customer_phone` varchar(255) NULL DEFAULT NULL,
  `booking_date` timestamp NULL DEFAULT NULL,
  `booking_time` varchar(255) NULL DEFAULT NULL,
  `guests_count` int(11) NOT NULL DEFAULT 0,
  `room_preference` varchar(255) NULL DEFAULT NULL,
  `status` varchar(255) NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `table_bookings` (`id`, `booking_code`, `user_id`, `branch_id`, `table_id`, `customer_name`, `customer_phone`, `booking_date`, `booking_time`, `guests_count`, `room_preference`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'TBK-2026-001', 1, 1, 1, 'Pelanggan Setia Gacoan', 081234567890, '2026-09-21', '19:00', 4, 'Indoor AC', 'confirmed', 'Dekat stop kontak bila memungkinkan.', '2026-09-21 03:47:44', '2026-09-21 03:47:44'),
(2, 'TBK-260921-0YOZ', 3, 2, 3, 'Admin Operasional', 081234567899, '2026-09-21', '18:30', 4, 'Outdoor', 'confirmed', NULL, '2026-09-21 04:28:08', '2026-09-21 04:28:08');

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NULL DEFAULT NULL,
  `value` text DEFAULT NULL,
  `expiration` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NULL DEFAULT NULL,
  `owner` varchar(255) NULL DEFAULT NULL,
  `expiration` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NULL DEFAULT NULL,
  `payload` text DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT 0,
  `reserved_at` int(11) NOT NULL DEFAULT 0,
  `available_at` int(11) NOT NULL DEFAULT 0,
  `created_at` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NULL DEFAULT NULL,
  `name` varchar(255) NULL DEFAULT NULL,
  `total_jobs` int(11) NOT NULL DEFAULT 0,
  `pending_jobs` int(11) NOT NULL DEFAULT 0,
  `failed_jobs` int(11) NOT NULL DEFAULT 0,
  `failed_job_ids` text DEFAULT NULL,
  `options` text DEFAULT NULL,
  `cancelled_at` int(11) NOT NULL DEFAULT 0,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `finished_at` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NULL DEFAULT NULL,
  `connection` varchar(255) NULL DEFAULT NULL,
  `queue` varchar(255) NULL DEFAULT NULL,
  `payload` text DEFAULT NULL,
  `exception` text DEFAULT NULL,
  `failed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NULL DEFAULT NULL,
  `tokenable_id` int(11) NOT NULL DEFAULT 0,
  `name` text DEFAULT NULL,
  `token` varchar(255) NULL DEFAULT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NULL DEFAULT NULL,
  `batch` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_09_20_152944_create_personal_access_tokens_table', 1),
(5, '2026_09_20_152954_create_kedai_mie_tables', 1),
(6, '2026_09_21_034652_update_schema_for_laravel_native', 1);

SET FOREIGN_KEY_CHECKS=1;
COMMIT;
