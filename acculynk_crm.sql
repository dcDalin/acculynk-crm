-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2017 at 08:58 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `acculynk_crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sys_config`
--

CREATE TABLE `tbl_sys_config` (
  `item_id` int(12) NOT NULL,
  `main_url` varchar(200) NOT NULL,
  `system_name` varchar(100) NOT NULL,
  `system_registered_to` varchar(150) NOT NULL,
  `sys_default_ip` varchar(120) NOT NULL,
  `sys_status_enabled` int(12) NOT NULL DEFAULT '1',
  `support_email` varchar(150) NOT NULL,
  `support_phone` varchar(150) NOT NULL,
  `support_website` varchar(150) NOT NULL,
  `deployment_date` varchar(150) NOT NULL,
  `deployed_by` varchar(150) NOT NULL,
  `sys_version` varchar(100) NOT NULL,
  `system_act_status` int(12) NOT NULL DEFAULT '0',
  `termination_date` datetime NOT NULL,
  `isssl` varchar(12) DEFAULT NULL,
  `coop_phone` varchar(16) DEFAULT NULL,
  `coop_website` varchar(255) DEFAULT NULL,
  `companyAddress` text,
  `coop_countyid` int(11) DEFAULT NULL,
  `coop_email` varchar(120) DEFAULT NULL,
  `coop_logo` varchar(600) DEFAULT NULL,
  `coop_status` int(3) DEFAULT '1',
  `companyPIN` varchar(50) DEFAULT NULL,
  `companyName` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_sys_config`
--

INSERT INTO `tbl_sys_config` (`item_id`, `main_url`, `system_name`, `system_registered_to`, `sys_default_ip`, `sys_status_enabled`, `support_email`, `support_phone`, `support_website`, `deployment_date`, `deployed_by`, `sys_version`, `system_act_status`, `termination_date`, `isssl`, `coop_phone`, `coop_website`, `companyAddress`, `coop_countyid`, `coop_email`, `coop_logo`, `coop_status`, `companyPIN`, `companyName`) VALUES
(1, 'http://localhost/ufv', 'The CRM!', 'SME AFRICA UFV', '127.0.0.1', 1, 'support@acculynksystems.com', '0725 642 401, 0704727804', 'www.acculynksystems.com', '', 'Acculynk Systems', 'VER 1.0.0', 1, '2017-06-01 00:00:00', 'http://', '0720000000', 'www.smeafrica.net', 'SME AFRICA UFV', 3, 'info@smeafrica.net', 'logo.jpg', 1, 'P051615995Z', 'SME Resource Centre');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `phoneNumber` varchar(10) DEFAULT NULL,
  `idNumber` int(15) DEFAULT NULL,
  `pass` varchar(100) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `userLevel` enum('0','1','2','3','4','5','6') NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `last_passchange` timestamp NULL DEFAULT NULL,
  `isActive` int(1) DEFAULT '1',
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT '0',
  `tokenCode` varchar(60) NOT NULL,
  `online` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `firstName`, `lastName`, `email`, `gender`, `phoneNumber`, `idNumber`, `pass`, `photo`, `userLevel`, `last_login`, `last_passchange`, `isActive`, `date_created`, `created_by`, `tokenCode`, `online`) VALUES
(2, 'Dalin', 'Oluoch', 'mcdalinoluoch@gmail.com', 'Male', '0715973838', 30423877, '5f4dcc3b5aa765d61d8327deb882cf99', NULL, '0', NULL, NULL, 1, '2017-12-19 21:18:13', 0, 'da9eef6eeea8ae714a83869a485a55dd', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_level`
--

CREATE TABLE `tbl_user_level` (
  `userLevelId` enum('0','1','2','3','4','5','6') NOT NULL,
  `userLevelName` varchar(50) NOT NULL,
  `userLevelDescription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_level`
--

INSERT INTO `tbl_user_level` (`userLevelId`, `userLevelName`, `userLevelDescription`) VALUES
('1', 'Administrator', 'Performs administrative tasks'),
('2', 'Manager', 'Manages people');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_sys_config`
--
ALTER TABLE `tbl_sys_config`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `idNumber` (`idNumber`),
  ADD UNIQUE KEY `phoneNumber` (`phoneNumber`),
  ADD KEY `userLevel` (`userLevel`);

--
-- Indexes for table `tbl_user_level`
--
ALTER TABLE `tbl_user_level`
  ADD PRIMARY KEY (`userLevelId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
