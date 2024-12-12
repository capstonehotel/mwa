-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2024 at 09:14 PM
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
-- Database: `hmsystemdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_files`
--

CREATE TABLE `chat_files` (
  `file_id` varchar(255) NOT NULL,
  `message_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `livechat`
--

CREATE TABLE `livechat` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `message` text DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(10) DEFAULT NULL,
  `conversation_id` int(11) NOT NULL,
  `file_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `livechat`
--

INSERT INTO `livechat` (`id`, `sender_id`, `user_name`, `message`, `sent_at`, `status`, `conversation_id`, `file_id`) VALUES
(37, 148, 'Linux Ungon', 'huuhu', '2024-11-15 15:24:40', 0, 0, NULL),
(38, 148, 'admin', 'huhuhh', '2024-11-15 15:24:51', 0, 0, NULL),
(39, 148, 'admin', 'go', '2024-11-15 15:24:56', 0, 0, NULL),
(40, 148, 'Linux Ungon', 'huhuhu', '2024-11-15 15:25:10', 0, 0, NULL),
(41, 148, 'admin', 'hukokok', '2024-11-15 15:25:17', 0, 0, NULL),
(42, 148, 'Linux Ungon', 'kkk', '2024-11-19 20:11:58', 0, 0, NULL),
(43, 148, 'admin', 'huhu', '2024-11-19 22:12:51', 0, 0, NULL),
(44, 148, 'Linux Ungon', 'jiji', '2024-11-21 17:32:53', 0, 0, NULL),
(45, 148, 'admin', 'hu', '2024-11-27 21:36:38', 0, 0, NULL),
(46, 148, 'Linux Ungon', 'loq', '2024-11-27 21:37:31', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `MESSAGEID` int(11) NOT NULL,
  `SENDERID` int(11) NOT NULL,
  `RECEIVERID` int(11) NOT NULL,
  `SENDER_TYPE` enum('admin','guest') NOT NULL,
  `MESSAGE` text NOT NULL,
  `READ_STATUS` tinyint(1) DEFAULT 0,
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `ID` int(11) NOT NULL,
  `GUESTID` int(11) NOT NULL,
  `CONFIRMATIONCODE` varchar(50) NOT NULL,
  `ROOMID` varchar(100) NOT NULL,
  `PAYMENT_STATUS` varchar(50) NOT NULL,
  `SPRICE` decimal(10,2) NOT NULL,
  `TRANSDATE` datetime NOT NULL,
  `IS_READ` tinyint(1) DEFAULT 0,
  `AMOUNT_PAID` decimal(10,2) DEFAULT 0.00,
  `BALANCE` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`ID`, `GUESTID`, `CONFIRMATIONCODE`, `ROOMID`, `PAYMENT_STATUS`, `SPRICE`, `TRANSDATE`, `IS_READ`, `AMOUNT_PAID`, `BALANCE`) VALUES
(55, 152, 'yfxogjmb', '14', '', 1000.00, '2024-11-28 18:18:30', 0, 500.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `otp_verification`
--

CREATE TABLE `otp_verification` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp_hash` varchar(255) NOT NULL,
  `verification_token_hash` varchar(255) NOT NULL,
  `otp_expiry` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `star_ratings`
--

CREATE TABLE `star_ratings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_image` varchar(100) NOT NULL,
  `room_id` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `star_ratings`
--

INSERT INTO `star_ratings` (`id`, `user_id`, `user_name`, `user_image`, `room_id`, `rating`, `comment`, `created_at`) VALUES
(17, 148, 'Linux Ungon', 'Screenshot 2024-03-21 203055.png', '16', 3, 'mmm', '2024-11-18 19:32:44'),
(18, 148, 'Linux Ungon', 'Screenshot 2024-03-21 203055.png', '14', 3, 'nice', '2024-12-09 04:24:58'),
(19, 148, 'Linux Ungon', 'Screenshot 2024-03-21 203055.png', '173', 4, 'nice', '2024-12-09 04:25:40');

-- --------------------------------------------------------

--
-- Table structure for table `tblaccomodation`
--

CREATE TABLE `tblaccomodation` (
  `ACCOMID` int(11) NOT NULL,
  `ACCOMODATION` varchar(30) NOT NULL,
  `ACCOMDESC` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblaccomodation`
--

INSERT INTO `tblaccomodation` (`ACCOMID`, `ACCOMODATION`, `ACCOMDESC`) VALUES
(12, 'Standard Room', 'legit'),
(61, '2.056', 'legit'),
(62, 'sd', 'legit');

-- --------------------------------------------------------

--
-- Table structure for table `tblamenities`
--

CREATE TABLE `tblamenities` (
  `AMENID` int(11) NOT NULL,
  `AMENNAME` varchar(125) NOT NULL,
  `AMENDECS` varchar(125) NOT NULL,
  `AMENIMAGE` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblcontact`
--

CREATE TABLE `tblcontact` (
  `CONTID` int(11) NOT NULL,
  `CONT_NAME` varchar(255) DEFAULT NULL,
  `CONT_EMAIL` varchar(255) DEFAULT NULL,
  `CONT_MESSAGE` varchar(255) DEFAULT NULL,
  `CONT_CREATED_AT` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcontact`
--

INSERT INTO `tblcontact` (`CONTID`, `CONT_NAME`, `CONT_EMAIL`, `CONT_MESSAGE`, `CONT_CREATED_AT`, `is_read`) VALUES
(17, 'jenifer', 'rod@gmail.com', 'NICE AND CLEAN ROOM BETTER EXPERINCE.\r\nTHANK YOU FOR YOUR HOTEL AND FOR THE KINDNESS OF THE STAFF.', '2023-11-25 05:57:31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblguest`
--

CREATE TABLE `tblguest` (
  `GUESTID` int(11) NOT NULL,
  `REFNO` int(11) NOT NULL,
  `G_AVATAR` varchar(255) DEFAULT NULL,
  `G_FNAME` varchar(30) NOT NULL,
  `G_LNAME` varchar(255) DEFAULT NULL,
  `G_GENDER` varchar(100) NOT NULL,
  `G_CITY` varchar(90) NOT NULL,
  `G_ADDRESS` varchar(90) NOT NULL,
  `DBIRTH` date NOT NULL,
  `G_PHONE` varchar(20) NOT NULL,
  `G_NATIONALITY` varchar(30) NOT NULL,
  `G_COMPANY` varchar(90) NOT NULL,
  `G_CADDRESS` varchar(90) NOT NULL,
  `G_TERMS` tinyint(4) NOT NULL,
  `G_UNAME` varchar(255) NOT NULL,
  `G_PASS` varchar(255) NOT NULL,
  `ZIP` int(11) NOT NULL,
  `LOCATION` varchar(125) NOT NULL,
  `OTP` varchar(6) NOT NULL,
  `OTP_EXPIRE_AT` datetime DEFAULT NULL,
  `EMAIL_VERIFIED` tinyint(1) DEFAULT 0,
  `VERIFICATION_TOKEN` varchar(255) DEFAULT NULL,
  `session_token` varchar(255) NOT NULL,
  `status` enum('active','logged_out') NOT NULL DEFAULT 'active',
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblguest`
--

INSERT INTO `tblguest` (`GUESTID`, `REFNO`, `G_AVATAR`, `G_FNAME`, `G_LNAME`, `G_GENDER`, `G_CITY`, `G_ADDRESS`, `DBIRTH`, `G_PHONE`, `G_NATIONALITY`, `G_COMPANY`, `G_CADDRESS`, `G_TERMS`, `G_UNAME`, `G_PASS`, `ZIP`, `LOCATION`, `OTP`, `OTP_EXPIRE_AT`, `EMAIL_VERIFIED`, `VERIFICATION_TOKEN`, `session_token`, `status`, `last_activity`) VALUES
(148, 0, 'Screenshot 2024-03-21 203055.png', 'Linux', 'Ungon', 'Male', 'Madridejos', 'Poblacion', '2002-01-02', '09234325553', 'Filipino', 'None', 'None', 1, 'choilovely8@gmail.com', '$2a$12$GKi3Rc0jwybBiLVK2p0OXO.OP6OJlzPxaUgy35MV5nRq4ipxIUdb6', 123123, '', '', '2024-11-04 01:32:37', 0, '766bfd5b13ff736ac97fa7cfde728b1cb7670eb1da05eb979fdf2a4c854d2fc278a3bf95dd92857e5f948755c71b533424d7', '', 'active', '2024-12-09 18:35:08'),
(152, 0, 'Screenshot 2024-11-14 142303.png', 'Asdfasd', 'Asdfad', 'Male', 'Dsfsdfa', 'Adfds', '2002-01-02', '09213233211', 'Asdfaea', 'Asdfa', 'Adfasd', 1, 'ungonkathleen@gmail.com', '$2y$10$KpkRg./bd3uQASBy.QoP3.PlLH9a3cW79iWpN6vviFtQfqjBq8qBC', 1232, '', '', NULL, 0, NULL, '', 'active', '2024-12-09 18:35:08');

-- --------------------------------------------------------

--
-- Table structure for table `tblpayment`
--

CREATE TABLE `tblpayment` (
  `SUMMARYID` int(11) NOT NULL,
  `TRANSDATE` datetime NOT NULL,
  `CONFIRMATIONCODE` varchar(30) NOT NULL,
  `PQTY` int(11) NOT NULL,
  `GUESTID` int(11) NOT NULL,
  `SPRICE` double NOT NULL,
  `MSGVIEW` tinyint(1) NOT NULL,
  `STATUS` varchar(30) NOT NULL,
  `PAYMENT_METHOD` varchar(30) NOT NULL,
  `PAYMENT_STATUS` varchar(50) NOT NULL,
  `AMOUNT_PAID` decimal(10,2) DEFAULT 0.00,
  `BALANCE` decimal(10,2) DEFAULT 0.00,
  `PAID_DATE` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpayment`
--

INSERT INTO `tblpayment` (`SUMMARYID`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `GUESTID`, `SPRICE`, `MSGVIEW`, `STATUS`, `PAYMENT_METHOD`, `PAYMENT_STATUS`, `AMOUNT_PAID`, `BALANCE`, `PAID_DATE`) VALUES
(289, '2024-11-28 06:16:44', 's76yixz8', 1, 152, 1000, 0, 'Pending', 'GCash', '', 500.00, 0.00, NULL),
(290, '2024-11-28 06:18:30', 'yfxogjmb', 1, 152, 1000, 0, 'Pending', 'GCash', '', 500.00, 0.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblreservation`
--

CREATE TABLE `tblreservation` (
  `RESERVEID` int(11) NOT NULL,
  `CONFIRMATIONCODE` varchar(50) NOT NULL,
  `TRANSDATE` date NOT NULL,
  `ROOMID` int(11) NOT NULL,
  `ARRIVAL` datetime NOT NULL,
  `DEPARTURE` datetime NOT NULL,
  `RPRICE` double NOT NULL,
  `NIGHTS` int(20) NOT NULL,
  `GUESTID` int(11) NOT NULL,
  `PRORPOSE` varchar(30) NOT NULL,
  `STATUS` varchar(11) NOT NULL,
  `PAYMENT_STATUS` varchar(20) NOT NULL,
  `PAYMENT_METHOD` varchar(30) NOT NULL,
  `BOOKDATE` datetime NOT NULL,
  `REMARKS` text NOT NULL,
  `USERID` int(11) NOT NULL,
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblreservation`
--

INSERT INTO `tblreservation` (`RESERVEID`, `CONFIRMATIONCODE`, `TRANSDATE`, `ROOMID`, `ARRIVAL`, `DEPARTURE`, `RPRICE`, `NIGHTS`, `GUESTID`, `PRORPOSE`, `STATUS`, `PAYMENT_STATUS`, `PAYMENT_METHOD`, `BOOKDATE`, `REMARKS`, `USERID`, `is_read`) VALUES
(317, 's76yixz8', '2024-11-28', 14, '2024-11-28 00:00:00', '2024-11-28 00:00:00', 1000, 1, 152, 'Travel', 'Pending', '', 'GCash', '0000-00-00 00:00:00', '', 0, 0),
(318, 'yfxogjmb', '2024-11-28', 14, '2024-11-28 00:00:00', '2024-11-28 00:00:00', 1000, 1, 152, 'Travel', 'Pending', '', 'GCash', '0000-00-00 00:00:00', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblroom`
--

CREATE TABLE `tblroom` (
  `ROOMID` int(11) NOT NULL,
  `ROOMNUM` int(11) NOT NULL,
  `ACCOMID` int(11) NOT NULL,
  `ROOM` varchar(30) NOT NULL,
  `ROOMDESC` varchar(255) NOT NULL,
  `NUMPERSON` int(11) NOT NULL,
  `PRICE` double NOT NULL,
  `ROOMIMAGE` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblroom`
--

INSERT INTO `tblroom` (`ROOMID`, `ROOMNUM`, `ACCOMID`, `ROOM`, `ROOMDESC`, `NUMPERSON`, `PRICE`, `ROOMIMAGE`) VALUES
(14, 8, 61, 'RM 102', 'Wing A Without TV', 2, 1000, 'rooms/3.jpg'),
(16, 56, 61, 'RM 103', 'Wing B &amp;amp; Ground Floor With TV', 3, 1000, 'rooms/5.jpg'),
(173, 56, 12, 'Rm345', 'safsfads', 2, 1000, 'rooms/room_673b98f747b650.19252412.webp');

-- --------------------------------------------------------

--
-- Table structure for table `tbluseraccount`
--

CREATE TABLE `tbluseraccount` (
  `USERID` int(11) NOT NULL,
  `UNAME` varchar(30) NOT NULL,
  `USER_NAME` varchar(40) NOT NULL,
  `UPASS` varchar(90) NOT NULL,
  `ROLE` varchar(30) NOT NULL,
  `PHONE` varchar(100) NOT NULL,
  `LOCATION` varchar(255) DEFAULT NULL,
  `EMAIL_VERIFIED` tinyint(1) DEFAULT 0,
  `VERIFICATION_TOKEN` varchar(255) DEFAULT NULL,
  `OTP` varchar(10) DEFAULT NULL,
  `OTP_EXPIRE_AT` datetime DEFAULT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `last_failed_attempt` timestamp NOT NULL DEFAULT current_timestamp(),
  `session_token` varchar(255) NOT NULL,
  `status` enum('active','logged_out') NOT NULL DEFAULT 'active',
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbluseraccount`
--

INSERT INTO `tbluseraccount` (`USERID`, `UNAME`, `USER_NAME`, `UPASS`, `ROLE`, `PHONE`, `LOCATION`, `EMAIL_VERIFIED`, `VERIFICATION_TOKEN`, `OTP`, `OTP_EXPIRE_AT`, `failed_attempts`, `last_failed_attempt`, `session_token`, `status`, `last_activity`) VALUES
(1, 'Ms.Cristy Forrosuelo', 'Cristy@gmail.com', '0778f4add9b65b9b30bda5d2c11fd7053131800b\r\n\r\n', 'Administrator', '09090909099', NULL, 0, NULL, NULL, NULL, 0, '2024-11-23 07:49:18', '', 'active', '2024-12-09 17:38:14'),
(3, 'ADMIN', 'mcchmhotelreservahtion@gmail.c', '$2a$12$XC2t3V8DmpQ5t7DM5Ct8QumasRpnhRbUkCirst9hHGpnSBXMZfXgq', 'Administrator', '09683525733', NULL, 0, NULL, NULL, NULL, 0, '2024-11-23 07:49:18', '', 'active', '2024-12-09 17:38:14'),
(5, 'mr.magic', 'magic@gmail.com', '$2a$12$XC2t3V8DmpQ5t7DM5Ct8QumasRpnhRbUkCirst9hHGpnSBXMZfXgq', 'Guest In-charge', '09090909099', NULL, 0, NULL, NULL, NULL, 0, '2024-11-23 07:49:18', '', 'active', '2024-12-09 17:38:14'),
(7, 'Jake quoe', 'jake@gmail.com', '76569cdd97019401110576e99febe314fc44a4b9', 'Guest In-charge', '09317622381', NULL, 0, NULL, NULL, NULL, 0, '2024-11-23 07:49:18', '', 'active', '2024-12-09 17:38:14'),
(8, 'Admin', 'mcchmhotelreservation@gmail.com', '$2a$12$XC2t3V8DmpQ5t7DM5Ct8QumasRpnhRbUkCirst9hHGpnSBXMZfXgq', 'Administrator', '09317622381', NULL, 0, NULL, NULL, NULL, 0, '2024-11-23 07:49:18', '', 'active', '2024-12-09 17:38:14'),
(12, 'joy', 'joyy@gmail.com', '4a8844277dc9ac1cd77e7ac9931180b3cf789ec1', 'Administrator', '09876543212', NULL, 0, NULL, NULL, NULL, 0, '2024-11-23 07:49:18', '', 'active', '2024-12-09 17:38:14'),
(24, 'Kathleen', 'mcchmhotelreservation@gmail.co', '$2y$10$8tm7fuo4WlQt7RoLz4GdxeOCDKqLLMO8cFDrSysEdgHTMmjlCm8S6', 'Guest In-charge', '12345678900', NULL, 0, NULL, NULL, NULL, 0, '2024-11-23 07:49:18', '', 'active', '2024-12-09 17:38:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_files`
--
ALTER TABLE `chat_files`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `message_id` (`message_id`);

--
-- Indexes for table `livechat`
--
ALTER TABLE `livechat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_id` (`file_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`MESSAGEID`),
  ADD KEY `SENDERID` (`SENDERID`),
  ADD KEY `RECEIVERID` (`RECEIVERID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `otp_verification`
--
ALTER TABLE `otp_verification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `star_ratings`
--
ALTER TABLE `star_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblaccomodation`
--
ALTER TABLE `tblaccomodation`
  ADD PRIMARY KEY (`ACCOMID`);

--
-- Indexes for table `tblamenities`
--
ALTER TABLE `tblamenities`
  ADD PRIMARY KEY (`AMENID`);

--
-- Indexes for table `tblcontact`
--
ALTER TABLE `tblcontact`
  ADD PRIMARY KEY (`CONTID`);

--
-- Indexes for table `tblguest`
--
ALTER TABLE `tblguest`
  ADD PRIMARY KEY (`GUESTID`);

--
-- Indexes for table `tblpayment`
--
ALTER TABLE `tblpayment`
  ADD PRIMARY KEY (`SUMMARYID`),
  ADD UNIQUE KEY `CONFIRMATIONCODE` (`CONFIRMATIONCODE`),
  ADD KEY `GUESTID` (`GUESTID`);

--
-- Indexes for table `tblreservation`
--
ALTER TABLE `tblreservation`
  ADD PRIMARY KEY (`RESERVEID`),
  ADD KEY `ROOMID` (`ROOMID`),
  ADD KEY `GUESTID` (`GUESTID`),
  ADD KEY `CONFIRMATIONCODE` (`CONFIRMATIONCODE`);

--
-- Indexes for table `tblroom`
--
ALTER TABLE `tblroom`
  ADD PRIMARY KEY (`ROOMID`),
  ADD KEY `ACCOMID` (`ACCOMID`);

--
-- Indexes for table `tbluseraccount`
--
ALTER TABLE `tbluseraccount`
  ADD PRIMARY KEY (`USERID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `livechat`
--
ALTER TABLE `livechat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `MESSAGEID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `otp_verification`
--
ALTER TABLE `otp_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `star_ratings`
--
ALTER TABLE `star_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tblaccomodation`
--
ALTER TABLE `tblaccomodation`
  MODIFY `ACCOMID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `tblamenities`
--
ALTER TABLE `tblamenities`
  MODIFY `AMENID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcontact`
--
ALTER TABLE `tblcontact`
  MODIFY `CONTID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tblguest`
--
ALTER TABLE `tblguest`
  MODIFY `GUESTID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `tblpayment`
--
ALTER TABLE `tblpayment`
  MODIFY `SUMMARYID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;

--
-- AUTO_INCREMENT for table `tblreservation`
--
ALTER TABLE `tblreservation`
  MODIFY `RESERVEID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=319;

--
-- AUTO_INCREMENT for table `tblroom`
--
ALTER TABLE `tblroom`
  MODIFY `ROOMID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `tbluseraccount`
--
ALTER TABLE `tbluseraccount`
  MODIFY `USERID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat_files`
--
ALTER TABLE `chat_files`
  ADD CONSTRAINT `chat_files_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `livechat` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `livechat`
--
ALTER TABLE `livechat`
  ADD CONSTRAINT `livechat_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `chat_files` (`file_id`) ON DELETE SET NULL;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`SENDERID`) REFERENCES `tbluseraccount` (`USERID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`SENDERID`) REFERENCES `tblguest` (`GUESTID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`RECEIVERID`) REFERENCES `tbluseraccount` (`USERID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_4` FOREIGN KEY (`RECEIVERID`) REFERENCES `tblguest` (`GUESTID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblreservation`
--
ALTER TABLE `tblreservation`
  ADD CONSTRAINT `tblreservation_ibfk_1` FOREIGN KEY (`ROOMID`) REFERENCES `tblroom` (`ROOMID`),
  ADD CONSTRAINT `tblreservation_ibfk_2` FOREIGN KEY (`GUESTID`) REFERENCES `tblguest` (`GUESTID`);

--
-- Constraints for table `tblroom`
--
ALTER TABLE `tblroom`
  ADD CONSTRAINT `tblroom_ibfk_1` FOREIGN KEY (`ACCOMID`) REFERENCES `tblaccomodation` (`ACCOMID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
