<?php
  /****************************
   *Einbindung fremder Dateien*
   ****************************/
    require_once "./src/my_funcs.inc";
    include "./src/db.inc";


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
	$datenbank = new Datenbank();
	$Status = $datenbank->Get_Status($_SESSION['User_ID']); 
	$Beitrag="";
	$Anzahl = 0;
  /***************************
   *Beginn des Hauptprogramms*
   ***************************/
   $timestamp = time();
   $datenbank->Useronline($_SESSION['User_ID'], $timestamp);
	if(!isset($_GET["seite"]))
	  $seite = 1;
    else
      $seite = $_GET["seite"];

    $eintraege_pro_seite = 10;
    $count = 0;
    $count_max = 3;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Imperial-March</title>
<link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Wallpoet" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Graduate" rel="stylesheet" type="text/css"/>
<link href="./style.css" rel="stylesheet" type="text/css" media="screen" />
<link href="./forum.css" rel="stylesheet" type="text/css" media="screen" />
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
			 <li><a href="./login.php">Home</a></li>
             <li class="current_page_item"><a href="./overview.php">Forum</a></li>
             <li><a href="./raidplaner.php">Raidplaner</a></li>
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
				<div id="contentforum">
					<div class="post">
						<div class="thread">
						<?php
							include './Forum/config.php'; // Datei für DB-Verbindung laden
							include './Forum/functions.php'; // Datei mit Funktionen laden
							
							  $fid = checkinput(trim($_GET['fid'])); // Überprüft die übergebene Forenid und löscht überflüssige Leerzeichen
							  $get_name = 'SELECT `name` FROM `forum_categories` WHERE `ID` = '.$fid.''; // SQL-Query zum Auslesen des Namens des Forums
							  $name = $db->query($get_name);
								$f_name = $name->fetch_assoc();
								echo '<p style="display: inline;"><a href="overview.php">Forum</a> &raquo; <a href="showthreads.php?fid='.$fid.'">'.$f_name['name'].'</a> </p>'; // Breadcrumb
								echo '<p style="float: right;"><a href="createthread.php?fid='.$fid.'">Thema erstellen</a></p>'; // Thema erstellen-Link
							  $start = $seite * $eintraege_pro_seite - $eintraege_pro_seite;  
							  $sql = 'SELECT * FROM `forum_threads` WHERE `fid` = '.$fid.' ORDER BY  `Sticky` DESC, `created` DESC   LIMIT '.$start.' , '.$eintraege_pro_seite; // SQL-Query zum Auslesen der erstellen Themen
							  $res = $db->query($sql);
							  

							if($res->num_rows) { // Falls Themen vorhanden sind
							  echo '<table style="border:0; width:100%;" cellpadding="0" cellspacing="0" rules="rows" >
										<tr>
											<th style="background-color:#AA0000; width:30px;"></th>
											<th style="background-color:#AA0000; align:left;">&nbsp;&nbsp;Themen</th>
											<th style="background-color:#AA0000; width:30%">Anzahl Beiträge</th>
											<th style="background-color:#AA0000; width:30%">Letzter Beitrag</th>
										</tr>
									';
							  while(($row = $res->fetch_assoc()) != false) {
								$get_anwesend = 'SELECT Thread_ID FROM `forum_gelesen` WHERE Kategorie_ID = '.$fid.' && Forum_ID = '.$row['ID'].' && User_ID = '.$_SESSION['User_ID'].' ORDER BY Thread_ID DESC';
								$anwesend = $db->query($get_anwesend);
								$f_anwesend = $anwesend->fetch_assoc();
								$get_thread = 'SELECT ID FROM forum_posts WHERE tid = '.$row['ID'].' && fid = '.$fid.' ORDER BY ID DESC';
								$thread = $db->query($get_thread);
								$f_thread= $thread->fetch_assoc();
								if ($row['Sticky'])
     							{
									if($f_anwesend['Thread_ID'] == $f_thread['ID']) 
									{
										 $Beitrag=' margin-left: 8px; margin-right: 10px; margin-left: 5px;" src="./img/Site/sticky_gelesen.png" width="48" height="35"';
									}
									else
									{
										 $Beitrag=' margin-left: 8px; margin-right: 10px;" src="./img/Site/sticky_ungelesen.png" width="40" height="32"';
									};
								}
								else
								{
									if($f_anwesend['Thread_ID'] == $f_thread['ID']) 
									{
										 $Beitrag='" src="./img/Site/ForenLogoKeinNeuerBeitrag.png" width="60" height="35"';
									}
									else
									{
										 $Beitrag='" src="./img/Site/ForenLogoNeuerBeitrag.png" width="60" height="35"';
									};
																}
								$Anzahl = 'SELECT * FROM `forum_posts` WHERE `tid` = '.$row['ID'];
								$resource = $db->query($Anzahl);

								if($resource->num_rows)
								{
									$Zaehler = "";
								    while(($leer = $resource->fetch_assoc())!= false)
									{
										$Zaehler++;
									}
								}
								$last_post_q = 'SELECT * FROM `forum_posts` WHERE `tid` = '.$row['ID'].' ORDER BY `ID` DESC LIMIT 1'; // SQL-Query zum Auslesen der Daten des letzen Beitrags eines Themas
								$l_p_res = $db->query($last_post_q);
								$last_post = $l_p_res->fetch_assoc();
								$username = $datenbank->Get_Username($last_post['User_ID']);
								/* Infos zum letzen Beitrag ausgeben: am TT.MM.JJJJ um mm:hh Uhr von USERNAME */
									echo '
										<tr>
											<td></td>
											<td>
												<img style="float: left;'.$Beitrag.' alt="altes Thema" />
												<a href="showposts.php?fid='.$row['fid'].'&amp;tid='.$row['ID'].'" style="font-size: 14px; font-weight: bold; font-family: Verdana,sans-serif; color: #ffffff; text-decoration: none;">'.$row['topic'].'</a>
											</td>
											<td>
											<div style="margin-left: 150px; font-size: 14px; font-weight: bold; font-family: Verdana,sans-serif; color: #ffffff; text-decoration: none;">';echo $Zaehler;echo'</div>
											
											</td>
											<td>
												am '.convertdate($last_post['created']).' <br /> von '.$username.'
											</td>											
										</tr>';
							  }
								echo '</table>';
							} 
							else
							{ // Falls keine Themen vorhanden
								echo '<br /><br />Keine Themen vorhanden';
							}

							$sql = 'SELECT * FROM `forum_threads` WHERE `fid` = '.$fid.' ORDER BY `created` DESC   LIMIT 0 , 10000';
							$res = $db->query($sql);
																
							$Zeilen = array();
							while(($row = $res->fetch_assoc())!= false)
							$Zeilen[] = $row;						
							$i=0;
							foreach($Zeilen AS $row)
							$i++;	
							$menge = $i;
							$wieviel_seiten = $menge / $eintraege_pro_seite;
							echo "<div id='postseitenanzahl'>";
							echo "<b>Seite:</b> ";
							for($a=0; $a < $wieviel_seiten; $a++)
							{
							   $b = $a + 1;
							   if($seite == $b)
								  {
									  echo "  <b>$b</b> ";
								  }
								  else
								  {
									  echo '<a href="./showthreads.php?seite='.$b.'&amp;fid='.$fid.'"> '.$b.'</a>';
								  }
						    }
							echo "</div>";
						?>
						</div>
					</div>
					<div style="clear: both;">&nbsp;</div>
				</div>
				<div style="clear: both;"></div>
	</div>

</div>

</body>
</html>