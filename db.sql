-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2023 at 11:27 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cityindex`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_details`
--

CREATE TABLE `bank_details` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `bank_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `branch_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ifsc_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0->inactive, 1->active',
  `created_at` bigint(20) DEFAULT NULL,
  `updated_at` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commission`
--

CREATE TABLE `commission` (
  `id` bigint(20) NOT NULL,
  `introducer_id` bigint(20) DEFAULT NULL,
  `investment_id` bigint(20) DEFAULT NULL,
  `investor_id` bigint(20) DEFAULT NULL,
  `bank_details` text DEFAULT NULL,
  `investment_amount` decimal(10,2) DEFAULT NULL,
  `commission` decimal(10,2) DEFAULT NULL COMMENT 'introducer commission percentage',
  `per_day_commission` decimal(10,2) DEFAULT NULL,
  `total_days` int(11) DEFAULT NULL,
  `total_commission` decimal(10,2) DEFAULT NULL,
  `month_amount` decimal(10,2) DEFAULT NULL,
  `curr_month` int(11) DEFAULT NULL,
  `curr_year` int(11) DEFAULT NULL,
  `created_at` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Investor'),
(3, 'Introducer');

-- --------------------------------------------------------

--
-- Table structure for table `infinitive`
--

CREATE TABLE `infinitive` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `active` tinyint(4) DEFAULT 1,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `infinitive`
--

INSERT INTO `infinitive` (`id`, `name`, `active`, `created_at`) VALUES
(1, 'Avoir\n', 1, 1675754210),
(2, 'Pleuvoir', 1, 1675754236);

-- --------------------------------------------------------

--
-- Table structure for table `interest`
--

CREATE TABLE `interest` (
  `id` bigint(20) NOT NULL,
  `investor_id` bigint(20) DEFAULT NULL,
  `investment_id` bigint(20) DEFAULT NULL,
  `bank_details` text DEFAULT NULL,
  `investment_date` varchar(100) DEFAULT NULL,
  `investment_amount` decimal(10,2) DEFAULT NULL,
  `interest` decimal(10,2) DEFAULT NULL,
  `per_day_interest` decimal(10,2) DEFAULT NULL,
  `total_days` int(11) DEFAULT NULL,
  `total_interest` decimal(10,2) DEFAULT NULL,
  `tds_percentage` decimal(10,2) DEFAULT NULL,
  `tds` decimal(10,2) DEFAULT NULL,
  `other_charges` decimal(10,2) DEFAULT NULL,
  `payble_interest` decimal(10,2) DEFAULT NULL,
  `month_amount` decimal(10,2) DEFAULT NULL,
  `curr_month` int(11) DEFAULT NULL,
  `curr_year` int(11) DEFAULT NULL,
  `created_at` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `investment`
--

CREATE TABLE `investment` (
  `id` bigint(20) NOT NULL,
  `investor_id` bigint(20) DEFAULT NULL,
  `introducer_id` bigint(20) DEFAULT NULL,
  `investment_amount` decimal(10,2) DEFAULT NULL,
  `interest` decimal(10,2) DEFAULT NULL,
  `introducer_commission` decimal(10,2) DEFAULT NULL,
  `tds` decimal(10,2) DEFAULT NULL,
  `other_charges` decimal(10,2) DEFAULT NULL,
  `reason_other_charges` text DEFAULT NULL,
  `bank_details` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0-> inactive, 1 -> active',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `investment_tracker`
--

CREATE TABLE `investment_tracker` (
  `id` bigint(20) NOT NULL,
  `investment_id` bigint(20) DEFAULT NULL,
  `updated_investment_amount` decimal(10,2) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `investors_document`
--

CREATE TABLE `investors_document` (
  `id` bigint(20) NOT NULL,
  `investor_id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `created_at` varchar(100) DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `relationship_manager`
--

CREATE TABLE `relationship_manager` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `created_at` varchar(100) DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `relationship_manager`
--

