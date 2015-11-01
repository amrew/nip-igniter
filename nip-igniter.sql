-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2015 at 04:25 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nip-igniter-v3`
--
CREATE DATABASE IF NOT EXISTS `nip-igniter-v3` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `nip-igniter-v3`;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `parent_menu_id` int(255) DEFAULT '0',
  `controller` varchar(255) NOT NULL,
  `params` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT '0',
  `icon` varchar(50) DEFAULT NULL,
  `core` int(11) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `title`, `url`, `parent_menu_id`, `controller`, `params`, `order`, `icon`, `core`, `created`, `updated`, `deleted`) VALUES
(1, 'Role', 'admin/role', 5, 'RoleController', '', 1, 'fa fa-table', 1, '2015-03-17 16:38:10', '2015-04-04 16:58:47', NULL),
(2, 'Status', 'admin/status', 5, 'StatusController', '', 2, 'fa fa-table', 1, '2015-03-17 16:41:01', '2015-04-04 16:58:53', NULL),
(3, 'User', 'admin/user', 5, 'UserController', '', 0, 'fa fa-table', 1, '2015-03-17 16:41:33', '2015-04-04 16:58:41', NULL),
(4, 'Menu', 'admin/menu', 10, 'MenuController', '', 3, 'fa fa-table', 1, '2015-03-17 16:43:16', '2015-04-22 19:36:11', NULL),
(5, 'User', '#', 0, '', '', 98, 'fa fa-unlock-alt', 0, '2015-03-19 16:39:21', '2015-05-02 08:14:02', NULL),
(6, 'Privilege', 'admin/privilege', 10, 'PrivilegeController', '', 4, 'fa fa-table', 1, '2015-04-04 16:37:36', '2015-04-22 19:36:24', NULL),
(10, 'Hak Akses', '#', 0, '', '', 99, 'fa fa-gavel', 0, '2015-04-22 19:35:39', '2015-05-02 08:14:09', NULL),
(30, 'Settings', '#', 0, '', '', 100, 'fa fa-gear', 0, '2015-05-01 22:03:08', '2015-11-01 17:03:00', NULL),
(44, 'General', 'admin/setting', 30, 'SettingController', '', 0, 'fa fa-table', 1, '2015-05-03 20:12:47', '2015-05-03 20:12:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `privilege`
--

CREATE TABLE IF NOT EXISTS `privilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `view` varchar(1) NOT NULL,
  `create` varchar(1) NOT NULL,
  `update` varchar(1) NOT NULL,
  `delete` varchar(1) NOT NULL,
  `trash` varchar(1) NOT NULL,
  `restore` varchar(1) NOT NULL,
  `delete_permanent` varchar(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `privilege`
--

INSERT INTO `privilege` (`id`, `menu_id`, `role_id`, `view`, `create`, `update`, `delete`, `trash`, `restore`, `delete_permanent`, `created`, `updated`, `deleted`) VALUES
(37, 1, 1, '1', '1', '1', '0', '0', '0', '0', '2015-10-27 21:43:19', '2015-10-27 21:43:19', NULL),
(38, 2, 1, '1', '1', '1', '0', '0', '0', '0', '2015-10-27 21:43:19', '2015-10-27 21:43:19', NULL),
(39, 3, 1, '1', '1', '1', '1', '1', '0', '0', '2015-10-27 21:43:19', '2015-10-27 21:43:19', NULL),
(40, 4, 1, '1', '1', '1', '1', '1', '1', '1', '2015-10-27 21:43:19', '2015-10-27 21:43:19', NULL),
(41, 6, 1, '1', '1', '0', '0', '0', '0', '0', '2015-10-27 21:43:19', '2015-10-27 21:43:19', NULL),
(42, 44, 1, '1', '1', '1', '1', '1', '1', '1', '2015-10-27 21:43:19', '2015-10-27 21:43:19', NULL),
(43, 45, 1, '1', '1', '1', '1', '1', '1', '1', '2015-10-27 21:43:19', '2015-10-27 21:43:19', NULL),
(44, 46, 1, '1', '1', '1', '1', '1', '1', '1', '2015-10-27 21:43:19', '2015-10-27 21:43:19', NULL),
(45, 47, 1, '1', '1', '1', '1', '1', '1', '1', '2015-10-27 21:43:19', '2015-10-27 21:43:19', NULL),
(46, 48, 1, '1', '1', '1', '1', '1', '1', '1', '2015-10-27 21:43:19', '2015-10-27 21:43:19', NULL),
(47, 49, 1, '1', '1', '1', '1', '1', '1', '1', '2015-10-27 21:43:19', '2015-10-27 21:43:19', NULL),
(48, 51, 1, '1', '1', '1', '1', '1', '1', '1', '2015-10-27 21:43:19', '2015-10-27 21:43:19', NULL),
(49, 52, 2, '1', '1', '1', '0', '0', '0', '0', '2015-10-27 21:43:48', '2015-10-27 21:43:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `title`, `created`, `updated`, `deleted`) VALUES
(1, 'Administrator', '2014-10-07 21:54:21', '2014-10-07 21:54:21', NULL),
(2, 'Member', '2014-10-07 21:54:28', '2015-05-01 16:44:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `title`, `created`, `updated`, `deleted`) VALUES
(1, 'Active', '2014-09-16 12:31:26', '2014-09-16 12:31:26', NULL),
(2, 'Non Active', '2014-09-16 12:31:34', '2014-09-16 12:31:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama`, `email`, `role_id`, `status_id`, `picture`, `created`, `updated`, `deleted`) VALUES
(1, 'admin', 'f865b53623b121fd34ee5426c792e5c33af8c227', 'Hanif Nur Amrullah', 'admin@nipstudio.com', 1, 1, './public/uploads/10261117_1439074583088362_676447915_n1.jpg', '2015-02-23 21:42:38', '2015-11-01 17:51:17', NULL),
(2, 'member', 'd5ba8948074cdbf36d17f61c8f3f077256e04fb3', 'Member Igniter', 'member@nipstudio.com', 2, 1, './public/uploads/10261117_1439074583088362_676447915_n.jpg', '2015-02-23 22:10:35', '2015-10-27 21:46:21', NULL),
(3, 'testing', '4c0d2b951ffabd6f9a10489dc40fc356ec1d26d5', NULL, 'testing@nipstudio.com', 2, 1, NULL, '2015-10-28 20:53:33', '2015-10-28 20:53:33', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
