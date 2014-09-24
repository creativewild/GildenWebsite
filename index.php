<?php
  /****************************
   *Einbindung fremder Dateien*
   ****************************/
    require_once "./src/my_funcs.inc";
    include "./src/db.inc";
    include "./src/print_html.inc";
    include "./src/dbadmin.inc";

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
	$error="";
	$table="";
	$db = new Datenbank();
	$Status = null;
	$dbconn = Connect_DB();
	$raid_arr = GetRaid($dbconn); 

  /***************************
   *Beginn des Hauptprogramms*
   ***************************/
$SeitenInformationarray = GetSeitenInformation($dbconn);
if($_COOKIE['UserID']=="")
{
	if (isset($_POST['Login_Button']))
	{
		if (eingabecheck_login())
		{
		$User_ID = $db->Get_User_ID_By_Login($_POST["login"],$_POST["passwd"]);
				if($User_ID==false)
				{
					$ziel = "./Meldungen.php?id=5";
					header("Location: $ziel");
				}
				else
				{
					$Status = $db->Get_Status($User_ID);
					if($Status=='aktiv' || $Status=='admin')
					{
						$_SESSION['Status']=$Status;
						$_SESSION['User_ID'] = $User_ID;
						$_SESSION['Musik'] = null;
						if(!empty($_POST['cookie_setzen']))
							{
							setcookie('UserID', $User_ID, time()+604800);
							}
						$ziel = "./Meldungen.php?id=1";
						header("Location: $ziel");
					}
				}
		}
		else
		{
			$ziel = "./Meldungen.php?id=5";
			header("Location: $ziel");
		}
	}
}
else
{
	$Status = $db->Get_Status($_COOKIE['UserID']);
	if(($Status=='aktiv'||$Status=='admin'))
	{

		$_SESSION['User_ID'] = $_COOKIE['UserID'];
		$_SESSION['cookie'] = true;
		$ziel = "./login.php?".SID;
		header("Location: ./$ziel");
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Imperial-March</title>
<link rel="stylesheet" type="text/css" href="./tsstatus/tsstatus.css" /> 
<link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Wallpoet" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Graduate" rel="stylesheet" type="text/css"/>
<link href="./style.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="./Video/jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="gVWAgS1lq2qQM53IP7HME+SjdzZAmFKvQMPEew==";</script>
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
			<li class="current_page_item"><a href="./Index.php">Home</a></li>
			<li><a href="./Gildenregeln.php">Gildenregeln</a></li>
			<li><a href="#">Bewerbung</a>
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
				<div id="content">
					<div class="post">
						<div id="img_willkommen">
										<div id="myElement">Loading the player...</div>

										<script type="text/javascript">
											jwplayer("myElement").setup({
												file: "./Video/IM.flv",
												image: "./img/Site/WelcomeLogo.png"
											});
										</script>
										<br /><br />
						</div>						
						<div id="message_willkommen">
						<?php ForEach($SeitenInformationarray as $SeitenInformation )
						{ ?>
							<div id="willkommen_start"><?= $SeitenInformation['LoginOben']?>	
							</div>
							<div id="willkommen_mitte"><?= $SeitenInformation['LoginMitte']?> 
							</div>
							<div id="willkommen_ende"><?= $SeitenInformation['LoginUnten']?>	
							</div>
						<?php } ?>
						</div>
					</div>
					<div style="clear: both;">&nbsp;</div>
				</div>
				<div id="sidebar">
					<ul>
						<li>
							<div class="sidebar_anzeige">
								<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
									<div id="Login_anzeige">
										<img id="img_user" src="./img/site/Content_Hintergrundbalken_Blanko.png" alt="" />
										<div id="USER_NAME"><h2 id="img_user_name">Login</h2></div>
										<img id="Rahmen_Login" src="./img/site/Rahmen_Raidfortschritt.png" alt=""/>
											<div id="Login_Eingabe">
												<div id="E-Mail_Eingabe">
													<div id="n_text"><label for="login">E-Mail:</label></div>
													<div id="n_eingabe"><input type="text" id="login" name="login" /></div>
												</div>
												<div id="Passwort_Eingabe">
													<div id="p_text"><label for="passwd">Passwort:</label></div>
													<div id="p_eingabe"><input type="password" id="passwd" name="passwd" />
												</div>
											</div>
											<div id="L_Button">
												<input type="submit" name="Login_Button" value="Anmelden" />
											</div>
											<div id="cookie">
												<input type="checkbox" id="cookie_cb" name="cookie_setzen" value="cookie_setzen"/>
												automatischer Login
											</div>
										</div>
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
<div id="footer">
<?php echo $create=print_create_validate();?>
</div>

</body>
</html>
