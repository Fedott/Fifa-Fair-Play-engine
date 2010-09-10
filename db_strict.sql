SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `clubs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `clubs` (`id`, `name`, `url`, `logo`) VALUES
(1, 'Зенит', 'zenit', '10.jpeg'),
(2, 'Udinese', 'udinese', '4c83e40dc18341he4J0nCWQ7CnbE.jpg'),
(3, 'Lazio', 'lazio', ''),
(4, 'ЦСКА', 'cska', ''),
(5, 'Спартак Москва', 'spartak-moskva', ''),
(6, 'Сатурн', 'saturn', '');

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `date` int(11) NOT NULL,
  `author_id` int(10) unsigned NOT NULL,
  `match_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `comments` (`id`, `text`, `date`, `author_id`, `match_id`) VALUES
(1, 'Твержу', 2010, 2, 2),
(2, 'Блин продул =(', 0, 1, 3),
(3, 'Сложно что-то сказать.', 0, 1, 5);

CREATE TABLE IF NOT EXISTS `goals` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` int(11) unsigned NOT NULL,
  `player_id` int(10) unsigned NOT NULL,
  `table_id` int(10) unsigned NOT NULL,
  `line_id` int(10) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `match_id` (`match_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

INSERT INTO `goals` (`id`, `match_id`, `player_id`, `table_id`, `line_id`, `count`) VALUES
(1, 2, 3, 1, 1, 1),
(2, 2, 8, 1, 2, 1),
(3, 6, 8, 1, 2, 1),
(4, 6, 6, 1, 3, 1),
(5, 7, 4, 1, 1, 1);

CREATE TABLE IF NOT EXISTS `lines` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `table_id` int(11) unsigned DEFAULT NULL,
  `club_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `games` int(11) NOT NULL,
  `win` int(11) NOT NULL,
  `drawn` int(11) NOT NULL,
  `lose` int(11) NOT NULL,
  `goals` int(11) NOT NULL,
  `passed_goals` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

INSERT INTO `lines` (`id`, `table_id`, `club_id`, `user_id`, `games`, `win`, `drawn`, `lose`, `goals`, `passed_goals`, `points`) VALUES
(1, 1, 1, 1, 1, 0, 1, 0, 1, 1, 1),
(2, 1, 2, 2, 1, 0, 1, 0, 1, 1, 1),
(3, 1, 3, NULL, 0, 0, 0, 0, 0, 0, 0),
(4, 2, 1, NULL, 0, 0, 0, 0, 0, 0, 0),
(5, 2, 2, 1, 0, 0, 0, 0, 0, 0, 0),
(6, 2, 3, NULL, 0, 0, 0, 0, 0, 0, 0),
(7, 1, 4, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 1, 5, NULL, 0, 0, 0, 0, 0, 0, 0),
(9, 1, 6, NULL, 0, 0, 0, 0, 0, 0, 0),
(10, 2, 4, 2, 0, 0, 0, 0, 0, 0, 0),
(11, 2, 5, NULL, 0, 0, 0, 0, 0, 0, 0),
(12, 2, 6, NULL, 0, 0, 0, 0, 0, 0, 0);

CREATE TABLE IF NOT EXISTS `matches` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(11) unsigned DEFAULT NULL,
  `table_id` int(11) unsigned NOT NULL,
  `home_id` int(11) unsigned DEFAULT NULL,
  `away_id` int(11) unsigned DEFAULT NULL,
  `home_goals` int(10) unsigned NOT NULL,
  `away_goals` int(10) unsigned NOT NULL,
  `confirm` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

INSERT INTO `matches` (`id`, `date`, `table_id`, `home_id`, `away_id`, `home_goals`, `away_goals`, `confirm`) VALUES
(2, 1283708488, 1, 1, 2, 1, 1, 1),
(6, 1283949911, 1, 2, 3, 1, 1, 0),
(7, 1283959153, 1, 1, 2, 1, 0, 0);

CREATE TABLE IF NOT EXISTS `players` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(70) DEFAULT NULL,
  `last_name` varchar(70) NOT NULL,
  `year_of_birth` int(4) NOT NULL DEFAULT '0',
  `club_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `first_name` (`first_name`,`last_name`,`year_of_birth`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

INSERT INTO `players` (`id`, `first_name`, `last_name`, `year_of_birth`, `club_id`) VALUES
(1, 'Вячеслав', 'Малафеев', 0, 1),
(2, 'Александр', 'Анюков', 0, 1),
(3, '', 'Данни', 0, 1),
(4, 'Александро', 'Розина', 0, 1),
(5, 'Юрий', 'Жевнов', 0, 1),
(6, 'Tomaso', 'Rocchi', 0, 3),
(8, 'Ivanov', 'Petr', 0, 2);

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'login', 'Возможность логинеться'),
(2, 'admin', 'Права администратора'),
(3, 'coach', 'Может быть тренером');

