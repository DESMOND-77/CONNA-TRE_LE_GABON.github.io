-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 13 juil. 2025 à 19:18
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `base_gabon`
--

-- --------------------------------------------------------

--
-- Structure de la table `departements`
--

DROP TABLE IF EXISTS `departements`;
CREATE TABLE IF NOT EXISTS `departements` (
  `id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chef_lieu` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province_id` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `population` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `province_id` (`province_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `departements`
--

INSERT INTO `departements` (`id`, `nom`, `chef_lieu`, `province_id`, `population`) VALUES
('G1-1', 'Komo', 'Kango', 'G1', 17575),
('G1-2', 'Komo-Océan', 'Ndzomoe', 'G1', 553),
('G1-3', 'Komo-Mondah', 'Ntoum', 'G1', 90096),
('G1-4', 'Akanda', 'Akanda', 'G1', 703940),
('G1-5', 'Noya', 'Cocobeach', 'G1', 4225),
('G1-6', 'Owendo5 (commune du Komo-Mondah )', 's.o.', 'G1', 79300),
('G2-1', 'Bayi-Brikolo', 'Aboumi', 'G2', 1998),
('G2-2', 'Djoué', 'Onga', 'G2', 2178),
('G2-3', 'Djouori-Agnili', 'Bongoville', 'G2', 4210),
('G2-4', 'Lemboumbi-Leyou', 'Moanda', 'G2', 64569),
('G2-5', 'Lékabi-Léwolo', 'Ngouoni', 'G2', 4914),
('G2-6', 'Lékoko', 'Bakoumba', 'G2', 4920),
('G2-7', 'Lékoni-Lékori', 'Akiéni', 'G2', 10028),
('G2-8', 'Mpassa', 'Franceville', 'G2', 129694),
('G2-9', 'Ogooué-Létili', 'Boumango', 'G2', 2791),
('G2-10', 'Plateaux', 'Lékoni', 'G2', 9054),
('G2-11', 'Sébé-Brikolo', 'Okondja', 'G2', 16443),
('G3-1', 'Abanga-Bigné', 'Ndjolé', 'G3', 14941),
('G3-2', 'Ogooué et des Lacs', 'Lambaréné', 'G3', 54346),
('G4-1', 'Boumi-Louetsi', 'Mbigou', 'G4', 13223),
('G4-2', 'Dola', 'Ndendé', 'G4', 6979),
('G4-3', 'Douya-Onoye', 'Mouila', 'G4', 37699),
('G4-4', 'Louetsi-Bibaka', 'Malinga', 'G4', 2734),
('G4-5', 'Louetsi-Wano', 'Lébamba', 'G4', 9750),
('G4-6', 'Mougalaba', 'Guiétsou', 'G4', 1490),
('G4-7', 'Ndolou', 'Mandji', 'G4', 5727),
('G4-8', 'Ogoulou', 'Mimongo', 'G4', 8361),
('G4-9', 'Tsamba-Magotsi', 'Fougamou', 'G4', 14875),
('G5-1', 'Basse-Banio', 'Mayumba', 'G5', 7192),
('G5-2', 'Douigny', 'Moabi', 'G5', 5235),
('G5-3', 'Doutsila', 'Mabanda', 'G5', 4623),
('G5-4', 'Haute-Banio', 'Ndindi', 'G5', 1413),
('G5-5', 'Mongo', 'Moulengui-Binza', 'G5', 2602),
('G5-6', 'Mougoutsi', 'Tchibanga', 'G5', 31789),
('G6-1', 'Ivindo', 'Makokou', 'G6', 31073),
('G6-2', 'Lopé', 'Booué', 'G6', 12382),
('G6-3', 'Mvoung', 'Ovan', 'G6', 4022),
('G6-4', 'Zadié', 'Mékambo', 'G6', 15816),
('G7-1', 'Lolo-Bouenguidi', 'Koulamoutou', 'G7', 30643),
('G7-2', 'Lombo-Bouenguidi', 'Pana', 'G7', 4635),
('G7-3', 'Mulundu', 'Lastourville', 'G7', 27750),
('G7-4', 'Offoué-Onoye', 'Iboundji', 'G7', 2743),
('G8-1', 'Bendjé', 'Port-Gentil', 'G8', 140747),
('G8-2', 'Etimboué', 'Omboué', 'G8', 5723),
('G8-3', 'Ndougou', 'Gamba', 'G8', 11092),
('G9-1', 'Haut-Komo', 'Médouneu', 'G9', 3403),
('G9-2', 'Haut-Ntem', 'Minvoul', 'G9', 10838),
('G9-3', 'Ntem', 'Bitam', 'G9', 49712),
('G9-4', 'Okano', 'Mitzic', 'G9', 16630),
('G9-5', 'Woleu', 'Oyem', 'G9', 74403);

-- --------------------------------------------------------

--
-- Structure de la table `ethnies`
--

DROP TABLE IF EXISTS `ethnies`;
CREATE TABLE IF NOT EXISTS `ethnies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province_id` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ethnies`
--

INSERT INTO `ethnies` (`id`, `nom`, `province_id`, `description`) VALUES
(1, 'Fang', 'G1', 'Peuple majoritaire du Gabon, société clanique et tradition spirituelle Bwiti.'),
(2, 'Omyene Group', 'G1', 'Groupement côtier d’artisans et navigateurs, riche héritage maritime.'),
(3, 'Benga', 'G1', 'Pêcheurs des lagunes et de la côte, techniques de filets et barques traditionnelles.'),
(4, 'Akele', 'G1', 'Liés aux Fang, connus pour l’agriculture, le tissage et la sculpture sur bois.'),
(5, 'Simba', 'G1', 'Petits groupes intégrés aux Fang, avec pratiques animistes locales.'),
(6, 'Beseki', 'G1', 'Communautés assimilées aux Fang, artisans du bois et sculpteurs.'),
(7, 'Seke', 'G1', 'Agriculteurs sur brûlis, cérémonies paysannes et musique rituelle.'),
(8, 'Téké', 'G2', 'Présents au Gabon et au Congo, réputés pour leurs masques et rites spirituels.'),
(9, 'Mbahouin', 'G2', 'Peuple bantou d’agriculteurs, coutumes foncées et artisanat local.'),
(10, 'Obamba', 'G2', 'Agriculteurs et tisserands du centre, riche tradition musicale.'),
(11, 'Bakaningui', 'G2', 'Vivant en forêt, experts en plantes médicinales et chasse.'),
(12, 'Nzebi', 'G2', 'Cultivateurs, métiers du cuir et commerce régional dynamique.'),
(13, 'Ndoumou', 'G2', 'Connus pour leurs tambours rituels et danses en forêt tropicale.'),
(14, 'Ndassa\nNdumu', 'G2', 'Groupes de chasseurs et cueilleurs, folklore animiste fort.'),
(15, 'Awandji', 'G2', 'Dialecte bantou, élevage de petits ruminants et artisanat régional.'),
(16, 'Mbeté', 'G2', 'Cultivateurs de manioc et bananes, cultes d’ancêtres.'),
(17, 'Haoussa', 'G2', 'Commerçants originaires du Sahel, caravanes et marchés interrégionaux.'),
(18, 'Apindji\nGaloa', 'G3', 'Forestiers montagnards, chasse traditionnelle et poterie artisanale.'),
(19, 'Fang Akele', 'G3', 'Sous-groupe Fang, influence Bwiti et art sculptural prononcé.'),
(20, 'Vili', 'G3', 'Peuple côtier du Loango, royauté traditionnelle et navigation.'),
(21, 'Enenga', 'G3', 'Pêcheurs et cultivateurs d’estuaires, rites du fleuve.'),
(22, 'Akélé', 'G4', 'Agropasteurs forestiers, fusion culturelle Akele/Fang.'),
(23, 'Banzebie', 'G4', 'Groupes de forêts, chants et danses d’initiation.'),
(24, 'Mitsogho', 'G4', 'Montagnards, gardiens du culte Bwiti originel.'),
(25, 'Massango', 'G4', 'Chasseurs-cueilleurs historiques, riche tradition orale.'),
(26, 'Bavarama', 'G4', 'Agriculteurs forestiers, tissage et vannerie.'),
(27, 'Bapunu', 'G4', 'Petits agriculteurs, fêtes saisonnières et musique locale.'),
(28, 'Apindji', 'G4', 'Expertise en chasse de forêt et sculpture sur bois.'),
(29, 'Bavungu', 'G4', 'Peuple de vallées montagneuses, cérémonies de guérison.'),
(30, 'Guisir', 'G4', 'Forêts méridionales, poterie artisanale et mythes de la terre.'),
(31, 'Eviya', 'G4', 'Communautés peu documentées, forte intégration culturelle.'),
(32, 'lumbu', 'G5', 'Pêcheurs côtiers, vénération des ancêtres marins.'),
(33, 'Bakota', 'G6', 'Masques rituels et danses sacrées de l’est du pays.'),
(34, 'Mahongue', 'G6', 'Artisans métallurgistes traditionnels, forgerons de village.'),
(35, 'Boungome', 'G6', 'Société de chasse, vannerie et musique à flûte.'),
(36, 'Kwele', 'G6', 'Célèbres pour leurs masques en forme de cœur et spiritualité.'),
(37, 'Baschiwe', 'G6', 'Agriculteurs du centre-est, mythes ancestraux et sorcellerie.'),
(38, 'Basimba people', 'G6', 'Minorité, cultes de possession et guérison traditionnelle.'),
(39, 'Banzebi\nPuvi', 'G7', 'Groupes montagnards, rites secrets et initiations.'),
(40, 'Aduma', 'G7', 'Communautés mixtes, marchés transversaux et fusion culturelle.'),
(41, 'Omiene group( Oroungu, Nkomi)', 'G8', 'Navigateurs de l’Omyene, commerce d’ivoire et artisanat de fer.'),
(42, 'Baka', 'G9', 'Pygmées, chasse en forêt équatoriale et chants polyphoniques.'),
(43, '', '', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `personnages`
--

DROP TABLE IF EXISTS `personnages`;
CREATE TABLE IF NOT EXISTS `personnages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `histoire` text COLLATE utf8mb4_unicode_ci,
  `date_naissance` date DEFAULT NULL,
  `date_deces` date DEFAULT NULL,
  `lieu_naissance` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province_id` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ethnie_id` int DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `province_id` (`province_id`),
  KEY `ethnie_id` (`ethnie_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `personnages`
--

INSERT INTO `personnages` (`id`, `nom`, `description`, `histoire`, `date_naissance`, `date_deces`, `lieu_naissance`, `province_id`, `ethnie_id`, `image`) VALUES
(1, 'RAPOTCHOMBO', 'Homme politique gabonais influent du XXe siècle.', 'Il a œuvré pour l’indépendance du Gabon et participé à la construction des institutions modernes.', '1780-01-01', '1876-05-09', 'Ntoum', 'G1', 1, 'ROI_DENIS_RAPONTCHOMBO.JPG'),
(2, 'Léon Mba', 'Premier président du Gabon.', 'Président de 1961 à 1967, artisan de l’unité nationale.', '1902-02-09', '1967-10-28', 'Libreville', 'G1', 1, 'LEON_MBA_.JPG'),
(3, 'Omar Bongo Ondimba', 'Président du Gabon de 1967 à 2009, plus long règne présidentiel d’Afrique (42 ans).', 'Né sous le nom Albert-Bernard Bongo, il a modernisé le pays et consolidé la dynastie Bongo.', '1935-12-30', '2009-06-08', 'Lewai (aujourd\'hui Bongoville)', 'G2', 1, 'OMAR_BONGO_ONDIMBA.JPG'),
(4, 'Ali Bongo Ondimba', 'Président du Gabon de 2009 à 2023, continuation de la dynastie Bongo.', 'Fils d’Omar Bongo, il a poursuivi les réformes économiques et la diversification.', '1959-02-09', NULL, 'Brazzaville (Congo)', 'G2', 1, 'ALI_BONGO_ONDIMBA.JPG'),
(5, 'Paul-Marie Yembit', 'Premier ministre, leader politique fang et figure de l’opposition sous Léon Mba.', 'Grand artisan de la vie politique gabonaise après l’indépendance.', '1917-08-14', '1972-11-18', 'Mitzic', 'G9', 1, 'PAUL_MARIE_YEMBIT.JPG'),
(6, 'Jean-Hilaire Aubame', 'Leader politique et opposant historique de l’indépendance gabonaise.', 'Fondateur de l’Union démocratique et membre clé de la décolonisation.', '1912-11-05', '1989-11-17', 'Libreville', 'G1', NULL, 'JEAN_HILAIRE_AUBAME.JPG'),
(7, 'Emane Tole', 'Chef fang et héros de la résistance anti-coloniale.', 'Il mena plusieurs révoltes contre l’administration coloniale française.', '1843-01-01', '1898-12-31', 'Région de Kango', '1', 1, 'EMANE_TOLE.JPG'),
(8, 'Roi Louis (Anguile)', 'Chef traditionnel de la région du Cap Lopez et signataire de traités coloniaux.', 'Actif au XIXᵉ siècle, il négocia avec la France les premiers traités commerciaux.', NULL, '0000-00-00', NULL, 'G1', NULL, 'ROI_LOUIS.JPG'),
(9, 'Albert Schweitzer', 'Médecin, théologien et prix Nobel de la paix.', 'Fondateur de l’hôpital de Lambaréné et promoteur de la médecine tropicale.', '1875-01-14', '1965-09-04', 'Kaysersberg (France) – activité à Lambaréné', 'G3', NULL, 'ALBERT_SCHWEITZER.JPG'),
(10, 'Mgr André Raponda-Walker', 'Premier prêtre gabonais et ethnologue.', 'Auteur d’études majeures sur les cultures et langues gabonaises.', '1871-07-01', '1968-12-24', 'Libreville', 'G1', NULL, 'MGR_ANDRÉ_RAPONDA_WALKER.GIF'),
(11, 'Pierre-Emerick Aubameyang', 'Footballeur international et ambassadeur du Gabon dans le sport mondial.', 'Meilleur buteur de l’équipe nationale, carrière européenne brillante.', '1989-06-18', NULL, 'Laval (France)', 'G1', NULL, 'PIERRE_EMERICK_AUBAMEYANG.PNG'),
(12, 'Patience Dabany', 'Chanteuse et première dame du Gabon (épouse d’Omar Bongo).', 'Icône de la musique gabonaise, ambassadrice culturelle.', '1944-01-22', NULL, 'Brazzaville (Congo)', 'G2', 1, 'PATIENCE_DABANY.JPG'),
(13, 'Pierre-Claver Zeng Ebome', 'Diplomate et homme politique.', 'Premier ambassadeur du Gabon aux Nations unies.', '1916-03-22', '2008-07-15', 'Oyem', 'G9', NULL, 'PIERRE_CLAVER_ZENG_EBOME.JPG'),
(14, 'Général Brice Oligui Nguema', 'Chef de la transition depuis le coup d’État de 2023.', 'Ancien chef d’état‑major, il a mené le renversement de 2023.', '1975-03-03', NULL, 'Lekoni-Lekori (Haut-Ogooué)', 'G2', 1, 'GÉNÉRAL_BRICE_OLIGUI_NGUEMA.JPG'),
(15, 'Capitaine Ntchorere', 'Héros de la Seconde Guerre mondiale et résistant.', 'Mort pour la France en 1940, célèbre pour son courage au combat.', '1896-05-04', '1940-06-18', 'Libreville', 'G1', NULL, 'CAPITAINE_NTCHORERE.JPG'),
(16, 'Angèle Rawiri', 'Écrivaine, première romancière gabonaise.', 'Pionnière de la littérature féminine en Afrique centrale.', '1954-05-10', '2010-07-07', 'Port-Gentil', 'G8', NULL, 'ANGÈLE_RAWIRI.WEBP'),
(17, 'Laurent Owondo', 'Écrivain et dramaturge.', 'Figure marquante du théâtre gabonais moderne.', '1945-04-12', '2019-11-01', 'Lastoursville', 'G7', NULL, 'LAURENT_OWONDO.JPG'),
(18, 'Ferdinand Allogho-Oke', 'Écrivain et journaliste.', 'Pionnier du journalisme gabonais.', '1932-01-01', NULL, 'Oyem', 'G9', NULL, 'FERDINAND_ALLOGHO_OKE.JPEG'),
(19, 'Paul Gondjout', 'Homme politique et ministre.', 'Père de Laure Gondjout, figure de l’indépendance.', '1912-10-09', '1990-05-20', 'Libreville', 'G1', NULL, 'PAUL_GONDJOUT.JPEG'),
(20, 'Georges Rawiri', 'Vice-président et diplomate.', 'Bras droit d’Omar Bongo pendant plusieurs décennies.', '1932-04-29', '2006-09-09', 'Port-Gentil', 'G8', NULL, 'GEORGES_RAWIRI.JPG'),
(21, 'Martin Bongo', 'Homme politique, frère d’Omar Bongo.', 'Influent conseiller et diplomate.', '1932-05-15', '2009-06-08', 'Lewai (Bongoville)', 'G2', NULL, 'MARTIN_BONGO.JPEG'),
(22, 'Casimir Oyé-Mba', 'Premier ministre et homme politique.', 'Pilier de la transition démocratique des années 1990.', '1942-09-20', '2021-09-11', 'Lambaréné', 'G3', NULL, 'CASIMIR_OYÉ_MBA.JPEG'),
(23, 'Hilarion Nguema', 'Guitariste et compositeur.', 'Légende de la musique gabonaise moderne.', '1944-03-03', '2017-12-10', 'Oyem', 'G9', NULL, 'HILARION_NGUEMA.JPG'),
(24, 'Pierre Akendengué', 'Chanteur, poète et musicien.', 'Ambassadeur culturel du Gabon.', '1943-04-25', NULL, 'Awuta', 'G8', NULL, 'PIERRE_AKENDENGUÉ.JPEG'),
(25, 'Annie-Flore Batchiellilys', 'Chanteuse, voix emblématique de la musique gabonaise.', 'Figure majeure des années 1990–2000.', '1967-08-31', NULL, 'Libreville', 'G1', NULL, 'ANNIE_FLORE_BATCHIELLILYS.JPEG'),
(26, 'Daniel Cousin', 'Footballeur international, capitaine historique des Panthères.', 'Recordman de sélections et meilleur buteur national.', '1977-03-07', NULL, 'Libreville', 'G1', NULL, 'DANIEL_COUSIN.JPEG'),
(27, 'Anthony Obame', 'Taekwondoïste, premier médaillé olympique gabonais (2012).', 'Médaille de bronze en 2012, icône du sport national.', '1988-11-10', NULL, 'Libreville', 'G1', NULL, 'ANTHONY_OBAME.JPEG'),
(28, 'Bruno Ecuele Manga', 'Footballeur international, défenseur emblématique.', 'Capitaine des Panthères et carrière en Europe.', '1988-03-24', NULL, 'Libreville', 'G1', NULL, 'BRUNO_ECUELE_MANGA.JPEG'),
(29, 'Mgr Basile Mvé', 'Archevêque de Libreville.', 'Pilier du catholicisme gabonais moderne.', '1923-07-15', '2018-02-16', 'Oyem', 'G9', NULL, 'MGR_BASILE_MVÉ.JPEG'),
(30, 'Paul du Chaillu', 'Explorateur franco-américain.', 'Premier Européen à documenter les gorilles et l’intérieur du Gabon.', '1831-07-31', '1903-04-26', 'Saint-denis (France)', NULL, NULL, 'PAUL_DU_CHAILLU.JPG'),
(31, 'Lord Ekomy Ndong (Rodrigue Ekomy)', 'Rappeur et chanteur, figure majeure du hip-hop gabonais.', 'Pionnier du mouvement rap moderne au Gabon.', '1977-09-22', NULL, 'Port-Gentil', 'G1', NULL, 'LORD_EKOMY_NDONG.JPG'),
(32, 'Oliver N\'Goma', 'Chanteur, icône de la musique gabonaise.', 'Son tube « Bane » est un hymne national.', '1959-09-23', '2010-06-07', 'Mayumba', 'G5', NULL, 'OLIVER_N\'GOMA.JPG'),
(33, 'Owono Ndong', 'Chef militaire fang et stratège de guérilla.', 'Actif au XIXᵉ siècle contre l’occupation coloniale.', NULL, NULL, NULL, 'G9', 1, 'OWONO_NDONG.JPG'),
(34, 'Nguema Mba', 'Guerrier et diplomate fang.', 'Allié stratégique dans la résistance anti-coloniale.', NULL, NULL, NULL, 'G9', 1, 'NGUEMA_MBA.JPG'),
(35, 'Aba\'a Minko', 'Chef de guerre fang et leader des migrations vers le sud.', 'Conduisit les grandes migrations fang au XIXᵉ siècle.', '1969-08-04', NULL, 'Bitam', 'G6', 1, 'ABA\'A_MINKO_ROLAND_D.JPG');

-- --------------------------------------------------------

--
-- Structure de la table `provinces`
--

DROP TABLE IF EXISTS `provinces`;
CREATE TABLE IF NOT EXISTS `provinces` (
  `id` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chef_lieu` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `provinces`
--

INSERT INTO `provinces` (`id`, `nom`, `chef_lieu`) VALUES
('G1', 'Estuaire', 'Libreville'),
('G2', 'Haut-Ogooué', 'Franceville'),
('G3', 'Moyen-Ogooué', 'Lambaréné'),
('G4', 'Ngounié', 'Mouila'),
('G5', 'Nyanga', 'Tchibanga'),
('G6', 'Ogooué-Ivindo', 'Makokou'),
('G7', 'Ogooué-Lolo', 'Koulamoutou'),
('G8', 'Ogooué-Maritime', 'Port-Gentil'),
('G9', 'Woleu-Ntem', 'Oyem');

-- --------------------------------------------------------

--
-- Structure de la table `villes`
--

DROP TABLE IF EXISTS `villes`;
CREATE TABLE IF NOT EXISTS `villes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departement_id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `population` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `departement_id` (`departement_id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `villes`
--

INSERT INTO `villes` (`id`, `nom`, `departement_id`, `population`) VALUES
(1, 'Kango', 'G1-1', 1975),
(2, 'Ndzomoe', 'G1-2', 0),
(3, 'Libreville', 'G1-3', 753550),
(4, 'Ntoum', 'G1-3', 11169),
(5, 'Nkan', 'G1-3', 11113),
(6, 'Akanda', 'G1-4', 0),
(7, 'Cocobeach', 'G1-5', 2155),
(8, 's.o.', 'G1-6', 0),
(9, 'Aboumi', 'G2-1', 0),
(10, 'Lékoni', 'G2-10', 4669),
(11, 'Okondja', 'G2-11', 9326),
(12, 'Onga', 'G2-2', 0),
(13, 'Bongoville', 'G2-3', 0),
(14, 'Moanda', 'G2-4', 39298),
(15, 'Mounana', 'G2-4', 11443),
(16, 'Ngouoni', 'G2-5', 0),
(17, 'Bakoumba', 'G2-6', 0),
(18, 'Akiéni', 'G2-7', 0),
(19, 'Franceville', 'G2-8', 56002),
(20, 'Boumango', 'G2-9', 0),
(21, 'Ndjolé', 'G3-1', 6645),
(22, 'Lambaréné', 'G3-2', 26998),
(23, 'Mbigou', 'G4-1', 5388),
(24, 'Ndendé', 'G4-2', 8082),
(25, 'Mouila', 'G4-3', 29286),
(26, 'Malinga', 'G4-4', 0),
(27, 'Lébamba', 'G4-5', 0),
(28, 'Guiétsou', 'G4-6', 0),
(29, 'Mandji', 'G4-7', 0),
(30, 'Mimongo', 'G4-8', 4310),
(31, 'Fougamou', 'G4-9', 7363),
(32, 'Tsogni', 'G5-1', 12977),
(33, 'Mayumba', 'G5-1', 5208),
(34, 'Moabi', 'G5-2', 0),
(35, 'Mabanda', 'G5-3', 0),
(36, 'Ndindi', 'G5-4', 0),
(37, 'Moulengui-Binza', 'G5-5', 0),
(38, 'Tchibanga', 'G5-6', 25239),
(39, 'Makokou', 'G6-1', 17688),
(40, 'Booué', 'G6-2', 7543),
(41, 'Ovan', 'G6-3', 0),
(42, 'Mékambo', 'G6-4', 5029),
(43, 'Koulamoutou', 'G7-1', 21143),
(44, 'Pana', 'G7-2', 0),
(45, 'Lastourville', 'G7-3', 10871),
(46, 'Iboundji', 'G7-4', 0),
(47, 'Port-Gentil', 'G8-1', 142280),
(48, 'Omboué', 'G8-2', 2173),
(49, 'Gamba', 'G8-3', 12939),
(50, 'Médouneu', 'G9-1', 2514),
(51, 'Minvoul', 'G9-2', 3771),
(52, 'Bitam', 'G9-3', 13421),
(53, 'Mitzic', 'G9-4', 5064),
(54, 'Oyem', 'G9-5', 40235);

-- --------------------------------------------------------

--
-- Structure de la table `villes_gabon`
--

DROP TABLE IF EXISTS `villes_gabon`;
CREATE TABLE IF NOT EXISTS `villes_gabon` (
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `population` int DEFAULT NULL,
  `population_year` year DEFAULT NULL,
  `role` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mayor` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `political_notes` text COLLATE utf8mb4_unicode_ci,
  `ethnic_diversity` text COLLATE utf8mb4_unicode_ci,
  `economic_sectors` text COLLATE utf8mb4_unicode_ci,
  `infrastructure` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `villes_gabon`
--

INSERT INTO `villes_gabon` (`name`, `province`, `department`, `population`, `population_year`, `role`, `mayor`, `political_notes`, `ethnic_diversity`, `economic_sectors`, `infrastructure`, `notes`) VALUES
('Libreville', 'Estuaire', NULL, 920000, '2025', 'capitale nationale', NULL, 'Présidence, Assemblée nationale; Brice Oligui Nguema investi président le 3 mai 2025 après élection du 12 avril (≈94 %)', 'plus de 40 ethnies; fortes diasporas européenne/libanaise/asiatique', 'pétrole, bois, port, services, enseignement/recherche', 'fortes inégalités; ≈30 % population sous seuil de pauvreté', 'centre politique & économique'),
('Ndzomoe', 'Estuaire', 'Komo-Océan', 1110, '2012', 'chef‑lieu département', NULL, 'Visité par le président de la transition mars 2025; projet route et quai en cours; tensions autour de gestion fonds', NULL, 'pêche, tourisme', 'accès par navette maritime + piste 4×4; quasi absence d’infrastructures', 'appellation « commune oubliée »'),
('Ntoum', 'Estuaire', 'Komo‑Mondah', 51954, '2013', 'chef‑lieu département', 'Juste Parfait Biyogo B\'Otogo', 'budget municipal 1.38 G FCFA (2022); insalubrité, routes dégradées; programme Angelys 52 Md FCFA; insécurité accrue', NULL, 'ciment (CIMGAB), zone spéciale bois Nkok, agriculture maraîchère, élevage avicole, foresterie', 'usine ciment, zone économique spéciale, projets routiers, connexions transgabonais', '2e ville Estuaire, «grenier de Libreville»'),
('Nkan', 'Estuaire', NULL, 11113, '2010', NULL, NULL, NULL, NULL, NULL, 'dispose d’un aéroport (code NKA)', NULL),
('Cocobeach', 'Estuaire', 'Noya', 2279, '2012', 'commune rurale', NULL, 'Développement projet route Ntoum‑Cocobeach visité 14 février 2025', NULL, 'pêche, petit commerce transfrontalier, tourisme balnéaire', 'accès maritime & route en réhabilitation', 'commune frontalière, potentiel station balnéaire'),
('Bitam', 'Woleu‑Ntem', 'Ntem', 22000, '2023', 'chef‑lieu département', 'Jules Mbélé Assoko', NULL, 'majoritairement fang; présence haoussa islamique', 'hévéa, pisciculture (tilapia)', 'aéroport local', 'marché transfrontalier'),
('Kango', 'Estuaire', 'Komo', 2089, '2012', 'chef‑lieu département', 'Martine Oyane Ovone', 'Conseil départemental du Komo-Kango dirigé par M. Koussou; maire élue février 2019', NULL, 'agriculture (bananes, palmier, hévéa), exploitation forestière, pêche (crevettes), tourisme (Monts de Cristal)', 'projet aéroport Andem; gare ferroviaire en restructuration; station transgabonais', 'Mairie RPG; enveloppe de 500 M FCFA annoncée en tournée présidentielle'),
('Nkan', 'Estuaire', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Aboumi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Lékoni', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Okondja', 'Haut-Ogooué', 'Sébè-Brikolo', 10136, '2013', 'chef‑lieu département', NULL, 'Centre d’activisme PDG; visite présidentielle 2025; espère développement équitable post-élection', 'populations Obamba; langues Mbete, Lendambomo', 'exploitation manganèse, café, bananes, transport (aéroport)', 'route Makokou–Okondja en construction (~260 km; 2500 emplois prévus)', 'ancienne ville minière, aspirations à plus de services'),
('Onga', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Bongoville', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Moanda', 'Haut‑Ogooué', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Mounana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Ngouoni', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Bakoumba', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Akiéni', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Franceville', 'Haut‑Ogooué', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Boumango', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Ndjolé', 'Moyen‑Ogooué', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Lambaréné', 'Moyen‑Ogooué', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Mbigou', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Ndendé', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Mouila', 'Ngounié', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Malinga', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Lébamba', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Guiétsou', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Mandji', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Mimongo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Fougamou', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Tsogni', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Mayumba', 'Ngounié', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Moabi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Mabanda', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Ndindi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Moulengui‑Binza', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Tchibanga', 'Nyanga', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Makokou', 'Ogooué‑Ivindo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Booué', 'Ogooué‑Ivindo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Ovan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Mékambo', 'Ogooué‑Ivindo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Koulamoutou', 'Ogooué‑Lolo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Pana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Lastourville', 'Ogooué‑Lolo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Iboundji', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Port‑Gentil', 'Ogooué-Maritime', NULL, 136462, '2013', 'capitale économique', 'Gabriel Tchango', NULL, 'populations locales et expatriés européens, africains', 'pétrole (~75 % PIB), raffinage (SOGARA), bois, pêche, transport maritime', 'aéroport international; routes en projet vers Omboué', 'Port commercial principal'),
('Omboué', 'Ogooué‑Maritime', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Gamba', 'Ogooué‑Maritime', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Médouneu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Minvoul', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Mitzic', 'Woleu‑Ntem', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Oyem', 'Woleu‑Ntem', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
