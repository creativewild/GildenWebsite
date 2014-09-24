<?php
  /****************************
   *Einbindung fremder Dateien*
   ****************************/
    require_once "./src/my_funcs.inc";
    include "./src/dbadmin.inc";
	include "./src/db.inc";
    include "./src/print_html.inc";
	include "./src/admin.inc";


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
	$dbconn = Connect_DB();
	$db=new Datenbank();
  /***************************
   *Beginn des Hauptprogramms*
   ***************************/
    $timestamp = time();
    $db->Useronline($_SESSION['User_ID'], $timestamp);

	
	$Status = $db->Get_Status($_SESSION['User_ID']);
	if($Status!='admin')
		header("Location: ./index.php");


	if (isset($_POST['button_status']))
	{
		if(isset($_POST['aktiv']))
		{
			$status='aktiv';
			$ID=(int)$_POST['aktiv'];
			$db->Statusaendern($ID, $status);
		}
		if(isset($_POST['deaktiv']))
		{
			$status='deaktiviert';
			$ID=(int)$_POST['deaktiv'];
			$db->Statusaendern($ID, $status);
		}
		if(isset($_POST['admin']))
		{
			$status='admin';
			$ID=(int)$_POST['admin'];
			$db->Statusaendern($ID, $status);
		}
	}

	if(isset($_POST['button_news']))
	{	
		if(!empty($_POST['News']) && !empty($_POST["admin_betreff_eingabe"]) && !empty($_POST["Admin_News_eingabe"]))
			$db->INSERT_News($_POST['News'], $_POST["admin_betreff_eingabe"], $_POST["Admin_News_eingabe"]);
		else
			$error='<h4>Bild auswählen, Betreff und Nachricht ausfüllen. Muss man sich den hier um alles kümmern, VERDAMMT NOCHMAL.</h4>';
		
	}
	if(isset($_POST['button_raids']))
	{
		$raid_arr = GetRaid($dbconn);
        foreach($raid_arr AS $raid):
	        if(!empty($_POST['Raid'.$raid["ID"]]) && ($_POST['geschafft'.$raid["ID"]]>=0) && ($_POST['gesamt'.$raid["ID"]]>=0))
	        {
                if($_POST['geschafft'.$raid["ID"]] <= $_POST['gesamt'.$raid["ID"]] )
                {
                    $db->UPDATE_Raids($raid["ID"], $_POST['Raid'.$raid["ID"]], $_POST['geschafft'.$raid["ID"]], $_POST['gesamt'.$raid["ID"]]);       
                } 
            }
        endforeach;
    }
	if(isset($_POST['button_Login_oben']))
	{	
		$Spalte="LoginOben";
		$db->SeitenInformation(1, $Spalte, $_POST['Admin_Login_oben']);
	}
	if(isset($_POST['button_Login_mitte']))
	{	
		$Spalte="LoginMitte";
		$db->SeitenInformation(1, $Spalte, $_POST['Admin_Login_mitte']);
	}
	if(isset($_POST['button_Login_unten']))
	{	
		$Spalte="LoginUnten";
		$db->SeitenInformation(1, $Spalte, $_POST['Admin_Login_unten']);
	}
	if(isset($_POST['button_Raid1']))
	{	
		$ID = 1;
		$db->UpdateRaidGruppenAdmin($ID, $_POST['Raid1_Tag1'], $_POST['Raid1_Uhrzeit1'], $_POST['Raid1_Tag2'], $_POST['Raid1_Uhrzeit2'], $_POST['Raid1_Tank1'], $_POST['Raid1_Tank2'], $_POST['Raid1_Heal1'], $_POST['Raid1_Heal2'], $_POST['Raid1_DD1'], $_POST['Raid1_DD2'], $_POST['Raid1_DD3'], $_POST['Raid1_DD4'], $_POST['Raid1_StammID'] );
	}
	if(isset($_POST['button_Raid2']))
	{	
		$ID = 2;
		$db->UpdateRaidGruppenAdmin($ID, $_POST['Raid2_Tag1'], $_POST['Raid2_Uhrzeit1'], $_POST['Raid2_Tag2'], $_POST['Raid2_Uhrzeit2'], $_POST['Raid2_Tank1'], $_POST['Raid2_Tank2'], $_POST['Raid2_Heal1'], $_POST['Raid2_Heal2'], $_POST['Raid2_DD1'], $_POST['Raid2_DD2'], $_POST['Raid2_DD3'], $_POST['Raid2_DD4'], $_POST['Raid2_StammID'] );
	}
	if(isset($_POST['button_Raidgruppen']))
	{	
		$Spalte="Raidgruppen";
		$db->SeitenInformation(1, $Spalte, $_POST['Admin_Raidgruppen']);
	}
	if(isset($_POST['button_TS3Gespraech']))
	{	
		$Spalte="TS3Gespraech";
		$db->SeitenInformation(1, $Spalte, $_POST['Admin_TS3Gespraech']);
	}
	if(isset($_POST['button_ForumAnwesenheit']))
	{	
		$Spalte="ForumAnwesenheit";
		$db->SeitenInformation(1, $Spalte, $_POST['Admin_ForumAnwesenheit']);
	}
	if(isset($_POST['button_Teamspeak3']))
	{	
		$Spalte="Teamspeak3";
		$db->SeitenInformation(1, $Spalte, $_POST['Admin_Teamspeak3']);
	}
	if(isset($_POST['button_Sozialverhalten']))
	{	
		$Spalte="Sozialverhalten";
		$db->SeitenInformation(1, $Spalte, $_POST['Admin_Sozialverhalten']);
	}
	if(isset($_POST['button_Loot']))
	{	
		$Spalte="Loot";
		$db->SeitenInformation(1, $Spalte, $_POST['Admin_Loot']);
	}
	if(isset($_POST['button_Ausschluss']))
	{	
		$Spalte="Ausschluss";
		$db->SeitenInformation(1, $Spalte, $_POST['Admin_Ausschluss']);
	}

	$SeitenInformationarray = GetSeitenInformation($dbconn);
	$Raidgruppenarray = GetRaidgruppen($dbconn);
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Imperial-March - Admin</title>
		<link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css"/>
		<link href="http://fonts.googleapis.com/css?family=Wallpoet" rel="stylesheet" type="text/css"/>
		<link href="http://fonts.googleapis.com/css?family=Graduate" rel="stylesheet" type="text/css"/>
		<link href="./styleadmin.css" rel="stylesheet" type="text/css" media="screen" />
	</head>
	<body>
		<div id="wrapper">
			<div id="menu">
				<ul>
					<li><a href="./Login.php">Home</a></li>
					<li><a href="./overview.php">Forum</a></li>
					<li><a href="./raidplaner.php">Raidplaner</a></li>
					<li><a href="./News.php">News</a></li>
					<li><a href="./Gildenregeln.php">Gildenregeln</a></li>
					<li><a href="./Bewerbungen.php">Bewerbung</a></li>
					<li><a href="./Pictures.php">Pictures</a></li>
					<li><a href="./Movies.php">Movies</a></li>
					<li><a href="./User.php">User</a></li>
					<li><a href="./Account.php">Acc.</a></li>
					<li><a href="./Forum.php">Forum Edit</a></li>
				</ul>
			</div>
		</div>
		<div id="User">
		<hr />
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<h2>Websitearchivieren</h2>
				<h4>Per "ausf&uuml;hren" wird eine Sicherung der Datenbank von der Website erstellt.</h4>
				<h4>Die Sicherungsdatei wird hierbei überschrieben.</h4>
				<div><input type="submit" value="ausf&uuml;hren" name="button_website_archiv" /></div>
				<hr />
				<table>
					<colgroup>
					 <col width="550" />
					 <col width="550" />
					 <col width="550" />
				   </colgroup>
					<tr>
						<td><h2>User Best&auml;tigen</h2></td>
						<td><h2>News erstellen</h2></td>
						<td><h2>Raids</h2></td>
					</tr>
					<tr>
						<td valign="top"><p>	Es darf nur ein Button gedr&uuml;ckt werden und dann best&auml;tigen.</p>
								<?php
								$user_arr = GetUser($dbconn);
								echo $table = print_user_as_table($user_arr); ?>
								<div><input type="submit" value="ausf&uuml;hren" name="button_status" /></div>
						</td>
						<td valign="top"><div><input type="radio" name="News" value="./img/Site/I_M_FUN.png" />IM-Fun</div>
							<div><input type="radio" name="News" value="./img/Site/News.png" />News</div>
							<div><input type="radio" name="News" value="./img/Site/Event.png" />Event</div>
							<div><label for="admin_betreff_eingabe">Betreff:</label></div>
							<div><input type="text" id="admin_betreff_eingabe" name="admin_betreff_eingabe" /></div>
							<div><label>Nachricht:</label></div>
							<h4>Beim Zeilenende "ENTER" dr&uuml;cken, haut sonst mit der Ausgabeformatierung nicht hin.</h4>
							<div><textarea name="Admin_News_eingabe" cols="52" rows="15"></textarea></div>
							<?=$error;?>
							<div><input type="submit" value="ausf&uuml;hren" name="button_news" /></div>
						</td>
						<td valign="top">
							<table>
								<tr>
								   <td></td>
								   <td>Raid:</td>
								   <td>Geschafft:</td>
								   <td>Gesamt:</td>
								   <td></td>
								</tr>
							<?php
								$raid_arr = GetRaid($dbconn);
								foreach($raid_arr AS $raid):
								?>
									<tr>
										<td><?php echo $raid["ID"];?></td>
										<td><input type="text" class="raid" name="Raid<?=$raid["ID"]?>" value="<?php echo $raid["Raid"];?>" /></td>
										<td><input type="text" class="raid" name="geschafft<?=$raid["ID"]?>" value="<?php echo $raid["geschafft"];?>" /></td>
										<td><input type="text" class="raid" name="gesamt<?=$raid["ID"]?>" value="<?php echo $raid["gesamt"];?>" /></td>
									</tr>
									<?php 
			 
								endforeach;
							?>
							
							</table>
							<div><input type="submit" value="ausf&uuml;hren" name="button_raids" /></div>
						</td>
					</tr>
					<tr>
						<td colspan = "3"><h2>Startseite</h2></td>
					</tr>
					<tr>
						<td><h4>Oben</h4></td>
						<td><h4>Mitte</h4></td>
						<td><h4>Unten</h4></td>
					</tr>
					<?php ForEach($SeitenInformationarray as $SeitenInformation )
					{?>
					<tr>
						<td>
							<div><textarea name="Admin_Login_oben" cols="52" rows="15"><?= $SeitenInformation['LoginOben']?></textarea></div>
							<?=$error;?>
							<div><input type="submit" value="ausf&uuml;hren" name="button_Login_oben" /></div>
						</td>
						<td>
							<div><textarea name="Admin_Login_mitte" cols="52" rows="15"><?= $SeitenInformation['LoginMitte']?></textarea></div>
							<?=$error;?>
							<div><input type="submit" value="ausf&uuml;hren" name="button_Login_mitte" /></div>
						</td>
						<td>	
							<div><textarea name="Admin_Login_unten" cols="52" rows="15"><?= $SeitenInformation['LoginUnten']?></textarea></div>
							<?=$error;?>
							<div><input type="submit" value="ausf&uuml;hren" name="button_Login_unten" /></div>
						</td>
					</tr>
					<?php }?>
					<tr>
						<td colspan = "3"><h2>Gildenregeln</h2></td>
					</tr>
					<tr>
						<td colspan = "3"><h2>Raidgruppen</h2></td>
					</tr>
					<tr>
						<td><h4>Gruppe1</h4></td>
						<td><h4>Gruppe2</h4></td>
						<td><h4>Information</h4></td>
					</tr>
					<tr>
						<td>
						<?php ForEach($Raidgruppenarray as $Raidgruppen)
						{
							if ($Raidgruppen['ID']==1)
							{
						?>
							<table id="Raid1">
								<tr>
									<td>Raidgruppe 1: </td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Zeiten: </td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td><input type="text" id="Raid1_Tag1" name="Raid1_Tag1" value="<?=$Raidgruppen['Tag1'] ?>" /></td>
									<td></td>
									<td><input type="text" id="Raid1_Uhrzeit1" name="Raid1_Uhrzeit1" /value="<?=$Raidgruppen['Uhrzeit1'] ?>" /></td>
								</tr>
								<tr>
									<td><input type="text" id="Raid1_Tag2" name="Raid1_Tag2" value="<?=$Raidgruppen['Tag2'] ?>" /></td>
									<td></td>
									<td><input type="text" id="Raid1_Uhrzeit2" name="Raid1_Uhrzeit2" value="<?=$Raidgruppen['Uhrzeit2'] ?>" /></td>
								</tr>
								<tr class = "Tank">
									<td>Tank:</td>
									<td></td>
									<td><input type="text" id="Raid1_Tank1" name="Raid1_Tank1" value="<?=$Raidgruppen['Tank1'] ?>" /></td>
								</tr>
								<tr class = "Tank">
									<td>Tank:</td>
									<td></td>
									<td><input type="text" id="Raid1_Tank2" name="Raid1_Tank2" value="<?=$Raidgruppen['Tank2'] ?>" /></td>
								</tr>
								<tr class = "Heal">
									<td>Heal:</td>
									<td></td>
									<td><input type="text" id="Raid1_Heal1" name="Raid1_Heal1" value="<?=$Raidgruppen['Heal1'] ?>" /></td>
								</tr>
								<tr class = "Heal">
									<td>Heal:</td>
									<td></td>
									<td><input type="text" id="Raid1_Heal2" name="Raid1_Heal2" value="<?=$Raidgruppen['Heal2'] ?>" /></td>
								</tr>
								<tr class = "DD">
									<td>DD:</td>
									<td></td>
									<td><input type="text" id="Raid1_DD1" name="Raid1_DD1" value="<?=$Raidgruppen['DD1'] ?>" /></td>
								</tr>
								<tr class = "DD">
									<td>DD:</td>
									<td></td>
									<td><input type="text" id="Raid1_DD2" name="Raid1_DD2" value="<?=$Raidgruppen['DD2'] ?>" /></td>
								</tr>
								<tr class = "DD">
									<td>DD:</td>
									<td></td>
									<td><input type="text" id="Raid1_DD3" name="Raid1_DD3" value="<?=$Raidgruppen['DD3'] ?>" /></td>
								</tr>
								<tr class = "DD">
									<td>DD:</td>
									<td></td>
									<td><input type="text" id="Raid1_DD4" name="Raid1_DD4" value="<?=$Raidgruppen['DD4'] ?>" /></td>
								</tr>
								<tr class = "DD">
									<td>User-ID Raidbest&auml;tigung:</td>
									<td></td>
									<td><input type="text" id="Raid1_StammID" name="Raid1_StammID" value="<?=$Raidgruppen['StammID'] ?>" /></td>
								</tr>
							</table>
						<?php 
							}
						} ?>
						<div><input type="submit" value="ausf&uuml;hren" name="button_Raid1" /></div>
						</td>
						<td>
						<?php ForEach($Raidgruppenarray as $Raidgruppen)
						{
							if ($Raidgruppen['ID']==2)
							{
						?>
						<table id="Raid2">
								<tr>
									<td>Raidgruppe 2: </td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Zeiten: </td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td><input type="text" id="Raid2_Tag1" name="Raid2_Tag1" value="<?=$Raidgruppen['Tag1'] ?>" /></td>
									<td></td>
									<td><input type="text" id="Raid2_Uhrzeit1" name="Raid2_Uhrzeit1" value="<?=$Raidgruppen['Uhrzeit1'] ?>" /></td>
								</tr>
								<tr>
									<td><input type="text" id="Raid2_Tag2" name="Raid2_Tag2" value="<?=$Raidgruppen['Tag2'] ?>" /></td>
									<td></td>
									<td><input type="text" id="Raid2_Uhrzeit2" name="Raid2_Uhrzeit2" value="<?=$Raidgruppen['Uhrzeit2'] ?>" /></td>
								</tr>
								<tr class = "Tank">
									<td>Tank:</td>
									<td></td>
									<td><input type="text" id="Raid2_Tank1" name="Raid2_Tank1" value="<?=$Raidgruppen['Tank1'] ?>" /></td>
								</tr>
								<tr class = "Tank">
									<td>Tank:</td>
									<td></td>
									<td><input type="text" id="Raid2_Tank2" name="Raid2_Tank2" value="<?=$Raidgruppen['Tank2'] ?>" /></td>
								</tr>
								<tr class = "Heal">
									<td>Heal:</td>
									<td></td>
									<td><input type="text" id="Raid2_Heal1" name="Raid2_Heal1" value="<?=$Raidgruppen['Heal1'] ?>" /></td>
								</tr>
								<tr class = "Heal">
									<td>Heal:</td>
									<td></td>
									<td><input type="text" id="Raid2_Heal2" name="Raid2_Heal2" value="<?=$Raidgruppen['Heal2'] ?>" /></td>
								</tr>
								<tr class = "DD">
									<td>DD:</td>
									<td></td>
									<td><input type="text" id="Raid2_DD1" name="Raid2_DD1" value="<?=$Raidgruppen['DD1'] ?>" /></td>
								</tr>
								<tr class = "DD">
									<td>DD:</td>
									<td></td>
									<td><input type="text" id="Raid2_DD2" name="Raid2_DD2" value="<?=$Raidgruppen['DD2'] ?>" /></td>
								</tr>
								<tr class = "DD">
									<td>DD:</td>
									<td></td>
									<td><input type="text" id="Raid2_DD3" name="Raid2_DD3" value="<?=$Raidgruppen['DD3'] ?>" /></td>
								</tr>
								<tr class = "DD">
									<td>DD:</td>
									<td></td>
									<td><input type="text" id="Raid2_DD4" name="Raid2_DD4" value="<?=$Raidgruppen['DD4'] ?>" /></td>
								</tr>
								<tr class = "DD">
									<td>User-ID Raidbest&auml;tigung:</td>
									<td></td>
									<td><input type="text" id="Raid2_StammID" name="Raid2_StammID" value="<?=$Raidgruppen['StammID'] ?>" /></td>
								</tr>
							</table>
						<?php 
							}
						} ?>
						<div><input type="submit" value="ausf&uuml;hren" name="button_Raid2" /></div>
						</td>
						<?php ForEach($SeitenInformationarray as $SeitenInformation )
						{?>
						<td>
							<div><textarea name="Admin_Raidgruppen" cols="52" rows="15"><?= $SeitenInformation['Raidgruppen']?></textarea></div>
							<?=$error;?>
							<div><input type="submit" value="ausf&uuml;hren" name="button_Raidgruppen" /></div>
						</td>
						<?php }?>
					</tr>
					<tr>
						<td><h2>TS3-Gespr&auml;ch</h2></td>
						<td><h2>Forum/Anwesenheit</h2></td>
						<td><h2>Teamspeak3</h2></td>
					</tr>
					<tr>
					<?php ForEach($SeitenInformationarray as $SeitenInformation )
					{?>
						<td>
							<div><textarea name="Admin_TS3Gespraech" cols="52" rows="15"><?= $SeitenInformation['TS3Gespraech']?></textarea></div>
							<?=$error;?>
							<div><input type="submit" value="ausf&uuml;hren" name="button_TS3Gespraech" /></div>
						</td>
						<td>
							<div><textarea name="Admin_ForumAnwesenheit" cols="52" rows="15"><?= $SeitenInformation['ForumAnwesenheit']?></textarea></div>
							<?=$error;?>
							<div><input type="submit" value="ausf&uuml;hren" name="button_ForumAnwesenheit" /></div>
						</td>
						<td>
							<div><textarea name="Admin_Teamspeak3" cols="52" rows="15"><?= $SeitenInformation['Teamspeak3']?></textarea></div>
							<?=$error;?>
							<div><input type="submit" value="ausf&uuml;hren" name="button_Teamspeak3" /></div>
						</td>
					</tr>
					<?php }?>
					<tr>
						<td><h2>Spiel- und Sozialverhalten</h2></td>
						<td><h2>Lootregeln</h2></td>
						<td><h2>Ausschlusskriterien</h2></td>
					</tr>
					<tr>
					<?php ForEach($SeitenInformationarray as $SeitenInformation )
					{?>
						<td>
							<div><textarea name="Admin_Sozialverhalten" cols="52" rows="15"><?= $SeitenInformation['Sozialverhalten']?></textarea></div>
							<?=$error;?>
							<div><input type="submit" value="ausf&uuml;hren" name="button_Sozialverhalten" /></div>
						</td>
						<td>
							<div><textarea name="Admin_Loot" cols="52" rows="15"><?= $SeitenInformation['Loot']?></textarea></div>
							<?=$error;?>
							<div><input type="submit" value="ausf&uuml;hren" name="button_Loot" /></div>
						</td>
						<td>
							<div><textarea name="Admin_Ausschluss" cols="52" rows="15"><?= $SeitenInformation['Ausschluss']?></textarea></div>
							<?=$error;?>
							<div><input type="submit" value="ausf&uuml;hren" name="button_Ausschluss" /></div>
						</td>
					</tr>
					<?php }?>
					<tr>
						<td colspan = "3">
							<h2>HTML-Befehle</h2>
						</td>
					</tr>
					<tr>
						<td colspan = "3">
							<h4>Eine Übersicht der wichtigsten HTML-Befehle</h4>
							<table>
								<tr>
									<td><h4>Code:</h4></td>
									<td><h4>Beschreibung</h4></td>
								</tr>
								<tr>
									<td>&lt;br /&gt;</td>
									<td>Erzwungender Zeilenumbruch</td>
								</tr>
								<tr>
									<td>&lt;p&gt;</td>
									<td>Erzwungender Absatz</td>
								</tr>
								<tr>
									<td>&lt;b&gt; ... &lt;/b&gt;</td>
									<td><b>FETT</b></td>
								</tr>
								<tr>
									<td>& uuml;</td>
									<td>(ohne Leerzeichen) &uuml;</td>
								</tr>
								<tr>
									<td>& auml;</td>
									<td>(ohne Leerzeichen) &auml;</td>
								</tr>
								<tr>
									<td>& ouml;</td>
									<td>(ohne Leerzeichen) &ouml;</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>					
				</form>
		</div>
	</body>
