-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2023 at 05:09 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.27

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
(12, 'Standard Room', 'max 22hrs.'),
(13, 'Travelers Time', 'max of 12hrs.'),
(17, 'Bayanihan', 'max.12hrs'),
(23, 'test', 'test'),
(24, 'test', 'test');

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
  `CONT_CREATED_AT` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcontact`
--

INSERT INTO `tblcontact` (`CONTID`, `CONT_NAME`, `CONT_EMAIL`, `CONT_MESSAGE`, `CONT_CREATED_AT`) VALUES
(7, 'Sample 1', 'customer@example.com', 'Gwapo ako. Kay ako gud ni!!', '2023-08-15 12:15:56'),
(8, 'Mark', 'magic@gmail.com', 'laban lng alaxan', '2023-10-12 12:06:51'),
(9, 'Mark', 'magic@gmail.com', 'laban lng alaxan', '2023-10-12 12:08:25'),
(10, 'rhea bacolod', 'rhea@gmail.com', 'can you please cancelled my booking for some reason i did not come for what i have been done sorry for convenience.', '2023-10-17 09:38:32'),
(11, 'rodel ', 'magic@gmail.com', 'it ia nice PLACE', '2023-11-18 09:06:36'),
(12, 'gemu', 'jupril@gmail.com', 'good', '2023-11-21 11:43:50'),
(13, 'gemu', 'jupril@gmail.com', 'good', '2023-11-21 12:00:29'),
(14, 'gemu', 'jupril@gmail.com', 'good', '2023-11-21 12:00:56'),
(15, 'gemu', 'jupril@gmail.com', 'good', '2023-11-21 12:02:43'),
(16, 'Rodel', 'magic@gmail.com', 'dhhc', '2023-11-21 12:16:26'),
(17, 'jenifer', 'rod@gmail.com', 'NICE AND CLEAN ROOM BETTER EXPERINCE.\r\nTHANK YOU FOR YOUR HOTEL AND FOR THE KINDNESS OF THE STAFF.', '2023-11-25 05:57:31'),
(18, 'jenifer', 'rod@gmail.com', 'NICE AND CLEAN ROOM BETTER EXPERINCE.\r\nTHANK YOU FOR YOUR HOTEL AND FOR THE KINDNESS OF THE STAFF.', '2023-11-25 06:01:29'),
(19, 'rebicca', 'cristy@gmail.com', 'NICE', '2023-11-25 06:27:38'),
(20, 'rebicca', 'cristy@gmail.com', 'NICE', '2023-11-25 06:28:37'),
(21, 'rebicca', 'cristy@gmail.com', 'NICE', '2023-11-25 06:28:51');

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
  `LOCATION` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblguest`
--

