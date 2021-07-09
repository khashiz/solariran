--
-- Table structure for table `#__hd_profile_field`
--

DROP TABLE IF EXISTS `#__hd_profile_field`;
CREATE TABLE `#__hd_profile_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profileid` int(11) NOT NULL,
  `column` varchar(255) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `profileid_2` (`profileid`,`column`),
  KEY `profileid` (`profileid`),
  KEY `column` (`column`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `#__hd_profile_field`
--

INSERT INTO `#__hd_profile_field` (`id`, `profileid`, `column`, `params`) VALUES
(3, 1, 'catid', '{"type":"reference","table":"#__categories","reftext":"title"}'),
(1, 1, 'title', '{"type":"file","format":"string"}'),
(2, 1, 'fulltext', '{"type":"file","format":"string"}'),
(4, 1, 'alias', '{"type":"file","format":"urlsafe"}'),
(5, 1, 'introtext', '{"type":"file","format":"string"}'),
(10, 1, 'state', '{"type":"defined","default":"1"}'),
(6, 1, 'created', '{"type":"file","format":"date"}'),
(7, 1, 'created_by', '{"type":"reference","table":"#__users","reftext":"email"}'),
(8, 1, 'access', '{"type":"defined","default":"1"}'),
(9, 1, 'language', '{"type":"defined","default":"*"}');