-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2014 at 04:06 PM
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
-- Table structure for table `skills`
--

CREATE TABLE IF NOT EXISTS `skills` (
  `skillId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `level` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  PRIMARY KEY (`skillId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`skillId`, `name`, `level`, `description`) VALUES
(1, 'Jumprope', 1, 'This is the description for Jumprope at level 1'),
(2, 'Jumprope', 2, 'This is the description for Jumprope at level 2'),
(3, 'Jumprope', 3, 'This is the description for Jumprope at level 3'),
(4, 'Armcircles', 1, 'This is the description for Armcircles at level 1'),
(5, 'Armcircles', 2, 'This is the description for Armcircles at level 2'),
(6, 'Armcircles', 3, 'This is the description for Armcircles at level 3'),
(7, 'Pike jumps on Dryboard', 1, 'This is the description for Pike jumps on Dryboard at level 1'),
(8, 'Pike jumps on Dryboard', 2, 'This is the description for Pike jumps on Dryboard at level 2'),
(9, 'Pike jumps on Dryboard', 3, 'This is the description for Pike jumps on Dryboard at level 3'),
(10, 'Standing 1/2 twist Drills', 1, 'This is the description for Standing 1/2 twist Drills at level 1'),
(11, 'Standing 1/2 twist Drills', 2, 'This is the description for Standing 1/2 twist Drills at level 2'),
(12, 'Standing 1/2 twist Drills', 3, 'This is the description for Standing 1/2 twist Drills at level 3'),
(13, 'Lunges', 1, 'This is the description for Lunges at level 1'),
(14, 'Lunges', 2, 'This is the description for Lunges at level 2'),
(15, 'Lunges', 3, 'This is the description for Lunges at level 3');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
