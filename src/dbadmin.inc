<?php 
function Connect_DB()
{
    $dbconn = mysql_connect("localhost", "root", "JK198dre1YotKah");
    if ( !$dbconn )
    {
      die("DB &ouml;ffnen fehlgeschlagen:" . mysql_error());
    }
    
    if ( MYDEBUG )
		echo "<div class=\"debug\">Verbindung hergestellt: "
           .mysql_get_host_info($dbconn)."</div>";
    $rc = mysql_select_db( "im_website", $dbconn );
    if ( !$rc )
		die("DB &ouml;ffnen fehlgeschlagen:" . mysql_error());
    else
		if ( MYDEBUG )
			echo "<div class=\"debug\">Verbindung zur DB hergestellt</div>";
    return $dbconn;
}

function GetUser($dbconn)
{
	$sql = "SELECT User_ID, Mainchar, Status ".
	       "FROM User ".
	       "ORDER BY Status ASC, Mainchar ASC";		
	
	$query_result = mysql_query($sql, $dbconn) or die("Anfrage nicht erfolgreich");
	if(MYDEBUG)
	$anzahl = mysql_num_rows($query_result);
	$user_arr = array();
	while (($user_ds = mysql_fetch_assoc($query_result))!= false)
		$user_arr[] = $user_ds;
	return $user_arr;
}
function GetUserliste($dbconn)
{
	$sql = "SELECT User_ID, Mainchar, Status, GebDatum ".
				 "FROM User
				  WHERE Status = 'admin' or Status = 'aktiv'
				  ORDER BY Mainchar";		
	$query_result = mysql_query($sql, $dbconn) or die("Anfrage nicht erfolgreich");
	if(MYDEBUG)
	$anzahl = mysql_num_rows($query_result);
	$user_arr = array();
	while (($user_ds = mysql_fetch_assoc($query_result))!= false)
		$user_arr[] = $user_ds;
	return $user_arr;
}
function Get_User($User_ID, $dbconn)
{
    $sql = "SELECT `Email`, `Mainchar`, `RLBildklein`, `RLBildgross`, `Vorname`, `Name`, `GebDatum`, `Ort`, `Telefon`, `oeffentlEmail`, `Beschreibung`, `Status`
			FROM `User`  
            WHERE `User_ID` = ".$User_ID.";";
	$query_result = mysql_query($sql, $dbconn) or die("Anfrage nicht erfolgreich");
	if(MYDEBUG)
	$anzahl = mysql_num_rows($query_result);
	$user_arr = array();
	while (($user_ds = mysql_fetch_assoc($query_result))!= false)
		$user_arr[] = $user_ds;
	return $user_arr;
}
function GetBewerbungen($dbconn)
{
	$sql = "SELECT Bewerbung_ID, Grund, Charname, Aufgenommen, Bearbeitung ".
				 "FROM bewerbung";		
	$query_result = mysql_query($sql, $dbconn) or die("Anfrage nicht erfolgreich");
	if(MYDEBUG)
	$anzahl = mysql_num_rows($query_result);
	$bewerbung_arr = array();
	while (($bewerbung_ds = mysql_fetch_assoc($query_result))!= false)
		$bewerbung_arr[] = $bewerbung_ds;
	return $bewerbung_arr;
}

function Get_Bewerbung($Bewerbung_ID, $dbconn)
{
    $sql = "SELECT `Charname`, `Rasse`, `Klasse`, `Ausrichtung`, `Warum`, `Vorlieben`, `Zeit`, `Zusatz`, `Mo`, `Di`, `Mi`, `Do`, `Fr`, `Sa`, `So`, `JT`, `Aufgenommen`, `Bearbeitung`, `alter`, `Grund`    
            FROM `Bewerbung`  
            WHERE `Bewerbung_ID` = ".$Bewerbung_ID.";";
	$query_result = mysql_query($sql, $dbconn) or die("Anfrage nicht erfolgreich");
	if(MYDEBUG)
		$anzahl = mysql_num_rows($query_result);
	$user_arr = array();
	while (($user_ds = mysql_fetch_assoc($query_result))!= false)
		$user_arr[] = $user_ds;
	return $user_arr;
}

