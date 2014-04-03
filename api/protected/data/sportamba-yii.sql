-- phpMyAdmin SQL Dump
-- version 4.0.6deb1

--
-- База данных: `sportamba-yii`
--

-- --------------------------------------------------------

/*
  ALTER TABLE `sport_match` DROP FOREIGN KEY `fk_id_command_1`;
  ALTER TABLE `sport_match` DROP KEY         `fk_id_command_1`;
  ALTER TABLE `sport_match` DROP FOREIGN KEY `fk_id_command_2`;
  ALTER TABLE `sport_match` DROP KEY         `fk_id_command_2`;
  ALTER TABLE `sport_match` DROP FOREIGN KEY `fk_stadion_id`;
  ALTER TABLE `sport_match` DROP KEY         `fk_stadion_id`;

  ALTER TABLE `sport_user_profile` DROP FOREIGN KEY `ifk_user_id`;
  ALTER TABLE `sport_user_profile` DROP KEY         `ifk_user_id`;
  
  ALTER TABLE `sport_user_match` DROP FOREIGN KEY `fk_match_id`;
  ALTER TABLE `sport_user_match` DROP KEY         `fk_match_id`;
  ALTER TABLE `sport_user_match` DROP FOREIGN KEY `fk_user_id`;
  ALTER TABLE `sport_user_match` DROP KEY         `fk_user_id`;
  ALTER TABLE `sport_user_match` DROP FOREIGN KEY `fk_command_id`;
  ALTER TABLE `sport_user_match` DROP KEY         `fk_command_id`;

  ALTER TABLE `sport_connection` DROP FOREIGN KEY `fk_user_id_1`;  
  ALTER TABLE `sport_connection` DROP KEY         `fk_user_id_1`;
  ALTER TABLE `sport_connection` DROP FOREIGN KEY `fk_user_id_2`;
  ALTER TABLE `sport_connection` DROP KEY         `fk_user_id_2`;
 */
  
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
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `session_data` text NOT NULL,
  `created_at` datetime NOT NULL,
  `provider` varchar(20) NOT NULL,
  `role` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `password` (`password`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;

DROP TABLE IF EXISTS `sport_user_profile`;

CREATE TABLE IF NOT EXISTS `sport_user_profile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `profileUrl` varchar(200) NOT NULL,
  `photoUrl` varchar(200) NOT NULL,
  `displayName` varchar(100) DEFAULT NULL,
  `firstName` varchar(60) NOT NULL,
  `lastName` varchar(60) NOT NULL,
  `gender` varchar(30) NOT NULL,
  `region` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ifk_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `sport_user` (`id`, `username`, `password`, `session_data`, `created_at`, `provider`, `role`, `status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '', '2014-03-31 00:00:00', '', 'admin', 1);

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

ALTER TABLE `sport_connection`
  ADD CONSTRAINT `fk_user_id_1` FOREIGN KEY (`user_id_1`) REFERENCES `sport_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_id_2` FOREIGN KEY (`user_id_2`) REFERENCES `sport_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `sport_user_match`
  ADD CONSTRAINT `fk_match_id` FOREIGN KEY (`match_id`) REFERENCES `sport_match` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `sport_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_command_id` FOREIGN KEY (`command_id`) REFERENCES `sport_command` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `sport_match`
  ADD CONSTRAINT `fk_id_command_1` FOREIGN KEY (`id_command_1`) REFERENCES `sport_command` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_command_2` FOREIGN KEY (`id_command_2`) REFERENCES `sport_command` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stadion_id` FOREIGN KEY (`stadion_id`) REFERENCES `sport_stadion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `sport_user_profile`
  ADD CONSTRAINT `ifk_user_id` FOREIGN KEY (`user_id`) REFERENCES `sport_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