CREATE TABLE IF NOT EXISTS `roles_users` (
  `user_id` int(11) unsigned NOT NULL,
  `role_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(1, 2),
(1, 3),
(2, 3);

CREATE TABLE IF NOT EXISTS `tables` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `type` enum('friendly','official') NOT NULL,
  `season` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ended` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `matches` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `tables` (`id`, `name`, `url`, `type`, `season`, `active`, `visible`, `ended`, `matches`) VALUES
(1, 'Предсезонка', 'predsezonka', 'friendly', NULL, 1, 1, 0, 2),
(2, 'Первый сезон', 'pervwy-sezon', 'official', NULL, 0, 1, 0, 2);

CREATE TABLE IF NOT EXISTS `trophies` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `line_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `club_id` int(11) unsigned DEFAULT NULL,
  `table_id` int(11) unsigned DEFAULT NULL,
  `player_id` int(11) unsigned DEFAULT NULL,
  `weight` tinyint(4) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `trophies` (`id`, `description`, `line_id`, `user_id`, `club_id`, `table_id`, `player_id`, `weight`, `image`) VALUES
(1, 'Кубок Чемпиона', NULL, NULL, NULL, 1, NULL, 1, '4c7ca6655c2c0Screenshot.png');

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(127) NOT NULL,
  `username` varchar(32) NOT NULL DEFAULT '',
  `password` char(50) NOT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(10) unsigned DEFAULT NULL,
  `icq` int(11) unsigned NOT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`),
  UNIQUE KEY `icq` (`icq`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `users` (`id`, `email`, `username`, `password`, `logins`, `last_login`, `icq`, `first_name`, `last_name`, `avatar`) VALUES
(1, 'fedotru@gmail.com', 'Федот', '6dc288f11444c62cd60b54db803d1ffe86abeb063c9ea417b3', 29, 1284101704, 7372085, 'Владимир', 'Фёдоров', ''),
(2, 'test@qwe.er', 'test', '6dc288f11444c62cd60b54db803d1ffe86abeb063c9ea417b3', 9, 1284047658, 233123, '', '', '4c8903bd0ab4e3.jpg');

CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(32) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

INSERT INTO `user_tokens` (`id`, `user_id`, `user_agent`, `token`, `created`, `expires`) VALUES
(1, 1, 'c8900548171c2227f7d7621fbc10b977624eff72', 'nMuCJqnJf77OtrQceb5eu8gbHGclUcMl', 1282822803, 1284032403),
(3, 1, 'ff973ef53520da8a8800409721398f1f9e9c8d2a', 'jYPsRrUmVBO3YlTCTQAFhxJaYA5gy4Vw', 1283262938, 1284472538),
(5, 2, '948e2716280bf7a15fe83405f3a8a914043e75a8', '0HlQTbnWFR5SB5eNecsBF2GPF24m9yV7', 1283713921, 1284923521),
(6, 1, '4de460a499da6d94fc265b15efc395ff5a0633c5', '9CT3RtG1Bd0A5y5L1jkVVFNw2ObTPZH7', 1283735635, 1284945235);


ALTER TABLE `goals`
  ADD CONSTRAINT `goals_ibfk_1` FOREIGN KEY (`match_id`) REFERENCES `matches` (`id`) ON DELETE CASCADE;

ALTER TABLE `roles_users`
  ADD CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