function Allebilder($start=0,$eintraege_pro_seite=100000, $dbconn)
{
    $sql = "SELECT PIC_ID, PIC_GROSS, PIC_KLEIN, PIC_Beschreibung
            FROM mediapics
            ORDER BY PIC_ID ASC                   
            LIMIT $start, $eintraege_pro_seite";
    $query_result = mysql_query($sql, $dbconn) or die("Anfrage nicht erfolgreich");
    $rows = array();
    while (($row = mysql_fetch_assoc($query_result))!= false)
        $rows[] = $row;
    return $rows;     
}

function Anzahlbilder($dbconn)
{
   	$anzahl = "";
    $result=Allebilder(0,10000, $dbconn);
    $i=0;
    foreach($result AS $row)
        $i++;
    return $i;
    if(MYDEBUG)
		echo "<div>".$this->dbconn->error."</div>";
    return $anzahl;
}

function Allemovies($start=0,$eintraege_pro_seite=100000, $dbconn)
{
    $sql = "SELECT Video_ID, PfadVideo
            FROM mediavideo
            ORDER BY Video_ID ASC                   
            LIMIT $start, $eintraege_pro_seite";
    $query_result = mysql_query($sql, $dbconn) or die("Anfrage nicht erfolgreich");
    $rows = array();
    while (($row = mysql_fetch_assoc($query_result))!= false)
        $rows[] = $row;
    return $rows;     
}

function Anzahlmovies($dbconn)
{
   	$anzahl = "";
    $result=Allemovies(0,10000, $dbconn);
    $i=0;
    foreach($result AS $row)
		$i++;
    return $i;
	if(MYDEBUG)
		echo "<div>".$this->dbconn->error."</div>";
    return $anzahl;
}

function AlleNews($start=0,$eintraege_pro_seite=100000, $dbconn)
{
    $sql = "SELECT NewsID 
            FROM News 
            ORDER BY NewsID ASC                    
            LIMIT $start, $eintraege_pro_seite";
    $query_result = mysql_query($sql, $dbconn) or die("Anfrage nicht erfolgreich");
    $rows = array();
    while (($row = mysql_fetch_assoc($query_result))!= false)
        $rows[] = $row;
	return $rows;     
}

function AnzahlNews($dbconn)
{
   	$anzahl = "";
    $result=AlleNews(0,10000, $dbconn);
    $i=0;
    foreach($result AS $row)
        $i++;
    return $i;
    if(MYDEBUG)
	echo "<div>".$this->dbconn->error."</div>";
    return $anzahl;
}                                	

function Useronlinereturn($dbconn)
{
    $sql = "SELECT Online, User_ID
            FROM User";
    $query_result = mysql_query($sql, $dbconn) or die("Anfrage nicht erfolgreich");
    $rows = array();
    while (($row = mysql_fetch_assoc($query_result))!= false)
        $rows[] = $row;
    return $rows;
}

function Useronlineanzeige($User_ID, $dbconn)
{
    $sql = "SELECT Mainchar ".
		   "FROM User ".
		   "Where User_ID = ".$User_ID."; ";
    $query_result = mysql_query($sql, $dbconn) or die("Anfrage nicht erfolgreich");
    $rows = array();
    while (($row = mysql_fetch_assoc($query_result))!= false)
        $rows[] = $row;
    return $rows;
}

