-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2014 at 07:59 PM
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
  PRIMARY KEY (`diverId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=172 ;

--
-- Dumping data for table `divers`
--

INSERT INTO `divers` (`diverId`, `fname`, `lname`, `coachId`) VALUES
(1, 'Aaron', 'Aardvark', 1000),
(2, 'Aaron', 'Pie', 1000),
(3, 'Aaron', 'Wambach', 1000),
(4, 'Aaron', 'Keys', 1000),
(5, 'Aaron', 'Poehler', 1000),
(6, 'Aaron', 'Gabrielle', 1000),
(7, 'Aaron', 'Badelia', 1000),
(8, 'Aaron', 'Smith', 1000),
(9, 'Aaron', 'Johnson', 1000),
(10, 'Aaron', 'Johns', 1000),
(11, 'Aaron', 'Mans', 1000),
(12, 'Aaron', 'Rabb', 1000),
(13, 'Aaron', 'Bynoe', 1000),
(14, 'Aaron', 'Alquhist', 1000),
(15, 'Aaron', 'McMahon', 1000),
(16, 'Aaron', 'MacDonald', 1000),
(17, 'Aaron', 'Meat', 1000),
(18, 'Aaron', 'Mere', 1000),
(19, 'Aaron', 'Mixalot', 1000),
(20, 'Apple', 'Aardvark', 1000),
(21, 'Apple', 'Pie', 1000),
(22, 'Apple', 'Wambach', 1000),
(23, 'Apple', 'Keys', 1000),
(24, 'Apple', 'Poehler', 1000),
(25, 'Apple', 'Gabrielle', 1000),
(26, 'Apple', 'Badelia', 1000),
(27, 'Apple', 'Smith', 1000),
(28, 'Apple', 'Johnson', 1000),
(29, 'Apple', 'Johns', 1000),
(30, 'Apple', 'Mans', 1000),
(31, 'Apple', 'Rabb', 1000),
(32, 'Apple', 'Bynoe', 1000),
(33, 'Apple', 'Alquhist', 1000),
(34, 'Apple', 'McMahon', 1000),
(35, 'Apple', 'MacDonald', 1000),
(36, 'Apple', 'Meat', 1000),
(37, 'Apple', 'Mere', 1000),
(38, 'Apple', 'Mixalot', 1000),
(39, 'Abby', 'Aardvark', 1000),
(40, 'Abby', 'Pie', 1000),
(41, 'Abby', 'Wambach', 1000),
(42, 'Abby', 'Keys', 1000),
(43, 'Abby', 'Poehler', 1000),
(44, 'Abby', 'Gabrielle', 1000),
(45, 'Abby', 'Badelia', 1000),
(46, 'Abby', 'Smith', 1000),
(47, 'Abby', 'Johnson', 1000),
(48, 'Abby', 'Johns', 1000),
(49, 'Abby', 'Mans', 1000),
(50, 'Abby', 'Rabb', 1000),
(51, 'Abby', 'Bynoe', 1000),
(52, 'Abby', 'Alquhist', 1000),
(53, 'Abby', 'McMahon', 1000),
(54, 'Abby', 'MacDonald', 1000),
(55, 'Abby', 'Meat', 1000),
(56, 'Abby', 'Mere', 1000),
(57, 'Abby', 'Mixalot', 1000),
(58, 'Alicia', 'Aardvark', 1000),
(59, 'Alicia', 'Pie', 1000),
(60, 'Alicia', 'Wambach', 1000),
(61, 'Alicia', 'Keys', 1000),
(62, 'Alicia', 'Poehler', 1000),
(63, 'Alicia', 'Gabrielle', 1000),
(64, 'Alicia', 'Badelia', 1000),
(65, 'Alicia', 'Smith', 1000),
(66, 'Alicia', 'Johnson', 1000),
(67, 'Alicia', 'Johns', 1000),
(68, 'Alicia', 'Mans', 1000),
(69, 'Alicia', 'Rabb', 1000),
(70, 'Alicia', 'Bynoe', 1000),
(71, 'Alicia', 'Alquhist', 1000),
(72, 'Alicia', 'McMahon', 1000),
(73, 'Alicia', 'MacDonald', 1000),
(74, 'Alicia', 'Meat', 1000),
(75, 'Alicia', 'Mere', 1000),
(76, 'Alicia', 'Mixalot', 1000),
(77, 'Amy', 'Aardvark', 1000),
(78, 'Amy', 'Pie', 1000),
(79, 'Amy', 'Wambach', 1000),
(80, 'Amy', 'Keys', 1000),
(81, 'Amy', 'Poehler', 1000),
(82, 'Amy', 'Gabrielle', 1000),
(83, 'Amy', 'Badelia', 1000),
(84, 'Amy', 'Smith', 1000),
(85, 'Amy', 'Johnson', 1000),
(86, 'Amy', 'Johns', 1000),
(87, 'Amy', 'Mans', 1000),
(88, 'Amy', 'Rabb', 1000),
(89, 'Amy', 'Bynoe', 1000),
(90, 'Amy', 'Alquhist', 1000),
(91, 'Amy', 'McMahon', 1000),
(92, 'Amy', 'MacDonald', 1000),
(93, 'Amy', 'Meat', 1000),
(94, 'Amy', 'Mere', 1000),
(95, 'Amy', 'Mixalot', 1000),
(96, 'Anthony', 'Aardvark', 1000),
(97, 'Anthony', 'Pie', 1000),
(98, 'Anthony', 'Wambach', 1000),
(99, 'Anthony', 'Keys', 1000),
(100, 'Anthony', 'Poehler', 1000),
(101, 'Anthony', 'Gabrielle', 1000),
(102, 'Anthony', 'Badelia', 1000),
(103, 'Anthony', 'Smith', 1000),
(104, 'Anthony', 'Johnson', 1000),
(105, 'Anthony', 'Johns', 1000),
(106, 'Anthony', 'Mans', 1000),
(107, 'Anthony', 'Rabb', 1000),
(108, 'Anthony', 'Bynoe', 1000),
(109, 'Anthony', 'Alquhist', 1000),
(110, 'Anthony', 'McMahon', 1000),
(111, 'Anthony', 'MacDonald', 1000),
(112, 'Anthony', 'Meat', 1000),
(113, 'Anthony', 'Mere', 1000),
(114, 'Anthony', 'Mixalot', 1000),
(115, 'Amelia', 'Aardvark', 1000),
(116, 'Amelia', 'Pie', 1000),
(117, 'Amelia', 'Wambach', 1000),
(118, 'Amelia', 'Keys', 1000),
(119, 'Amelia', 'Poehler', 1000),
(120, 'Amelia', 'Gabrielle', 1000),
(121, 'Amelia', 'Badelia', 1000),
(122, 'Amelia', 'Smith', 1000),
(123, 'Amelia', 'Johnson', 1000),
(124, 'Amelia', 'Johns', 1000),
(125, 'Amelia', 'Mans', 1000),
(126, 'Amelia', 'Rabb', 1000),
(127, 'Amelia', 'Bynoe', 1000),
(128, 'Amelia', 'Alquhist', 1000),
(129, 'Amelia', 'McMahon', 1000),
(130, 'Amelia', 'MacDonald', 1000),
(131, 'Amelia', 'Meat', 1000),
(132, 'Amelia', 'Mere', 1000),
(133, 'Amelia', 'Mixalot', 1000),
(134, 'Allie', 'Aardvark', 1000),
(135, 'Allie', 'Pie', 1000),
(136, 'Allie', 'Wambach', 1000),
(137, 'Allie', 'Keys', 1000),
(138, 'Allie', 'Poehler', 1000),
(139, 'Allie', 'Gabrielle', 1000),
(140, 'Allie', 'Badelia', 1000),
(141, 'Allie', 'Smith', 1000),
(142, 'Allie', 'Johnson', 1000),
(143, 'Allie', 'Johns', 1000),
(144, 'Allie', 'Mans', 1000),
(145, 'Allie', 'Rabb', 1000),
(146, 'Allie', 'Bynoe', 1000),
(147, 'Allie', 'Alquhist', 1000),
(148, 'Allie', 'McMahon', 1000),
(149, 'Allie', 'MacDonald', 1000),
(150, 'Allie', 'Meat', 1000),
(151, 'Allie', 'Mere', 1000),
(152, 'Allie', 'Mixalot', 1000),
(153, 'Bob', 'Aardvark', 1000),
(154, 'Bob', 'Pie', 1000),
(155, 'Bob', 'Wambach', 1000),
(156, 'Bob', 'Keys', 1000),
(157, 'Bob', 'Poehler', 1000),
(158, 'Bob', 'Gabrielle', 1000),
(159, 'Bob', 'Badelia', 1000),
(160, 'Bob', 'Smith', 1000),
(161, 'Bob', 'Johnson', 1000),
(162, 'Bob', 'Johns', 1000),
(163, 'Bob', 'Mans', 1000),
(164, 'Bob', 'Rabb', 1000),
(165, 'Bob', 'Bynoe', 1000),
(166, 'Bob', 'Alquhist', 1000),
(167, 'Bob', 'McMahon', 1000),
(168, 'Bob', 'MacDonald', 1000),
(169, 'Bob', 'Meat', 1000),
(170, 'Bob', 'Mere', 1000),
(171, 'Bob', 'Mixalot', 1000);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
