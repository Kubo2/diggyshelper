<?php

	include "connect.php";
	
	$value = $_POST['value'];
	
	echo '<ul>';
	
	$query = mysql_query("SELECT username FROM users WHERE username LIKE '$value%'");
	while($run = mysql_fetch_array($query)){
		$username = $run['username'];
		
		echo '<li><a href=#>'.$username.'</a></li>';
	}
	
	echo '</ul>';
	
?>