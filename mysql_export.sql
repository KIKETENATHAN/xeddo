-- MySQL Export from SQLite Database
-- Generated on 2025-07-04 22:31:51
-- Source: database/database.sqlite

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Table structure for table `migrations`
-- --------------------------------------------------------

CREATE TABLE `migrations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `migration` VARCHAR(255) NOT NULL ,
  `batch` INT NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `migrations`
-- --------------------------------------------------------

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4, '2025_07_04_131236_add_user_role_to_users_table', 2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5, '2025_07_04_131255_create_driver_profiles_table', 2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6, '2025_07_04_131306_create_passenger_profiles_table', 2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7, '2025_07_04_150000_create_saccos_table', 3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8, '2025_07_04_150001_add_sacco_id_to_driver_profiles_table', 3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9, '2025_07_04_192952_create_trips_table', 4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10, '2025_07_04_203456_create_bookings_table', 5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11, '2025_07_04_203510_create_payments_table', 5);

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `email_verified_at` TIMESTAMP NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(100) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `role` VARCHAR(50) NOT NULL DEFAULT 'passenger',
  `phone` VARCHAR(20) NULL,
  `address` TEXT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `users`
-- --------------------------------------------------------

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `phone`, `address`, `is_active`) VALUES (1, 'Admin User', 'admin@xeddo.com', '2025-07-04 13:28:16', '$2y$12$bpBegs8gpETo9nfQdE1itOZDLNlPKEz6SEATTWnBpBIjnAAZF6ubi', NULL, '2025-07-04 13:28:16', '2025-07-04 13:28:16', 'admin', '+1234567890', 'Admin Office', 1);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `phone`, `address`, `is_active`) VALUES (2, 'Nathan Kikete Wanyonyi', 'kiketenathan@gmail.com', NULL, '$2y$12$HLq9.Tqw5UzZsaM.U3OOU.imjy1JBrNIdtvBHz5J2QC6MUQ5nJim2', NULL, '2025-07-04 13:40:37', '2025-07-04 13:40:37', 'passenger', '0708579885', 'P. O. Box 29010-00625, Nairobi', 1);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `phone`, `address`, `is_active`) VALUES (3, 'Ann Maweu Obiero', 'annm@kiambupoly.ac.ke', NULL, '$2y$12$8naEO.Ar8SwY0gwEuQIq1Oe5JYuWq4iD1ecA9kG1nvRnvhL9btdJa', NULL, '2025-07-04 13:41:42', '2025-07-04 13:41:42', 'driver', '0724521066', 'P. O. Box 29053, – 00625', 1);

-- --------------------------------------------------------
-- Table structure for table `password_reset_tokens`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `sessions`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` VARCHAR(255) NOT NULL,
  `user_id` BIGINT UNSIGNED NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` TEXT NULL,
  `payload` LONGTEXT NOT NULL,
  `last_activity` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `sessions`
-- --------------------------------------------------------

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('MpLRzqnuUsX2bjKA22dfJja5TS9QfLVWCysrUgNM', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicjBOdjNCcWNlRDQ1cGdnNHlDQTZJeWhYWjdtSmxXRXhZb3VxOEJBTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9NDg3Y2FmOTEtNmI4Ni00YWM1LTg2ZjktZmQyN2QyMzYzZTg5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzUxNjYyMTc5MjYzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662180);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('SYHiObpiC3u2QW1DpvcU4FEDR7ipVHCFzORCZxLD', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibXJYVmNidDY1UDlHbW9iS0kzYm5LVUxhRFZ2NWxCQmc3MUF0SkVvOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hcGkvc2FjY29zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662231);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('SNoxve9z07Z9hcf7BgFdqGdefp89J5tJt52w7fcz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiRFdPTjJPWU9ndkVCenpRR21UdkxIblRzNmp2aXhYbnpFV05CZG80ViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662253);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('Ui26rfleNL3h8MgDUfIKXIBXFNDxxNtg4mnPmmSz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiWnNCekpoWTNJSXdNdHNGbXZ3ck10WWFVYnRMYlljM1p2OW80dzVBVSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662267);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('TNQJwEDjWPaZGLRUAGL2zmn24mi8QrOM0oEqSW3x', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiQ256NmN1UGxFWnNSeHdMQ2ZCUHYyQ0hxOEpYd2lVTHY5TnNOZFFEaCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662269);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('luihhk4l2s46ICOVXJLDPbUOeaLVMqmypJXlsRfv', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiTUpkTU9waHlJWnJhSmJwQXlvS0NyeUNqbEZkajdzZlpqRjV5d3VFViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662271);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('OvVuZEVDBc5CxmEORuMRorLBM4i82xY8h0jHIXJK', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoicVo1R2FQUUowdTlmYnpZOFk2dGpPb2dPbXlzc1AzZWRMNWhjUUJRWiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662274);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('KxwNVgSkY5liwXEOZJlIT8xIpGdOuOeq1XVnjtcB', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiWnp0MFc5YU9LcW5Takh4b1VHSlVaQ01GZFViS3hZTlZaTHhRWWVpWiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662296);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('QjvXAllKGAnylOgX3Ucq6O95MzYHZImIk8ByWbDf', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZXcwSmYxUW1QQXdpaU1ZR0Njcm5DRzhTbUJpQkhrek9uUDc3clpidyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662308);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('T4DZYb0xcrCDEjFUC4H9hFtxxsMt78e72a6HPtb1', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY013TUFNcnZVYzZlUERpbURuU1lKUUZXYUNFb2s4MzdhYmpxSVhwMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9NDg3Y2FmOTEtNmI4Ni00YWM1LTg2ZjktZmQyN2QyMzYzZTg5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzUxNjYyMzMxNzUwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662332);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('3WRNUexaRfbNoxKQEC4ryibt0rr4WvOqv739BKb7', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNHo4UExKOEdvME9RZDRZd256SVZnWTJUaXpDOUU0bGlFc0NtaTVoQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hcGkvc2FjY29zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662334);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('1IVbhuknOzLE5vPetEmH2oPHSmbtW8gDSdIQuTgr', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiVVprQmR6NlRreHNjQXdmaDdLWFY3NGJiMHBzZ1B2aWwxMDNtVUpJWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662350);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('ougSYHX6fidH5DPXUJpNvbwke2LNSzemd1i2BcyW', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiUXpQR3VqZkJHVm42dllETEhRSzZWSWs2dHNGd3dnUVhTSlR2RWtqMyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662379);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('4N0fA6ZRp0kcw72aRyI2HIeBtuzR1E9SK76QGVl5', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidWlhZXhjTjdmc0pRelJJSGlQUHhyTWJuSmR3R2M3QndjWGFlYTFHaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9NDg3Y2FmOTEtNmI4Ni00YWM1LTg2ZjktZmQyN2QyMzYzZTg5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzUxNjYyMzMxNzUwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662526);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('ucvxDFOlYE3cvoqFz6ImTa0GFNHMfbZT971Km5tZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiczk5TWh3Tk5QYXRXUXlqNU5GRHdSSWNkVFRCd3lFQm9Lc21SaVNESSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9NDg3Y2FmOTEtNmI4Ni00YWM1LTg2ZjktZmQyN2QyMzYzZTg5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzUxNjYyMzMxNzUwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662526);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('uTfrLAB0dUYtxGDl6pLqn0drPAHvEKewSchdRDK4', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibHRoclVUZzhYUUpGdnZaR3VTNlR6RUU5S2paV0NoQTJpR3NlbEdrWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9NDg3Y2FmOTEtNmI4Ni00YWM1LTg2ZjktZmQyN2QyMzYzZTg5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzUxNjYyMzMxNzUwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662539);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('Mbp2FlGSn1T5lg1cCRUdJial58m1riL8zEvfgwQe', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicDhzdllydkt0UUx2RnFYN1lLT2U2TUNPbHJQUmpsSmVVZFlNQVEySiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9NDg3Y2FmOTEtNmI4Ni00YWM1LTg2ZjktZmQyN2QyMzYzZTg5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzUxNjYyMzMxNzUwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662541);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('dJIYQuNppD4usFaiWFk7sRXjweRperqU8LPxNj48', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidkx4MHFDWkdYT2pzOHVqdklCNDhLbllPOTlBeVNOUEpYbjdoWmtVdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9NDg3Y2FmOTEtNmI4Ni00YWM1LTg2ZjktZmQyN2QyMzYzZTg5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzUxNjYyMzMxNzUwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662573);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('1mqY58760kb2rJIh4fcbjhnC6rVsI0SMD9liPDNr', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM3FRWXBOY3Q4RVRhb0hROEZWMFVIVlZDRmtydkVNZTVZWGpwSUI4RSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9NDg3Y2FmOTEtNmI4Ni00YWM1LTg2ZjktZmQyN2QyMzYzZTg5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzUxNjYyMzMxNzUwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662574);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('2o8GAEozLMug1Xr7TIUFGTB9XDeHzNF1o4qzFJwf', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieldpUEJVRzdwUkJQdnRURlhOVVlTTUoxYjVoS3IyZzZHc3JubHBHRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9NDg3Y2FmOTEtNmI4Ni00YWM1LTg2ZjktZmQyN2QyMzYzZTg5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzUxNjYyMzMxNzUwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662582);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('ZVkLvNeL8SU2fZmVjccNfVsKTL82m0dG4vYA0WPM', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ0c2YVVEaVBCZXBFV0tBR1hWVTBFamp6MHZBWG9nUUlOOUVJUlpGeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9NDg3Y2FmOTEtNmI4Ni00YWM1LTg2ZjktZmQyN2QyMzYzZTg5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzUxNjYyMzMxNzUwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662583);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('GJZaM0oJGKnGTbw4gtoxeFUszYfX4FXWlf99YpGS', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQjZjSUNZUEVRNGljNlNYYUVMdG9wNlM1Tm1WVHJVU2NkQXJLWklpTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9NDg3Y2FmOTEtNmI4Ni00YWM1LTg2ZjktZmQyN2QyMzYzZTg5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzUxNjYyMzMxNzUwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662594);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('uEYdVsU01zOux9cJzqQxNA39aPIz19ThYOaYT8W8', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQmo5aDZYcnVtTUwxNVRERGVHdFFiSzVobzVxOEtSRXlXUmNqeWJoOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9NDg3Y2FmOTEtNmI4Ni00YWM1LTg2ZjktZmQyN2QyMzYzZTg5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzUxNjYyMzMxNzUwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662594);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('Ol6e08odzVQwGTRT5BBkUTiKX9HLJnLaQQsWEuZT', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMTRtNEQ2SWdhMmNwOWhBcGFZV05wWmUwRFZWWExMa29vSzZGNFg5YyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9NDg3Y2FmOTEtNmI4Ni00YWM1LTg2ZjktZmQyN2QyMzYzZTg5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzUxNjYyMzMxNzUwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662611);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('CJWuBGyQBSJgysVzkXvscsooSrKyS4f6x87FtU76', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM25VZURVZWNlczZJY0RCajVqU3g0aEllQ3Vvc0pxTE90VlZNaGV5byI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9NDg3Y2FmOTEtNmI4Ni00YWM1LTg2ZjktZmQyN2QyMzYzZTg5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzUxNjYyMzMxNzUwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662612);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('8eYRrIjcDJXBwywg1SrtwMbStgd4zFrd8EyAKaTb', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOVpQQkNVRlFwYzB0VU9CRXFkYlgwWk1zRFRNc3ZoczFiZFNNVHVxUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9NDg3Y2FmOTEtNmI4Ni00YWM1LTg2ZjktZmQyN2QyMzYzZTg5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzUxNjYyMzMxNzUwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662622);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('LvIIMoIdemtiic2PXBMEcJ4VxHMBDmPw8WygzeIg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY0VhQ3hvTUFySVFiem5mZjBWNXZkMEROZkxpeWw1enJDelVpcVAyeCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9NDg3Y2FmOTEtNmI4Ni00YWM1LTg2ZjktZmQyN2QyMzYzZTg5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzUxNjYyMzMxNzUwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662623);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('5CZcPkVexBMQQ4XTfU6uqpuobO8Vv6T91hzVfxIg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUlhNT0FZZjBBSlp6anNqQmxBZmtwY3FNTEozR29JSjFUVlNUZXJWaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9NDg3Y2FmOTEtNmI4Ni00YWM1LTg2ZjktZmQyN2QyMzYzZTg5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzUxNjYyNjcxNDI3Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662674);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('zpdtrP350NcSxH2N37859AR3etehZyjet37jL9CK', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiTDhKODFrSFBLUmNiZ2wyNXpObXVFWHFkN3dKWW11NUdOd1Vmc2FMcCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662739);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('wDAvrpvgWZeANCJznHhrZMfETyKVMe8UoR14QnBT', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoibXE3QTI2dlN4bmdxeGFFOUVDZmRVZ3ZYQ09FWU9ST3hmU0JHZHBVTyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662741);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('AyjaiTChT1sBiGQmXXpFfgmNsqSxs4hyzFer9OWM', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRVVrQk5LUkVwRkJtTWVnZXpPUFZkQVFvclJ5UGVTd001d1hBem9XYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9NDg3Y2FmOTEtNmI4Ni00YWM1LTg2ZjktZmQyN2QyMzYzZTg5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzUxNjYyNzQ2MzQ0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662747);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('QWHR6jI10GcWXES4PGRAgtjrzgIQ3ez3ZCEXLovX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibkRwUXJIbXpnRVdFc0JSWFhsYWREbnJaalFNZUdaQW1nbnh6QTBmdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hcGkvc2FjY29zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662749);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('8n9fF5HAVgiYw8aAxfXojiQEDhJiRbjeVgYx8GFx', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiaTF2dEtpOXVaTHNSNmc5R3lDckJybDZSTjhPMzJDeXhXS1REU2F0RCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662766);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('flEHR2KuGrFFnT5jOFfDlofQ34ZBJuaDjBfkemqU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaFhOZlZQcW0zSm51V0hJbWN4cUhZd3daZ0dVdGk3QXdUdG92SVFHRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC8/aWQ9NDg3Y2FmOTEtNmI4Ni00YWM1LTg2ZjktZmQyN2QyMzYzZTg5JnZzY29kZUJyb3dzZXJSZXFJZD0xNzUxNjYyNzQ2MzQ0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662778);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('7Yt9ySLlt8BgulaDQ0bkzDHxPFzfYJPTt8JE0S28', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoicWxqS3RaR3dGbE9rUUJCa1AwdUVMaDg4YUJudmpNMGhxS2NIMTZNZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662863);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('fOhsdbTEfWECCHgXgJa9W99gQNyBh8LtTbQrStSc', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiajJTbmJzZzVMRnFsUGJqa2RxRDB0OWluVWtwcDhvT3lOUklyTkxZWSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662868);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('PX3lxqBadnt3MuWRvMRLSXvmGm7pxHoJzxz0p2f8', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZW9wUFpKd1ZrbXR6NTVyZmE1ZUVLZXdTaER4TWJ3cE9yWGd2a0E3YyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662871);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('htMtm3Nwcv9OI8jZhsmVolx69DNqBMcso2WVWyDK', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiWWdOckRxdUhZWlBrdFFBQW95R051ZUZxSjh3U1VTQVV0eXBBY2NhSiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662874);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('m4WgVE2ztJK8H7YdUGdgG1GVSc7eDd8DQ5oazRNN', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSlhqWHNtWjFud0pIcFNYSTJBamZKYkhuWkVZM1FxQlM5eFhxc0FZZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662878);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('bcLRpw2uol5Y7jvgmG6xpzZZ221WJusQUf7PJfmt', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.101.2 Chrome/134.0.6998.205 Electron/35.5.1 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoicGx4eUNzNE5NWlcwa3FadVFZdUdTR3czdFdTenZLNTlEbEtwMEZjdyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751662906);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('tVEy2MGgbtgHNmwZJoYIJZIogZhVkjy7A8b2YsDe', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZXRvN3N2U0JTOHhHSzZHcmNxMW9WVHFTRFVyNXVmYVRTM2RuZGprUCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1751664997);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('X5QghthWQqe9QMyUcfzMSjHrZy0u3RHSxixnjgEO', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR0dIbUFuMVgwY0pZR3MzVm5PaHUyVmFQbVlrODlqbVVjUkRtdXlNWiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1751665030);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('iRTCtzYLfsW6xnmDFHqzuQAet64L8uPu2WYxbhgP', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMXlxRDdYaU52MlYxZWtVVmVpamZ4YzRNR1ZBS1RqMFQ0SDFLaDJ0ZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3Rlci9kcml2ZXIiO319', 1751665397);

-- --------------------------------------------------------
-- Table structure for table `cache`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` VARCHAR(255) NOT NULL,
  `value` LONGTEXT NOT NULL,
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
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` VARCHAR(255) NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `attempts` TINYINT UNSIGNED NOT NULL,
  `reserved_at` INT UNSIGNED NULL,
  `available_at` INT UNSIGNED NOT NULL,
  `created_at` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `jobs_queue_index` (`queue`)
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
  `failed_job_ids` LONGTEXT NOT NULL,
  `options` MEDIUMTEXT NULL,
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
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL,
  `connection` TEXT NOT NULL,
  `queue` TEXT NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `passenger_profiles`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `passenger_profiles`;
CREATE TABLE `passenger_profiles` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `emergency_contact_name` VARCHAR(255) NULL,
  `emergency_contact_phone` VARCHAR(20) NULL,
  `preferences` TEXT NULL,
  `rating` DECIMAL(3,2) NOT NULL DEFAULT 0.00,
  `total_trips` INT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `passenger_profiles_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `passenger_profiles`
