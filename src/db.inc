<?php 
class Datenbank
{
    public $dbconn;
    
    /* ***************************************************
    *  Öffentliche Methoden
    **************************************************** */

	public function __construct()
	{
        $this->dbconn = new mysqli("localhost","root","JK198dre1YotKah","IM_Website");
		if($this->dbconn===FALSE)
		{
			die("DB &ouml;ffnen fehlgeschlagen:" . mysql_error());
		}
		if(MYDEBUG)
		{
			echo "<div class=\"debug\">Verbindung hergestellt: ".$this->dbconn->host_info."</div>";
		}
		if(MYDEBUG)
		{
			echo "<div class=\"debug\">Verbindung zur Datenbank hergestellt</div>";
		}
	}
	
	public function Get_User_ID_By_Login($login,$pw)
	{
		$User_ID = "";
        $sql = "SELECT User_ID ".
			   "FROM User ".
			   "WHERE Email = ? AND Passwort = MD5( ? );";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
        $stmt->bind_param("ss",$login,$pw);
        $stmt->execute();
        $stmt->bind_result( $User_ID ); 
        if($stmt->fetch())
            return $User_ID;
        else
			return FALSE;
	}
	
	public function Get_User_ID($UserID)
	{
		$User_ID = "";
        $sql = "SELECT User_ID ".
			   "FROM User ".
			   "WHERE User_ID = ?;";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
        $stmt->bind_param("s",$UserID);
        $stmt->execute();
        $stmt->bind_result( $User_ID ); 
        if($stmt->fetch())
            return $User_ID;
        else
			return FALSE;
	}
	
	public function Get_Username($User_ID)
	{
		$Mainchar = "";
		$sql =	"SELECT Mainchar ".
				"FROM User ".
				"Where User_ID = ?;";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
        $stmt->bind_param("i",$User_ID);
        $stmt->execute();
        $stmt->bind_result( $Mainchar ); 
        if($stmt->fetch())
            return $Mainchar;
        else
            return FALSE;
	}
	
	public function Get_Userbild($User_ID)
	{
		$Userbild = "";
		$sql =	"SELECT RLBildklein ".
				"FROM User ".
				"Where User_ID = ?;";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
        $stmt->bind_param("i",$User_ID);
        $stmt->execute();
        $stmt->bind_result( $Userbild ); 
        if($stmt->fetch())
            return $Userbild;
        else
            return FALSE;
	}
	
	public function Get_Status($User_ID)
	{
	    $status="";
		$sql =	"SELECT Status ".
				"FROM User ".
				"Where User_ID = ?;";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
        $stmt->bind_param("i",$User_ID);
        $stmt->execute();
        $stmt->bind_result( $status ); 
        if($stmt->fetch())
            return $status;
        else
            return FALSE;
	}
	
