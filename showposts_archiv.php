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
	$anwesend="";
	$datenbank = new Datenbank();
	$Status = $datenbank->Get_Status($_SESSION['User_ID']);
	$username = $datenbank->Get_User_Forum($_SESSION['User_ID']);
	$menge = 0;
	$_SESSION['ID_POST'] = "";
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
						<div class="posts">
						<?php
							include './Forum/config.php'; // Datei f?r DB-Verbindung laden
							include './Forum/functions.php'; // Datei mit Funktionen laden
							
							$tid = checkinput(trim($_GET['tid'])); // ThemenID aus URL
							
							$get_name = 'SELECT `name` FROM `forum_categories` WHERE `ID` = 46 && `active` = 1'; //SQL-Query: Name der des Forums auslesen
						  $name = $db->query($get_name);
							$f_name = $name->fetch_assoc();
							
							if($f_name) { // Wenn keine Fehler aufgetreten sind
									$get_thread = 'SELECT `topic` FROM `forum_threads` WHERE `ID` = '.$tid; //SQL-Query: Titel des Themas auslesen
									$thread = $db->query($get_thread);
										$t_name = $thread->fetch_assoc(); 
									echo '<p style="display: inline;margin-left:40px;"><a href="overview.php">Forum</a> &raquo; <a href="showthreads.php?fid=46">'.$f_name['name'].'</a> &raquo; <a href="showposts.php?fid=46&amp;tid='.$tid.'">'.$t_name['topic'].'</a>  </p> <br /><br />';
								$start = $seite * $eintraege_pro_seite - $eintraege_pro_seite;  
								$sql = 'SELECT * FROM `forum_posts_archiv` WHERE tid = '.$tid.' ORDER BY `ID` ASC  LIMIT '.$start.' , '.$eintraege_pro_seite; 
								$res = $db->query($sql);
								
								if($res->num_rows) {
									$Zeilen = array();
									while($row = $res->fetch_assoc()) {
									$Zeilen[] = $row;
									$username = $datenbank->Get_Username($row['User_ID']);
									$bild = $datenbank->Get_Userbild($row['User_ID']); 
									?>
								<table border="0" cellpadding="0" cellspacing="0" width="1105" style="margin-left: 40px;">
									<tr>
										<td style="vertical-align: top; width:250px;"><p style="padding-left: 5px; font-weight: bold; font-family: serif;margin-top: auto; "><?php echo convertdate($row['created']); ?><br /> von <?php echo $username; ?></p><br />
                                        
                                        <?php
                                        if ($bild == "_s.png" or $bild == null )
                                        {
                                            echo '<img src="./img/site/platzhalter_troll.png" width="100" alt="" style="margin-top:-20px; margin-left: 30px;"/>';     
                                        }
                                        else
                                        {
                                            echo '<img src="'.$bild.'" width="100" alt="" style="margin-top:-20px; margin-left: 30px;"/>'; 
                                        }
                                        ?>
                                        <br />
                                       	<td valign="top"><p style="padding-left: 5px; width: 780px; font-weight: bold; font-family: serif; text-align: left; "><?php echo nl2br($row['text']);?></p></td>
										<td>
										
										</td>
									</tr>
								</table>
								<hr style="margin-left: 40px; width:1100px;" />
								<?php
									}
									$sql = 'SELECT ID FROM `forum_posts_archiv` WHERE tid = '.$tid.' ORDER BY `created` DESC';
									$res = $db->query($sql);
									$row = $res->fetch_assoc();
								}
							} else { // Falls Thema nicht existiert
						  
							echo '<strong>Dieses Thema existiert nicht (mehr).</strong>';
						  
						  }
						?> 
						</div>
					</div>

					<div style="clear: both;">&nbsp;</div>
				</div>
	</div>
</div>
</body>
</html>
<?php

?>