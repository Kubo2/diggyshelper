<?php

if(strpos($_SERVER['SERVER_NAME'], '.php5.sk') !== false) {
	if(!empty($_SERVER['HTTP_USER_AGENT']) && stripos($_SERVER['HTTP_USER_AGENT'], 'bot') !== false) {
		// @todo parsing and redirecting url part
		header("Location: http://diggyshelper.net/", true, 301);
		exit;
	}
	header("Content-Type: text/html; charset=utf-8", true, 303);
?>
<title>Natrvalo presunuté</title>
<h1>Natrvalo presnutý na novú doménu</h1>
<p>Celý web Diggy's Helper Fórum bol presunutý na <a href="http://diggyshelper.net/">novú doménu</a>
<?php
}