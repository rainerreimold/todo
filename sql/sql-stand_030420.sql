-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 03. Apr 2020 um 18:03
-- Server-Version: 5.7.20-log
-- PHP-Version: 7.1.4

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Datenbank: `rezept`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bestellzettel`
--

DROP TABLE IF EXISTS `bestellzettel`;
CREATE TABLE IF NOT EXISTS `bestellzettel` (
  `bestellzettel_id` int(11) NOT NULL,
  `initial_id` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `wochenplan_id` int(11) NOT NULL,
  `familie_id` int(11) NOT NULL,
  `kalenderwoche` tinyint(2) DEFAULT NULL,
  `wiederholung` tinyint(2) DEFAULT NULL,
  `bezeichnung` varchar(40) NOT NULL,
  `beschreibung` text,
  `eingetragen` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `aktiv` tinyint(1) DEFAULT '1',
  `loeschbar` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`bestellzettel_id`),
  KEY `fk_wochenplan_id_idx` (`wochenplan_id`),
  KEY `fk_familien_id_idx` (`familie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bestellzetteleintrag`
--

DROP TABLE IF EXISTS `bestellzetteleintrag`;
CREATE TABLE IF NOT EXISTS `bestellzetteleintrag` (
  `bestellzetteleintrag_id` int(11) NOT NULL,
  `initial_id` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `bestellzettel_id` int(11) NOT NULL,
  `ingredienz_id` int(11) NOT NULL,
  `ingredienzname` varchar(100) DEFAULT NULL,
  `menge` varchar(5) DEFAULT NULL,
  `einheit` varchar(2) NOT NULL,
  `beschreibung` text,
  `eingetragen` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `aktiv` tinyint(1) DEFAULT '1',
  `loeschbar` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`bestellzetteleintrag_id`),
  KEY `fk_bestellzettel_id_idx` (`bestellzettel_id`),
  KEY `fk_ingredienz_id_idx` (`ingredienz_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `familie`
--