	public function INSERT_User($Email, $Passwort, $Mainchar, $RLBildklein=null, $RLBildgross=null, $Vorname=null, $Nachname=null, $GebDatum=null, $Ort=null, $Telefon=null, $oeffentlEmail=false, $Beschreibung=null)
	{
		$stmt=null;
        $sql = "INSERT INTO User ( Email, Passwort, Mainchar, RLBildklein, RLBildgross, Vorname, Name, GebDatum, Ort, Telefon, oeffentlEmail, Beschreibung, Status) VALUES".
               "(?,MD5(?),?,?,?,?,?,?,?,?,?,?,?);";
        if(MYDEBUG)
    	{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
		$status="neu";
        $stmt->bind_param("sssssssssssss", $Email, $Passwort, $Mainchar, $RLBildklein, $RLBildgross, $Vorname, $Nachname, $GebDatum, $Ort, $Telefon, $oeffentlEmail, $Beschreibung, $status);
        $stmt->execute();
        return $this->dbconn->insert_id;     
	}
	
	public function INSERT_Bewerbung($Charname, $Rasse, $Klasse, $Ausrichtung, $Warum, $Vorlieben, $Zeit, $Zusatz = null, $Mo = null, $Di = null, $Mi = null, $Do = null, $Fr = null, $Sa = null, $So = null, $JT = null, $Alt = null )
	{
		$stmt=null;
        $sql = "INSERT INTO `bewerbung`(`Charname`, `Rasse`, `Klasse`, `Ausrichtung`, `Warum`, `Vorlieben`, `Zeit`, `Zusatz`, `Mo`, `Di`, `Mi`, `Do`, `Fr`, `Sa`, `So`, `JT`, `alter`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
        $stmt->bind_param("sssssssssssssssss",$Charname, $Rasse, $Klasse, $Ausrichtung, $Warum, $Vorlieben, $Zeit, $Zusatz, $Mo, $Di, $Mi, $Do, $Fr, $Sa, $So, $JT, $Alt );
        $stmt->execute();
        return $this->dbconn->insert_id;  
	}
	
	public function Get_news_aktuell()
	{
		$NewsID="";
		$sql =	"SELECT MAX(NewsID) ".
				"FROM NEWS ";
	    if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
        $stmt->execute();
        $stmt->bind_result( $NewsID ); 
        if($stmt->fetch())
            return $NewsID;
        else
            return FALSE;
	}
	
	public function Get_news_alle()
	{
		$NewsID="";
		$sql =	"SELECT NewsID ".
				"FROM NEWS ";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
        $stmt->execute();
        $stmt->bind_result( $NewsID ); 
        if($stmt->fetch())
            return $NewsID;
        else
            return FALSE;
	}
	
	public function Get_news_news($NewsID)
	{
		$News="";
		$sql =	"SELECT News ".
				"FROM NEWS ".
				"WHERE NewsID = ?";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
		$stmt->bind_param("i",$NewsID);
		$stmt->execute();
        $stmt->bind_result( $News ); 
        if($stmt->fetch())
            return $News;
        else
            return FALSE;
	}
	
	public function Get_news_bild($NewsID)
	{
		$Bild="";
		$sql =	"SELECT Bild ".
				"FROM NEWS ".
				"WHERE NewsID = ?";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
		$stmt->bind_param("i",$NewsID);
        $stmt->execute();
        $stmt->bind_result( $Bild ); 
        if($stmt->fetch())
            return $Bild;
        else
            return FALSE;
	}

	public function Statusaendern($ID, $status)
	{
		$stmt=null;
        $sql = "UPDATE User SET User.Status = ? WHERE User.User_ID = ?";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
		$stmt->bind_param("si",$status, $ID);
        $stmt->execute();
	}
	public function INSERT_News($Bild, $Betreff, $News)
	{
			$stmt=null;
            $sql = "INSERT INTO `news`(`titel`, `news`, `bild`) VALUES (?,?,?);";

            if(MYDEBUG)
			{
				echo "<div>$sql</div>";
			}

            $stmt = $this->dbconn->prepare($sql);
            if(MYDEBUG)
			{
				echo "<div>".$this->dbconn->error.$stmt->error."</div>";
			}
            $stmt->bind_param("sss", $Betreff, $News, $Bild);
            $stmt->execute();
	}
	public function Alle_User()
	{		
		$sql = " SELECT *
				 FROM User
				 WHERE Status = 'aktiv' OR STATUS = 'admin'";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
        $rows=$this->query($sql);  
        return $rows;   
	}

	public function UPDATE_Userpasswd($passwd, $User_ID)
	{
	    $stmt=null;
        $sql = "UPDATE User SET Passwort = MD5(?) WHERE User.User_ID = ?";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
		$stmt->bind_param("si",$passwd, $User_ID);
        $stmt->execute();
	}

	public function UPDATE_Userbild($Bildklein, $Bildgross, $User_ID)
	{
	    $stmt=null;
        $sql = "UPDATE User SET RLBildklein = ?, RLBildgross = ? WHERE User.User_ID = ?";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
		$stmt->bind_param("ssi",$Bildklein, $Bildgross, $User_ID);
        $stmt->execute();
	}

	public function UPDATE_User($email,$Mainchar, $vorname, $name, $GebDatum, $ort, $telefon, $Emailoeffentlich, $Beschreibung, $User_ID)
	{
		$stmt=null;
        $sql = "UPDATE User SET Email = ?, Mainchar = ?, Vorname = ?, Name = ?, Gebdatum = ?, Ort = ?, Telefon = ?, oeffentlEmail = ?, Beschreibung = ? WHERE User.User_ID = ?";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
		$stmt->bind_param("sssssssssi",$email,$Mainchar, $vorname, $name, $GebDatum, $ort, $telefon, $Emailoeffentlich, $Beschreibung, $User_ID);
        $stmt->execute();
	}
	
	public function Get_User_Forum($UserID)
	{
		$User_ID = "";
	    $sql = "SELECT Mainchar ".
			   "FROM User ".
			   "WHERE User_ID = ?;";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
        $stmt->bind_param("s",$UserID);
        $stmt->execute();
        $stmt->bind_result( $User_ID ); 
        if($stmt->fetch())
            return $User_ID;
        else
            return FALSE;
	}

	public function UpdateBewerbung($Bewerbung_ID, $Grund, $Aufgenommen, $Bearbeitung)
	{
		$stmt=null;
        $sql = "UPDATE Bewerbung SET Grund = ?, Aufgenommen = ?, Bearbeitung = ?  WHERE Bewerbung_ID = ?";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
		$stmt->bind_param("sssi",$Grund, $Aufgenommen, $Bearbeitung, $Bewerbung_ID);
        $stmt->execute();
	}

	public function Anzahlbilder()
	{
		$anzahl = "";
            $result=$this->Allebilder(0,10000);
            $i=0;
            foreach($result AS $row)
              $i++;
            return $i;

	    if(MYDEBUG)
		echo "<div>".$this->dbconn->error."</div>";
            
	    return $anzahl;
	}
	public function Allebilder($start=0,$eintraege_pro_seite=100000)
	{
        $sql = "SELECT User_ID, RLBildklein 
                FROM User
                ORDER BY User_ID ASC                   
                LIMIT $start, $eintraege_pro_seite;";
		if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
        $rows=$this->query($sql);  
        return $rows;          
	}

	public function INSERT_Gildenbild($Bildklein, $Bildgross, $PIC_Beschreibung)
	{
	    $stmt=null;
        $sql = "INSERT mediapics SET PIC_KLEIN = ?, PIC_GROSS = ?, PIC_Beschreibung = ? ";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
		$stmt->bind_param("sss",$Bildklein, $Bildgross, $PIC_Beschreibung);
        $stmt->execute();
	}


	public function INSERT_Movie($Pfad)
	{
	    $stmt=null;
        $sql = "INSERT mediavideo SET PfadVideo = ? ";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
		$stmt->bind_param("s",$Pfad);
        $stmt->execute();
	}
	
    public function Useronline($ID, $status)
	{
		$stmt=null;
        $sql = "UPDATE User SET User.Online = ? WHERE User.User_ID = ?";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
		$stmt->bind_param("si",$status, $ID);
        $stmt->execute();
	}
	
	public function Useronlineanzeige($UserID)
	{
		$User_ID = "";
	    $sql = "SELECT Mainchar ".
				   "FROM User ".
				   "WHERE User_ID = ?;";

        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
        $stmt->bind_param("i",$UserID);
        $stmt->execute();
        $stmt->bind_result( $User_ID );
        if($stmt->fetch())
            return $User_ID;
        else
            return FALSE;
	}
	
	public function UPDATE_Raids($ID, $Raids, $Geschafft, $Gesamt)
	{
	    $stmt=null;
        $sql = "UPDATE raids SET Raid = ?, geschafft = ?, gesamt = ? WHERE ID = ?";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
		$stmt->bind_param("siii",$Raids, $Geschafft, $Gesamt, $ID);
        $stmt->execute();
	}
	
	public function INSERT_Raidplaner($Raidauswahl, $Modusauswahl, $day, $month, $year, $Stundeauswahl, $Minuteauswahl, $Gruppeauswahl, $Leiterauswahl, $User_ID)
	{               
			$stmt=null;
            $sql = "INSERT INTO `Raidplaner`(`Raid`, `Modus`, `Tag`, `Monat`, `Jahr`, `Uhrzeit`, `User_ID`, `Raidleiter`, `Gruppe`) VALUES (?,?,?,?,?,?,?,?,?);";

            if(MYDEBUG)
			{
				echo "<div>$sql</div>";
			}

            $stmt = $this->dbconn->prepare($sql);
            if(MYDEBUG)
			{
				echo "<div>".$this->dbconn->error.$stmt->error."</div>";
			}
			$Zeit = "$Stundeauswahl:$Minuteauswahl";
            $stmt->bind_param("ssiiisiss", $Raidauswahl, $Modusauswahl, $day, $month, $year, $Zeit, $User_ID, $Leiterauswahl, $Gruppeauswahl);
            $stmt->execute();
    }
    public function GetRaidGruppe($ID)
	{
		$User_ID = "";
	$sql = "SELECT Gruppe, Raid, Modus, Tag, Monat, Jahr, Uhrzeit, Gruppe  ".
	       "FROM raidplaner ".
	       "WHERE ID = ?;";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
        $stmt->bind_param("i",$ID);
        $stmt->execute();
        $stmt->bind_result( $User_ID );
        if($stmt->fetch())
            return $User_ID;
        else
			return FALSE;
	}
	
    public function UPDATE_Chars($ID, $User_ID, $Char, $Klasse)
	{
	    $stmt=null;
        $sql = "UPDATE Chars SET User_ID = ?, `Char` = ?, Klasse = ? WHERE ID = ?";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
		$stmt->bind_param("iss",$User_ID, $Char, $Klasse);
        $stmt->execute();
	}
	public function INSERT_Char($User_ID, $Char, $Klasse)
	{
			$stmt=null;
            $sql = "INSERT INTO `Chars`(`User_ID`, `Char`, `Klasse`) VALUES (?,?,?);";

            if(MYDEBUG)
			{
				echo "<div>$sql</div>";
			}

            $stmt = $this->dbconn->prepare($sql);
            if(MYDEBUG)
			{
				echo "<div>".$this->dbconn->error.$stmt->error."</div>";
			}
            $stmt->bind_param("iss", $User_ID, $Char, $Klasse);
            $stmt->execute();
	}
    public function GetCharID($Charname, $User_ID)
	{
	    $status="";
		$sql =	"SELECT ID ".
				"FROM `chars` ".
				"WHERE `User_ID` = ? AND `Char` = ? ".
                "ORDER BY ID ASC LIMIT 1;";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
        $stmt->bind_param("is",$User_ID, $Charname);
        $stmt->execute();
        $stmt->bind_result( $status );
        if($stmt->fetch())
            return $status;
        else
            return FALSE;
	}
	public function GetCharIDohneUser($Charname)
	{
	    $status="";
		$sql =	"SELECT ID, User_ID ".
				"FROM `chars` ".
				"WHERE `Char` = ? ".
                "ORDER BY ID ASC LIMIT 1;";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
        $stmt->bind_param("s", $Charname);
        $stmt->execute();
        $stmt->bind_result( $status );
        if($stmt->fetch())
            return $status;
        else
            return FALSE;
	}
    public function UpdateRaidChar($RaidID, $Char_ID, $Raidteilnahme, $UserID)
	{
	    $stmt=null;
        $sql = "UPDATE `raidteilnahme` SET `CharID` = ?, `Teilnahme` = ? WHERE `RaidID` = ? AND `UserID` = ?";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
		$stmt->bind_param("iiii",$Char_ID, $Raidteilnahme, $RaidID, $UserID);
        $stmt->execute();
	}
	public function InsertRaidChar($RaidID, $Char_ID, $Raidteilnahme, $UserID )
	{
			$stmt=null;
            $sql = "INSERT INTO `raidteilnahme`(`RaidID`, `CharID`, `Teilnahme`, `UserID`) VALUES (?,?,?,?);";

            if(MYDEBUG)
			{
				echo "<div>$sql</div>";
			}

            $stmt = $this->dbconn->prepare($sql);
            if(MYDEBUG)
			{
				echo "<div>".$this->dbconn->error.$stmt->error."</div>";
			}
            $stmt->bind_param("iiii", $RaidID, $Char_ID, $Raidteilnahme, $UserID);
            $stmt->execute();
	}
    public function GetRaidleiterID($Charname)
	{
	    $status="";
		$sql =	"SELECT User_ID ".
				"FROM `user` ".
				"WHERE `Mainchar` = ? ";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
        $stmt->bind_param("s", $Charname);
        $stmt->execute();
        $stmt->bind_result( $status );
        if($stmt->fetch())
            return $status;
        else
            return FALSE;
	}
	public function GetRaidTeilnahme($User_ID, $Raid_ID)
	{
	    $status="";
		$sql =	"SELECT Teilnahme ".
				"FROM `raidteilnahme` ".
				"WHERE `UserID` = ? and RaidID = ? and Teilnahme <> '' ";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
        $stmt->bind_param("is", $User_ID, $Raid_ID);
        $stmt->execute();
        $stmt->bind_result( $status );
        if($stmt->fetch())
            return $status;
        else
            return false;
	 }
	 public function GetRaidKommentar($User_ID, $Raid_ID)
	 {
	    $status="";
		$sql =	"SELECT Kommentar ".
				"FROM `raidteilnahme` ".
				"WHERE `UserID` = ? and RaidID = ? ";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
        $stmt->bind_param("is", $User_ID, $Raid_ID);
        $stmt->execute();
        $stmt->bind_result( $status );
        if($stmt->fetch())
            return $status;
        else
            return false;
	 }
	   
     public function UpdateKommentar($RaidID,  $UserID, $Kommentar)
	 {
	    $stmt=null;
        $sql = "UPDATE `raidteilnahme` SET `Kommentar` = ? WHERE `RaidID` = ? AND `UserID` = ?";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
		$stmt->bind_param("sii",$Kommentar, $RaidID, $UserID);
		$stmt->execute();
	 }
	 public function GetRaidID()
	 {
	    $status="";
		$sql =	"SELECT ID ".
				"FROM `raidplaner` ".
				"ORDER BY ID DESC LIMIT 1 ";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
        $stmt->bind_param("is", $User_ID, $Raid_ID);
        $stmt->execute();
        $stmt->bind_result( $status );
        if($stmt->fetch())
            return $status;
        else
            return false;
	 }

	public function UpdateBewerbungKommentar($Bewerbung_ID, $Grund)
	{
		$stmt=null;
        $sql = "UPDATE Bewerbung SET Grund = ? WHERE Bewerbung_ID = ?";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
	$stmt = $this->dbconn->prepare($sql);
       	if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
	$stmt->bind_param("si",$Grund, $Bewerbung_ID);
        $stmt->execute();
	}
    public function SeitenInformation($ID, $Spalte, $Information)
	{
		$stmt=null;
        $sql = "UPDATE seiteninformation SET seiteninformation.".$Spalte." = ? WHERE seiteninformation.ID = ?";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
        $stmt = $this->dbconn->prepare($sql);
        if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
		$stmt->bind_param("si",$Information, $ID);
        $stmt->execute();
	}	
	public function UpdateRaidGruppenAdmin($ID, $Tag1, $Uhrzeit1, $Tag2, $Uhrzeit2, $Tank1, $Tank2, $Heal1, $Heal2, $DD1, $DD2, $DD3, $DD4, $StammID )
	{
		$stmt=null;
        $sql = "UPDATE raidgruppen SET Tag1 = ?, Uhrzeit1 = ?, Tag2 = ?, Uhrzeit2 = ?, Tank1 = ?, Tank2 = ?, Heal1 = ?, Heal2 = ?, DD1 = ?, DD2 = ?, DD3 = ?, DD4 = ?, StammID = ?   WHERE ID = ?";
        if(MYDEBUG)
		{
			echo "<div>$sql</div>";
		}
	$stmt = $this->dbconn->prepare($sql);
       	if(MYDEBUG)
		{
			echo "<div>".$this->dbconn->error.$stmt->error."</div>";
		}
	$stmt->bind_param("sssssssssssssi", $Tag1, $Uhrzeit1, $Tag2, $Uhrzeit2, $Tank1, $Tank2, $Heal1, $Heal2, $DD1, $DD2, $DD3, $DD4, $StammID, $ID);
        $stmt->execute();
	}
}
?>
