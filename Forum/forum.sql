-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 17. Aug 2013 um 17:39
-- Server Version: 5.5.27
-- PHP-Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `forum`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `forum_categories`
--

CREATE TABLE IF NOT EXISTS `forum_categories` (
  `ID` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `position` int(255) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` int(1) NOT NULL COMMENT '0 = Categorie; 1 = Forum',
  `main_categorie` int(255) NOT NULL,
  `active` int(1) NOT NULL COMMENT '0 = not visible; 1 = visible',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Daten für Tabelle `forum_categories`
--

INSERT INTO `forum_categories` (`ID`, `position`, `name`, `description`, `type`, `main_categorie`, `active`) VALUES
(33, 1, 'Allgemeines', '', 0, 0, 1),
(22, 2, 'Gildeninternes', 'Das hat die CIA nix anzugehen!', 0, 0, 1),
(23, 3, 'Abwesenheitsnotizen', 'Urlaube - längerer Ausfall - etc.', 1, 1, 1),
(25, 1, 'Abwesenheitsnotizen', 'Urlaube - längerer Ausfall - etc.', 1, 22, 1),
(36, 3, 'Offtopic', 'Für Fun, Wortsalat & mehr.', 1, 22, 1),
(27, 3, 'Raidplanung', 'Raidkalender. Eventkalender.', 0, 0, 1),
(35, 1, 'Verbesserungsvorschläge und Ideeen', 'Schwarzes Brett für alle Ideeen & Kritiken', 1, 33, 1),
(30, 1, 'Raidgruppe I', '', 1, 27, 1),
(31, 2, 'Radgruppe II', '', 1, 27, 1),
(32, 5, 'Eventkalender', 'Eventplanung', 1, 27, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `forum_posts`
--

CREATE TABLE IF NOT EXISTS `forum_posts` (
  `ID` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(255) NOT NULL,
  `fid` int(255) NOT NULL,
  `username` varchar(60) NOT NULL,
  `topic` varchar(60) NOT NULL,
  `text` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90 ;

--
-- Daten für Tabelle `forum_posts`
--

INSERT INTO `forum_posts` (`ID`, `tid`, `fid`, `username`, `topic`, `text`, `created`) VALUES
(9, 4, 26, 'Nazjatar', 'Testthema', 'Testereitotaletesterei!', '2013-06-17 18:49:43'),
(10, 5, 31, 'Katejo', 'Raid Dienstag 18. Juni', 'Wer ist ab 21:00 Uhr alles dabei ?\\r\\n\\r\\nIch bin da.', '2013-06-17 20:31:57'),
(11, 5, 31, 'Ysefv', 'Re: Raid Dienstag 18. Juni', 'Falls ihr noch einen DD oder Heiler Braucht helfe ich gerne aus\r\n\r\nMFG\r\n\r\nYsefv', '2013-06-17 20:32:59'),
(12, 5, 31, 'Cali', 'Re: Raid Dienstag 18. Juni', 'Dabei', '2013-06-17 20:34:44'),
(13, 6, 30, 'Ysefv', 'Raid am Donnerstag wer ist dabei', 'bitte einmal Eintargen wer am Donnerstag dabei ist THX', '2013-06-17 20:36:06'),
(14, 6, 30, 'Cali', 'Re: Raid am Donnerstag wer ist dabei', 'dabei', '2013-06-17 20:36:31'),
(15, 5, 31, 'Nazjatar', 'Re: Raid Dienstag 18. Juni', 'Wie immer!', '2013-06-17 20:46:48'),
(16, 5, 31, 'Kandala', 'Re: Raid Dienstag 18. Juni', 'Bin dabei', '2013-06-17 20:51:56'),
(17, 6, 30, 'Nadja', 'Re: Raid am Donnerstag wer ist dabei', 'Dabei', '2013-06-18 10:06:52'),
(18, 7, 31, 'Nazjatar', 'Raid Mittwoch 19. Juni', 'Dabei!', '2013-06-18 18:06:56'),
(19, 7, 31, 'Kandala', 'Re: Raid Mittwoch 19. Juni', 'dabei', '2013-06-18 18:42:52'),
(20, 7, 31, 'Cali', 'Re: Raid Mittwoch 19. Juni', 'dabei', '2013-06-18 21:07:46'),
(21, 7, 31, 'Nadja', 'Re: Raid Mittwoch 19. Juni', 'dabei', '2013-06-19 10:19:03'),
(22, 7, 31, 'Avioid', 'Re: Raid Mittwoch 19. Juni', 'dei mudda', '2013-06-19 19:20:40'),
(23, 6, 30, 'Cassíya', 'Re: Raid am Donnerstag wer ist dabei', 'Dabei.', '2013-06-20 14:32:51'),
(24, 6, 30, 'Crypter', 'Re: Raid am Donnerstag wer ist dabei', 'na gut ok', '2013-06-20 15:41:22'),
(25, 8, 31, 'Katejo', 'Raid  23. Juni', 'Wer ist am Sonntag da?', '2013-06-20 17:00:11'),
(26, 8, 31, 'Katejo', 'Re: Raid  23. Juni', 'Sollte da sein.', '2013-06-20 17:00:48'),
(27, 8, 31, 'Nazjatar', 'Re: Raid  23. Juni', 'Sonntag... Jo denke dass ich da bin!', '2013-06-21 06:20:30'),
(28, 8, 31, 'Kandala', 'Re: Raid  23. Juni', 'Bin da', '2013-06-21 17:57:26'),
(29, 9, 31, 'Nazjatar', 'Raid Dienstag, 25. Juni', 'Dabei', '2013-06-24 08:02:46'),
(30, 9, 31, 'Katejo', 'Re: Raid Dienstag, 25. Juni', 'Bin auch da', '2013-06-24 14:02:13'),
(31, 9, 31, 'Cali', 'Re: Raid Dienstag, 25. Juni', 'dabei', '2013-06-24 14:35:14'),
(32, 9, 31, 'Ronik', 'Re: Raid Dienstag, 25. Juni', 'Am Start', '2013-06-24 17:55:09'),
(33, 9, 31, 'Kandala', 'Re: Raid Dienstag, 25. Juni', 'dabei', '2013-06-25 09:07:33'),
(34, 9, 31, 'Katejo', 'Re: Raid Dienstag, 25. Juni', 'Enviolatas sagte gestern er wäre auch da, als Heiler oder DD', '2013-06-25 12:35:58'),
(35, 10, 31, 'Katejo', 'Mittwoch 26. Juni', 'Wer ist ab wann da?', '2013-06-25 12:37:07'),
(36, 10, 31, 'Ronik', 'Re: Mittwoch 26. Juni', 'Ausnahmsweise auch mal ab 20 Uhr da :)', '2013-06-25 13:20:13'),
(37, 10, 31, 'Kandala', 'Re: Mittwoch 26. Juni', 'bin schon um 17Uhr da :-D', '2013-06-25 17:13:05'),
(38, 10, 31, 'Cali', 'Re: Mittwoch 26. Juni', 'Kann den ganzen Tag', '2013-06-25 17:24:43'),
(39, 11, 30, 'Cali', 'Raid am Do 270613', 'Tarry, Crypter und meiner einer sind Donnerstag nicht dabei.', '2013-06-25 18:00:22'),
(40, 10, 31, 'Nazjatar', 'Re: Mittwoch 26. Juni', 'Urlaub Baby!', '2013-06-25 18:44:02'),
(41, 10, 31, 'Avioid', 'Re: Mittwoch 26. Juni', 'dabei', '2013-06-25 18:52:24'),
(42, 9, 31, 'Avioid', 'Re: Raid Dienstag, 25. Juni', 'dabei', '2013-06-25 18:52:48'),
(43, 12, 35, 'Cali', 'Website', 'Bitte mal schreiben, was so fehlt oder verbessert werden kann.', '2013-06-25 21:47:09'),
(44, 12, 35, 'Naztar', 'Re: Website', 'Nur als Notiz, denn du weißt es ja schon:\r\n\r\n- Forumsymbole für neue Beiträge\r\n- Forenanpassung Farblich (weg von dem Augenkrebsrot)\r\n- Forenanpassung Beiträge (Übersicht wer, wann gepostet hat)\r\n- Mein Char heißt jetzt Naztar :P', '2013-06-26 22:33:09'),
(45, 12, 35, 'Naztar', 'Re: Website', '- Bestätigungsseite nach Registrierung', '2013-06-26 22:33:34'),
(46, 13, 25, 'Naztar', 'Thread falls das selbsterstellen nicht funzt -&gt; hier eint', 'Bittsche', '2013-06-29 15:40:39'),
(47, 13, 25, 'Ronik', 'Re: Thread falls das selbsterstellen nicht funzt -&gt; hier ', 'Hey zusammen!\r\n\r\nIch bin vom 2.7. bis 10.7. im Urlaub in Südfrankreich - von daher dürft ihr die nächsten 2 IDs endlich mal mit nem richtigen DD clearen ;)', '2013-06-29 15:42:51'),
(48, 13, 25, 'Avioid', 'Re: Thread falls das selbsterstellen nicht funzt -&gt; hier ', 'Moin Moin,\r\n\r\nich bin ja wie bereits angekündigt vom 01.07. bis 08.07. im Urlaub in Spanien.\r\n\r\nViel Erfolg euch mit dem Raiden.', '2013-06-30 20:42:32'),
(49, 13, 25, 'Pendragona', 'Re: Thread falls das selbsterstellen nicht funzt -&gt; hier ', 'Bin ab Montag 08.Juli bis Sonntag 14. Juli auch Weg,\r\ndann aber wieder da für Raids!\r\nVesteh den "Raidplaner" hier im Forum nicht?! Letzter Raid war im Juni??? Was muss ich machen, jede Woche bin da reinschreiben? Ist doch Quatsch - da war WA besser. Habe bis nächste Woche kein internetfähiges Handy (Reperatur)!', '2013-07-04 05:27:48'),
(50, 14, 31, 'Katejo', 'Di 9. Juli', 'Wer ist da und ab wann?', '2013-07-07 07:14:24'),
(51, 14, 31, 'Cali', 'Re: Di 9. Juli', 'Dabei', '2013-07-07 16:14:21'),
(52, 14, 31, 'Naztar', 'Re: Di 9. Juli', 'dabei', '2013-07-07 20:25:14'),
(53, 14, 31, 'Cassíya', 'Re: Di 9. Juli', 'Also ich bin ab 19uhr oder so on.', '2013-07-08 05:42:01'),
(54, 14, 31, 'Nadja', 'Re: Di 9. Juli', 'Kann auch ab 19 uhr', '2013-07-08 07:32:00'),
(55, 14, 31, 'Kandala', 'Re: Di 9. Juli', 'Bin wenn alles gut läuft um 21Uhr da', '2013-07-08 17:42:17'),
(56, 15, 30, 'Cali', 'Raid Do 11.07 und So 14.07.', 'Bitte mitteilen wer alles am Do und So da ist.', '2013-07-08 19:41:56'),
(57, 14, 31, 'Naztar', 'Re: Di 9. Juli', 'Was is mit Phil?', '2013-07-09 17:50:38'),
(58, 16, 31, 'Kandala', 'Mi, 10.07', 'Wer kann wann?', '2013-07-09 20:04:11'),
(59, 16, 31, 'Nadja', 'Re: Mi, 10.07', 'Ab 20 uhr', '2013-07-10 07:41:53'),
(60, 16, 31, 'Cassíya', 'Re: Mi, 10.07', 'Ab ca. 21uhr.', '2013-07-10 15:14:29'),
(61, 16, 31, 'Cali', 'Re: Mi, 10.07', 'zwischen 2000 und 2100', '2013-07-10 15:50:02'),
(62, 15, 30, 'Cali', 'Re: Raid Do 11.07 und So 14.07.', 'Nicht dabei, da zum Grillen eingeladen', '2013-07-10 15:51:02'),
(63, 15, 30, 'Cassíya', 'Re: Raid Do 11.07 und So 14.07.', 'Bin ab ca. 20uhr dabei.', '2013-07-11 14:09:22'),
(64, 15, 30, 'Nadja', 'Re: Raid Do 11.07 und So 14.07.', 'Sonntag ab 20 Uhr on', '2013-07-11 20:00:42'),
(65, 13, 25, 'Ysefv', 'Re: Thread falls das selbsterstellen nicht funzt -&gt; hier ', 'Bin vom 12.07.2013 bis zum 21.07.2013 nicht da.\r\nSorry das ich erst jetzt euch informiere.', '2013-07-11 21:59:37'),
(66, 13, 25, 'Ysefv', 'Re: Thread falls das selbsterstellen nicht funzt -&gt; hier ', 'Bin in Berlin (Blankenfelde & Falkensee) habe Handy dabei', '2013-07-11 22:01:28'),
(67, 13, 25, 'Naztar', 'Re: Thread falls das selbsterstellen nicht funzt -&gt; hier ', 'Zockst jetzt übers Handy?', '2013-07-12 13:10:53'),
(68, 17, 31, 'Katejo', 'So. 14.07', 'Schubdi wer ist auch noch da und was machen wir? :)', '2013-07-12 16:40:19'),
(69, 17, 31, 'Kandala', 'Re: So. 14.07', 'Ich bin dabei.\r\nA&V HC wenn das Setup passt, ansonsten irgendwas im SM Mode.', '2013-07-13 12:17:54'),
(70, 17, 31, 'Ronik', 'Re: So. 14.07', 'Müsste klappen, krieg vor 20 Uhr vielleicht Besuch, aber der tangiert mich selbst eigentlich nur periphär^^', '2013-07-13 20:56:34'),
(71, 18, 31, 'Kandala', 'Di, 17.07.2013', 'Test', '2013-07-15 17:22:57'),
(72, 18, 31, 'Kandala', 'Re: Di, 17.07.2013', 'Dabei binum ca 21Uhr da, wenn es später werde sollte geben ich vorher bescheid', '2013-07-15 17:23:51'),
(73, 18, 31, 'Nadja', 'Re: Di, 17.07.2013', 'dabei', '2013-07-15 18:21:36'),
(74, 18, 31, 'Naztar', 'Re: Di, 17.07.2013', 'Noch nicht ganz sicher. Geb euch aber vor 21 Uhr bescheid.', '2013-07-16 10:06:24'),
(75, 18, 31, 'Cali', 'Re: Di, 17.07.2013', 'anwesend', '2013-07-16 10:57:11'),
(76, 18, 31, 'Ronik', 'Re: Di, 17.07.2013', 'Werde da sein.', '2013-07-16 13:19:56'),
(77, 18, 31, 'Cassíya', 'Re: Di, 17.07.2013', 'bin auch da.', '2013-07-16 17:24:59'),
(78, 19, 31, 'Kandala', 'So, 21.07.2013', 'Dabei', '2013-07-19 15:20:23'),
(79, 19, 31, 'Katejo', 'Re: So, 21.07.2013', 'Bin auch da', '2013-07-19 16:15:46'),
(80, 19, 31, 'Naztar', 'Re: So, 21.07.2013', 'Sollte auch da sein', '2013-07-19 20:41:42'),
(81, 19, 31, 'Cassíya', 'Re: So, 21.07.2013', 'Wenn nix dazwischen kommt bin ich dabei.', '2013-07-20 09:04:50'),
(82, 13, 25, 'Kandala', 'Re: Thread falls das selbsterstellen nicht funzt -&gt; hier ', 'Vom 23.07 bis zum 01.08 bin ich nicht da. Bin vielleicht ab und zu mal on aber zu den Raids nicht.', '2013-07-21 09:39:53'),
(83, 12, 35, 'Naztar', 'Re: Website', 'Kann man davon ausgehen, dass an der Seite nicht mehr gearbeitet wird? Hier passiert ja seit geraumer Zeit nix mehr.', '2013-07-30 12:56:14'),
(84, 20, 36, 'Naztar', 'Wars das mit Homepagebearbeitung?', 'Kann man davon ausgehen, dass an der Seite nicht mehr gearbeitet wird? Hier passiert ja seit geraumer Zeit nix mehr.', '2013-07-31 11:39:06'),
(85, 21, 31, 'Kandala', 'So, 04.08.2013', 'Dabei', '2013-08-02 18:42:28'),
(86, 21, 31, 'Cali', 'Re: So, 04.08.2013', 'dabei', '2013-08-02 19:39:09'),
(87, 21, 31, 'Naztar', 'Re: So, 04.08.2013', 'Not shure', '2013-08-03 13:19:19'),
(88, 13, 25, 'Katejo', 'Re: Thread falls das selbsterstellen nicht funzt -&gt; hier ', 'Ich bin von Samstag den 17. bis Mittwoch 21. oder evtl auch erst Donnerstag abend nicht da.', '2013-08-14 20:54:55'),
(89, 13, 25, 'Citan', 'Re: Thread falls das selbsterstellen nicht funzt -&gt; hier ', '17-24.8.2013 in Holland', '2013-08-14 21:02:04');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `forum_threads`
--

CREATE TABLE IF NOT EXISTS `forum_threads` (
  `ID` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `fid` int(255) NOT NULL,
  `topic` varchar(60) NOT NULL,
  `closed` int(11) NOT NULL DEFAULT '0' COMMENT '0 = open; 1 = closed',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Daten für Tabelle `forum_threads`
--

INSERT INTO `forum_threads` (`ID`, `fid`, `topic`, `closed`, `created`) VALUES
(4, 26, 'Testthema', 0, '2013-06-17 18:49:43'),
(5, 31, 'Raid Dienstag 18. Juni', 0, '2013-06-17 20:31:57'),
(6, 30, 'Raid am Donnerstag wer ist dabei', 0, '2013-06-17 20:36:06'),
(7, 31, 'Raid Mittwoch 19. Juni', 0, '2013-06-18 18:06:56'),
(8, 31, 'Raid  23. Juni', 0, '2013-06-20 17:00:11'),
(9, 31, 'Raid Dienstag, 25. Juni', 0, '2013-06-24 08:02:46'),
(10, 31, 'Mittwoch 26. Juni', 0, '2013-06-25 12:37:07'),
(11, 30, 'Raid am Do 270613', 0, '2013-06-25 18:00:22'),
(12, 35, 'Website', 0, '2013-06-25 21:47:09'),
(13, 25, 'Thread falls das selbsterstellen nicht funzt -&gt; hier eint', 0, '2013-06-29 15:40:39'),
(14, 31, 'Di 9. Juli', 0, '2013-07-07 07:14:24'),
(15, 30, 'Raid Do 11.07 und So 14.07.', 0, '2013-07-08 19:41:56'),
(16, 31, 'Mi, 10.07', 0, '2013-07-09 20:04:11'),
(17, 31, 'So. 14.07', 0, '2013-07-12 16:40:19'),
(18, 31, 'Di, 17.07.2013', 0, '2013-07-15 17:22:57'),
(19, 31, 'So, 21.07.2013', 0, '2013-07-19 15:20:23'),
(20, 36, 'Wars das mit Homepagebearbeitung?', 0, '2013-07-31 11:39:06'),
(21, 31, 'So, 04.08.2013', 0, '2013-08-02 18:42:28');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `forum_gelesen`
--

CREATE TABLE IF NOT EXISTS `forum_gelesen` (
  `ID` int(255) NOT NULL,
  `Forum_ID` int(255) NOT NULL,
  `Thread_ID` int(255) NOT NULL,
  `Kategorie_ID` int(255) NOT NULL,
  `Username` varchar(60) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------