<?php
  /****************************
   *Einbindung fremder Dateien*
   ****************************/
    require_once "./src/my_funcs.inc";
    include "./src/db.inc";
	include './Forum/config.php';
	include './Forum/functions.php';

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
	$UserId = $_SESSION['User_ID'];
	$Beitrag="";
	$zaehlergelesen = 1;
	$KID = array();
	$TID = array();
	$FID = array();
  /***************************
   *Beginn des Hauptprogramms*
   ***************************/
   $timestamp = time();
   $datenbank->Useronline($_SESSION['User_ID'], $timestamp);
    if (isset($_POST['Best_Button']))
	{
			$get_cats = 'SELECT * FROM `forum_categories` WHERE `active` = 1 && `type` = 0 ORDER BY `position`'; // SQL-Query zum Abfragen der Hauptkategorien
			$res = $db->query($get_cats);
			if($res->num_rows)
			{
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
								$get_Beitrag1 = 'SELECT ID FROM forum_posts WHERE tid = '.$f_Thread['ID'].' && fid = '.$sub['ID'].' ORDER BY ID DESC' ;
								$Beitrag1 = $db->query($get_Beitrag1);
								$f_Beitrag1 = $Beitrag1->fetch_assoc();
								$get_anwesend = 'SELECT Thread_ID FROM `forum_gelesen` WHERE Kategorie_ID = '.$sub['ID'].' && Forum_ID = '.$f_Thread['ID'].' && User_ID = '.$_SESSION['User_ID'].' ORDER BY Thread_ID DESC';
								$anwesend = $db->query($get_anwesend);
								$f_anwesend = $anwesend->fetch_assoc();
								if ($f_anwesend['Thread_ID'] == $f_Beitrag1['ID'])
								{
								}
								else
								{
									$sql = 'INSERT INTO `forum_gelesen` (Forum_ID, Thread_ID, Kategorie_ID, User_ID) VALUES (\''.$f_Thread['ID'].'\', \''.$f_Beitrag1['ID'].'\', \''.$sub['ID'].'\', \''.$UserId.'\')';
									$db->query($sql);
									
								}
							}
						}
					}
				}
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
<link href="./forum.css" rel="stylesheet" type="text/css" media="screen" />
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
					<li><a href="https://www.facebook.com/groups/515150171884119/">Facebook</a></li>
					<li><a href="./owncloud/">OwnCloud</a></li>
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
					<div class="forum">
						<?php
							$get_cats = 'SELECT * FROM `forum_categories` WHERE `active` = 1 && `type` = 0 ORDER BY `position`'; // SQL-Query zum Abfragen der Hauptkategorien
							$res = $db->query($get_cats); // Speichert das Ergebnis des oberen Querys in $res
								
							if($res->num_rows) 
							{	// Falls Kategorien existieren
								$Tags = 'Bei der Eingabe von TAG`s, werden diese unbrauchbar gemacht';
								while($row = $res->fetch_assoc()) {
								if ($row['ID'] != 47)
								{
									echo '<div class="black_border">
										  <div class="white_border"><div class="main_cat">'.$row['name'].'</div>';
									$subs = 'SELECT * FROM `forum_categories` WHERE `main_categorie` = '.$row['ID'].' && `type` = 1 && `active` = 1 ORDER BY `position`'; // Sucht beschreibbare Foren
									$sub_res = $db->query($subs);
									$counter = 0; // Zähler-Variable
									while($sub = $sub_res->fetch_assoc())
									{										
										switch($counter)
										{ // Sorgt für "Zebra-Effekt"
											case 0: $bg = '#e6e6e6'; // Wenn Zähler-Variable auf 0, dann Zeilenhintergrund = #363636
												$counter++; // Zähler-Variable + 1
												break;
											case 1: $bg = '#d9d9d9'; // Wenn Zähler-Variable auf 1, dann Zeilenhintergrund = #d9d9d9
												$counter--; // Zähler-Variable - 1
												break;
										}
										if ($row['ID'] == 45)
										{
											$get_Thread = "SELECT ID FROM forum_threads_archiv WHERE fid = ".$sub['ID'];
											$Thread = $db->query($get_Thread);
											$Zaehlerthreads = 0;
											$Zaehlergleich = 0;
											while($f_Thread = $Thread->fetch_assoc())
											{
												$get_Beitrag = 'SELECT ID FROM forum_posts_archiv WHERE tid = '.$f_Thread['ID'].' && fid = '.$sub['ID'] ;
												$Beitrag = $db->query($get_Beitrag);
												
											}
											?>
											<div style="background-color: <?php echo $bg; ?>;">
											<div class="sub_cat_a">
												<img style="float: left; margin-right: 10px;" src="./img/Site/<?php echo $Beitrag?>.png" width="50" height="30" alt="" />
												<a href="./showthreads_archiv.php?fid=<?php echo $sub['ID'] ; ?>" style="color: #000; text-decoration: none;"><?php echo $sub['name']; ?>&raquo;</a>
												<br />
												<div class="description">
															<?php echo $sub['description']; // Beschreibung des Forums ?> 
												</div>
											</div>
											<div class="sub_cat_b">
											<?php
												$latest_post = 'SELECT * FROM `forum_posts_archiv` ORDER BY `ID` DESC LIMIT 1'; // letzen Beitrag auslesen
												$result = $db->query($latest_post); 
												if(!$result->num_rows)
												{ // Falls keine Beiträge vorhanden sind
													echo 'Keine Beitr&auml;ge vorhanden';
												}
												else
												{
													$post = $result->fetch_assoc(); // Letzen Beitrag in $post speichern
													$get_topic = 'SELECT `topic`, `fid`, `ID` FROM `forum_threads_archiv` '; // dazugehöriges Thema für Link finden
													$t_res = $db->query($get_topic);
													$topic = $t_res->fetch_assoc();
													echo 'Letzter Beitrag in <a href="./showposts_archiv.php?fid='.$topic['fid'].'&amp;tid='.$topic['ID'].'">';
													if(strlen($topic['topic']) >= 15)
													{ // Kürzen, falls Titel länger als 14 Zeichen
														echo substr($topic['topic'], 0, 15).'...</a>';
													}
													else
													{
														echo $topic['topic'].'</a>';
													}
													$username = $datenbank->Get_Username($post['User_ID']);
													echo ' von '.$username.' am '.convertdate($post['created']); // Hier wandelt convertdate() unseren timestamp in eine "normale" Angabe um
												}
												?>
											</div>
											<div style="clear: left;"></div>
										</div>
										<?php
										}
										else
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
													$get_Beitrag1 = 'SELECT ID FROM forum_posts WHERE tid = '.$f_Thread['ID'].' && fid = '.$sub['ID'].' ORDER BY ID DESC' ;
													$Beitrag1 = $db->query($get_Beitrag1);
													$f_Beitrag1 = $Beitrag1->fetch_assoc();
													$get_anwesend = 'SELECT Thread_ID FROM `forum_gelesen` WHERE Kategorie_ID = '.$sub['ID'].' && Forum_ID = '.$f_Thread['ID'].' && User_ID = '.$_SESSION['User_ID'].' ORDER BY Thread_ID DESC';
													$anwesend = $db->query($get_anwesend);
													$f_anwesend = $anwesend->fetch_assoc();
													if ($f_anwesend['Thread_ID'] == $f_Beitrag1['ID'])
													{
														$Zaehlergleich++;
													}
													else
													{
														$KID[] = $sub['ID'];
														$TID[] = $f_Beitrag1['ID'];
														$FID[] = $f_Thread['ID'];
														$zaehlergelesen++;
													}
												}
											}
											if ($Zaehlergleich == $Zaehlerthreads )
											{
												$Beitrag="ForenLogokeinNeuerBeitrag";
											}
											else
											{
												$Beitrag="ForenLogoNeuerBeitrag";
											}
											?>
											<div style="background-color: <?php echo $bg; ?>;">
											<div class="sub_cat_a">
												<img style="float: left; margin-right: 10px;" src="./img/Site/<?php echo $Beitrag?>.png" width="50" height="30" alt="" />
												<a href="./showthreads.php?fid=<?php echo $sub['ID'] ; ?>" style="color: #000; text-decoration: none;"><?php echo $sub['name']; ?>&raquo;</a>
												<br />
												<div class="description">
															<?php echo $sub['description']; // Beschreibung des Forums ?> 
												</div>
											</div>
											<div class="sub_cat_b">
											<?php
												$latest_post = 'SELECT * FROM `forum_posts` WHERE `fid` = '.$sub['ID'].' ORDER BY `ID` DESC LIMIT 1'; // letzen Beitrag auslesen
												$result = $db->query($latest_post); 
												if(!$result->num_rows)
												{ // Falls keine Beiträge vorhanden sind
													echo 'Keine Beitr&auml;ge vorhanden';
												}
												else
												{
													$post = $result->fetch_assoc(); // Letzen Beitrag in $post speichern
													$get_topic = 'SELECT `topic`, `fid`, `ID` FROM `forum_threads` WHERE `ID` = '.$post['tid'].''; // dazugehöriges Thema für Link finden
													$t_res = $db->query($get_topic);
													$topic = $t_res->fetch_assoc();
													echo 'Letzter Beitrag in <a href="./showposts.php?fid='.$topic['fid'].'&amp;tid='.$topic['ID'].'">';
													if(strlen($topic['topic']) >= 15)
													{ // Kürzen, falls Titel länger als 14 Zeichen
														echo substr($topic['topic'], 0, 15).'...</a>';
													}
													else
													{
														echo $topic['topic'].'</a>';
													}
													$username = $datenbank->Get_Username($post['User_ID']);
													echo ' von '.$username.' am '.convertdate($post['created']); // Hier wandelt convertdate() unseren timestamp in eine "normale" Angabe um
												}
												?>
											</div>
											<div style="clear: left;"></div>
										</div>
										<?php
										}
									}
								}
								elseif ($row['ID'] == 47 or $row['ID'] = 48)
									{	
										if ($Status == "admin")
										{
											if ($row['ID'] == 47 or $row['ID'] = 48)
											{
												echo '<div class="black_border">
												  <div class="white_border"><div class="main_cat">'.$row['name'].'</div>';
										
											
												$subs = 'SELECT * FROM `forum_categories` WHERE `main_categorie` = '.$row['ID'].' && `type` = 1 && `active` = 1 ORDER BY `position`'; // Sucht beschreibbare Foren
												$sub_res = $db->query($subs);
												
												$counter = 0; // Zähler-Variable
												
												while($sub = $sub_res->fetch_assoc())
												{										
													switch($counter) 
													{ // Sorgt für "Zebra-Effekt"
														case 0: $bg = '#e6e6e6'; // Wenn Zähler-Variable auf 0, dann Zeilenhintergrund = #363636
															$counter++; // Zähler-Variable + 1
																break;
														case 1: $bg = '#d9d9d9'; // Wenn Zähler-Variable auf 1, dann Zeilenhintergrund = #d9d9d9
															$counter--; // Zähler-Variable - 1
																break;
													}
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
													$get_Beitrag1 = 'SELECT ID FROM forum_posts WHERE tid = '.$f_Thread['ID'].' && fid = '.$sub['ID'].' ORDER BY ID DESC' ;
													$Beitrag1 = $db->query($get_Beitrag1);
													$f_Beitrag1 = $Beitrag1->fetch_assoc();
													$get_anwesend = 'SELECT Thread_ID FROM `forum_gelesen` WHERE Kategorie_ID = '.$sub['ID'].' && Forum_ID = '.$f_Thread['ID'].' && User_ID = '.$_SESSION['User_ID'].' ORDER BY Thread_ID DESC';
													$anwesend = $db->query($get_anwesend);
													$f_anwesend = $anwesend->fetch_assoc();
													if ($f_anwesend['Thread_ID'] == $f_Beitrag1['ID'])
													{
														$Zaehlergleich++;
													}
													else
													{
														$KID[] = $sub['ID'];
														$TID[] = $f_Beitrag1['ID'];
														$FID[] = $f_Thread['ID'];
														$zaehlergelesen++;
													}
												}
											}
											if ($Zaehlergleich == $Zaehlerthreads )
											{
												$Beitrag="ForenLogokeinNeuerBeitrag";
											}
											else
											{
												$Beitrag="ForenLogoNeuerBeitrag";
											}
											?>
												
											  
												<div style="background-color: <?php echo $bg; ?>;">
													<div class="sub_cat_a">
															<img style="float: left; margin-right: 10px;" src="./img/Site/<?php echo $Beitrag?>.png" width="50" height="30" alt="" />
															<a href="./showthreads.php?fid=<?php echo $sub['ID'] ; ?>" style="color: #000; text-decoration: none;"><?php echo $sub['name']; ?>&raquo;</a>
																<br />
														<div class="description">
															<?php echo $sub['description']; // Beschreibung des Forums ?> 
														</div>
													</div>
													
													<div class="sub_cat_b">
														<?php
														$latest_post = 'SELECT * FROM `forum_posts` WHERE `fid` = '.$sub['ID'].' ORDER BY `ID` DESC LIMIT 1'; // letzen Beitrag auslesen
														$result = $db->query($latest_post); 
														
														if(!$result->num_rows) { // Falls keine Beiträge vorhanden sind
															echo 'Keine Beitr&auml;ge vorhanden';
														  } else {
															$post = $result->fetch_assoc(); // Letzen Beitrag in $post speichern
															  $get_topic = 'SELECT `topic`, `fid`, `ID` FROM `forum_threads` WHERE `ID` = '.$post['tid'].''; // dazugehöriges Thema für Link finden
															  $t_res = $db->query($get_topic);
																$topic = $t_res->fetch_assoc();
															  echo 'Letzter Beitrag in <a href="./showposts.php?fid=48&tid='.$topic['ID'].'">';
															  if(strlen($topic['topic']) >= 15) { // Kürzen, falls Titel länger als 14 Zeichen
																echo substr($topic['topic'], 0, 15).'...</a>';
															  } else {
																echo $topic['topic'].'</a>';
															  }
															  $username = $datenbank->Get_Username($post['User_ID']);
															  echo ' von '.$username.' am '.convertdate($post['created']); // Hier wandelt convertdate() unseren timestamp in eine "normale" Angabe um
														  
														  }
															?>
														</div>
														<div style="clear: left;"></div>
													</div>
													  
													  <?php
													
												}	
											}
										}
									}
								
								echo '</div></div><br />';
								}
							} else {
							$Tags = '<br />
									 <br />
									 Forum in Bearbeitung';
							}
						?>
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" id="Beitraegegelesen">	
							<div id="gelesen_text"><label>Alle Beitr&auml;ge als gelesen markieren:</label></div>
							<div><input  type="submit" name="Best_Button" value="" class="submit-button" /></div>
						</form>
						<div id="Legende">
							<img style="float: left; margin-right: 10px;" src="./img/Site/ForenLogokeinNeuerBeitrag.png" width="60" height="35" alt="" />
							<h4 class="Legende_Text"> Forum Beitrag wurde gelesen.</h4>
							<img style="float: left; margin-right: 10px;" src="./img/Site/ForenLogoNeuerBeitrag.png" width="60" height="35" alt="" />
							<h4 class="Legende_Text"> Es wurde ein neuer Beitrag verfasst.</h4>
						</div>
						<div id="Legende_Sticky">
							<img style="float: left; margin-right: 17px; margin-left: -3px;" src="./img/Site/sticky_gelesen.png" width="48" height="35" alt="" />
							<h4 class="Legende_TextStickyGelesen"> Sticky, Forum Beitrag wurde gelesen.</h4>
							<img style="float: left; margin-right: 22px;" src="./img/Site/sticky_ungelesen.png" width="40" height="32" alt="" />
							<h4 class="Legende_TextSticky"> Sticky, es wurde ein neuer Beitrag verfasst.</h4>
						</div>
						<br />
						<div><h4 style="margin-left: 40px; width:665px;"><?php echo $Tags;?></h4></div>
					</div>
					<div style="clear: both;">&nbsp;</div>
				</div>
				<div style="clear: both;"></div>
	</div>

</div>
</body>
</html>
						<?php
							
						?>						
						