DROP TABLE IF EXISTS `familie`;
CREATE TABLE IF NOT EXISTS `familie` (
  `familie_id` int(11) NOT NULL,
  `initial_id` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `anzahl_personen` tinyint(2) NOT NULL,
  `davon_kinder` tinyint(2) DEFAULT NULL,
  `eingetragen` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `aktiv` tinyint(1) DEFAULT '1',
  `loeschbar` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`familie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `familienwochenplan`
--

DROP TABLE IF EXISTS `familienwochenplan`;
CREATE TABLE IF NOT EXISTS `familienwochenplan` (
  `familienwochenplan_id` int(11) NOT NULL AUTO_INCREMENT,
  `initial_id` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `wochenplan_id` int(11) NOT NULL,
  `familie_id` int(11) NOT NULL,
  `kalenderwoche` tinyint(2) DEFAULT NULL,
  `wiederholung` tinyint(2) DEFAULT NULL,
  `bezeichnung` varchar(40) NOT NULL,
  `beschreibung` text,
  `eingetragen` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `aktiv` tinyint(1) DEFAULT '1',
  `loeschbar` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`familienwochenplan_id`),
  KEY `wochenplan_id` (`wochenplan_id`),
  KEY `familie_id` (`familie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ingredienz`
--

DROP TABLE IF EXISTS `ingredienz`;
CREATE TABLE IF NOT EXISTS `ingredienz` (
  `ingredienz_id` int(11) NOT NULL AUTO_INCREMENT,
  `initial_id` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `bezeichnung` varchar(40) NOT NULL,
  `beschreibung` text,
  `eingetragen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `aktiv` tinyint(1) DEFAULT '1',
  `loeschbar` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ingredienz_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `ingredienz`
--

INSERT INTO `ingredienz` (`ingredienz_id`, `initial_id`, `parent_id`, `bezeichnung`, `beschreibung`, `eingetragen`, `aktiv`, `loeschbar`) VALUES
(1, 1, 0, 'Kartoffel', 'Die Kartoffel gehört zu den Sättigungsbeilagen', '2020-03-29 13:33:00', 1, 0),
(2, 2, 0, 'Möhren', 'Gemüsebeilage oder Salat', '2020-03-29 13:33:00', 1, 0),
(3, 3, 0, 'Erbsen', 'Gemüsebeilage', '2020-03-29 13:33:00', 1, 0),
(4, 4, 0, 'Bohnen', 'Gemüsebeilage', '2020-03-29 13:33:00', 1, 0),
(5, 5, 0, 'Rotkohl', 'Gemüsebeilage ', '2020-03-29 13:33:00', 1, 0),
(6, 6, 0, 'Sauerkraut', 'Gemüsebeilage', '2020-03-29 13:33:00', 1, 0),
(7, 7, 0, 'Reis', 'Sättigungsbeilage', '2020-03-29 13:33:00', 1, 0),
(8, 8, 0, 'Kartoffelbrei', 'oder Kartoffelstampf', '2020-03-29 13:33:00', 1, 0),
(9, 9, 0, 'Nudeln', 'verschiedene Arten', '2020-03-29 13:33:00', 1, 0),
(10, 10, 0, 'Schnitzel', 'paniertes Schweinefleisch', '2020-03-29 13:33:00', 1, 0),
(11, 11, 0, 'Cordon Bleu', 'paniertes und gefülltes Schweine oder Geflügefleisch', '2020-03-29 13:33:00', 1, 0),
(12, 12, 0, 'Nougets', 'kleine panierte Fleischteile', '2020-03-29 13:33:00', 1, 0),
(13, 13, 0, 'Boulette', 'Boulette, Klops, Frikadelle oder Grillette', '2020-03-30 20:25:18', 1, 0),
(14, 14, 0, 'Schweinesteak', 'klassische Steak hat normalerweise 125g Rohgewicht und ist aus dem Schweinekamm oder heute auch Schweinehals, was nicht ganz richtig ist. Es handelt sich vielmehr um den Übergang vom Kotelette zum tatsächlichen Hals', '2020-03-30 20:25:18', 1, 0),
(15, 15, 0, 'Eier', 'verschiedene Zubereitungsarten\r\n', '2020-04-01 14:50:25', 1, 0),
(16, 16, 0, 'Schaschlik', 'Schweinenacken, Speck, Gewürkgurke, Zwiebeln und viel Senf', '2020-04-01 14:50:25', 1, 0),
(17, 17, 0, 'Brot', 'eine Scheibe Brot', '2020-04-01 14:50:25', 1, 0),
(18, 18, 0, 'Gulasch', 'Gulasch besteht in aller Regel aus Halb Schwein, Halb Rind.', '2020-04-01 14:42:35', 1, 0),
(19, 19, 0, 'Mutzbraten', 'Zupffleisch', '2020-04-01 14:50:25', 1, 0),
(20, 20, 0, 'SenfSoße', 'Senfsoße mit 2 Eier', '2020-04-01 14:50:25', 1, 0),
(21, 21, 0, 'Bratwurst', 'Bratwurst', '2020-04-01 14:50:25', 1, 0),
(22, 22, 0, 'Pinkel', 'gebratene Knack- oder Bratwurst. (geräuchert)', '2020-04-01 14:50:25', 1, 0),
(23, 23, 0, 'Wiener', 'Wiener dünne Würstchen', '2020-04-01 14:50:25', 1, 0),
(24, 24, 0, 'Bockwurst', 'klassische Bockwurst', '2020-04-01 14:50:25', 1, 0),
(25, 25, 0, 'Zigeunersoße', 'Muss heute wohl anders bezeichnet werden, ich kenne es unter dieser Bezeichnung', '2020-04-01 14:52:04', 1, 0),
(26, 26, 0, 'Wirsingroulade', NULL, '2020-04-01 14:52:04', 1, 0),
(27, 27, 0, 'Kohlroulade', 'In Kohlblättern gewickeltes Hackfleisch, auch Krautwickel', '2020-04-01 14:53:49', 1, 0),
(28, 28, 0, 'Pellkartoffel', 'Mit Schale gekochte Kartoffel', '2020-04-01 14:53:49', 1, 0),
(29, 29, 0, 'Grünkohl', 'gekochter Grünkohl', '2020-04-01 14:58:17', 1, 0),
(30, 30, 0, 'Rotkraut', 'gekochter Rotkohl', '2020-04-01 14:58:17', 1, 0),
(31, 31, 0, 'Spinat', 'gehackt oder als Blattspinat', '2020-04-01 14:58:17', 1, 0),
(32, 32, 0, 'Krautpfanne', 'klein gehackter Weißkohl oder Wirsing angebraten mit Hackfleisch und gekocht', '2020-04-01 14:58:17', 1, 0),
(33, 33, 0, 'Brokkoli', 'auch Spargelkohl', '2020-04-03 05:00:56', 1, 0),
(34, 34, 0, 'Blumenkohl', NULL, '2020-04-03 05:00:57', 1, 0),
(35, 35, 0, 'Rosenkohl', 'Rosenkohl', '2020-04-03 05:00:57', 1, 0),
(36, 36, 0, 'Tomaten', 'Tomaten', '2020-04-03 05:00:57', 1, 0),
(37, 37, 0, 'Zwiebeln', 'Zwiebeln für Rostbrätel, Leber usw.', '2020-04-03 05:13:24', 1, 0),
(38, 38, 0, 'Schweineleber', 'Schweineleber gebraten oder als Ragout', '2020-04-03 05:13:24', 1, 0),
(39, 39, 0, 'Graupen', 'für Suppe, aber auch als Sättigungsbeilage', '2020-04-03 05:15:19', 1, 0),
(40, 40, 0, 'Linsen', 'für Suppe, aber auch als Sättigungsbeilage', '2020-04-03 05:15:19', 1, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `menge`
--

DROP TABLE IF EXISTS `menge`;
CREATE TABLE IF NOT EXISTS `menge` (
  `menge_id` int(11) NOT NULL AUTO_INCREMENT,
  `bezeichnung` varchar(40) NOT NULL,
  `einheit` varchar(40) DEFAULT 'gr',
  `beschreibung` text,
  `aktiv` tinyint(1) DEFAULT '1',
  `loeschbar` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`menge_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `menge`
--

INSERT INTO `menge` (`menge_id`, `bezeichnung`, `einheit`, `beschreibung`, `aktiv`, `loeschbar`) VALUES
(1, '20', 'gr', NULL, 1, 0),
(2, '50', 'gr', NULL, 1, 0),
(3, '100', 'gr', NULL, 1, 0),
(4, '125', 'gr', NULL, 1, 0),
(5, '150', 'gr', NULL, 1, 0),
(6, '180', 'gr', NULL, 1, 0),
(7, '200', 'gr', NULL, 1, 0),
(8, '225', 'gr', NULL, 1, 0),
(9, '250', 'gr', NULL, 1, 0),
(10, '375', 'gr', NULL, 1, 0),
(11, '500', 'gr', NULL, 1, 0),
(12, '20', 'ml', NULL, 1, 0),
(13, '50', 'ml', NULL, 1, 0),
(14, '100', 'ml', NULL, 1, 0),
(15, '125', 'ml', NULL, 1, 0),
(16, '150', 'ml', NULL, 1, 0),
(17, '180', 'ml', NULL, 1, 0),
(18, '200', 'ml', NULL, 1, 0),
(19, '225', 'ml', NULL, 1, 0),
(20, '250', 'ml', NULL, 1, 0),
(21, '375', 'ml', NULL, 1, 0),
(22, '500', 'ml', NULL, 1, 0),
(23, '1', 'St', NULL, 1, 0),
(24, '2', 'St', NULL, 1, 0),
(25, '3', 'St', NULL, 1, 0),
(26, '4', 'St', NULL, 1, 0),
(27, '5', 'St', NULL, 1, 0),
(28, '6', 'St', NULL, 1, 0),
(29, '7', 'St', NULL, 1, 0),
(30, '8', 'St', NULL, 1, 0),
(31, '9', 'St', NULL, 1, 0),
(32, '10', 'St', NULL, 1, 0),
(33, '15', 'St', NULL, 1, 0),
(34, '1', 'Prise', NULL, 1, 0),
(35, '2', 'Prise', NULL, 1, 0),
(36, '3', 'Prise', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rezept`
--

DROP TABLE IF EXISTS `rezept`;
CREATE TABLE IF NOT EXISTS `rezept` (
  `rezept_id` int(11) NOT NULL AUTO_INCREMENT,
  `initial_id` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `bezeichnung` varchar(40) DEFAULT NULL,
  `beschreibung` text NOT NULL,
  `eingetragen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `zubereitungshinweise` text,
  `aktiv` tinyint(1) DEFAULT '1',
  `loeschbar` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`rezept_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `rezept`
--

INSERT INTO `rezept` (`rezept_id`, `initial_id`, `parent_id`, `bezeichnung`, `beschreibung`, `eingetragen`, `zubereitungshinweise`, `aktiv`, `loeschbar`) VALUES
(1, 1, 0, 'Schnitzel, Salzkartoffeln, Sauerkraut', 'Schnitzel, Salzkartoffeln, Erbsen', '2020-04-03 06:57:37', NULL, 1, 0),
(2, 2, 0, 'Zigeunersteak', 'Zigeunersteak, Pommes', '2020-04-03 06:57:11', 'Zigeunersteak, Pommes\r\nSchweinesteak mit Letscho', 1, 0),
(3, 3, 0, 'Gulasch', 'Gulasch, Rotkohl, Kartoffeln', '2020-04-03 06:56:10', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rezeptteil`
--

DROP TABLE IF EXISTS `rezeptteil`;
CREATE TABLE IF NOT EXISTS `rezeptteil` (
  `rezeptteil_id` int(11) NOT NULL AUTO_INCREMENT,
  `initial_id` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `speisekomponente_id` int(11) NOT NULL,
  `rezept_id` int(11) NOT NULL,
  `bezeichnung` varchar(40) NOT NULL,
  `beschreibung` text,
  `eingetragen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `aktiv` tinyint(1) DEFAULT '1',
  `loeschbar` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`rezeptteil_id`),
  KEY `fk_rezept_id_idx` (`rezept_id`),
  KEY `fk_speisekomponente_id_idx` (`speisekomponente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `rezeptteil`
--

INSERT INTO `rezeptteil` (`rezeptteil_id`, `initial_id`, `parent_id`, `speisekomponente_id`, `rezept_id`, `bezeichnung`, `beschreibung`, `eingetragen`, `aktiv`, `loeschbar`) VALUES
(1, 1, 0, 3, 1, 'Schnitzel', NULL, '2020-04-03 07:00:41', 1, 0),
(2, 2, 0, 2, 1, 'Salzkartoffeln', 'Salzkartoffeln', '2020-04-03 07:00:41', 1, 0),
(3, 3, 0, 1, 1, 'gekochtes Sauerkraut', 'gekochtes und gebundenes Sauerkraut', '2020-04-03 07:00:41', 1, 0),
(4, 3, 3, 12, 1, 'Schnitzel, Salzkartoffeln, Erbsen', 'Sauerkraut passt nicht zu diesem Gericht, daher ersetzen wir dies durch Erbsen.', '2020-04-03 08:57:15', 1, 0),
(5, 5, 0, 6, 2, 'Zigeunersteak', 'oder Steak Letscho', '2020-04-03 09:14:27', 1, 0),
(6, 6, 0, 7, 2, 'Pommes', 'Zigeuner mit Pommes', '2020-04-03 09:15:36', 1, 0),
(7, 7, 0, 13, 2, 'Zigeunersoße', 'Soße für Zigeunersteak, Bratwurst oder Frikadelle... \r\nAlternativbezeichnung: Balkansteak :-|', '2020-04-03 09:14:27', 1, 0),
(8, 8, 0, 14, 3, 'Gulasch S/R', 'Gulasch aus Schwein und Rind', '2020-04-03 09:14:27', 1, 0),
(9, 9, 0, 15, 3, 'Rotkohl', 'Rotkohl für Gulasch', '2020-04-03 09:14:27', 1, 0),
(10, 10, 0, 2, 3, 'Salzkartoffeln', 'Salzkartoffeln für Gulasch', '2020-04-03 09:14:27', 1, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `speisekategorie`
--

DROP TABLE IF EXISTS `speisekategorie`;
CREATE TABLE IF NOT EXISTS `speisekategorie` (
  `speisekategorie_id` int(11) NOT NULL AUTO_INCREMENT,
  `speisekategorie_bezeichnung` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`speisekategorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `speisekategorie`
--

INSERT INTO `speisekategorie` (`speisekategorie_id`, `speisekategorie_bezeichnung`) VALUES
(1, 'Sättigungsbeilage'),
(2, 'Gemüsebeilage'),
(3, 'Fleischbeilage'),
(4, 'Suppen'),
(5, 'Vorspeise'),
(6, 'Dessert'),
(7, 'Hauptbestandteil'),
(8, 'Speiseteil');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `speisekomponente`
--

DROP TABLE IF EXISTS `speisekomponente`;
CREATE TABLE IF NOT EXISTS `speisekomponente` (
  `speisekomponente_id` int(11) NOT NULL AUTO_INCREMENT,
  `initial_id` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `menge_id` int(11) NOT NULL,
  `ingredienz_id` int(11) NOT NULL,
  `bezeichnung` varchar(40) NOT NULL,
  `beschreibung` text,
  `eingetragen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `zubereitungsart_id` int(11) DEFAULT NULL,
  `speisekategorie_id` int(11) DEFAULT NULL,
  `aktiv` tinyint(1) DEFAULT '1',
  `loeschbar` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`speisekomponente_id`),
  KEY `fk_ingredienz_id_idx` (`ingredienz_id`),
  KEY `fk_menge_id_idx` (`menge_id`),
  KEY `fk_zubereitungsart_id_idx` (`zubereitungsart_id`),
  KEY `fk_speisekategorie_idx` (`speisekategorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `speisekomponente`
--

INSERT INTO `speisekomponente` (`speisekomponente_id`, `initial_id`, `parent_id`, `menge_id`, `ingredienz_id`, `bezeichnung`, `beschreibung`, `eingetragen`, `zubereitungsart_id`, `speisekategorie_id`, `aktiv`, `loeschbar`) VALUES
(1, 1, 0, 5, 6, 'gekochtes Sauerkraut', NULL, '2020-04-03 05:04:17', 2, 2, 1, 0),
(2, 2, 0, 5, 1, 'Salzkartoffeln', NULL, '2020-04-03 05:04:17', 2, 1, 1, 0),
(3, 3, 0, 4, 10, 'Schweineschnitzel Wiener Art', 'Schweineschnitzel Wiener Art', '2020-04-03 05:04:17', 1, 3, 1, 0),
(4, 4, 0, 23, 17, 'Scheibe(n) Brot', 'eine oder mehrere Scheiben Brot', '2020-04-01 14:25:19', 9, 1, 1, 0),
(5, 5, 0, 24, 15, '2 Spiegeleier', '2 Setzeier', '2020-04-01 14:25:19', 1, 1, 1, 0),
(6, 6, 0, 5, 14, 'Zigeunersteak', 'Schweinesteak mit Zigeunersoße oder Letscho.', '2020-04-03 05:08:59', 1, 3, 1, 0),
(7, 7, 0, 5, 1, 'Pommes Frites', 'fritierte Kartoffeln', '2020-04-03 05:08:59', 7, 1, 1, 0),
(8, 0, 0, 3, 37, 'Röstzwiebeln', 'Röstzwiebeln', '2020-04-03 05:19:15', 1, 8, 1, 0),
(9, 0, 0, 5, 1, 'Bratkartoffeln', 'Bratkartoffeln sind rohe in Scheiben geschnittene Kartoffeln.', '2020-04-03 05:19:15', 1, 1, 1, 0),
(10, 0, 0, 4, 21, 'Bratwurst', 'Bratwurst meist zw. 100-125g', '2020-04-03 05:22:52', 1, 3, 1, 0),
(11, 0, 0, 5, 8, 'Kartoffelbrei', 'Kartoffelbrei normale Portion', '2020-04-03 05:22:52', 2, 1, 1, 0),
(12, 0, 0, 5, 3, 'Zuckererbsen', 'Erbsen gekocht mit Butterflocken, etwas Zucker', '2020-04-03 08:55:50', 2, 2, 1, 0),
(13, 0, 0, 4, 25, 'Zigeunersoße', 'Zigeunersoße ist im Wesentlichen Letscho, welche noch etwas verfeinert wird.', '2020-04-03 09:03:17', 2, 8, 1, 0),
(14, 14, 0, 5, 18, 'Gulasch S/R', 'Gulasch aus Schwein und Rind', '2020-04-03 09:10:51', 6, 3, 1, 0),
(15, 15, 0, 5, 5, 'Rotkraut', 'gekochtes und gebundenes Rotkraut', '2020-04-03 09:10:51', 2, 2, 1, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `wochenplan`
--

DROP TABLE IF EXISTS `wochenplan`;
CREATE TABLE IF NOT EXISTS `wochenplan` (
  `wochenplan_id` int(11) NOT NULL AUTO_INCREMENT,
  `initial_id` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `rezept_id_mo` int(11) DEFAULT '1',
  `rezept_id_di` int(11) DEFAULT '2',
  `rezept_id_mi` int(11) DEFAULT '3',
  `rezept_id_do` int(11) DEFAULT '4',
  `rezept_id_fr` int(11) DEFAULT '5',
  `rezept_id_sa` int(11) DEFAULT '6',
  `rezept_id_so` int(11) DEFAULT '7',
  `bezeichnung` varchar(40) NOT NULL,
  `beschreibung` text,
  `eingetragen` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `aktiv` tinyint(1) DEFAULT '1',
  `loeschbar` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`wochenplan_id`),
  KEY `fk_rezepte_id_mo_idx` (`rezept_id_mo`),
  KEY `fk_rezepte_id_di_idx` (`rezept_id_di`),
  KEY `fk_rezept_id_mi_idx` (`rezept_id_mi`),
  KEY `fk_rezept_id_do_idx` (`rezept_id_do`),
  KEY `fk_rezept_id_fr_idx` (`rezept_id_fr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zubereitungsart`
--

DROP TABLE IF EXISTS `zubereitungsart`;
CREATE TABLE IF NOT EXISTS `zubereitungsart` (
  `zubereitungsart_id` int(11) NOT NULL AUTO_INCREMENT,
  `zubereitungsart_bezeichnung` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`zubereitungsart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `zubereitungsart`
--

INSERT INTO `zubereitungsart` (`zubereitungsart_id`, `zubereitungsart_bezeichnung`) VALUES
(1, 'braten'),
(2, 'kochen'),
(3, 'backen'),
(4, 'dämpfen'),
(5, 'pochieren'),
(6, 'schmoren'),
(7, 'fritieren'),
(8, 'grillen'),
(9, 'roh');

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `bestellzettel`
--
ALTER TABLE `bestellzettel`
  ADD CONSTRAINT `fk_familien_id` FOREIGN KEY (`familie_id`) REFERENCES `familie` (`familie_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_wochenplan_id` FOREIGN KEY (`wochenplan_id`) REFERENCES `wochenplan` (`wochenplan_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `bestellzetteleintrag`
--
ALTER TABLE `bestellzetteleintrag`
  ADD CONSTRAINT `fk_bestellzettel_id` FOREIGN KEY (`bestellzettel_id`) REFERENCES `bestellzettel` (`bestellzettel_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ingredienz_id` FOREIGN KEY (`ingredienz_id`) REFERENCES `ingredienz` (`ingredienz_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `familienwochenplan`
--
ALTER TABLE `familienwochenplan`
  ADD CONSTRAINT `familienwochenplan_ibfk_1` FOREIGN KEY (`wochenplan_id`) REFERENCES `wochenplan` (`wochenplan_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `familienwochenplan_ibfk_2` FOREIGN KEY (`familie_id`) REFERENCES `familie` (`familie_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `rezeptteil`
--
ALTER TABLE `rezeptteil`
  ADD CONSTRAINT `rezeptteil_ibfk_1` FOREIGN KEY (`rezept_id`) REFERENCES `rezept` (`rezept_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `rezeptteil_ibfk_2` FOREIGN KEY (`speisekomponente_id`) REFERENCES `speisekomponente` (`speisekomponente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `speisekomponente`
--
ALTER TABLE `speisekomponente`
  ADD CONSTRAINT `speisekomponente_ibfk_1` FOREIGN KEY (`zubereitungsart_id`) REFERENCES `zubereitungsart` (`zubereitungsart_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `speisekomponente_ibfk_2` FOREIGN KEY (`ingredienz_id`) REFERENCES `ingredienz` (`ingredienz_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `speisekomponente_ibfk_3` FOREIGN KEY (`menge_id`) REFERENCES `menge` (`menge_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `speisekomponente_ibfk_4` FOREIGN KEY (`speisekategorie_id`) REFERENCES `speisekategorie` (`speisekategorie_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `wochenplan`
--
ALTER TABLE `wochenplan`
  ADD CONSTRAINT `fk_rezept_id_di` FOREIGN KEY (`rezept_id_di`) REFERENCES `rezept` (`rezept_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rezept_id_do` FOREIGN KEY (`rezept_id_do`) REFERENCES `rezept` (`rezept_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rezept_id_fr` FOREIGN KEY (`rezept_id_fr`) REFERENCES `rezept` (`rezept_id`) ON DELETE NO ACTION ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_rezept_id_mi` FOREIGN KEY (`rezept_id_mi`) REFERENCES `rezept` (`rezept_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rezept_id_mo` FOREIGN KEY (`rezept_id_mo`) REFERENCES `rezept` (`rezept_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;
