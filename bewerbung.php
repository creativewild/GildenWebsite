<?php
  /****************************
   *Einbindung fremder Dateien*
   ****************************/
    require_once "./src/my_funcs.inc";
    include "./src/db.inc";

  /***********
   *Debugging*
   ***********/
    debugging( false );

  /***********
   *Variablen*
   ***********/
  $error=null;
  $table=null;
  $db = new Datenbank();
  /************
   *Funktionen*
   ************/

  function eingabecheck()
  {
    if (true)
      return true;
    else
      return false;
  }

  /***************************
   *Beginn des Hauptprogramms*
   ***************************/
  //Abbruch Button
  if (isset($_POST['A_Button_bewerbung'])) 
  {
	header('Location: ./index.php');
  }

  //Registrieren Button	
  if (isset($_POST['Be_Button_bewerbung']))
  {
	if(isset($_POST['GR_gelesen']))
	{
		if (eingabecheck_Bewerbung())
		{
			$_POST['why'] = nl2br ($_POST["why"]);
			$_POST['sonstiges'] = nl2br ($_POST["sonstiges"]);
			$db->INSERT_Bewerbung($_POST["mainchar"], $_POST["rasse"], $_POST["klasse"], $_POST["richtung"], $_POST["why"], $_POST["vorlieben"], $_POST["onlinezeiten"], $_POST["sonstiges"], $_POST["Mo"], $_POST["Di"], $_POST["Mi"], $_POST["Do"], $_POST["Fr"], $_POST["Sa"], $_POST["So"], $_POST["jt"], $_POST["alt"]);
			echo $_POST["alter"];
			if (($_POST["email"] != "") && ($_POST["passwd"] != "") && ($_POST["passwd_wiederholen"] != ""))
			{
				if ($_POST["passwd"] == $_POST["passwd_wiederholen"])
				{
					$db->INSERT_User($_POST["email"],$_POST["passwd"], $_POST["mainchar"]);
				}
			}
			$ziel = "./Meldungen.php?id=4";
			header("Location: $ziel");
		}
		else
		{
			$ziel = "./Meldungen.php?id=6";
			header("Location: $ziel");
		}
	}
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Imperial-March - Bewerbung</title>
	<link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css"/>
	<link href="http://fonts.googleapis.com/css?family=Wallpoet" rel="stylesheet" type="text/css"/>
	<link href="http://fonts.googleapis.com/css?family=Graduate" rel="stylesheet" type="text/css"/>
	<link href="./style.css" rel="stylesheet" type="text/css" media="screen" />
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
				<div id="contentbew">
					<div id="bew">
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">	
							<div id="Bewerbung">
								<h2 class="title">Bewerbung</h2>
								<h2 id="Pflicht">Pflichtangaben</h2>
									<div id="MainChar">
										<div id="MC_text"><label for="mainchar">Char-Name:</label></div>
										<div id="MC_eingabe"><input type="text" id="mainchar" name="mainchar" /></div>
									</div>
									<h2 class="alter">Alter:</h2>
									<select id="Alter" name="alt">
										<option></option>
										<option>18</option>
										<option>19</option>
										<option>20</option>
										<option>21</option>
										<option>22</option>
										<option>23</option>
										<option>24</option>
										<option>25</option>
										<option>26</option>
										<option>27</option>
										<option>28</option>
										<option>29</option>
										<option>30</option>
										<option>31</option>
										<option>32</option>
										<option>33</option>
										<option>34</option>
										<option>35</option>
										<option>36</option>
										<option>37</option>
										<option>38</option>
										<option>39</option>
										<option>40</option>
										<option>41</option>
										<option>42</option>
										<option>43</option>
										<option>44</option>
										<option>45</option>
										<option>46</option>
										<option>47</option>
										<option>48</option>
										<option>49</option>
										<option>50+</option>
									</select>
									<h2 class="Character">Charakter Information</h2>
									<h2 class="rasse">Rasse</h2>
									<select id="Rasse" name="rasse">
										<option>-----</option>
										<option>Mensch</option>
										<option>Chiss</option>
										<option>Mirialaner</option>
										<option>Miraluka</option>
										<option>Rattataki</option>
										<option>Sith</option>
										<option>Twi&apos;Lek</option>
										<option>Zabrak</option>
										<option>Cyborg</option>
										<option>Cathar</option>
									</select>
									<h2 class="klasse">Klasse</h2>
									<select id="Klasse" name="klasse">
										<option>-----</option>
										<option>Sith-Krieger</option>
										<option>Sith-Inquisitor</option>
										<option>Kopfgeldj&auml;ger</option>
										<option>Imperialer-Agent</option>
									</select>
									<h2 class="ausrichtung">Ausrichtung</h2>
									<select id="Richtung" name="richtung">
										<option>-----</option>
										<option value="Heal">Heal</option>
										<option value="Tank">Tank</option>
										<option value="DDmelee">DD(Melee)</option>
										<option value="DDrange">DD(Range)</option>
									</select>
									<div id="why_text"><label>Warum m&ouml;chtest Du zu Imperial-March:</label></div>
									<div id="why_eingabe"><textarea name="why" cols="52" rows="10"></textarea></div>
									<h2 class="vorlieben">Vorlieben</h2>
										<select id="vorlieben_ausgabe" name="vorlieben">
										  <option>-----</option>
										  <option>PVE</option>
										  <option>PVP</option>
										  <option>PVE/PVP</option>
										  <option>Casual</option>
										</select>
									<h2 class="onlinezeiten">Online-Zeiten</h2>
									<h2 id="tage">Spieltage ( Mehrfachnennung)</h2>
										<div id="mo"><input type="checkbox" name="Mo" value="Mo" /> Montag</div>
										<div id="di"><input type="checkbox" name="Di" value="Di" /> Dienstag</div>
										<div id="mi"><input type="checkbox" name="Mi" value="Mi" /> Mittwoch</div>
										<div id="do"><input type="checkbox" name="Do" value="Do" /> Donnerstag</div>
										<div id="fr"><input type="checkbox" name="Fr" value="Fr" /> Freitag</div>
										<div id="sa"><input type="checkbox" name="Sa" value="Sa" /> Samstag</div>
										<div id="so"><input type="checkbox" name="So" value="So" /> Sonntag</div>
										<div id="jt"><input type="checkbox" name="jt" value="jt" /> jeden Tag</div>
									<h2 id="uhrzeit">ca. Online ab</h2>
										<select id="von" name="onlinezeiten">
										  <option>-----</option>
										  <option>01:00</option>
										  <option>02:00</option>
										  <option>03:00</option>
										  <option>04:00</option>
										  <option>05:00</option>
										  <option>06:00</option>
										  <option>07:00</option>
										  <option>08:00</option>
										  <option>09:00</option>
										  <option>10:00</option>
										  <option>11:00</option>
										  <option>12:00</option>
										  <option>13:00</option>
										  <option>14:00</option>
										  <option>15:00</option>
										  <option>16:00</option>
										  <option>17:00</option>
										  <option>18:00</option>
										  <option>19:00</option>
										  <option>20:00</option>
										  <option>21:00</option>
										  <option>22:00</option>
										  <option>23:00</option>
										  <option>24:00</option>
										</select>
										<h2 id="sonstiges">Was m&ouml;chtest Du uns noch sagen (freiwillig):</h2>
										<div id="sonstiges_Text"><textarea name="sonstiges" cols="52" rows="10"></textarea></div>
										<div id="information">Nach deiner Bewerbung wird sich ein Offizier bei dir im Spiel melden.<br />
															  Du kannst im Gegenzug auch jemanden aus der Gilde ansprechen, wir beissen nicht.<br />
															  Einfach "/who March" (2*best&auml;tigen) eingeben.</div>
										 <div><h4>Wir werden Dir unter "Bewerbung-Offen" eine Nachricht hinterlassen, sollten wir dich Ingame nicht erreichen.</h4></div>
										<div id="reg_info">Du kannst dich hier gleich auch noch Registrieren. Du hast dann bei Aufnahme<br />
															  gleich Zugriff auf s&auml;mtliche Funktionen der Seite.</div>

										<div id="Registrieren">
											<h2 class="title">Registrierung</h2>
												<div class="registrierung">
													<div id="E-Mail">
														<div id="e_text_bewerbung"><label for="email">E-Mail Adresse:</label></div>
														<div id="e_eingabe_bewerbung"><input type="text" id="email" name="email" /></div>
													</div>
													<div id="Passwort">
														<div id="pw_text_bewerbung"><label for="passwd">Passwort:</label></div>
														<div id="pw_eingabe_bewerbung"><input type="password" id="passwd" name="passwd" /></div>
													</div>
													<div id="Passwort_wiederholen">
														<div id="pww_text_bewerbung"><label for="passwd_wiederholen">Passwort wiederholen:</label></div>
														<div id="pww_eingabe_bewerbung"><input type="password" id="passwd_wiederholen" name="passwd_wiederholen" /></div>
													</div>
													<div id="GR_gelesen"><input type="checkbox" name="GR_gelesen" /> <a href="./Gildenregeln.php" >Gildenregeln</a> gelesen und aktzeptiert</div>
													<div id="Be_Button_bewerbung">
														<input type="submit" class="buttons" name="Be_Button_bewerbung" value="Bewerben" />
													</div>
													<div id="A_Button_bewerbung">
														<input type="submit" class="buttons" name="A_Button_bewerbung" value="Abbruch" />
													</div>
												</div>
											</div>
									   </div>
									   <div><h4>Wir werden Dir unter "Bewerbung-Offen" eine Nachricht hinterlassen, sollten wir dich Ingame nicht erreichen.</h4></div>
							
						</form>
						
					</div>
                		</div>
			</div>
		</div>
		<div style="clear: both;">&nbsp;</div>
	</div>
	<div style="clear: both;"></div>
</div>
<div id="footer"><?php echo $create=print_create();?></div>

</body>
</html>
