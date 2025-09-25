-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2025 at 11:33 PM
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
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `category_id` int(6) NOT NULL,
  `name` varchar(80) NOT NULL,
  `icon` varchar(120) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_courses`
--

CREATE TABLE `tbl_courses` (
  `course_id` bigint(6) NOT NULL,
  `title` varchar(200) NOT NULL,
  `category_id` int(6) NOT NULL,
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
(1, 'Become to Front-end Developer', 1, 'Learn2Code', 'Natthaphong', 'beginner', 'TH', 'paid', 2790.00, '6 สัปดาห์', 'เริ่มต้นสู่การเป็นนักพัฒนาเว็บไซต์\r\nBecome to Front-end Developer\r\nกับพื้นฐานที่สำคัญที่สุดของทักษะการสร้างเว็บสาย Front-End\r\nและ วิธีการคิดจาก Senior Programmer ที่มีประสบการณ์กว่า 10 ปี', 'uploads/courses/Xw9gVQ5UMVQbREZ378D0qSSf1BycYmOgVIOv8paw.jpg', 'https://www.borntodev.com/', 5.00, '2025-09-08 13:33:04'),
(2, 'Complete Python3 Programming', 9, 'Learn2Code', 'Natthaphong', 'intermediate', 'EN', 'paid', 2790.00, '10 ชั่วโมง', 'เริ่มต้นเส้นทางการเขียนโปรแกรมแบบจัดเต็ม\r\nComplete Python3 Programming\r\nเพราะพื้นฐานสำคัญที่สุด ทำให้ต่อยอดได้ไม่รู้จบกับภาษา Python 3\r\nที่จะทำให้ทักษะการเขียนโปรแกรมของคุณเหนือกว่าใครตั้งแต่ก้าวแรก', 'uploads/courses/vVQhhGuSxf4QhppT431clnPIHDVkVICLljSjP9w8.jpg', 'https://school.borntodev.com/course/complete-python3-programming', 5.00, '2025-09-08 13:36:09'),
(3, 'Fundamental Web Dev', 10, 'Learn2Code', 'Natthaphong', 'advanced', 'EN', 'paid', 690.00, '3 ชั่วโมง', 'เริ่มต้นเส้นทางนักออกแบบเว็บไซต์\r\nFundamental Web Dev With HTML5 & CSS3\r\nให้การสร้างเว็บไซต์เป็นเรื่องง่าย ๆ เปลี่ยนคนธรรมดาให้เข้าใจการทำงานของเว็บ\r\nถึงขั้นออกแบบ และ ประกอบอาชีพได้ครบจบในคอร์สเดียว', 'uploads/courses/gS6AxCXEd3ZN7uzcNmj1Iv9cFEivwbB9IIXSbbjN.jpg', 'https://www.borntodev.com/', 4.50, '2025-09-08 14:27:48'),
(4, 'Game Development', 11, 'Learn2Code', 'Natthaphong', 'beginner', 'TH', 'paid', 1290.00, '5 ชั่วโมง', 'หลักสูตร Game Development with Unreal Engine 5 เป็นหลักสูตรออนไลน์ที่สอนวิธีสร้างเกมโดยใช้ Unreal Engine 5 ซึ่งเป็นเครื่องมือสร้างเกมอันทรงพลังที่ใช้สร้างเกม AAA เช่น Fortnite, PUBG และ Gears of War หลักสูตรนี้เหมาะสำหรับทั้งผู้เริ่มต้นและนักพัฒนาเกมที่มีประสบการณ์ที่ต้องการเรียนรู้เกี่ยวกับ Unreal Engine 5', 'uploads/courses/OTodo3crYznAKFYietBo57IpuzZJJnhQITb9ijBP.jpg', 'https://school.borntodev.com/course/game-development-with-unreal-engine-5', 5.00, '2025-09-08 14:29:06'),
(5, 'Data Analytics with Python', 5, 'Learn2Code', 'Natthaphong', 'advanced', 'EN', 'paid', 12345.00, '3 ชั่วโมง', 'เข้าใจการวิเคราะห์ข้อมูลใน 2 สัปดาห์\r\nData Analytics With Python\r\nต่อยอดความรู้พื้นฐานการเขียนโปรแกรมด้วย Python ให้กลายเป็น\r\nการวิเคราะห์ข้อมูลขั้นเทพ สร้างคุณค่าให้กับโลก', 'uploads/courses/2zqI0H5ifv93KYj5ECuMYGcoigBnsKpbmgQhio7P.jpg', 'https://school.borntodev.com/course/data-analytics-with-python', 5.00, '2025-09-25 13:22:15'),
(6, 'Mini Course : GitHub for Beginner', 15, 'Learn2Code', 'Natthaphong Matkhao', 'advanced', 'TH', 'paid', 2990.00, '1 ชั่วโมง', 'หมดยุคการเรียนรู้สุดน่าเบื่อ เพราะนี่คือโลกยุคใหม่แล้ว ! ให้ทุกการเรียนรู้สร้างแรงบันดาลใจให้คุณ\r\nเริ่มต้นจนถึงใช้งานจริงแบบมือโปรกับเครื่องมือสุดพลัง', 'uploads/courses/O8xWPsIAu9eZOXzFDfLezpsWyBuYU9nZmG0hKQhe.jpg', 'https://school.borntodev.com/course/mini-course-github-for-beginner', 5.00, '2025-09-25 13:54:21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_favorites`
--

CREATE TABLE `tbl_favorites` (
  `user_id` bigint(6) NOT NULL,
  `course_id` bigint(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `role_id` tinyint(2) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `tbl_favorites`
--
ALTER TABLE `tbl_favorites`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  ADD PRIMARY KEY (`review_id`);

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
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `category_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_courses`
--
ALTER TABLE `tbl_courses`
  MODIFY `course_id` bigint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_favorites`
--
ALTER TABLE `tbl_favorites`
  MODIFY `user_id` bigint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  MODIFY `review_id` bigint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `role_id` tinyint(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` bigint(6) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
