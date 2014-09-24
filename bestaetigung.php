<?php
	if(extension_loaded("zlib") AND strstr($_SERVER["HTTP_ACCEPT_ENCODING"],"gzip"))
		@ob_start("ob_gzhandler");

  /****************************
   *Einbindung fremder Dateien*
   ****************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Imperial-March</title>
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
	<div id="page">
		<div id="page-bgtop">
			<div id="page-bgbtm">
				<div id="content">
					<div class="post">
						<h2 class="title"></h2>
						
					</div>
					<div style="clear: both;">&nbsp;</div>
				</div>
				<div style="clear: both;"></div>
			</div>
		</div>
	</div>

</div>
<div id="footer"><?php echo $create=print_create();?></div>

</body>
</html>