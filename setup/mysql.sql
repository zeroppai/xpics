CREATE DATABASE  `xpicts` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE  `xpicts`.`picture` (
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`title` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
	`image_url` VARCHAR( 512 ) NOT NULL ,
	`thumbnail_url` VARCHAR( 512 ) NOT NULL ,
	`rate` VARCHAR( 11 ) NOT NULL ,
	`date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = MYISAM ;

CREATE TABLE  `xpicts`.`archive_pages` (
`page_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`archive_id` INT NOT NULL ,
`picture_id` INT NOT NULL
) ENGINE = MYISAM ;

CREATE TABLE IF NOT EXISTS `archive` (
  `archive_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail_url` varchar(512) COLLATE utf8_unicode_ci,
  `tags` text COLLATE utf8_unicode_ci NOT NULL,
  `rate` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`archive_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;