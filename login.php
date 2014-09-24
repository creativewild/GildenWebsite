<?php
  /****************************
   *Einbindung fremder Dateien*
   ****************************/
    require_once "./src/my_funcs.inc";
    include "./src/db.inc";
    include "./src/print_html.inc";
	include "./src/dbadmin.inc";
	include "./src/counter.php" ;

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
	$create="";
	$datenbank = new Datenbank();
	$Status = null;
	$dbconn = Connect_DB();
	$DetailAnzeige=GetUserliste($dbconn);
	$Ampel = False;
	$Bewerbungneu = 0;
	$Serverpopulationniedrig = Serverpopulationniedrig();
    $Servername = Servername();
	$Servernstatus = Serverstatus();
	$Population = "Niedrig";
	$Name = "";
	$Status = "";
	$Server = "T3-M4";
	$i=0;
	$OnlineUser = array();
	$OnlineUserName = array();
	$sub = array();
	$f_Thread = array();
   /***************************
   *Beginn des Hauptprogramms*
   ***************************/
    $timestamp = time();
    $datenbank->Useronline($_SESSION['User_ID'], $timestamp);
    $OnlineUser = Useronlinereturn($dbconn);
       
	if(!empty($_SESSION['User_ID']))
	{
		$Status = $datenbank->Get_Status($_SESSION['User_ID']);
		$bild = $datenbank->Get_Userbild($_SESSION['User_ID']);
		$user = $datenbank->Get_Username($_SESSION['User_ID']);
		$NewsID = $datenbank->Get_news_aktuell();
		$Bild = $datenbank->Get_news_bild($NewsID);
		$News = $datenbank->Get_news_news($NewsID);
		$OnlineUserName = GetUser($dbconn);
		$raid_arr = GetRaid($dbconn);
		$AnzahlUngelesen = 0;
		if($_SESSION['cookie'])
		setcookie('UserID', $_SESSION['User_ID'], time()+604800);
	}
	if(isset($_POST['Ausloggen']))
	{
		$_SESSION['User_ID']="";
		$_COOKIE['UserID']="";
		session_destroy();
		setcookie('UserID',$_SESSION['User_ID'], time()-3600);
		$ziel = "./Meldungen.php?id=2";
		header("Location: $ziel");

	}
	$key = array_search($Server, $Servername);
	$Statusserver = $Servernstatus[$key - 1];
	$Name = $Servername[$key];
	if ($Serverpopulationniedrig[$key + 1] == "")
	{
		$Population = "Standard";
		$Serverpopulationstandart = Serverpopulationnormal();
		if ($Serverpopulationstandart[$key + 1] == "")
		{
			$Population = "Hoch";
			$Serverpopulationhoch = Serverpopulationhoch();
			if ($Serverpopulationhoch[$key + 1] == "")
			{
				$Population = "Voll";
			}
		}
	}
	if ($Statusserver == "UP")
	{
		$Serverbild = "./img/site/Glasbutton_Gruen.png";
		
	}
	else
	{
		$Serverbild = "./img/site/Glasbutton_Rot.png";
		$Population = "Leer";
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Imperial-March</title>
<meta http-equiv="refresh" content="1800;url=./login.php" />
<link rel="stylesheet" type="text/css" href="./tsstatus/tsstatus.css" /> 
<link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Wallpoet" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Graduate" rel="stylesheet" type="text/css"/>
<link href="./style.css" rel="stylesheet" type="text/css" media="screen" />
<style type="text/css">
	@font-face { 
			font-family: Starjedi;
             		src: ./fonts/starjedi.ttf;
		   }
</style>
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
			<div id="gif">
			</div>
		</div>
	</div>
	<div id="menu">
		<ul>
			 <li class="current_page_item"><a href="./login.php">Home</a></li>
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
				<div id="content">
					<div class="post">
						<?php
						{
							echo
								' <div>
                                    <div id="Login_News_Bild"><img id="img_willkommen" src="'.$Bild.'" alt="Willkommenslogo" /></div>
                                    <div id="Login_News_News">'.nl2br($News).'</div>
								    <div id="Login_Bewerbung_Forum">
							      </div>';
							$Bearbeitung_Pruefen = false;
							$rows = GetBewerbungen($dbconn);
							foreach($rows as $row)
							{
								if ($row["Bearbeitung"]==0)
								{	
									$Bewerbungneu = $Bewerbungneu + 1;
									$Ampel = true;
								}
							}
							if ($Bewerbungneu > 0)
							{
								echo '<img id="AmpelGif" src="./img/site/neuBewerberForum.gif" alt="" />
									  <div id="Login_Bewerbung_neu">';
								if ($Bewerbungneu == 1)
								{
									echo '<h4>1 neuer Bewerber</h4>';
								}
								else
								{
									echo '<h4>'.$Bewerbungneu.' neue Bewerber</h4>';
								}
									echo '</div>';
							}
							include './Forum/config.php';
							include './Forum/functions.php';
							$get_cats = 'SELECT * FROM `forum_categories` WHERE `active` = 1 && `type` = 0 ORDER BY `position`'; // SQL-Query zum Abfragen der Hauptkategorien
							$res = $db->query($get_cats);
							if($res->num_rows)
							{
								$Tags = 'Bei der Eingabe von TAG`s, werden diese unbrauchbar gemacht';
								while($row = $res->fetch_assoc())
								{
									$subs = 'SELECT * FROM `forum_categories` WHERE `main_categorie` = '.$row['ID'].' && `type` = 1 && `active` = 1 ORDER BY `position`'; // Sucht beschreibbare Foren
									$sub_res = $db->query($subs);
									while($sub = $sub_res->fetch_assoc())
									{										
										$get_Thread = "SELECT ID FROM forum_threads WHERE fid = ".$sub['ID'];
										$Thread = $db->query($get_Thread);
										$Zaehlerthreads = 0;
										$Zaehlergleich = 0;
										while($f_Thread = $Thread->fetch_assoc())
										{
											$get_Beitrag = 'SELECT ID FROM forum_posts WHERE tid = '.$f_Thread['ID'].' && fid = '.$sub['ID'] ;
											$Beitrag = $db->query($get_Beitrag);
											while($f_Beitrag = $Beitrag->fetch_assoc())
											{
												$Zaehlerthreads++;
												$get_Beitrag1 = 'SELECT ID FROM forum_posts WHERE tid = '.$f_Thread['ID'].' && fid = '.$sub['ID'].' ORDER BY ID DESC';
												$Beitrag1 = $db->query($get_Beitrag1);
												$f_Beitrag1 = $Beitrag1->fetch_assoc();
												$get_anwesend = 'SELECT Thread_ID FROM `forum_gelesen` WHERE Kategorie_ID = '.$sub['ID'].' && Forum_ID = '.$f_Thread['ID'].' && User_ID = '.$_SESSION['User_ID'].' ORDER BY Thread_ID DESC';
												$anwesend = $db->query($get_anwesend);
												$f_anwesend = $anwesend->fetch_assoc();
												if ($f_anwesend['Thread_ID'] == $f_Beitrag1['ID'])
												{
													$AnzahlUngelesen = $AnzahlUngelesen;
												}
												else
												{
													if ($sub['ID']!=48)
														$AnzahlUngelesen = $AnzahlUngelesen + 1;
												}
											}
										}
									}
								}
							}
							if ($AnzahlUngelesen > 0)
							{	
								if ($Ampel == false)
								{
									echo '<img id="AmpelGif" src="./img/site/neuBewerberForum.gif" alt=""/>';
									echo '<div id="Login_Forum_neu_ohne_Bewerbung">';
								}
								else
								{
									echo '<div id="Login_Forum_neu">';
								}
								echo '<h4>Neue Beitr&auml;ge im Forum</h4>';
								echo '</div>';
							}

							echo '</div>';
						}
					?>
					</div>
					<div style="clear: both;">&nbsp;</div>
				</div>
				<div id="sidebar">
					<ul>
						<li>

							<div class="sidebar_anzeige">
								<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
									<div id="Login_anzeige">
										<?php
										{
											echo	'<div id="login_anzeige">
														 <div id="Login_Beschriftung">
														 <img id="img_user" src="./img/site/Content_Hintergrundbalken_Blanko.png" alt="" />
														 <div id="USER_NAME"><h2 id="img_user_name">'.strtolower($user).'</h2></div></div>
														 <img class="Rahmen_Login" src="./img/site/Rahmen_Raidfortschritt.png" alt="" />
														 <div id="LR_Button">';
														if ($bild == "_s.png")
														{
															echo '<img id="img_User" src="./img/site/platzhalter_troll.png"  alt="" />';     
														}
														else
														{
															echo '<img id="img_User" src="'.$bild.'" alt="" />'; 
														}
											echo'		 </div>
													 </div>';
										}
										?>
									</div>
									<div id="Logout_Button"><input  type="submit" class="Button" id="unlogin_button" name="Ausloggen" value="Ausloggen" /></div>
									<div id="Meldungen">
										<h6><?php echo $error;?></h6>
									</div>
								</form>
							</div>

						</li>
						<li>

							<div class="sidebar_anzeige">
								<div id="Anzeige_Raids">
									<img id="img_raid" src="./img/site/Content_Hintergrundbalken_Raidfortschritt.png" alt="Raidfortschritt" />
									<img class="Rahmen_Raid" src="./img/site/Rahmen_Raidfortschritt.png" alt=""/>
                                    <div id="raidanzeige">
                                        <table id="Raids"> 									
                                            <tr>
                                            	<td>8er Raids: </td>
                                            	<td>HM:</td>
                                            </tr>
                                            <?php
                                            
                                            foreach($raid_arr AS $raid):
                                                if($raid['gesamt']>0)
                                                {
                                            ?>
                                            <tr>
                                            	<td><?php echo $raid['Raid']; ?></td>
                                            	<td><?php echo $raid['geschafft']; ?>/<?php echo $raid['gesamt']; ?></td>
                                            </tr>
                                            <?php
                                                }
                                            endforeach;
                                             ?>
                                        </table>
                                    </div>
								</div>
							</div>

						</li>	
						<li>
							<div class="sidebar_server">
								<div id="Server_Beschriftung">
									 <img id="img_server" src="./img/site/Content_Hintergrundbalken_Blanko.png" alt="" />
									 <h2 id="Serverstatus">Serverstatus</h2>
									 <img class="Rahmen_Login" src="./img/site/Rahmen_Raidfortschritt.png" alt="" />
									 <h3 id="img_server_name"><?=$Name;?></h3>
									 <img id="img_Server" src="<?=$Serverbild;?>" width="100" height="auto" alt="" />
									 <h3 id="img_server_Auslastung">Auslastung: <?=$Population;?></h3>
								</div>
							</div>
						</li>	
						<li>
							<div class="sidebar_ts">
								<div id="TS3">
									<img id="img_ts" src="./img/site/Content_Hintergrundbalken_Teamspeak.png" alt="Teamspeak" />
									<img class="Rahmen_Raid" src="./img/site/Rahmen_TS.png" alt="" />
									<div id="ts3viewer">
                                        <script type="text/javascript" src="/Gilde/tsstatus/tsstatus.js"></script>
                                        <?php
                                                require_once("./tsstatus/tsstatus.php");
                                                $tsstatus = new TSStatus("imperial-march.de", 10011);
                                                $tsstatus->useServerPort(9987);
                                                $tsstatus->imagePath = "./tsstatus/img/";
                                                $tsstatus->timeout = 2;
                                                $tsstatus->hideEmptyChannels = false;
                                                $tsstatus->hideParentChannels = false;
                                                $tsstatus->showNicknameBox = false;
                                                $tsstatus->showPasswordBox = false;
                                                echo $tsstatus->render();
                                        ?>
								    </div> 
                                </div>
							</div>

						</li>
					</ul>
				</div>
				<div style="clear: both;"></div>
			</div>
		</div>
	</div>

</div>
<div id="footer"><?php echo $create=print_create();?></div>
</body>
</html>