-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2023 at 05:31 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `departmentId` int(11) NOT NULL,
  `departmentName` varchar(255) NOT NULL,
  `departmentDesc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`departmentId`, `departmentName`, `departmentDesc`) VALUES
(12, 'CS', 'CS'),
(13, 'machinist', 'machinist'),
(14, 'stewardess', 'stewardess'),
(15, 'OPERATION ', 'The operation of the railway is through a system of control');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `scheduleId` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `crewID` varchar(255) NOT NULL,
  `jobRoles` varchar(255) NOT NULL,
  `dutyTime` varchar(255) NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`scheduleId`, `fullName`, `crewID`, `jobRoles`, `dutyTime`, `startTime`, `endTime`) VALUES
(8, 'Ain Zulaikha', 'S-AIN', 'stewardess', '4', '00:00:00', '04:00:00'),
(9, 'Yamunah', 'S-YMN', 'stewardess', '2', '21:00:00', '23:00:00'),
(10, 'Bunga', 'S-BG', 'stewardess', '3', '18:00:00', '22:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `crewId` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `userRole` varchar(255) NOT NULL,
  `mfa_secret` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`crewId`, `name`, `email`, `username`, `password`, `department`, `userRole`, `mfa_secret`) VALUES
('adminBunga', 'BungaAdmin', 'admin@gmail.com', 'root', '$2y$10$ROyDzwHXo6g2Ld2c/.4M/./jS1JwCGjCzqqin0c/BYH96hbQapv9G', 'Department1', 'Admin', NULL),
('ai210002', 'vinisha', 'vinisha@gmail.com', 'root', '$2y$10$2LhRLfQQjbOBPhOKACQYBe8TF//9TF7P2BSovdQPplJjZrABnJwKG', 'Department3', 'Admin', NULL),
('ai210003', 'hossini', 'hossini@gmail.com', 'root', '$2y$10$7zneqb1VGDtfag/zAGiVs.pkhECRCBe7yduMd8RABbPLcCYxY5KBm', 'Department1', 'Staff', NULL),
('ai210004', 'tulasi', 'tulasi@gmail.com', 'root', '$2y$10$dfV8.S57rlwIuET3I93yfe75.TFUMhZf4g5Ke7bFGQk6b6b.bRtOS', 'Department2', 'Admin', NULL),
('ai210005', 'qw', 'qw@gmail.com', 'root', '$2y$10$DxXPE4XSgp7ykfArv84.F.aPfQVJLimJoIq4bqTWRePl2X4XVDeLG', 'Department1', 'Admin', NULL),
('di210001', 'YAMUNAH A/P K.RAGUBATHI', 'muna@gmail.com', 'root', '$2y$10$Cgs2S7kK/RHNwd3srSbVWeMYU.US9CQhNux4JpvDtTEprgC7jys1W', 'CS', 'Admin', NULL),
('di210002', 'chee', 'chee@gmail.com', 'root', '$2y$10$UjVEZ5EBffTS43qu5hmj7e6wDI.LA4m8ve7noByBmwcyTOP8Il7N.', 'Department1', 'Staff', NULL),
('di210005', 'zx', 'zx@gmail.com', 'root', '$2y$10$soDkbBqRcgZOYoH8u4.Yk.Ps79dh7Vr4VOkqGkp1eL5H5mIimTNEW', 'Department2', 'Admin', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`departmentId`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`scheduleId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`crewId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `departmentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `scheduleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
