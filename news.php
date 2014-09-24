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
	$Bildklein="";
	$Bildgross="";
	$dbconn = Connect_DB();
	$db = new Datenbank();
	$Status = $db->Get_Status($_SESSION['User_ID']);

  /***************************
   *Beginn des Hauptprogramms*
   ***************************/
   $timestamp = time();
   $db->Useronline($_SESSION['User_ID'], $timestamp);
	if(!isset($_GET["seite"]))
	  $seite = 1;
    else
      $seite = $_GET["seite"];

    $eintraege_pro_seite = 5;
    $count = 0;
    $count_max = 3;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Imperial-March - News</title>
<link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Wallpoet" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Graduate" rel="stylesheet" type="text/css"/>
<link href="./style.css" rel="stylesheet" type="text/css" media="screen" />
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
			?>
		</ul>
	</div>
	<div id="pagepictures">
		<div id="page-bgtop">
			<div id="page-bgbtm">
				<div id="content_news">
					<div class="post">
						<div id = "Picture">
						<?php
							
							$start = $seite * $eintraege_pro_seite - $eintraege_pro_seite;
							$rows = AlleNews($start, $eintraege_pro_seite, $dbconn);
							foreach($rows as $row)
							{
								$newsnews = $db->Get_news_news($row['NewsID']);
								$newsbild = $db->Get_news_bild($row['NewsID']);
								echo	'<div class="News_News_Bild"><img class="img_willkommen" src="'.$newsbild.'" alt="News" /></div>
										 <div class="News_News_News">'.nl2br($newsnews).'</div>';
							}
						?>
						</div>
					</div>
					<div id = "clear"></div>
					<?php	
						$menge = AnzahlNews($dbconn);			
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
							  echo '<a href="./News.php?seite='.$b.'">'.$b.' </a>';
							  }
						   }
						echo "</div>";
						?>
					<div style="clear: both;">&nbsp;</div>
				</div>
				<div style="clear: both;"></div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
