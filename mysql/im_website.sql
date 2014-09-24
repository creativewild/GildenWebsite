-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 07. Okt 2013 um 23:40
-- Server Version: 5.5.27
-- PHP-Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `im_website`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bewerbung`
--

CREATE TABLE IF NOT EXISTS `bewerbung` (
  `Bewerbung_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Charname` varchar(20) NOT NULL,
  `Rasse` varchar(60) NOT NULL,
  `Klasse` varchar(60) NOT NULL,
  `Ausrichtung` varchar(60) NOT NULL,
  `Warum` varchar(1000) NOT NULL,
  `Vorlieben` varchar(60) NOT NULL,
  `Zeit` char(5) NOT NULL,
  `Zusatz` varchar(1000) NOT NULL,
  `Mo` char(6) DEFAULT NULL,
  `Di` char(8) DEFAULT NULL,
  `Mi` char(8) DEFAULT NULL,
  `Do` char(10) DEFAULT NULL,
  `Fr` char(7) DEFAULT NULL,
  `Sa` char(7) DEFAULT NULL,
  `So` char(7) DEFAULT NULL,
  `JT` char(9) DEFAULT NULL,
  `alter` varchar(20) NOT NULL DEFAULT 'ohne Angabe',
  `Aufgenommen` tinyint(1) NOT NULL DEFAULT '0',
  `Bearbeitung` tinyint(1) NOT NULL DEFAULT '0',
  `Grund` varchar(1000) NOT NULL,
  PRIMARY KEY (`Bewerbung_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Daten für Tabelle `bewerbung`
--

