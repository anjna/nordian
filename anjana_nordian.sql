-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 05, 2014 at 12:44 PM
-- Server version: 5.1.69
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `anjana_nordian`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` text,
  `fullname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `is_active` enum('1','0') DEFAULT NULL,
  `is_verified` enum('0','1') DEFAULT NULL,
  `type` enum('admin','sme') DEFAULT NULL,
  `lastloggedin` timestamp NULL DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `password`, `fullname`, `email`, `is_active`, `is_verified`, `type`, `lastloggedin`, `created`, `modified`) VALUES
(1, '4087b868bf3ae19efc8bfcb0748cfbc39d1497b9', 'Super Admin', 'admin@nordian.com', '1', '1', 'admin', NULL, '2014-01-23 14:36:16', '2014-01-23 14:36:16'),
(45, '746d9e779bd0865605690632dc32dff52886b159', 'monty', 'monty.khanna@trigma.co.in', '1', '1', 'sme', NULL, '2014-09-05 11:24:49', '2014-09-05 11:24:49'),
(44, '58afd66ff646579d0b4c17c3bd0c43a2c0dbdf03', 'anjana', 'anjana.sharma@trigma.in', '1', '1', 'sme', NULL, '2014-09-04 11:28:02', '2014-09-04 11:28:02');

-- --------------------------------------------------------

--
-- Table structure for table `admin_subjects`
--

CREATE TABLE IF NOT EXISTS `admin_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=99 ;

--
-- Dumping data for table `admin_subjects`
--

INSERT INTO `admin_subjects` (`id`, `admin_id`, `subject_id`, `course_id`) VALUES
(82, 12, 31, 6),
(81, 13, 30, 6),
(80, 13, 28, 6),
(79, 13, 27, 11),
(78, 11, 25, 6),
(77, 12, 24, 7),
(76, 11, 24, 7),
(75, 11, 24, 7),
(74, 13, 20, 6),
(73, 13, 17, 6),
(68, 11, 23, 6),
(67, 11, 22, 6),
(66, 12, 21, 6),
(65, 12, 20, 6),
(64, 12, 19, 6),
(63, 12, 18, 6),
(62, 12, 17, 6),
(61, 12, 16, 7),
(60, 3, 14, 7),
(59, 11, 15, 7),
(83, 12, 40, 6),
(56, 12, 14, 6),
(55, 11, 14, 6),
(84, 13, 67, 6),
(85, 13, 70, 6),
(86, 14, 17, 6),
(87, 12, 71, 13),
(88, 15, 71, 13),
(89, 16, 71, 13),
(90, 17, 71, 13),
(91, 17, 72, 13),
(92, 17, 72, 13),
(93, 17, 72, 13),
(94, 17, 72, 13),
(95, 17, 72, 13),
(96, 17, 72, 13),
(97, 17, 73, 15),
(98, 17, 74, 16);

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE IF NOT EXISTS `chapters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `name` text,
  `description` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `status` enum('ready','inprogress') DEFAULT 'inprogress',
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `chapters`
--