INSERT INTO `tblguest` (`GUESTID`, `REFNO`, `G_AVATAR`, `G_FNAME`, `G_LNAME`, `G_GENDER`, `G_CITY`, `G_ADDRESS`, `DBIRTH`, `G_PHONE`, `G_NATIONALITY`, `G_COMPANY`, `G_CADDRESS`, `G_TERMS`, `G_UNAME`, `G_PASS`, `ZIP`, `LOCATION`) VALUES
(119, 0, '361713748_1320721818880950_7525028163040864305_n.jpg', 'Rodel ', 'Bacolod', '', 'Cebu', 'Madridejos', '2000-11-20', '09876543212', 'Filipino', 'None', 'None', 1, 'rodskie@123', '961e314744602f2fd7804e54a98d98f42e9f003c', 6053, ''),
(120, 0, '377108539_842157074172798_7412385795172135075_n.jpg', 'Mark', 'Despi', '', 'Cebu', 'Madridejos', '2004-03-16', '09876543212', 'Filipino', 'None', 'None', 1, 'Mark@123', 'fb1fd3379d9e9dc7936b16be1a6605cbe794ced1', 6053, ''),
(121, 0, '377105091_1015888549830606_6501154337235931340_n.jpg', 'Asdsa', 'Asd', 'male', 'Sad', 'Sdas', '2005-10-13', '09999999999', 'Asasasd', 'Asd', 'Asd', 1, 'try@gmail.com', 'b240628a389481ccb16bda201e5a733e3ea1f143', 233, ''),
(122, 0, '361713748_1320721818880950_7525028163040864305_n (1).jpg', 'Rhea', 'Bacolod', '', 'Cebu', 'Madridejos', '1992-06-19', '09071417749', 'Filipino', 'None', 'None', 1, 'Rhea@123', 'aaef15544fca3f1a0b298277e18d09d562d0bac1', 6053, ''),
(123, 0, 'admin.png', 'Justin', 'Vasquez', '', 'Cebu', 'Madridejos', '2005-08-20', '09071417749', 'Filipino', 'None', 'None', 1, 'justin@gmail.com', 'e7ca4d0645e1937580b1aa6735670224834bffad', 6053, ''),
(124, 0, 'logo2.jpg', 'Jerald', 'Anderson', '', 'Cebu', 'Madridejos', '1999-07-06', '09642512342', 'Filipino', 'None', 'None', 1, 'jerald@gmail.com', '119cd497a304089fae399570164e284d095c00c2', 6053, ''),
(125, 0, 'Screenshot 2023-04-30 222641.png', 'Loy', 'Dong', '', 'Cebu', 'Madridejos', '2001-03-03', '09764152317', 'Filipino', 'None', 'None', 1, 'rodelbacolod21@gmail.com', 'dab780121412c3438bb60308db98eb7f0dc1bdda', 6053, ''),
(126, 0, 'RAD1.jpg', 'Boy', 'Abonda', '', 'Cebu', 'Madridejos', '1996-06-13', '09764152317', 'Filipino', 'Parot', 'Bulkitan', 1, 'boy@gmail.com', '35c16313295369d2ebaf08454eca7b9a681eb847', 6053, ''),
(127, 0, 'Screenshot 2023-07-22 204346.png', 'Loy', 'Dong', '', 'Cebu', 'Madridejos', '2000-11-16', '09642512342', 'Filipino', 'None', 'Bulkitan', 1, 'loy@gmail.com', 'c6f56e56dc7aa36f08bb8a6dbfce22673c4ebad5', 6052, ''),
(128, 0, 'Screenshot 2023-04-30 222641.png', 'Loy', 'Dong', 'Male', 'Cebu', 'Madridejos', '2005-11-03', '09642512342', 'Filipino', 'Parot', 'Bulkitan', 1, 'bacolodrodel01@gmail.com', '7c193e6c090b2574ab16837d7ec0bb6ecf9af792', 5969, ''),
(129, 0, 'logo2.jpg', 'Lupog', 'Abonda', '', 'Cebu', 'Madridejos', '2005-11-01', '09554123123', 'Filipino', 'None', 'Bulkitan', 1, 'loy@gmail.com', 'b01f283975f34a2b282414e5fee6aa44d5a22fd8', 6053, ''),
(130, 0, 'CONTEXT FLOW DIAGRAM.png', 'Jenelyn', 'Dong', 'fMale', 'Cebu', 'Madridejos', '2002-06-07', '09764152317', 'Filipino', 'Parot', 'None', 1, 'rodelbacolod21@gmail.com', 'a22efb9abd2ad28e6116b987c15913b9de1ac9ea', 2234, ''),
(131, 0, 'RAD1.jpg', 'Loy', 'Angelo', '', 'Cebu', 'Madridejos', '2001-01-02', '09658907513', 'Filipino', 'Parot', 'Bulkitan', 1, 'angelo@gmail.com', '35544277eb982f0b67fa2b8c35732732c30216a9', 6053, ''),
(132, 0, 'Screenshot 2023-04-30 222641.png', 'ACE', 'Ochia', 'Male', 'Cebu', 'Madridejos', '2005-11-02', '09554123123', 'Filipino', 'Parot', 'Bulkitan', 1, 'loy@gmail.com', '7c193e6c090b2574ab16837d7ec0bb6ecf9af792', 6053, ''),
(133, 0, 'Screenshot 2023-04-30 222641.png', 'Angelo', 'Tiburcio', 'Male', 'Cebu', 'Madridejos', '2001-01-25', '09642512342', 'Filipino', 'None', 'Bulkitan', 1, 'loy@gmail.com', 'f0054b495655fd0d662e43d2bd1b2a039bc8e1ed', 6053, ''),
(134, 0, 'logo2.jpg', 'Rebicca', 'Anderson', 'Female', 'Cebu', 'Madridejos', '1996-01-07', '09642512342', 'Filipino', 'None', 'Bulacan', 1, 'user@gmail.com', '7c193e6c090b2574ab16837d7ec0bb6ecf9af792', 2147483647, ''),
(135, 0, 'entity-relation diagram.png', 'Naldo', 'Ochia', 'Male', 'Cebu', 'Madridejos', '2001-02-07', '09658907513', 'Filipino', 'None', 'Bulacan', 1, 'bacolodrodel01@gmail.com', '35544277eb982f0b67fa2b8c35732732c30216a9', 1223, ''),
(136, 0, 'Screenshot 2023-04-30 222641.png', 'Jupril', 'Alegre', 'Male', 'Cebu', 'Poblacio', '2005-11-02', '09876543212', 'Filipino', 'None', 'Poblacion mad cebu', 1, 'jupril@gmail.com', '878e24e628294f376f281b7bfe63f029cb2e2b9c', 1234, 'guest/photos/avatar5.png'),
(137, 0, 'IMG20210107133304 - Copy.jpg', 'LO', 'CDDS', 'SSA', 'DADA', 'SWQ', '2005-11-01', '09876543212', 'Filipino', 'None', 'Poblacion mad cebu', 1, 'cristy@gmail.com', '878e24e628294f376f281b7bfe63f029cb2e2b9c', 1234, ''),
(138, 0, '361713748_1320721818880950_7525028163040864305_n (1).jpg', 'Loy', 'Anderson', 'Male', 'Cebu', 'Madridejos', '1995-07-25', '09654123421', 'Filipino', 'None', 'None', 1, 'rodelbacolod21@gmail.com', 'dd24f5cc538d15bdd32825c9c4fc66eff702e7a0', 6053, '');

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
  `STATUS` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpayment`
--

INSERT INTO `tblpayment` (`SUMMARYID`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `GUESTID`, `SPRICE`, `MSGVIEW`, `STATUS`) VALUES
(70, '2023-10-11 11:56:54', '003p4gx5', 1, 119, 845, 0, 'Checkedout'),
(71, '2023-10-12 12:03:14', 'x272ds2u', 1, 120, 725, 0, 'Checkedin'),
(72, '2023-10-12 12:05:43', 'xbyvm0ia', 1, 120, 123, 0, 'Confirmed'),
(74, '2023-10-13 06:34:51', 'n6nbxzsa', 1, 121, 725, 0, 'Checkedin'),
(75, '2023-10-17 09:28:57', '4pyixhjn', 1, 122, 1650, 0, 'Confirmed'),
(76, '2023-11-04 02:24:17', 'fna7ahu6', 1, 123, 1200, 0, 'Checkedin'),
(77, '2023-11-06 08:19:53', 'rdw34mic', 1, 124, 2000, 0, 'Confirmed'),
(78, '2023-11-06 10:20:59', '2g8i24cw', 1, 125, 1000, 0, 'Confirmed'),
(79, '2023-11-06 10:46:57', 'ef4kb4gh', 1, 126, 1000, 0, 'Pending'),
(80, '2023-11-06 11:27:00', 'qp4nvmwk', 1, 126, 1200, 0, 'Confirmed'),
(81, '2023-11-07 07:40:18', 'ty0weqkq', 1, 127, 2400, 0, 'Confirmed'),
(82, '2023-11-07 07:42:06', 'sbixc5jn', 1, 127, 3000, 0, 'Cancelled'),
(83, '2023-11-07 08:50:13', '65zuipvc', 1, 128, 2400, 0, 'Cancelled'),
(84, '2023-11-07 09:05:34', 'h70ei5jc', 1, 129, 2000, 0, 'Confirmed'),
(85, '2023-11-07 09:10:43', 'mjeafmcg', 1, 130, 2600, 0, 'Checkedout'),
(86, '2023-11-07 09:23:58', 'ffvhsuo8', 1, 131, 2000, 0, 'Confirmed'),
(87, '2023-11-07 09:44:44', 'id6paeni', 1, 132, 2000, 0, 'Cancelled'),
(88, '2023-11-07 09:57:49', 'zfszswap', 1, 133, 2600, 0, 'Cancelled'),
(89, '2023-11-07 10:40:33', '8mybcgc5', 1, 134, 2600, 0, 'Checkedout'),
(90, '2023-11-07 10:46:51', '7zjobcdv', 1, 135, 2600, 0, 'Confirmed'),
(91, '2023-11-19 06:42:43', 'gutxo828', 1, 136, 2400, 0, 'Checkedout'),
(92, '2023-11-19 09:44:41', 'ib4t6op6', 1, 136, 1300, 0, 'Pending'),
(93, '2023-11-21 09:24:54', '5xnonu50', 1, 136, 1500, 0, 'Confirmed'),
(94, '2023-11-21 10:55:07', 'mu4aageo', 1, 136, 1200, 0, 'Pending'),
(95, '2023-11-21 01:46:39', 'jvzif37e', 1, 136, 1500, 0, 'Pending'),
(96, '2023-11-22 11:09:21', 'p60oim42', 1, 137, 1430, 0, 'Pending'),
(97, '2023-11-23 04:11:48', 'fdzhfhnr', 1, 136, 1000, 0, 'Confirmed'),
(98, '2023-11-25 03:41:04', '04idyh8r', 1, 138, 1200, 0, 'Pending'),
(99, '2023-11-25 04:25:57', 'mq4r8raw', 1, 138, 1500, 0, 'Pending');

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
  `GUESTID` int(11) NOT NULL,
  `PRORPOSE` varchar(30) NOT NULL,
  `STATUS` varchar(11) NOT NULL,
  `BOOKDATE` datetime NOT NULL,
  `REMARKS` text NOT NULL,
  `USERID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblreservation`
--

INSERT INTO `tblreservation` (`RESERVEID`, `CONFIRMATIONCODE`, `TRANSDATE`, `ROOMID`, `ARRIVAL`, `DEPARTURE`, `RPRICE`, `GUESTID`, `PRORPOSE`, `STATUS`, `BOOKDATE`, `REMARKS`, `USERID`) VALUES
(57, '003p4gx5', '2023-10-11', 20, '2023-10-14 00:00:00', '2023-10-15 00:00:00', 845, 119, 'Travel', 'Checkedout', '0000-00-00 00:00:00', '', 0),
(58, 'x272ds2u', '2023-10-12', 12, '2023-10-12 00:00:00', '2023-10-12 00:00:00', 725, 120, 'Travel', 'Checkedin', '0000-00-00 00:00:00', '', 0),
(59, 'xbyvm0ia', '2023-10-12', 28, '2023-10-14 00:00:00', '2023-10-15 00:00:00', 123, 120, 'Travel', 'Confirmed', '0000-00-00 00:00:00', '', 0),
(61, 'n6nbxzsa', '2023-10-13', 12, '2023-10-13 00:00:00', '2023-10-13 00:00:00', 725, 121, 'Travel', 'Checkedin', '0000-00-00 00:00:00', '', 0),
(62, '4pyixhjn', '2023-10-17', 24, '2023-10-18 00:00:00', '2023-10-19 00:00:00', 1650, 122, 'Travel', 'Confirmed', '0000-00-00 00:00:00', '', 0),
(63, 'fna7ahu6', '2023-11-04', 19, '2023-11-06 00:00:00', '2023-11-07 00:00:00', 1200, 123, 'Travel', 'Checkedin', '0000-00-00 00:00:00', '', 0),
(64, 'rdw34mic', '2023-11-06', 12, '2023-11-07 00:00:00', '2023-11-09 00:00:00', 2000, 124, 'Travel', 'Confirmed', '0000-00-00 00:00:00', '', 0),
(65, '2g8i24cw', '2023-11-06', 12, '2023-11-06 00:00:00', '2023-11-06 00:00:00', 1000, 125, 'Travel', 'Confirmed', '0000-00-00 00:00:00', '', 0),
(66, 'ef4kb4gh', '2023-11-06', 12, '2023-11-06 00:00:00', '2023-11-06 00:00:00', 1000, 126, 'Travel', 'Pending', '0000-00-00 00:00:00', '', 0),
(67, 'qp4nvmwk', '2023-11-06', 14, '2023-11-06 00:00:00', '2023-11-06 00:00:00', 1200, 126, 'Travel', 'Confirmed', '0000-00-00 00:00:00', '', 0),
(68, 'ty0weqkq', '2023-11-07', 14, '2023-11-07 00:00:00', '2023-11-09 00:00:00', 2400, 127, 'Travel', 'Confirmed', '0000-00-00 00:00:00', '', 0),
(69, 'sbixc5jn', '2023-11-07', 28, '2023-11-07 00:00:00', '2023-11-09 00:00:00', 3000, 127, 'Travel', 'Cancelled', '0000-00-00 00:00:00', '', 0),
(70, '65zuipvc', '2023-11-07', 14, '2023-11-07 00:00:00', '2023-11-09 00:00:00', 2400, 128, 'Travel', 'Cancelled', '0000-00-00 00:00:00', '', 0),
(71, 'h70ei5jc', '2023-11-07', 12, '2023-11-07 00:00:00', '2023-11-09 00:00:00', 2000, 129, 'Travel', 'Confirmed', '0000-00-00 00:00:00', '', 0),
(72, 'mjeafmcg', '2023-11-07', 16, '2023-11-07 00:00:00', '2023-11-09 00:00:00', 2600, 130, 'Travel', 'Checkedout', '0000-00-00 00:00:00', '', 0),
(73, 'ffvhsuo8', '2023-11-07', 12, '2023-11-07 00:00:00', '2023-11-09 00:00:00', 2000, 131, 'Travel', 'Confirmed', '0000-00-00 00:00:00', '', 0),
(74, 'id6paeni', '2023-11-07', 12, '2023-11-07 00:00:00', '2023-11-09 00:00:00', 2000, 132, 'Travel', 'Cancelled', '0000-00-00 00:00:00', '', 0),
(75, 'zfszswap', '2023-11-07', 16, '2023-11-07 00:00:00', '2023-11-09 00:00:00', 2600, 133, 'Travel', 'Cancelled', '0000-00-00 00:00:00', '', 0),
(76, '8mybcgc5', '2023-11-07', 16, '2023-11-07 00:00:00', '2023-11-09 00:00:00', 2600, 134, 'Travel', 'Checkedout', '0000-00-00 00:00:00', '', 0),
(77, '7zjobcdv', '2023-11-07', 16, '2023-11-07 00:00:00', '2023-11-09 00:00:00', 2600, 135, 'Travel', 'Confirmed', '0000-00-00 00:00:00', '', 0),
(78, 'gutxo828', '2023-11-19', 14, '2023-11-20 00:00:00', '2023-11-22 00:00:00', 2400, 136, 'Travel', 'Checkedout', '0000-00-00 00:00:00', '', 0),
(79, 'ib4t6op6', '2023-11-19', 24, '2023-11-19 00:00:00', '2023-11-19 00:00:00', 1300, 136, 'Travel', 'Pending', '0000-00-00 00:00:00', '', 0),
(80, '5xnonu50', '2023-11-21', 28, '2023-11-21 00:00:00', '2023-11-21 00:00:00', 1500, 136, 'Travel', 'Confirmed', '0000-00-00 00:00:00', '', 0),
(81, 'mu4aageo', '2023-11-21', 21, '2023-11-21 00:00:00', '2023-11-21 00:00:00', 1200, 136, 'Travel', 'Pending', '0000-00-00 00:00:00', '', 0),
(82, 'jvzif37e', '2023-11-21', 28, '2023-11-21 00:00:00', '2023-11-21 00:00:00', 1500, 136, 'Travel', 'Pending', '0000-00-00 00:00:00', '', 0),
(83, 'p60oim42', '2023-11-22', 25, '2023-11-22 00:00:00', '2023-11-22 00:00:00', 1430, 137, 'Travel', 'Pending', '0000-00-00 00:00:00', '', 0),
(84, 'fdzhfhnr', '2023-11-23', 12, '2023-11-23 00:00:00', '2023-11-23 00:00:00', 1000, 136, 'Travel', 'Confirmed', '0000-00-00 00:00:00', '', 0),
(85, '04idyh8r', '2023-11-25', 21, '2023-11-26 00:00:00', '2023-11-27 00:00:00', 1200, 138, 'Travel', 'Pending', '0000-00-00 00:00:00', '', 0),
(86, 'mq4r8raw', '2023-11-25', 28, '2023-11-26 00:00:00', '2023-11-27 00:00:00', 1500, 138, 'Travel', 'Pending', '0000-00-00 00:00:00', '', 0);

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
(12, 1, 12, 'RM 101', 'Wing A Without TV', 1, 1000, 'rooms/3page-img13.jpg'),
(14, 1, 13, 'RM 102', 'Wing A Without TV', 2, 1200, 'rooms/3.jpg'),
(16, 7, 12, 'RM 103', 'Wing B & Ground Floor With TV', 3, 1300, 'rooms/5.jpg'),
(17, 3, 12, 'RM 104', 'Wing B & Ground Floor With TV', 4, 1650, 'rooms/4.jpg'),
(19, 3, 13, 'RM 105', 'Wing B & Ground Floor Without TV', 5, 1200, 'rooms/th.jfif'),
(20, 5, 12, 'RM 201', 'Wing B  Twin Beds with TV', 6, 1300, 'rooms/th (1).jfif'),
(21, 2, 13, 'RM 202', 'Wing B Barkada8  with TV', 7, 1200, 'rooms/th (2).jfif'),
(24, 3, 17, 'RM 203', '2 Beds with TV & Hot and Cold Shower', 8, 1300, 'rooms/th (4).jfif'),
(25, 4, 13, 'RM 203', 'Family room with TV & Hot and Cold Shower', 9, 1430, 'rooms/th.jfif'),
(26, 4, 12, 'RM 204', '3 double & single bed with Hot and Cold Shower', 10, 1350, 'rooms/jacuzzi-room.jpg'),
(27, 3, 13, 'RM 205', '1 double & single bed with Hot and Cold Shower', 3, 1100, 'rooms/2queens-room-320x270.jpg'),
(28, 1, 17, 'RM 206', 'Family Room With TV and Aircon ', 8, 1500, 'rooms/th (6).jfif');

-- --------------------------------------------------------

--
-- Table structure for table `tbluseraccount`
--

CREATE TABLE `tbluseraccount` (
  `USERID` int(11) NOT NULL,
  `UNAME` varchar(30) NOT NULL,
  `USER_NAME` varchar(30) NOT NULL,
  `UPASS` varchar(90) NOT NULL,
  `ROLE` varchar(30) NOT NULL,
  `PHONE` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbluseraccount`
