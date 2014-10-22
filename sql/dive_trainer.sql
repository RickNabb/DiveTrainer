-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2014 at 05:18 PM
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
-- Table structure for table `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `level` int(11) NOT NULL,
  `title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `coaches`
--

CREATE TABLE IF NOT EXISTS `coaches` (
  `coachId` int(11) NOT NULL,
  `fname` varchar(50) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `lname` varchar(50) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `level` int(11) NOT NULL,
  `address1` varchar(200) NOT NULL,
  `address2` varchar(200) NOT NULL,
  `zip` varchar(5) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dob` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coaches`
--

INSERT INTO `coaches` (`coachId`, `fname`, `lname`, `level`, `address1`, `address2`, `zip`, `phone`, `email`, `dob`) VALUES
(1000, 'Cliff', 'Devries', 5, '1234 Test Dr', '', '12345', '1112223333', 'cliff@server.com', '1970-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `divers`
--

CREATE TABLE IF NOT EXISTS `divers` (
`diverId` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `coachId` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `address1` varchar(200) NOT NULL,
  `address2` varchar(200) NOT NULL,
  `zip` varchar(5) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dob` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=186 ;

--
-- Dumping data for table `divers`
--

INSERT INTO `divers` (`diverId`, `fname`, `lname`, `coachId`, `level`, `address1`, `address2`, `zip`, `phone`, `email`, `dob`) VALUES
(1, 'Aaron', 'Aardvark', 1000, 0, '', '', '', '', '', '0000-00-00'),
(2, 'Aaron', 'Pie', 1000, 0, '', '', '', '', '', '0000-00-00'),
(3, 'Aaron', 'Wambach', 1000, 0, '', '', '', '', '', '0000-00-00'),
(4, 'Aaron', 'Keys', 1000, 0, '', '', '', '', '', '0000-00-00'),
(5, 'Aaron', 'Poehler', 1000, 0, '', '', '', '', '', '0000-00-00'),
(6, 'Aaron', 'Gabrielle', 1000, 0, '', '', '', '', '', '0000-00-00'),
(7, 'Aaron', 'Badelia', 1000, 0, '', '', '', '', '', '0000-00-00'),
(8, 'Aaron', 'Smith', 1000, 0, '', '', '', '', '', '0000-00-00'),
(9, 'Aaron', 'Johnson', 1000, 0, '', '', '', '', '', '0000-00-00'),
(10, 'Aaron', 'Johns', 1000, 0, '', '', '', '', '', '0000-00-00'),
(11, 'Aaron', 'Mans', 1000, 0, '', '', '', '', '', '0000-00-00'),
(12, 'Aaron', 'Rabb', 1000, 0, '', '', '', '', '', '0000-00-00'),
(13, 'Aaron', 'Bynoe', 1000, 0, '', '', '', '', '', '0000-00-00'),
(14, 'Aaron', 'Alquhist', 1000, 0, '', '', '', '', '', '0000-00-00'),
(15, 'Aaron', 'McMahon', 1000, 0, '', '', '', '', '', '0000-00-00'),
(16, 'Aaron', 'MacDonald', 1000, 0, '', '', '', '', '', '0000-00-00'),
(17, 'Aaron', 'Meat', 1000, 0, '', '', '', '', '', '0000-00-00'),
(18, 'Aaron', 'Mere', 1000, 0, '', '', '', '', '', '0000-00-00'),
(19, 'Aaron', 'Mixalot', 1000, 0, '', '', '', '', '', '0000-00-00'),
(20, 'Apple', 'Aardvark', 1000, 0, '', '', '', '', '', '0000-00-00'),
(21, 'Apple', 'Pie', 1000, 0, '', '', '', '', '', '0000-00-00'),
(22, 'Apple', 'Wambach', 1000, 0, '', '', '', '', '', '0000-00-00'),
(23, 'Apple', 'Keys', 1000, 0, '', '', '', '', '', '0000-00-00'),
(24, 'Apple', 'Poehler', 1000, 0, '', '', '', '', '', '0000-00-00'),
(25, 'Apple', 'Gabrielle', 1000, 0, '', '', '', '', '', '0000-00-00'),
(26, 'Apple', 'Badelia', 1000, 0, '', '', '', '', '', '0000-00-00'),
(27, 'Apple', 'Smith', 1000, 0, '', '', '', '', '', '0000-00-00'),
(28, 'Apple', 'Johnson', 1000, 0, '', '', '', '', '', '0000-00-00'),
(29, 'Apple', 'Johns', 1000, 0, '', '', '', '', '', '0000-00-00'),
(30, 'Apple', 'Mans', 1000, 0, '', '', '', '', '', '0000-00-00'),
(31, 'Apple', 'Rabb', 1000, 0, '', '', '', '', '', '0000-00-00'),
(32, 'Apple', 'Bynoe', 1000, 0, '', '', '', '', '', '0000-00-00'),
(33, 'Apple', 'Alquhist', 1000, 0, '', '', '', '', '', '0000-00-00'),
(34, 'Apple', 'McMahon', 1000, 0, '', '', '', '', '', '0000-00-00'),
(35, 'Apple', 'MacDonald', 1000, 0, '', '', '', '', '', '0000-00-00'),
(36, 'Apple', 'Meat', 1000, 0, '', '', '', '', '', '0000-00-00'),
(37, 'Apple', 'Mere', 1000, 0, '', '', '', '', '', '0000-00-00'),
(38, 'Apple', 'Mixalot', 1000, 0, '', '', '', '', '', '0000-00-00'),
(39, 'Abby', 'Aardvark', 1000, 0, '', '', '', '', '', '0000-00-00'),
(40, 'Abby', 'Pie', 1000, 0, '', '', '', '', '', '0000-00-00'),
(41, 'Abby', 'Wambach', 1000, 0, '', '', '', '', '', '0000-00-00'),
(42, 'Abby', 'Keys', 1000, 0, '', '', '', '', '', '0000-00-00'),
(43, 'Abby', 'Poehler', 1000, 0, '', '', '', '', '', '0000-00-00'),
(44, 'Abby', 'Gabrielle', 1000, 0, '', '', '', '', '', '0000-00-00'),
(45, 'Abby', 'Badelia', 1000, 0, '', '', '', '', '', '0000-00-00'),
(46, 'Abby', 'Smith', 1000, 0, '', '', '', '', '', '0000-00-00'),
(47, 'Abby', 'Johnson', 1000, 0, '', '', '', '', '', '0000-00-00'),
(48, 'Abby', 'Johns', 1000, 0, '', '', '', '', '', '0000-00-00'),
(49, 'Abby', 'Mans', 1000, 0, '', '', '', '', '', '0000-00-00'),
(50, 'Abby', 'Rabb', 1000, 0, '', '', '', '', '', '0000-00-00'),
(51, 'Abby', 'Bynoe', 1000, 0, '', '', '', '', '', '0000-00-00'),
(52, 'Abby', 'Alquhist', 1000, 0, '', '', '', '', '', '0000-00-00'),
(53, 'Abby', 'McMahon', 1000, 0, '', '', '', '', '', '0000-00-00'),
(54, 'Abby', 'MacDonald', 1000, 0, '', '', '', '', '', '0000-00-00'),
(55, 'Abby', 'Meat', 1000, 0, '', '', '', '', '', '0000-00-00'),
(56, 'Abby', 'Mere', 1000, 0, '', '', '', '', '', '0000-00-00'),
(57, 'Abby', 'Mixalot', 1000, 0, '', '', '', '', '', '0000-00-00'),
(58, 'Alicia', 'Aardvark', 1000, 0, '', '', '', '', '', '0000-00-00'),
(59, 'Alicia', 'Pie', 1000, 0, '', '', '', '', '', '0000-00-00'),
(60, 'Alicia', 'Wambach', 1000, 0, '', '', '', '', '', '0000-00-00'),
(61, 'Alicia', 'Keys', 1000, 0, '', '', '', '', '', '0000-00-00'),
(62, 'Alicia', 'Poehler', 1000, 0, '', '', '', '', '', '0000-00-00'),
(63, 'Alicia', 'Gabrielle', 1000, 0, '', '', '', '', '', '0000-00-00'),
(64, 'Alicia', 'Badelia', 1000, 0, '', '', '', '', '', '0000-00-00'),
(65, 'Alicia', 'Smith', 1000, 0, '', '', '', '', '', '0000-00-00'),
(66, 'Alicia', 'Johnson', 1000, 0, '', '', '', '', '', '0000-00-00'),
(67, 'Alicia', 'Johns', 1000, 0, '', '', '', '', '', '0000-00-00'),
(68, 'Alicia', 'Mans', 1000, 0, '', '', '', '', '', '0000-00-00'),
(69, 'Alicia', 'Rabb', 1000, 0, '', '', '', '', '', '0000-00-00'),
(70, 'Alicia', 'Bynoe', 1000, 0, '', '', '', '', '', '0000-00-00'),
(71, 'Alicia', 'Alquhist', 1000, 0, '', '', '', '', '', '0000-00-00'),
(72, 'Alicia', 'McMahon', 1000, 0, '', '', '', '', '', '0000-00-00'),
(73, 'Alicia', 'MacDonald', 1000, 0, '', '', '', '', '', '0000-00-00'),
(74, 'Alicia', 'Meat', 1000, 0, '', '', '', '', '', '0000-00-00'),
(75, 'Alicia', 'Mere', 1000, 0, '', '', '', '', '', '0000-00-00'),
(76, 'Alicia', 'Mixalot', 1000, 0, '', '', '', '', '', '0000-00-00'),
(77, 'Amy', 'Aardvark', 1000, 0, '', '', '', '', '', '0000-00-00'),
(78, 'Amy', 'Pie', 1000, 0, '', '', '', '', '', '0000-00-00'),
(79, 'Amy', 'Wambach', 1000, 0, '', '', '', '', '', '0000-00-00'),
(80, 'Amy', 'Keys', 1000, 0, '', '', '', '', '', '0000-00-00'),
(81, 'Amy', 'Poehler', 1000, 0, '', '', '', '', '', '0000-00-00'),
(82, 'Amy', 'Gabrielle', 1000, 0, '', '', '', '', '', '0000-00-00'),
(83, 'Amy', 'Badelia', 1000, 0, '', '', '', '', '', '0000-00-00'),
(84, 'Amy', 'Smith', 1000, 0, '', '', '', '', '', '0000-00-00'),
(85, 'Amy', 'Johnson', 1000, 0, '', '', '', '', '', '0000-00-00'),
(86, 'Amy', 'Johns', 1000, 0, '', '', '', '', '', '0000-00-00'),
(87, 'Amy', 'Mans', 1000, 0, '', '', '', '', '', '0000-00-00'),
(88, 'Amy', 'Rabb', 1000, 0, '', '', '', '', '', '0000-00-00'),
(89, 'Amy', 'Bynoe', 1000, 0, '', '', '', '', '', '0000-00-00'),
(90, 'Amy', 'Alquhist', 1000, 0, '', '', '', '', '', '0000-00-00'),
(91, 'Amy', 'McMahon', 1000, 0, '', '', '', '', '', '0000-00-00'),
(92, 'Amy', 'MacDonald', 1000, 0, '', '', '', '', '', '0000-00-00'),
(93, 'Amy', 'Meat', 1000, 0, '', '', '', '', '', '0000-00-00'),
(94, 'Amy', 'Mere', 1000, 0, '', '', '', '', '', '0000-00-00'),
(95, 'Amy', 'Mixalot', 1000, 0, '', '', '', '', '', '0000-00-00'),
(96, 'Anthony', 'Aardvark', 1000, 0, '', '', '', '', '', '0000-00-00'),
(97, 'Anthony', 'Pie', 1000, 0, '', '', '', '', '', '0000-00-00'),
(98, 'Anthony', 'Wambach', 1000, 0, '', '', '', '', '', '0000-00-00'),
(99, 'Anthony', 'Keys', 1000, 0, '', '', '', '', '', '0000-00-00'),
(100, 'Anthony', 'Poehler', 1000, 0, '', '', '', '', '', '0000-00-00'),
(101, 'Anthony', 'Gabrielle', 1000, 0, '', '', '', '', '', '0000-00-00'),
(102, 'Anthony', 'Badelia', 1000, 0, '', '', '', '', '', '0000-00-00'),
(103, 'Anthony', 'Smith', 1000, 0, '', '', '', '', '', '0000-00-00'),
(104, 'Anthony', 'Johnson', 1000, 0, '', '', '', '', '', '0000-00-00'),
(105, 'Anthony', 'Johns', 1000, 0, '', '', '', '', '', '0000-00-00'),
(106, 'Anthony', 'Mans', 1000, 0, '', '', '', '', '', '0000-00-00'),
(107, 'Anthony', 'Rabb', 1000, 0, '', '', '', '', '', '0000-00-00'),
(108, 'Anthony', 'Bynoe', 1000, 0, '', '', '', '', '', '0000-00-00'),
(109, 'Anthony', 'Alquhist', 1000, 0, '', '', '', '', '', '0000-00-00'),
(110, 'Anthony', 'McMahon', 1000, 0, '', '', '', '', '', '0000-00-00'),
(111, 'Anthony', 'MacDonald', 1000, 0, '', '', '', '', '', '0000-00-00'),
(112, 'Anthony', 'Meat', 1000, 0, '', '', '', '', '', '0000-00-00'),
(113, 'Anthony', 'Mere', 1000, 0, '', '', '', '', '', '0000-00-00'),
(114, 'Anthony', 'Mixalot', 1000, 0, '', '', '', '', '', '0000-00-00'),
(115, 'Amelia', 'Aardvark', 1000, 0, '', '', '', '', '', '0000-00-00'),
(116, 'Amelia', 'Pie', 1000, 0, '', '', '', '', '', '0000-00-00'),
(117, 'Amelia', 'Wambach', 1000, 0, '', '', '', '', '', '0000-00-00'),
(118, 'Amelia', 'Keys', 1000, 0, '', '', '', '', '', '0000-00-00'),
(119, 'Amelia', 'Poehler', 1000, 0, '', '', '', '', '', '0000-00-00'),
(120, 'Amelia', 'Gabrielle', 1000, 0, '', '', '', '', '', '0000-00-00'),
(121, 'Amelia', 'Badelia', 1000, 0, '', '', '', '', '', '0000-00-00'),
(122, 'Amelia', 'Smith', 1000, 0, '', '', '', '', '', '0000-00-00'),
(123, 'Amelia', 'Johnson', 1000, 0, '', '', '', '', '', '0000-00-00'),
(124, 'Amelia', 'Johns', 1000, 0, '', '', '', '', '', '0000-00-00'),
(125, 'Amelia', 'Mans', 1000, 0, '', '', '', '', '', '0000-00-00'),
(126, 'Amelia', 'Rabb', 1000, 0, '', '', '', '', '', '0000-00-00'),
(127, 'Amelia', 'Bynoe', 1000, 0, '', '', '', '', '', '0000-00-00'),
(128, 'Amelia', 'Alquhist', 1000, 0, '', '', '', '', '', '0000-00-00'),
(129, 'Amelia', 'McMahon', 1000, 0, '', '', '', '', '', '0000-00-00'),
(130, 'Amelia', 'MacDonald', 1000, 0, '', '', '', '', '', '0000-00-00'),
(131, 'Amelia', 'Meat', 1000, 0, '', '', '', '', '', '0000-00-00'),
(132, 'Amelia', 'Mere', 1000, 0, '', '', '', '', '', '0000-00-00'),
(133, 'Amelia', 'Mixalot', 1000, 0, '', '', '', '', '', '0000-00-00'),
(134, 'Allie', 'Aardvark', 1000, 0, '', '', '', '', '', '0000-00-00'),
(135, 'Allie', 'Pie', 1000, 0, '', '', '', '', '', '0000-00-00'),
(136, 'Allie', 'Wambach', 1000, 0, '', '', '', '', '', '0000-00-00'),
(137, 'Allie', 'Keys', 1000, 0, '', '', '', '', '', '0000-00-00'),
(138, 'Allie', 'Poehler', 1000, 0, '', '', '', '', '', '0000-00-00'),
(139, 'Allie', 'Gabrielle', 1000, 0, '', '', '', '', '', '0000-00-00'),
(140, 'Allie', 'Badelia', 1000, 0, '', '', '', '', '', '0000-00-00'),
(141, 'Allie', 'Smith', 1000, 0, '', '', '', '', '', '0000-00-00'),
(142, 'Allie', 'Johnson', 1000, 0, '', '', '', '', '', '0000-00-00'),
(143, 'Allie', 'Johns', 1000, 0, '', '', '', '', '', '0000-00-00'),
(144, 'Allie', 'Mans', 1000, 0, '', '', '', '', '', '0000-00-00'),
(145, 'Allie', 'Rabb', 1000, 0, '', '', '', '', '', '0000-00-00'),
(146, 'Allie', 'Bynoe', 1000, 0, '', '', '', '', '', '0000-00-00'),
(147, 'Allie', 'Alquhist', 1000, 0, '', '', '', '', '', '0000-00-00'),
(148, 'Allie', 'McMahon', 1000, 0, '', '', '', '', '', '0000-00-00'),
(149, 'Allie', 'MacDonald', 1000, 0, '', '', '', '', '', '0000-00-00'),
(150, 'Allie', 'Meat', 1000, 0, '', '', '', '', '', '0000-00-00'),
(151, 'Allie', 'Mere', 1000, 0, '', '', '', '', '', '0000-00-00'),
(152, 'Allie', 'Mixalot', 1000, 0, '', '', '', '', '', '0000-00-00'),
(153, 'Bob', 'Aardvark', 1000, 0, '', '', '', '', '', '0000-00-00'),
(154, 'Bob', 'Pie', 1000, 0, '', '', '', '', '', '0000-00-00'),
(155, 'Bob', 'Wambach', 1000, 0, '', '', '', '', '', '0000-00-00'),
(156, 'Bob', 'Keys', 1000, 0, '', '', '', '', '', '0000-00-00'),
(157, 'Bob', 'Poehler', 1000, 0, '', '', '', '', '', '0000-00-00'),
(158, 'Bob', 'Gabrielle', 1000, 0, '', '', '', '', '', '0000-00-00'),
(159, 'Bob', 'Badelia', 1000, 0, '', '', '', '', '', '0000-00-00'),
(160, 'Bob', 'Smith', 1000, 0, '', '', '', '', '', '0000-00-00'),
(161, 'Bob', 'Johnson', 1000, 0, '', '', '', '', '', '0000-00-00'),
(162, 'Bob', 'Johns', 1000, 0, '', '', '', '', '', '0000-00-00'),
(163, 'Bob', 'Mans', 1000, 0, '', '', '', '', '', '0000-00-00'),
(164, 'Bob', 'Rabb', 1000, 0, '', '', '', '', '', '0000-00-00'),
(165, 'Bob', 'Bynoe', 1000, 0, '', '', '', '', '', '0000-00-00'),
(166, 'Bob', 'Alquhist', 1000, 0, '', '', '', '', '', '0000-00-00'),
(167, 'Bob', 'McMahon', 1000, 0, '', '', '', '', '', '0000-00-00'),
(168, 'Bob', 'MacDonald', 1000, 0, '', '', '', '', '', '0000-00-00'),
(169, 'Bob', 'Meat', 1000, 0, '', '', '', '', '', '0000-00-00'),
(170, 'Bob', 'Mere', 1000, 0, '', '', '', '', '', '0000-00-00'),
(171, 'Bob', 'Mixalot', 1000, 0, '', '', '', '', '', '0000-00-00'),
(180, 'TestFirst', 'TestLast', 1000, 0, '', '', '', '', '', '0000-00-00'),
(185, 'Test2', 'Test2', 1000, 0, '', '', '', '', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `divertopractice`
--

CREATE TABLE IF NOT EXISTS `divertopractice` (
  `diverId` int(11) NOT NULL,
  `practiceId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exercise`
--

CREATE TABLE IF NOT EXISTS `exercise` (
`exerciseId` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `level` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `videoURL` varchar(500) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `exercise`
--

INSERT INTO `exercise` (`exerciseId`, `name`, `level`, `type`, `description`, `videoURL`) VALUES
(1, 'Jumprope', 1, '', 'This is the description for Jumprope at level 1', ''),
(2, 'Jumprope', 2, '', 'This is the description for Jumprope at level 2', ''),
(3, 'Jumprope', 3, '', 'This is the description for Jumprope at level 3', ''),
(4, 'Armcircles', 1, '', 'This is the description for Armcircles at level 1', ''),
(5, 'Armcircles', 2, '', 'This is the description for Armcircles at level 2', ''),
(6, 'Armcircles', 3, '', 'This is the description for Armcircles at level 3', ''),
(7, 'Pike jumps on Dryboard', 1, '', 'This is the description for Pike jumps on Dryboard at level 1', ''),
(8, 'Pike jumps on Dryboard', 2, '', 'This is the description for Pike jumps on Dryboard at level 2', ''),
(9, 'Pike jumps on Dryboard', 3, '', 'This is the description for Pike jumps on Dryboard at level 3', ''),
(10, 'Standing 1/2 twist Drills', 1, '', 'This is the description for Standing 1/2 twist Drills at level 1', ''),
(11, 'Standing 1/2 twist Drills', 2, '', 'This is the description for Standing 1/2 twist Drills at level 2', ''),
(12, 'Standing 1/2 twist Drills', 3, '', 'This is the description for Standing 1/2 twist Drills at level 3', ''),
(13, 'Lunges', 1, '', 'This is the description for Lunges at level 1', ''),
(14, 'Lunges', 2, '', 'This is the description for Lunges at level 2', ''),
(15, 'Lunges', 3, '', 'This is the description for Lunges at level 3', '');

-- --------------------------------------------------------

--
-- Table structure for table `exercisetogoal`
--

CREATE TABLE IF NOT EXISTS `exercisetogoal` (
  `exerciseId` int(11) NOT NULL,
  `goalId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exercisetopractice`
--

CREATE TABLE IF NOT EXISTS `exercisetopractice` (
  `exerciseId` int(11) NOT NULL,
  `practiceId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `goals`
--

CREATE TABLE IF NOT EXISTS `goals` (
`goalId` int(11) NOT NULL,
  `diverId` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `goals`
--

INSERT INTO `goals` (`goalId`, `diverId`, `name`, `startDate`, `endDate`) VALUES
(1, 1, 'Goal1', '2014-10-13', '2015-01-01'),
(2, 1, 'Goal2', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `practices`
--

CREATE TABLE IF NOT EXISTS `practices` (
`practiceId` int(11) NOT NULL,
  `coachId` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
 ADD PRIMARY KEY (`level`);

--
-- Indexes for table `coaches`
--
ALTER TABLE `coaches`
 ADD PRIMARY KEY (`coachId`);

--
-- Indexes for table `divers`
--
ALTER TABLE `divers`
 ADD PRIMARY KEY (`diverId`), ADD FULLTEXT KEY `fname` (`fname`);

--
-- Indexes for table `divertopractice`
--
ALTER TABLE `divertopractice`
 ADD PRIMARY KEY (`diverId`,`practiceId`);

--
-- Indexes for table `exercise`
--
ALTER TABLE `exercise`
 ADD PRIMARY KEY (`exerciseId`);

--
-- Indexes for table `exercisetogoal`
--
ALTER TABLE `exercisetogoal`
 ADD PRIMARY KEY (`exerciseId`,`goalId`);

--
-- Indexes for table `exercisetopractice`
--
ALTER TABLE `exercisetopractice`
 ADD PRIMARY KEY (`exerciseId`,`practiceId`);

--
-- Indexes for table `goals`
--
ALTER TABLE `goals`
 ADD PRIMARY KEY (`goalId`);

--
-- Indexes for table `practices`
--
ALTER TABLE `practices`
 ADD PRIMARY KEY (`practiceId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `divers`
--
ALTER TABLE `divers`
MODIFY `diverId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=186;
--
-- AUTO_INCREMENT for table `exercise`
--
ALTER TABLE `exercise`
MODIFY `exerciseId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `goals`
--
ALTER TABLE `goals`
MODIFY `goalId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `practices`
--
ALTER TABLE `practices`
MODIFY `practiceId` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