-- --------------------------------------------------------

INSERT INTO `passenger_profiles` (`id`, `user_id`, `emergency_contact_name`, `emergency_contact_phone`, `preferences`, `rating`, `total_trips`, `created_at`, `updated_at`) VALUES (1, 2, 'Nathan', '0708579885', 'quiet melancholic music', 0, 0, '2025-07-04 13:40:38', '2025-07-04 18:28:48');

-- --------------------------------------------------------
-- Table structure for table `saccos`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `saccos`;
CREATE TABLE `saccos` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `phone_number` VARCHAR(20) NOT NULL,
  `location` VARCHAR(255) NOT NULL,
  `route_from` VARCHAR(255) NOT NULL,
  `route_to` VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `saccos`
-- --------------------------------------------------------

INSERT INTO `saccos` (`id`, `name`, `phone_number`, `location`, `route_from`, `route_to`, `description`, `is_active`, `created_at`, `updated_at`) VALUES (5, 'Nairobi City Express', '+254712345678', 'Nairobi CBD', 'Nairobi', 'voi/mombasa', 'Express transport service between Nairobi and Mombasa', 1, '2025-07-04 18:53:05', '2025-07-04 19:12:07');
INSERT INTO `saccos` (`id`, `name`, `phone_number`, `location`, `route_from`, `route_to`, `description`, `is_active`, `created_at`, `updated_at`) VALUES (7, 'Nakuru SACCO', '+254734567890', 'Nakuru', 'Nakuru', 'Nairobi', 'Reliable transport service from Nakuru to Nairobi', 1, '2025-07-04 18:53:05', '2025-07-04 18:53:05');
INSERT INTO `saccos` (`id`, `name`, `phone_number`, `location`, `route_from`, `route_to`, `description`, `is_active`, `created_at`, `updated_at`) VALUES (9, 'Test SACCO', '+254700000000', 'Test Location', 'Point A', 'Point B', 'Test description', 1, '2025-07-04 18:58:33', '2025-07-04 18:58:33');
INSERT INTO `saccos` (`id`, `name`, `phone_number`, `location`, `route_from`, `route_to`, `description`, `is_active`, `created_at`, `updated_at`) VALUES (10, 'Nyamakima', '0708579885', 'Nairobi, Kenya', 'mombasa', 'nairobi', NULL, 1, '2025-07-04 18:59:38', '2025-07-04 18:59:38');
INSERT INTO `saccos` (`id`, `name`, `phone_number`, `location`, `route_from`, `route_to`, `description`, `is_active`, `created_at`, `updated_at`) VALUES (11, 'Nairobi City Express', '+254712345678', 'Nairobi CBD', 'Nairobi', 'Mombasa', 'Express transport service between Nairobi and Mombasa', 1, '2025-07-04 20:28:41', '2025-07-04 20:28:41');
INSERT INTO `saccos` (`id`, `name`, `phone_number`, `location`, `route_from`, `route_to`, `description`, `is_active`, `created_at`, `updated_at`) VALUES (12, 'Kisumu Transport Co-op', '+254723456789', 'Kisumu', 'Kisumu', 'Eldoret', 'Regional transport cooperative serving western Kenya', 1, '2025-07-04 20:28:41', '2025-07-04 20:28:41');
INSERT INTO `saccos` (`id`, `name`, `phone_number`, `location`, `route_from`, `route_to`, `description`, `is_active`, `created_at`, `updated_at`) VALUES (13, 'Nakuru SACCO', '+254734567890', 'Nakuru', 'Nakuru', 'Nairobi', 'Reliable transport service from Nakuru to Nairobi', 1, '2025-07-04 20:28:41', '2025-07-04 20:28:41');
INSERT INTO `saccos` (`id`, `name`, `phone_number`, `location`, `route_from`, `route_to`, `description`, `is_active`, `created_at`, `updated_at`) VALUES (14, 'Mombasa Coast Shuttle', '+254745678901', 'Mombasa', 'Mombasa', 'Malindi', 'Coastal transport service', 1, '2025-07-04 20:28:41', '2025-07-04 20:28:41');