--

INSERT INTO `tbluseraccount` (`USERID`, `UNAME`, `USER_NAME`, `UPASS`, `ROLE`, `PHONE`) VALUES
(1, 'Ms.Cristy Forrosuelo', 'Cristy@gmail.com', 'c08be12c1e5cca0928e9f332fa23374989cac47f', 'Administrator', '09090909099'),
(3, 'John Wick', 'admin1@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Administrator', '09683525733'),
(5, 'mr.magic', 'magic@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Guest In-charge', '09090909099'),
(7, 'Jake quoe', 'jake@gmail.com', '76569cdd97019401110576e99febe314fc44a4b9', 'Guest In-charge', '09317622381'),
(8, 'hidden', 'hidden@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Guest In-charge', '09317622381');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `tblaccomodation`
--
ALTER TABLE `tblaccomodation`
  MODIFY `ACCOMID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  MODIFY `GUESTID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `tblpayment`
--
ALTER TABLE `tblpayment`
  MODIFY `SUMMARYID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `tblreservation`
--
ALTER TABLE `tblreservation`
  MODIFY `RESERVEID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `tblroom`
--
ALTER TABLE `tblroom`
  MODIFY `ROOMID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tbluseraccount`
--
ALTER TABLE `tbluseraccount`
  MODIFY `USERID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

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
