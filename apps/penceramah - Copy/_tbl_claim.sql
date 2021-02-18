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
-- Table structure for table `_tbl_claim`
--

CREATE TABLE IF NOT EXISTS `_tbl_claim` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_ins_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cl_depcd` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cl_accoffcd` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cl_ptjdesc` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cl_ptjcd` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cl_payctrdesc` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cl_payctrcd` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cl_brchdesc` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cl_brchcd` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cl_doctype` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cl_docno` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cl_month` char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cl_year` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cl_tarafpost` char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cl_gaji` float(8,2) DEFAULT NULL,
  `cl_elaun` float(8,2) DEFAULT NULL,
  `cl_gajino` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cl_orgdesc` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cl_orgadd` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `create_dt` datetime DEFAULT NULL,
  `create_by` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `update_dt` datetime DEFAULT NULL,
  `update_by` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `delete_dt` datetime DEFAULT NULL,
  `delete_by` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `_tbl_claim`
--

INSERT INTO `_tbl_claim` (`cl_id`, `cl_ins_id`, `cl_depcd`, `cl_accoffcd`, `cl_ptjdesc`, `cl_ptjcd`, `cl_payctrdesc`, `cl_payctrcd`, `cl_brchdesc`, `cl_brchcd`, `cl_doctype`, `cl_docno`, `cl_month`, `cl_year`, `cl_tarafpost`, `cl_gaji`, `cl_elaun`, `cl_gajino`, `cl_orgdesc`, `cl_orgadd`, `create_dt`, `create_by`, `update_dt`, `update_by`, `is_deleted`, `delete_dt`, `delete_by`) VALUES
(1, '117', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '2010', '01', NULL, NULL, NULL, NULL, NULL, '2010-11-18 14:14:38', NULL, NULL, NULL, 0, NULL, NULL),
(2, '85', '111', '222', 'wwwwwwwwww ffffffffffffff', '333', 'sssssssssss fffffff gggggggggggggg', '4444', 'rrrrrrrrr gggggggggggggggg', '5555', NULL, NULL, '11', '2010', '01', 0.00, 0.00, 'zczc', NULL, NULL, '2010-11-18 14:18:01', NULL, NULL, NULL, 0, NULL, NULL),
(3, '1', '111', '100', 'aaaaaaaaaaaaaaa fffffff dddddddddddddd', '233', 'rrrrrrrrrrrrrrr  ggggggggggggggg', '123', 'rrrrrrrrrrrrrrrrrrrrrr bbbbbbbbbbbbbbbbb', '1234', NULL, NULL, '11', '2010', '01', 3000.00, 900.00, '12133344', 'adas dwed sadsf dsf ', 'rrrrrrrrrrrrrrrrrrr bbbbbbbbbbbbbb gggggggggggggg hhhhhhhhhhhh jjjjjjjjjj nnnnnnnnn   fffffffffffffffffffffffff', '2010-11-18 22:58:46', NULL, NULL, NULL, 0, NULL, NULL),
(4, '81', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '2010', '01', NULL, NULL, NULL, NULL, NULL, '2010-11-18 23:29:19', NULL, NULL, NULL, 0, NULL, NULL),
(5, '9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11', '2010', '01', NULL, NULL, NULL, NULL, NULL, '2010-11-18 23:31:20', NULL, NULL, NULL, 0, NULL, NULL),
(6, '9', '1111', '11', 'ASDASDAS ASDASDAS', '3', 'ASDASDAS', '111', 'ASDASDAS', '3', 'DASDASDA', '111', '6', '2010', '01', 0.00, 0.00, 'DAS', 'SDASD', 'ASDASDAS', '2010-07-02 12:29:02', NULL, '2010-07-03 21:50:08', NULL, 0, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
