<?php
    include './Forum/config.php';
    include './Forum/dbconfig.php';
	include './Forum/functions.php';
    require_once "./src/my_funcs.inc";
	include "./src/dbadmin.inc";
	include "./src/db.inc";
    debugging( false );
    init_session();
	user_pruefen();
	$error="";
	$table="";
	$dbconn = Connect_DB();
	$Datenbank = new Datenbank();
	$Status = $Datenbank->Get_Status($_SESSION['User_ID']);
	if($Status!='admin')
	{
		header("Location: ./login.php");
	}
	if (isset($_POST['delete']))
	{
		if(isset($_POST['loeschen1']))
		{
			$ID=(int)$_POST['loeschen1'];
			$sql = 'DELETE FROM forum_categories
					WHERE ID = '.$ID.';';
			$db->query($sql);
		}
		if(isset($_POST['loeschen']))
		{
			$ID=(int)$_POST['loeschen'];
			$sql = 'DELETE FROM forum_threads
					WHERE ID = '.$ID.';';
			$db->query($sql);
		}
		if(isset($_POST['sticky']))
		{
		$ID = (int)$_POST['sticky'];
		$sql = "UPDATE forum_threads SET Sticky = 1 WHERE ID = ".$ID.";";
		$db->query($sql);
		}
		if(isset($_POST['closed']))
		{
		$ID = (int)$_POST['closed'];
		$sql = "DELETE from forum_threads WHERE ID = ".$ID.";";
		$db->query($sql);
		$sql = "DELETE from forum_posts WHERE tid = ".$ID.";";
		$db->query($sql);
		}
		if(isset($_POST['stickyentfernen']))
		{
		$ID = (int)$_POST['stickyentfernen'];
		$sql = "UPDATE forum_threads SET Sticky = 0 WHERE ID = ".$ID.";";
		$db->query($sql);
		}
	}
	if(isset($_POST['anzeigen']))
	{
		header('Location: ./overview.php');
	}
	$timestamp = time();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Imperial-March - Admin</title>
