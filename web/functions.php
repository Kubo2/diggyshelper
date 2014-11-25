<?php


/**
 * Identity of object. Returns passed value unchanged.
 *
 * @author   Jakub Vrána
 * @since v1.5-beta
 *
 * @param mixed
 * @return mixed
 */
function id($o)
{
	return $o;
}

/**
 * Array slice function that works with associative arrays (keys).
 *
 * @author Taylor Barstow <taylorbarstow@gmail.com>
 * @link http://php.net/array-slice#64122
 *
 * @param array
 * @param array
 * @return array
 */
function array_slice_assoc($array,$keys) {
    return array_intersect_key($array,array_flip($keys));
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
 * <b>DO NOT CALL THIS FUNCTION FREQUENTLY (E. G. IN A LOOP)!</b>
 *
 * @since v1.5.0-alpha1
 *
 * @param int user identifier
 * @param array|string the name(s) of the column(s) in database table
 * @return array|string|boolean an array of information about specified user or false when user does not exist, string if second parameter was scalar (= for backwards comapatibility)
 */
function getUser($id, $fieldList) {

	// less queries to database
	static $cache = [];

	// last assign may generate warnings in some cases
	$cache[$id] = !isset($cache[$id]) ? [ ] : $cache[$id];
	
	// skips the execution if there is no user with specified id
	{
		$statement = sprintf( "SELECT COUNT(*) FROM users WHERE id = %d", $id );
		$result = mysql_query($statement);

		if(mysql_num_rows($result) < 1) {
			return false;
		}

		mysql_free_result($result);
		unset($statement, $result);
	}

	// array of final fields and values
	$fields = [];
	// initial field list containing fields to return
	$fieldList = (array) $fieldList;
	// which fields to select in the following query
	$select = [];

	foreach($fieldList as $field) {
		if(!isset($cache[$id][$field])) {
			$select[] = $field;
		} else {
			$fields[$field] = $cache[$id][$field];
		}
	}

	if(count($select)) {
		$statement = sprintf(	"SELECT %s FROM users WHERE id = %d",
			'`' . join('`, `', $select) . '`', // joins array('a', 'b', 'c') to the string "`a`, `b`, `c`"
			$id
		);

		$result = mysql_query($statement);
		$fields += mysql_fetch_assoc($result);
	}

	$cache[$id] += $fields;

	return count($fields) === 1 ? array_shift($fields) : $fields;
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
 * Sequentially loops through an array and compares its values at specific keys/indexes with second
 * array's values on the same keys/indexes.
 *
 * Returns < 0 if the value in the second array is not equal with the first array or the second array is greater 
 * e.g. it has greater length.
 * Returns > 0 if the first array is greater than second array (the specific value in the second array doesn't
 * exist).
 * Return 0 (false) if both arrays are equal.
 *
 * @param array
 * @param array
 * @return integer
 *
 */
function cmpArrayValuesSeq(array $_1_, array $_2_) {
	
	// less than second array
	if(count($_2_) > count($_1_)) {
		return   -1;
	}

	foreach($_1_ as $key => $value) {
		
		// lgreater than second array
		if(!isset($_2_[$key])) {
			return   +1;
		}

		// less than second array - theoretically the second array have got newer version of the value
		//# (but only theoretically)
		if($value !== $_2_[$key]) {
			return   -1;
		}
	}

	// neutral - both arrays are equal
	//return   0;
	return   (int) !true;
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
 * @todo refactor
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
