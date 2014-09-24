<?php
  /****************************
   *Einbindung fremder Dateien*
   ****************************/
    require_once "./src/my_funcs.inc";
	include "./src/dbadmin.inc";
	include "./src/db.inc";
    include "./src/print_html.inc";

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
	$db = new Datenbank();
	$Status = $db->Get_Status($_SESSION['User_ID']);
  
  /***************************
   *Beginn des Hauptprogramms*
   ***************************/
   $timestamp = time();
   $db->Useronline($_SESSION['User_ID'], $timestamp);
	//Filter
   
	if(!isset($_GET["seite"]))
	  $seite = 1;
    else
      $seite = $_GET["seite"];

    $eintraege_pro_seite = 4;
    $count = 0;
    $count_max = 3;

	if(isset($_POST['Absenden']))
	{
		if ($_POST['vid_pfad'] != "")
			$db->INSERT_Movie($_POST['vid_pfad']);
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Imperial-March - Movies</title>
<link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Wallpoet" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Graduate" rel="stylesheet" type="text/css"/>
<link href="./style.css" rel="stylesheet" type="text/css" media="screen" />
		<script type="text/javascript">
		$(function() { 
		    $('a[href^=http]').click( function() { 
		        window.open(this.href); 
		        return false; 
		    }); 
		});  
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
             <li><a href="./overview.php">Forum</a></li>
             <li><a href="./raidplaner.php">Raidplaner</a></li>
			 <li><a href="#">News</a>
				<ul>
					<li><a href="./News.php">News</a></li>
					<li><a href="./Gildenregeln.php">Gildenregeln</a></li>
				</ul>
			</li>

			 <li><a href="./Bewerbungen.php">Bewerbung</a></li>
			 <li class="current_page_item"><a href="#">Media</a>
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
	<div id="pagepictures">
		<div id="page-bgtop">
			<div id="page-bgbtm">
				<div id="content_movies">
					<div class="post">
						<div id = "Movies">
							<?php
							$start = $seite * $eintraege_pro_seite - $eintraege_pro_seite;  									
						    $rows = Allemovies($start,$eintraege_pro_seite, $dbconn);
							foreach($rows as $row)
							{
							$youtube = $row['PfadVideo'];
							echo '<div class="moviebox">
								<iframe width="420" height="345" src="//www.youtube.com/embed/'.$youtube.'" frameborder="0"></iframe>
							</div>';
							}
							?>
						</div>
					</div>
					<div id = "clear"></div>
					<?php	
						$menge = Anzahlmovies($dbconn);			
						$wieviel_seiten = $menge / $eintraege_pro_seite;
						echo "<div id='seitenanzahl'>";
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
							  echo '<a href="./Movies.php?seite='.$b.'">'.$b.'</a>';
							  }
						   }
						echo "</div>";
					?>
					<div id="Upload">
					<form action="Movies.php" method="post" enctype="multipart/form-data">

						<div id="bild_beschreibung">
							<h4 class="bild_hochladen">Anleitung:<br />
													Um ein Video von YouTube zu verlinken ist es wichtig nur den hinteren Teil des<br />
													Link's zu verwenden.<br /><br />
													Beispiel:<br />
													YouTube Link: http://www.youtube.com/watch?v=RJuFVtqoU7M<br />
													Hier darf dann nur folgender Teil gespeichert werden: RJuFVtqoU7M</h4>
						</div>
						<div id = "bild_bestaetigen">	
							<h4 class="bild_hochladen">Video speichern:</h4>
						</div>
						<div id="bild_auswaehlen">
							<input type="text" id="vid_pfad" name="vid_pfad" />
						</div>
						<div>
							<input type="submit" name="Absenden" value="Absenden" id="Absenden"/>	
						</div>
					</form>	

					</div>
					<div style="clear: both;">&nbsp;</div>
				</div>
				<div style="clear: both;"></div>
			</div>
		</div>
	</div>

</div>
<div id="footer"><?php echo $create=print_create();?></div>

</body>
</html>