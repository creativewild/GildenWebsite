<?php
	if(extension_loaded("zlib") AND strstr($_SERVER["HTTP_ACCEPT_ENCODING"],"gzip"))
		@ob_start("ob_gzhandler");

  /****************************
   *Einbindung fremder Dateien*
   ****************************/
    require_once "./src/my_funcs.inc";
    include "./src/db.inc";
    include "./src/print_html.inc";
	require_once('./src/recaptchalib.php');

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
  $DEBUG=false;
  $error=null;
  $table=null;
  $db = new Datenbank();
  $Emailoeffentlich = false;
  $Bildklein = "";
  $Bildgross = "";
 
  /***************************
   *Beginn des Hauptprogramms*
   ***************************/
  //Abbruch Button
  if (isset($_POST['Abbruch_Button'])) 
  {
	header('Location: ./index.php');
  }

  //Registrieren Button	
if (isset($_POST['Reg_Button']))
{
	if (eingabecheck_registrieren())
	{
		if(!empty($_FILES['bild'])||!empty($_POST['bild']))
		{
			$orig_bild = $_FILES['bild']['tmp_name'];
			$orig_size = getimagesize($orig_bild);
			$format=($orig_size[0]>$orig_size[1])?"h":"v"; 
			switch($orig_size[2])                         
			{
			case 1 : $orig_image = ImageCreateFromGIF($orig_bild);
								 break;
			case 2 : $orig_image = ImageCreateFromJPEG($orig_bild);  	         
								 break;
			case 3 : $orig_image = ImageCreateFromPNG($orig_bild);
								 break;
			case 6 : $content_type = "bmp"; break;
			case 7 : 
			case 8 : $content_type = "tiff"; 
								 break;
			default: $content_type = "unknown";
			}
            if ( $orig_image )
			{
				if ( $format=="h" ) 
				{
					$new_width_b  = 600;
					$new_height_b = round(600*$orig_size[1]/$orig_size[0],0); 
					$new_width_s  = 200;
					$new_height_s = round(200*$orig_size[1]/$orig_size[0],0); 
				}
				else               
				{
					$new_height_b = 600;
					$new_width_b  = round(600*$orig_size[0]/$orig_size[1],0); 
					$new_height_s = 200;
					$new_width_s  = round(200*$orig_size[0]/$orig_size[1],0); 
				}
				$path_s    = "./img/Userfoto/klein/";	
				$path_b    = "./img/Userfoto/gross/";
				$path_orig = "./img/Userfoto/orig/";
				$new_name  = time().mt_rand(1000,9999);
				$quality   = 75;
			}
		  $new_image_b=ImageCreateTrueColor($new_width_b, $new_height_b); 
		  $new_image_s=ImageCreateTrueColor($new_width_s, $new_height_s);		 
		  ImageCopyResampled($new_image_b,$orig_image,
						   0,0,0,0,
						   $new_width_b, $new_height_b,
						   $orig_size[0],$orig_size[1]);	 
		  ImageCopyResized($new_image_s,$orig_image,
						   0,0,0,0,
						   $new_width_s, $new_height_s,
						   $orig_size[0],$orig_size[1]);
		  $newBild_b="$path_b"."$new_name"."_b.";
		  $newBild_s="$path_s"."$new_name"."_s.";
		  ImageJPEG($new_image_b,$newBild_b.="png"); 
		  ImageJPEG($new_image_s,$newBild_s.="png");
		  $Bildklein=$newBild_s;
		  $Bildgross=$newBild_b;	
		}
		if(isset($_POST['emailoeffentlich']))
			$Emailoeffentlich = true;
		$_Post["captchareturn"]=true;
		$var = $_POST['geburtstag'];
		$date = str_replace('.', '-', $var);
		$date = date('Y-m-d', strtotime($date));
		$db->INSERT_User($_POST["email"],$_POST["passwd"], $_POST["mainchar"], $Bildklein, $Bildgross, $_POST["vorname"], $_POST["nachname"], $date, $_POST["wohnort"], $_POST["telefonnummer"], $Emailoeffentlich, $_POST["user_eingabe"] );
		$ziel = "./Meldungen.php?id=3";
		header("Location: $ziel");
	}
	else
	{
		$ziel = "./Meldungen.php?id=5";
		header("Location: $ziel");
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Imperial-March - Registrieren</title>
<link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Wallpoet" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Graduate" rel="stylesheet" type="text/css"/>
<link href="./style.css" rel="stylesheet" type="text/css" media="screen" />
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
			<li><a href="./Index.php">Home</a></li>
			<li><a href="./Gildenregeln.php">Gildenregeln</a></li>
			<li><a href="#">Bewerbung</a>
				<ul>
					<li><a href="./Bewerbung.php">Neu</a></li>
					<li><a href="./Bewerbungindex.php">Offen</a></li>
				</ul>
			</li>
	        <li class="current_page_item"><a href="./Registrieren.php">Registrieren</a></li>
		</ul>
	</div>
	<div id="page">
		<div id="page-bgtop">
			<div id="page-bgbtm">
				<div id="contentreg">
					<div id="reg">
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >	
						<div id="Registrieren">
							<h2 class="title">Registrierung</h2>
							<h4 class='angaben'>Pflichtangaben</h4>
								<div class="registrierung">
									<div id="E-Mail">
										<div id="e_text"><label for="email">E-Mail Adresse:</label></div>
										<div id="e_eingabe"><input type="text" id="email" name="email" /></div>
									</div>
									<div id="Passwort">
										<div id="pw_text"><label for="passwd">Passwort:</label></div>
										<div id="pw_eingabe"><input type="password" id="passwd" name="passwd" /></div>
									</div>
									<div id="Passwort_wiederholen">
										<div id="pww_text"><label for="passwd_wiederholen">Passwort wiederholen:</label></div>
										<div id="pww_eingabe"><input type="password" id="passwd_wiederholen" name="passwd_wiederholen" /></div>
									</div>
									<div id="Mainchar">
										<div id="mc_text"><label for="mainchar">MainChar:</label></div>
										<div id="mc_eingabe"><input type="text" id="mainchar" name="mainchar" /></div>
									</div>
								</div>
						</div>
						<div class="freiwillig">
								<h4 class='freiwillig1'>Freiwillige Angaben</h4>
								<div id="Eingabe">  
									<div id="b_text"><label for="bild" >Real-Life Bild:</label></div>
									<div id="b_eingabe"><input type="file" name="bild" id="bild" accept="image/*" size="80" /></div>
								</div>
								<div id="persoenlich">
								<div id="vn_text"><label for="vorname">Vorname:</label></div>
									<div id="vn_eingabe"><input type="text" id="vorname" name="vorname" /></div>
								<div id="nn_text"><label for="nachname">Nachname:</label></div>
									<div id="nn_eingabe"><input type="text" id="nachname" name="nachname" /></div>
								<div id="gt_text"><label for="geburtstag">Geburtstag:</label></div>
									<div id="gt_eingabe"><input type="text" id="geburtstag" name="geburtstag" /></div>
								<div id="wo_text"><label for="wohnort">Wohnort:</label></div>
									<div id="wo_eingabe"><input type="text" id="wohnort" name="wohnort" /></div>
								<div id="tn_text"><label for="telefonnummer">Telefonnummer:</label></div>
									<div id="tn_eingabe"><input type="text" id="telefonnummer" name="telefonnummer" /></div>
								<div id="em_text"><label for="emailoeffentlich">E-Mail Adresse(öffentlich):</label></div>
									<div id="em_eingabe"><input type="checkbox" id="emailoeffentlich" name="emailoeffentlich" /></div>
								<div id="ft_text"><label>freier Text:</label></div>
								<div id="ft_eingabe"><textarea name="user_eingabe" cols="87" rows="15"></textarea></div>
								<div id="Reg_Button">
									<input type="submit" class="buttons" name="Reg_Button" value="Registrieren" />
								</div>
								<div id="A_Button">
									<input type="submit" class="buttons" name="Abbruch_Button" value="Abbruch" />
								</div>
								<div id="Meldungenreg">
									<h6><?php echo $error; ?></h6>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div style="clear: both;">&nbsp;</div>
				</div>
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>
</div>

<div id="footer"><?php echo $create=print_create();?></div>

</body>
</html>
