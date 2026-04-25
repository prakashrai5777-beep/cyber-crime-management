-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2026 at 04:30 PM
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
-- Database: `cyber_crime`
--

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `id` int(11) NOT NULL,
  `complaint_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `crime_type` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text DEFAULT NULL,
  `resolution_note` text DEFAULT NULL,
  `resolved_at` datetime DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `user_id`, `crime_type`, `status`, `created_at`, `description`, `resolution_note`, `resolved_at`, `email`) VALUES
(18, 8, 'Online Fraud', 'Resolved', '2026-04-20 15:13:10', 'mere saath online fraud hua h ', NULL, NULL, NULL),
(23, 9, 'UPI Scam', 'Resolved', '2026-04-22 15:07:40', 'someone call me and ask a otp and me was sharing to someone then some money was deducted to my account', 'Do not approve unknown payment requests. Contact your bank immediately and report fraud.', '2026-04-23 20:53:53', NULL),
(25, 13, 'Cyber Bullying', 'Resolved', '2026-04-23 07:17:51', 'sir aapki gf kitani hai......', 'Block the user, save screenshots as evidence, and report on the platform.', '2026-04-23 20:53:38', NULL),
(26, 13, 'Cyber Bullying', 'Resolved', '2026-04-23 07:17:59', 'sir aapki gf kitani hai......', '5 h meri to', '2026-04-23 20:28:08', NULL),
(27, 14, 'Online Fraud', 'Resolved', '2026-04-23 07:22:34', 'sir ne hamari fees kha gye h', 'sir ko  khoob maro fees ke paise wapas le lo ', '2026-04-23 20:27:23', NULL),
(28, 15, 'Hacking', 'Resolved', '2026-04-23 07:28:40', 'rudra ne kai salo se hdfc bank me paise transfer nhi kiye h ', NULL, NULL, NULL),
(30, 17, 'Online Fraud', 'Resolved', '2026-04-23 14:23:11', 'bhaiya mere saath koi online fraud kr gya madam krdo', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `message` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `message`) VALUES
(1, 'prakash rai', 'prakashrai5777@gmail', 'bhai  otp scam h gya account se saare paise kat gye'),
(2, 'mayank rai', 'mayank10@gmail.com', 'online fraud'),
(3, 'mayank rai', 'mayank10@gmail.com', 'yrr kya bolu ab ');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `username`, `password`) VALUES
(1, 'prakash rai', 'prakashrai5777@gmail.com', 'prakash', '1234'),
(4, 'mayank rai', 'mayank10@gmail.com', 'mayank', '7879'),
(5, 'piyush rai', 'piyush123@gmail.com', 'piyush', '9424'),
(8, 'rohitrajput', 'rohitrajput01833@gmail.com', 'rohitrajput', '77729'),
(9, 'meena rai', 'pr431074@gmail.com', 'meena', '93020'),
(10, 'gulshan basena ', 'gulshanbasena8@gmail.com', 'gulshan', '9343'),
(12, 'naina sonwane', 'nainasonwanesonwane@gmail.com', 'naina', '9399'),
(13, 'sudhir bisen', 'sudhirbisen26@gmail.com', 'sudhir', '9424'),
(14, 'kamlesh parihar', 'kamleshparihar@gmail.com', 'kamlesh', '1132'),
(15, 'rudra rahangdale', 'rudrarahangdale97@gmail.com', 'rudra', '6261'),
(16, 'adarsh kumar', 'adarshchouhan2704@gmail.com', 'adarsh', '2704'),
(17, 'yadav kumar', 'yadav43@gmail.com', 'yadav', '2211');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