function GetRaid($dbconn)
{
	$sql = "SELECT ID, Raid, geschafft, gesamt ".
	       "FROM raids ".
	       "ORDER BY ID ASC";
	$query_result = mysql_query($sql, $dbconn) or die("Anfrage nicht erfolgreich");
	if(MYDEBUG)
	$anzahl = mysql_num_rows($query_result);
	$raid_arr = array();
	while (($raid_ds = mysql_fetch_assoc($query_result))!= false)
		$raid_arr[] = $raid_ds;
	return $raid_arr;
}
function Get_News($dbconn)
{
	$sql = 	'SELECT NewsID, News, Bild '. 
			'FROM NEWS '.
			'ORDER BY NewsID DESC '.
			'LIMIT 1';
	$query_result = mysql_query($sql, $dbconn) or die("Anfrage nicht erfolgreich");
	$rows = array();
    while (($row = mysql_fetch_assoc($query_result))!= false)
        $rows[] = $row;
    return $rows;			
}
function GetRaidplaner($dbconn, $ID)
{
	$sql = "SELECT Raid, Modus, Tag, Monat, Jahr, Uhrzeit, Raidleiter, Gruppe  ".
	       "FROM raidplaner ".
	       "WHERE ID = $ID;";
	$query_result = mysql_query($sql, $dbconn) or die("Anfrage nicht erfolgreich");
	$rows = array();
    while (($row = mysql_fetch_assoc($query_result))!= false)
        $rows[] = $row;
    return $rows;
}
function GetRaidplanerAktuellerMonat($dbconn, $month, $year)
{
    $sql = "SELECT ID, Raid, Modus, Tag, Monat, Jahr, Uhrzeit, Raidleiter, Gruppe  ".
	       "FROM raidplaner ".
	       "WHERE Monat = $month and Jahr = $year ".
	       "ORDER BY Tag ASC ";
	$query_result = mysql_query($sql, $dbconn) or die("Anfrage nicht erfolgreich");
	$rows = array();
    while (($row = mysql_fetch_assoc($query_result))!= false)
        $rows[] = $row;
    return $rows;
}
function GetChar($dbconn, $User_ID)
{
    $sql = "SELECT ID, User_ID, `Char`, Klasse ".
	       "FROM chars ".
	       "WHERE User_ID = $User_ID ".
	       "ORDER BY ID ASC ";
	$query_result = mysql_query($sql, $dbconn) or die("Anfrage nicht erfolgreich");
	$rows = array();
    while (($row = mysql_fetch_assoc($query_result))!= false)
        $rows[] = $row;
    return $rows;
}
function GetRaidteilnehmer($dbconn, $Raid_ID)
{
    $sql = "SELECT CharID, Teilnahme, UserID ".
	       "FROM raidteilnahme ".
	       "WHERE RaidID = $Raid_ID ".
	       "ORDER BY ID ASC ";
	$query_result = mysql_query($sql, $dbconn) or die("Anfrage nicht erfolgreich");
	$rows = array();
    while (($row = mysql_fetch_assoc($query_result))!= false)
        $rows[] = $row;
    return $rows;    
}
function GetRaidteilnehmerAnzeige($dbconn, $ID)
{
    $sql = "SELECT raidteilnahme.Teilnahme, chars.Char, chars.Klasse, raidteilnahme.Kommentar ".
           "FROM raidteilnahme JOIN chars ON raidteilnahme.CharID = chars.ID ".
           "WHERE RaidID = $ID;";
	$query_result = mysql_query($sql, $dbconn) or die("Anfrage nicht erfolgreich");
	$rows = array();
    while (($row = mysql_fetch_assoc($query_result))!= false)
        $rows[] = $row;
    return $rows;
}
function GetCharIDohneUser($dbconn, $Charname)
{
	$sql = "SELECT `ID`, `User_ID` ".
		   "FROM `chars` ".
		   "WHERE `Char` = '$Charname';";
    $query_result = mysql_query($sql, $dbconn) or die("Anfrage nicht erfolgreich1");
	$rows = array();
    while (($row = mysql_fetch_assoc($query_result))!= false)
        $rows[] = $row;
    return $rows;

}
function GetSeitenInformation($dbconn)
{
	$sql = "SELECT * ".
	       "FROM `seiteninformation` ";
    $query_result = mysql_query($sql, $dbconn) or die("Anfrage nicht erfolgreich1");
	$rows = array();
    while (($row = mysql_fetch_assoc($query_result))!= false)
        $rows[] = $row;
    return $rows;

}
function GetRaidgruppen($dbconn)
{
	$sql = "SELECT * ".
	       "FROM `raidgruppen` ";
    $query_result = mysql_query($sql, $dbconn) or die("Anfrage nicht erfolgreich1");
	$rows = array();
    while (($row = mysql_fetch_assoc($query_result))!= false)
        $rows[] = $row;
    return $rows;

}
?> 