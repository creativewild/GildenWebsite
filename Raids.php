<?php
  /****************************
   *Einbindung fremder Dateien*
   ****************************/
    require_once "./src/my_funcs.inc";
    include "./src/db.inc";
    include "./src/print_html.inc"; 
    include "./src/dbadmin.inc";

  /***********
   *Debugging*
   ***********/
    debugging( false );

  /********************
   *Session und Cookie*
   ********************/
    init_session();
	user_pruefen();

  /***********
   *Variablen*
   ***********/
	$error="";
	$table="";
	$i=0;
	$db = new Datenbank();
	$dbconn = Connect_DB();
	$Status = $db->Get_Status($_SESSION['User_ID']);
	$User = array();
	$User = GetUserliste($dbconn);
	$UserID = $_SESSION['User_ID'];
	$UserIDRaid =$_SESSION['User_ID'].";";
	$key;
	$Raids = array();
	$Raidgruppe=array();
	$Raidgruppenarray = GetRaidgruppen($dbconn);
	foreach($Raidgruppenarray as $RaidGruppen)
	{
		if ($RaidGruppen['ID']==1)	
			$RG1 = $RaidGruppen['StammID'];
		if ($RaidGruppen['ID']==2)	
			$RG2 = $RaidGruppen['StammID'];
		
	}
	if(isset($_GET['id']))
    {
        $ID = $_GET['id'];
        $Raids = GetRaidplaner($dbconn,$ID);
        foreach($Raids as $Raid1)
        {  
            $Raidleiter = $Raid1['Raidleiter'];
        }
        $RaidleiterID = $db->GetRaidleiterID($Raidleiter);
        $RaidteilnehmerArray = array();
        $RaidteilnehmerArray = GetRaidteilnehmer($dbconn, $ID);
        $RaidteilnehmeranzeigeArray = array();
        $RaidteilnehmeranzeigeArray = GetRaidteilnehmerAnzeige($dbconn, $ID);
        $Bestaetigt = array();
        $Angemeldet = array();
        $Ersatz = array();
        $Abgemeldet = array();
        $Kommentar = $db->GetRaidKommentar($_SESSION['User_ID'], $ID);
        $a = 0;
        $b = 0;
        $c = 0;
        $d = 0;
        foreach($RaidteilnehmeranzeigeArray as $Raidteilnehmeranzeige)
        {       
            if ($Raidteilnehmeranzeige['Teilnahme'] == 1)
            {
                $Bestaetigt[$a]= $Raidteilnehmeranzeige;
                $a++;             
            }
            if ($Raidteilnehmeranzeige['Teilnahme'] == 2)
            {
                $Angemeldet[$b]= $Raidteilnehmeranzeige;
                $b++;               
            }
            if ($Raidteilnehmeranzeige['Teilnahme'] == 3)
            {
                $Ersatz[$c]= $Raidteilnehmeranzeige;
                $c++;            
            }
            if ($Raidteilnehmeranzeige['Teilnahme'] == 4)
            {
                $Abgemeldet[$d]= $Raidteilnehmeranzeige;
                $d++;
            }
        }
    }
	else
	{
    	$day = $_GET['d'];
    	$month = $_GET['m'];
    	$year = $_GET['y'];
    }
    $Wiederholen = 0;

    $Raidteilnahme = 2;
    $Chars=GetChar($dbconn, $_SESSION['User_ID']);
  /***************************
   *Beginn des Hauptprogramms*
   ***************************/
    if (isset($_POST['Button_Raid'])) 
    {
        if(($_POST['Raidauswahl']!='-----') and ($_POST['Modusauswahl']!='-----') and ($_POST['Stundeauswahl']!='-----') and ($_POST['Minuteauswahl']!='-----') and ($_POST['Gruppeauswahl']!='-----') and ($_POST['Leiterauswahl']!='-----')) 
        {
            if (empty($_POST['wiederholen']))
            {
                $insert=$db->INSERT_Raidplaner($_POST['Raidauswahl'], $_POST['Modusauswahl'], $day, $month, $year, $_POST['Stundeauswahl'], $_POST['Minuteauswahl'], $_POST['Gruppeauswahl'], $_POST['Leiterauswahl'], $_SESSION['User_ID']);
            }
            else
            {    
                for ($i=0; $i<4; $i++)
                {
                    $insert=$db->INSERT_Raidplaner($_POST['Raidauswahl'], $_POST['Modusauswahl'], $day, $month, $year, $_POST['Stundeauswahl'], $_POST['Minuteauswahl'], $_POST['Gruppeauswahl'], $_POST['Leiterauswahl'], $_SESSION['User_ID']);    
                    $day = $day + 7;
                    $monatstage = 0;
                    switch ($month)
                    {
                    case(1):
                        $monatstage = 31;
                        break;
                    case(2):
                        $monatstage = 28;
                        break;
                    case(3):
                        $monatstage = 31;
                        break;
                    case(4):   
                        $monatstage = 30;
                        break;
                    case(5):   
                        $monatstage = 31;
                        break;
                    case(6):   
                        $monatstage = 30;
                        break;
                    case(7):   
                        $monatstage = 31;
                        break;
                    case(8):   
                        $monatstage = 31;
                        break;
                    case(9):   
                        $monatstage = 30;
                        break;
                    case(10):  
                        $monatstage = 31;
                        break;
                    case(11):  
                        $monatstage = 30;
                        break;
                    case(12):  
                        $monatstage = 31;
                        break;
                    }
                    if ($day>$monatstage)
                        $i=4;
               }
           }
        }
        $ziel = "./Raidplaner.php";
		header("Location: $ziel");
    } 
    if(isset($_POST['Button_Raid_Anmelden']))
    {
        if ($_POST['Charauswahl']!="-----")
        {
            $CharID = $db->GetCharID($_POST['Charauswahl'] ,$_SESSION['User_ID']);
            if($_POST['Anmeldung']=='Anmelden')
            {
                if ($Raids[0]['Gruppe'] == 'Raidgruppe 2')
                {
                    $i = 0;
                        if (strpos($RG2, $UserIDRaid )!==false)
                        {
                            foreach($RaidteilnehmerArray as $Raidteilnehmer)
                            {     
                                if ($Raidteilnehmer['Teilnahme']==1)
                                    $i++;
                            }
                            if ($i==8)
                                $Raidteilnahme = 2;
                            else
                                $Raidteilnahme = 1;
                        }
                }
                elseif ($Raids[0]['Gruppe'] == 'Raidgruppe 1')
                {
                    $i = 0;
                        if (strpos($RG1, $UserIDRaid )!==false)
                        {
                            foreach($RaidteilnehmerArray as $Raidteilnehmer)
                            {
                                if ($Raidteilnehmer['Teilnahme']==1)
                                    $i++;
                            }
                            if ($i==8)
                                $Raidteilnahme = 2;
                            else
                                $Raidteilnahme = 1;
                        }
                }
            }
            elseif ($_POST['Anmeldung']=='Ersatz')
            {
                $Raidteilnahme = 3;
            }
            elseif ($_POST['Anmeldung']=='Abmelden')
            {
                $Raidteilnahme = 4;
            }
            $i = 0;
            foreach($RaidteilnehmerArray as $Raidteilnehmer)
            {
                if ($Raidteilnehmer['UserID']==$_SESSION['User_ID'])
                    $i = 1;
            }
            if($i == 1)
            {
                $db->UpdateRaidChar($ID, $CharID, $Raidteilnahme, $_SESSION['User_ID'] );
            }
            else
            {
                $db->InsertRaidChar($ID, $CharID, $Raidteilnahme, $_SESSION['User_ID'] );
            }
            
        }
        if($_POST['RaidKommentar']!="")
        {
            if(strlen($_POST['RaidKommentar']) > 10 and strlen($_POST['RaidKommentar']) < 100)
            {   
                $db->UpdateKommentar($ID,  $_SESSION['User_ID'], $_POST['RaidKommentar']);
                
            }
        } 
        $ziel = "./Raids.php?id=$ID";
		header("Location: $ziel");
    }

    if(isset($_POST['Button_User_bestaetigen']))
    {
        if ($_POST['Charauswahl_bestaetigen']!='-----')
        {             
            $CharID = GetCharIDohneUser($dbconn, $_POST['Charauswahl_bestaetigen']);
            foreach ($CharID as $CharIDEinzeln)
            $db->UpdateRaidChar($ID, $CharIDEinzeln['ID'], 1, $CharIDEinzeln['User_ID'] );
        }
		
		if ($_POST['Charauswahl_Ersatz']!='-----')
        {             
            $CharID = GetCharIDohneUser($dbconn, $_POST['Charauswahl_Ersatz']);
            foreach ($CharID as $CharIDEinzeln)
            $db->UpdateRaidChar($ID, $CharIDEinzeln['ID'], 3, $CharIDEinzeln['User_ID'] );
		}
        $ziel = "./Raids.php?id=$ID";
		header("Location: $ziel");
    }      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Imperial-March - Raidplaner</title>
