<?php

#define
define(
	'ABSURL',
	"http://" . 
	$_SERVER["SERVER_NAME"] . 
	(trim(dirname($_SERVER["PHP_SELF"]), DIRECTORY_SEPARATOR) ? dirname($_SERVER["PHP_SELF"]) : '') . 
	"/"
);

session_start();

if(empty($_SESSION['uid'])) {
	header("Location:" . ABSURL . "index.php", true, 302);
	exit();
}

if(isset($_POST['topic_submit'])) {
	if(empty($_POST['topic_title']) && empty($_POST['prispevok'])) {
		echo "Nevyplnili ste vsetky polia. Prosim, vratte sa na predchadzajucu stranku.";
		exit();
	} else {
		// okej tentoraz
		// ja tu nie som od toho prepisovať celý skript, pretože je 27. 4. 2014 okolo 1:50 v noci
		// nemám ešte spravený projekt o Masarykovi na dejepis, ktorý som mal odovzdať pred dvoma dňami
		// iba dopíšem obranu proti SQL Injection
		// vďaka za pochopenie.
		include_once("connect.php");
		// okrem potenciálnej náchylnosti ku SQL Injection
		// je tu ešte jedna zásadná chyba:
		// !! nie je zaistená atomicity operácií 
		// toto je riešiteľné transakciami, ale na to je potrebné pozmeniť štruktúru databáze
		// a tabuľkám zmeniť engine na InnoDB
		// :-(
		$cid = intval($_POST['cid']);
		$title = mysql_real_escape_string($_POST['topic_title']);
		$content = mysql_real_escape_string($_POST['prispevok']);
		$creator = intval($_SESSION['uid']);
		$sql = "INSERT INTO topics (category_id, topic_title, topic_creator, topic_date, topic_reply_date) VALUES ('".$cid."', '".$title."', '".$creator."', now(), now())";
		$res = mysql_query($sql);// or die(mysql_error());
		$new_topic_id = mysql_insert_id();
		$sql2 = "INSERT INTO posts (category_id, topic_id, post_creator, post_content, post_date) VALUES ('".$cid."', '".$new_topic_id."', '".$creator."', '".$content."', now())";
		$res2 = mysql_query($sql2);// or die(mysql_error());
		$sql3 = "UPDATE categories SET last_post_date=now(), last_user_posted='".$creator."' WHERE id='".$cid."' LIMIT 1";
		$res3 = mysql_query($sql3);// or die(mysql_error());

		if(($res) && ($res2) && ($res3)) {
			header("Location: " . ABSURL . "view.php?cid=".$cid."&tid=".$new_topic_id);
		} else {
			echo "Nastal problém pri vytváraní vasej témy. Skúste to prosím znova.";
		}
	}
}

?>


