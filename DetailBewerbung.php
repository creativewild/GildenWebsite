<?php
    require_once "./src/my_funcs.inc";
	include "./src/dbadmin.inc";
	include "./src/db.inc";
	debugging(false);
	init_session();
  	$error = "";
	$dbconn = Connect_DB();
	$db = new Datenbank();
	if ($_SESSION['BID']=="")
		$_SESSION['BID'] = $_GET['BID'];
	$DetailBewerbung=Get_Bewerbung($_SESSION['BID'], $dbconn);
	$_SESSION['BID'] = "";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>K&uuml;nstlerwebsite - Pictures</title>
		<link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css"/>
		<link href="http://fonts.googleapis.com/css?family=Wallpoet" rel="stylesheet" type="text/css"/>
		<link href="http://fonts.googleapis.com/css?family=Graduate" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="./styleoverlaybewerbungen.css" />
		<script type="text/javascript">var GB_ROOT_DIR = "./greybox/";</script>
		<script type="text/javascript" src="greybox/AJS.js"></script>
		<script type="text/javascript" src="greybox/AJS_fx.js"></script>
	</head>
	<body>
		<div id="Detailuser">
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<?php
					foreach($DetailBewerbung as $row)
					{
						echo '<div id="OverlayChar">
						<p><h2>Bewerbung von '.$row['Charname'].'</h2></p>
						</div>';
						echo '<div>
							  	<p><h4>Alter:</h4></p>
								<div class="OverlayAusgabe">'.$row['alter'].'</div>
							  </div>';
						echo '<div>
							  	<p><h4>Rasse:</h4></p>
								<div class="OverlayAusgabe">'.$row['Rasse'].'</div>
							  </div>';
						echo '<div>
							  	<p><h4>Klasse:</h4></p>
								<div class="OverlayAusgabe">'.$row['Klasse'].'</div>
							  </div>';
						echo '<div>
							  	<p><h4>Ausrichtung:</h4></p>
								<div class="OverlayAusgabe">'.$row['Ausrichtung'].'</div>
							  </div>';
						echo '<div>
							  	<p><h4>Warum:</h4></p>
								<div class="OverlayAusgabe" style="padding-right: 12px;">'.$row['Warum'].'</div>
							  </div>';
						echo '<div>
							  	<p><h4>Vorlieben:</h4></p>
								<div class="OverlayAusgabe">'.$row['Vorlieben'].'</div>
							  </div>';
						echo '<div>
								<p><h3>Online-Zeiten:</h3></p>
								<p><h4>Online-Tage:</h4></p>
							  </div>
							  <div id="OverlayTage">';
						if(empty($row['JT']))
						{
							if(!empty($row['Mo']))
							{
							echo '<div>
							  		<p><h4></h4></p>
									<div class="Tag">Montag</div>
								  </div>';
							}
							if(!empty($row['Di']))
							{
							echo '<div class="Tag">Dienstag</div>';
							}
							if(!empty($row['Mi']))
							{
							echo '<div class="Tag">Mittwoch</div>';
							}
							if(!empty($row['Do']))
							{
							echo '<div class="Tag">Donnerstag</div>';
							}
							if(!empty($row['Fr']))
							{
							echo '<div class="Tag">Freitag</div>';
							}
							if(!empty($row['Sa']))
							{
							echo '<div class="Tag">Samstag</div>';
							}
							if(!empty($row['So']))
							{
							echo '<div class="Tag">Sonntag</div>';
							}
						}
						else
						{
							echo '<div class="OverlayTag">Jeden Tag</div>';
						}
						echo '</div>
				              <div>
							  	<p><h4>Ab wann:</h4></p>
								<div class="OverlayAusgabe">'.$row['Zeit'].' Uhr</div>
							  </div>';
						if(!empty($row['Zusatz']))
						{
						echo '<div id="OverlayName">
							  	<p><h4>Weitere Infos:</h4></p>
								<div class="OverlayAusgabe">'.$row['Zusatz'].'</div>
							  </div>';
						}
						if(!empty($row['Grund']))
						{
						echo '<div>
								<p><h3>Bewerbungsinformation:</h3></p></br>
								<div class="OverlayAusgabe">'.$row['Grund'].'</div>
							  </div>';
						}
					} 
				?>
				<div id="Overlaysubmit">
						<input type="submit" name="Schließen" value="Fenster schlie&szlig;en"  onclick="parent.parent.GB_hide();" />
				</div>
			</form>
		</div>
	</body>
</html>