-- --------------------------------------------------------
-- Table structure for table `driver_profiles`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `driver_profiles`;
CREATE TABLE `driver_profiles` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `license_number` VARCHAR(255) NOT NULL,
  `license_expiry` DATE NOT NULL,
  `vehicle_type` VARCHAR(100) NOT NULL,
  `vehicle_make` VARCHAR(100) NOT NULL,
  `vehicle_model` VARCHAR(100) NOT NULL,
  `vehicle_year` YEAR NOT NULL,
  `vehicle_plate_number` VARCHAR(20) NOT NULL,
  `vehicle_color` VARCHAR(50) NOT NULL,
  `vehicle_description` TEXT NULL,
  `status` VARCHAR(50) NOT NULL DEFAULT 'pending',
  `is_available` TINYINT(1) NOT NULL DEFAULT 1,
  `rating` DECIMAL(3,2) NOT NULL DEFAULT 0.00,
  `total_trips` INT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `sacco_id` BIGINT UNSIGNED NULL,
  PRIMARY KEY (`id`),
  INDEX `driver_profiles_user_id_index` (`user_id`),
  INDEX `driver_profiles_sacco_id_index` (`sacco_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `driver_profiles`
-- --------------------------------------------------------

INSERT INTO `driver_profiles` (`id`, `user_id`, `license_number`, `license_expiry`, `vehicle_type`, `vehicle_make`, `vehicle_model`, `vehicle_year`, `vehicle_plate_number`, `vehicle_color`, `vehicle_description`, `status`, `is_available`, `rating`, `total_trips`, `created_at`, `updated_at`, `sacco_id`) VALUES (1, 3, 'Dl-8582', '2025-07-18 00:00:00', 'matatu', 'toyota', 'civic', 1980, 'kar343f', 'white', NULL, 'approved', 1, 0, 0, '2025-07-04 13:42:31', '2025-07-04 19:25:43', 10);

-- --------------------------------------------------------
-- Table structure for table `trips`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `trips`;
CREATE TABLE `trips` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `driver_id` BIGINT UNSIGNED NOT NULL,
  `sacco_id` BIGINT UNSIGNED NOT NULL,
  `from_location` VARCHAR(255) NOT NULL,
  `to_location` VARCHAR(255) NOT NULL,
  `departure_time` DATETIME NOT NULL,
  `estimated_arrival_time` DATETIME NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `status` VARCHAR(50) NOT NULL DEFAULT 'scheduled',
  `available_seats` INT NOT NULL DEFAULT 0,
  `booked_seats` INT NOT NULL DEFAULT 0,
  `notes` TEXT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `trips_driver_id_index` (`driver_id`),
  INDEX `trips_sacco_id_index` (`sacco_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `trips`
-- --------------------------------------------------------

INSERT INTO `trips` (`id`, `driver_id`, `sacco_id`, `from_location`, `to_location`, `departure_time`, `estimated_arrival_time`, `amount`, `status`, `available_seats`, `booked_seats`, `notes`, `created_at`, `updated_at`) VALUES (1, 1, 10, 'Nairobi CBD', 'Kiambu', '2025-07-04 23:57:00', '2025-07-05 03:57:00', 1999.97, 'completed', 12, 0, NULL, '2025-07-04 19:58:00', '2025-07-04 20:02:47');
INSERT INTO `trips` (`id`, `driver_id`, `sacco_id`, `from_location`, `to_location`, `departure_time`, `estimated_arrival_time`, `amount`, `status`, `available_seats`, `booked_seats`, `notes`, `created_at`, `updated_at`) VALUES (2, 1, 10, 'Nairobi CBD', 'Kiambu', '2025-07-04 23:07:00', '2025-07-05 01:07:00', 1999.97, 'scheduled', 14, 5, NULL, '2025-07-04 20:07:35', '2025-07-04 21:10:20');
INSERT INTO `trips` (`id`, `driver_id`, `sacco_id`, `from_location`, `to_location`, `departure_time`, `estimated_arrival_time`, `amount`, `status`, `available_seats`, `booked_seats`, `notes`, `created_at`, `updated_at`) VALUES (3, 1, 5, 'Nairobi CBD', 'Westlands', '2025-07-04 22:19:05', '2025-07-04 22:49:05', 50, 'scheduled', 14, 1, 'Express route via Uhuru Highway', '2025-07-04 20:19:05', '2025-07-04 20:28:02');
INSERT INTO `trips` (`id`, `driver_id`, `sacco_id`, `from_location`, `to_location`, `departure_time`, `estimated_arrival_time`, `amount`, `status`, `available_seats`, `booked_seats`, `notes`, `created_at`, `updated_at`) VALUES (4, 1, 5, 'Westlands', 'Nairobi CBD', '2025-07-05 00:19:05', '2025-07-05 00:49:05', 50, 'scheduled', 14, 2, 'Return trip via Uhuru Highway', '2025-07-04 20:19:05', '2025-07-04 20:19:05');
INSERT INTO `trips` (`id`, `driver_id`, `sacco_id`, `from_location`, `to_location`, `departure_time`, `estimated_arrival_time`, `amount`, `status`, `available_seats`, `booked_seats`, `notes`, `created_at`, `updated_at`) VALUES (5, 1, 5, 'Nairobi CBD', 'Karen', '2025-07-05 02:19:05', '2025-07-05 03:04:05', 80, 'scheduled', 14, 1, 'Route via Langata Road', '2025-07-04 20:19:05', '2025-07-04 20:19:05');
INSERT INTO `trips` (`id`, `driver_id`, `sacco_id`, `from_location`, `to_location`, `departure_time`, `estimated_arrival_time`, `amount`, `status`, `available_seats`, `booked_seats`, `notes`, `created_at`, `updated_at`) VALUES (6, 1, 5, 'Karen', 'Nairobi CBD', '2025-07-05 04:19:05', '2025-07-05 05:04:05', 80, 'scheduled', 14, 0, 'Return trip via Langata Road', '2025-07-04 20:19:05', '2025-07-04 20:19:05');
INSERT INTO `trips` (`id`, `driver_id`, `sacco_id`, `from_location`, `to_location`, `departure_time`, `estimated_arrival_time`, `amount`, `status`, `available_seats`, `booked_seats`, `notes`, `created_at`, `updated_at`) VALUES (7, 1, 5, 'CBD', 'Eastlands', '2025-07-05 21:19:05', '2025-07-05 21:59:05', 60, 'cancelled', 14, 3, 'Route via Outer Ring Road', '2025-07-04 20:19:05', '2025-07-04 20:26:16');
INSERT INTO `trips` (`id`, `driver_id`, `sacco_id`, `from_location`, `to_location`, `departure_time`, `estimated_arrival_time`, `amount`, `status`, `available_seats`, `booked_seats`, `notes`, `created_at`, `updated_at`) VALUES (8, 1, 10, 'Bungoma', 'nairobi', '2222-05-12 20:00:00', '2222-05-31 04:00:00', 1999.98, 'scheduled', 13, 0, NULL, '2025-07-04 20:25:41', '2025-07-04 20:25:41');

-- --------------------------------------------------------
-- Table structure for table `bookings`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_reference` VARCHAR(255) NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `trip_id` BIGINT UNSIGNED NOT NULL,
  `passenger_name` VARCHAR(255) NOT NULL,
  `passenger_email` VARCHAR(255) NOT NULL,
  `passenger_phone` VARCHAR(20) NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `seats_booked` INT NOT NULL DEFAULT 1,
  `status` VARCHAR(50) NOT NULL DEFAULT 'pending',
  `booking_details` TEXT NULL,
  `booking_date` DATETIME NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bookings_booking_reference_unique` (`booking_reference`),
  INDEX `bookings_user_id_index` (`user_id`),
  INDEX `bookings_trip_id_index` (`trip_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `payments`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `payment_reference` VARCHAR(255) NOT NULL,
  `booking_id` BIGINT UNSIGNED NOT NULL,
  `phone_number` VARCHAR(20) NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `payment_method` VARCHAR(50) NOT NULL DEFAULT 'mpesa',
  `status` VARCHAR(50) NOT NULL DEFAULT 'pending',
  `transaction_id` VARCHAR(255) NULL,
  `checkout_request_id` VARCHAR(255) NULL,
  `merchant_request_id` VARCHAR(255) NULL,
  `payment_details` TEXT NULL,
  `paid_at` TIMESTAMP NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_payment_reference_unique` (`payment_reference`),
  INDEX `payments_booking_id_index` (`booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
