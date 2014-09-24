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

  /***********
   *Variablen*
   ***********/
    $_SESSION['BID'] = "";
	$error="";
	$table="";
	$dbconn = Connect_DB();
	$db = new Datenbank();
  
  /***************************
   *Beginn des Hauptprogramms*
   ***************************/
   	if (isset($_POST['Kommentar_Bestaetigen']))
	{
	foreach ($_POST['Kommentar'] as $key => $inhalt)
		{
			if ($inhalt!="")
				$Kommentar = $inhalt;
		}
	$ID=(int)key($_POST['Kommentar_Bestaetigen']);
	$db->UpdateBewerbungKommentar($ID,$Kommentar);
	}
	if (isset($_POST['Bestaetigen']))
	{
		if(isset($_POST['Aufnahme']))
		{
			$ID=(int)$_POST['Aufnahme'];
			$db->UpdateBewerbung($ID,"", True, True);
		}
		if(isset($_POST['Ablehnung']))
		{  
		  $error = "";
		  $ID=(int)$_POST['Ablehnung'];
		  echo $ID;
		  $db->UpdateBewerbung($ID,"", False, True);
		
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Imperial-March - Bewerbungen</title>
<link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Wallpoet" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Graduate" rel="stylesheet" type="text/css"/>
<link href="./style.css" rel="stylesheet" type="text/css" media="screen" />
		<script type="text/javascript" src="./src/overlay.js"></script>
		<script type="text/javascript">var GB_ROOT_DIR = "./greybox/";</script>
		<script type="text/javascript" src="greybox/AJS.js"></script>
		<script type="text/javascript" src="greybox/AJS_fx.js"></script>
		<script type="text/javascript" src="greybox/gb_scripts.js"></script>
		<script type="text/javascript">
		$(function() { 
		    $('a[href^=http]').click( function() { 
		        window.open(this.href); 
		        return false; 
		    }); 
		});  
		</script>
		<link href="greybox/gb_styles.css" rel="stylesheet" type="text/css" />
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
			<li class="current_page_item"><a href="#">Bewerbung</a>
				<ul>
					<li><a href="./Bewerbung.php">Neu</a></li>
					<li><a href="./Bewerbungindex.php">Offen</a></li>
				</ul>
			</li>
	        <li><a href="./Registrieren.php">Registrieren</a></li>
		</ul>
	</div>
	<div id="page">
		<div id="page-bgtop">
			<div id="page-bgbtm">
				<div id="content_bewerbung_user">
					<div class="post">
						<h2 class="title"></h2>
						<div id="useranzeigen">
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<?php
										$Bearbeitung_Pruefen = false;
										$rows = GetBewerbungen($dbconn);
										foreach($rows as $row)
										{
											if($row['Bearbeitung'] == 0 and $row['Aufgenommen'] == 0)
											{											
												$display = '<ul><li class="alleBewerbungen" style= "background-color: #D6C610 ';
												$Bearbeitung_Pruefen = true;
												$display        .= '"><a href="./DetailBewerbung.php?BID=';
												$display        .= $row['Bewerbung_ID'];
												$display        .= '" rel="gb_page[600, 600]"';
												$display        .= ' title="';
												$display        .= '">';
												$display		.= $row["Charname"];
												$display        .= '</a>';
												$display        .= '</li></ul>'."\r\n";
												echo $display;
												$display = "";
											}
										}

								?>
							</form>
						</div>
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