INSERT INTO `chapters` (`id`, `course_id`, `subject_id`, `name`, `description`, `created`, `modified`, `admin_id`, `status`, `order`) VALUES
(31, 13, 71, 'The Earth', 'vZymQp2UEcGmaxzBI/A5G5NtGf666kC2xJQu6K36Y2I=', '2014-01-22 12:51:08', '2014-01-22 12:51:08', 1, 'ready', NULL),
(32, 13, 71, 'General Navigation', 'TccuNk5QsVGXtVqy40sU4D06JMonOjtk3j7p4+dCQlM=', '2014-01-22 12:51:25', '2014-01-23 11:30:47', 1, 'ready', NULL),
(33, 13, 72, 'Electrical Chapter1', 'C+7kCvlg6r3EufxKHTnOW0zJNeKJwk5Zy4ku75N8Gw4=', '2014-01-24 11:17:14', '2014-08-21 10:52:01', 1, 'inprogress', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chapter_questions`
--

CREATE TABLE IF NOT EXISTS `chapter_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `chapter_id` int(11) DEFAULT NULL,
  `question` text,
  `option1` text,
  `option2` text,
  `option3` text,
  `option4` text,
  `answer` enum('option1','option2','option3','option4') DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `status` enum('ready','inprogress') DEFAULT 'inprogress',
  `order` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `chapter_questions`
--

INSERT INTO `chapter_questions` (`id`, `course_id`, `subject_id`, `chapter_id`, `question`, `option1`, `option2`, `option3`, `option4`, `answer`, `created`, `modified`, `admin_id`, `status`, `order`) VALUES
(29, 13, 71, 31, '<p>Q1</p>\r\n', 'Y8KeboNGp8RGLFpLSlzdFoG4rJx8a7awElYStexBxeA=', 'vS4BrxKcCLMXv7lcRHMZUrxdpURje0eJTyUaxL9eDoE=', 'xwIDBbYkzbkCc5ZINFsybg==', '3vDf/7SLFeeRXhOvAryS4g==', 'option1', '2014-01-22 14:24:03', '2014-01-22 14:24:03', 1, 'ready', NULL),
(30, 13, 71, 32, '<p>Next Question</p>\r\n', 'cspCZP4bkg83kZbnjgtq3Q==', 'qJ7bi3GYi+YuJ3NRl9jWbw==', 'ZsgAB+4OQpbaUEquoncbzg==', 'ymdAzalTMg+2r52uSqLNaQ==', 'option2', '2014-01-22 14:26:30', '2014-01-23 11:33:02', 1, 'ready', NULL),
(31, 13, 72, 33, '<p>Q!</p>\r\n', '+ni3pz/BX5uljOObB9LVGA==', 'NCqzLOq8ucWPNmR7ttyeBg==', 'G7a6nK8QmAnU/uUeQyPVgQ==', 'CjQmssMzOtFvNViTddW5rw==', 'option4', '2014-01-24 11:18:50', '2014-01-24 11:18:50', 1, 'ready', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE IF NOT EXISTS `email_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `slug` varchar(50) NOT NULL COMMENT 'unique identifier code',
  `subject` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `title`, `slug`, `subject`, `description`, `created`, `modified`, `status`) VALUES
(16, 'Forgot Password', 'forgot-password', 'Forgot Password', '<p>Now your password is</p>\r\n<p>Email : {EMAIL}</p>\r\n<p>Password : {PASSWORD}</p>', '0000-00-00 00:00:00', '2013-01-14 04:07:29', '1');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE IF NOT EXISTS `feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `feedback` int(11) NOT NULL,
  `comments` varchar(250) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `chapter_id` int(11) DEFAULT NULL,
  `summary_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL,
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `slug`, `value`, `created`, `modified`) VALUES
(1, 'Site Email', 'SiteEmail', 'rajinder.singh@cloudsmart.net', NULL, NULL),
(2, 'Paging', 'paging-length', '10', NULL, '2014-01-17'),
(3, 'Drop Down', 'dropdown-paging', '20,100,500,1000,All', NULL, '2014-01-23');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `extcode` text,
  `course_id` int(11) DEFAULT NULL,
  `intcode` text,
  `name` text,
  `description` text,
  `admin_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `is_active` enum('ready','inprogress') DEFAULT NULL,
  `status` enum('publish','unpublish') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `extcode`, `course_id`, `intcode`, `name`, `description`, `admin_id`, `created`, `modified`, `is_active`, `status`) VALUES
(71, 'AIRFRAME', 13, 'AIRFRAME', 'AIR FRAME', '8DBspLu2QKRATCHinueM/Q==', 1, '2014-01-22 12:50:20', '2014-08-19 10:36:59', 'ready', 'publish'),
(72, 'Electrical', 13, 'ELECTRICAL', 'ELECTRICAL', 'HnK9NXH7OHHZ++0mWoOjgg==', 1, '2014-01-24 11:15:46', '2014-01-24 11:33:58', 'ready', NULL),
(74, '123', 16, '231', 'php', 'CkiX1fwKRQbBLNXNQ7S3ow==', 1, '2014-08-19 10:43:23', '2014-08-19 10:43:23', 'ready', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `summaries`
--

CREATE TABLE IF NOT EXISTS `summaries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `chapter_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('ready','inprogress') DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `summaries`
--

INSERT INTO `summaries` (`id`, `course_id`, `subject_id`, `chapter_id`, `admin_id`, `description`, `created`, `modified`, `status`, `order`) VALUES
(34, 13, 71, 31, 1, 'FnFOaaSvUVNzhMFY+jdUsZF7N5afN416ucr3Bv3oVjm+PTJyhe3MdgAXd8x7Vef1', '2014-01-22 13:05:02', '2014-01-22 13:05:02', 'ready', NULL),
(35, 13, 71, 32, 1, '1vIjo50gOLWVXEImxKuiaxofFBkWlyZelxX4LVyfSZ0=', '2014-01-22 13:05:18', '2014-01-23 11:31:39', 'ready', NULL),
(36, 13, 72, 33, 1, 'I0wYfQqNS7ZcgCjhfRw5PPt4Xhe3ZBpeNtDAjjcGFKU=', '2014-01-24 11:17:46', '2014-01-24 11:20:31', 'ready', NULL),
(37, 13, 72, 33, 1, 'I0wYfQqNS7ZcgCjhfRw5PK/e3ieBpFnsyHIFmqVtngJMyTXiicJOWcuJLu+TfBsO', '2014-01-24 11:18:11', '2014-01-24 11:20:50', 'ready', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_reference` varchar(250) NOT NULL,
  `task_description` text NOT NULL,
  `project_type` varchar(128) NOT NULL,
  `remarks` varchar(48) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `project_id`, `user_id`, `project_reference`, `task_description`, `project_type`, `remarks`, `created`, `modified`) VALUES
(4, 123, 44, 'cake php', 'cake', 'billing', 'completed', '2014-09-04 12:07:16', '2014-09-04 12:07:16'),
(5, 0, 44, 'test', 'test', 'fixed', 'completed', '2014-09-09 12:09:14', '2014-09-05 12:09:14'),
(6, 34, 45, 'cake php', 'cake php', 'fixed', 'pending', '2014-09-05 11:26:34', '2014-09-05 11:26:34');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE IF NOT EXISTS `tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `name`, `status`) VALUES
(27, 'anjana', '0'),
(26, 'user1', '0'),
(25, 'test', '0');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(55) NOT NULL,
  `topic` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `presentator` varchar(250) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `email` varchar(250) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `user_id`, `topic`, `description`, `presentator`, `start_time`, `end_time`, `email`, `created`, `modified`) VALUES
(1, '44', 'test', 'test', 'test', '2014-09-04 11:28:00', '2014-09-04 11:28:00', 'anjana.sharma@trigma.in', '2014-09-04 05:58:53', '2014-09-04 05:58:53');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
