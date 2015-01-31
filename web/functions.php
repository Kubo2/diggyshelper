<?php

/**
 * Functions library.
 */

require dirname(__FILE__) . '/lib-core.php';

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

		if(empty($cache[$id])) {
			$result = mysql_query($statement);

			if(mysql_num_rows($result) < 1) {
				return false; // ============>
			}

			mysql_free_result($result);
		}

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
