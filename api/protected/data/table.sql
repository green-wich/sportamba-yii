DROP TABLE IF EXISTS `sport_command`;

CREATE TABLE IF NOT EXISTS `sport_command` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `img` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `sport_match`;

CREATE TABLE IF NOT EXISTS `sport_match` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_command_1` int(11) unsigned NOT NULL,
  `id_command_2` int(11) unsigned NOT NULL,
  `stadion_id` int(11) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_command_1` (`id_command_1`),
  KEY `fk_id_command_2` (`id_command_2`),
  KEY `fk_stadion_id` (`stadion_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `sport_user`;

CREATE TABLE IF NOT EXISTS `sport_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;

DROP TABLE IF EXISTS `sport_login`;

CREATE TABLE IF NOT EXISTS `sport_login` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `session_data` text NOT NULL,
  `created_at` datetime NOT NULL,
  `provider` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ifk_user_id` (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `password` (`password`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;

DROP TABLE IF EXISTS `sport_user_profile`;

CREATE TABLE IF NOT EXISTS `sport_user_profile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login_id` int(11) unsigned NOT NULL,
  `profileUrl` varchar(200) NOT NULL,
  `photoUrl` varchar(200) NOT NULL,
  `displayName` varchar(100) DEFAULT NULL,
  `firstName` varchar(60) NOT NULL,
  `lastName` varchar(60) NOT NULL,
  `gender` varchar(30) NOT NULL,
  `region` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ifk_login_id` (`login_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;

DROP TABLE IF EXISTS `sport_stadion`;

CREATE TABLE IF NOT EXISTS `sport_stadion` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `address` varchar(200) NOT NULL,
  `lat` varchar(75) NOT NULL,
  `long` varchar(75) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `sport_user_match`;

CREATE TABLE IF NOT EXISTS `sport_user_match` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `command_id` int(11) unsigned NOT NULL,
  `type_place_viewing` int(1) unsigned NOT NULL COMMENT '1-дома, 2-стадион, 3-бар',
  `place_viewing` varchar(75) NOT NULL,
  `permission_post` tinyint(1) DEFAULT NULL COMMENT '1-делаем пост в соц сеть',
  `result_post` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_match_id` (`match_id`),
  KEY `fk_user_id` (`user_id`),
  KEY `fk_command_id` (`command_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `sport_connection` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id_1` int(11) unsigned NOT NULL,
  `user_id_2` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_id_1` (`user_id_1`),
  KEY `fk_user_id_2` (`user_id_2`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `sport_news`;

CREATE TABLE IF NOT EXISTS `sport_news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `sport_user_news`;

CREATE TABLE IF NOT EXISTS `sport_user_news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `news_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkn_user_id` (`user_id`),
  KEY `fk_news_id` (`news_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
