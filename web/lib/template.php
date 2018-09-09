<?php

/**
 * These are primarily template helper functions.
 *
 * @author  Kubo2
 */


/**
 * Include $file and provide a near-isolated specific $scope of variables to it.
 *
 * @since v1.5-beta
 * @param  string $file
 * @param  array $scope
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
 * Formats a hindsight difference between an arbitrary DateTimeInterface and a base DateTimeInterface.
 *
 * @internal assumes that $date's occured in time before $base and returns 'teraz' for all negative intervals
 * @lang sk-sk
 *
 * @param  DateTimeInterface an arbitrary point in time
 * @param  DateTimeInterface a base point in time
 * @return string
 */
function sk_relativeDateFormat(DateTimeInterface $date, DateTimeInterface $base) {
	$diff = $base->diff($date);

	if($diff->y || $diff->m > 10) return 'dávno';
	if($diff->m > 5) return 'pred pol rokom';

	if($diff->m > 1 || $diff->m && $diff->d) {
		return sprintf('pred %s mesiacmi', max(2, $diff->m));
	}

	if($diff->m || !$diff->m && $diff->d > 7) {
		return sprintf('pred %.0u týždňami', $diff->m ? 4 : max(2, $diff->d / 7));
	}

	if($diff->d > 1) return sprintf('pred %s dňami', $diff->d);
	if($diff->h > 1 || $diff->d) return sprintf('pred %s hodinami', $diff->d * 24 + $diff->h);

	if($diff->h || !$diff->h && $diff->i > 1) {
		return sprintf('pred %s minútami', $diff->h * 60 ?: $diff->i);
	}

	return 'teraz'; // this assumes that the $diff interval is positive
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
 * Alias of ifsetor().
 *
 * @deprecated v1.5
 * @see ifsetor()
 */
function whether(& $var, $default) {
	return ifsetor($var, $default);
}


/**
 * Return $var if set and not NULL, otherwise $default.
 *
 * @since v1.5-beta
 * @deprecated v1.5 since PHP >= 7 natively supports both shorthand ?: and the null coalesce ??
 * @param  &mixed a variable reference
 * @param  mixed the default return value
 * @return mixed
 */
function ifsetor(& $var, $default) {
	return isset($var) ? $var : $default;
}


/**
 * This function is an alias of PHP > 5.5 native ?: operator.
 *
 * @deprecated v1.5 since PHP >= 7 natively supports both shorthand ?: and the null coalesce ??
 * @param  mixed variable or value reference
 * @param  mixed The default value
 * @return mixed either the variable's or the default value
 */
function iftrue($val, $default) {
	return $val ?: $default;
}