INSERT INTO `relationship_manager` (`id`, `name`, `email`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'RAHUL', 'rahul@mail.com', '8088552525', '1643189959', NULL),
(2, 'PRASAD', 'prasad@mail.com', '9743103695', '1643189986', '1678446995');

-- --------------------------------------------------------

--
-- Table structure for table `total_monthly_payout`
--

CREATE TABLE `total_monthly_payout` (
  `id` bigint(20) NOT NULL,
  `total_commission` decimal(10,2) DEFAULT NULL,
  `total_interest` decimal(10,2) DEFAULT NULL,
  `payble_interest` decimal(10,2) DEFAULT NULL,
  `tds_charges` decimal(10,2) DEFAULT NULL,
  `other_charges` decimal(10,2) DEFAULT NULL,
  `total_investor` int(11) DEFAULT NULL,
  `total_introducer` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `created_at` varchar(100) DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `member_id` varchar(255) DEFAULT NULL,
  `group_id` int(11) NOT NULL,
  `introducer_id` bigint(20) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `new_email` varchar(191) DEFAULT NULL,
  `password_hash` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `rm_name` varchar(255) DEFAULT NULL COMMENT 'Relationship Manager Name',
  `rm_meeting_date` varchar(100) DEFAULT NULL COMMENT 'RM meeting date',
  `rm_discussion_points` text DEFAULT NULL,
  `introducer_commission` decimal(10,2) NOT NULL DEFAULT 0.00,
  `activate_hash` varchar(191) DEFAULT NULL,
  `reset_hash` varchar(191) DEFAULT NULL,
  `reset_expires` bigint(20) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` bigint(20) DEFAULT NULL,
  `updated_at` bigint(20) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0->deleted, 1-> not deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `member_id`, `group_id`, `introducer_id`, `email`, `new_email`, `password_hash`, `name`, `user_name`, `mobile`, `address`, `rm_name`, `rm_meeting_date`, `rm_discussion_points`, `introducer_commission`, `activate_hash`, `reset_hash`, `reset_expires`, `active`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, '', 1, NULL, 'admin@invest.com', NULL, '$2y$10$ncZXKr0Mh7uBktanPSeo8.w3zLtmjuXOQdNfnNHufIMwu1PJOKNtS', 'Super Admin', 'admin', '8550093663', NULL, NULL, NULL, NULL, '0.00', NULL, NULL, NULL, 1, NULL, 1675755578, 1);

-- --------------------------------------------------------

--
-- Table structure for table `withdraw`
--

CREATE TABLE `withdraw` (
  `id` bigint(20) NOT NULL,
  `investment_id` bigint(20) DEFAULT NULL,
  `previous_amount` decimal(10,2) DEFAULT NULL,
  `withdrawl_amount` decimal(10,2) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_details`
--
ALTER TABLE `bank_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commission`
--
ALTER TABLE `commission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `infinitive`
--
ALTER TABLE `infinitive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interest`
--
ALTER TABLE `interest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investment`
--
ALTER TABLE `investment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investment_tracker`
--
ALTER TABLE `investment_tracker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investors_document`
--
ALTER TABLE `investors_document`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `relationship_manager`
--
ALTER TABLE `relationship_manager`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `total_monthly_payout`
--
ALTER TABLE `total_monthly_payout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`) USING BTREE;

--
-- Indexes for table `withdraw`
--
ALTER TABLE `withdraw`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_details`
--
ALTER TABLE `bank_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commission`
--
ALTER TABLE `commission`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `infinitive`
--
ALTER TABLE `infinitive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `interest`
--
ALTER TABLE `interest`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investment`
--
ALTER TABLE `investment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investment_tracker`
--
ALTER TABLE `investment_tracker`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investors_document`
--
ALTER TABLE `investors_document`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `relationship_manager`
--
ALTER TABLE `relationship_manager`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `total_monthly_payout`
--
ALTER TABLE `total_monthly_payout`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
