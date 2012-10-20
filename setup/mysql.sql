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
