<?php
/* Funktion zum Konvertieren des Timestamps in "normales" Format */
function convertdate($date) {
$expDate = explode(" ", $date); // zuerst das Leerzeichen (" ") als Trennzeichen benutzen und jeweils als Arrayelement speichern
  $d    =    explode("-", $expDate[0]); // dann den Bindestrich ("-") als Trennzeichen auf der erste Element des Arrays $expDate, also unseres davor schon einmal geteilten Timestamps, anwenden
  $t    =    explode(":", $expDate[1]); // nun den Doppelpunkt (":") als Trennzeichen auf das zweite Element des Arrays $expDate, also unseres davor schon einmal geteilten Timestamps, anwenden
  
  // $d[2] = Tag; $d[1] = Monat; $d[0] = Jahr; 
  // $t[0] = Minuten; $t[1] = Stunden
    
      return $d[2].'.'.$d[1].'.'.$d[0].' um '.$t[0].':'.$t[1].' Uhr'; // Ausgabe: "TT.MM.JJJJ um mm:hh Uhr"
}

/* Funktion zum Überprüfen der Benutzereingaben um Hackangriffe und SQL-Injections zu verhindern */
function checkinput($input) {
	return $input;
	
}
?>