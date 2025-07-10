-- Database Verification Queries
-- Run these queries to verify your migration

-- 1. Check all tables exist
SHOW TABLES;

-- 2. Verify record counts
SELECT COUNT(*) as count_migrations FROM `migrations`; -- Expected: 14
SELECT COUNT(*) as count_users FROM `users`; -- Expected: 7
SELECT COUNT(*) as count_password_reset_tokens FROM `password_reset_tokens`; -- Expected: 0
SELECT COUNT(*) as count_sessions FROM `sessions`; -- Expected: 1
SELECT COUNT(*) as count_cache FROM `cache`; -- Expected: 0
SELECT COUNT(*) as count_cache_locks FROM `cache_locks`; -- Expected: 0
SELECT COUNT(*) as count_jobs FROM `jobs`; -- Expected: 0
SELECT COUNT(*) as count_job_batches FROM `job_batches`; -- Expected: 0
SELECT COUNT(*) as count_failed_jobs FROM `failed_jobs`; -- Expected: 0
SELECT COUNT(*) as count_passenger_profiles FROM `passenger_profiles`; -- Expected: 4
SELECT COUNT(*) as count_saccos FROM `saccos`; -- Expected: 4
SELECT COUNT(*) as count_driver_profiles FROM `driver_profiles`; -- Expected: 2
SELECT COUNT(*) as count_bookings FROM `bookings`; -- Expected: 0
SELECT COUNT(*) as count_payments FROM `payments`; -- Expected: 0
SELECT COUNT(*) as count_admin_notifications FROM `admin_notifications`; -- Expected: 3
SELECT COUNT(*) as count_trips FROM `trips`; -- Expected: 1

-- 3. Check table structures
DESCRIBE `migrations`;
DESCRIBE `users`;
DESCRIBE `password_reset_tokens`;
DESCRIBE `sessions`;
DESCRIBE `cache`;
DESCRIBE `cache_locks`;
DESCRIBE `jobs`;
DESCRIBE `job_batches`;
DESCRIBE `failed_jobs`;
DESCRIBE `passenger_profiles`;
DESCRIBE `saccos`;
DESCRIBE `driver_profiles`;
DESCRIBE `bookings`;
DESCRIBE `payments`;
DESCRIBE `admin_notifications`;
DESCRIBE `trips`;
