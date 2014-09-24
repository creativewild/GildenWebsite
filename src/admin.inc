<?php
/* gibt ein Array von Lehrern als Tabelle zurück*/
function print_user_as_table($user_arr)
{
?>
<table class="user_table">
<tr>
	<th>ID</th>
	<th>Char</th>
	<th>Status</th>
	<th>Aktiv</th>
	<th>Deaktiv</th>
	<th>Admin</th>
</tr>
<?php

foreach($user_arr AS $user): ?>
<tr>	
	<td><?php echo $user['User_ID']?></td>
	<td><?php echo $user['Mainchar']?></td>
	<td><?php echo $user['Status']?></td>
	<td><input type="radio"  name="aktiv" value="<?php echo $user["User_ID"];?>" />Aktivieren</td>
	<td><input type="radio"  name="deaktiv" value="<?php echo $user["User_ID"];?>" />Deaktivieren</td>
	<td><input type="radio"  name="admin" value="<?php echo $user["User_ID"];?>" />Administrator</td>
</tr>
<?php endforeach; ?>
</table>
<?php
}	//end: function print_lehrer_as_table($lehrer_arr)

?>
