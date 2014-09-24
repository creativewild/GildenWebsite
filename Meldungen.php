<?php
require_once "./src/my_funcs.inc";
debugging( true );
init_session();
$Fehlermeldung = "";
$fid ="";
$tid ="";
if (isset($_GET['fid']))
{
$fid = $_GET['fid'];
$tid = $_GET['tid'];    
}
$index = "<a href='./index.php'>Weiter</a>";
$login = "<a href='./login.php'>Weiter</a>";
$Postbearbeiten = "<a href='./showposts.php?fid=$fid&tid=$tid'>Weiter</a>";
$bewerbung = "<a href='./bewerbung.php'>Zur&uuml;ck</a>";
switch($_GET['id'])
{
	case 1: 
		$Fehlermeldung = "Anmeldung erfolgreich.<br /><br />"; 
		break;
	case 2:
		$Fehlermeldung = "Abmeldung erfolgreich.<br /><br />";
		break;
	case 3:
		$Fehlermeldung = "Registrierung erfolgreich.<br />
									<p>Ein Admin wird wird dich schnellstmöglich freischalten. .</p><br /><br />";
		break;
	case 4:
		$Fehlermeldung = "Bewerbung erfolgreich erstellt<br />
											<p>Ein Gildenmitglied setzt sich so schnell<br />wie möglich mit dir in Verbindung.</p><br /><br />";
		break;
	case 5:
		$Fehlermeldung = "Es ist ein Fehler aufgetreten. Bitte Wiederholen<br /><br />";
		break;
	case 6:
		$Fehlermeldung = "Es wurden nicht alle Pflichtfelder ausgef&uuml;llt<br /><br />";
		break;
	case 7:
        $Fehlermeldung = "Post wurde erfolgreich bearbeitet<br /><br />";
        break;
    case 8:         
        $Fehlermeldung = "Bei der Bearbeitung des Posts ist ein Fehler aufgetreten<br /><br />";
        break;
    case 9:
        $Fehlermeldung = "Post wurde nicht verändert.<br /><br />";
       	break;
    
       	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Imperial-March</title>
<script type="text/javascript">
function weiterleitung(a, b)
{
	window.setTimeout(a, b * 1000);
}
</script>
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
	<div id="pagemeldung">
		<div id="page-bgtop">
			<div id="page-bgbtm">
				<div class="post">
					<h2 class="title"></h2>
						<?php
							switch($_GET['id'])
							{
								case 1: 
									echo $Fehlermeldung;
									echo '<script type="text/javascript"><!--
									function Weiterleitung()
									{
									   location.href="./index.php";
									}
											window.setTimeout("Weiterleitung()", 3000);
									</script>';
									echo $login;
									break;
								case 2:
									echo $Fehlermeldung;
									echo '<script type="text/javascript"><!--
									function Weiterleitung()
									{
									   location.href="./index.php";
									}
											window.setTimeout("Weiterleitung()", 3000);
									</script>';
									echo $index;
									break;
								case 3:
									echo $Fehlermeldung;
									echo '<script type="text/javascript"><!--
									function Weiterleitung()
									{
									   location.href="./index.php";
									}
											window.setTimeout("Weiterleitung()", 3000);
									</script>';
									echo $index;
									break;
								case 4:
									echo $Fehlermeldung;
									echo '<script type="text/javascript"><!--
									function Weiterleitung()
									{
									   location.href="./index.php";
									}
											window.setTimeout("Weiterleitung()", 3000);
									</script>';
									echo $index;
									break;
								case 5:
									echo $Fehlermeldung;
									echo '<script type="text/javascript"><!--
									function Weiterleitung()
									{
									   location.href="./index.php";
									}
											window.setTimeout("Weiterleitung()", 3000);
									</script>';
									echo $index;
									break;
								case 6:
									echo $Fehlermeldung;
									echo '<script type="text/javascript"><!--
									function Weiterleitung()
									{
									   location.href="./bewerbung.php";
									}
											window.setTimeout("Weiterleitung()", 3000);
									</script>';
									echo $bewerbung;
									break;
								case 7:
								    echo $Fehlermeldung;
									echo '<script type="text/javascript"><!--
									function Weiterleitung()
									{
									   location.href="./showposts.php?fid='.$fid.'&tid='.$tid.'";
									} 
											window.setTimeout("Weiterleitung()", 3000);
									</script>';
									echo $Postbearbeiten;
									break;
								case 8:
									echo $Fehlermeldung;
									echo '<script type="text/javascript"><!--
									function Weiterleitung()
									{
									   location.href="./showposts.php?fid='.$fid.'&tid='.$tid.'";
									}
											window.setTimeout("Weiterleitung()", 3000);
									</script>';
									echo $Postbearbeiten;
									break;
								case 9:
									echo $Fehlermeldung;
									echo '<script type="text/javascript"><!--
									function Weiterleitung()
									{
									   location.href="./showposts.php?fid='.$fid.'&tid='.$tid.'";
									} 
											window.setTimeout("Weiterleitung()", 3000);
									</script>';
									echo $Postbearbeiten;
									break;
							}
						?> 
					</div>
				<div style="clear: both;">&nbsp;</div>
				</div>
			<div style="clear: both;"></div>
			</div>
		</div>
</div>
</body>
</html>