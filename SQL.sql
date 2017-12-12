-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `date_publication` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_CBE5A331989D9B62` (`slug`),
  UNIQUE KEY `UNIQ_CBE5A331996B28` (`url_image`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `book` (`id`, `title`, `slug`, `url_image`, `author`, `description`, `date_publication`) VALUES
(1,	'Le temps où nous chantions',	'Le+temps+o%C3%B9+nous+chantions_Richard+Powers_2008',	'https://media.senscritique.com/media/000016861718/150/Le_temps_ou_nous_chantions.jpg',	'Richard Powers',	'Bla oisahfiusdhfiosd',	'2008-04-01 00:00:00'),
(3,	'Jane Eyre',	'Jane+Eyre_Charlotte+Bront%C3%AB_1847',	'https://media.senscritique.com/media/000013966921/150/Jane_Eyre.jpg',	'Charlotte Brontë',	'Bla bla bla!!!',	'1847-10-16 00:00:00'),
(4,	'Quelle était verte ma vallée',	'Quelle+%C3%A9tait+verte+ma+vall%C3%A9e_Richard+Llewellyn_1939',	'https://media.senscritique.com/media/000000153826/150/Quelle_etait_verte_ma_vallee.gif',	'Richard Llewellyn',	'Une vallée verte devient jaune après un incendie',	'1939-01-01 00:00:00'),
(5,	'Le Portrait de Dorian Gray',	'Le+Portrait+de+Dorian+Gray_Oscar+Wilde_1891',	'https://media.senscritique.com/media/000006605798/150/Le_Portrait_de_Dorian_Gray.jpg',	'Oscar Wilde',	'un bonhomme ne vieillit jamais',	'1891-01-01 00:00:00');

DROP TABLE IF EXISTS `books_categories`;
CREATE TABLE `books_categories` (
  `book_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`book_id`,`category_id`),
  KEY `IDX_16746F1516A2B381` (`book_id`),
  KEY `IDX_16746F1512469DE2` (`category_id`),
  CONSTRAINT `FK_16746F1512469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `FK_16746F1516A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `books_categories` (`book_id`, `category_id`) VALUES
(1,	1),
(1,	2),
(3,	3),
(3,	5),
(4,	2),
(4,	3),
(5,	2),
(5,	4);

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `category` (`id`, `name`, `slug`) VALUES
(1,	'Horreur',	'Horreur'),
(2,	'Fantastique',	'Fantastique'),
(3,	'Policier',	'Policier'),
(4,	'Thriller',	'Thriller'),
(5,	'Thatre',	'Thatre');

-- 2017-12-12 15:50:48
