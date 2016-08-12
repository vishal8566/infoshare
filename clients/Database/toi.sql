-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jul 04, 2016 at 05:57 AM
-- Server version: 5.6.29-76.2-log
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `codeeyv8_infoshare_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `deal_type_master`
--

CREATE TABLE IF NOT EXISTS `deal_type_master` (
  `deal_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `deal_type_eng_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `deal_type_hebrew_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`deal_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `deal_type_master`
--

INSERT INTO `deal_type_master` (`deal_type_id`, `deal_type_eng_name`, `deal_type_hebrew_name`, `created_date`) VALUES
(1, 'Loan', 'הלוואה', '2016-06-20 00:00:00'),
(2, 'Reporting', 'דיווח', '2016-06-20 04:11:09'),
(3, 'Discounting', 'נכיון', '2016-06-20 09:14:24');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE IF NOT EXISTS `tbl_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `admin_email` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `admin_password` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_admin`
--



-- --------------------------------------------------------

--
-- Table structure for table `tbl_candidate`
--

CREATE TABLE IF NOT EXISTS `tbl_candidate` (
  `candidate_id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `candidate_id_LLC` varchar(100) NOT NULL,
  `candidate_createBy` varchar(100) DEFAULT NULL,
  `candidate_createDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `candidate_updateBy` varchar(100) DEFAULT NULL,
  `candidate_updateDate` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`candidate_id`,`candidate_id_LLC`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_candidate`
--

--
-- Table structure for table `tbl_deal`
--

CREATE TABLE IF NOT EXISTS `tbl_deal` (
  `deal_id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) DEFAULT NULL,
  `candidate_LLC_number` varchar(100) DEFAULT NULL,
  `candidate_LLC_number_integer` int(11) NOT NULL,
  `deal_type` int(11) DEFAULT NULL COMMENT 'primary id of ''deal_master_master''',
  `deal_due_date` varchar(100) DEFAULT NULL,
  `deal_start_date` varchar(100) DEFAULT NULL,
  `deal_phone` varchar(100) DEFAULT NULL,
  `deal_amount` varchar(100) DEFAULT NULL,
  `deal_paymentCount` int(11) DEFAULT NULL,
  `deal_comments` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `deal_report_comment_id` int(11) DEFAULT NULL COMMENT 'primary id of `tbl_report`',
  `deal_guarantor_1` varchar(100) DEFAULT NULL,
  `deal_guarantor_1_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `deal_guarantor_2` varchar(100) DEFAULT NULL,
  `deal_guarantor_2_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `deal_guarantor_3` varchar(100) DEFAULT NULL,
  `deal_guarantor_3_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `deal_createBy` varchar(100) DEFAULT NULL,
  `deal_createDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `deal_updateBy` varchar(100) DEFAULT NULL,
  `deal_updateDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `loan_status` enum('0','1','2') NOT NULL COMMENT '0=pending,1=approved,2=rejected',
  PRIMARY KEY (`deal_id`),
  KEY `FK_tbl_deal` (`candidate_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_deal`
--

--
-- Table structure for table `tbl_report`
--

CREATE TABLE IF NOT EXISTS `tbl_report` (
  `rprt_id` int(11) NOT NULL AUTO_INCREMENT,
  `rprt_comment` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `rprt_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`rprt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_report`
--

--
-- Table structure for table `tbl_search`
--

CREATE TABLE IF NOT EXISTS `tbl_search` (
  `search_id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id_LLC` varchar(100) DEFAULT NULL,
  `user_id` varchar(20) DEFAULT NULL,
  `search_date` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`search_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_search`
--



--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_fullname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `user_email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `user_password` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `user_id_LLC` varchar(255) DEFAULT NULL,
  `user_office_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_phone` varchar(255) DEFAULT NULL,
  `user_contact_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_createBy` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_createDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_updateBy` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_updateDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('0','1') NOT NULL COMMENT '0 for inactive , 1 for active',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_user`
--

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_deal`
--
ALTER TABLE `tbl_deal`
  ADD CONSTRAINT `FK_tbl_deal` FOREIGN KEY (`candidate_id`) REFERENCES `tbl_candidate` (`candidate_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
