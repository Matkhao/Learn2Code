-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2025 at 10:17 AM
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
-- Database: `learn2code`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `featured_image` varchar(500) DEFAULT NULL,
  `author` varchar(100) NOT NULL DEFAULT 'Learn2Code Team',
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `views` int(11) NOT NULL DEFAULT 0,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `slug` varchar(255) NOT NULL,
  `meta_description` text DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_29_032545_create_articles_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL,
  `icon` varchar(120) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`category_id`, `name`, `icon`, `created_at`) VALUES
(1, 'พื้นฐานการเขียนโปรแกรม', 'bi-code-slash', '2025-09-27 17:03:38'),
(2, 'เว็บฟรอนต์เอนด์', 'bi-braces', '2025-09-27 17:03:38'),
(3, 'เว็บแบ็กเอนด์', 'bi-braces-asterisk', '2025-09-27 17:03:38'),
(4, 'ฟูลสแต็ก', 'bi-layers', '2025-09-27 17:03:38'),
(5, 'ฐานข้อมูล', 'bi-database', '2025-09-27 17:03:38'),
(6, 'วิทยาการข้อมูล (Data Science)', 'bi-graph-up', '2025-09-27 17:03:38'),
(7, 'ปัญญาประดิษฐ์/แมชชีนเลิร์นนิง', 'bi-robot', '2025-09-27 17:03:38'),
(8, 'วิศวกรรมข้อมูล (Data Engineering)', 'bi-diagram-3', '2025-09-27 17:03:38'),
(9, 'คลาวด์ & DevOps', 'bi-cloud', '2025-09-27 17:03:38'),
(10, 'ความปลอดภัยไซเบอร์', 'bi-shield-lock', '2025-09-27 17:03:38'),
(11, 'พัฒนาแอปมือถือ', 'bi-phone', '2025-09-27 17:03:38'),
(12, 'พัฒนาเกม', 'bi-joystick', '2025-09-27 17:03:38'),
(13, 'UI/UX ดีไซน์', 'bi-brush', '2025-09-27 17:03:38'),
(14, 'การทดสอบซอฟต์แวร์/QA', 'bi-bug', '2025-09-27 17:03:38'),
(15, 'IoT / Embedded', 'bi-cpu', '2025-09-27 17:03:38'),
(16, 'เครื่องมือ & เวิร์กโฟลว์ (Git/Docker)', 'bi-git', '2025-09-27 17:03:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_courses`
--

CREATE TABLE `tbl_courses` (
  `course_id` bigint(6) NOT NULL,
  `title` varchar(200) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `provider` varchar(120) NOT NULL,
  `provider_instructor` varchar(120) DEFAULT NULL,
  `level` varchar(20) NOT NULL,
  `language` varchar(50) NOT NULL,
  `price_type` varchar(10) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration_text` varchar(60) NOT NULL,
  `description` text NOT NULL,
  `cover_img` varchar(255) NOT NULL,
  `course_url` varchar(255) NOT NULL,
  `avg_rating` decimal(3,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_courses`
--

INSERT INTO `tbl_courses` (`course_id`, `title`, `category_id`, `provider`, `provider_instructor`, `level`, `language`, `price_type`, `price`, `duration_text`, `description`, `cover_img`, `course_url`, `avg_rating`, `created_at`) VALUES
(1, 'Become to Front-end Developer2', 2, 'Learn2Code2', 'Natthaphong2', 'beginner', 'TH', 'free', 0.00, '6 สัปดาห์', 'เริ่มต้นสู่การเป็นนักพัฒนาเว็บไซต์\r\nBecome to Front-end Developer\r\nกับพื้นฐานที่สำคัญที่สุดของทักษะการสร้างเว็บสาย Front-End\r\nและ วิธีการคิดจาก Senior Programmer ที่มีประสบการณ์กว่า 10 ปี', 'uploads/courses/Xw9gVQ5UMVQbREZ378D0qSSf1BycYmOgVIOv8paw.jpg', 'https://www.borntodev.com/', 5.00, '2025-09-08 13:33:04'),
(2, 'Complete Python3 Programming', 9, 'Learn2Code', 'Natthaphong', 'intermediate', 'EN', 'paid', 2790.00, '10 ชั่วโมง', 'เริ่มต้นเส้นทางการเขียนโปรแกรมแบบจัดเต็ม\r\nComplete Python3 Programming\r\nเพราะพื้นฐานสำคัญที่สุด ทำให้ต่อยอดได้ไม่รู้จบกับภาษา Python 3\r\nที่จะทำให้ทักษะการเขียนโปรแกรมของคุณเหนือกว่าใครตั้งแต่ก้าวแรก', 'uploads/courses/vVQhhGuSxf4QhppT431clnPIHDVkVICLljSjP9w8.jpg', 'https://school.borntodev.com/course/complete-python3-programming', 5.00, '2025-09-08 13:36:09'),
(3, 'Fundamental Web Dev', 10, 'Learn2Code', 'Natthaphong', 'advanced', 'EN', 'paid', 690.00, '3 ชั่วโมง', 'เริ่มต้นเส้นทางนักออกแบบเว็บไซต์\r\nFundamental Web Dev With HTML5 & CSS3\r\nให้การสร้างเว็บไซต์เป็นเรื่องง่าย ๆ เปลี่ยนคนธรรมดาให้เข้าใจการทำงานของเว็บ\r\nถึงขั้นออกแบบ และ ประกอบอาชีพได้ครบจบในคอร์สเดียว', 'uploads/courses/gS6AxCXEd3ZN7uzcNmj1Iv9cFEivwbB9IIXSbbjN.jpg', 'https://www.borntodev.com/', 4.50, '2025-09-08 14:27:48'),
(4, 'Game Development', 11, 'Learn2Code', 'Natthaphong', 'beginner', 'TH', 'paid', 1290.00, '5 ชั่วโมง', 'หลักสูตร Game Development with Unreal Engine 5 เป็นหลักสูตรออนไลน์ที่สอนวิธีสร้างเกมโดยใช้ Unreal Engine 5 ซึ่งเป็นเครื่องมือสร้างเกมอันทรงพลังที่ใช้สร้างเกม AAA เช่น Fortnite, PUBG และ Gears of War หลักสูตรนี้เหมาะสำหรับทั้งผู้เริ่มต้นและนักพัฒนาเกมที่มีประสบการณ์ที่ต้องการเรียนรู้เกี่ยวกับ Unreal Engine 5', 'uploads/courses/OTodo3crYznAKFYietBo57IpuzZJJnhQITb9ijBP.jpg', 'https://school.borntodev.com/course/game-development-with-unreal-engine-5', 5.00, '2025-09-08 14:29:06'),
(5, 'Data Analytics with Python', 5, 'Learn2Code', 'Natthaphong', 'advanced', 'EN', 'paid', 12345.00, '3 ชั่วโมง', 'เข้าใจการวิเคราะห์ข้อมูลใน 2 สัปดาห์\r\nData Analytics With Python\r\nต่อยอดความรู้พื้นฐานการเขียนโปรแกรมด้วย Python ให้กลายเป็น\r\nการวิเคราะห์ข้อมูลขั้นเทพ สร้างคุณค่าให้กับโลก', 'uploads/courses/2zqI0H5ifv93KYj5ECuMYGcoigBnsKpbmgQhio7P.jpg', 'https://school.borntodev.com/course/data-analytics-with-python', 5.00, '2025-09-25 13:22:15'),
(6, 'Mini Course : GitHub for Beginner', 16, 'Learn2Code', 'Natthaphong Matkhao', 'advanced', 'TH', 'paid', 2990.00, '1 ชั่วโมง', 'หมดยุคการเรียนรู้สุดน่าเบื่อ เพราะนี่คือโลกยุคใหม่แล้ว ! ให้ทุกการเรียนรู้สร้างแรงบันดาลใจให้คุณ\r\nเริ่มต้นจนถึงใช้งานจริงแบบมือโปรกับเครื่องมือสุดพลัง', 'uploads/courses/O8xWPsIAu9eZOXzFDfLezpsWyBuYU9nZmG0hKQhe.jpg', 'https://school.borntodev.com/course/mini-course-github-for-beginner', 2.00, '2025-09-25 13:54:21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_favorites`
--

CREATE TABLE `tbl_favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_favorites`
--

INSERT INTO `tbl_favorites` (`id`, `user_id`, `course_id`, `created_at`) VALUES
(10, 4, 6, '2025-09-27 21:11:50'),
(11, 3, 5, '2025-09-27 21:59:46'),
(12, 3, 4, '2025-09-27 21:59:53'),
(13, 3, 22, '2025-09-27 21:59:58'),
(14, 3, 6, '2025-09-27 22:40:46'),
(15, 4, 5, '2025-09-28 08:50:24'),
(16, 4, 1, '2025-09-28 13:40:01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_detail` text NOT NULL,
  `product_price` float(10,2) NOT NULL,
  `product_img` varchar(200) NOT NULL,
  `dateCreate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`id`, `product_name`, `product_detail`, `product_price`, `product_img`, `dateCreate`) VALUES
(1, 'Test1', '1234567890', 123.00, 'uploads/product/JExacHzaKJwjGR2kRZHd83REiNGDoAAFZj1de3Lf.png', '2025-09-07 23:52:18'),
(2, 'Test2', '1234567890', 123.00, 'uploads/product/JExacHzaKJwjGR2kRZHd83REiNGDoAAFZj1de3Lf.png', '2025-09-07 23:52:18'),
(3, 'Test3', '1234567890', 123.00, 'uploads/product/JExacHzaKJwjGR2kRZHd83REiNGDoAAFZj1de3Lf.png', '2025-09-07 23:52:18'),
(4, 'Test4', '1234567890', 123.00, 'uploads/product/JExacHzaKJwjGR2kRZHd83REiNGDoAAFZj1de3Lf.png', '2025-09-07 23:52:18'),
(5, 'Test5', '1234567890', 123.00, 'uploads/product/JExacHzaKJwjGR2kRZHd83REiNGDoAAFZj1de3Lf.png', '2025-09-07 23:52:18'),
(6, 'Test6', '1234567890', 123.00, 'uploads/product/JExacHzaKJwjGR2kRZHd83REiNGDoAAFZj1de3Lf.png', '2025-09-07 23:52:18'),
(7, 'Test7', '1234567890', 123.00, 'uploads/product/JExacHzaKJwjGR2kRZHd83REiNGDoAAFZj1de3Lf.png', '2025-09-07 23:52:18'),
(8, 'Test8', '1234567890', 123.00, 'uploads/product/JExacHzaKJwjGR2kRZHd83REiNGDoAAFZj1de3Lf.png', '2025-09-07 23:52:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reviews`
--

CREATE TABLE `tbl_reviews` (
  `review_id` bigint(6) NOT NULL,
  `course_id` bigint(6) NOT NULL,
  `user_id` bigint(6) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_reviews`
--

INSERT INTO `tbl_reviews` (`review_id`, `course_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(4, 6, 3, 1, 'test', '2025-09-27 21:28:05'),
(5, 6, 4, 3, 'Test', '2025-09-27 21:28:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `role_id` tinyint(2) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`role_id`, `code`, `name`) VALUES
(1, 'admin', 'Administrator'),
(2, 'member', 'Student / Member');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` bigint(6) NOT NULL,
  `role_id` tinyint(2) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(190) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `role_id`, `name`, `email`, `password`, `avatar_url`, `created_at`, `updated_at`) VALUES
(3, 1, 'bfr1end', 'ma.natthaphong.infj@gmail.com', '$2y$12$S/di1awYmeRwycc2aud2yeYbgn.Qq0/OCY8b3iASuit/XrBFG1u3.', NULL, '2025-09-27 15:42:17', '2025-09-27 22:50:32'),
(4, 2, 'arashi3659', 'test@gmail.com', '$2y$12$mSfIO/vK1yFo5/cYvHI9bOFckWG2kMFKQc1.V/CU0T6syAHC2kTFe', NULL, '2025-09-27 16:58:04', '2025-09-27 16:58:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `articles_slug_unique` (`slug`),
  ADD KEY `articles_status_published_at_index` (`status`,`published_at`),
  ADD KEY `articles_featured_published_at_index` (`featured`,`published_at`),
  ADD KEY `articles_slug_index` (`slug`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `tbl_courses`
--
ALTER TABLE `tbl_courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `fk_courses_category` (`category_id`);

--
-- Indexes for table `tbl_favorites`
--
ALTER TABLE `tbl_favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_fav` (`user_id`,`course_id`),
  ADD UNIQUE KEY `uniq_user_course` (`user_id`,`course_id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD UNIQUE KEY `uq_review` (`user_id`,`course_id`),
  ADD UNIQUE KEY `uniq_review_user_course` (`user_id`,`course_id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_users_role` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_courses`
--
ALTER TABLE `tbl_courses`
  MODIFY `course_id` bigint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_favorites`
--
ALTER TABLE `tbl_favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  MODIFY `review_id` bigint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `role_id` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` bigint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_courses`
--
ALTER TABLE `tbl_courses`
  ADD CONSTRAINT `fk_courses_category` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`category_id`) ON UPDATE CASCADE;

--
-- Constraints for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `tbl_roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
