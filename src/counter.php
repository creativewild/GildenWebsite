<?php 

class counter 
{ 
   public $tag = NULL; 
   public $gestern = NULL; 
   private $host; 
   private $user; 
   private $pass; 
   private $name; 
   private $befehl; 

   public function __construct($host, $user, $pass, $name) 
   { 
     $this->webserver    = $host; 
     $this->username    = $user; 
     $this->password    = $pass; 
     $this->database    = $name; 
     $this->connect    = @mysql_connect($this->webserver, $this->username, $this->password); 
     
     if(is_resource($this->connect)) 
     { 
       if(!@mysql_select_db($this->database)) 
       { 
         $this->fehler("Die Datenbank <strong>".$this->database."</strong> konnte nicht geöffnet werden. Bitte überprüfen sie ihre Einstellungen."); 
       } 
     } 
    else 
     { 
       $this->fehler("Es konnte keine Verbindung zum MySQL Server aufgebaut werden. Bitte überprüfen sie ihre Einstellungen."); 
     } 
   } 

   public function __destruct() 
   { 
     if(is_resource($this->connect)) 
     { 
       if(!@mysql_close($this->connect)) 
       { 
         $this->fehler("Die Verbindung zum MySQL Server konnte nicht beendet werden."); 
       } 
     } 
    else 
     { 
       $this->fehler("Es besteht keine Verbindung zum MySQL Server, darum kann sie auch nicht beendet werden."); 
     } 
   } 

   private function fehler($text="") 
   { 
     echo '<br /><strong>MySQL Fehler:</strong><br />'.$text.'<br />'; 
     exit(); 
   } 

   public function zaehlen($gezaehlt="") 
   { 
     echo mysql_num_rows($gezaehlt); 
   } 

   public function ueberpruefen($ip="") 
   { 
     $this->ip = $ip; 
     $this->befehl = @mysql_query("SELECT * FROM `site_counter` WHERE `ip` = '".$this->ip."' AND `visit` = '".date("Y-m-d", time())."' LIMIT 0,1"); 
     $this->count = mysql_num_rows($this->befehl); 
     if($this->count == 0) 
     { 
       $this->befehl = @mysql_query("INSERT INTO `site_counter`(`ip`, `visit`, `online`)VALUES('$this->ip', '".date("Y-m-d", time())."', '".time()."');"); 
     } 
    else 
     { 
       $this->befehl = @mysql_query("UPDATE `site_counter` SET `online` = '".time()."' WHERE `ip` = '".$this->ip."' LIMIT 1"); 
     } 
     if($this->befehl) 
     { 
       return $this->befehl; 
     } 
    else 
     { 
       $this->fehler(mysql_error()); 
     } 
   } 

   public function online() 
   { 
     $this->minuten = 2; 
     $result = time()-$this->minuten*60; 
     $this->befehl = @mysql_query("SELECT * FROM `site_counter` WHERE `online` >= '".$result."'"); 
     if($this->befehl) 
     { 
       return $this->befehl; 
     } 
    else 
     { 
       $this->fehler(mysql_error()); 
     } 
   } 

   public function heute($tag="") 
   { 
     $this->heute = $tag; 
     $this->befehl = @mysql_query("SELECT * FROM `site_counter` WHERE `visit` = '".$this->heute."'"); 
     if($this->befehl) 
     { 
       return $this->befehl; 
     } 
    else 
     { 
       $this->fehler(mysql_error()); 
     } 
   } 

   public function gestern($gestern="") 
   { 
     $this->gestern = $gestern; 
     $this->befehl = @mysql_query("SELECT * FROM `site_counter` WHERE `visit` = '".$this->gestern."'"); 
     if($this->befehl) 
     { 
       return $this->befehl; 
     } 
    else 
     { 
       $this->fehler(mysql_error()); 
     } 
   } 

   public function gesamt() 
   { 
     $this->befehl = @mysql_query("SELECT * FROM `site_counter`"); 
     if($this->befehl) 
     { 
       return $this->befehl; 
     } 
    else 
     { 
       $this->fehler(mysql_error()); 
     } 
   } 
} 
?>