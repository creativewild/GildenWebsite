<?php
include_once './Forum/config.php'; // Datei für DB-Verbindung laden
include_once './Forum/functions.php'; // Datei mit Funktionen laden
$tid = checkinput(trim($_GET['tid']));
$fid = checkinput(trim($_GET['fid']));

function AllePosts($start=0,$eintraege_pro_seite=100000)
{
include_once './Forum/config.php'; // Datei für DB-Verbindung laden
include_once './Forum/functions.php'; // Datei mit Funktionen laden
$tid = checkinput(trim($_GET['tid']));
$fid = checkinput(trim($_GET['fid']));
$datenbank = new Datenbank();
$db = new Datenbank();
	$sql = 'SELECT * FROM `forum_posts` WHERE `fid` = '.$fid.' && tid = '.$tid.' ORDER BY `ID`  LIMIT $start, $eintraege_pro_seite'; // Beiträge auslesen
	$res = $db->query($sql);
	if($res->num_rows)
	{
		while(($row = $res->fetch_assoc("MYSQL_ASSOC")) != false)
		{
			$username = $datenbank->Get_Username($row['User_ID']);
			echo   '<table border="0" cellpadding="0" cellspacing="0" width="1105px;" style="margin-left: 40px;">
  					<tr>
					<td width="961px" valign="top">
						<table border="0" cellpadding="0" cellspacing="0" width="961px" valign="top">
							<tr valign="top">
								<th bgcolor="#AA0000" align="left" valign="top" width="700px;" height="17">&nbsp;&nbsp;<?php echo $row["topic"]; ?></th>
								<th bgcolor="#AA0000" width="150px"><?php echo convertdate($row["created"]); ?></th>
							</tr>
							<tr>
								<td valign="top"><p style="padding-left: 5px;"><?php echo nl2br($row["text"]); // nl2br = \n zu <br> (Bei einem Zeilenumbruch wird in der Datenbank automatisch ein \n eingefügt) ?></p></td>
							</tr>
						</table>  
					</td>
					<td valign="top" width="160px">
					<div style="display:table; padding:0px; table-layout:fixed; text-align:center; width:160px;border-top: 17px solid #AA0000;">
						<div style="margin-top: -17px;">'; 
			       echo $username;
				  echo '</div>
				    </div>';
					if ($_SESSION['User_ID']==$row['User_ID'])
					echo '<a href="updatepost.php?ID='.$row['ID'].'" style="margin-left: 60px;"><img src="./img/site/Forum_Beitrag_bearbeiten.png" alt="" style=" width: 100px; height: auto;" /></a>';
					echo '</td>
					</tr>
					</table>';
			}
			$sql = 'SELECT ID FROM `forum_posts` WHERE `fid` = '.$fid.' && tid = '.$tid.' ORDER BY `ID` DESC';
			$res = $db->query($sql);
			$row = $res->fetch_assoc();
			$get_anwesend = 'SELECT Thread_ID FROM `forum_gelesen` WHERE Kategorie_ID = '.$fid.' && Forum_ID = '.$tid.' && User_ID = '.$_SESSION['User_ID'].' ORDER BY Thread_ID DESC';
			$anwesend = $db->query($get_anwesend);
			$f_anwesend = $anwesend->fetch_assoc();
			if (($row['ID'] != $f_anwesend['Thread_ID']))
			{
				$set_anwesend = 'INSERT INTO `forum_gelesen` (Forum_ID, Thread_ID, Kategorie_ID, User_ID) VALUES (\''.$tid.'\', \''.$row['ID'].'\', \''.$fid.'\',  \''.$_SESSION['User_ID'].'\')';
				$insert=$db->query($set_anwesend);
				if ($insert)
					$fehler='io';
				else
					$fehler='dumm';
			}
			$thread_stat = 'SELECT `closed`, `topic` FROM `forum_threads` WHERE `ID` = '.$tid.''; //SQL-Query: Status und Titel des Themas
			$stat = $db->query($thread_stat);
			$stats = $stat->fetch_assoc();
			if($stats['closed'] == 0)
			{ // Falls Thema nicht geschlossen
			echo'   <hr style="margin-left: 40px; width:1100px;" />
					<form action="answer.php?tid=<?php echo $tid; ?>&amp;fid=<?php echo $fid; ?>" method="post" style="margin-left: 40px; width:665px;">
						<p><strong>Titel:</strong><br /> <input type="text" name="title" value="Re: '; echo $stats["topic"]; echo 'size="30"/></p>
						<p><strong> Beitrag: </strong></p>
						<p><textarea name="message" rows="10" cols="60"></textarea></p>
						<p><input type="hidden" name="tid" value="<?php echo $tid; ?>" /></p>
						<p><input type="hidden" name="fid" value="<?php echo $fid; ?>" /></p>
						<p><input type="submit" name="postit" value="Antworten" /></p>
					</form>
					<div><h4 style="margin-left: 40px; width:665px;">Bei der Eingabe von TAG´s, werden diese unbrauchbar gemacht.</h4></div>';
			} 
		}
	}

function Kategories()
{
		include_once './Forum/config.php'; // Datei für DB-Verbindung laden
		include_once './Forum/functions.php'; // Datei mit Funktionen laden
		$db = new Datenbank();
		$tid = checkinput(trim($_GET['tid']));
		$fid = checkinput(trim($_GET['fid']));
		$get_name = 'SELECT `name` FROM `forum_categories` WHERE `ID` = '.$fid.' && `active` = 1'; //SQL-Query: Name der des Forums auslesen
		$name = $db->query($get_name);
		$f_name = $name->fetch_assoc();
		return f_name;

}

function Thread()
{
		include_once './Forum/config.php'; // Datei für DB-Verbindung laden
		include_once './Forum/functions.php'; // Datei mit Funktionen laden
		$f_name = array();
		$db = new Datenbank();
		$tid = checkinput(trim($_GET['tid']));
		$fid = checkinput(trim($_GET['fid']));
		$get_thread = 'SELECT `topic` FROM `forum_threads` WHERE `ID` = '.$tid.''; //SQL-Query: Titel des Themas auslesen
		$thread = $db->query($get_thread);
		$t_name = $thread->fetch_assoc(); 
		echo '<p style="display: inline;margin-left:40px;"><a href="overview.php">Forum</a> &raquo; <a href="showthreads.php?fid='.$fid.'">'.$f_name['name'].'</a> &raquo; <a href="showposts.php?fid='.$fid.'&amp;tid='.$tid.'">'.$t_name['topic'].'</a>  </p> <br /><br />';
	
	}
?>