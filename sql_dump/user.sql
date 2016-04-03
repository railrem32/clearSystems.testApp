-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 03 2016 г., 18:07
-- Версия сервера: 5.5.47-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `yii2basic`
--

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_token` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `surname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `thumb_image` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `city_id` (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `access_token`, `email`, `name`, `surname`, `phone`, `password`, `city_id`, `image`, `thumb_image`) VALUES
(7, 'ErPN0ff2x9GTR4nib4Kff41Ks11NF2wN', 'railrem@yandex.ru', 'railreefr', 'hisamutdinov', '+795020392402', '$2y$13$JB8849VkJpYHT.qI0Qsfv.5UkIT/vH2rR9msW2Y2C0.C3pYJ8PXFy', 17, '/image/avatar/imagакакeszFTsN7.jpg', '/image/avatar/thumbs/imagакакeszFTsN7.jpg'),
(10, 'bITmIPkWIZGpoLIiIdfScerPk3qMCsvw', 'rail@rail.ru', 'Rail', 'Khisamutdinov', '+79520392402', '$2y$13$m56NEyvQzb2W0xU3/62R3.1yHJBqOx/j290d3GSI8JKr4GIfU46VG', 16, '/image/avatar/imagesfZ86Sd.jpg', '/image/avatar/thumbs/imagesfZ86Sd.jpg'),
(12, 'gSmQuKQJthVrxwBMvQ2F6Vn0boKBugB6', 'ralina@ralina.ru', 're', '', '', '$2y$13$eDx7G3Ot0/Uj/1IeP5lqmOV1q3G6itOSzgkOIO0WFbHIRmNmky8SK', NULL, '/image/avatar/ проеткаYfAkQ2.png', '/image/avatar/thumbs/ проеткаYfAkQ2.png'),
(13, '64J2hDgNpDssIe-07ROEyTGFVngD34gm', 'raiz@raiz.ru', 'Раяз', 'Хисамутдинов', '', '$2y$13$Cc9tJKyqJBKWayVRlTI5LOyeTzK9YMgtZraONrBkW1IcpaLsWBpUq', 16, '/image/avatar/imageskB49hQ.jpg', '/image/avatar/thumbs/imageskB49hQ.jpg'),
(14, 'm9pFrZajQPmVurxqR3xHP2AQMUAqHdcT', 'ra@ra.tet', 'raa', 'ra', '89632211975', '$2y$13$MzaAzDyelFylPmBEGZ8pIOtUOZuQrpe2HoHxEg7SIEeh69F7.nYNS', 17, '/image/avatar/ проеткаSSTnNF.png', '/image/avatar/thumbs/ проеткаSSTnNF.png');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
