<?php

if(DEFINED('DH_PHP_CORE')) RETURN;

/**
 * This is the "core" library supposed to provide some low-level polyfill functionality
 * that is not natively included in PHP nor implemented yet, but is going to be
 * implemented in newer versions of PHP.
 *
 *
 * @author   Kubo2
 * @version  1.0.0.0
 * @deprecated This package is deprecated as of v2 and will be removed in v3.
 * @package 		DH
 * @subpackage 	DH_PHP_CORE
 *
 */


/**
 * The core can be **really** included only once.
 *
 * @var BOOLEAN whether this file was included yet
 */
DEFINE('DH_PHP_CORE', TRUE);


/**
 * Identity of object. Returns passed value unchanged.
 *
 * @author   Jakub Vrána
 * @since v1.5-beta
 * @param mixed
 * @return mixed
 */
function id($o) {
	return $o;
}


/**
 * Include $file and provide a specific variable $scope to it.
 *
 * @since v1.5-beta
 * @param string $file
 * @param array $scope
 * @return mixed
 */
function includeScoped($file, $scope = array()) {
	foreach($scope as $name => $value) {
		$$name = $value;
	}

	unset($scope, $name, $value);
	return include $file;
}


/**
 * Sometimes it is called ifsetor(), we use the name whether() for it.
 * Its role is to determine *whether* some variable was set; if it was,
 * then return its value; if not, return the default value, specified in the
 * second parameter.
 *
 * @internal An alternative to coalesce (T_COALESCE) operator available through PHP >= 5.6.1
 * @deprecated as of v1.5
 * @param & mixed Variable reference
 * @param mixed The default value
 * @return mixed Either variable's or the default value
 */
function whether(& $var, $default) {
	return isset($var) ? $var : $default;
}


/**
 * Alias of whether().
 * @see whether()
 * @since v1.5-beta
 */
function ifsetor(& $var, $default) {
	return whether($var, $default);
}


/**
 * This function is an alias of PHP > 5.5 native ?: operator.
 *
 * @deprecated as of v1.5
 *  @param mixed Variable or value reference
 *  @param mixed The default value
 *  @return mixed Either variable's or the default value
 */
function iftrue($val, $default) {
	return $val ?: $default;
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
function array_slice_assoc($array, $keys) {
	return array_intersect_key($array, array_flip($keys));
}
