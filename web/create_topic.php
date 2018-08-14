<?php

require __DIR__ . '/functions.php';

define(
	'ABSURL',
	"http://" . 
	$_SERVER["SERVER_NAME"] . 
	(trim(dirname($_SERVER["PHP_SELF"]), DIRECTORY_SEPARATOR) ? dirname($_SERVER["PHP_SELF"]) : '') . 
	"/"
);

$dbContext = require __DIR__ . '/connect.php';

session_start();

if(!loggedIn()) {
	header("Location:" . ABSURL . "index.php", TRUE, 303);
	exit();
}

// topic form submitted?
if(isset($_POST['topic_submit'])) {
	if(empty($_POST['topic_title']) || empty($_POST['prispevok'])) {
		echo "Nevyplnili ste všetky polia. Prosím, vráťte sa na predchádzajúcu stránku.";
		exit();
	} elseif(!$dbContext) {
		echo 'Ospravedlň nás! Máme dočasné problémy s vytváraním tém. Prejdi naspäť a skús to znova!';
		exit();
	} else {

		$markup = 'bb'; // default for non-admin users
		$type = getUser($dbContext, $_SESSION['uid'], 'access');

		if($type === 'admin' && !empty($_POST['post-markup'])) {
			$markup = in_array($_POST['post-markup'], ['html', 'bb']) ? $_POST['post-markup'] : $markup;
		}

		/**
		 * @internal {2} a {3} by mohli byť riešené trigermi vyvolanými pri {1}
		 * @todo zaistiť atomicitu operácií
		 */
		$cid = intval($_POST['cid']);
		$title = mysql_real_escape_string($_POST['topic_title'], $dbContext);
		$content = mysql_real_escape_string($_POST['prispevok'], $dbContext);
		$creator = intval($_SESSION['uid']);
		$sql = "INSERT INTO topics (category_id, topic_title, topic_creator, topic_date, topic_reply_date) VALUES ($cid, '$title', $creator, now(), now())"; // 1
		$res = mysql_query($sql, $dbContext);
		$new_topic_id = mysql_insert_id($dbContext);
		$sql2 = "INSERT INTO posts (topic_id, post_creator, post_content, post_markup, post_date) VALUES ($new_topic_id, '$creator', '$content', '$markup', now())"; // 2
		$res2 = mysql_query($sql2, $dbContext);
		$sql3 = "UPDATE categories SET last_post_date = now(), last_user_posted = $creator WHERE id = $cid LIMIT 1"; // 3
		$res3 = mysql_query($sql3, $dbContext);

		if(($res) && ($res2) && ($res3)) {
			header(sprintf('Location: %sview_topic.php?tid=%d', ABSURL, $new_topic_id), TRUE, 303);
			exit();
		} else {
			echo "Nastal problém pri vytváraní vasej témy. Skúste to prosím znova.";
		}
	}
}
