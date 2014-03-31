-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 01 2014 г., 02:15
-- Версия сервера: 5.5.35-0ubuntu0.13.10.2
-- Версия PHP: 5.5.3-1ubuntu2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `sportamba-yii`
--

-- --------------------------------------------------------

--
-- Структура таблицы `sport_commands`
--

CREATE TABLE IF NOT EXISTS `sport_commands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `img` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `sport_commands`
--


-- --------------------------------------------------------

--
-- Структура таблицы `sport_match`
--

CREATE TABLE IF NOT EXISTS `sport_match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_command1` int(11) NOT NULL,
  `id_command2` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  `url` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `img` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `sport_match`
--

INSERT INTO `sport_match` (`id`, `id_command1`, `id_command2`, `date`, `status`, `url`, `title`, `text`, `img`) VALUES
(1, 2, 1, '0000-00-00 00:00:00', 1, 'sfdfsf', 'fcdynamo', 'kjo', 'lkj');

-- --------------------------------------------------------

--
-- Структура таблицы `sport_user`
--

CREATE TABLE IF NOT EXISTS `sport_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `session_data` text NOT NULL,
  `created_at` datetime NOT NULL,
  `provider` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `sport_user`
--

INSERT INTO `sport_user` (`id`, `username`, `password`, `session_data`, `created_at`, `provider`, `status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '', '2014-03-31 00:00:00', '', 1),
(2, 'asdasd', 'asdasd', '', '2014-03-31 13:37:05', '', 1),
(3, 'qwer', '1q1q', '', '2014-03-31 13:53:34', '', 1),
(4, 'ttttt444', 'desc2', '', '2014-03-31 13:56:13', '', 1),
(5, '100003101458147', '42f15b6970f231a659c24a3613fd3a14', 'a:2:{s:35:"hauth_session.facebook.is_logged_in";s:4:"i:1;";s:41:"hauth_session.facebook.token.access_token";s:193:"s:184:"CAAU8OR2Due8BADkCeE0dDy8u9ZCiqoLa1xoJ4C3uVsVK58uaqucnHPDHQ9v3NGTLcb3BTe7pJUps06hd0aZAZC1E6Lhl4QqC7VWf4pAAZCZCQBVgJbHdWUJMmZCge46vUq78oZBvTFoIFPt64dDJEfubms1qJYncTqHW5tMAwlX9oG8tdCfWGO9";";}', '2014-03-31 22:54:29', 'Facebook', 1),
(8, '132747192', '215b1294238c575662687206552b6402', 'a:6:{s:42:"hauth_session.vkontakte.token.access_token";s:93:"s:85:"337bf4b4f0cdae71970bc361b0a71cbad9b2ebc09e29f4864a6639f4e07d8d821c4ef1cfa21c31120ee7a";";s:43:"hauth_session.vkontakte.token.refresh_token";s:7:"s:0:"";";s:40:"hauth_session.vkontakte.token.expires_in";s:8:"i:86397;";s:40:"hauth_session.vkontakte.token.expires_at";s:13:"i:1396383759;";s:31:"hauth_session.vkontakte.user_id";s:12:"i:132747192;";s:36:"hauth_session.vkontakte.is_logged_in";s:4:"i:1;";}', '2014-03-31 23:25:00', 'Vkontakte', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `sport_user_profile`
--

CREATE TABLE IF NOT EXISTS `sport_user_profile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `profileUrl` varchar(200) NOT NULL,
  `photoUrl` varchar(200) NOT NULL,
  `displayName` varchar(100) DEFAULT NULL,
  `firstName` varchar(60) NOT NULL,
  `lastName` varchar(60) NOT NULL,
  `gender` varchar(30) NOT NULL,
  `region` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `sport_user_profile`
--

INSERT INTO `sport_user_profile` (`id`, `user_id`, `profileUrl`, `photoUrl`, `displayName`, `firstName`, `lastName`, `gender`, `region`, `email`) VALUES
(1, 5, 'https://www.facebook.com/grischuk.sasha', 'https://graph.facebook.com/100003101458147/picture?width=150&height=150', 'Саша Грищук', 'Саша', 'Грищук', 'male', 'Krolevets', 'alexander.grischuk@yandex.ua'),
(2, 8, 'http://vk.com/grischuk_sasha', 'http://cs312618.vk.me/v312618192/3a70/8eNp6bxOFAg.jpg', '', 'Саша', 'Грищук', 'male', NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
