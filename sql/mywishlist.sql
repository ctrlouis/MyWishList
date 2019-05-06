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
  `tarif` decimal(5,2) DEFAULT NULL,
  `token_private` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `item` (`id`, `liste_id`, `nom`, `descr`, `img`, `url`, `tarif`, `token_private`) VALUES
(1,	2,	'Champagne',	'Bouteille de champagne + flutes + jeux à gratter',	'champagne.jpg',	'',	20.00, 'tokenitemprivate1'),
(2,	2,	'Musique',	'Partitions de piano à 4 mains',	'musique.jpg',	'',	25.00, 'tokenitemprivate2'),
(3,	2,	'Exposition',	'Visite guidée de l’exposition ‘REGARDER’ à la galerie Poirel',	'poirelregarder.jpg',	'',	14.00, 'tokenitemprivate4'),
(4,	3,	'Goûter',	'Goûter au FIFNL',	'gouter.jpg',	'',	20.00, 'tokenitemprivate5'),
(5,	3,	'Projection',	'Projection courts-métrages au FIFNL',	'film.jpg',	'',	10.00, 'tokenitemprivate6'),
(6,	2,	'Bouquet',	'Bouquet de roses et Mots de Marion Renaud',	'rose.jpg',	'',	16.00, 'tokenitemprivate7'),
(7,	2,	'Diner Stanislas',	'Diner à La Table du Bon Roi Stanislas (Apéritif /Entrée / Plat / Vin / Dessert / Café / Digestif)',	'bonroi.jpg',	'',	60.00, 'tokenitemprivate8'),
(8,	3,	'Origami',	'Baguettes magiques en Origami en buvant un thé',	'origami.jpg',	'',	12.00, 'tokenitemprivate9'),
(9,	3,	'Livres',	'Livre bricolage avec petits-enfants + Roman',	'bricolage.jpg',	'',	24.00, 'tokenitemprivate10'),
(10,	2,	'Diner  Grand Rue ',	'Diner au Grand’Ru(e) (Apéritif / Entrée / Plat / Vin / Dessert / Café)',	'grandrue.jpg',	'',	59.00, 'tokenitemprivate11'),
(11,	0,	'Visite guidée',	'Visite guidée personnalisée de Saint-Epvre jusqu’à Stanislas',	'place.jpg',	'',	11.00, 'tokenitemprivate12'),
(12,	2,	'Bijoux',	'Bijoux de manteau + Sous-verre pochette de disque + Lait après-soleil',	'bijoux.jpg',	'',	29.00, 'tokenitemprivate13'),
(19,	0,	'Jeu contacts',	'Jeu pour échange de contacts',	'contact.png',	'',	5.00, 'tokenitemprivate14'),
(22,	0,	'Concert',	'Un concert à Nancy',	'concert.jpg',	'',	17.00, 'tokenitemprivate15'),
(23,	1,	'Appart Hotel',	'Appart’hôtel Coeur de Ville, en plein centre-ville',	'apparthotel.jpg',	'',	56.00, 'tokenitemprivate16'),
(24,	2,	'Hôtel d\'Haussonville',	'Hôtel d\'Haussonville, au coeur de la Vieille ville à deux pas de la place Stanislas',	'hotel_haussonville_logo.jpg',	'',	169.00, 'tokenitemprivate17'),
(25,	1,	'Boite de nuit',	'Discothèque, Boîte tendance avec des soirées à thème & DJ invités',	'boitedenuit.jpg',	'',	32.00, 'tokenitemprivate18'),
(26,	1,	'Planètes Laser',	'Laser game : Gilet électronique et pistolet laser comme matériel, vous voilà équipé.',	'laser.jpg',	'',	15.00, 'tokenitemprivate19'),
(27,	1,	'Fort Aventure',	'Découvrez Fort Aventure à Bainville-sur-Madon, un site Accropierre unique en Lorraine ! Des Parcours Acrobatiques pour petits et grands, Jeu Mission Aventure, Crypte de Crapahute, Tyrolienne, Saut à l\'élastique inversé, Toboggan géant... et bien plus encore.',	'fort.jpg',	'',	25.00, 'tokenitemprivate20');


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

INSERT INTO `liste` (`no`, `user_id`, `titre`, `description`, `expiration`, `token_private`) VALUES
(1,	1,	'Pour fêter le bac !',	'Pour un week-end à Nancy qui nous fera oublier les épreuves. ',	'2018-06-27',	'tokenprivate1'),
(3,	3,	'C\'est l\'anniversaire de Charlie',	'Pour lui préparer une fête dont il se souviendra :)',	'2017-12-12',	'tokenprivate3');
INSERT INTO `liste` (`no`, `user_id`, `titre`, `description`, `expiration`, `token_private`, `token_publique`) VALUES
(2,	2,	'Liste de mariage d\'Alice et Bob',	'Nous souhaitons passer un week-end royal à Nancy pour notre lune de miel :)',	'2018-06-30',	'tokenprivate2', 'tokenpublic2');



DROP TABLE IF EXISTS `reservation`;
CREATE TABLE `reservation` (
  `item_id` int(11),
  `reservation` boolean DEFAULT 0,
  `participant_name` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `reservation` (`item_id`) VALUES
(1), (2), (4), (5), (6), (7), (8), (9), (10), (11), (12), (19), (22), (23), (24), (25), (26), (27);


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user` (`username`, `password`, `token`) VALUES
('root',	'',	'2jhxjzbddcw088cs00480ko8wocoscocog4kkc4w8448w44kw8'),
('vanille',	'chocolat',	'63yeltu5z24go8wsw84c0cg040oswsk084wg8kk4s4gggwg8s8');


DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_liste` int(11) NOT NULL,
  `msg` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
