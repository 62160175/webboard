-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 08, 2022 at 05:42 PM
-- Server version: 5.7.33
-- PHP Version: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbwebboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `m_id` int(11) NOT NULL,
  `m_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = member,2 = admin',
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `m_name` varchar(50) NOT NULL,
  `m_created` datetime NOT NULL,
  `m_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`m_id`, `m_type`, `email`, `password`, `m_name`, `m_created`, `m_image`) VALUES
(10, 2, 'admin@admin.com', '$2y$10$4wN.OUFEnNNvvsK2Qdbu/ezhyg8uudPiylPWx5cnLKbAGpyKnO7kG', 'Admin', '2022-09-08 17:41:15', '142596370_109150097834443_12673755584965935_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `qt_id` int(11) NOT NULL,
  `qt_title` varchar(255) NOT NULL,
  `qt_detail` text NOT NULL COMMENT 'รายละเอียด',
  `qt_view` int(11) DEFAULT '0' COMMENT 'จำนวนคนเข้าอ่าน',
  `qt_reply` int(11) DEFAULT '0' COMMENT 'จำนวนคนเข้าตอบ',
  `qt_created` datetime NOT NULL COMMENT 'วันที่สร้างข้อมุล',
  `m_id` int(11) NOT NULL,
  `qt_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE `reply` (
  `rp_id` int(11) NOT NULL,
  `rp_detail` text NOT NULL COMMENT 'แสดงความคิดเห็น',
  `rp_created` datetime NOT NULL,
  `qt_id` int(11) NOT NULL,
  `rp_image` varchar(100) NOT NULL,
  `m_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`qt_id`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`rp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `qt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `rp_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
