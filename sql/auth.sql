-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2015 at 07:09 AM
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
-- Table structure for table `auth`
--

CREATE TABLE IF NOT EXISTS `auth` (
  `authId` int(11) NOT NULL AUTO_INCREMENT,
  `diverId` int(11) NOT NULL,
  `coachId` int(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `GUID` varchar(36) NOT NULL,
  `active` bit(1) NOT NULL,
  `isSuperAdmin` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`authId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`authId`, `diverId`, `coachId`, `password`, `GUID`, `active`, `isSuperAdmin`) VALUES
(1, 189, -1, '@=77;3Z4=JW4', 'B9F295E3-9CF2-4ADA-A3B3-4C7164026F52', b'1', b'0'),
(2, 191, -1, '', '1C33BB01-DB84-4C8B-8222-B9098ED70455', b'1', b'0'),
(3, -1, 1000, '@=77;3Z4=JW4', 'B9F295E3-9CF2-4ADA-A3B3-4C7164026F51', b'1', b'0'),
(5, 342, -1, ';A=7A<J[0JNN', '6AC7E695-BC1E-4E4E-82B3-E23727CF7BF4', b'1', b'0'),
(6, 343, -1, ';A=7A<J[0JNN', '3949E201-450A-4776-9DC8-9A377E2E6F01', b'0', b'0'),
(7, 344, -1, ';A=7A<J[0JNN', '31BA6B7E-4E6D-465A-A8C3-436E9DBC5DB5', b'1', b'0'),
(8, 349, -1, ';A=7A<J[0JNN', '67BC251D-243A-4795-99B5-BB7291CCC988', b'1', b'0'),
(9, 350, -1, ';A=7A<J[0JNN', '709930A3-3676-46C1-AC37-1ABD56E7FB8A', b'1', b'0'),
(10, -1, 3566742, 'DE^EV[=0]', '935B08F3-1353-4534-B970-21C6A01EDB45', b'1', b'1'),
(12, -1, 123456, 'KA=7A<J[0JNNJ', '77897F79-B80A-4A04-95E1-CE682DBDEC34', b'1', b'0'),
(13, 351, -1, '@=77;3Z4=JW4', 'E97BECBB-567E-4067-B062-51D6F7998745', b'0', b'0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
