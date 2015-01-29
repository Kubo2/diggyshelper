<?php

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
	if(empty($_POST['topic_title']) || empty($_POST['prispevok'])) {
		echo 'Nevyplnili ste všetky polia. 
			Prosím, vráťte sa na <a href="javascript:// návrat späť" 
			onclick="window.history.go(-1); return false">predchádzajúcu stránku.</a>';
		exit;
	} else {
		if(TRUE === include_once("connect.php")) {

			/**
			 * @internal {2} a {3} by mohli byť riešené trigermi vyvolanými pri {1}
			 * @todo zaistiť atomicitu operácií
			 */
			$cid = intval($_POST['cid']);
			$title = mysql_real_escape_string($_POST['topic_title']);
			$content = mysql_real_escape_string($_POST['prispevok']);
			$creator = intval($_SESSION['uid']);
			$sql = "INSERT INTO topics (category_id, topic_title, topic_creator, topic_date, topic_reply_date) VALUES ($cid, '$title', $creator, now(), now())"; // 1
			$res = mysql_query($sql);
			$new_topic_id = mysql_insert_id();
			$sql2 = "INSERT INTO posts (category_id, topic_id, post_creator, post_content, post_date) VALUES ($cid, $new_topic_id, '$creator', '$content', now())"; // 2
			$res2 = mysql_query($sql2);
			$sql3 = "UPDATE categories SET last_post_date = now(), last_user_posted = $creator WHERE id = $cid LIMIT 1"; // 3
			$res3 = mysql_query($sql3);

			if(($res) && ($res2) && ($res3)) {
				$destination = sprintf("Location: %s/view_topic.php?cid=%d&tid=%d", rtrim(ABSURL, '/'), $cid, $new_topic_id);
				header($destination, true, 303);
				exit; // this is VERY important here
			}
		}

		setcookie('-newtopic-saved-title', $_POST['topic_title']);
		setcookie('-newtopic-saved-post', $_POST['prispevok']);

		echo('Žiaľ, <!--váš príspevok-->tému sa, chybou našej databáze, nepodarilo zaslať. <span id="js-help"></span>');
		echo <<<JS
<script>
(function() {
	// store placeholder
	var help = document.getElementById('js-help');
	// parse cookies
	var cookies = document.cookie.split(';')
	for(var cookie, len = cookies.length, r = 0; r < len; r++) {
		cookie = cookies[r].trim().split('=');
		cookies[cookie[0].toString()] = cookie[1];
		delete cookies[r];
	}
	// check for cookie
	if(cookies['-newtopic-saved-title'] || cookies['-newtopic-saved-post']) {
		help.innerHTML = "Váš príspevok sa však zachoval. Ak chcete tému vytvoriť, vráťte sa v histórii a skúste to znova.";
	}
})();
</script>
JS;
	}
}

?>


