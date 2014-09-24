<?php
function my_r ($arr, $out=FALSE)
{
	if($out)
	{
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
}
?>