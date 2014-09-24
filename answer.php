<?php
	if(extension_loaded("zlib") AND strstr($_SERVER["HTTP_ACCEPT_ENCODING"],"gzip"))
		@ob_start("ob_gzhandler");

  /****************************
   *Einbindung fremder Dateien*
   ****************************/
    require_once "./src/my_funcs.inc";
    include "./src/db.inc";


  /***********
   *Debugging*
   ***********/
    debugging( false);

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
	$Datenbank = new Datenbank();
	$Status = $Datenbank->Get_Status($_SESSION['User_ID']); 
	$username = $Datenbank->Get_User_Forum($_SESSION['User_ID']);
	$db=null;
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
						<?php
							include './Forum/config.php'; // Datei f?r DB-Verbindung laden
							include './Forum/functions.php'; // Datei mit Funktionen laden
														
							/* ?berpr?fe ?bergebene Angaben */
							$title = checkinput(trim($_POST['title']));
							$message = $_POST['message'];
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
							$fid = checkinput(trim($_POST['fid']));
							$tid = checkinput(trim($_POST['tid']));
						  

						 $thread_stat = 'SELECT closed
										 FROM forum_threads
										 WHERE `ID` = '.$tid.''; //SQL-Query: Status des Threads
								  $stat = $db->query($thread_stat);
								  $stats = $stat->fetch_assoc();
								
								if(isset($_SESSION['lastpost'])) { // Falls letzer Beitrag in Sitzung gespeichert
								  $diff = $_SESSION['lastpost'] + 10; // $diff = Zeitpunkt von Abschicken des Beitrags + 10 Sekunden
								} else { // Falls kein letzer Beitrag gespeichert wurde
								  $diff = false;
								}    
								
						 if($stats['closed'] == 0) { // Falls Thread nicht geschlossen
							if($diff < time() || $diff == false) { // Falls 60 Sekunden zwischen 2 abgeschickten Beitr?gen liegen, oder kein Beitrag in der Sitzung gespeichert ist
								if(is_numeric($tid)) { // Falls $tid numerisch ist
									if(is_numeric($fid)) { // Falls $fid numerisch ist
										if(!empty($message)) { // Falls Nachricht eingegeben wurde
													 $sql = 'INSERT INTO 
																		`forum_posts` 
																	 (tid, fid, username, User_ID, topic, text)
																	  VALUES
																	 (\''.$tid.'\', \''.$fid.'\', \''.$username.'\', \''.$_SESSION['User_ID'].'\',  \''.$title.'\', \''.$message.'\')';
													 					  
													 $insert = $db->query($sql);
													 $timestamp = date("Y-m-d H:i:s", time());
													 $sql = "UPDATE `forum_threads` SET `created`='".$timestamp."' where `ID` = ".$tid;
													 $update =  $db->query($sql);
													 echo $db->error.'<br />';
													  
														if($insert) {
														  $_SESSION['lastpost'] = time();
														  echo '<meta http-equiv="refresh" content="1; URL=showposts.php?fid='.$fid.'&amp;tid='.$tid.'">';
														  
														} else {
														  echo 'Es ist ein Fehler beim Erstellen Ihrer Antwort aufgetreten, bitte versuchen Sie es sp&auml;ter erneut und sollte sich dieses Problem nicht beheben, so melden Sie dies bitte &uuml;ber das <a href="index.php?site=contact">Kontaktformular</a>';
														}													
																			
										} else {
											echo 'Bitte geben Sie eine Nachricht ein.';
										}
								
									} else {
										echo 'Es wurde keine ForenID &uuml;bergeben';
									}
							  
								} else {
									echo 'Es wurde keine ThemenID &uuml;bergeben.';
								}
							
							 
							} else {
								echo 'Seit Ihrem letzen Post ist weniger als eine Minute vergangen.';
							}
						 
						 } else {
							echo 'Dieses Thema wurde bereits geschlossen.';
						 }
									  
						?>
			</div>
		</div> 
	</div>
</div>

</body>
</html>