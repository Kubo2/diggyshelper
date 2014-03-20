<?php
session_start();
function change_profile_image($user_id, $file_temp, $file_extn) {
	$file_path = 'images/avatars/' . substr(md5(time()), 0, 10) . '.' . $file_extn;
	move_uploaded_file($file_temp, $file_path);
	mysql_query("UPDATE `users` SET `imagelocation` = '" . mysql_real_escape_string($file_path) . "' WHERE `user_id` = " . (int)$user_id);
}

function loggedIn() {
	if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
		return true;
	} else {
		return false;
	}
}

function getuser($id, $field){
	$query = mysql_query("SELECT $field FROM users WHERE id='$id'");
	$run = mysql_fetch_array($query);
	return $run[$field];
}?>