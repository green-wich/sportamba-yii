-- phpMyAdmin SQL Dump
-- version 4.0.6deb1

--
-- База данных: `sportamba-yii`
--

-- --------------------------------------------------------

--
-- Структура таблицы `sport_command`
--

--  ALTER TABLE `sport_match` DROP FOREIGN KEY `fk_id_command_1`;
--  ALTER TABLE `sport_match` DROP KEY `fk_id_command_1`;
--  ALTER TABLE `sport_match` DROP FOREIGN KEY `fk_id_command_2`;
--  ALTER TABLE `sport_match` DROP KEY `fk_id_command_2`;
--  ALTER TABLE `sport_user_profile` DROP FOREIGN KEY `fk_user_id`;
--  ALTER TABLE `sport_user_profile` DROP KEY `fk_user_id`;
--  ALTER TABLE `sport_user_profile` DROP FOREIGN KEY `fk_stadion_id`;
--  ALTER TABLE `sport_user_profile` DROP KEY `fk_stadion_id`;


DROP TABLE IF EXISTS `sport_command`;

CREATE TABLE IF NOT EXISTS `sport_command` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `img` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Структура таблицы `sport_match`
--

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


--
-- Структура таблицы `sport_user`
--

DROP TABLE IF EXISTS `sport_user`;

CREATE TABLE IF NOT EXISTS `sport_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `session_data` text NOT NULL,
  `created_at` datetime NOT NULL,
  `provider` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `password` (`password`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;

-- --------------------------------------------------------

--
-- Структура таблицы `sport_user_profile`
--

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
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

ALTER TABLE `sport_user_profile`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `sport_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Дамп данных таблицы `sport_user`
--

INSERT INTO `sport_user` (`id`, `username`, `password`, `session_data`, `created_at`, `provider`, `status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '', '2014-03-31 00:00:00', '', 1);


DROP TABLE IF EXISTS `sport_stadion`;

CREATE TABLE IF NOT EXISTS `sport_stadion` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `address` varchar(200) NOT NULL,
  `lat` varchar(75) NOT NULL,
  `long` varchar(75) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `sport_match`
  ADD CONSTRAINT `fk_id_command_1` FOREIGN KEY (`id_command_1`) REFERENCES `sport_command` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_command_2` FOREIGN KEY (`id_command_2`) REFERENCES `sport_command` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_stadion_id` FOREIGN KEY (`stadion_id`) REFERENCES `sport_stadion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
