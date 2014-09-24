<?php
  /****************************
   *Einbindung fremder Dateien*
   ****************************/
    require_once "./src/my_funcs.inc";
    include "./src/db.inc";
	include "./src/dbadmin.inc";
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
  $resp = null;
  $captchareturn = false;
  $db = new Datenbank();
  $Emailoeffentlich = false;
  $Bildklein = null;
  $Bildgross = null;
  $dbconn = Connect_DB();
  $Status = $db->Get_Status($_SESSION['User_ID']);
  $DetailAnzeige=Get_User($_SESSION['User_ID'], $dbconn);
  $username = $db->Get_User_Forum($_SESSION['User_ID']);
  $i = 0;
  $CHARID = array();
  $CHARNAME = array();
  $CHARKLASSE = array();
  $char = GetChar($dbconn, $_SESSION['User_ID']);
  foreach($char as $charausgabe)
  {
      $CHARID[$i]=$charausgabe['ID'];
      $CHARNAME[$i]=$charausgabe['Char'];
      $CHARKLASSE[$i]=$charausgabe['Klasse'];
      $i++;    
  }
  
  /***************************
   *Beginn des Hauptprogramms*
   ***************************/
    $timestamp = time();
    $db->Useronline($_SESSION['User_ID'], $timestamp);
   
  //Abbruch Button
  if (isset($_POST['Abbruch_Button'])) 
  {
	header('Location: ./index.php');
  }

  //Registrieren Button	
