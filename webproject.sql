-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2023 at 06:15 PM
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
(11, 'Crew Railaway', 'Crew Railaway'),
(12, 'CS', 'CS'),
(13, 'machinist', 'machinist'),
(14, 'stewardess', 'stewardess');

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
('Bunga01', 'Bunga Laelatu M(Benar)', 'bungamagelang57@gmail.com', 'bungaa', '$2y$10$LjSPDzSmyleRcEttUiifEeC9h2aLLdzzaevtmE2aWiDNipkf1CMGm', 'Department3', 'Admin', NULL),
('ji0', 'aa', '21102010@ittelkom-pwt.ac.id', 'a', '$2y$10$lgF.eiX0Sb2g9a11gSs6reD5mKf/ZdTjDvPBRIAl90wkmhKMnZK16', 'aa', 'Staff', NULL),
('staffBunga', 'BungaStaff', 'staff@gmail.com', 'staff', '$2y$10$fcUtgrE2VgI2EQ7xUrn50u9cHXLlMSlWWslsQQKw42X0YMxPj.Q62', 'stewardess', 'Staff', NULL);

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
  MODIFY `departmentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `scheduleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
