-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2014 at 01:40 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dive_trainer`
--

-- --------------------------------------------------------

--
-- Table structure for table `divers`
--

CREATE TABLE IF NOT EXISTS `divers` (
  `diverId` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `coachId` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `address1` varchar(200) NOT NULL,
  `address2` varchar(200) NOT NULL,
  `zip` varchar(5) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  PRIMARY KEY (`diverId`),
  FULLTEXT KEY `fname` (`fname`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=350 ;

--
-- Dumping data for table `divers`
--

INSERT INTO `divers` (`diverId`, `fname`, `lname`, `coachId`, `level`, `address1`, `address2`, `zip`, `phone`, `email`, `dob`) VALUES
(292, 'Aaron', 'Aardvark', 1000, 2, '12 White Alder Elephant', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(293, 'Aaron', 'Pie', 1000, 5, '212 Loden Lane', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(294, 'Aaron', 'Smith', 1000, 5, '12 White Alder Elephant', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(295, 'Aaron', 'Johnson', 1000, 4, '212 Loden Lane', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(296, 'Aaron', 'Johns', 1000, 4, '34 Gibson Lane', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(297, 'Aaron', 'Mans', 1000, 5, '34 Gibson Lane', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(298, 'Aaron', 'Rabb', 1000, 2, '12 White Alder Elephant', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(299, 'Aaron', 'Bynoe', 1000, 1, '34 Gibson Lane', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(300, 'Aaron', 'Alquhist', 1000, 3, '34 Tannon Drive South', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(301, 'Aaron', 'McMahon', 1000, 3, '34 Gibson Lane', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(302, 'Apple', 'Aardvark', 1000, 4, '34 Tannon Drive South', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(303, 'Apple', 'Pie', 1000, 1, '34 Tannon Drive South', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(304, 'Apple', 'Smith', 1000, 1, '34 Tannon Drive South', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(305, 'Apple', 'Johnson', 1000, 3, '34 Tannon Drive South', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(306, 'Apple', 'Johns', 1000, 4, '12 White Alder Elephant', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(307, 'Apple', 'Mans', 1000, 5, '34 Gibson Lane', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(308, 'Apple', 'Rabb', 1000, 4, '212 Loden Lane', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(309, 'Apple', 'Bynoe', 1000, 2, '34 Tannon Drive South', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(310, 'Apple', 'Alquhist', 1000, 5, '34 Tannon Drive South', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(311, 'Apple', 'McMahon', 1000, 3, '34 Gibson Lane', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(312, 'James', 'Aardvark', 1000, 4, '34 Gibson Lane', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(313, 'James', 'Pie', 1000, 2, '12 White Alder Elephant', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(314, 'James', 'Smith', 1000, 4, '34 Gibson Lane', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(315, 'James', 'Johnson', 1000, 2, '34 Gibson Lane', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(316, 'James', 'Johns', 1000, 1, '212 Loden Lane', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(317, 'James', 'Mans', 1000, 4, '34 Gibson Lane', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(318, 'James', 'Rabb', 1000, 5, '34 Tannon Drive South', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(319, 'James', 'Bynoe', 1000, 4, '12 White Alder Elephant', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(320, 'James', 'Alquhist', 1000, 2, '12 White Alder Elephant', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(321, 'James', 'McMahon', 1000, 3, '34 Gibson Lane', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(322, 'Calvin', 'Aardvark', 1000, 1, '12 White Alder Elephant', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(323, 'Calvin', 'Pie', 1000, 4, '34 Gibson Lane', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(324, 'Calvin', 'Smith', 1000, 4, '212 Loden Lane', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(325, 'Calvin', 'Johnson', 1000, 2, '34 Tannon Drive South', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(326, 'Calvin', 'Johns', 1000, 3, '12 White Alder Elephant', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(327, 'Calvin', 'Mans', 1000, 4, '212 Loden Lane', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(328, 'Calvin', 'Rabb', 1000, 1, '34 Tannon Drive South', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(329, 'Calvin', 'Bynoe', 1000, 1, '12 White Alder Elephant', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(330, 'Calvin', 'Alquhist', 1000, 2, '212 Loden Lane', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(331, 'Calvin', 'McMahon', 1000, 5, '34 Gibson Lane', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(332, 'Earl', 'Aardvark', 1000, 2, '34 Gibson Lane', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(333, 'Earl', 'Pie', 1000, 2, '34 Gibson Lane', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(334, 'Earl', 'Smith', 1000, 4, '212 Loden Lane', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(335, 'Earl', 'Johnson', 1000, 4, '34 Tannon Drive South', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(336, 'Earl', 'Johns', 1000, 1, '212 Loden Lane', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(337, 'Earl', 'Mans', 1000, 1, '34 Gibson Lane', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(338, 'Earl', 'Rabb', 1000, 5, '12 White Alder Elephant', 'Henrietta', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(339, 'Earl', 'Bynoe', 1000, 5, '34 Tannon Drive South', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(340, 'Earl', 'Alquhist', 1000, 5, '212 Loden Lane', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(341, 'Earl', 'McMahon', 1000, 3, '34 Tannon Drive South', 'Rochester', '14623', '555-555-55', 'notareal@email.com', '0000-00-00'),
(342, 'Nick', 'Rabb', 1000, 0, '', '', '', '', '', '0000-00-00'),
(343, 'Nicholas', 'Rabb', 1000, 0, '', '', '', '', '', '0000-00-00'),
(344, 'Colleen', 'McMahon', 1000, 0, '', '', '', '', '', '0000-00-00'),
(345, 'Rick', 'Nabb', 1000, 0, '', '', '', '', 'nrabb@outlook.com', '0000-00-00'),
(346, 'Rick', 'Nabb', 1000, 0, '', '', '', '', 'nrabb@outlook.com', '0000-00-00'),
(348, 'Rick', 'Nabb', 1000, 0, '', '', '', '', 'nrabb@outlook.com', '0000-00-00'),
(349, 'Rick', 'Nabb', 1000, 0, '', '', '', '', 'nrabb@outlook.com', '0000-00-00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