if (isset($_POST['Reg_Button']))
{
	if(!empty($_FILES['bild']))
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
	if($_POST["mainchareingabe"] == "")
	{
		$_POST["mainchareingabe"]=$username;
	}
	$db->UPDATE_User($_POST["email"],$_POST["mainchareingabe"], $_POST["vorname"], $_POST["nachname"], $date, $_POST["wohnort"], $_POST["telefonnummer"], $Emailoeffentlich, $_POST["user_eingabe"], $_SESSION['User_ID']  );
	if(!empty($_POST['passwd']))
	{
		if($_POST['passwd']==$_POST['passwd_wiederholen'])
			$db->UPDATE_Userpasswd($_POST['passwd'], $_SESSION['User_ID']);
		else
			$error="Passwort nicht identisch";
	}
	if($Bildklein=="_s.png")
	{
	}
	else
	{
    	$db->UPDATE_Userbild($Bildklein, $Bildgross, $_SESSION['User_ID']);
	}
	if(($_POST['c1_char']!='-----') and ($_POST['char1']!=''))
	{
	    if($CHARID[0]!= "" )
	    {
            $db->UPDATE_Chars($CHARID[0],$_SESSION['User_ID'], $_POST['char1'], $_POST['c1_char']);
        }
        else
        {
            $db->INSERT_Char($_SESSION['User_ID'], $_POST['char1'], $_POST['c1_char']);
        }
    }    
	if(($_POST['c2_char']!='-----') and ($_POST['char2']!=''))
	{
	    if($CHARID[1]!= "" )
	    {
            $db->UPDATE_Chars($CHARID[1],$_SESSION['User_ID'], $_POST['char2'], $_POST['c2_char']);
        }
        else
        {
            $db->INSERT_Char($_SESSION['User_ID'], $_POST['char2'], $_POST['c2_char']);
        }
    }
	if(($_POST['c3_char']!='-----') and ($_POST['char3']!=''))
	{
	    if($CHARID[2]!= "" )
	    {
            $db->UPDATE_Chars($CHARID[2],$_SESSION['User_ID'], $_POST['char3'], $_POST['c3_char']);
        }
        else
        {
            $db->INSERT_Char($_SESSION['User_ID'], $_POST['char3'], $_POST['c3_char']);
        }
    }	
	
	
	header("Location: ./account.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Imperial-March - Account</title>
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
			 <li class="current_page_item"><a href="./Account.php">Account</a></li>
			<?php
			if($Status=='admin')
			{
			echo '<li><a href="./Admin.php">Admin</a></li>';
			}
			?>
		</ul>
	</div>
	<div id="page">
		<div id="page-bgtop">
			<div id="page-bgbtm">
				<div id="contentreg">
					<div id="reg">
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >	
							<div id="Registrieren">
								<?php
								foreach($DetailAnzeige as $row)
								{
									
								if ($row[oeffentlEmail] == true)
								{
									$cb = 'checked="checked"';
								}
								else
								{
									$cb = "";
								}
								echo'<h4 class="angaben">Pflichtangaben</h4>
									<div class="registrierung">
										<div id="E-Mail">
											<div id="e_text"><label for="email">E-Mail Adresse:</label></div>
											<div id="e_eingabe"><input type="text" id="email" name="email" value="'?><?=$row[Email]?><?='" /></div>
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
											<div id="mc_text"><label for="mainchareingabe">MainChar:</label></div>
											<div id="mc_eingabe"><input type="text" id="mainchareingabe" name="mainchareingabe" value="'?><?=$row[Mainchar]?><?='" /></div>
										</div>
									</div>
							</div>
							<div class="freiwillig">
									<h4 class="freiwillig1">Freiwillige Angaben</h4>
									<div id="Eingabe">  
										<div id="b_text"><label for="bild" >Real-Life Bild:</label></div>
										<div id="b_eingabe"><input type="file" name="bild" id="bild" accept="image/*" size="80" /></div>
									</div>
									<div id="persoenlich">
									<div id="vn_text"><label for="vorname">Vorname:</label></div>
										<div id="vn_eingabe"><input type="text" id="vorname" name="vorname" value="'?><?=$row[Vorname]?><?='" /></div>
									<div id="nn_text"><label for="nachname">Nachname:</label></div>
										<div id="nn_eingabe"><input type="text" id="nachname" name="nachname" value="'?><?=$row[Name]?><?='" /></div>
									<div id="gt_text"><label for="geburtstag">Geburtstag:</label></div>
										<div id="gt_eingabe"><input type="text" id="geburtstag" name="geburtstag" value="'?><?=$row[GebDatum]?><?='" /></div>
									<div id="wo_text"><label for="wohnort">Wohnort:</label></div>
										<div id="wo_eingabe"><input type="text" id="wohnort" name="wohnort" value="'?><?=$row[Ort]?><?='" /></div>
									<div id="tn_text"><label for="telefonnummer">Telefonnummer:</label></div>
										<div id="tn_eingabe"><input type="text" id="telefonnummer" name="telefonnummer" value="'?><?=$row[Telefon]?><?='" /></div>
									<div id="em_text"><label for="emailoeffentlich">E-Mail Adresse(öffentlich):</label></div>
										<div id="em_eingabe"><input type="checkbox" id="emailoeffentlich" name="emailoeffentlich" '?><?=$cb?><?=' /></div>
									<h4 class="freiwillig1">Chars f&uuml;r den Raidplaner</h4>
									<h4 class="freiwillig1">Bitte eindeutige Namen vergeben (keine Apostrophe und dergleichen verwenden).</h4>
									<div id="c1_text"><label for="char1">Char1:</label></div>
										<div id="c1_eingabe"><input type="text" id="char1" name="char1" value="'?><?=$CHARNAME[0]?><?='" /></div>
									    <div id="c1_char"><select name="c1_char">
        									<option>-----</option>
        									<option>Tank</option>
        									<option>Heal</option>
        									<option>Melee</option>
        									<option>RDD</option>
        								</select></div>
									<div id="c2_text"><label for="char2">Char2:</label></div>
										<div id="c2_eingabe"><input type="text" id="char2" name="char2" value="'?><?=$CHARNAME[1]?><?='" /></div>
									    <div id="c2_char"><select name="c2_char">
        									<option>-----</option>
        									<option>Tank</option>
        									<option>Heal</option>
        									<option>Melee</option>
        									<option>RDD</option>
        								</select></div>
									<div id="c3_text"><label for="char3">Char3:</label></div>
										<div id="c3_eingabe"><input type="text" id="char3" name="char3" value="'?><?=$CHARNAME[2]?><?='" /></div>
									    <div id="c3_char"><select name="c3_char">
        									<option>-----</option>
        									<option>Tank</option>
        									<option>Heal</option>
        									<option>Melee</option>
        									<option>RDD</option>
        								</select></div>
									<div id="ft_text"><label>freier Text:</label></div>
									<div id="ft_eingabe"><textarea name="user_eingabe" cols="87" rows="15">'?><?=$row[Beschreibung]?><?='</textarea></div>
									<div id="Reg_Button">
										<input type="submit" class="buttons" name="Reg_Button" value="Bestätigen" />
									</div>
									<div id="A_Button">
										<input type="submit" class="buttons" name="Abbruch_Button" value="Abbruch" />
									</div>
								</div>';
								}
							?>
							</div>
						</form>
					</div>
				</div>
				<div style="clear: both;">&nbsp;</div>
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>
</div>

<div id="footer"><?php echo $create=print_create();?></div>

</body>
</html>
