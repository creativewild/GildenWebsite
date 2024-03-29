DROP DATABASE IF EXISTS IM_Website;

CREATE DATABASE IM_Website 
  CHARACTER SET utf8 
  COLLATE utf8_general_ci;

USE IM_Website;

CREATE TABLE User(
  User_ID	INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  Email		VARCHAR (100) NOT NULL,
  Passwort	CHAR (32) CHARACTER SET ascii NOT NULL,
  Mainchar      VARCHAR (20) NOT NULL,
  RLBildklein	VARCHAR(160) NULL,
  RLBildgross	VARCHAR(160) NULL,
  Vorname	VARCHAR (60) NULL,
  Name		VARCHAR (60) NULL,
  GebDatum	DATE NULL,
  Ort		VARCHAR (60) NULL,
  Telefon	VARCHAR (25) NULL,
  oeffentlEmail  BOOLEAN NULL,
  Beschreibung	VARCHAR(1000) NULL,
  Status	ENUM("aktiv", "gesperrt", "deaktiviert") DEFAULT "deaktiviert"
)ENGINE = InnoDB;

CREATE TABLE Bewerbung(
  Bewerbung_ID	INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  Charname	VARCHAR (20) NOT NULL,
  Vorname	VARCHAR (60) NOT NULL,
  Geburtstag	DATE NOT NULL,
  Rasse		VARCHAR (60) NOT NULL,
  Klasse	VARCHAR (60) NOT NULL,
  Ausrichtung	VARCHAR (60) NOT NULL,
  Warum		VARCHAR (60) NOT NULL,
  Vorlieben	VARCHAR (60) NOT NULL,
  Tage		VARCHAR (60) NOT NULL,
  Zeit		CHAR (5) NOT NULL,
  Zusatz	VARCHAR (1000) NOT NULL
)ENGINE = InnoDB;

CREATE TABLE News(
  NewsID	INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  Titel 	VARCHAR(50) NOT NULL,
  News		VARCHAR(1000) NOT NULL,
  Bild		VARCHAR(160) NOT NULL
)ENGINE = InnoDB;

CREATE TABLE MediaPics(
  PIC_ID	INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  PIC_GROSS	VARCHAR(160) NOT NULL,
  PIC_KLEIN	VARCHAR(160) NOT NULL,
  PICDatum	TIMESTAMP NOT NULL
)ENGINE = InnoDB;

CREATE TABLE MediaVideo(
  Video_ID	INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  PfadVideo	VARCHAR(160) NOT NULL,
  VideoDatum	TIMESTAMP NOT NULL
)ENGINE = InnoDB;



GRANT USAGE ON *.* TO admin@'%' IDENTIFIED BY 'admin';
GRANT USAGE ON *.* TO admin@'localhost' IDENTIFIED BY 'admin';
GRANT ALL ON IM_Website.* TO IM_admin@'%' WITH GRANT OPTION;
GRANT ALL ON IM_Website.* TO IM_admin@'localhost' WITH GRANT OPTION;
GRANT SELECT ON IM_Website.* TO IM_USER@'%' WITH GRANT OPTION;
GRANT INSERT ON IM_Website.* TO IM_USER@'%' WITH GRANT OPTION;
GRANT UPDATE ON IM_Website.* TO IM_USER@'%' WITH GRANT OPTION;