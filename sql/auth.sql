-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2014 at 05:17 AM
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
  PRIMARY KEY (`authId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`authId`, `diverId`, `coachId`, `password`, `GUID`, `active`) VALUES
(1, 189, -1, '@=77;3Z4=JW4', 'B9F295E3-9CF2-4ADA-A3B3-4C7164026F52', b'1'),
(2, 191, -1, '', '1C33BB01-DB84-4C8B-8222-B9098ED70455', b'1'),
(3, -1, 1000, '@=77;3Z4=JW4', 'B9F295E3-9CF2-4ADA-A3B3-4C7164026F51', b'1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
