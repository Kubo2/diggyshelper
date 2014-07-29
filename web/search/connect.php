<?php

$dbData = array(
	"host" => 'localhost',
	"user" => 'skdiggyshelper',
	"password" => (strpos($_SERVER["SERVER_NAME"], 'localhost') !== false ? 'heslo' : '7FD58A34E5'),
	"name" => 'skdiggyshelper',
);

$connection = mysql_connect(
	$dbData["host"], 
	$dbData["user"], 
	$dbData["password"]
);

$selectedDb = mysql_select_db($dbData["name"]);

unset($dbData);

if((bool)$connection && $selectedDb) {
	mysql_query("SET NAMES utf8");
	return true;
}
return false;


?>