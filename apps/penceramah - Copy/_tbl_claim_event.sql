-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 04, 2010 at 12:12 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_ilim2`
--

-- --------------------------------------------------------

--
-- Table structure for table `_tbl_claim_event`
--

CREATE TABLE IF NOT EXISTS `_tbl_claim_event` (
  `cl_eve_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_id` int(11) DEFAULT NULL,
  `cl_eve_event_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cl_eve_tempoh` int(11) DEFAULT NULL,
  `cl_eve_course_id` int(11) DEFAULT NULL,
  `cl_eve_startdate` datetime DEFAULT NULL,
  `cl_eve_enddate` datetime DEFAULT NULL,
  PRIMARY KEY (`cl_eve_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `_tbl_claim_event`
--

INSERT INTO `_tbl_claim_event` (`cl_eve_id`, `cl_id`, `cl_eve_event_id`, `cl_eve_tempoh`, `cl_eve_course_id`, `cl_eve_startdate`, `cl_eve_enddate`) VALUES
(1, 5, '0', 8, NULL, NULL, NULL),
(2, 5, '0', 9, NULL, NULL, NULL),
(3, 5, 'E000000094', 7, NULL, NULL, NULL),
(4, 5, 'E000000094', 12, 64, '2010-07-05 00:00:00', '2010-07-11 00:00:00'),
(5, 6, 'E000000094', 8, 64, '2010-07-05 00:00:00', '2010-07-11 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
