<?php

if(defined('DB_CONNECTION_ESTABLISHED')) return;
define('DB_CONNECTION_ESTABLISHED', true);

$dbData = array(
	"host" => 'localhost',
	"user" => 'skdiggyshelper',
	"password" => (strpos($_SERVER["SERVER_NAME"], 'localhost') !== false ? '' : '7FD58A34E5'),
	"name" => 'skdiggyshelper',
);

$connection = mysql_connect(
	$dbData["host"],
	$dbData["user"],
	$dbData["password"]
);

if((bool)$connection) {
	mysql_query("SET NAMES utf8");
	$selectedDb = mysql_select_db($dbData["name"]);
	unset($dbData);
	if($selectedDb)
		return true;
}
return false;


?>