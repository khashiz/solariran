--
-- Table structure for table `#__hd_profiles`
--

DROP TABLE IF EXISTS `#__hd_profiles`;
CREATE TABLE `#__hd_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pluginid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------