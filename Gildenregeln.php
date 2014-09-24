<?php
  /****************************
   *Einbindung fremder Dateien*
   ****************************/
    require_once "./src/my_funcs.inc";
    include "./src/db.inc";
	include "./src/dbadmin.inc";
    include "./src/print_html.inc";

  /***********
   *Debugging*
   ***********/
    debugging( false );

  /********************
   *Session und Cookie*
   ********************/
    init_session();

  /***********
   *Variablen*
   ***********/
	$error="";
	$table="";
	$db = new Datenbank();
	$dbconn = Connect_DB();
	$Status = $db->Get_Status($_SESSION['User_ID']);
  
  /***************************
   *Beginn des Hauptprogramms*
   ***************************/
	$timestamp = time();
	$db->Useronline($_SESSION['User_ID'], $timestamp);
	$SeitenInformationarray = GetSeitenInformation($dbconn);
	$Raidgruppenarray = GetRaidgruppen($dbconn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Imperial-March - Regeln</title>
<link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Wallpoet" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Graduate" rel="stylesheet" type="text/css"/>
<link href="./style.css" rel="stylesheet" type="text/css" media="screen" />
		<script type="text/javascript">
			function showHideLayer(id){
				e = document.getElementById(id);
				if(e.style.display=="block"){
					e.style.display = "none";
				} else {
					e.style.display = "block";
				}
			}
		</script>
		<script type="text/javascript">
		function FensterOeffnen (Adresse) {
		  MeinFenster = window.open(Adresse, "Zweitfenster", "scrollbars=yes");
		  MeinFenster.focus();
		}  
		</script> 
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
			<?php
			if ($Status != "")
			{
			?>
			 <li><a href="./login.php">Home</a></li>
             <li><a href="./overview.php">Forum</a></li>
             <li><a href="./raidplaner.php">Raidplaner</a></li>
			 <li class="current_page_item"><a href="#">News</a>
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

			}
			else
			{
			?>
			<li><a href="./Index.php">Home</a></li>
			<li class="current_page_item"><a href="./Gildenregeln.php">Gildenregeln</a></li>
			<li><a href="#">Bewerbung</a>
				<ul>
					<li><a href="./Bewerbung.php">Neu</a></li>
					<li><a href="./Bewerbungindex.php">Offen</a></li>
				</ul>
			</li>
	        <li><a href="./Registrieren.php">Registrieren</a></li>
			<?php
			}
			?>
		</ul>
	</div>
	<div id="page">
		<div id="page-bgtop">
			<div id="page-bgbtm">
				<div id="content_regeln">
					<div class="post">
						<div id="Regel">
							<div id = "AGB_Head" class="title"><img id="Pic_Head" src="./img/site/AGB.png" alt="" /></div>
								<div class = "Regeln">
									<a href="alternativerLink" onclick="showHideLayer('Raid');return(false)"><img id="Pic_Raid" src="./img/site/leer.png" alt="" /></a>
								</div>
								<div id="Raid" style="display:none;">
									<br /><br />
									<?php
									ForEach($Raidgruppenarray as $Raidgruppen)
									{
										if ($Raidgruppen['ID']==1)
										{
											echo '<table id="Raid1">
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
														<td>'.$Raidgruppen['Tag1'].'</td>
														<td></td>
														<td>'.$Raidgruppen['Uhrzeit1'].'</td>
													</tr>
													<tr>
														<td>'.$Raidgruppen['Tag2'].'</td>
														<td></td>
														<td>'.$Raidgruppen['Uhrzeit2'].'</td>
													</tr>
													<tr class = "Tank">
														<td>Tank:</td>
														<td></td>
														<td>'.$Raidgruppen['Tank1'].'</td>
													</tr>
													<tr class = "Tank">
														<td>Tank:</td>
														<td></td>
														<td>'.$Raidgruppen['Tank2'].'</td>
													</tr>
													<tr class = "Heal">
														<td>Heal:</td>
														<td></td>
														<td>'.$Raidgruppen['Heal1'].'</td>
													</tr>
													<tr class = "Heal">
														<td>Heal:</td>
														<td></td>
														<td>'.$Raidgruppen['Heal2'].'</td>
													</tr>
													<tr class = "DD">
														<td>DD</td>
														<td></td>
														<td>'.$Raidgruppen['DD1'].'</td>
													</tr>
													<tr  class = "DD">
														<td>DD</td>
														<td></td>
														<td>'.$Raidgruppen['DD2'].'</td>
													</tr>
													<tr class = "DD">
														<td>DD</td>
														<td></td>
														<td>'.$Raidgruppen['DD3'].'</td>
													</tr>
													<tr  class = "DD">
														<td>DD</td>
														<td></td>
														<td>'.$Raidgruppen['DD4'].'</td>
													</tr>
												  </table>';
										}
									}
									ForEach($Raidgruppenarray as $Raidgruppen)
									{
										if ($Raidgruppen['ID']==2)
										{
											echo '<table id="Raid2">
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
														<td>'.$Raidgruppen['Tag1'].'</td>
														<td></td>
														<td>'.$Raidgruppen['Uhrzeit1'].'</td>
													</tr>
													<tr>
														<td>'.$Raidgruppen['Tag2'].'</td>
														<td></td>
														<td>'.$Raidgruppen['Uhrzeit2'].'</td>
													</tr>
													<tr class = "Tank">
														<td>Tank:</td>
														<td></td>
														<td>'.$Raidgruppen['Tank1'].'</td>
													</tr>
													<tr class = "Tank">
														<td>Tank:</td>
														<td></td>
														<td>'.$Raidgruppen['Tank2'].'</td>
													</tr>
													<tr class = "Heal">
														<td>Heal:</td>
														<td></td>
														<td>'.$Raidgruppen['Heal1'].'</td>
													</tr>
													<tr class = "Heal">
														<td>Heal:</td>
														<td></td>
														<td>'.$Raidgruppen['Heal2'].'</td>
													</tr>
													<tr class = "DD">
														<td>DD</td>
														<td></td>
														<td>'.$Raidgruppen['DD1'].'</td>
													</tr>
													<tr  class = "DD">
														<td>DD</td>
														<td></td>
														<td>'.$Raidgruppen['DD2'].'</td>
													</tr>
													<tr class = "DD">
														<td>DD</td>
														<td></td>
														<td>'.$Raidgruppen['DD3'].'</td>
													</tr>
													<tr  class = "DD">
														<td>DD</td>
														<td></td>
														<td>'.$Raidgruppen['DD4'].'</td>
													</tr>
												  </table>';
										}
									}
									ForEach($SeitenInformationarray as $SeitenInformation )
									{
										echo $SeitenInformation['Raidgruppen'];
									}
									?>
									
								</div>
								<div class = "Regeln">
								<a href="alternativerLink" onclick="showHideLayer('Kennlernen');return(false)"><img id="Pic_Kennlernen" src="./img/site/leer.png" alt="" /></a>
								</div>
								<div id="Kennlernen" style="display:none;">
								<?php ForEach($SeitenInformationarray as $SeitenInformation )
								{
									echo $SeitenInformation['TS3Gespraech'];
								}?>
								</div>
								<div class = "Regeln">
									<a href="alternativerLink" onclick="showHideLayer('Anwesenheit');return(false)"><img id="Pic_Anwesenheit" src="./img/site/leer.png" alt="" /></a>
								</div>
								<div id="Anwesenheit" style="display:none;">
								<?php ForEach($SeitenInformationarray as $SeitenInformation )
								{
									echo $SeitenInformation['ForumAnwesenheit'];
								}?>		
								</div>
								<div class = "Regeln">
									<a href="alternativerLink" onclick="showHideLayer('TS');return(false)"><img id="Pic_TS" src="./img/site/leer.png" alt="" /></a>
								</div>
								<div id="TS" style="display:none;">
								<?php ForEach($SeitenInformationarray as $SeitenInformation )
								{
									echo $SeitenInformation['Teamspeak3'];
								}?>		
								</div>
								<div class = "Regeln">
									<a href="alternativerLink" onclick="showHideLayer('Sozial');return(false)"><img  id="Pic_Sozial" src="./img/site/leer.png" alt="" /></a>
								</div>
								<div id="Sozial" style="display:none;">
								<?php ForEach($SeitenInformationarray as $SeitenInformation )
								{
									echo $SeitenInformation['Sozialverhalten'];
								}?>		
								</div>
																<div class = "Regeln">
								<a href="alternativerLink" onclick="showHideLayer('Loot');return(false)"><img id="Pic_Loot" src="./img/site/leer.png" alt="" /></a>
								</div>
								<div id="Loot" style="display:none;">
								<?php ForEach($SeitenInformationarray as $SeitenInformation )
								{
									echo $SeitenInformation['Loot'];
								}?>		
								</div>
								<div class = "Regeln">
									<a href="alternativerLink" onclick="showHideLayer('Ausschluss');return(false)"><img id="Pic_Ausschluss" src="./img/site/leer.png" alt="" /></a>
								</div>
								<div id="Ausschluss" style="display:none;">
								<?php ForEach($SeitenInformationarray as $SeitenInformation )
								{
									echo $SeitenInformation['Ausschluss'];
								}?>		
								</div>
						  </div>
					</div>
					<div style="clear: both;">&nbsp;</div>
				</div>
				<div style="clear: both;"></div>
			</div>
		</div>
	</div>

</div>
</body>
</html> 
