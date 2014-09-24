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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Imperial-March - User</title>
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
			function FensterOeffnen (Adresse) {
  				MeinFenster = window.open(Adresse, "Zweitfenster", "scrollbars=yes");
  				MeinFenster.focus();
			}
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
			 <li class="current_page_item"><a href="./User.php">User</a></li>
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
			<div id="page-bgtop">
				<div id="page-bgbtm">
					<div id="content_bewerbung_user">
						<div class="post">
							<h2 class="title"></h2>
							<div id="useranzeigen">
								<ul>
									<?php
											$rows = GetUserliste($dbconn);
			
											foreach($rows as $row)
											{
												$display		 = '<li class="alleuser';
												$display        .= '"><a href="./DetailUser.php?UID=';
												$display        .= $row['User_ID'];
												$display        .= '" rel="gb_page[600, 600]"';
												$display        .= ' title="';
												$display        .= '">';
												$display		.= $row['Mainchar'];
												$display        .= '</a>';
												$display        .= '</li>'."\r\n";
												echo $display;
	 											$display = "";
												
											}
										?>
								</ul>
							<div class="useranzeigen">
						</div>
						<div style="clear: both;">&nbsp;</div>
					</div>
					<div style="clear: both;"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="footer"><?php echo $create=print_create();?></div>
</div>
</body>
</html>
