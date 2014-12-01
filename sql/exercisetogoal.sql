-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2014 at 09:35 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

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
-- Table structure for table `exercisetogoal`
--

CREATE TABLE IF NOT EXISTS `exercisetogoal` (
  `exerciseId` int(11) NOT NULL,
  `goalId` int(11) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exercisetogoal`
--

INSERT INTO `exercisetogoal` (`exerciseId`, `goalId`, `rating`) VALUES
(7, 1, 3),
(10, 1, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exercisetogoal`
--
ALTER TABLE `exercisetogoal`
 ADD PRIMARY KEY (`exerciseId`,`goalId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
