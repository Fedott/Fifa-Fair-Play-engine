SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `clubs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `date` int(11) NOT NULL,
  `author_id` int(11) unsigned NOT NULL,
  `match_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `match_id` (`match_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `goals` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` int(11) unsigned NOT NULL,
  `player_id` int(11) unsigned NOT NULL,
  `table_id` int(11) unsigned NOT NULL,
  `line_id` int(11) unsigned NOT NULL,
  `count` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `match_id` (`match_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `matches` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(11) unsigned DEFAULT NULL,
  `table_id` int(11) unsigned NOT NULL,
  `home_id` int(11) unsigned DEFAULT NULL,
  `away_id` int(11) unsigned DEFAULT NULL,
  `home_goals` int(11) unsigned NOT NULL,
  `away_goals` int(11) unsigned NOT NULL,
  `confirm` tinyint(1) NOT NULL,
  `tech` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
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

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `date` int(11) unsigned NOT NULL,
  `author_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date` int(11) unsigned NOT NULL,
  `author_id` int(11) unsigned NOT NULL,
  `category_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `players` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(70) DEFAULT NULL,
  `last_name` varchar(70) NOT NULL,
  `year_of_birth` int(4) NOT NULL DEFAULT '0',
  `club_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `first_name` (`first_name`,`last_name`,`year_of_birth`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `text` text NOT NULL,
  `date` int(11) unsigned NOT NULL,
  `topic_id` int(11) unsigned NOT NULL,
  `author_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `roles_users` (
  `user_id` int(11) unsigned NOT NULL,
  `role_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

/* 17.02.13 */
ALTER TABLE `tables` ADD `scheduled` tinyint(1) NOT NULL;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(127) NOT NULL,
  `username` varchar(32) NOT NULL DEFAULT '',
  `password` char(50) NOT NULL,
  `logins` int(11) unsigned NOT NULL DEFAULT '0',
  `last_login` int(11) unsigned DEFAULT NULL,
  `icq` int(11) unsigned DEFAULT NULL,
  `skype` varchar(32) DEFAULT NULL,
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
  UNIQUE KEY `icq` (`icq`),
  UNIQUE KEY `skype` (`skype`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

/*  13.11.12 */
ALTER TABLE `users` ADD `origin` VARCHAR( 32 ) NULL DEFAULT NULL AFTER `skype` ,
ADD UNIQUE (
`origin`
);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `pro_players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(255) NOT NULL,
  `games` int(11) NOT NULL,
  `goals` int(11) NOT NULL,
  `assists` int(11) NOT NULL,
  `shots` int(11) NOT NULL,
  `passes` int(11) NOT NULL,
  `tackles` int(11) NOT NULL,
  `season` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nick` (`nick`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`match_id`) REFERENCES `matches` (`id`) ON DELETE CASCADE;

ALTER TABLE `goals`
  ADD CONSTRAINT `goals_ibfk_1` FOREIGN KEY (`match_id`) REFERENCES `matches` (`id`) ON DELETE CASCADE;

ALTER TABLE `roles_users`
  ADD CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
