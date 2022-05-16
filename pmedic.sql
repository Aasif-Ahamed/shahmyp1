-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 16, 2022 at 06:51 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pmedic`
--

-- --------------------------------------------------------

--
-- Table structure for table `ctracks`
--

DROP TABLE IF EXISTS `ctracks`;
CREATE TABLE IF NOT EXISTS `ctracks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trackname` varchar(50) NOT NULL,
  `trackpath` varchar(100) DEFAULT NULL,
  `uploadtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ctracks`
--

INSERT INTO `ctracks` (`id`, `trackname`, `trackpath`, `uploadtime`) VALUES
(1, 'Raining Sound (1 Hour)', 'CustomTracks/1secondofsilence.mp3', NULL),
(2, 'None', 'None', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cuploads`
--

DROP TABLE IF EXISTS `cuploads`;
CREATE TABLE IF NOT EXISTS `cuploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `clabel` varchar(50) NOT NULL,
  `cpath` varchar(100) NOT NULL,
  `score` varchar(50) DEFAULT 'Pending',
  `add_comments` varchar(255) DEFAULT 'No Additional Comments',
  `score_provder` int(11) DEFAULT '0',
  `upload_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cuploads`
--

INSERT INTO `cuploads` (`id`, `uid`, `clabel`, `cpath`, `score`, `add_comments`, `score_provder`, `upload_time`, `updated_time`) VALUES
(6, 1, 'Audio Recording - 2022/05/13', 'ClientAudio/16280aa7b54fcd6.51163466.wav', 'Pending', 'No Additional Comments', 0, '2022-05-15 07:23:39', '2022-05-15 16:17:13'),
(5, 1, 'Audio Recording - 2022/05/13', 'Aasif Ahamed16280aa7b54fcd6.51163466.wav', 'Pending', 'No Additional Comments', 0, '2022-05-15 07:23:39', '2022-05-15 12:32:41'),
(7, 1, 'Recording (16th May 2022)', 'ClientAudio/Aasif Ahamed1628272a541b518.16193328.wav', 'Pending', 'No Additional Comments', 0, '2022-05-16 15:49:57', '2022-05-16 15:49:57');

-- --------------------------------------------------------

--
-- Table structure for table `docs`
--

DROP TABLE IF EXISTS `docs`;
CREATE TABLE IF NOT EXISTS `docs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `doc_spcial` varchar(255) NOT NULL,
  `exp_years` varchar(50) NOT NULL,
  `highest_qual` varchar(100) NOT NULL,
  `institue` varchar(100) NOT NULL,
  `completion_year` varchar(50) NOT NULL,
  `bio` mediumtext NOT NULL,
  `password` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `docs`
--

INSERT INTO `docs` (`id`, `name`, `age`, `email`, `address`, `contact`, `doc_spcial`, `exp_years`, `highest_qual`, `institue`, `completion_year`, `bio`, `password`, `code`, `created`, `updated`) VALUES
(1, 'Aasif Ahamed', 22, 'asifnawasdeen@gmail.com', '123, Somewhere Around, Sri Lanka', '0769833732', 'Physiotheraphy', '22', 'Bachelors in Physiotheraphy', 'Moratuwa University of Sri Lanka', '2010', 'Well experienced doctor', '1234', '1234', '2022-05-16 17:34:56', '2022-05-16 18:06:04');

-- --------------------------------------------------------

--
-- Table structure for table `habbits`
--

DROP TABLE IF EXISTS `habbits`;
CREATE TABLE IF NOT EXISTS `habbits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `habit` varchar(100) NOT NULL,
  `upload_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `habbits`
--

INSERT INTO `habbits` (`id`, `habit`, `upload_time`, `update_time`, `uid`) VALUES
(1, 'Watching TV', '2022-05-15 16:49:29', '2022-05-15 16:49:29', 1),
(7, 'Coding', '2022-05-15 17:22:18', '2022-05-15 17:23:09', 1),
(12, 'Sleeping', '2022-05-16 15:50:22', '2022-05-16 15:50:22', 1),
(13, 'Coding', '2022-05-16 15:50:22', '2022-05-16 15:50:22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `medical`
--

DROP TABLE IF EXISTS `medical`;
CREATE TABLE IF NOT EXISTS `medical` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `medic` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `upload_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medical`
--

INSERT INTO `medical` (`id`, `medic`, `uid`, `upload_time`, `update_time`) VALUES
(1, 'Diabetes', 1, '2022-05-15 17:51:31', '2022-05-15 17:51:31'),
(4, 'Blood Pressure', 1, '2022-05-16 15:50:51', '2022-05-16 15:50:51'),
(5, 'Cancer', 1, '2022-05-16 15:50:51', '2022-05-16 15:50:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salutation` varchar(25) DEFAULT 'Mr',
  `fullname` varchar(50) NOT NULL,
  `dob` varchar(50) NOT NULL,
  `gender` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `salutation`, `fullname`, `dob`, `gender`, `email`, `password`, `created_time`, `updated_time`) VALUES
(1, 'Mr', 'Aasif Ahamed', '2001-08-24', 'Male', 'asifnawasdeen@gmail.com', '1234', '2022-05-11 07:45:19', '2022-05-11 07:45:45'),
(2, 'Dr', 'Nawasdeen', '1991-01-01', 'Male', 'nawasdeen@gmail.com', '123456', '2022-05-14 18:25:54', '2022-05-14 18:25:54'),
(3, 'Mr', 'John', '1994-01-01', 'Male', 'john@gmail.com', '1234', '2022-05-16 15:48:04', '2022-05-16 15:48:04');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
