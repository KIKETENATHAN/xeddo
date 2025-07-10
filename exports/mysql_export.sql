-- MySQL Export for Xeddolink
-- Generated on 2025-07-07 20:54:31
-- Laravel Database Migration from SQLite to MySQL
-- 
-- IMPORTANT: Review and test this export before using in production
-- 

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- Table structure for table `migrations`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
`id` BIGINT UNSIGNED NOT NULL  AUTO_INCREMENT,
`migration` VARCHAR(255) NOT NULL,
`batch` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
`id` BIGINT UNSIGNED NOT NULL  AUTO_INCREMENT,
`name` VARCHAR(255) NOT NULL,
`email` VARCHAR(255) NOT NULL,
`email_verified_at` DATETIME NULL,
`password` VARCHAR(255) NOT NULL,
`remember_token` VARCHAR(255) NULL,
`created_at` DATETIME NULL,
`updated_at` DATETIME NULL,
`role` VARCHAR(255) NOT NULL DEFAULT '\'passenger\'',
`phone` VARCHAR(255) NULL,
`address` TEXT NULL,
`is_active` VARCHAR(255) NOT NULL DEFAULT '\'1\'',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `password_reset_tokens`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
`email` VARCHAR(255) NOT NULL,
`token` VARCHAR(255) NOT NULL,
`created_at` DATETIME NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `sessions`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
`id` VARCHAR(255) NOT NULL,
`user_id` INT NULL,
`ip_address` VARCHAR(255) NULL,
`user_agent` TEXT NULL,
`payload` TEXT NOT NULL,
`last_activity` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `cache`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
`key` VARCHAR(255) NOT NULL,
`value` TEXT NOT NULL,
`expiration` INT NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `cache_locks`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
`key` VARCHAR(255) NOT NULL,
`owner` VARCHAR(255) NOT NULL,
`expiration` INT NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `jobs`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
`id` BIGINT UNSIGNED NOT NULL  AUTO_INCREMENT,
`queue` VARCHAR(255) NOT NULL,
`payload` TEXT NOT NULL,
`attempts` INT NOT NULL,
`reserved_at` INT NULL,
`available_at` INT NOT NULL,
`created_at` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `job_batches`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
`id` VARCHAR(255) NOT NULL,
`name` VARCHAR(255) NOT NULL,
`total_jobs` INT NOT NULL,
`pending_jobs` INT NOT NULL,
`failed_jobs` INT NOT NULL,
`failed_job_ids` TEXT NOT NULL,
`options` TEXT NULL,
`cancelled_at` INT NULL,
`created_at` INT NOT NULL,
`finished_at` INT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `failed_jobs`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
`id` BIGINT UNSIGNED NOT NULL  AUTO_INCREMENT,
`uuid` VARCHAR(255) NOT NULL,
`connection` TEXT NOT NULL,
`queue` TEXT NOT NULL,
`payload` TEXT NOT NULL,
`exception` TEXT NOT NULL,
`failed_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `passenger_profiles`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `passenger_profiles`;
CREATE TABLE `passenger_profiles` (
`id` BIGINT UNSIGNED NOT NULL  AUTO_INCREMENT,
`user_id` INT NOT NULL,
`emergency_contact_name` TEXT NULL,
`emergency_contact_phone` VARCHAR(255) NULL,
`preferences` TEXT NULL,
`rating` DECIMAL(10,2) NOT NULL DEFAULT '\'0\'',
`total_trips` INT NOT NULL DEFAULT '\'0\'',
`created_at` DATETIME NULL,
`updated_at` DATETIME NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `saccos`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `saccos`;
CREATE TABLE `saccos` (
`id` BIGINT UNSIGNED NOT NULL  AUTO_INCREMENT,
`name` VARCHAR(255) NOT NULL,
`phone_number` VARCHAR(255) NOT NULL,
`location` VARCHAR(255) NOT NULL,
`route_from` VARCHAR(255) NOT NULL,
`route_to` VARCHAR(255) NOT NULL,
`description` TEXT NULL,
`is_active` VARCHAR(255) NOT NULL DEFAULT '\'1\'',
`created_at` DATETIME NULL,
`updated_at` DATETIME NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `driver_profiles`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `driver_profiles`;
CREATE TABLE `driver_profiles` (
`id` BIGINT UNSIGNED NOT NULL  AUTO_INCREMENT,
`user_id` INT NOT NULL,
`license_number` VARCHAR(255) NOT NULL,
`license_expiry` DATE NOT NULL,
`vehicle_type` VARCHAR(255) NOT NULL,
`vehicle_make` VARCHAR(255) NOT NULL,
`vehicle_model` VARCHAR(255) NOT NULL,
`vehicle_year` VARCHAR(255) NOT NULL,
`vehicle_plate_number` VARCHAR(255) NOT NULL,
`vehicle_color` VARCHAR(255) NOT NULL,
`vehicle_description` TEXT NULL,
`status` VARCHAR(255) NOT NULL DEFAULT '\'pending\'',
`is_available` VARCHAR(255) NOT NULL DEFAULT '\'1\'',
`rating` DECIMAL(10,2) NOT NULL DEFAULT '\'0\'',
`total_trips` INT NOT NULL DEFAULT '\'0\'',
`created_at` DATETIME NULL,
`updated_at` DATETIME NULL,
`sacco_id` INT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `driver_profiles_vehicle_plate_number_unique` (`vehicle_plate_number`),
  UNIQUE KEY `driver_profiles_license_number_unique` (`license_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `bookings`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
