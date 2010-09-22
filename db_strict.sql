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
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `date` int(11) NOT NULL,
  `author_id` int(11) unsigned NOT NULL,
  `match_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `match_id` (`match_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `comments` (`id`, `text`, `date`, `author_id`, `match_id`) VALUES
(1, 'Твержу', 2010, 2, 2),
(5, 'Отличный матч', 1284112646, 1, 9),
(6, '<u>Вот</u> <sup>такой</sup><sub>хуйня =)</sub><br /><h3>ываыва</h3>', 1284206098, 1, 10);
DROP TRIGGER IF EXISTS `increment_count_comments`;
DELIMITER //
CREATE TRIGGER `increment_count_comments` AFTER INSERT ON `comments`
 FOR EACH ROW BEGIN
	UPDATE `users` SET comments = comments + 1 WHERE `id` = NEW.author_id;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `unincrement_count_comments`;
DELIMITER //
CREATE TRIGGER `unincrement_count_comments` AFTER DELETE ON `comments`
 FOR EACH ROW BEGIN
	UPDATE `users` SET comments = comments - 1 WHERE `id` = OLD.author_id;
END
//
DELIMITER ;

CREATE TABLE IF NOT EXISTS `forums` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `role_id` int(11) unsigned NOT NULL,
  `weight` int(11) NOT NULL,
  `count_topics` int(11) unsigned NOT NULL,
  `count_posts` int(11) unsigned NOT NULL,
  `section_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `forums` (`id`, `name`, `description`, `role_id`, `weight`, `count_topics`, `count_posts`, `section_id`) VALUES
(1, 'Премьер лига', 'Вот она премьер лига нашего чемпионата.', 3, 0, 1, 4, 1),
(2, 'Первый дивизион', 'Первый дивизион нашего чемпионата.<br />Есть все шансы на выход в Премьеру.', 3, 0, 0, 0, 1),
(3, 'РПЛ', 'Обуждение Росийской препьер лиги', 1, 0, 0, 0, 2);

CREATE TABLE IF NOT EXISTS `goals` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` int(11) unsigned NOT NULL,
  `player_id` int(11) unsigned NOT NULL,
  `table_id` int(11) unsigned NOT NULL,
  `line_id` int(11) unsigned NOT NULL,
  `count` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `match_id` (`match_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

INSERT INTO `goals` (`id`, `match_id`, `player_id`, `table_id`, `line_id`, `count`) VALUES
(1, 2, 3, 1, 1, 1),
(2, 2, 8, 1, 2, 1),
(3, 6, 8, 1, 2, 1),
(4, 6, 6, 1, 3, 1),
(6, 8, 3, 1, 1, 1),
(7, 8, 4, 1, 1, 1),
(8, 8, 2, 1, 1, 1),
(9, 9, 3, 1, 1, 1);

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
  `home_goals` int(11) unsigned NOT NULL,
  `away_goals` int(11) unsigned NOT NULL,
  `confirm` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

INSERT INTO `matches` (`id`, `date`, `table_id`, `home_id`, `away_id`, `home_goals`, `away_goals`, `confirm`) VALUES
(2, 1283708488, 1, 1, 2, 1, 1, 1),
(6, 1283949911, 1, 2, 3, 1, 1, 0),
(8, 1284112553, 1, 1, 8, 3, 0, 0),
(9, 1284112646, 1, 1, 7, 1, 0, 0),
(10, 1284206098, 1, 1, 7, 0, 0, 0);
DROP TRIGGER IF EXISTS `increment_count_matches`;
DELIMITER //
CREATE TRIGGER `increment_count_matches` AFTER INSERT ON `matches`
 FOR EACH ROW BEGIN
	UPDATE `users` SET matches = matches + 1 WHERE `id` = (SELECT `user_id` FROM `lines` WHERE `id` = NEW.home_id);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `unincrement_count_matches`;
DELIMITER //
CREATE TRIGGER `unincrement_count_matches` AFTER DELETE ON `matches`
 FOR EACH ROW BEGIN
	UPDATE `users` SET matches = matches - 1 WHERE `id` = (SELECT `user_id` FROM `lines` WHERE `id` = OLD.home_id);
	UPDATE `users` SET matches = matches - OLD.confirm WHERE `id` = (SELECT `user_id` FROM `lines` WHERE `id` = OLD.away_id);
END
//
DELIMITER ;

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

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `text` text NOT NULL,
  `date` int(11) unsigned NOT NULL,
  `topic_id` int(11) unsigned NOT NULL,
  `author_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

INSERT INTO `posts` (`id`, `title`, `text`, `date`, `topic_id`, `author_id`) VALUES
(1, 'Тест', 'Тест ёлки палки =)<br /><a href="http://fko3.fifafairplay.ru">вот сюда ходи</a>', 1284985705, 1, 1),
(2, 'Пипец', 'qweqweqw<br>Точно =)', 1285102032, 1, 1),
(3, '', 'dsgsdfgsfg', 1285105381, 1, 1),
(4, '', 'dsgsdfgsfg<br>hu<br>jg<br>hj<br>fgh<br>j<br>fghjf<br>ghj<br>fgh<br>j<br>fgh<br>j<br>fghjf<br>ghj<br>fghj', 1285110800, 1, 1);
DROP TRIGGER IF EXISTS `increment_count_posts`;
DELIMITER //
CREATE TRIGGER `increment_count_posts` AFTER INSERT ON `posts`
 FOR EACH ROW BEGIN
	UPDATE `topics` SET `count_posts` = `count_posts` + 1 WHERE `id` = NEW.topic_id;
	UPDATE `forums` SET `count_posts` = `count_posts` + 1 WHERE `id` = (SELECT `topics`.`forum_id` FROM `topics` WHERE `id` = NEW.topic_id);
	UPDATE `users` SET `posts` = `posts` + 1 WHERE `id` = NEW.author_id;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `unincrement_count_posts`;
DELIMITER //
CREATE TRIGGER `unincrement_count_posts` AFTER DELETE ON `posts`
 FOR EACH ROW BEGIN
	UPDATE `topics` SET `count_posts` = `count_posts` - 1 WHERE `id` = OLD.topic_id;
	UPDATE `forums` SET `count_posts` = `count_posts` - 1 WHERE `id` = (SELECT `topics`.`forum_id` FROM `topics` WHERE `id` = OLD.topic_id);
	UPDATE `users` SET `posts` = `posts` - 1 WHERE `id` = OLD.author_id;
END
//
DELIMITER ;

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

CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `sections` (`id`, `name`, `weight`) VALUES
(1, 'Чемпионат Красивый футбол', -1),
(2, 'Реальный футбол', 0);

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

CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `count_posts` int(11) unsigned NOT NULL,
  `count_views` int(11) unsigned NOT NULL,
  `date` int(11) unsigned NOT NULL,
  `forum_id` int(11) unsigned NOT NULL,
  `author_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `topics` (`id`, `title`, `description`, `count_posts`, `count_views`, `date`, `forum_id`, `author_id`) VALUES
(1, 'Тест', NULL, 4, 0, 1284985705, 1, 1);
DROP TRIGGER IF EXISTS `increment_count_topics`;
DELIMITER //
CREATE TRIGGER `increment_count_topics` AFTER INSERT ON `topics`
 FOR EACH ROW BEGIN
	UPDATE `forums` SET `count_topics` = `count_topics` + 1 WHERE `id` = NEW.forum_id;
	UPDATE `users` SET `posts` = `posts` + 1 WHERE `id` = NEW.author_id;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `unincrement_count_topics`;
DELIMITER //
CREATE TRIGGER `unincrement_count_topics` AFTER DELETE ON `topics`
 FOR EACH ROW BEGIN
	UPDATE `forums` SET `count_topics` = `count_topics` - 1 WHERE `id` = OLD.forum_id;
	UPDATE `users` SET `posts` = `posts` - 1 WHERE `id` = OLD.author_id;
END
//
DELIMITER ;

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
  `logins` int(11) unsigned NOT NULL DEFAULT '0',
  `last_login` int(11) unsigned DEFAULT NULL,
  `icq` int(11) unsigned NOT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `comments` int(11) unsigned NOT NULL DEFAULT '0',
  `posts` int(11) unsigned NOT NULL DEFAULT '0',
  `matches` int(11) unsigned NOT NULL DEFAULT '0',
  `topics` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`),
  UNIQUE KEY `icq` (`icq`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `users` (`id`, `email`, `username`, `password`, `logins`, `last_login`, `icq`, `first_name`, `last_name`, `avatar`, `comments`, `posts`, `matches`, `topics`) VALUES
(1, 'fedotru@gmail.com', 'Федот', '6dc288f11444c62cd60b54db803d1ffe86abeb063c9ea417b3', 36, 1285102011, 7372085, 'Владимир', 'Фёдоров', '4c89f786dc2b5dwW0d9987Dj1pWW.gif', 0, 4, 0, 0),
(2, 'test@qwe.er', 'test', '6dc288f11444c62cd60b54db803d1ffe86abeb063c9ea417b3', 10, 1284293502, 233123, '', '', '4c8903bd0ab4e3.jpg', 0, 0, 0, 0);

CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(32) NOT NULL,
  `created` int(11) unsigned NOT NULL,
  `expires` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `user_tokens` (`id`, `user_id`, `user_agent`, `token`, `created`, `expires`) VALUES
(1, 1, 'c8900548171c2227f7d7621fbc10b977624eff72', 'nMuCJqnJf77OtrQceb5eu8gbHGclUcMl', 1282822803, 1284032403),
(3, 1, 'ff973ef53520da8a8800409721398f1f9e9c8d2a', 'jYPsRrUmVBO3YlTCTQAFhxJaYA5gy4Vw', 1283262938, 1284472538),
(5, 2, '948e2716280bf7a15fe83405f3a8a914043e75a8', 'UES8Wj1NIOzzr6M9s5yAP5zSg2dBWdLz', 1283713921, 1284923521),
(6, 1, '4de460a499da6d94fc265b15efc395ff5a0633c5', '9CT3RtG1Bd0A5y5L1jkVVFNw2ObTPZH7', 1283735635, 1284945235);


ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`match_id`) REFERENCES `matches` (`id`) ON DELETE CASCADE;

ALTER TABLE `goals`
  ADD CONSTRAINT `goals_ibfk_1` FOREIGN KEY (`match_id`) REFERENCES `matches` (`id`) ON DELETE CASCADE;

ALTER TABLE `roles_users`
  ADD CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