<link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Wallpoet" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Graduate" rel="stylesheet" type="text/css"/>
<link href="./style.css" rel="stylesheet" type="text/css" media="screen" />
		<script type="text/javascript" src="./src/overlay.js"></script>
		<script type="text/javascript">var GB_ROOT_DIR = "./greybox/";</script>
		<script type="text/javascript" src="greybox/AJS.js"></script>
		<script type="text/javascript" src="greybox/AJS_fx.js"></script>
		<script type="text/javascript" src="greybox/gb_scripts.js"></script>
		<script type="text/javascript">
		$(function() {
		    $('a[href^=http]').click( function() {
		        window.open(this.href);
		        return false;
		    });
		});
		</script>
		<link href="greybox/gb_styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
	<div id="header-wrapper">
		<div id="header">
			<div id="logo">
			</div>
		</div>
	</div>
	<div id="menu">
		<ul>
			 <li><a href="./login.php">Home</a></li>
             <li><a href="./overview.php">Forum</a></li>
             <li class="current_page_item"><a href="./raidplaner.php">Raidplaner</a></li>
			 <li><a href="#">News</a>
				<ul>
					<li><a href="./News.php">News</a></li>
					<li><a href="./Gildenregeln.php">Gildenregeln</a></li>
				</ul>
			</li>

			 <li><a href="./Bewerbungen.php">Bewerbung</a></li>
			 <li><a href="#">Media</a>
				<ul>
					<li><a href="./Pictures.php">Pictures</a></li>
					<li><a href="./Movies.php">Movies</a></li>
				</ul>
			 </li>
			 <li><a href="./User.php">User</a></li>
			 <li><a href="./Account.php">Account</a></li>
			<?php
			if($Status=='admin')
			{
			echo '<li><a href="./Admin.php">Admin</a></li>';
			}
			?>
		</ul>
	</div>
	  	<div id="page">
    		<div id="page-bgtop">
    			<div id="page-bgbtm">
    				<div id="content_bewerbung_user">
    					<div class="post">
    					   <?php 
    					       if (!isset($_GET['id']))
    					        {
                           ?>
                        	<div id="RaidErstellen">
        						<div>
                                    <h2 style="font-family: Arial; color: #FFFFFF;">Raid erstellen f&uuml;r den <?php echo $_GET['d'] ?>.<?php echo $_GET['m'] ?>.<?php echo $_GET['y'] ?></h2> 
                                </div>
                                <form method="post" action="<?php echo "./Raids.php?d=$day&amp;m=$month&amp;y=$year" ?>" enctype="multipart/form-data">
                                    <div id="RaidRaid">
									<table>
										<tr>
											<th><h4 id="raid">Raid: </h4></th>
											<th><h4 id="raid">Modus: </h4></th>
											<th><h4 id="raid">Stunde: </h4></th>
											<th><h4 id="raid">Minute: </h4></th>
											<th><h4 id="raid">Gruppe: </h4></th>
											<th><h4 id="raid">Raidleiter: </h4></th>
											<th></th>
											<th></th>
										</tr>
										<tr>
											<td>
												<select id="Raidauswahl" name="Raidauswahl">
													<option>-----</option>
													<option>Ewige Kammer</option>
													<option>Karragas Palast</option>
													<option>Denova</option>
													<option>Asation</option>
													<option>Darvannis</option>
													<option>Toborros Hof</option>
													<option>Schreckensfestung</option>
													<option>Schreckenspalast</option>
													<option>Weltbosse</option>
												</select>
											</td>
											<td>
												<select id="Modusauswahl" name="Modusauswahl">
													<option>-----</option>
													<option>SM</option>
													<option>HC</option>
													<option>NM</option>
												</select>
											</td>
											<td>
												<select id="Stundeauswahl" name="Stundeauswahl">
													<option>-----</option>
													<option>18</option>
													<option>19</option>
													<option>20</option>
													<option>21</option>
													<option>22</option>
												</select>
											</td>
											<td>
												<select id="Minuteauswahl" name="Minuteauswahl">
													<option>-----</option>
													<option>00</option>
													<option>15</option>
													<option>30</option>
													<option>45</option>
												</select>
											</td>
											<td>
												<select id="Gruppeauswahl" name="Gruppeauswahl">
													<option>-----</option>
													<option>Raidgruppe 1</option>
													<option>Raidgruppe 2</option>
													<option>16er</option>
													<option>Event (siehe Forum)</option>
												</select>
											</td>
											<td>
												<select id="Leiterauswahl" name="Leiterauswahl">
													<option>-----</option>
													<?php
														foreach($User as $Raidleiter)
														{
															if ($Raidleiter['Status']!= 'deaktiviert')
																echo '<option>'.$Raidleiter['Mainchar'].'</option>';       
														}
													 ?>
												</select>
											</td>
											<td>
												<input type="checkbox" name="wiederholen" value="wiederholen" /> Raid 4 Wochen wiederholen? 
											</td>
											<td>
												<input type="submit" class="buttons" name="Button_Raid" value="Erstellen" />
											</td>
										</tr>
									</table>
                                </form>
                            </div>
                            <?php 
                            }
                            else
                            {
                                foreach($Raids as $Raid)
                                {
                                ?>
                                <form method="post" action="<?php echo "./Raids.php?id=$ID" ?>" enctype="multipart/form-data">
                                    <table>
                                    <tr>
                                    <td><h3 style="margin-left: -450px; font-family: Arial; color: #FFFFFF;">Raid:</h3></td><td><h3 style="font-family: Arial; color: #FFFFFF;"><?php echo $Raid['Raid'] ?>[<?php echo $Raid['Modus'] ?>]</h3></td>
                                    </tr>
                                    <tr>
                                    <td><h3 style="margin-left: -450px; font-family: Arial; color: #FFFFFF;">Raidleiter:</h3></td><td><h3 style="font-family: Arial; color: #FFFFFF;"><?php echo $Raid['Raidleiter'] ?></h3></td>
                                    </tr>
                                    <tr>
                                    <td><h3 style="margin-left: -450px; font-family: Arial; color: #FFFFFF;">Raidgruppe:</h3></td><td><h3 style="font-family: Arial; color: #FFFFFF;"><?php echo $Raid['Gruppe'] ?></h3></td>
                                    </tr>
                                    <tr>
                                    <td><h3 style="margin-left: -450px; font-family: Arial; color: #FFFFFF;">Zeit:</h3></td><td><h3 style="font-family: Arial; color: #FFFFFF;"><?php echo $Raid['Tag']?>.<?php echo $Raid['Monat']?>.<?php echo $Raid['Jahr']?> <?php echo $Raid['Uhrzeit']?></h3></td>
                                    </tr>
                                    </table>
                                    <h3 style="margin-left: -450px; font-family: Arial; color: #FFFFFF;">Anmelden:</h3>
                                    <?php
                                    if (count($Chars) > 0)
                                    {
                                    ?>
                                        <h4 style="margin-left: -450px; font-family: Arial; color: #FFFFFF;">Stammspieler der Raidgruppen werden bei Anmeldung automatisch best&auml;tigt</h4>
                                        <div style="margin-left:-450px"><select id="Charauswahl" name="Charauswahl">
                							<option>-----</option>
                							<?php 
                                            foreach($Chars as $Char)
                                            {
                                                echo '<option>'.$Char['Char'].'</option>';
                                            } 
                                            ?>
                						</select></div>
                                        <div style="margin-left:-450px; margin-top: 5px; "><select id="Anmeldung" name="Anmeldung">
                							<option>-----</option>
                							<option>Anmelden</option>
                							<option>Ersatz</option>
                							<option>Abmelden</option>
                						</select></div>
                						<div style="margin-top: 5px; margin-left: -450px; font-size: .7em;">Kommentar: min. 10 Zeichen, max. 100 Zeichen (kein Pflichtfeld)</div>
                						<div id="Text_Raid_Kommentar" style="margin-top: 5px; margin-left: -450px;">
                                            <input type="text" id="RaidKommentar" name="RaidKommentar" value="<?=$db->GetRaidKommentar($_SESSION['User_ID'], $ID);?>" />
                                        </div>
                                        <div id="Button_Raid_Anmeldung" style="margin-top: 5px; margin-left: -450px;">
        									<input type="submit" class="buttons" name="Button_Raid_Anmelden" value="Best&auml;tigen" />
        								</div>
        								
    			       				<?php
                                    }
                                    else
                                    {
                                        echo '<h4 style="margin-left: -450px; font-family: Arial; color: #FFFFFF;">Es m&uuml;ssen erst Chars unter "Account" erstellt werden.</h4>';
                                    }
                                    ?>
    								<div style="margin-left: -200px;">
                                        <table cellspacing="0" style="margin-top: 20px;">
                                            <tr>
                                                <th style="width: 600px; text-align: center; background-color: green; color: black; border: 1px solid silver;" colspan = '3' >Best&auml;tigt</th>
                                            </tr>    
                                            <tr>
                                                <td style="text-align: center; width: 200px; border-top: 1px solid silver; border-left: 1px solid silver"><b>DD</b></td><td style="text-align: center; width: 200px; border-top: 1px solid silver; "><b>Heal</b></td><td style="text-align: center; width: 200px; border-top: 1px solid silver; border-right: 1px solid silver"><b>Tank</b></td>
                                            </tr>
                                            <?php
                                            if (count($Bestaetigt)!= 0)
                                            {
                                                echo'<tr>
                                                        <td style="border-bottom: 1px solid silver; border-left: 1px solid silver"></td><td style="border-bottom: 1px solid silver; "></td><td style="border-bottom: 1px solid silver; border-right: 1px solid silver"></td>
                                                     </tr>';
                                            }
                                            $a = 0;
                                            $b = 0;
                                            $c = 0;
                                            $d = 0;
                                            
                                            for ($d;$d<count($Bestaetigt);$d++)
                                            {
                                                echo '<tr>';
                                                echo '<td style="text-align: center; border-left: 1px solid silver"><b>';
                                                    for ($a; $a<count($Bestaetigt); $a++)
                                                    {
                                                        if ($Bestaetigt[$a]['Klasse'] == 'RDD' OR $Bestaetigt[$a]['Klasse'] == 'Melee')
                                                        {
                                                            print_r($Bestaetigt[$a]['Char']);
                                                            $a++;
                                                            break;
                                                        }
                                                    }
                                                echo'</b></td>';
                                                echo '<td style="text-align: center;"><b>';
                                                    for ($b; $b<count($Bestaetigt); $b++)
                                                    {
                                                        if ($Bestaetigt[$b]['Klasse'] == 'Heal')
                                                        {
                                                            print_r($Bestaetigt[$b]['Char']);
                                                            $b++;
                                                            break;
                                                        }
                                                    }
                                                echo'</b></td>';
                                                echo '<td style="text-align: center; border-right: 1px solid silver"><b>';
                                                    for ($c; $c<count($Bestaetigt); $c++)
                                                    {
                                                        if ($Bestaetigt[$c]['Klasse'] == 'Tank')
                                                        {
                                                            print_r($Bestaetigt[$c]['Char']);
                                                            $c++;
                                                            break;
                                                        }
                                                    }
                                                echo'</b></td>';
                                                echo '</tr>';
                                            }
                                            
                                            ?>
                                        <tr>
                                            <td style="border-bottom: 1px solid silver; border-left: 1px solid silver"></td><td style="border-bottom: 1px solid silver; "></td><td style="border-bottom: 1px solid silver; border-right: 1px solid silver"></td>
                                        </tr>
                                        </table>
                                        <table cellspacing="0" style="margin-top: 20px;">
                                            <tr>
                                                <th style="width: 600px; text-align: center; background-color: yellow; color: black; border: 1px solid silver;" colspan = '3'>Angemeldet</th>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center; width: 200px; border-top: 1px solid silver; border-left: 1px solid silver"><b>DD</b></td><td style="text-align: center; width: 200px; border-top: 1px solid silver; "><b>Heal</b></td><td style="text-align: center; width: 200px; border-top: 1px solid silver; border-right: 1px solid silver"><b>Tank</b></td>
                                            </tr>
                                            <?php
                                            if (count($Angemeldet)!= 0)
                                            {
                                                echo'<tr>
                                                        <td style="border-bottom: 1px solid silver; border-left: 1px solid silver"></td><td style="border-bottom: 1px solid silver; "></td><td style="border-bottom: 1px solid silver; border-right: 1px solid silver"></td>
                                                     </tr>';
                                            }
											$a = 0;
                                            $b = 0;
                                            $c = 0;
                                            $d = 0;
                                            
                                            for ($d;$d<=count($Angemeldet);$d++)
                                            {
					    
                                            echo '<tr>';
                                                echo '<td style="text-align: center; border-left: 1px solid silver"><b>';
                                                    for ($a; $a<count($Angemeldet); $a++)
                                                    {
                                                        if ($Angemeldet[$a]['Klasse'] == 'RDD' OR $Angemeldet[$a]['Klasse'] == 'Melee')
                                                        {
                                                            print_r($Angemeldet[$a]['Char']);
                                                            $a++;
                                                            break;
                                                        }
                                                    }                                           
                                                echo'</b></td>';
                                                echo '<td style="text-align: center;"><b>';
                                                    for ($b; $b<count($Angemeldet); $b++)
                                                    {
                                                        if ($Angemeldet[$b]['Klasse'] == 'Heal')
                                                        {
                                                            print_r($Angemeldet[$b]['Char']);
                                                            $b++;
                                                            break;
                                                        }
                                                    }
                                                echo'</b></td>';
                                                echo '<td style="text-align: center; border-right: 1px solid silver"><b>';
                                                    for ($c; $c<count($Angemeldet); $c++)
                                                    {
                                                        if ($Angemeldet[$c]['Klasse'] == 'Tank')
                                                        {
                                                            print_r($Angemeldet[$c]['Char']);
                                                            $c++;
                                                            break;
                                                        }
                                                    }
                                                
                                                echo '</b></td>';
                                            echo '</tr>';
                                            }
                                            ?>
                                        <tr>
                                            <td style="border-bottom: 1px solid silver; border-left: 1px solid silver"></td><td style="border-bottom: 1px solid silver; "></td><td style="border-bottom: 1px solid silver; border-right: 1px solid silver"></td>
                                        </tr>
                                        </table>
                                        <table cellspacing="0" style="margin-top: 20px;">
                                            <tr>
                                                <th style="width: 600px; text-align: center; background-color: Purple; color: black; border: 1px solid silver;" colspan = '3'>Ersatz</th>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center; width: 200px; border-top: 1px solid silver; border-left: 1px solid silver"><b>DD</b></td><td style="text-align: center; width: 200px; border-top: 1px solid silver; "><b>Heal</b></td><td style="text-align: center; width: 200px; border-top: 1px solid silver; border-right: 1px solid silver"><b>Tank</b></td>
                                            </tr>
                                            <?php
                                            if (count($Ersatz)!= 0)
                                            {
                                                echo'<tr>
                                                        <td style="border-bottom: 1px solid silver; border-left: 1px solid silver"></td><td style="border-bottom: 1px solid silver; "></td><td style="border-bottom: 1px solid silver; border-right: 1px solid silver"></td>
                                                     </tr>';
                                            }
                                            $a = 0;
                                            $b = 0;
                                            $c = 0;
                                            $d = 0;
                                            
                                            for ($d;$d<=count($Ersatz);$d++)
                                            {
                                            echo '<tr>';
                                                echo '<td style="text-align: center; border-left: 1px solid silver"><b>';
                                                    for ($a; $a<count($Ersatz); $a++)
                                                    {
                                                        if ($Ersatz[$a]['Klasse'] == 'RDD' OR $Ersatz[$a]['Klasse'] == 'Melee')
                                                        {
                                                            print_r($Ersatz[$a]['Char']);
                                                            $a++;
                                                            break;
                                                        }
                                                    }
                                                echo'</b></td>';
                                                echo '<td style="text-align: center;"><b>';
                                                    for ($b; $b<count($Ersatz); $b++)
                                                    {
                                                        if ($Ersatz[$b]['Klasse'] == 'Heal')
                                                        {
                                                            print_r($Ersatz[$b]['Char']);
                                                            $b++;
                                                            break;
                                                        }
                                                        $b++;
                                                    }
                                                echo'</b></td>';
                                                echo '<td style="text-align: center; border-right: 1px solid silver"><b>';
                                                    for ($c; $c<count($Ersatz); $c++)
                                                    {
                                                        if ($Ersatz[$c]['Klasse'] == 'Tank')
                                                        {
                                                            print_r($Ersatz[$c]['Char']);
                                                            $c++;
                                                            break;
                                                        }
                                                    }
                                                
                                                echo '</b></td>';
                                            echo '</tr>';
                                            };
                                            ?>
                                        <tr>
                                            <td style="border-bottom: 1px solid silver; border-left: 1px solid silver"></td><td style="border-bottom: 1px solid silver; "></td><td style="border-bottom: 1px solid silver; border-right: 1px solid silver"></td>
                                        </tr>
                                        </table>
                                        <table cellspacing="0" style="margin-top: 20px;">
                                            <tr>
                                                <th style="width: 600px; text-align: center; background-color: red; color: black; border: 1px solid silver;" colspan = '3'>Abgemeldet</th>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center; width: 200px; border-top: 1px solid silver; border-left: 1px solid silver"><b>DD</b></td><td style="text-align: center; width: 200px; border-top: 1px solid silver; "><b>Heal</b></td><td style="text-align: center; width: 200px; border-top: 1px solid silver; border-right: 1px solid silver"><b>Tank</b></td>
                                            </tr>
                                            <?php
                                            if (count($Abgemeldet)!= 0)
                                            {   
                                                echo'<tr>
                                                        <td style="border-bottom: 1px solid silver; border-left: 1px solid silver"></td><td style="border-bottom: 1px solid silver; "></td><td style="border-bottom: 1px solid silver; border-right: 1px solid silver"></td>
                                                     </tr>';
                                            }
                                            $a = 0;
                                            $b = 0;
                                            $c = 0;
                                            $d = 0;
                                            
                                            for ($d;$d<=count($Abgemeldet);$d++)
                                            {
                                            echo '<tr>';
                                                echo '<td style="text-align: center; border-left: 1px solid silver"><b>';
                                                    for ($a; $a<count($Abgemeldet); $a++)
                                                    {
                                                        if ($Abgemeldet[$a]['Klasse'] == 'RDD' OR $Abgemeldet[$a]['Klasse'] == 'Melee')
                                                        {
                                                            print_r($Abgemeldet[$a]['Char']);
                                                            $a++;
                                                            break;
                                                        }
                                                    }
                                                echo'</b></td>';
                                                echo '<td style="text-align: center;"><b>';
                                                    for ($b; $b<count($Abgemeldet); $b++)
                                                    {
                                                        if ($Abgemeldet[$b]['Klasse'] == 'Heal')
                                                        {
                                                            print_r($Abgemeldet[$b]['Char']);
                                                            $b++;
                                                            break;
                                                        }
                                                    }
                                                echo'</b></td>';
                                                echo '<td style="text-align: center; border-right: 1px solid silver"><b>';
                                                    for ($c; $c<count($Abgemeldet); $c++)
                                                    {
                                                        if ($Abgemeldet[$c]['Klasse'] == 'Tank')
                                                        {
                                                            print_r($Abgemeldet[$c]['Char']);
                                                            $c++;
                                                            break;
                                                        }
                                                    }
                                                echo '</b></td>';
                                            echo '</tr>';
                                            }
                                            ?>
                                        <tr>
                                            <td style="border-bottom: 1px solid silver; border-left: 1px solid silver"></td><td style="border-bottom: 1px solid silver; "></td><td style="border-bottom: 1px solid silver; border-right: 1px solid silver"></td>
                                        </tr>
                                        </table>
                                        
                                    </div>
                        			<?php
                        			if($Status=='admin' or $_SESSION['User_ID'] == $RaidleiterID)
                        			{
                                    ?>                                    
									<h4 style="margin-left: -450px; font-family: Arial; color: #FFFFFF;">Angemeldete Spieler best&auml;tigen</h4>
                                    <div style="margin-left:-450px"><select id="Charauswahl_bestaetigen" name="Charauswahl_bestaetigen">
            							<option>-----</option>
            							<?php 
                                        foreach($Angemeldet as $Char)
                                        {
                                            echo '<option>'.$Char['Char'].'</option>';
                                        }
										foreach($Ersatz as $Char)
                                        {
                                            echo '<option>'.$Char['Char'].'</option>';
                                        } 
                                        ?>
            						</select></div>
									<h4 style="margin-left: -450px; font-family: Arial; color: #FFFFFF;">Best&auml;tigte Spieler -> Ersatzbank</h4>
                                    <div style="margin-left:-450px"><select id="Charauswahl_Ersatz" name="Charauswahl_Ersatz">
            							<option>-----</option>
            							<?php 
                                        foreach($Bestaetigt as $Char)
                                        {
                                            echo '<option>'.$Char['Char'].'</option>';
                                        }
                                        ?>
            						</select></div>
									<div id="Button_Raid_Anmeldung" style="margin-top: 5px; margin-left: -450px;">
    									<input type="submit" class="buttons" name="Button_User_bestaetigen" value="Best&auml;tigen" />
    								</div>
    								<?php 
                                    }
                                    ?>
                                </form>   
                                <?php
                                }
                                $KommentarVorhanden = 0;
                                foreach($RaidteilnehmeranzeigeArray as $KommentarAnzeige)
                                {
                                    if ($KommentarAnzeige['Kommentar'] != "")
                                        $KommentarVorhanden = 1;
                                }
                                if ($KommentarVorhanden == 1)
                                {       
                                    echo ' <div style="margin-left: -200px;"><table cellspacing="0" style="background-color: rgba(0, 0, 0, 0.7);">';
                                     echo '<tr><th colspan="2"><h3 style="font-family: Arial; color: #FFFFFF; text-align: left;">Kommentare</h3></th></tr>';
                                    foreach($RaidteilnehmeranzeigeArray as $KommentarAnzeige)
                                    {   
                                        if ($KommentarAnzeige['Kommentar']!="")
                                        {
                                            echo '<tr><td style="width: 60px; text-align: left;">';
                                            echo $KommentarAnzeige['Char'].': ';
                                            echo '</td><td style="width: 550px;">';
                                            echo $KommentarAnzeige['Kommentar'];
                                            echo '</td></tr>';
                                        }
                                    }
                                }                               
                            } 
                            ?>
    					</div>
    				</div>
    			</div>
    		</div>
       	</div>
</div>
</body>
</html>
			