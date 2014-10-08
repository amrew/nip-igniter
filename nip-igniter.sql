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
(2, 'Member', '2014-10-07 21:54:28', '2014-10-07 21:54:28', NULL);

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
  `email` varchar(255) NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `role_id`, `status_id`, `created`, `updated`, `deleted`) VALUES
(1, 'admin', 'f865b53623b121fd34ee5426c792e5c33af8c227', 'admin@example.com', 1, 1, '2014-09-16 12:37:06', '2014-10-08 21:08:02', NULL);