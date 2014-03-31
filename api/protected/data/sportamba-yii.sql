-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 31 2014 г., 12:43
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
  `description` text NOT NULL,
  `img` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `sport_commands`
--

INSERT INTO `sport_commands` (`id`, `name`, `description`, `img`) VALUES
(1, 'Динамо', 'Динамо', 'Динамо'),
(2, 'Шахтер', 'Шахтер', 'Шахтер'),
(3, 'Манчестер', 'Манчестер', 'Манчестер');

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
  `created_at` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `sport_user`
--

INSERT INTO `sport_user` (`id`, `username`, `password`, `created_at`, `status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '2014-03-31 00:00:00', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
