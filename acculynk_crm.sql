-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 03, 2018 at 07:12 PM
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
-- Table structure for table `tbl_companies`
--

CREATE TABLE `tbl_companies` (
  `userPic` varchar(60) NOT NULL,
  `id` int(11) NOT NULL,
  `companyName` varchar(60) NOT NULL,
  `companyEmail` varchar(50) DEFAULT NULL,
  `companyPhoneNumber` varchar(15) DEFAULT NULL,
  `companyWebsite` varchar(50) DEFAULT NULL,
  `category` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_companies`
--

INSERT INTO `tbl_companies` (`userPic`, `id`, `companyName`, `companyEmail`, `companyPhoneNumber`, `companyWebsite`, `category`) VALUES
('', 71, 'Phone Limited', 'phone@limited.com', '0712356354', 'phone.com', 'Service'),
('', 72, 'Bicycle Wheels', 'bicycle@info.com', '0712356354', 'www.hut.com', 'Merchandising');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact`
--

CREATE TABLE `tbl_contact` (
  `contact_id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phoneNumber` varchar(15) NOT NULL,
  `idNumber` int(20) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `company` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_notes`
--

CREATE TABLE `tbl_contact_notes` (
  `notesId` int(11) NOT NULL,
  `notesTitle` varchar(50) NOT NULL,
  `notesDescription` text NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dueDate` datetime NOT NULL,
  `contactId` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `email` varchar(100) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `idNumber` int(20) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `userLevel` varchar(10) NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `last_passchange` timestamp NULL DEFAULT NULL,
  `isActive` int(1) DEFAULT '1',
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT '0',
  `tokenCode` varchar(60) DEFAULT NULL,
  `online` enum('Y','N') DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `firstName`, `lastName`, `email`, `gender`, `phoneNumber`, `idNumber`, `pass`, `photo`, `userLevel`, `last_login`, `last_passchange`, `isActive`, `date_created`, `created_by`, `tokenCode`, `online`) VALUES
(1, 'Admin', 'Admin', 'admin@localhost.com', 'Male', '0000000000', 1000000, '5f4dcc3b5aa765d61d8327deb882cf99', NULL, '', NULL, NULL, 1, '2017-12-24 16:49:56', 0, NULL, 'Y'),
(3, 'Twiga', 'Musiya', 'twiga@mus.com', 'Female', '0783434783', 27837637, '5f4dcc3b5aa765d61d8327deb882cf99', NULL, '3', NULL, NULL, 1, '2017-12-29 06:57:26', 0, NULL, 'N'),
(4, 'Dalo', 'Mallo', 'mcdalinoluoch@gmail.com', 'Male', '0715973838', 37362767, 'a3ef74254a5d1c201295bb3049da26ed', NULL, '2', NULL, NULL, 1, '2017-12-30 00:28:02', 0, '', 'Y'),
(5, 'Shopper', 'Sa', 'shopper@sacco.com', 'Male', '0712376327', 29837678, '90b35b961c5c9a1b3f0aea6aba8f2dc8', NULL, '2', NULL, NULL, 1, '2018-01-17 13:28:44', 0, NULL, 'N'),
(6, 'Another', 'Onnee', 'another@one.com', 'Male', '0723473478', 3823898, '6f85cfaae09acd596045d5e3130f7f87', NULL, '2', NULL, NULL, 1, '2018-01-17 13:31:04', 0, NULL, 'N');

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
('2', 'Sales Manager', 'In charge of the Sales Team'),
('3', 'Sales Team', 'Perform sales activities');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_companies`
--
ALTER TABLE `tbl_companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `company` (`company`);

--
-- Indexes for table `tbl_contact_notes`
--
ALTER TABLE `tbl_contact_notes`
  ADD PRIMARY KEY (`notesId`),
  ADD KEY `contactId` (`contactId`);

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
  ADD UNIQUE KEY `phoneNumber` (`phoneNumber`),
  ADD UNIQUE KEY `idNumber` (`idNumber`),
  ADD KEY `userLevel` (`userLevel`),
  ADD KEY `userLevel_2` (`userLevel`);

--
-- Indexes for table `tbl_user_level`
--
ALTER TABLE `tbl_user_level`
  ADD PRIMARY KEY (`userLevelId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_companies`
--
ALTER TABLE `tbl_companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_contact_notes`
--
ALTER TABLE `tbl_contact_notes`
  MODIFY `notesId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  ADD CONSTRAINT `tbl_contact_ibfk_1` FOREIGN KEY (`company`) REFERENCES `tbl_companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_contact_notes`
--
ALTER TABLE `tbl_contact_notes`
  ADD CONSTRAINT `tbl_contact_notes_ibfk_1` FOREIGN KEY (`contactId`) REFERENCES `tbl_contact` (`contact_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
