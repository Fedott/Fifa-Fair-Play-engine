SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'login', 'Возможность логинеться'),
(2, 'admin', 'Права администратора'),
(3, 'coach', 'Может быть тренером');

INSERT INTO `users` (`id`, `email`, `username`, `password`, `logins`, `last_login`, `icq`, `first_name`, `last_name`, `avatar`, `comments`, `posts`, `matches`, `topics`) VALUES
(1, 'fedotru@gmail.com', 'Федот', '911968d8bf13a4423513d33d9a191e40c6feaf0ee69cf48a2b', 44, 1285852108, 7372085, 'Владимир', 'Фёдоров', '4c89f786dc2b5dwW0d9987Dj1pWW.gif', 0, 7, 0, 0);

INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3);
