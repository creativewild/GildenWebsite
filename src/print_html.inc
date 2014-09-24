<?php

function print_create()
{
?>
	<p>Imperial-March.de | Design by Vikki &amp; Naztar</p>
	<p>Programmed by Vikki</p>

<?php
}
function Serverstatus()
{
$resa = "";
$url = "http://www.swtor.com/server-status";
$startstatus = '<span class="upArrow">';
$endstatus = "</span></div>";
$file = @fopen ($url,"r");
$resultat = array();
	$i=0;
	while (!feof($file)) {

		$zeile[$i] = fgets($file,2000);
		$i++;
	}
	fclose($file);

for ($j=0;$j<$i;$j++) {
		$resa = strstr($zeile[$j], $startstatus);
	if ($resa) {
		$resb = str_replace($startstatus, "", $resa);
		$endstueck = strstr($resb, $endstatus);
		$resultat[$j]  = str_replace($endstueck,"",$resb);
	}
}

return $resultat;

}
function Servername()
{
$resa = "";
$url = "http://www.swtor.com/server-status";
$startstatus = 'class="name">';
$endstatus = "</div>";
$file = @fopen ($url,"r");
$resultat = array();
	$i=0;
	while (!feof($file)) {

		$zeile[$i] = fgets($file,2000);
		$i++;
	}
	fclose($file);

for ($j=0;$j<$i;$j++) {
	$resa = strstr($zeile[$j], $startstatus);
	if ($resa) {
		$resb = str_replace($startstatus, "", $resa);
		$endstueck = strstr($resb, $endstatus);
		$resultat[$j]  = str_replace($endstueck,"",$resb);

	}
}

return $resultat;

}
function Serverpopulationniedrig()
{
$resa = "";
$url = "http://www.swtor.com/server-status";
$startstatus = 'popload1">';
$endstatus = "</div>";
$file = @fopen ($url,"r");
$resultat = array();
	$i=0;
	while (!feof($file)) {

		$zeile[$i] = fgets($file,2000);
		$i++;
	}
	fclose($file);

for ($j=0;$j<$i;$j++) {
$resa = strstr($zeile[$j], $startstatus);
if ($resa) {
		$resb = str_replace($startstatus, "", $resa);
		$endstueck = strstr($resb, $endstatus);
		$resultat[$j]  = str_replace($endstueck,"",$resb);
	}
}

return $resultat;

}
function Serverpopulationnormal()
{
$resa = "";
$url = "http://www.swtor.com/server-status";
$startstatus = 'popload2">';
$endstatus = "</div>";
$file = @fopen ($url,"r");
$resultat = array();
	$i=0;
	while (!feof($file)) {

		$zeile[$i] = fgets($file,2000);
		$i++;
	}
	fclose($file);

for ($j=0;$j<$i;$j++) {
$resa = strstr($zeile[$j], $startstatus);
if ($resa) {
		$resb = str_replace($startstatus, "", $resa);
		$endstueck = strstr($resb, $endstatus);
		$resultat[$j]  = str_replace($endstueck,"",$resb);
	}
}

return $resultat;

}
function Serverpopulationhoch()
{
$resa = "";
$url = "http://www.swtor.com/server-status";
$startstatus = 'popload3">';
$endstatus = "</div>";
$file = @fopen ($url,"r");
$resultat = array();
	$i=0;
	while (!feof($file)) {

		$zeile[$i] = fgets($file,2000);
		$i++;
	}
	fclose($file);

for ($j=0;$j<$i;$j++) {
$resa = strstr($zeile[$j], $startstatus);
if ($resa) {
		$resb = str_replace($startstatus, "", $resa);
		$endstueck = strstr($resb, $endstatus);
		$resultat[$j]  = str_replace($endstueck,"",$resb);
	}
}

return $resultat;

}
function Serverpopulationvoll()
{
$resa = "";
$url = "http://www.swtor.com/server-status";
$startstatus = 'popload4">';
$endstatus = "</div>";
$file = @fopen ($url,"r");
$resultat = array();
	$i=0;
	while (!feof($file)) {

		$zeile[$i] = fgets($file,2000);
		$i++;
	}
	fclose($file);

for ($j=0;$j<$i;$j++) {
$resa = strstr($zeile[$j], $startstatus);
if ($resa) {
		$resb = str_replace($startstatus, "", $resa);
		$endstueck = strstr($resb, $endstatus);
		$resultat[$j]  = str_replace($endstueck,"",$resb);
	}
}

return $resultat;

}

?>