<?php

require dirname(__FILE__) . '/lib-core.php';

/**
 * Functions library.
 */


/**
 * Retrieves a HTTP GET parameter applying $filter.
 * - A $filter can be a function with one argument the value of the GET param, or can be NULL,
 * in which case no filter is  applied on any value retrieved.
 * - $params ca be an array of strings, or a variable argument list of strings. Either case
 * must contain at least one non-empty string.
 * This function returns a non-empty array with indexes the strings given in $params and values
 * of either the original values retrieved from GET and run through the $filter, or NULL in case a
 * particular param does not exist in GET.
 *
 * @since v1.5
 *
 * @param callable|NULL
 * @param array(string, ...)|...string
 * @return array(string => mixed, ...)
 */
function getUriParam(callable $filter = NULL, $params) {
	if(!is_array($params)) {
		$params = func_get_args();
		array_shift($params);
	}

	if(!count($params)) {
		trigger_error('$params must contain at least one element', E_USER_WARNING);
	}

	$values = array_slice_assoc($_GET, $params);

	foreach($params as $p) {
		if(!isset($values[$p])) {
			$values[$p] = NULL;
		} elseif($filter) {
			$values[$p] = $filter($values[$p]);
		}
	}

	return $values;
}


/**
 * Is current user signed in?
 *
 * @since 1.3.3
 * @return bool
 */
function loggedIn() {
	return !empty($_SESSION['uid']);
}


/**
 * Retrieves an information about user specified by unique identifier.
 * @internal  Requires and assumes an active ext_mysql connection
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
		$statement = sprintf("SELECT COUNT(*) FROM users WHERE id = %d", $id);

		if(empty($cache[$id])) {
			$result = mysql_query($statement);

			if(mysql_num_rows($result) < 1) {
				return FALSE; // ============>
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
		$statement = sprintf("SELECT %s FROM users WHERE id = %d",
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
 * @see diggyshelper.js
 *
 * @param string
 * @return string
 */
function sk_sanitizeEmail($email) {
	return str_replace(['.', '@'], [' (bodka) ', ' (zavináč) '], $email);
}


/**
 * Records a line to the log.
 * (Trying to log a newline will result in logging everything BEFORE
 * the newline character and raising a E_USER_NOTICE.)
 *
 * @param string description of the information
 * @param string error level, used as a prefix for the line
 * @param string topic of the error, if provided, used as a prefix for the log filename
 * @param string
 * @return bool TRUE on success, FALSE on failure
 */
function recordLog($message, $level, $section = NULL, $logdir = NULL) {
	$origLen = strlen($message);
	$message = substr($message, 0, strcspn($message, "\r\n"));
	if(strlen($message) < $origLen) {
		trigger_error('$message should not contain a newline', E_USER_NOTICE);
		if(!$message) return FALSE; // ============>
	}

	$message = sprintf('[%s] %s: %s', date('Y-d-m H:i:s'), ucfirst($level), $message);
	$message .= "\n"; // always trailing newline at EOF

	if(!$logdir) $logdir = __DIR__ . '/logs';
	{
		if(!is_dir($logdir) && !@mkdir($logdir)) { // intentionally @ -- expression not atomic
			return FALSE; // ============>
		}
	}

	$logfile = sprintf('%s/%s%d-%s.log', $logdir, ($section ? "$section-" : NULL), date('Y'), date('m'));
	return !!@file_put_contents($logfile, $message, FILE_APPEND);
}


/**
 * Checks whether at least one of an array's elements is empty().
 *
 * @param array
 * @return bool
 *         TRUE if at least one of the array's elements is empty,
 *         FALSE otherwise (even if there are no elements in the array)
 */
function arrayHasEmptyElements(array $array) {
	$isEmpty = FALSE;
	foreach($array as $elem) {
		$isEmpty = $isEmpty || empty($elem); // if $isEmpty is TRUE, empty() is being ignored
	}

	return $isEmpty;
}
