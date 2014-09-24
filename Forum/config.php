<?php
$cfg = array(
 'db' => array(
  'host' => 'localhost', // Datenbankhost, meist localhost
  'user' => 'root', // Datenbank-Benutzername
  'pass' => 'JK198dre1YotKah', // Datenbankpasswort
  'base' => 'Forum' // Datenbankname
 )
);

$cfg['db'] = new mysqli($cfg['db']['host'], $cfg['db']['user'], $cfg['db']['pass'], $cfg['db']['base']);
if(mysqli_connect_errno()) {
 die('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}

$GLOBALS['db'] =& $cfg['db']; // Globale Variable $db anlegen
?>
