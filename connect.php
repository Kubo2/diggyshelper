<?php

if(defined('DB_CONNECTED')) return true;

/**
 * Implementation is not strictly specified. There is only one convention.
 * The <code>require("./.db.cfg")</code> statement or its equivalents *must* return
 * an associative array with structure of these four items:
 *
 * <pre>
 * array(4) {
 * 	[host] => 'database hostname e.g. localhost'
 * 	[user] => 'user login to the database server e.g. root'
 * 	[password] => 'password of specified user'
 * 	[name] => 'concrete name of database to be used'
 * }
 * </pre>
 *
 */
$dbData = require("./.db.cfg");

$connection = mysql_connect(
	$dbData["host"], 
	$dbData["user"], 
	$dbData["password"]
);

$selectedDb = mysql_select_db($dbData["name"]);

unset($dbData);

if((bool)$connection && $selectedDb) {
	mysql_query("SET NAMES utf8");
	define('DB_CONNECTED', true);
	return true;
}
return false;


?>