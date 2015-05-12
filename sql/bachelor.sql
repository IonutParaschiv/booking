-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 12, 2015 at 04:02 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bachelor`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `surname` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `join_date` datetime NOT NULL,
  `salt` varchar(32) NOT NULL,
  `token` varchar(32) NOT NULL,
  `apiKey` varchar(32) NOT NULL,
  `parent` int(16) NOT NULL,
  `master` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `name`, `surname`, `email`, `password`, `join_date`, `salt`, `token`, `apiKey`, `parent`, `master`) VALUES
(1, 'Ionut', 'Paraschiv', 'ionut@htd.ro', 'de6d7af3ebb5c6cc2585d000a909994921f459f44b53461bf679af7f2f46e233', '2015-05-12 14:31:49', 'kXOtHe9LRGnDuzQp', '86e6ba8473b08ff258b23de7eac29ccb', '86e6ba8473b08ff258b23de7eac29ccb', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE IF NOT EXISTS `booking` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `company_id` int(16) NOT NULL,
  `staff_id` int(16) NOT NULL,
  `service_id` int(16) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `company_id`, `staff_id`, `service_id`, `start`, `end`) VALUES
(1, 1, 2, 2, '2015-03-24 18:31:22', '2015-03-24 20:31:22'),
(2, 1, 2, 2, '2015-03-24 18:31:22', '2015-03-24 20:31:22'),
(3, 1, 2, 2, '2015-03-24 18:31:22', '2015-03-24 20:31:22');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `account_id` int(16) NOT NULL,
  `name` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `address` text NOT NULL,
  `opening_h` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `account_id`, `name`, `email`, `address`, `opening_h`) VALUES
(1, 1, 'Some newly edited company', 'me@mynewcompany.com', 'myaddress', 'allday'),
(2, 2, 'Some newly edited company', 'me@mynewcompany.com', 'myaddress', 'allday'),
(3, 2, 'Some newly edited company', 'me@mynewcompany.com', 'myaddress', 'allday');

-- --------------------------------------------------------

--
-- Table structure for table `master_account`
--

CREATE TABLE IF NOT EXISTS `master_account` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `surname` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `join_date` datetime NOT NULL,
  `salt` varchar(32) NOT NULL,
  `token` varchar(32) NOT NULL,
  `apiKey` varchar(32) NOT NULL,
  `parent` int(16) DEFAULT NULL,
  `master` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `master_account`
--

INSERT INTO `master_account` (`id`, `name`, `surname`, `email`, `password`, `join_date`, `salt`, `token`, `apiKey`, `parent`, `master`) VALUES
(25, 'Master', 'master', 'master@api.com', '6b8f017287f6d7e3471def8b696ed397a4c7b18415485d5b16c4f1774f59b4b2', '2015-05-12 12:52:18', '77d2KEoe63QEsdSW', 'ec75c64b295ed40a799c924e663a807b', 'ec75c64b295ed40a799c924e663a807b', NULL, 0),
(30, 'second', 'master', 'second@api.com', '70e60bf3afa611e07335dff16b2abd4a8fb2e47ccf8ce56a540f4744f8d37c4d', '2015-05-12 14:19:09', 'TvfVN376LvUmpVKF', '86b2050f735ac0e7bad0d7b78e17f569', '86b2050f735ac0e7bad0d7b78e17f569', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE IF NOT EXISTS `service` (
  `id` int(16) NOT NULL,
  `company_id` int(16) NOT NULL,
  `name` varchar(32) NOT NULL,
  `price` int(32) NOT NULL,
  `description` text NOT NULL,
  `duration` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `company_id`, `name`, `price`, `description`, `duration`) VALUES
(0, 1, 'service name', 200, 'it is awesome', 100);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `company_id` int(16) NOT NULL,
  `name` varchar(32) NOT NULL,
  `surname` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `available_h` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `staffService`
--

CREATE TABLE IF NOT EXISTS `staffService` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `staff_id` int(16) NOT NULL,
  `service_id` int(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
