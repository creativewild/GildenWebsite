<?php
    require_once "./src/my_funcs.inc";
	include "./src/dbadmin.inc";
	debugging(false);
	init_session();
  	$error = "";
	$dbconn = Connect_DB();
	$DetailAnzeige=Get_User($_GET['UID'], $dbconn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>K&uuml;nstlerwebsite - Pictures</title>
		<link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css"/>
		<link href="http://fonts.googleapis.com/css?family=Wallpoet" rel="stylesheet" type="text/css"/>
		<link href="http://fonts.googleapis.com/css?family=Graduate" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="./styleoverlay.css" />
		<script type="text/javascript">var GB_ROOT_DIR = "./greybox/";</script>
		<script type="text/javascript" src="greybox/AJS.js"></script>
		<script type="text/javascript" src="greybox/AJS_fx.js"></script>
	</head>
	<body>
		<div id="Detailuser">
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<?php
					foreach($DetailAnzeige as $row)
					{
						echo '<div id="OverlayChar">
								<p><h2>'.$row['Mainchar'].'</h2></p>
							  </div>';
					if(!empty($row['RLBildklein']))
						{
						echo '<div id="OverlayBild">
								<div class="OverlayBild"><img src="'.$row['RLBildklein'].'" alt="" /></div>
							  </div>';
						}
					if(!empty($row['Vorname'])||
						!empty($row['Name']))
						{
						echo '<div id="OverlayName">
							  	<p><h4>Name:</h4></p>
								<div class="OverlayAusgabe">'.$row['Vorname']." ".$row['Name'].'</div>
							  </div>';
						}
					if(!empty($row['GebDatum']))
						{
						if ($row['GebDatum']!= "1970-01-01")
							{
							$datum_de = date("d.m.Y ", strToTime($row['GebDatum']));
							echo '<div id="OverlayGebDatum">
									<p><h4>Geburtstag:</h4></p>
									<div class="OverlayAusgabe">'.$datum_de.'</div>
								  </div>';
							}
						}
					if(!empty($row['Ort']))
						{
						echo '<div id="OverlayOrt">
								<p><h4>Wohnort:</h4></p>
								<div class="OverlayAusgabe">'.$row['Ort'].'</div>
							  </div>';
						}
					if(!empty($row['Telefon']))
						{
						echo '<div id="OverlayTelefon">
								<p><h4>Telefon:</h4></p>
								<div class="OverlayAusgabe">'.$row['Telefon'].'</div>
							  </div>';
						}
					if($row['oeffentlEmail'])
						{
						echo '<div id="OverlayEmail">
								<p><h4>Email-Adresse:</h4></p>
								<div class="OverlayAusgabe">'.$row['Email'].'</div>
							  </div>';
						}
						if($row['Beschreibung'])
						{
						echo '<div id="OverlayBeschreibung">
								<p><h4>Beschreibung:</h4></p>
								<div class="OverlayAusgabe">'.$row['Beschreibung'].'</div>
							  </div>';
						}

					} 
				?>
				<div id="Overlaysubmit">
						<input type="submit" id="Schließen" value="Fenster schlie&szlig;en"  onclick="parent.parent.GB_hide();" />
				</div>
			</form>
		</div>
	</body>
</html>