<?php

/**
 * Whether at least one field of array is empty.
 *
 * @param array
 * @return bool true if at least one array field is empty, otherwise false
 */

function emptyArray(array $array) {
	foreach($array as $field) {
		if(empty($field)){
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
function emptyArrayFields(array $array) {
	$result = [];
	foreach($array as $index => $field) {
		$result[$index] = empty($field);
	}
}