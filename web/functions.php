<?php


/**
 * Identity of object. Returns passed value unchanged.
 *
 * @author   Jakub Vrána
 * @since v1.5-beta
 * @param mixed
 * @return mixed
 */
function id($o)
{
	return $o;
}

/**
 * An alias of changeProfileImage() function.
 *
 * @uses changeProfileImage()
 * @deprecated since 1.3.1
 */
function change_profile_image($user_id, $file_temp, $file_extn)
{
	changeProfileImage($user_id, $file_temp, $file_extn);
}

/**
 * Change user's profile image.
 *
 * @deprecated
 * @too-specific
 */
function changeProfileImage($userId, $fileTemp, $fileExt)
{
	$filepath = 'images/avatars/' . substr(md5(time()), 0, 10) . '.' . $fileExt;
	move_uploaded_file($fileTemp, $filepath);
	mysql_query("UPDATE `users` SET `imagelocation` = '" . mysql_real_escape_string($filepath) . "' WHERE `user_id` = " . (int)$userId);
}

/**
 * Is current user signed in?
 *
 * @since 1.3.3
 * @return bool
 */
function loggedIn()
{
	return !empty($_SESSION['uid']);
	
}

/**
 * Retrieves an information about user specified by unique identifier.
 *
 * @param int user identifier
 * @param string the name of the column in database table
 * @return string an information about specified user
 */
function getUser($id, $field)
{
	// less queries to database
	static $cache = [];

	if(!isset($cache[$id][$field])) { //return $cache[$id][$field];
		$query = mysql_query( "SELECT `$field` FROM users WHERE id = " .intval($id) );
		$cache[$id][$field] = mysql_fetch_row($query)[0];
	}

	return $cache[$id][$field];
}

/**
 * Prepares an email address passed as argument for future rendering on the HTML webpage.
 *
 * @lang sk-sk
 * @param string
 * @return string
 */
function sk_sanitizeEmail($email)
{
	// dots
	$email = str_replace('.', ' (bodka) ', $email);

	// at-sign
	$email = preg_replace('#^([^@]+)@(.+)#', '$1 (zavináč) $2', $email);

	// strip any extra at-signs
	$email = str_replace('@', '', $email);

	return $email;
}

/**
 * Whether at least one field of array is empty.
 *
 * @param array
 * @return bool true if at least one array field is empty, otherwise false
 */

function emptyArray(array $array)
{
	foreach($array as $field)
	{
		if(empty($field))
		{
			return true;
		}
	}
	return false;
}

/**
 * Which fields in array are empty.
 *
 * @param array
 * @return array with keys from arg1 and field values true/false (empty/not empty)
 */
function emptyArrayFields(array $array)
{
	$result = [];
	foreach($array as $index => $field)
	{
		$result[$index] = empty($field);
	}
	return $result;
}

/**
 * Vloží všetky súbory v zadanom adresári do volajúceho skriptu
 * a pokúsi sa ich spracovať ako PHP kód (nezáleží na prípone).
 * 
 * @author Jakub Kubíček <kelerest123@gmail.com>
 * 
 * @param string adresár z ktorého sa majú načítať súbory
 * @param array vložia sa iba vymenované súbory (voliteľný)
 * @return void
 * @throws DomainException ak adresár alebo niektorý/é zo zadaných súborov v druhom parametri neexistuje
 *
*/
// function includeRecursive($dir, $files = array())
// {
// 	if(!is_dir($dir) || !$dh = opendir($dir)) throw new DomainException();

// 	$dir .= DIRECTORY_SEPARATOR;

// 	array_walk($files, function($item) use($dir)
// 		{
// 			$path = $dir . $item;
// 			if(!is_file($path)) throw new DomainException();
// 		}
// 	);

// 	if(count($files))
// 	{
// 		foreach($files as $file) require($dir . $file);
// 	} else {
// 		while(($file = readdir($dh) !== false) && $path = $dir . $file)
// 		{
// 			if(is_file($path)) require($path);
// 		}
// 	}

// 	closedir($dh);
// } includeRecursive("includes");
