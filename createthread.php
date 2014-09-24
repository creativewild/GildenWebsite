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
	$username = $datenbank->Get_User_Forum($_SESSION['User_ID']);
	$db = null;
  /***************************
   *Beginn des Hauptprogramms*
   ***************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Imperial-March - Forum</title>
<link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Wallpoet" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Graduate" rel="stylesheet" type="text/css"/>
<link href="./style.css" rel="stylesheet" type="text/css" media="screen" />
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
						<?php
						if(!empty($_SESSION['User_ID'])){
							include './Forum/config.php'; // Datei f?r DB-Verbindung laden
							include './Forum/functions.php'; // Datei mit Funktionen laden
							
							$fid = checkinput(trim($_GET['fid'])); // ?berpr?fen der ?bergebenen Forenid
							
							if(!empty($fid)) { // Wenn $fid nicht leer ist
									$cat_name_q = 'SELECT `name` FROM `forum_categories` WHERE `ID` = '.$fid.' && `type` = 1'; //  Name des Forums auslesen
										$t_res = $db->query($cat_name_q);
										$t_name = $t_res->fetch_assoc();
									echo '<p style="display: inline;margin-left: 40px; width:665px;"><a href="overview.php">Forum</a> &raquo; <a href="showthreads.php?fid='.$fid.'">'.$t_name['name'].'</a> &raquo; <a href="createthread.php?fid='.$fid.'">Thema erstellen</a>  </p> <br /><br />';
										   
								if(isset($_POST['create'])) { // Wenn Formular abgeschickt
								  
									$title = checkinput(trim($_POST['title'])); // Titel aus Formular
									$message = checkinput(trim($_POST['message']));
									$message = preg_replace('#\[b\](.*?)\[/b\]#si', '<span style="font-weight: bold;">\1</span>', $message);
									$message = preg_replace('#\[color=(.*?)\](.*?)\[/color\]#si', '<span style="color:\1;">\2</span>', $message);
									$message = preg_replace('#\[u\](.*?)\[/u\]#si', '<span style="text-decoration: underline;">\1</span>', $message);
									$message = preg_replace('#\[url\](.*)\[/url\]#isU', "<a href=\"http://$1\" >$1</a>", $message);
									$message = preg_replace('#\[img\](.*)\[/img\]#isU', "<img src=\"$1\" alt=\"\" style=\"width:850px; height:auto;\" />", $message);
									$width = 700; 
									while(preg_match('/\[quote\](.*)\[\/quote\]/Uis', $message))
									{ 
										$width -= 10; 
										$quote_start = "<br><b style=\"margin-left: 45px;\">Zitat:</b>\n". 
										"<div style=\"border:solid 1px black; margin-left:5px; background-color:grey; color:black; margin:0px auto; width:".$width."px\">\n"; 
										$quote_end = "</div>"; 
										$message = preg_replace("/\[quote](.*)\[\/quote\]/Uis", $quote_start."\\1".$quote_end, $message); 
									}
									$fid = checkinput(trim($_POST['fid'])); // ForenID aus Formular (versteckt)
									
									
										$cat_stat = 'SELECT `active`, `name` FROM `forum_categories` WHERE `ID` = '.$fid.''; //SQL-Query: Status und Name des Forums auslesen
												  $stat = $db->query($cat_stat);
													if($stat->num_rows) { // Falls Forum existiert
													   $stats = $stat->fetch_assoc();
													} else { // Falls Forum nicht existiert
														die('Dieses Forum existiert nicht.');
													}
											   
												if(isset($_SESSION['lastpost'])) { // Falls Session-Eintrag mit vorkurzem geschriebenemn Beitrag existiert
												  $diff = $_SESSION['lastpost'] + 30; // Zeitpunkt des letzen Beitrags + 60 Sekunden
												} else {
												  $diff = false; // Kein Eintrag vorhanden
												}  


    									
               								if($stats['active'] == 1) { // Falls Forum nicht geschlossen/unsichtbar ist
    											if($diff < time() || $diff == false) { // Falls letzer Beitrag 60 Sekunden zur?ck liegt oder gar nicht in Sitzung gespeichert
    												if(is_numeric($fid)) { // Falls $fid numerisch ist
    													if(!empty($message)) { // Falls die ?bergebene Nachricht nicht leer ist
    														if(!empty($title)) { // Falls der ?bergebene Titel nicht leer ist
    																															 
    																 $sql2 = 'INSERT INTO 
    																					`forum_threads` 
    																				 (fid, topic)
    																				  VALUES
    																				 (\''.$fid.'\', \''.$title.'\')';   //SQL-Query zum einf?gen des Themas in die Datenbank
    																					  
    																	$insert2 = $db->query($sql2);
    																 
    																 
    																  $get_id = 'SELECT max(ID) AS max FROM forum_threads'; // Gr??te ID (ID des letzen Eintrags) der Themen auslesen
    																  $res = $db->query($get_id);
    																	$row = $res->fetch_assoc();
    																	  $tid = $row['max']; // ID des gerade angelegten Themas in $tid speichern
    																 
    																 $sql = 'INSERT INTO 
    																				 `forum_posts` 
    																				 (tid, fid, username, User_ID,  topic, text)
    																				  VALUES
    																				 (\''.$tid.'\', \''.$fid.'\', \''.$username.'\', \''.$_SESSION['User_ID'].'\', \''.$title.'\', \''.$message.'\')'; // SQL-Query zum Einf?gen des Posts 
    																					  
    																 $insert = $db->query($sql);
    																 echo $db->error.'<br />';
																
    																	if($insert) { // Falls Eintragen fehlerfrei verlaufen
    																	  $_SESSION['lastpost'] = time(); // Letze "Schreibaktion" in Session festhalten
    																	  echo '<meta http-equiv="refresh" content="0; URL=showposts.php?fid='.$fid.'&amp;tid='.$tid.'">';
    																	} else { // Bei Fehler
    																	  echo 'Es ist ein Fehler beim Erstellen Ihres Themas aufgetreten, bitte versuchen Sie es sp&auml;ter erneut.<br />
    																	  <a href="javascript:window.back()">Zur?ck</a>';
    																	}
    																													
    														} else { // Falls kein Titel angegeben
    														  echo 'Bitte geben Sie einen Titel ein.<br />
    														  <a href="javascript:window.back()">Zur?ck</a>';
    														} 
    																
    												} else { // Falls keine Nachricht eingegeben
    													echo 'Bitte geben Sie eine Nachricht ein.<br />
    													<a href="javascript:window.back()">Zur?ck</a>';
    													echo $message;
    												}
    												
    											} else { // Falls keine ForenID ?bergeben wurde
    												echo 'Es wurde keine ForenID &uuml;bergeben.<br />
    												<a href="javascript:window.back()">Zur?ck</a>';
    											}
    																   
    										} else { // Falls inerhalb einer Minute bereits gepostet wurde
    											echo 'Seit Ihrem letzen Post ist weniger als eine Minute vergangen.<br />
    											<a href="javascript:window.back()">Zur?ck</a>';
    										}
    										 
    									} else { // Falls Forum f?r neue Beitr?ge geschlossen wurde
    										echo 'Dieses Forum wurde geschlossen.<br />
    										<a href="javascript:window.back()">Zur?ck</a>';
    									}
    																	 
								} else {
							  ?>
								 <!-- Formular zum Erstellen eines Themas -->
												<form id="formular"  method="post" action="createthread.php?fid=<?php echo $fid; ?>" style="margin-left: 40px; width:665px;">
													<div><strong>Titel:</strong><br /> <input type="text" name="title" value=""  size="30" /> <br /></div>
													<div><strong> Beitrag: </strong><br /></div>
													<div><textarea name="message" rows="15" cols="78"></textarea></div>
													<div><br /></div>
													<div><input type="button" value="" onclick="insert('[b]', '[/b]')" class="fett_button" />
													<input type="button" value="" onclick="insert('[u]', '[/u]')" class="unterstrichen_button" />
													<input type="button" value="" onclick="insert('[url]', '[/url]')" class="url_button" />
													<input type="button" value="" onclick="insert('[quote]', '[/quote]')" class="quote_button" />
													<input type="button" value="IMAGE" onclick="insert('[img]', '[/img]')" class="img_button" />
													<input type="button" value="" onclick="insert('[color=#800000]', '[/color]')" class="rot_button" />
													<input type="button" value="" onclick="insert('[color=#0000FF]', '[/color]')" class="blau_button" />
													<input type="button" value="" onclick="insert('[color=#005E00]', '[/color]')" class="gruen_button" />
													<input type="button" value="" onclick="insert('[color=#FFCC00]', '[/color]')" class="gelb_button" /></div>
													<div><input type="hidden" name="fid" value="<?php echo $fid; ?>" /></div>
													<div><input type="submit" name="create" value="Thema erstellen" /></div>
												</form>
												<div><h4 style="margin-left: 40px; width:665px;">Bei der Eingabe von TAG?s, werden diese unbrauchbar gemacht.</h4></div>
							  <?php
							  }
							} else {
								echo '<strong>Es wurde keine ForenID &uuml;bergeben.</strong>';
							}
						} else {
                            echo 'Es ist keine User-ID vorhanden<br />
    						<a href="javascript:window.back()">Zur?ck</a>';
    					}
						  ?>
					</div>
					<div style="clear: both;">&nbsp;</div>
				</div>
				<div style="clear: both;"></div>
	</div>

</div>
<div id="footer"><?php echo $create=print_create();?></div>

</body>
</html>