`id` BIGINT UNSIGNED NOT NULL  AUTO_INCREMENT,
`booking_reference` VARCHAR(255) NOT NULL,
`user_id` INT NOT NULL,
`trip_id` INT NOT NULL,
`passenger_name` VARCHAR(255) NOT NULL,
`passenger_email` VARCHAR(255) NOT NULL,
`passenger_phone` VARCHAR(255) NOT NULL,
`amount` DECIMAL(10,2) NOT NULL,
`seats_booked` INT NOT NULL DEFAULT '\'1\'',
`status` VARCHAR(255) NOT NULL DEFAULT '\'pending\'',
`booking_details` TEXT NULL,
`booking_date` DATETIME NOT NULL,
`created_at` DATETIME NULL,
`updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bookings_booking_reference_unique` (`booking_reference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `payments`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
`id` BIGINT UNSIGNED NOT NULL  AUTO_INCREMENT,
`payment_reference` VARCHAR(255) NOT NULL,
`booking_id` INT NOT NULL,
`phone_number` VARCHAR(255) NOT NULL,
`amount` DECIMAL(10,2) NOT NULL,
`payment_method` VARCHAR(255) NOT NULL DEFAULT '\'mpesa\'',
`status` VARCHAR(255) NOT NULL DEFAULT '\'pending\'',
`transaction_id` VARCHAR(255) NULL,
`checkout_request_id` VARCHAR(255) NULL,
`merchant_request_id` VARCHAR(255) NULL,
`payment_details` TEXT NULL,
`paid_at` DATETIME NULL,
`created_at` DATETIME NULL,
`updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_payment_reference_unique` (`payment_reference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `admin_notifications`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `admin_notifications`;
CREATE TABLE `admin_notifications` (
`id` BIGINT UNSIGNED NOT NULL  AUTO_INCREMENT,
`title` VARCHAR(255) NOT NULL,
`message` TEXT NOT NULL,
`type` VARCHAR(255) NOT NULL DEFAULT '\'driver_action\'',
`read` VARCHAR(255) NOT NULL DEFAULT '\'0\'',
`trip_id` INT NULL,
`driver_id` INT NULL,
`created_at` DATETIME NULL,
`updated_at` DATETIME NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `trips`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `trips`;
CREATE TABLE `trips` (
`id` BIGINT UNSIGNED NOT NULL  AUTO_INCREMENT,
`driver_id` INT NULL,
`sacco_id` INT NOT NULL,
`from_location` VARCHAR(255) NOT NULL,
`to_location` VARCHAR(255) NOT NULL,
`departure_time` DATETIME NOT NULL,
`estimated_arrival_time` DATETIME NOT NULL,
`amount` DECIMAL(10,2) NOT NULL,
`status` VARCHAR(255) NOT NULL DEFAULT '\'pending_acceptance\'',
`available_seats` INT NOT NULL DEFAULT '\'0\'',
`booked_seats` INT NOT NULL DEFAULT '\'0\'',
`notes` TEXT NULL,
`created_at` DATETIME NULL,
`updated_at` DATETIME NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `migrations` (14 records)
-- --------------------------------------------------------

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_04_131236_add_user_role_to_users_table', 2),
(5, '2025_07_04_131255_create_driver_profiles_table', 2),
(6, '2025_07_04_131306_create_passenger_profiles_table', 2),
(7, '2025_07_04_150000_create_saccos_table', 3),
(8, '2025_07_04_150001_add_sacco_id_to_driver_profiles_table', 3),
(9, '2025_07_04_192952_create_trips_table', 4),
(10, '2025_07_04_203456_create_bookings_table', 5),
(11, '2025_07_04_203510_create_payments_table', 5),
(12, '2025_07_07_105701_add_pending_acceptance_status_to_trips_table', 6),
(13, '2025_07_07_111359_create_admin_notifications_table', 7),
(14, '2025_07_07_114038_update_trips_status_enum', 8);

-- --------------------------------------------------------
-- Dumping data for table `users` (7 records)
-- --------------------------------------------------------

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `phone`, `address`, `is_active`) VALUES
(1, 'Admin User', 'admin@xeddo.com', '2025-07-04 13:28:16', '$2y$12$bpBegs8gpETo9nfQdE1itOZDLNlPKEz6SEATTWnBpBIjnAAZF6ubi', NULL, '2025-07-04 13:28:16', '2025-07-04 13:28:16', 'admin', +1234567890, 'Admin Office', 1),
(2, 'Nathan Kikete Wanyonyi', 'kiketenathan@gmail.com', NULL, '$2y$12$HLq9.Tqw5UzZsaM.U3OOU.imjy1JBrNIdtvBHz5J2QC6MUQ5nJim2', NULL, '2025-07-04 13:40:37', '2025-07-04 13:40:37', 'passenger', 0708579885, 'P. O. Box 29010-00625, Nairobi', 1),
(3, 'Ann Maweu Obiero', 'annm@kiambupoly.ac.ke', NULL, '$2y$12$8naEO.Ar8SwY0gwEuQIq1Oe5JYuWq4iD1ecA9kG1nvRnvhL9btdJa', NULL, '2025-07-04 13:41:42', '2025-07-04 13:41:42', 'driver', 0724521066, 'P. O. Box 29053, – 00625', 1),
(5, 'Jackson Wesonga', 'jack@gmail.com', NULL, '$2y$12$GyBh6UlcWhQjWPMM792C5OEyFZPuOhhHNkvCrSCk.cLVcThl7Jq1y', NULL, '2025-07-07 06:53:12', '2025-07-07 06:53:12', 'passenger', 0708579885, 'P. O. Box 29010-00625, Nairobi', 1),
(6, 'Alvin Wambayi', 'alvin@gmail.com', NULL, '$2y$12$1776849FDi0Mk3Rnv3wMDemJ7bLvBlHg/Qx1jRBztO1H93vJOIHli', NULL, '2025-07-07 08:25:19', '2025-07-07 08:25:19', 'driver', 0712345678, 'PO Box 1917-50200', 1),
(7, 'dickson ombaki', 'ombaki@gmail.com', NULL, '$2y$12$CGVIdbCQgogmrafqZdO9JOMl0pgOpm1lDvwGiTPaaq8zB0qNd9//.', NULL, '2025-07-07 08:29:25', '2025-07-07 08:29:25', 'passenger', 0747500207, 'P. O. Box 29010-00625, Nairobi', 1),
(8, 'dickson ombaki', 'ombaki1@gmail.com', NULL, '$2y$12$L/nWxNi.ljry2HaWS9nCke.THXNBkq7tjWYQFGvUk.6AcvFsGQXdq', NULL, '2025-07-07 08:30:16', '2025-07-07 08:30:16', 'passenger', 0747500207, 'P. O. Box 29010-00625, Nairobi', 1);

-- No data for table `password_reset_tokens`

-- --------------------------------------------------------
-- Dumping data for table `sessions` (1 records)
-- --------------------------------------------------------

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('zFy6Y8pvjJvnL1aL4u7JQENYEfdNUnZS5q5jj3bL', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVG52MUdVajVua3gwb2FZSDB3SVE2UTlpeTlNbVJWZjJQbDhJMVMzRCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1751921074);

-- No data for table `cache`

-- No data for table `cache_locks`

-- No data for table `jobs`

-- No data for table `job_batches`

-- No data for table `failed_jobs`

-- --------------------------------------------------------
-- Dumping data for table `passenger_profiles` (4 records)
-- --------------------------------------------------------

INSERT INTO `passenger_profiles` (`id`, `user_id`, `emergency_contact_name`, `emergency_contact_phone`, `preferences`, `rating`, `total_trips`, `created_at`, `updated_at`) VALUES
(1, 2, 'Nathan', 0708579885, 'quiet melancholic music', 0, 0, '2025-07-04 13:40:38', '2025-07-04 18:28:48'),
(2, 5, NULL, NULL, NULL, 0, 0, '2025-07-07 06:53:12', '2025-07-07 06:53:12'),
(3, 7, NULL, NULL, NULL, 0, 0, '2025-07-07 08:29:26', '2025-07-07 08:29:26'),
(4, 8, 'Nathan', 0708579885, NULL, 0, 0, '2025-07-07 08:30:17', '2025-07-07 08:30:52');

-- --------------------------------------------------------
-- Dumping data for table `saccos` (4 records)
-- --------------------------------------------------------

INSERT INTO `saccos` (`id`, `name`, `phone_number`, `location`, `route_from`, `route_to`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(11, 'Nairobi City Express', +254712345678, 'Nairobi CBD', 'Nairobi', 'Mombasa', 'Express transport service between Nairobi and Mombasa', 1, '2025-07-04 20:28:41', '2025-07-04 20:28:41'),
(12, 'Kisumu Transport Co-op', +254723456789, 'Kisumu', 'Kisumu', 'Eldoret', 'Regional transport cooperative serving western Kenya', 1, '2025-07-04 20:28:41', '2025-07-04 20:28:41'),
(15, 'Super Metro', 0708579885, 'Nairobi', 'Nairobi', 'Mombasa', 'Moving daily from nairobi to mombasa to and fro', 1, '2025-07-07 07:57:03', '2025-07-07 07:57:03'),
(19, 'Mombasa Coast Shuttle', +254745678901, 'Mombasa', 'Mombasa', 'Malindi', 'Coastal transport service', 1, '2025-07-07 08:47:10', '2025-07-07 08:47:10');

-- --------------------------------------------------------
-- Dumping data for table `driver_profiles` (2 records)
-- --------------------------------------------------------

INSERT INTO `driver_profiles` (`id`, `user_id`, `license_number`, `license_expiry`, `vehicle_type`, `vehicle_make`, `vehicle_model`, `vehicle_year`, `vehicle_plate_number`, `vehicle_color`, `vehicle_description`, `status`, `is_available`, `rating`, `total_trips`, `created_at`, `updated_at`, `sacco_id`) VALUES
(1, 3, 'Dl-8582', '2025-07-18 00:00:00', 'matatu', 'toyota', 'Matatu', 1980, 'KDT 600S', 'white', NULL, 'approved', 1, 0, 0, '2025-07-04 13:42:31', '2025-07-07 08:17:51', 15),
(2, 6, 'Dl-85821', '2025-07-18 00:00:00', 'van', 'toyota', 'matatu', 2015, 'KDS 200R', 'white', NULL, 'rejected', 1, 0, 0, '2025-07-07 08:26:17', '2025-07-07 08:27:47', NULL);

-- No data for table `bookings`

-- No data for table `payments`

-- --------------------------------------------------------
-- Dumping data for table `admin_notifications` (3 records)
-- --------------------------------------------------------

INSERT INTO `admin_notifications` (`id`, `title`, `message`, `type`, `read`, `trip_id`, `driver_id`, `created_at`, `updated_at`) VALUES
(3, 'Trip Accepted', 'Driver Ann Maweu Obiero has accepted the trip from Nairobi CBD to MOMBASA scheduled for Jul 07, 2025 17:29.', 'driver_action', 0, 1, 1, '2025-07-07 11:49:01', '2025-07-07 11:49:01'),
(4, 'Trip Started', 'Driver Ann Maweu Obiero has started the trip from Nairobi CBD to MOMBASA.', 'driver_action', 0, 1, 1, '2025-07-07 11:49:13', '2025-07-07 11:49:13'),
(5, 'Trip Completed', 'Driver Ann Maweu Obiero has completed the trip from Nairobi CBD to MOMBASA.', 'driver_action', 0, 1, 1, '2025-07-07 12:15:49', '2025-07-07 12:15:49');

-- --------------------------------------------------------
-- Dumping data for table `trips` (1 records)
-- --------------------------------------------------------

INSERT INTO `trips` (`id`, `driver_id`, `sacco_id`, `from_location`, `to_location`, `departure_time`, `estimated_arrival_time`, `amount`, `status`, `available_seats`, `booked_seats`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 15, 'Nairobi CBD', 'MOMBASA', '2025-07-07 17:29:00', '2025-07-07 20:29:00', 1500, 'completed', 14, 0, NULL, '2025-07-07 11:47:56', '2025-07-07 12:15:49');

-- Foreign key constraints for table `passenger_profiles`
ALTER TABLE `passenger_profiles` ADD CONSTRAINT `fk_passenger_profiles_user_id_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

-- Foreign key constraints for table `driver_profiles`
ALTER TABLE `driver_profiles` ADD CONSTRAINT `fk_driver_profiles_sacco_id_saccos_id` FOREIGN KEY (`sacco_id`) REFERENCES `saccos` (`id`) ON DELETE SET NULL;
ALTER TABLE `driver_profiles` ADD CONSTRAINT `fk_driver_profiles_user_id_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

-- Foreign key constraints for table `bookings`
ALTER TABLE `bookings` ADD CONSTRAINT `fk_bookings_trip_id_trips_id` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE;
ALTER TABLE `bookings` ADD CONSTRAINT `fk_bookings_user_id_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

-- Foreign key constraints for table `payments`
ALTER TABLE `payments` ADD CONSTRAINT `fk_payments_booking_id_bookings_id` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

-- Foreign key constraints for table `admin_notifications`
ALTER TABLE `admin_notifications` ADD CONSTRAINT `fk_admin_notifications_driver_id_driver_profiles_id` FOREIGN KEY (`driver_id`) REFERENCES `driver_profiles` (`id`) ON DELETE CASCADE;
ALTER TABLE `admin_notifications` ADD CONSTRAINT `fk_admin_notifications_trip_id_trips_id` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE;

-- Foreign key constraints for table `trips`
ALTER TABLE `trips` ADD CONSTRAINT `fk_trips_sacco_id_saccos_id` FOREIGN KEY (`sacco_id`) REFERENCES `saccos` (`id`) ON DELETE CASCADE;
ALTER TABLE `trips` ADD CONSTRAINT `fk_trips_driver_id_driver_profiles_id` FOREIGN KEY (`driver_id`) REFERENCES `driver_profiles` (`id`) ON DELETE CASCADE;


SET FOREIGN_KEY_CHECKS = 1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Migration completed at 2025-07-07 20:54:31
