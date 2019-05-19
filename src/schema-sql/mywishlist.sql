SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';


DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `liste_id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `descr` text,
  `img` text DEFAULT NULL,
  `url` text DEFAULT NULL,
  `tarif` decimal(8,2) DEFAULT NULL,
  `token_private` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reservation` tinyint(1) NOT NULL DEFAULT '0',
  `participant_name` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `cagnotte` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `liste`;
CREATE TABLE `liste` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `expiration` date DEFAULT NULL,
  `token_private` varchar(255) COLLATE utf8_unicode_ci NOT NULL, /* a voir pour le type */
  `token_publique` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL, /* a voir pour le type */
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS `save_liste`;
CREATE TABLE `save_liste` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`no_liste` int(11) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `cagnotte`;
CREATE TABLE IF NOT EXISTS `cagnotte` (
  `id_participation` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` text NOT NULL,
  `item_id` int(11) NOT NULL,
  `montant` int(11) NOT NULL DEFAULT '0',
  `message` text,
  PRIMARY KEY (`id_participation`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_liste` int(11) NOT NULL,
  `msg` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table activations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `activations`;
CREATE TABLE `activations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dump of table persistences
# ------------------------------------------------------------

DROP TABLE IF EXISTS `persistences`;
CREATE TABLE `persistences` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `persistences_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dump of table reminders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `reminders`;
CREATE TABLE `reminders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dump of table roles
# ------------------------------------------------------------


DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dump of table role_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `role_users`;
CREATE TABLE `role_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dump of table throttle
# ------------------------------------------------------------

DROP TABLE IF EXISTS `throttle`;
CREATE TABLE `throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `throttle_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `last_login` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
