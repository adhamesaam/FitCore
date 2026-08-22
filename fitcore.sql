-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2026 at 03:06 PM
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
-- Database: `fitcore`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `supplement_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goals`
--

CREATE TABLE `goals` (
  `userId` int(11) NOT NULL,
  `goal` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gym_locations`
--

CREATE TABLE `gym_locations` (
  `gymId` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gym_locations`
--

INSERT INTO `gym_locations` (`gymId`, `name`, `location`) VALUES
(1, 'FitCore Main Branch', 'Cairo'),
(2, 'FitCore Nasr City', 'Nasr City'),
(3, 'FitCore Giza', 'Giza');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `plan_name` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplements`
--

CREATE TABLE `supplements` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplements`
--

INSERT INTO `supplements` (`id`, `name`, `description`, `price`, `image_path`, `created_at`) VALUES
(1, 'Whey Protein Concentrate', 'High quality whey protein to support muscle recovery and growth after training. 30g protein per scoop.', 950.00, 'https://placehold.co/400x300/1b2331/c6ff3d?text=Whey+Protein', '2026-08-22 00:08:44'),
(2, 'Creatine Monohydrate', 'Pure micronized creatine to boost strength, power output, and lean muscle mass over time.', 480.00, 'https://placehold.co/400x300/1b2331/c6ff3d?text=Creatine', '2026-08-22 00:08:44'),
(3, 'BCAA 2:1:1', 'Branched-chain amino acids to reduce muscle soreness and support recovery between sessions.', 620.00, 'https://placehold.co/400x300/1b2331/c6ff3d?text=BCAA', '2026-08-22 00:08:44'),
(4, 'Mass Gainer', 'High calorie blend of protein and carbs designed to help hardgainers build size and mass.', 1350.00, 'https://placehold.co/400x300/1b2331/c6ff3d?text=Mass+Gainer', '2026-08-22 00:08:44'),
(5, 'Pre-Workout Energy', 'Caffeine and beta-alanine formula for energy, focus, and endurance during intense workouts.', 700.00, 'https://placehold.co/400x300/1b2331/c6ff3d?text=Pre-Workout', '2026-08-22 00:08:44'),
(6, 'Multivitamin Daily', 'Complete daily multivitamin to cover essential micronutrient needs for active lifestyles.', 380.00, 'https://placehold.co/400x300/1b2331/c6ff3d?text=Multivitamin', '2026-08-22 00:08:44'),
(7, 'Omega-3 Fish Oil', 'Fish oil softgels rich in EPA and DHA to support joint, heart, and brain health.', 420.00, 'https://placehold.co/400x300/1b2331/c6ff3d?text=Fish+Oil', '2026-08-22 00:08:44'),
(8, 'L-Glutamine', 'Amino acid supplement that supports muscle recovery and gut health after heavy training.', 540.00, 'https://placehold.co/400x300/1b2331/c6ff3d?text=Glutamine', '2026-08-22 00:08:44');

-- --------------------------------------------------------

--
-- Table structure for table `training_videos`
--

CREATE TABLE `training_videos` (
  `id` int(11) NOT NULL,
  `muscle_group` enum('Chest','Back','Legs','Arms','Shoulders','Abs') NOT NULL,
  `title` varchar(150) NOT NULL,
  `youtube_id` varchar(20) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_videos`
--

INSERT INTO `training_videos` (`id`, `muscle_group`, `title`, `youtube_id`, `is_default`, `created_at`) VALUES
(1, 'Chest', 'Perfect Push Up Form', 'jWxvty2KROs', 1, '2026-08-21 21:30:58'),
(2, 'Chest', 'Barbell Bench Press Tutorial', 'rT7DgCr-3pg', 1, '2026-08-21 21:30:58'),
(3, 'Back', 'Pull Up Progression', 'eGo4IYlbE5g', 1, '2026-08-21 21:30:58'),
(4, 'Back', 'Barbell Row Form', 'kBWAon7ItDw', 1, '2026-08-21 21:30:58'),
(5, 'Legs', 'Squat Technique Guide', 'ultWZbUMPL8', 1, '2026-08-21 21:30:58'),
(6, 'Legs', 'Romanian Deadlift Tutorial', '7j-2w4Bkj0A', 1, '2026-08-21 21:30:58'),
(7, 'Arms', 'Bicep Curl Form Tips', 'ykJmrZ5v0Oo', 1, '2026-08-21 21:30:58'),
(8, 'Arms', 'Tricep Pushdown Guide', '2-LAMcpzODU', 1, '2026-08-21 21:30:58'),
(9, 'Shoulders', 'Overhead Press Tutorial', 'B-aVuyhvLHU', 1, '2026-08-21 21:30:58'),
(10, 'Shoulders', 'Lateral Raise Form', '3VcKaXpzqRo', 1, '2026-08-21 21:30:58'),
(11, 'Abs', 'Plank Form Guide', 'pSHjTRCQxIw', 1, '2026-08-21 21:30:58'),
(12, 'Abs', 'Hanging Leg Raise Tutorial', 'JB2oyawG9KI', 1, '2026-08-21 21:30:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `role` varchar(50) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `gym_location_id` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `gender`, `role`, `photo`, `created_at`, `gym_location_id`, `password`, `remember_token`) VALUES
(2, 'Adham Ahmed', 'ahmed@gmail.com', 'Male', 'admin', NULL, '2026-08-21 03:19:20', NULL, '89898959bB@', NULL),
(10, 'm ', 'm@gmail.com', 'Male', 'admin', NULL, '2026-08-22 00:35:26', NULL, '89898959bB@', NULL),
(13, 'd a', 'd@gmial.com', 'Male', 'admin', NULL, '2026-08-20 21:00:00', NULL, '1245', '872c71f9e21803814762ce13f48a6140'),
(14, 'mahmoud ahmed', 'mahamed@gmail.com', 'Male', 'user', NULL, '2026-07-31 21:00:00', NULL, '89898959bB@', 'ea321afad3cf48ff8e9c3f34eff2eb09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplement_id` (`supplement_id`);

--
-- Indexes for table `goals`
--
ALTER TABLE `goals`
  ADD KEY `fk_goals_user` (`userId`);

--
-- Indexes for table `gym_locations`
--
ALTER TABLE `gym_locations`
  ADD PRIMARY KEY (`gymId`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_subscriptions_user` (`user_id`);

--
-- Indexes for table `supplements`
--
ALTER TABLE `supplements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_videos`
--
ALTER TABLE `training_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_users_gym_location` (`gym_location_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gym_locations`
--
ALTER TABLE `gym_locations`
  MODIFY `gymId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `supplements`
--
ALTER TABLE `supplements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `training_videos`
--
ALTER TABLE `training_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`supplement_id`) REFERENCES `supplements` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `goals`
--
ALTER TABLE `goals`
  ADD CONSTRAINT `fk_goals_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `fk_subscriptions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_gym_location` FOREIGN KEY (`gym_location_id`) REFERENCES `gym_locations` (`gymId`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
