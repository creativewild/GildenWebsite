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
	//Filter
   
	if(!isset($_GET["seite"]))
	  $seite = 1;
    else
      $seite = $_GET["seite"];

    $eintraege_pro_seite = 9;
    $count = 0;
    $count_max = 3;

	if(isset($_POST['Absenden']))
	{
		/* === ORIGINALDATEN ================================================ */
						$orig_bild = $_FILES['Datei']['tmp_name'];
						$orig_size = getimagesize($orig_bild);
						$format=($orig_size[0]>$orig_size[1])?"h":"v"; // horizontal oder vertical?
						switch($orig_size[2])                             // Bildtyp
						{
						case 1 : $content_type = "gif"; 
								 $orig_image = ImageCreateFromGIF($orig_bild);
											 break;
						case 2 : $content_type = "jpeg"; 
								 $orig_image = ImageCreateFromJPEG($orig_bild);  	         
											 break;
						case 3 : $content_type = "png"; 
								 $orig_image = ImageCreateFromPNG($orig_bild);
											 break;			 
						case 6 : $content_type = "bmp"; 
								 $orig_image = ImageCreateFromWBMP($orig_bild);  break;
						case 7 : 
						
						default: $content_type = "unknown";
						}

		/* === NEUE DATEN =================================================== */
						$Bild_OK=FALSE;
						if ( $orig_image )
						{
							if ( $format=="h" ) // horizontales Format: Landscape
							{
								$new_width_b  = 600;
								$new_height_b = round(600*$orig_size[1]/$orig_size[0],0); //berechnen
								$new_width_s  = 200;
								$new_height_s = round(200*$orig_size[1]/$orig_size[0],0); //berechnen
							}
							else                // verticales Format: Portrait
							{
								$new_height_b = 600;
								$new_width_b  = round(600*$orig_size[0]/$orig_size[1],0); //berechnen
								$new_height_s = 200;
								$new_width_s  = round(200*$orig_size[0]/$orig_size[1],0); //berechnen
							}
							$path_s    = "./img/Gildenfoto/klein/";	
							$path_b    = "./img/Gildenfoto/gross/";

							$new_name  = time();
							$quality   = 75;
							$Bild_OK=TRUE;
						}


		/* === BILDER ERZEUGEN ================================================= */
						if ( $Bild_OK )
						{
							$new_image_b=ImageCreateTrueColor($new_width_b, $new_height_b); 
							$new_image_s=ImageCreateTrueColor($new_width_s, $new_height_s);
							 
							ImageCopyResized($new_image_b,$orig_image,
															 0,0,0,0,
															 $new_width_b, $new_height_b,
															 $orig_size[0],$orig_size[1]);	 
							ImageCopyResized($new_image_s,$orig_image,
															 0,0,0,0,
															 $new_width_s, $new_height_s,
															 $orig_size[0],$orig_size[1]);
							$newBild_b="$path_b"."$new_name"."_b.";
							$newBild_s="$path_s"."$new_name"."_s.";
							
							$name_s = "$new_name"."_s.";
							$name_b = "$new_name"."_b.";
							$extension ="";
						}

						switch($content_type)                             
							{
								case "gif" : 
								   ImageGIF($new_image_b,$newBild_b.="gif");
								   ImageGIF($new_image_s,$newBild_s.="gif");
								   $extension .="gif";
												 break;
								case "jpeg" : 
								   ImageJPEG($new_image_b,$newBild_b.="jpeg", $quality); 
								   ImageJPEG($new_image_s,$newBild_s.="jpeg", $quality);
								   $extension .="jpeg";
												 break;
								case "png" : 
								   ImagePNG($new_image_b,$newBild_b.="png"); 
								   ImagePNG($new_image_s,$newBild_s.="png");
								   $extension .="png";
												 break;
								case "bmp" : 
								   ImagePNG($new_image_b,$newBild_b); 
								   ImagePNG($new_image_s,$newBild_s); 
								   $extension .="bmp";
												 break; 
								
								case "unknown" :
										   $Bild_OK  = FALSE;
										 $err_info = "Format nicht erkannt";
										 break;
								default: $Bild_OK  = FALSE;
										 $err_info = "should never happen";
							}
	if ($_POST["pic_Beschreibung"] != "")
		$db->INSERT_Gildenbild("./img/Gildenfoto/klein/"."$new_name"."_s.".$extension, "./img/Gildenfoto/gross/"."$new_name"."_b.".$extension, $_POST["pic_Beschreibung"]);
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Imperial-March - Pictures</title>
<link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Wallpoet" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Graduate" rel="stylesheet" type="text/css"/>
<link href="./style.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="Lightbox/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="Lightbox/js/lightbox-2.6.min.js"></script>
<script type="text/javascript">
function FensterOeffnen (Adresse) {
  MeinFenster = window.open(Adresse, "Zweitfenster", "scrollbars=yes");
  MeinFenster.focus();
}
</script>
<link href="Lightbox/css/lightbox.css" rel="stylesheet" />
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
				<div id="content_bewerbung_user">
					<div class="post">
						<div id = "Picture">
							<?php							
									 $start = $seite * $eintraege_pro_seite - $eintraege_pro_seite;  									
						             $rows = Allebilder($start,$eintraege_pro_seite, $dbconn);
									 foreach($rows as $row)
									 {
										 echo '<div class="bildbox">'."\r\n";
										 $bildk = $row['PIC_KLEIN'];
										 $bildg = $row['PIC_GROSS'];
										 echo '<h4 class="PIC_Beschreibung">'.$row["PIC_Beschreibung"].'</h4>
												<a href = "'.$bildg.'" data-lightbox="image-1" title = "">
												<img class="Pic" src="'.$bildk.'" alt="" />
											  </a>
											  </div>';
											
									}											 										
							?>
						</div>
					</div>
					<div id = "clear"></div>
					<?php	
						$menge = Anzahlbilder($dbconn);			
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
							  echo '<a href="./Pictures.php?seite='.$b.'">'.$b.'</a>';
							  }
						   }
						echo "</div>";
						?>
					<div id="Upload">
					<form action="pictures.php" method="post" enctype="multipart/form-data">
						<h4 class="bild_hochladen">Bilder hochladen:</h4>
						<div id="bild_auswaehlen">
							<input name="Datei" type="file" size="50" maxlength="100000" accept="text/*"/>
						</div>
						<div id="bild_beschreibung">
									<h4 class="bild_hochladen">&Uuml;berschrift:</h4>
									<input type="text" id="pic_Beschreibung" name="pic_Beschreibung" />
							<div id = "bild_bestaetigen">		
								<input type="submit" name="Absenden" value="Absenden" id="Absenden"/>	
							</div>
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