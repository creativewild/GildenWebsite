<?php
  /****************************
   *Einbindung fremder Dateien*
   ****************************/
    require_once "./src/my_funcs.inc";
    include "./src/db.inc";
    include "./src/dbadmin.inc";
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
	$db = new Datenbank();
	$dbconn = Connect_DB();
	$Status = $db->Get_Status($_SESSION['User_ID']);
	$Raids = array();
	// Wenn kein Monat ?bergeben wird, gehen wir von dem aktuellen aus
    $month = isset($_GET['month']) ? intval($_GET['month']) : date('n');
 
    // Wenn kein Jahr ?bergeben wird, gehen wir von dem aktuellen aus
    $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
    $Teilnahme = "4";
    $TeilnehmerArray = array();
    $Bestaetigt = 0;
    $Angemeldet = 0;
    $Ersatz = 0;
    $Abgemeldet = 0;
  /***************************
   *Beginn des Hauptprogramms*
   ***************************/
    // Wochentage (Bei den meisten Servern liefert die PHP Funktion englische Namen)
    $weekdays = array('So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa');
 
    // Monatsnamen (Bei den meisten Servern liefert die PHP Funktion englische Namen)
    $months = array(
      '01' => 'Januar',
      '02' => 'Februar',
      '03' => 'M&auml;rz',
      '04' => 'April',
      '05' => 'Mai',
      '06' => 'Juni',
      '07' => 'Juli',
      '08' => 'August',
      '09' => 'September',
      '10' => 'Oktober',
      '11' => 'November',
      '12' => 'Dezember'
    );
    // Anzahl der Tage im Monat
    $total_days = date('t', mktime(0, 0, 0, $month, 1, $year));
     
    // Den ersten Tag des Monats auf den richtigen Wochentag ausrichten
    $day_offset = date('w', mktime(0, 0, 0, $month, 1, $year));
    
    
    // Aktuellen Tag, Monat und Jahr bestimmmen
    list($n_month, $n_year, $n_day) = explode(', ', strftime('%m, %Y, %d'));

    // Berechnen von dem vorherigen Monat
    list($n_prev_month, $n_prev_year) = explode(', ', strftime('%m, %Y', mktime(0, 0, 0, $month - 1, 1, $year)));
     
    // Berechnen von dem kommenden Monat
    list($n_next_month, $n_next_year) = explode(', ', strftime('%m, %Y', mktime(0, 0, 0, $month + 1, 1, $year)));
    $Raids = GetRaidplanerAktuellerMonat($dbconn, $month, $year); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Imperial-March - Raidplaner</title>
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
			 <li><a href="./login.php">Home</a></li>
             <li><a href="./overview.php">Forum</a></li>
             <li class="current_page_item"><a href="./raidplaner.php">Raidplaner</a></li>
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
				<div id="content_bewerbung_user">
					<div class="post">
						<h2 class="title"></h2>
						<div id="Raidplaneranzeigen">
                        	<div id = "RaidKalender">
                            <table summary="Raidplaner">
                              <thead>
                                <tr>
                                  <th><a href="?month=<?php echo $n_prev_month;?>&amp;year=<?php echo $n_prev_year;?>" title="">&laquo;</a></th>
                                  <th colspan="5"><?php echo $months[strftime('%m', mktime(0, 0, 0, $month, 1, $year))];?> <?php echo $year;?></th>
                                  <th><a href="?month=<?php echo $n_next_month;?>&amp;year=<?php echo $n_next_year;?>" title="">&raquo;</a></th>
                                </tr>
                                <tr>
                                  <?php foreach($weekdays as $weekday):?>
                                    <th><?php echo $weekday;?></th>
                                  <?php endforeach;?>
                                </tr>
                              </thead>
                              <tbody>
                                    <tr>  
                                        <?php // Erste Woche mit leeren Zeilen ausf?llen, wenn der erste Tag kein Montag ist 
                                            if ($month > $n_month or $year > $n_year)
                                            {
                                                if($day_offset > 0):
                                                    for($i = 0; $i < $day_offset; $i++):
                                                        echo '<td class="empty-cell">&nbsp;</td>';
                                                endfor;
                                            endif;
                                            for($day = 1; $day <= $total_days; $day++):

                                                $class = array();
                                                $class[] = 'nottoday';?>
                                                <td id="day-<?php echo $day;?>" class="<?php echo implode(' ', $class);?>">
                                                        <a class="LinkRaid" href="./Raids.php?d=<?php echo $day;?>&amp;m=<?php echo $month;?>&amp;y=<?php echo $year;?>"><?php echo $day;?></a>
                                                </td>
                                                <?php 
                                                $day_offset++;
                                                if($day_offset == 7):
                                                    $day_offset = 0;
                                                    if($day < $total_days):
                                                    echo '</tr>
                                                          <tr>';
                                                    endif;
                                                endif;
                                            endfor;
                                            if($day_offset > 0):
                                                $day_offset = 7 - $day_offset;
                                            endif;
                                            if($day_offset > 0):
                                                for($i = 0; $i < $day_offset; $i++):
                                                    echo '<td class="empty-cell">&nbsp;</td>';
                                                endfor;
                                            endif;
                                            }
                                            if ($month < $n_month and $year <= $n_year )
                                            {
                                                if($day_offset > 0):
                                                    for($i = 0; $i < $day_offset; $i++):
                                                        echo '<td class="empty-cell">&nbsp;</td>';
                                                endfor;
                                            endif;
                                            for($day = 1; $day <= $total_days; $day++):

                                                $class = array();
                                                $class[] = 'nottoday';
                                                echo '<td id="day-'.$day.'" class="'.implode(' ', $class).'" style="color:red;">'.$day.'</td>';
                                                $day_offset++;
                                                if($day_offset == 7):
                                                    $day_offset = 0;
                                                    if($day < $total_days):
                                                    echo '</tr>
                                                          <tr>';
                                                    endif;
                                                endif;
                                            endfor;
                                            if($day_offset > 0):
                                                $day_offset = 7 - $day_offset;
                                            endif;
                                            if($day_offset > 0):
                                                for($i = 0; $i < $day_offset; $i++):
                                                    echo '<td class="empty-cell">&nbsp;</td>';
                                                endfor;
                                            endif; 
                                            }  
                                        ?>
                                            <?php if ($month == $n_month)
                                            {
                                                if($day_offset > 0):?>
                                                <?php for($i = 0; $i < $day_offset; $i++):?>
                                                    <td class="empty-cell">&nbsp;</td>
                                                <?php endfor;?>
                                            <?php endif;?>
                                        <?php // Die Tage ausgeben ?>
                                            <?php for($day = 1; $day <= $total_days; $day++):?>
                                                <?php $class = array();?>
                                                <?php // Wenn das aktuelle Datum dem "Schleifeninhalt" entspricht ?>
                                                    <?php if(($n_month == $month) && ($n_year == $year) && ($day == $n_day)):?>
                                                        <?php $class[] = 'today';?>
                                                    <?php endif;?>
                                                    <?php if(($n_month != $month) or ($n_year != $year) or ($day != $n_day)):?>
                                                        <?php $class[] = 'nottoday';?>
                                                    <?php endif;?>
                                                    <?php if($n_day <= $day)
                                                    {?>
                                                        <td id="day-<?php echo $day;?>" class="<?php echo implode(' ', $class);?>">
                                                        <a class="LinkRaid" href="./Raids.php?d=<?php echo $day;?>&amp;m=<?php echo $month;?>&amp;y=<?php echo $year;?>"><?php echo $day;?></a>
                                                        </td>
                                                    <?php 
                                                    }
                                                    else
                                                    {?>
                                                        <td id="day-<?php echo $day;?>" class="<?php echo implode(' ', $class);?>" style="color:red;"><?php echo $day;?></td>
                                                    <?php     
                                                    }?>
                                                    <?php $day_offset++;?>
                                                    <?php // F?r neue Woche eine neue Zeile beginnen ?>
                                                    <?php if($day_offset == 7):?>
                                                        <?php $day_offset = 0;?>
                                                        <?php if($day < $total_days):?>
                                     </tr>
                                     <tr>                                                                              
                                     
                                                        <?php endif;?>
                                                    <?php endif;?>
                                            <?php endfor;?>
                                            <?php if($day_offset > 0):?>
                                                <?php $day_offset = 7 - $day_offset;?>
                                            <?php endif;?>
                                            <?php // Letzte Woche mit leeren Zeilen ausf?llen ?>
                                            <?php if($day_offset > 0):?>
                                                <?php for($i = 0; $i < $day_offset; $i++):?>
                                                    <td class="empty-cell">&nbsp;</td>
                                                <?php endfor;?>
                                            <?php endif;
                                            }
                                            ?>           
                                    </tr>
                               </tbody>
                            </table>
                            </div>
                        </div>
                        <div id="RaidMonat">
                            <table id="Raidplaner_Anzeige_Raids" cellspacing="0">
                                <tr>
                                    <th style="text-align: center; width: 70px;">Tag</th>
                                    <th style="text-align: center; width: 50px;">Zeit</th>
                                    <th style="text-align: center; width: 155px;">Raid</th>
                                    <th style="text-align: center; width: 150px;">Raidgruppe</th>
                                    <th style="text-align: center; width: 90px;">Raidleiter</th>
                                    <th style="text-align: center; width: 80px;">Best&auml;tigt</th>
                                    <th style="text-align: center; width: 80px;">Angemeldet</th>
                                    <th style="text-align: center; width: 80px;">Ersatz</th>
                                    <th style="text-align: center; width: 80px;">Abgemeldet</th>
                                    <th></th>
                                </tr>
                                <?php   
                                    foreach($Raids as $Raid)
                                    {
					$Bestaetigt = 0;
					$Angemeldet = 0;
					$Ersatz = 0;
					$Abgemeldet = 0;
                                        $Raiddatum = $Raid['Jahr'].$Raid['Monat'].$Raid['Tag'];
                                        $aktuellesDatum =  $n_year.$n_month.$n_day;
                                        if ($Raid['Jahr']<=$n_year and $Raid['Monat'] <= $n_month and $Raid['Tag'] < $n_day )
                                        {
                                            ?>
                                            <tr style="text-decoration: line-through; color:red; margin-top: 5px; ">
                                            <?php
                                                echo'<td style="text-align: center;">';
                                                    echo $Raid['Tag'].'.'.$Raid['Monat'].'.'.$Raid['Jahr'];
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Raid['Uhrzeit'];  
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Raid['Raid'].' ['.$Raid['Modus'].']';
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Raid['Gruppe'];
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Raid['Raidleiter'];
                                                echo'</td>';
                                                $TeilnehmerArray =GetRaidteilnehmer($dbconn, $Raid['ID']);
                                                foreach($TeilnehmerArray as $Teilnehmer)
                                                {
                                                    if ($Teilnehmer['Teilnahme'] == 1)
                                                        $Bestaetigt++;
                                                    if ($Teilnehmer['Teilnahme'] == 2)
                                                        $Angemeldet++;
                                                    if ($Teilnehmer['Teilnahme'] == 3)
                                                        $Ersatz++;
                                                    if ($Teilnehmer['Teilnahme'] == 4)
                                                        $Abgemeldet++;
                                                }
                                                echo'<td style="text-align: center;">';
                                                    echo $Bestaetigt;
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Angemeldet;
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Ersatz;
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Abgemeldet;
                                                echo'</td>';
                                            echo'</tr>';
                                            echo'<tr><td style=" height: 5px;"></td><td></td><td></td><td></td><td></td></tr>';
                                            
                                        }
                                        elseif ($Raid['Jahr']<=$n_year and $Raid['Monat'] < $n_month )
                                        {
                                            ?>
                                            <tr style="text-decoration: line-through; color:red; margin-top: 5px; ">
                                            <?php
                                                echo'<td style="text-align: center;">';
                                                    echo $Raid['Tag'].'.'.$Raid['Monat'].'.'.$Raid['Jahr'];
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Raid['Uhrzeit'];
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Raid['Raid'].' ['.$Raid['Modus'].']';
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Raid['Gruppe'];
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Raid['Raidleiter'];
                                                echo'</td>';
                                                $TeilnehmerArray =GetRaidteilnehmer($dbconn, $Raid['ID']);
                                                foreach($TeilnehmerArray as $Teilnehmer)
                                                {
                                                    if ($Teilnehmer['Teilnahme'] == 1)
                                                        $Bestaetigt++;
                                                    if ($Teilnehmer['Teilnahme'] == 2)
                                                        $Angemeldet++;
                                                    if ($Teilnehmer['Teilnahme'] == 3)
                                                        $Ersatz++;
                                                    if ($Teilnehmer['Teilnahme'] == 4)
                                                        $Abgemeldet++;
                                                }
                                                echo'<td style="text-align: center;">';
                                                    echo $Bestaetigt;
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Angemeldet;
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Ersatz;
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Abgemeldet;
                                                echo'</td>';
                                            echo'</tr>';
                                            echo'<tr><td style=" height: 5px;"></td><td></td><td></td><td></td><td></td></tr>';

                                        }
                                        else
                                        {
                                            $Bestaetigt = 0;
                                            $Angemeldet = 0;
                                            $Ersatz = 0;
                                            $Abgemeldet = 0;
                                            $color = 'grey';
                                            $Teilnahme = "";
                                            $Teilnahme = $db->GetRaidTeilnahme($_SESSION['User_ID'], $Raid['ID']);
                                            
                                            if ($Teilnahme >= 0)
                                            {
                                                switch($Teilnahme)
                                                {
                                                    case 1 :
                                                        $color = 'green';
                                                        break;
                                                    case 2 :
                                                        $color = 'yellow';
                                                        break;
                                                    case 3 :
                                                        $color = 'purple';
                                                        break;
                                                    case 4 :
                                                        $color = 'red';
                                                        break;
                                                }
                                            }
                                            ?>
                                            <tr onclick="window.location.href = 'Raids.php?id=<?php echo $Raid['ID'];?>'" style="color: black; cursor: pointer; background-color:<?php echo $color;?> ;">
                                                                                    
                                            <?php
                                            
                                                echo'<td style="text-align: center;">';
                                                    echo $Raid['Tag'].'.'.$Raid['Monat'].'.'.$Raid['Jahr'];
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Raid['Uhrzeit'];
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Raid['Raid'].' ['.$Raid['Modus'].']';
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Raid['Gruppe'];
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Raid['Raidleiter'];
                                                echo'</td>';
                                                $TeilnehmerArray =GetRaidteilnehmer($dbconn, $Raid['ID']);
                                                foreach($TeilnehmerArray as $Teilnehmer)
                                                {
                                                    if ($Teilnehmer['Teilnahme'] == 1)
                                                        $Bestaetigt++;
                                                    if ($Teilnehmer['Teilnahme'] == 2)
                                                        $Angemeldet++;
                                                    if ($Teilnehmer['Teilnahme'] == 3)
                                                        $Ersatz++;
                                                    if ($Teilnehmer['Teilnahme'] == 4)
                                                        $Abgemeldet++;
                                                }
                                                echo'<td style="text-align: center;">';
                                                    echo $Bestaetigt;
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Angemeldet;
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Ersatz;
                                                echo'</td>';
                                                echo'<td style="text-align: center;">';
                                                    echo $Abgemeldet;
                                                echo'</td>';
                                            echo'</tr>';
                                            echo'<tr><td style=" height: 5px;"></td><td></td><td></td><td></td><td></td></tr>';
                                            $color='grey';
                                            
                                        }
                                    }
    							?>
    						</table>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>