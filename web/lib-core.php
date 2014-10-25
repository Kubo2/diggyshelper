<?php

/**
 * This is the "core" library supposed to provide some low-level polyfill functionality
 * that is not natively included in PHP nor implemented yet, but is going to be 
 * implemented in newer versions of PHP.
 *
 * @internal This file should not be include()d separately as it is already part of "functions" library, but there can be some exceptions.
 * @internal Sometimes when any of these "core" functions became {@deprecated} because of native implementation, you can still use it, but they will only slow down your code, because they will act like 'adapters'.
 *
 * @author   Kubo2
 * @version  1.0.0.0
 * @license <current>
 *
 * @package 		DH
 * @subpackage 	DH_PHP_CORE
 *
 */
if(DEFINED('DH_PHP_CORE')) return;
/**
 * The core can be **really** included only once.
 *
 * @var BOOLEAN whether this file was included yet
 */
DEFINE('DH_PHP_CORE', TRUE);

/**
 * Sometimes it is called ifsetor(), we use name whether() for it.
 * Its role is to determine *wheter* some variable was set; if it was,
 * then return its value; if not, return the default value, specified in 
 * second parameter.
 *
 * @internal An alternative to coalesce (T_COALESCE) operator available through PHP >= 5.6.1
 *
 * @param & mixed Variable or value reference
 * @param mixed The default value
 * @return mixed Either variable's or the default value
 */
function whether(& $var, $default) {
	if(isset($var))
		return $var;
	return $default;
}

/**
 * Sometimes we only need to determine, if value of something *evalueates*
 * to boolean's <code>false</code> after type coercion, and not directly
 * whether it is set. There you can take hand on this function.
 *
 * You pass to its first parameter a variable; if its vlaue coercies to {@code false},
 * the default value from second parameter will be returned; otherwise, the value
 * of the first parameter will be returned.
 *
 * @internal An alternative to shortened ternary (like <code>$var ?: 'default')
 *
 *  @param mixed Variable or value reference
 *  @param mixed The default value
 *  @return mixed Either variable's or the default value
 */
function iftrue($val, $default) {
	if((boolean) $val)
		return $val;
	return $default;
}
