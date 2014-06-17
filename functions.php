<?php

session_start();

/**
 * An alias of changeProfileImage() function.
 *
 * @uses changeProfileImage()
 */
function change_profile_image($user_id, $file_temp, $file_extn)
{
	changeProfileImage($user_id, $file_temp, $file_extn);
}

function changeProfileImage($userId, $fileTemp, $fileExt)
{
	$filepath = 'images/avatars/' . substr(md5(time()), 0, 10) . '.' . $fileExt;
	move_uploaded_file($fileTemp, $filepath);
	mysql_query("UPDATE `users` SET `imagelocation` = '" . mysql_real_escape_string($filepath) . "' WHERE `user_id` = " . (int)$userId);
}

function loggedIn()
{
	return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
	
}

/**
 * Retrieves an information about user specified by unique identifier.
 *
 * @param int user identifier
 * @param string the name of the column in database table
 * @return string an information about specified user
 *
 * @deprecated 1.3.1 This function has been deprecated since dh version 1.3.1.
 */
function getUser($id, $field)
{
	$query = mysql_query("SELECT $field FROM users WHERE id='$id'");
	$run = mysql_fetch_array($query);
	return $run[$field];
}