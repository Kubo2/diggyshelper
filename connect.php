<?php

if(defined('DB_CONNECTED')) return true;

$dbData = array(
	"host" => 'localhost',
	"user" => '',
	"password" => NULL,
	"name" => 'dh',
);

// load configuration
$conf = ".dh.db-config.ini";
foreach(file("./.dbconfig") as $line) {
	if(substr($line, 0, 4) == "ref:") {
		$conf = substr($line, 5);
		break;
	}
}

$dbData = parse_ini_file($conf) + $dbData;

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