<link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Wallpoet" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Graduate" rel="stylesheet" type="text/css"/>
<link href="./styleadmin.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
	<div id="wrapper">
		<div id="menu">
			<ul>
					<li><a href="./Login.php">Home</a></li>
					<li><a href="./overview.php">Forum</a></li>
					<li><a href="./raidplaner.php">Raidplaner</a></li>
					<li><a href="./News.php">News</a></li>
					<li><a href="./Gildenregeln.php">Gildenregeln</a></li>
					<li><a href="./Bewerbungen.php">Bewerbung</a></li>
					<li><a href="./Pictures.php">Pictures</a></li>
					<li><a href="./Movies.php">Movies</a></li>
					<li><a href="./User.php">User</a></li>
					<li><a href="./Account.php">Account</a></li>
    				<li><a href="./Admin.php">Admin</a></li>
			</ul>
		</div>
	</div>
	<div id="User">
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<hr />
			<h2>Forum archivieren</h2>
				<h4>Per "ausf&uuml;hren" wird eine Sicherung der Datenbank von der Website erstellt und sämtliche Beitr&auml;ge, die älter als 30 Tage sind, werden archiviert. </h4>
				<h4>Die Sicherungsdatei wird hierbei &uuml;berschrieben.</h4>			
				<div><input type="submit" value="ausf&uuml;hren" name="button_forum_archiv" /></div>
				<hr />
			<h2>Forum bearbeiten</h2>
				<h3>Erkl&auml;rung:</h3>
				<table>
				<tr>
				<td>Position:</td>
				<td>Positionsnummer, 1 ganz oben, 999 ganz unten.</td>
				</tr>
				<tr>
				<td>Name:</td>
				<td>Titel der Kategorie/des Forums</td>
				</tr>
				<tr>
				<td>Beschreibung:</td>
				<td>kurze Beschreibung des Forums / F&uuml;r Kategorie freilassen</td>
				</tr>
				<tr>
				<td>Typ:</td>			
				<td>0 = Kategorie; 1 = Forum</td>
				</tr>
				<tr>
				<td>Hauptkategorie:</td>		
				<td>ID der dazugeh&ouml;rigen Kategorie (nicht die Position) / Wird nur f&uuml;r Forum ben&ouml;tigt, nicht f&uuml;r Kategorie</td>
				</tr>
				</table>
				<hr />
			<h3>Beispiel:</h3>
				<table>
				<tr>
				<th>Kategorie</th>
				<th>Forum</th>
				<th>ID</th>	
				<th>Position</th>	
				<th>Typ</th>
				<th>Hauptkategorie</th>	
				</tr>
				<tr>
				<td>Offi-Forum</td>
				<td></td>
				<td>10</td>
				<td>1</td>
				<td>0</td>
				<td></td>
				</tr>
				<tr>
				<td></td>
				<td>Protokoll Offi-Besprechung</td>
				<td></td>
				<td>1</td>
				<td>1</td>
				<td>10</td>
				</tr>
				<tr>
				<td>Guides</td>
				<td></td>
				<td>20</td>
				<td>2</td>
				<td>0</td>
				<td></td>
				</tr>
				<tr>
				<td></td>			
				<td>Raids</td>
				<td></td>
				<td>1</td>
				<td>1</td>
				<td>20</td>
				</tr>
				<tr>
				<td></td>		
				<td>Flashpoints</td>
				<td></td>
				<td>2</td>
				<td>1</td>
				<td>20</td>
				</tr>
				</table>
				<hr />
			<h3>Forum erstellen:</h3>
				<div><label for="admin_forum_position">Position:</label></div>
				<div><input type="text" id="admin_forum_position" name="admin_forum_position" /></div>
				<div><label for="admin_forum_name">Name:</label></div>
				<div><input type="text" id="admin_forum_name" name="admin_forum_name" /></div>
				<div><label for="admin_forum_beschreibung">Beschreibung:</label></div>
				<div><input type="text" id="admin_forum_beschreibung" name="admin_forum_beschreibung" /></div>
				<div><label for="admin_forum_typ">Typ:</label></div>
				<div><input type="text" id="admin_forum_typ" name="admin_forum_typ" /></div>
				<div><label for="admin_forum_kategorie">Hauptkategorie:</label></div>
				<div><input type="text" id="admin_forum_kategorie" name="admin_forum_kategorie" /></div>
				<div><input type="submit" value="ausf&uuml;hren" name="button_forum_erstellen" /></div>
				<hr />
			<?php
			    if (isset($_POST['button_forum_archiv']))
			    {
                    $dbhost     = "localhost";
                    $dbuser     = "root";
                    $dbpwd      = "JK198dre1YotKah";
                    $dbname     = "Forum";
                    $dbbackup   = "./backup/backupforum.sql";
                     
                    error_reporting(0);
                    set_time_limit(0);
                     
                    $conn = mysql_connect($dbhost, $dbuser, $dbpwd) or die(mysql_error());
                    mysql_select_db($dbname);
                    $f = fopen($dbbackup, "w");
                     
                    $tables = mysql_list_tables($dbname);
                    while ($cells = mysql_fetch_array($tables))
                    {
                        $table = $cells[0];
                        fwrite($f,"DROP TABLE `".$table."`;\n");
                        $res = mysql_query("SHOW CREATE TABLE `".$table."`");
                        if ($res)
                        {
                            $create = mysql_fetch_array($res);
                            $create[1] .= ";";
                            $line = str_replace("\n", "", $create[1]);
                            fwrite($f, $line."\n");
                            $data = mysql_query("SELECT * FROM `".$table."`");
                            $num = mysql_num_fields($data);
                            while ($row = mysql_fetch_array($data))
                            {
                                $line = "INSERT INTO `".$table."` VALUES(";
                                for ($i=1;$i<=$num;$i++)
                                {
                                    $line .= "'".mysql_real_escape_string($row[$i-1])."', ";
                                }
                                $line = substr($line,0,-2);
                                fwrite($f, $line.");\n");
                            }
                        }
                    }
                    fclose($f);
                    $datum = time("Y-m-d");
                    $datum = $datum - 2592000;
		            $datum = date("Y-m-d", $datum); 
                    $zeit = date("H:i:s");
                    $date = $datum." ".$zeit;
                    $sql = "SELECT ID, fid, Sticky FROM forum_threads ORDER BY ID ASC";
                    $res = $db->query($sql);
					if($res->num_rows)
					{
						while($row = $res->fetch_assoc())
						{
							$sql = "SELECT ID, created FROM forum_posts WHERE tid =".$row['ID']." ORDER BY created DESC LIMIT 1";
							$res1 = $db->query($sql);
							if ($res1->num_rows)
							{
								while($row1 = $res1->fetch_assoc())
								{
									if ((strtotime($row1['created']) <= strtotime($date)) AND ($row['Sticky'] == 0) )
									{
										if (!($row['fid']==48 or $row['fid']==41))
										{
											$sql = "INSERT INTO forum_threads_archiv SELECT * FROM forum_threads WHERE ID = ".$row['ID'];
											$sql1 = "INSERT INTO forum_posts_archiv SELECT * FROM forum_posts WHERE tid = ".$row['ID'];
											$insert = $db->query($sql);
											$insert1 = $db->query($sql1);
											$sql2 = "DELETE FROM forum_threads WHERE ID = ".$row['ID'];
											$sql3 = "DELETE FROM forum_posts WHERE tid = ".$row['ID'];
											$sql4 = "DELETE FROM forum_gelesen WHERE Forum_ID = ".$row['ID'];
											$delete = $db->query($sql2);
											$delete1 = $db->query($sql3);
											$delete2 = $db->query($sql4);
										}
									}
								}	
							}    	  
						}
					}
					$sql1 = "SELECT User_ID FROM User WHERE Status <> 'deaktiviert'";
					$res1 = $db1->query($sql1);
					$user_arr = array();
					$user = "";
					if($res1->num_rows)
					{
						while($user_ds = $res1->fetch_assoc())
						{
							$user_arr[]=$user_ds;
						}
					}
					foreach($user_arr as $row_user)
					{
						if ($user<>"")
							$user = $user.' ; '.$row_user['User_ID'];
						else
							$user = $row_user['User_ID'];
					}			
					$sql = "SELECT User_ID FROM forum_gelesen ORDER BY User_ID ASC";
					$res = $db->query($sql);
					if($res->num_rows)
					{
						while($row = $res->fetch_assoc())
						{   
							if (strpos($user, $row['User_ID'])==false)
							{
								$sql2 = "DELETE FROM forum_gelesen WHERE User_ID = ".$row['User_ID'];   
								$delete = $db->query($sql2); 
								}
							}
						
					}
				}
				if (isset($_POST['button_forum_erstellen']))
				{
					$aktiv='1';
					$sql = 'INSERT INTO	`forum_categories` (position, name, description, type, main_categorie, active)
							VALUES (\''.$_POST["admin_forum_position"].'\', \''.$_POST["admin_forum_name"].'\', \''.$_POST["admin_forum_beschreibung"].'\',  \''.$_POST["admin_forum_typ"].'\', \''.$_POST["admin_forum_kategorie"].'\', \''.$aktiv.'\');';
					$db->query($sql);
				}
				echo '<div>Das Forum wird beim l&ouml;schen einer Kategorie nicht gel&ouml;scht, aber auch nicht mehr angezeigt. Dieses muss dann von Hand aus der DB gel&ouml;scht werden.<br />
					  Also immer erst das Forum l&ouml;schen, danach die Kategorie, erspart Altlasten in der DB und Arbeit.</div><hr />			
				      <h3>Aufbau des Forums:</h3>
				      <table id="Forumbearbeiten">
					  <tr>
					  <th>ID</th>	
					  <th>Position</th>	
					  <th>Kategorie</th>
					  <th>Forum</th>
					  <th>Beschreibung</th>
					  <th>Thread</th>
					  <th>Sticky</th>
					  <th>L&ouml;schen</th>
					  <th></th>
					  <th></th>
					  </tr>';
				$sql = 'SELECT * FROM `forum_categories` WHERE `active` = 1 && `type` = 0 ORDER BY `position`';
				$res = $db->query($sql);
				if($res->num_rows)
				{
					while($row = $res->fetch_assoc())
					{
						echo '<tr class ="Kategorie">
							  <td>'.$row['ID'].'</td>
					          <td>'.$row['position'].'</td>
							  <td>'.$row["name"].'</td>
							  <td></td>
							  <td></td>
							  <td></td>
							  <td></td>
							  <td></td>
							  <td></td>
							  <td></td>
							  </tr>';
						$subs = 'SELECT * FROM `forum_categories` WHERE `main_categorie` = '.$row['ID'].' && `type` = 1 && `active` = 1 ORDER BY `position`'; 
						$sub_res = $db->query($subs);
						while($sub = $sub_res->fetch_assoc()) {
							echo '<tr class ="Thread">
							  <td>'.$sub['ID'].'</td>
							  <td>'.$sub['position'].'</td>
							  <td></td>
					          <td>'.$sub["name"].'</td>
							  <td>'.$sub["description"].'</td>
							  <td></td>
							  <td></td>
							  <td></td>
							  <td></td>
							  <td></td>
							  </tr>';
							$threads = 'SELECT * FROM forum_threads WHERE fid = '.$sub["ID"].' ORDER BY `Sticky` DESC, `created` DESC';
							$thread_res = $db->query($threads);
							$i = 0;
							while($thread = $thread_res->fetch_assoc()) {
								
								if ($i>1)
									$i = 0;
								echo '<tr class ="Post'.$i.'">
								  <td></td>
								  <td></td>
								  <td></td>
								  <td></td>
								  <td></td>
								  <td>'.$thread['topic'].'</td>
								  <td>';if($thread['Sticky']){echo "gesetzt";} echo '</td>
								  <td><input type="radio"  name="closed" value="'.$thread["ID"].'" />L&ouml;schen</td>
								  <td><input type="radio"  name="sticky" value="'.$thread["ID"].'" />sticky</td>
								  <td><input type="radio"  name="stickyentfernen" value="'.$thread["ID"].'" />sticky entfernen</td>
								  </tr>';
								  $i++;
							}
						}
					}
				}
				echo '</table>';
				echo '<div><input type="submit" value="ausf&uuml;hren" name="delete" /></div>';
			?>
			<hr />
		</form>
	</div>
</body>
</html>