-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 04, 2010 at 12:11 PM
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
-- Table structure for table `ref_month`
--

CREATE TABLE IF NOT EXISTS `ref_month` (
  `id_month` int(11) NOT NULL,
  `desc_mal` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc_eng` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_month`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ref_month`
--

INSERT INTO `ref_month` (`id_month`, `desc_mal`, `desc_eng`) VALUES
(1, 'JANUARI', 'JANUARY'),
(2, 'FEBRUARI', 'FEBRUARY'),
(3, 'MAC', 'MARCH'),
(4, 'APRIL', 'APRIL'),
(5, 'MEI', 'MAY'),
(6, 'JUN', 'JUNE'),
(7, 'JULAI', 'JULY'),
(8, 'OGOS', 'AUGUST'),
(9, 'SEPTEMBER', 'SEPTEMBER'),
(10, 'OKTOBER', 'OCTOBER'),
(11, 'NOVEMBER', 'NOVEMBER'),
(12, 'DISEMBER', 'DECEMBER');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
