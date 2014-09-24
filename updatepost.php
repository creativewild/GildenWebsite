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
	$fid = $_GET['fid'];
	$tid = $_GET['tid'];
	$db = null;
	
	if ($_SESSION['ID_POST'] == "")
	$_SESSION['ID_POST']=$_GET['ID'];
    
	$ID = $_SESSION['ID_POST'];
    
  /***************************
   *Beginn des Hauptprogramms*
   ***************************/
	include './Forum/config.php';
	include './Forum/functions.php';
   	$sql = 'SELECT text FROM forum_posts WHERE ID = '.$ID;
	$res = $db->query($sql);
	$row1 = $res->fetch_assoc();
	$text = $row1['text'];
	$sql = 'SELECT topic FROM forum_posts WHERE ID = '.$ID;
	$res = $db->query($sql);
	$row2 = $res->fetch_assoc();
	$SuchWert = "<br /><br /><hr />bearbeitet am " ;
	
	$text = preg_replace('#<span style="font-weight: bold;">(.*?)</span>#si', '[b]\1[/b]', $text);
	$text = preg_replace('#<span style="color:(.*?);">(.*?)</span>#si', '[color=\1]\2[/color]', $text);
	$text = preg_replace('#<span style="text-decoration: underline;">(.*?)</span>#si', '[u]\1[/u]', $text);
	$text = preg_replace('#<a href="http://(.*)" >(.*)</a>#isU', "[url]$1[/url]", $text);
	$text = preg_replace('#<img src="(.*)" alt="" style="width:850px; height:auto;" />#isU', "[img]$1[/img]", $text);
	
	if(strpos($text,$SuchWert)!==false)
	{
        list($text, $rest) = split($SuchWert, $text);
    }
	
	if (isset($_POST['postupdate']))
	{
		if ($_POST['message'] != $text)
		{
			if ($_POST['message']!="" && $_POST['title']!="")
			{
				$text = $_POST['message'].'<br /><br /><hr />bearbeitet am '.date('d.m.Y H:i:s');
						$text = preg_replace('#\[b\](.*?)\[/b\]#si', '<span style="font-weight: bold;">\1</span>', $text);
						$text = preg_replace('#\[color=(.*?)\](.*?)\[/color\]#si', '<span style="color:\1;">\2</span>', $text);
						$text = preg_replace('#\[u\](.*?)\[/u\]#si', '<span style="text-decoration: underline;">\1</span>', $text);
						$text = preg_replace('#\[url\](.*)\[/url\]#isU', "<a href=\"http://$1\" >$1</a>", $text);
						$text = preg_replace('#\[img\](.*)\[/img\]#isU', "<img src=\"$1\" alt=\"\" style=\"width:850px; height:auto;\" />", $text);
						$width = 700; 
						while(preg_match('/\[quote\](.*)\[\/quote\]/Uis', $text))
						{ 
							$width -= 10; 
							$quote_start = "<br><b style=\"margin-left: 45px;\">Zitat:</b>\n". 
										   "<div style=\"border:solid 1px black; margin-left:5px; background-color:grey; color:black; margin:0px auto; width:".$width."px\">\n"; 
							$quote_end = "</div>"; 
							$text = preg_replace("/\[quote](.*)\[\/quote\]/Uis", $quote_start."\\1".$quote_end, $text); 
						}
	            		$sql = 'UPDATE forum_posts Set topic = \' '.$_POST['title'].' \', text = \' '.$text.' \' WHERE ID = '.$ID;
				$insert = $db->query($sql);
				$_SESSION['ID_POST'] = "";
				if ($insert)
				{	
	                		$ziel = 'Meldungen.php?fid='.$fid.'&tid='.$tid.'&id=7';
	            		}
	            		else
	            		{
	                		$ziel = 'Meldungen.php?fid='.$fid.'&tid='.$tid.'&id=8';
	            		}
				header("Location: $ziel");
			}
			else
			{
				$_SESSION['ID_POST'] = "";
				$ziel = './updatepost.php?ID='.$ID.'&fid='.$fid.'&tid='.$tid;
				header("Location: $ziel");
			}
		}
		else
		{
			$_SESSION['ID_POST'] = "";
			$ziel = 'Meldungen.php?fid='.$fid.'&tid='.$tid.'&id=9';
			header("Location: $ziel");
		}
	}
		


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
function FensterOeffnen (Adresse) {
  MeinFenster = window.open(Adresse, "Zweitfenster", "scrollbars=yes");
  MeinFenster.focus();
}
</script>
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
						<form id="formular" method="post" action="<?php echo './updatepost.php?ID='.$ID.'&amp;fid='.$fid.'&amp;tid='.$tid; ?>"  style="margin-left: 40px; width:665px;">
							<div>
								<strong>Titel:</strong><br /> <input type="text" name="title" value="<?=$row2['topic']?>"  size="30" /> <br />
							</div>
							<div>
								<strong> Beitrag: </strong><br />
							</div>
							<div>
								<textarea name="message" rows="15" cols="78"><?=$text?></textarea>
							</div>
							<div><br /></div>
							<input type="button" value="" onclick="insert('[u]', '[/u]')" class="unterstrichen_button" />
							<input type="button" value="" onclick="insert('[url]', '[/url]')" class="url_button" />
							<input type="button" value="" onclick="insert('[quote]', '[/quote]')" class="quote_button" />
							<input type="button" value="IMAGE" onclick="insert('[img]', '[/img]')" class="img_button" />
							<input type="button" value="" onclick="insert('[color=#800000]', '[/color]')" class="rot_button" />
							<input type="button" value="" onclick="insert('[color=#0000FF]', '[/color]')" class="blau_button" />
							<input type="button" value="" onclick="insert('[color=#005E00]', '[/color]')" class="gruen_button" />
							<input type="button" value="" onclick="insert('[color=#FFCC00]', '[/color]')" class="gelb_button" /></div>
							<div>		
								<input type="submit" name="postupdate" value="Beitrag bearbeiten" />
							</div>
						</form>
						<div>
							<h4 style="margin-left: 40px; width:665px;">Bei der Eingabe von TAG?s, werden diese unbrauchbar gemacht.</h4>
						</div>
					</div>
					<div style="clear: both;">&nbsp;</div>
				</div>
				<div style="clear: both;"></div>
	</div>
</div>
</body>
</html>