</html>
<?php
				if (isset($_POST['button_website_archiv']))
			    {
                    $dbhost     = "localhost";
                    $dbuser     = "root";
                    $dbpwd      = "JK198dre1YotKah";
                    $dbname     = "Forum";
                    $dbbackup   = "./backup/backupforum.sql";
                     
                    error_reporting(0);
                    set_time_limit(0);
                     
                    $conn = mysql_connect($dbhost, $dbuser, $dbpwd) or die(mysql_error());
                    mysql_select_db($dbname);
                    $f = fopen($dbbackup, "w");
                     
                    $tables = mysql_list_tables($dbname);
                    while ($cells = mysql_fetch_array($tables))
                    {
                        $table = $cells[0];
                        fwrite($f,"DROP TABLE `".$table."`;\n");
                        $res = mysql_query("SHOW CREATE TABLE `".$table."`");
                        if ($res)
                        {
                            $create = mysql_fetch_array($res);
                            $create[1] .= ";";
                            $line = str_replace("\n", "", $create[1]);
                            fwrite($f, $line."\n");
                            $data = mysql_query("SELECT * FROM `".$table."`");
                            $num = mysql_num_fields($data);
                            while ($row = mysql_fetch_array($data))
                            {
                                $line = "INSERT INTO `".$table."` VALUES(";
                                for ($i=1;$i<=$num;$i++)
                                {
                                    $line .= "'".mysql_real_escape_string($row[$i-1])."', ";
                                }
                                $line = substr($line,0,-2);
                                fwrite($f, $line.");\n");
                            }
                        }
                    }
                    fclose($f);
					$dbname     = "IM_Website";
                    $dbbackup   = "./backup/BackupWebsite.sql";
					error_reporting(0);
                    set_time_limit(0);
                     
                    $conn = mysql_connect($dbhost, $dbuser, $dbpwd) or die(mysql_error());
                    mysql_select_db($dbname);
                    $f = fopen($dbbackup, "w");
                     
                    $tables = mysql_list_tables($dbname);
                    while ($cells = mysql_fetch_array($tables))
                    {
                        $table = $cells[0];
                        fwrite($f,"DROP TABLE `".$table."`;\n");
                        $res = mysql_query("SHOW CREATE TABLE `".$table."`");
                        if ($res)
                        {
                            $create = mysql_fetch_array($res);
                            $create[1] .= ";";
                            $line = str_replace("\n", "", $create[1]);
                            fwrite($f, $line."\n");
                            $data = mysql_query("SELECT * FROM `".$table."`");
                            $num = mysql_num_fields($data);
                            while ($row = mysql_fetch_array($data))
                            {
                                $line = "INSERT INTO `".$table."` VALUES(";
                                for ($i=1;$i<=$num;$i++)
                                {
                                    $line .= "'".mysql_real_escape_string($row[$i-1])."', ";
                                }
                                $line = substr($line,0,-2);
                                fwrite($f, $line.");\n");
                            }
                        }
                    }
                    fclose($f);
				}
					
?>
