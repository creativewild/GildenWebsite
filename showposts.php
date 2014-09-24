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
<!--
function insert(aTag, eTag)
{
	var input = document.forms['formular'].elements['message'];
	input.focus();
	/* f?r Internet Explorer */
	if(typeof document.selection != 'undefined')
	{
		/* Einf?gen des Formatierungscodes */
		var range = document.selection.createRange();
		var insText = range.text;
		range.text = aTag + insText + eTag;
		/* Anpassen der Cursorposition */
		range = document.selection.createRange();
		if (insText.length == 0)
		{
			range.move('character', -eTag.length);
		}
		else
		{
			range.moveStart('character', aTag.length + insText.length + eTag.length);
		}
		range.select();
	}
	/* f?r neuere auf Gecko basierende Browser */
	else if(typeof input.selectionStart != 'undefined')
	{
		/* Einf?gen des Formatierungscodes */
		var start = input.selectionStart;
		var end = input.selectionEnd;
		var insText = input.value.substring(start, end);
		input.value = input.value.substr(0, start) + aTag + insText + eTag + input.value.substr(end);
		/* Anpassen der Cursorposition */
		var pos;
		if (insText.length == 0)
		{
			pos = start + aTag.length;
		}
		else
		{
			pos = start + aTag.length + insText.length + eTag.length;
		}
		input.selectionStart = pos;
		input.selectionEnd = pos;
		}
		/* f?r die ?brigen Browser */
		else
		{
		/* Abfrage der Einf?geposition */
		var pos;
		var re = new RegExp('^[0-9]{0,3}$');
		while(!re.test(pos))
		{
			pos = prompt("Einf?gen an Position (0.." + input.value.length + "):", "0");
		}
		if(pos > input.value.length)
		{
			pos = input.value.length;
		}
		/* Einf?gen des Formatierungscodes */
		var insText = prompt("Bitte geben Sie den zu formatierenden Text ein:");
		input.value = input.value.substr(0, pos) + aTag + insText + eTag + input.value.substr(pos);
	}
}
//-->
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
							$fid = checkinput(trim($_GET['fid'])); // ForenID aus URL

						  $get_name = 'SELECT `name` FROM `forum_categories` WHERE `ID` = '.$fid.' && `active` = 1'; //SQL-Query: Name der des Forums auslesen
						  $name = $db->query($get_name);
							$f_name = $name->fetch_assoc();
							
							if($f_name) { // Wenn keine Fehler aufgetreten sind
									$get_thread = 'SELECT `topic` FROM `forum_threads` WHERE `ID` = '.$tid; //SQL-Query: Titel des Themas auslesen
									$thread = $db->query($get_thread);
										$t_name = $thread->fetch_assoc(); 
									echo '<p style="display: inline;margin-left:40px;"><a href="overview.php">Forum</a> &raquo; <a href="showthreads.php?fid='.$fid.'">'.$f_name['name'].'</a> &raquo; <a href="showposts.php?fid='.$fid.'&amp;tid='.$tid.'">'.$t_name['topic'].'</a>  </p> <br /><br />';
								$start = $seite * $eintraege_pro_seite - $eintraege_pro_seite;  
								$sql = 'SELECT * FROM `forum_posts` WHERE `fid` = '.$fid.' && tid = '.$tid.' ORDER BY `ID` ASC  LIMIT '.$start.' , '.$eintraege_pro_seite; 
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
                                        <?php
										if ($_SESSION['User_ID']==$row['User_ID'])
											echo '<a href="updatepost.php?ID='.$row['ID'].'&amp;fid='.$fid.'&amp;tid='.$tid.'"><img src="./img/site/Forum_Beitrag_bearbeiten.png" alt="" style=" width: 100px; height: auto; margin-top:10px; margin-left: 30px;" /></a>';
										 ?>
                                        </td>
										<td valign="top"><p style="padding-left: 5px; width: 780px; font-weight: bold; font-family: serif; text-align: left; "><?php echo nl2br($row['text']);?></p></td>
										<td>
										
										</td>
									</tr>
								</table>
								<hr style="margin-left: 40px; width:1100px;" />
								<?php
									}
									$sql = 'SELECT ID FROM `forum_posts` WHERE `fid` = '.$fid.' && tid = '.$tid.' ORDER BY `ID` DESC';
									$res = $db->query($sql);
									$row = $res->fetch_assoc();
									$get_anwesend = 'SELECT Thread_ID FROM `forum_gelesen` WHERE Kategorie_ID = '.$fid.' && Forum_ID = '.$tid.' && User_ID = '.$_SESSION['User_ID'].' ORDER BY Thread_ID DESC';
									$anwesend = $db->query($get_anwesend);
									$f_anwesend = $anwesend->fetch_assoc();
									if (($row['ID'] != $f_anwesend['Thread_ID'])){
										$set_anwesend = 'INSERT INTO `forum_gelesen` (Forum_ID, Thread_ID, Kategorie_ID, User_ID)
											    VALUES
											    (\''.$tid.'\', \''.$row['ID'].'\', \''.$fid.'\',  \''.$_SESSION['User_ID'].'\')';
										$insert=$db->query($set_anwesend);
										if ($insert)
											$fehler='io';
										else
											$fehler='dumm';
									}
									$sql = 'SELECT * FROM `forum_posts` WHERE `fid` = '.$fid.' && tid = '.$tid.' ORDER BY `ID`  LIMIT 0, 10000'; 
									$res = $db->query($sql);
																
									$Zeilen = array();
									while($row = $res->fetch_assoc())
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
										  echo '<a href="./showposts.php?seite='.$b.'&amp;fid='.$fid.'&amp;tid='.$tid.'"> '.$b.'</a>';
										  }
									   }
									echo "</div>";
					
									$thread_stat = 'SELECT `closed`, `topic` FROM `forum_threads` WHERE `ID` = '.$tid.''; //SQL-Query: Status und Titel des Themas
										  $stat = $db->query($thread_stat);
										  $stats = $stat->fetch_assoc();
												
											if($stats['closed'] == 0) { // Falls Thema nicht geschlossen
										  ?>	
											<hr style="margin-left: 40px; width:1100px;" />
												<form id="formular" action="answer.php?tid=<?php echo $tid; ?>&amp;fid=<?php echo $fid; ?>" method="post" style="margin-left: 40px; width:665px;">
													<p><strong>Titel:</strong><br /> <input type="text" name="title" value="Re: <?php echo $stats['topic']; ?>"  size="30"/></p>
													<p><strong> Beitrag: </strong></p>
													<p><textarea name="message" rows="10" cols="60"></textarea></p>
													<div><input type="button" value="" onclick="insert('[b]', '[/b]')" class="fett_button" />
													<input type="button" value="" onclick="insert('[u]', '[/u]')" class="unterstrichen_button" />
													<input type="button" value="" onclick="insert('[url]', '[/url]')" class="url_button" />
													<input type="button" value="" onclick="insert('[quote]', '[/quote]')" class="quote_button" />
													<input type="button" value="IMAGE" onclick="insert('[img]', '[/img]')" class="img_button" />
													<input type="button" value="" onclick="insert('[color=#800000]', '[/color]')" class="rot_button" />
													<input type="button" value="" onclick="insert('[color=#0000FF]', '[/color]')" class="blau_button" />
													<input type="button" value="" onclick="insert('[color=#005E00]', '[/color]')" class="gruen_button" />
													<input type="button" value="" onclick="insert('[color=#FFCC00]', '[/color]')" class="gelb_button" /></div>	
													<p><input type="hidden" name="tid" value="<?php echo $tid; ?>" /></p>
													<p><input type="hidden" name="fid" value="<?php echo $fid; ?>" /></p>
													<p><input type="submit" name="postit" value="Antworten" /></p>
												</form>
												<div><h4 style="margin-left: 40px; width:665px;">Bei der Eingabe von TAG?s, werden diese unbrauchbar gemacht.</h4></div>
											<?php
											} 
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