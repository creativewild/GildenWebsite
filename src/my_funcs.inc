<?php
/*Sessions für alle Seiten ohne Cookies initialisieren*/
function init_session()
{
	ini_set("session.use_cookies", 1);
	ini_set("session.use_only_cookies", 0);
	session_name("IM");
	session_start();
	if (!defined("SID"))
	define("SID", session_name()."=".session_id());
}
function destroy_session()
{
	ini_set("session.use_cookies", 1);
	ini_set("session.use_only_cookies", 0);
	session_destroy();
	define('SID', 'IM=""');
}
/* Debugging? ja oder nein */
function debugging( $status=true )
{
  define("MYDEBUG", $status);
  if ( MYDEBUG )
    error_reporting(E_ALL);
  else
    error_reporting(0);

  ob_end_clean();
}
  
/* formatierte Ausgabe eines Arrays 
   ACHTUNG: setzt die Existenz einer Konstanten namens MYDEBUG voraus
*/
function my_arr( $arr, $debug=MYDEBUG )
{
    if ($debug)
    {
      echo "<pre>";
      print_r($arr);
      echo "</pre>";
    }
}
function my_r( $arr, $debug=MYDEBUG )
{
    if ($debug)
    {
      echo "<pre>";
      print_r($arr);
      echo "</pre>";
    }
}

function user_pruefen()
{
	if (empty($_SESSION['User_ID']))
		header("Location: ./index.php");
}
function eingabecheck_login()
{
  if (!empty($_POST['login']) &&
      !empty($_POST['passwd']))
     return true;
  else
     return false;
}
function eingabecheck_Bewerbung()
{
	$return=false;
		if(	!empty($_POST['mainchar']) &&
			($_POST['rasse'] != "-----") &&
			($_POST['klasse'] != "-----") &&
			($_POST['richtung'] != "-----") &&
			!empty($_POST['why']) &&
			($_POST['vorlieben'] != "-----") &&
			(!empty($_POST['Mo']) || !empty($_POST['Di']) || !empty($_POST['Mi']) || !empty($_POST['Do']) || !empty($_POST['Fr']) || !empty($_POST['Sa']) || !empty($_POST['So']) || !empty($_POST['jt'])) &&
			($_POST['onlinezeiten'] != "-----") &&
			 $_POST['alter'] != "-----")
	{
		$return=true;
	}
	return $return;
}
function eingabecheck_registrieren()
{
	$return=false;
	if(!empty($_POST['email']) &&
	   !empty($_POST['passwd']) &&
	   !empty($_POST['mainchar']) 
	)
	{
		$pattern = '=^([a-zA-Z0-9][\w.-]*)@((?:[a-zA-ZüöäÜÖÄ0-9][\wüöäÜÖÄ.-]*\.)*[a-zA-ZüöäÜÖÄ0-9][\wüöäÜÖÄ._-]*\.[a-zA-Z]{2,}|((\d{1,2}|1\d{2}|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d{2}|2[0-4]\d|25[0-5]))$=';
		$subject = $_POST['email'];
		if (preg_match($pattern , $subject))
			{
			$return=true;
			}
	}
	return $return;
}

function neues_passwort($altes_PW)
{
	$return = false;
	if(	!empty($_POST['pass_eingabe']) &&
			!empty($_POST['passwd_eingabe']))
				{
					if($altes_PW== md5($_POST['pass_alt']))
					{
						if($_POST['pass_eingabe']===$_POST['passwd_eingabe'])	
							$return = true;
					}
				}
	return $return;
}
?>