INSERT INTO `bewerbung` (`Bewerbung_ID`, `Charname`, `Rasse`, `Klasse`, `Ausrichtung`, `Warum`, `Vorlieben`, `Zeit`, `Zusatz`, `Mo`, `Di`, `Mi`, `Do`, `Fr`, `Sa`, `So`, `JT`, `alter`, `Aufgenommen`, `Bearbeitung`, `Grund`) VALUES
(10, 'umu', 'Mensch', 'Sith-Inquisitor', 'Heal', 'Suche Aktive Raidgilde um weiter zukommen', 'PVE', '15:00', 'Habe Wechselschicht und muss jeder Woche umfahren aber wenn ich weis wann ein raid ist bin ich da wenn ich mich angemeldet habe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jt', 'ohne Angabe', 0, 1, ''),
(11, 'Tuckitucki', 'Mensch', 'Sith-Krieger', 'Tank', 'suche eine aktive Raid Gilde. Da in der Gilde, wo ich jetzt ', 'PVE', '11:00', 'hab nen knall seid nachsichtig^^', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jt', 'ohne Angabe', 0, 1, ''),
(13, 'Nêxx', 'Mensch', 'Sith-Krieger', 'DDmelee', 'Hi Imperial March,<br />\r\n<br />\r\nhiermit bewerbe ich mich (', 'PVE', '16:00', 'Hier würde ich uns gerne noch einmal vorstellen: Wir sind 19-20 Jahre alt und kommen aus Niedersachsen. Da wir oft zusammen zocken, war es für uns eigentlich klar dass wir gemeinsam einer Gilde beitreten wollen.<br />\r\n<br />\r\nSpieler:<br />\r\n<br />\r\nTim 19 Jahre, Ingame: Nêxx, Marauder<br />\r\nMarcel 19 Jahre, Ingame: Râyy, Sorcerer<br />\r\nDaniel 20 Jahre, Ingame: [Pending], Imperialer Agent (subclass unentschlossen)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jt', '19', 1, 1, ''),
(14, 'Roheyn', 'Sith', 'Sith-Krieger', 'Tank', 'Eigentlich hatte ich nach vielen erfolgreichen Jahren WOW-Ga', 'PVE', '22:00', 'Zu Onlinezeiten:<br />\nStändig wechselnd aufgrund Schichtdienst und Familienleben. Kernzeiten: 8-16 oder 22 bis 02 Uhr<br />\n<br />\n', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So', NULL, '35', 1, 1, ''),
(16, 'Khrain', 'Mensch', 'Imperialer-Agent', 'DDrange', 'Da ich in das Raidgeschehen wieder mit einsteigen möchte , bin ich auf der Suche nach einer aktiven Raidgilde, welche auch ein schönes Heim für Schichtarbeiter und motivierte Raider bietet.', 'PVE', '15:00', 'Hey Zusammen,<br />\r\n<br />\r\nMein Name ist Daniel, bin 23 Jahre alt und komme aus dem schönen Wien in Österreich.<br />\r\nLeider muss ich schon vorweg sagen, dass ich Schichtarbeiter am Flughafen Wien-Schwechat bin und somit nicht zu allen Raidzeiten online sein kann, was ich aber durch jahrelange MMORPG und Raiderfahrung (WOW seit 2004 - Swtor seit 2012) in Sachen Gameplay und Taktik wieder wettmache.<br />\r\nWeiters bin ich sehr in American Football und Fußball interessiert und habe auch selbst 2 Jahre / 10 Jahre gespielt.<br />\r\n<br />\r\n•Informationen über meinen Hauptcharakter<br />\r\n<br />\r\nOrientierung: PvE<br />\r\n<br />\r\nName: Khrain<br />\r\n<br />\r\nSpezialisierung: MM ( je nachdem was am meisten Spaß macht und wo ich den größtmöglichen Schaden für den Raid erzielen kann)<br />\r\n<br />\r\nRolle : DD<br />\r\n<br />\r\nSpielzeit: wie gesagt, leider Schichtarbeiter ( ich gebe aber rechtzeitig bescheid sollte ein Termin nicht gehen!)<br />\r\n<br />\r\nEquip: Jau hier kommen wir zum Knackpunkt ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jt', '24', 1, 1, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `counter`
--

CREATE TABLE IF NOT EXISTS `counter` (
  `cid` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  `timestamp` int(10) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `counter`
--

INSERT INTO `counter` (`cid`, `ip`, `timestamp`) VALUES
(2, '93.219.201.33', 1371479586);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mediapics`
--

CREATE TABLE IF NOT EXISTS `mediapics` (
  `PIC_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PIC_GROSS` varchar(160) NOT NULL,
  `PIC_KLEIN` varchar(160) NOT NULL,
  `PICDatum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `PIC_Beschreibung` varchar(28) NOT NULL,
  PRIMARY KEY (`PIC_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `mediapics`
--

INSERT INTO `mediapics` (`PIC_ID`, `PIC_GROSS`, `PIC_KLEIN`, `PICDatum`, `PIC_Beschreibung`) VALUES
(2, './img/Gildenfoto/gross/1378401709_b.jpeg', './img/Gildenfoto/klein/1378401709_s.jpeg', '2013-09-11 15:55:32', 'TS Template: Darth Talon'),
(3, './img/Gildenfoto/gross/1378401727_b.jpeg', './img/Gildenfoto/klein/1378401727_s.jpeg', '2013-09-11 15:57:16', 'TS Template: Twilek Clear'),
(4, './img/Gildenfoto/gross/1378406675_b.jpeg', './img/Gildenfoto/klein/1378406675_s.jpeg', '2013-09-05 18:44:35', ''),
(5, './img/Gildenfoto/gross/1378917130_b.png', './img/Gildenfoto/klein/1378917130_s.png', '2013-09-11 16:32:10', 'Desktophintergrund Black&Red'),
(6, './img/Gildenfoto/gross/1379542777_b.jpeg', './img/Gildenfoto/klein/1379542777_s.jpeg', '2013-09-18 22:19:37', 'Asation Karte');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mediavideo`
--

CREATE TABLE IF NOT EXISTS `mediavideo` (
  `Video_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PfadVideo` varchar(160) NOT NULL,
  `VideoDatum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Video_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Daten für Tabelle `mediavideo`
--

INSERT INTO `mediavideo` (`Video_ID`, `PfadVideo`, `VideoDatum`) VALUES
(1, 'KAV7-CVc3Ms', '2013-09-11 23:01:39'),
(2, 'RJuFVtqoU7M', '2013-09-11 23:02:23'),
(3, 'ewAYjbaPQ7E', '2013-09-11 23:09:53'),
(4, '9LHzUndrNHY', '2013-09-11 23:57:03'),
(6, 'owmGmnIcD-c', '2013-09-11 23:58:26'),
(7, 'YDlqzIrQiHw', '2013-09-12 00:00:58');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `NewsID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Titel` varchar(50) NOT NULL,
  `News` varchar(1000) NOT NULL,
  `Bild` varchar(160) NOT NULL,
  PRIMARY KEY (`NewsID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- Daten für Tabelle `news`
--

INSERT INTO `news` (`NewsID`, `Titel`, `News`, `Bild`) VALUES
(10, 'erste News', 'Willkommen auf unser Neuen Seite', './img/Site/News.png'),
(11, 'User und Account fertig', 'Die Seiten "User" und "Account" sind fertig.\r\nDesweiteren ist auf der Startseite eine Geburtstagsübersicht eingebaut.\r\n\r\nMfG\r\n\r\nCali', './img/Site/News.png'),
(12, 'Website', 'Ein weiteres Update ist online.\r\nWer suchet, der findet.\r\n\r\nMfG\r\n\r\nCali', './img/Site/News.png'),
(13, 'Forum in der Open-Beta-Version Online!', 'Endlich ist es soweit! Wir haben ein Forum. Noch ist es\r\nin der Betaphase. Features wie eine Editierfunktion,\r\nSymbole welche neue Beiträge anzeigen, Userbild im Post\r\netc. kommen nach und nach!\r\n\r\nAlso keine Sorge ; Das Forum kommt noch auf seine Kosten.\r\nWichtig ist, dass wir jetzt erst mal diw wichtigesten\r\nSachen schriftlich festhalten können!\r\n\r\nWir hoffen es wird eurerseits gut angenommen und genutzt!\r\n\r\nGreetz das Admin-Team', './img/Site/News.png'),
(14, 'Forum in der Open-Beta-Version Online!', 'Endlich ist es soweit! Wir haben ein Forum. Noch ist es in der Betaphase. Features wie eine Editierfunktion, Symbole welche neue Beiträge anzeigen, Userbild im Post etc. kommen nach und nach!\r\n\r\nAlso keine Sorge ; Das Forum kommt noch auf seine Kosten.\r\nWichtig ist, dass wir jetzt erst mal diw wichtigesten Sachen schriftlich festhalten können!\r\n\r\nWir hoffen es wird eurerseits gut angenommen und genutzt!\r\n\r\nGreetz das Admin-Team', './img/Site/News.png'),
(15, 'Wussten Sie schon?', 'Das Tragen eines Kopfhörers von nur einer Stunde erhöht die Anzahl von Bakterien in deinem Ohr um 700%', './img/Site/I_M_FUN.png'),
(16, 'Wussten Sie schon?', 'Wusstest Du schon?\r\n\r\nDas Tragen eines Kopfhörers von nur einer Stunde erhöht die Anzahl von Bakterien in deinem Ohr um 700%', './img/Site/I_M_FUN.png'),
(17, 'Wussten Sie schon?', 'Wusstest Du schon?\r\n\r\nDer Aztekenherrscher Montezuma hatte einen Neffen namens Cuitlahac. Dieser Name bedeutet übersetzt in etwa "Großer Haufen Scheiße".', './img/Site/I_M_FUN.png'),
(18, 'Wussten Sie schon?', 'Wusstest Du schon?\r\n\r\nDas längste deutsche Wort, in dem sich kein Buchstabe wiederholt ist "Heizölrückstoßabdämpfung".', './img/Site/I_M_FUN.png'),
(19, 'Forum', 'Das Forum hat eine kleine, aber feine Erweiterung spendiert bekommen.\r\n', './img/Site/News.png'),
(20, 'Wussten Sie schon?', 'Wusstest Du schon?\r\n\r\nGemessen am Gewicht, kosten Hamburger mehr als ein Neuwagen.', './img/Site/I_M_FUN.png'),
(21, 'IM zieht um', 'I M zieht um!\r\n\r\nNach wochenlangem Überlegen, sind wir zu dem Entschluss gekommen, dass wir einen Umzug starten.\r\n\r\nAuf unserem derzeitigen Heimatserver Jar''Kai Sword sind wir einfach nicht mehr glücklich. Sei es, weil frisch angeworbene Leute, hochmotiviert unsere Raids unterstützen, nur um nach dem dritten Raid spontan nicht mehr aufzutauchen oder die Tatsache, dass es einfach zuviele reine PVPler gibt und uns das im PVE zu Raidmember-Engpässen führt.\r\n\r\nWir haben lange versucht Stabilität in die Raidgruppen zu bekommen. Letztenendes mit dem Ergebnis, dass eine 11 Mann Truppe nach T3M4 umzuzieht.\r\n\r\nWir wünschen den Verbliebenen alles Gute und viel Erfolg auf dem alten Server und bedauern es, dass sie nicht mitkommen.\r\n\r\nDen Umzüglern drücken wir die Daumen, dass auf dem neuen Heimatserver alles besser wird!\r\n\r\nGruß, der Naz', './img/Site/News.png'),
(22, 'Wussten Sie schon?', 'Wusstest Du schon?\r\n\r\nBruce Darnell war als Fallschirmspringer bei der US-Army.', './img/Site/I_M_FUN.png'),
(23, 'Bewerbungen', 'Das Bewerbungsmodul ist fertig, bitte mal alle zu Testzwecken, eine Bewerbung erstellen. Dazu muss man sich abmelden.\r\n\r\nDanke \r\n\r\nJan', './img/Site/News.png'),
(24, 'Cloudsystem', 'Eigenes Gildeninternes Cloudsystem.\r\nMehr im Forum unter "Wichtiges"\r\n\r\nJan', './img/Site/News.png'),
(25, 'Cloud und Bilder', 'Wir haben jetzt ein eigenes Gilden-Cloudsystem.\r\nMehr Infos im Forum unter "Wichtiges"\r\n\r\nDesweiteren können jetzt Bilder hochgeladen und\r\nangschaut werden.\r\nZufinden unter Medien -> Pics\r\n\r\nJan', './img/Site/News.png'),
(26, 'Forum Seite und TS off', 'Am 12.09. 1500 - 1800 nehme ich das Forum offline, da ich was an der Datenbank ändern will.\r\n\r\nAm 13.09. 2200 - 14.09. 0600 ist die Seite und das TS nicht erreichbar, da Strato die Server wartet.\r\n\r\nJan', './img/Site/News.png'),
(27, 'Video', 'Video-Seite Online.\nZu finden unter Medien -> Movies\n\nAm 13.09. 2200 - 14.09. 0600 ist die Seite und das TS nicht erreichbar, da Strato die Server wartet.\n\nJan', './img/Site/News.png'),
(28, 'Wissenschaftler und Pornos', 'Wissenschaftler der University of Montreal suchten für ein Experiment Männer, die schon einmal Pornos geschaut hatten, und solche, die noch nie welche gesehen hatten.\r\n\r\nAllerdings hatten sie Probleme die zweite Gruppe zu finden.', './img/Site/I_M_FUN.png'),
(29, '!', 'Wussten Sie schon?\r\n\r\nUnser Forum verfügt nicht nur über Beiträge, sondern auch offensichtlich über "BE"träge!\r\n\r\nBitte hinterlassen Sie ihre Kontonummer + PIN um den ausgewiesenen Betrag zu erhalten.', './img/Site/I_M_FUN.png'),
(31, 'Sticky', 'Unser Forum verfügt nun wie gewünscht über eine Sticky-Funkion. Wer einen Beitrag sticken möchte, der meldet das entsprechend in selbigem Beitrag. Gesticked wird dann von den Admins.', './img/Site/News.png'),
(32, 'Aratech', 'Nicht .vergessen: \r\n\r\nAm 27.09.2013  findet das Event von Crypter statt um sich evtl noch den fehlenden Aratech zu ergattern.\r\nMehr Infos dazu findet ihr im Forum.', './img/Site/Event.png'),
(34, 'Bearbeiten', 'Bearbeiten sollte wieder funktionieren.\r\nIch habe zu mindestens keine Fehler festgestellt.\r\n\r\nJan', './img/Site/News.png'),
(35, 'Bearbeiten', 'Forumbeiträge bearbeiten geht wieder.\r\n\r\nIch habe zumindestens in mein 2min Test keine Fehler festgestellt.\r\n\r\nJan', './img/Site/News.png'),
(36, 'Eure Beteiligung', 'Eure Beteiligung ist wichtig!\r\n\r\nMit freude beboachten wir, dass unser Forum seit einiger Zeit wieder richtig lebendig ist und es fast täglich neue Beiträge gibt.\r\n\r\nWie Ihr wisst ist unser Forum das mitunter wichtigste Kommunikationsmittel, gerade was Raidverabredungen bettrifft. Daher möchte ich Alle hier nocheinmal auffordern:\r\n\r\n"Meldet euch an UND ab"\r\n\r\nNichts ist ein wichtigeres Instrument für die Gildenstruktur und Planung, als euere Feedback! Um flexibel und situationsorientiert reagieren zu können brauchen wir diesen Input und die Beteiligung Aller. Zwei Klicks und ein deutliches "+" oder "-" helfen uns enorm. Sicher sogar mehr als Ihr glaubt.\r\n\r\nIch bedanke mich für euer Mitwirken und eure Unterstützung!\r\n\r\nGreetz der Naz', './img/Site/News.png'),
(37, 'Mitteilung', 'Eure Beteiligung ist wichtig!\r\n\r\nMit freude beboachten wir, dass unser Forum seit einiger Zeit wieder richtig lebendig ist und es fast täglich neue Beiträge gibt.\r\n\r\nWie Ihr wisst ist unser Forum das mitunter wichtigste Kommunikationsmittel, gerade was Raidverabredungen bettrifft. Daher möchte ich Alle hier nocheinmal auffordern:\r\n\r\n"Meldet euch an UND ab"\r\n\r\nNichts ist ein wichtigeres Instrument für die Gildenstruktur und Planung, als euere Feedback! Um flexibel und situationsorientiert reagieren zu können brauchen wir diesen Input und die Beteiligung Aller. Zwei Klicks und ein deutliches "+" oder "-" helfen uns enorm. Sicher sogar mehr als Ihr glaubt.\r\n\r\nIch bedanke mich für euer Mitwirken und eure Unterstützung!\r\n\r\nGreetz der Naz\r\n\r\nDie Website ist bis auf vereinzelte Style Sachen und eventuelle Bugs fertig.\r\n\r\nJan', './img/Site/News.png');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `raids`
--

CREATE TABLE IF NOT EXISTS `raids` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Raid` varchar(30) CHARACTER SET utf8 NOT NULL,
  `geschafft` int(11) NOT NULL,
  `gesamt` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `raids`
--

INSERT INTO `raids` (`ID`, `Raid`, `geschafft`, `gesamt`) VALUES
(1, 'Asation', 5, 5),
(2, 'Darvannis', 7, 7),
(3, 'Toborros', 1, 1),
(4, 'Dreadfortress', 3, 5),
(5, 'Dreadpalace', 0, 5),
(6, '', 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `site_counter`
--

CREATE TABLE IF NOT EXISTS `site_counter` (
  `ip` varchar(15) NOT NULL,
  `visit` date NOT NULL,
  `online` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `site_counter`
--

INSERT INTO `site_counter` (`ip`, `visit`, `online`) VALUES
('93.219.193.76', '2013-09-30', '1380577324'),
('2.245.230.108', '2013-09-30', '1380581937'),
('178.190.185.230', '2013-09-30', '1380568032'),
('85.214.217.142', '2013-09-30', '1380568520'),
('81.169.144.135', '2013-09-30', '1381180157'),
('87.183.135.170', '2013-09-30', '1380572445'),
('2.245.230.108', '2013-10-01', '1380578433'),
('81.169.144.135', '2013-10-01', '1380578448'),
('95.141.28.121', '2013-10-01', '1380602958'),
('91.64.217.39', '2013-10-01', '1381153641'),
('80.187.107.170', '2013-10-01', '1380611243'),
('2.245.95.226', '2013-10-01', '1380650265'),
('79.242.195.219', '2013-10-01', '1380635965'),
('109.45.3.29', '2013-10-01', '1380636925'),
('84.130.145.149', '2013-10-01', '1380638906'),
('93.219.222.96', '2013-10-01', '1380662899'),
('87.183.139.82', '2013-10-01', '1380649744'),
('91.66.218.79', '2013-10-01', '1380968675'),
('87.185.142.67', '2013-10-01', '1380644607'),
('176.199.22.154', '2013-10-01', '1380912146'),
('81.169.144.135', '2013-10-02', '1380666750'),
('37.221.169.137', '2013-10-02', '1380929955'),
('91.64.217.39', '2013-10-02', '1380697579'),
('80.187.108.223', '2013-10-02', '1380704874'),
('176.199.22.154', '2013-10-02', '1380705348'),
('2.245.70.148', '2013-10-02', '1380728121'),
('2.206.3.18', '2013-10-02', '1380708549'),
('91.66.218.79', '2013-10-02', '1380723130'),
('87.185.164.246', '2013-10-02', '1380739015'),
('87.183.141.116', '2013-10-02', '1380735015'),
('93.219.230.12', '2013-10-02', '1380755364'),
('79.242.194.46', '2013-10-02', '1380739134'),
('87.185.136.23', '2013-10-02', '1380821887'),
('93.219.230.12', '2013-10-03', '1380751224'),
('81.169.144.135', '2013-10-03', '1380751231'),
('85.214.217.142', '2013-10-03', '1380753178'),
('176.199.22.154', '2013-10-03', '1380754212'),
('87.183.141.116', '2013-10-03', '1380754643'),
('2.245.70.148', '2013-10-03', '1380761295'),
('87.185.136.23', '2013-10-03', '1380789083'),
('91.66.218.79', '2013-10-03', '1380790553'),
('93.219.223.51', '2013-10-03', '1380807119'),
('2.245.241.114', '2013-10-03', '1380933996'),
('80.187.100.7', '2013-10-03', '1380817251'),
('2.206.0.211', '2013-10-03', '1380813844'),
('92.77.63.57', '2013-10-03', '1380822560'),
('79.242.201.178', '2013-10-03', '1380833664'),
('93.219.197.183', '2013-10-03', '1380835565'),
('87.183.143.247', '2013-10-03', '1380824472'),
('87.185.179.241', '2013-10-03', '1380901465'),
('2.245.241.114', '2013-10-04', '1380837639'),
('81.169.144.135', '2013-10-04', '1380841705'),
('37.221.169.137', '2013-10-04', '1380861752'),
('91.64.217.39', '2013-10-04', '1380865843'),
('80.187.100.7', '2013-10-04', '1380869509'),
('80.187.97.35', '2013-10-04', '1380881500'),
('176.199.22.154', '2013-10-04', '1380878100'),
('87.185.179.241', '2013-10-04', '1380884558'),
('79.242.204.106', '2013-10-04', '1380885069'),
('2.206.0.172', '2013-10-04', '1380891342'),
('109.45.1.81', '2013-10-04', '1380893986'),
('93.219.215.121', '2013-10-04', '1380908471'),
('80.187.96.150', '2013-10-04', '1380899023'),
('87.183.143.4', '2013-10-04', '1380910155'),
('84.130.150.210', '2013-10-04', '1380918733'),
('93.219.197.5', '2013-10-04', '1380914673'),
('81.169.144.135', '2013-10-05', '1380926425'),
('2.245.241.114', '2013-10-05', '1380928738'),
('93.219.221.110', '2013-10-05', '1380934697'),
('37.221.169.137', '2013-10-05', '1380929424'),
('87.185.190.129', '2013-10-05', '1380998117'),
('93.219.219.235', '2013-10-05', '1381096459'),
('91.66.218.79', '2013-10-05', '1380968419'),
('84.130.165.170', '2013-10-05', '1381014453'),
('2.245.105.48', '2013-10-05', '1381019800'),
('87.183.152.208', '2013-10-05', '1381009679'),
('88.152.123.200', '2013-10-05', '1381000877'),
('87.170.111.210', '2013-10-05', '1381082621'),
('84.130.165.170', '2013-10-06', '1381010430'),
('2.245.105.48', '2013-10-06', '1381010485'),
('81.169.144.135', '2013-10-06', '1381010518'),
('87.183.152.208', '2013-10-06', '1381016183'),
('93.219.219.235', '2013-10-06', '1381038439'),
('109.45.2.26', '2013-10-06', '1381045791'),
('87.170.111.210', '2013-10-06', '1381051566'),
('2.206.0.1', '2013-10-06', '1381052888'),
('2.206.1.241', '2013-10-06', '1381054040'),
('87.183.185.142', '2013-10-06', '1381095949'),
('2.245.201.210', '2013-10-06', '1381076990'),
('109.45.0.131', '2013-10-06', '1381062782'),
('80.187.96.150', '2013-10-06', '1381065912'),
('84.160.92.216', '2013-10-06', '1381069093'),
('178.201.101.220', '2013-10-06', '1381174244'),
('84.130.150.167', '2013-10-06', '1381071099'),
('93.219.201.15', '2013-10-06', '1381073985'),
('80.187.97.173', '2013-10-06', '1381151435'),
('79.218.124.60', '2013-10-06', '1381079544'),
('87.149.137.96', '2013-10-06', '1381081571'),
('87.187.150.3', '2013-10-06', '1381084948'),
('87.185.167.163', '2013-10-06', '1381163775'),
('81.169.144.135', '2013-10-07', '1381096811'),
('93.219.241.141', '2013-10-07', '1381121319'),
('62.214.130.11', '2013-10-07', '1381140627'),
('91.64.217.39', '2013-10-07', '1381125995'),
('80.187.97.173', '2013-10-07', '1381127592'),
('2.206.3.196', '2013-10-07', '1381147950'),
('79.242.201.11', '2013-10-07', '1381178797'),
('109.47.1.56', '2013-10-07', '1381145631'),
('178.201.101.220', '2013-10-07', '1381151178'),
('217.7.207.41', '2013-10-07', '1381152038'),
('87.183.177.37', '2013-10-07', '1381167950'),
('87.185.167.163', '2013-10-07', '1381157792'),
('109.45.0.46', '2013-10-07', '1381158617'),
('93.219.199.112', '2013-10-07', '1381181658'),
('2.246.39.101', '2013-10-07', '1381175029'),
('87.185.174.162', '2013-10-07', '1381181278');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `User_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Email` varchar(100) NOT NULL,
  `Passwort` char(32) NOT NULL,
  `Mainchar` varchar(20) NOT NULL,
  `RLBildklein` varchar(160) DEFAULT NULL,
  `RLBildgross` varchar(160) DEFAULT NULL,
  `Vorname` varchar(60) DEFAULT NULL,
  `Name` varchar(60) DEFAULT NULL,
  `GebDatum` date DEFAULT NULL,
  `Ort` varchar(60) DEFAULT NULL,
  `Telefon` varchar(25) DEFAULT NULL,
  `oeffentlEmail` tinyint(1) DEFAULT NULL,
  `Beschreibung` varchar(1000) DEFAULT NULL,
  `Status` enum('aktiv','admin','deaktiviert','neu') DEFAULT 'neu',
  `Online` bigint(20) NOT NULL,
  PRIMARY KEY (`User_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`User_ID`, `Email`, `Passwort`, `Mainchar`, `RLBildklein`, `RLBildgross`, `Vorname`, `Name`, `GebDatum`, `Ort`, `Telefon`, `oeffentlEmail`, `Beschreibung`, `Status`, `Online`) VALUES
(2, 'jankruse83@googlemail.com', '29b3391b6d7b39e0070068d0e2f782ad', 'Vikki', './img/Userfoto/klein/13769511656585_s.png', './img/Userfoto/gross/13769511656585_b.png', 'Jan', 'Kruse', '1983-12-26', 'Berlin', '', 1, '', 'admin', 1381181805),
(3, 'rfn84@gmx.de', '342576de4de529c1c1c199f2e5eaaeb8', 'Naztar', './img/Userfoto/klein/13739700903392_s.png', './img/Userfoto/gross/13739700903392_b.png', 'Steven', 'Guth', '1984-06-03', 'Bingen', '', 1, 'Na na na na na na na na na na na na Batmaaaaan!', 'admin', 1381175130),
(4, 'danny.schr78@googlemail.com', '6b7b655dd22faa3f10677c512493a8a0', 'Nadja', './img/Userfoto/klein/13769331396657_s.png', './img/Userfoto/gross/13769331396657_b.png', 'Danny', 'Schröter', '1978-12-22', 'Marl', '', 1, '', 'admin', 1381167947),
(5, 'kilian.gerdes@gmail.com', '5003969326bbef0cb35112eb0f8a878a', 'Ysefv', './img/Userfoto/klein/13780509707710_s.png', './img/Userfoto/gross/13780509707710_b.png', 'Kilian', 'Gerdes', '1991-12-10', 'Westerstede', '', 1, '', 'aktiv', 1381145843),
(6, 'hamannsa@web.de', 'add47e0001e6cb32ead37e6e43b187b3', 'Katejo', '_s.png', '_b.png', 'Sabine', '', '1970-01-01', '', '', 0, '', 'aktiv', 1381178794),
(7, 'philipp.lemcke@gmail.com', '6bf2b956b02e7d2fac8968cd6cf89669', 'Avioid', '_s.png', '_b.png', 'Philipp', 'Lemcke', '1992-02-12', 'Ilsede', '', 1, 'pew pew pew!', 'deaktiviert', 0),
(8, 'bahn-christian@t-online.de', 'b2e90e2b853a2544b25c5b0a7e5dbe26', 'Citan', './img/Userfoto/klein/13796039877877_s.png', './img/Userfoto/gross/13796039877877_b.png', 'Christian', 'B.', '1991-10-17', 'Gelsenkirchen', '', 0, '', 'aktiv', 1381175196),
(9, 'denisoh@web.de', '37785745739b265174c69fa4488c4264', 'Abhauen', './img/Userfoto/klein/13781973593542_s.png', './img/Userfoto/gross/13781973593542_b.png', 'DeNis', '', '1984-04-03', 'Stuttgart', '', 0, '', 'aktiv', 1381160798),
(12, 'stefan.kurz1987@web.de', 'e99a18c428cb38d5f260853678922e03', 'Kandala', './img/Userfoto/klein/13783285174214_s.png', './img/Userfoto/gross/13783285174214_b.png', '', '', '1987-09-08', '', '', 0, '', 'aktiv', 1381181940),
(13, 'olafpache@gmail.com', 'b08cb75e2f2f37ff7f7ef87fdd80ca1b', 'Ronik', './img/Userfoto/klein/13802970441873_s.png', './img/Userfoto/gross/13802970441873_b.png', 'Olaf', '', '1982-02-05', 'Tübingen', '', 0, '', 'aktiv', 1381071162),
(14, 'andyziehn@gmx.de', '8090add91cee9ac9013bdc030e0162d8', 'Crypter', './img/Userfoto/klein/13717434304028_s.png', './img/Userfoto/gross/13717434304028_b.png', 'Andreas', 'Ziehn', '1983-07-13', 'Falkensee', '491629898829', 1, '', 'aktiv', 1380969141),
(17, 'stemar70@gmx.de', 'f0a1a3b76ca1f34c94f2d1a7976623e5', 'Pendragona', '_s.png', '_b.png', 'Stefan', '', '1970-08-16', '', '', 0, '', 'deaktiviert', 0),
(18, 'andreas@schrogl.de', '1d71035736651a192bd510103f3e04cc', 'Belgeron', '_s.png', '_b.png', 'Andreas', 'Schrogl', '1970-01-01', 'Pfullingen', '', 0, 'Möp Möp der Belge in da House', 'deaktiviert', 0),
(22, 'jankruse83@gmail.com', '29b3391b6d7b39e0070068d0e2f782ad', 'TestAccount', '_s.png', '_b.png', '', '', '1970-01-01', '', '', 0, '', 'deaktiviert', 0),
(23, 'Andrekehl@web.de', '56f56570c8fcc62d9199a87e207c05dd', 'Arnis', './img/Userfoto/klein/13803873969806_s.png', './img/Userfoto/gross/13803873969806_b.png', '', '', '1975-09-16', 'Berlin', '', 0, '', 'aktiv', 1381181436),
(24, 'moritz.kores@gmx.at', '4c89d9338927fdf76b666f5adec8aef8', 'Nupraptor', '_s.png', '_b.png', 'Moritz', '', '1970-01-01', '', '', 0, '', 'aktiv', 1380568045),
(25, 'marionbaumbach72@googlemail.com', '7e4910651a23242f77eb88d8ff410e22', 'Numaru', './img/Userfoto/klein/13778132706893_s.png', './img/Userfoto/gross/13778132706893_b.png', 'Marion', '', '1972-08-12', '', '', 0, '', 'aktiv', 0),
(26, 'blacky3300@hotmail.de', '90a93d0ad6888613ac0f8d8e40b8fef1', 'Sureala', '_s.png', '_b.png', 'Judith', '', '1970-01-01', '', '', 0, '', 'aktiv', 0),
(31, 'tim.schmidt1@gmx.de', '172e95ba6d11aaf4a73f5c020f67ebf8', 'Nêxx', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'aktiv', 0),
(32, 'nopelios1986@googlemail.com', 'fe7852ad5ec3952fda22db53d9ad5a8b', 'Dyranos', '_s.png', '_b.png', '', '', '1970-01-01', '', '', 0, '', 'aktiv', 0),
(33, 'Manegold1@gmx.de', 'e42ab927df5becdb620ba2cbfbf2a742', 'Râyy', '_s.png', '_b.png', 'Marcel', '', '1970-01-01', '', '', 0, '', 'aktiv', 1381079867),
(35, 'eunho.shin@googlemail.com', '141800617ad76940cf7168bb0a9ae6dd', 'Kimbab', './img/Userfoto/klein/13803225094038_s.png', './img/Userfoto/gross/13803225094038_b.png', 'Eun-Ho ', 'Shin', '1970-01-01', 'Berlin', '', 0, 'Hi! ^^', 'aktiv', 1381180187),
(36, '1414@gmx.net', 'e02e6a7eac2f848b378455585f2ded32', 'Mimicdegarus', './img/Userfoto/klein/13802166727671_s.png', './img/Userfoto/gross/13802166727671_b.png', '', '', '1970-01-01', '', '', 0, '', 'aktiv', 1381174130),
(37, 'chrisabtenau@gmx.de', '0975cf6baccb3862c31522c2b5b8fabc', 'Roheyn', '_s.png', '_b.png', 'Chris', '', '1978-07-12', 'Ruhrpott', '', 0, '35 Jahre alt, verheiratet, 1 Kind im Alter von 2,5 Jahren', 'aktiv', 1380408395),
(38, 'daniel.kohlschutter@gmx.net', '19145fb445a548c5281a31086890e09c', 'Khrain', './img/Userfoto/klein/13802780499325_s.png', './img/Userfoto/gross/13802780499325_b.png', '', '', '1970-01-01', '', '', 0, '', 'aktiv', 1381154864),
(39, 'ghgames@hotmail.de', 'da44429444e47bce286ae4603411ad0e', 'Dkayne', '_s.png', '_b.png', '', '', '1970-01-01', '', '', 0, '', 'aktiv', 0),
(40, 'stefan_schwark@web.de', '135a05c9fa59ca9ba6a963b940b1ce07', 'Thanas', '_s.png', '_b.png', '', '', '1970-01-01', '', '', 0, '', 'aktiv', 1381085984);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
