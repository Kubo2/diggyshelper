<?php

require __DIR__ . '/functions.php';

/**
 * @todo učesať a zrefaktorovať kód
 * @internal requires PHP >= 5.4
 */


$dbContext = require __DIR__ . '/connect.php';

session_start();

if(loggedIn()) { // iba ak je užívateľ prihlásený
	if(isset($_POST['prispevok'])) { // iba ak existuje príspevok
		$error = FALSE;

		if(!$dbContext)
			$error = "!db";
		elseif(empty($_POST["tid"]))
			$error = "!id";
		elseif(!trim($_POST["prispevok"]))
			$error = "!post";

		if($error) goto error_occured;

		list($t, $u) = [ intval($_POST["tid"]), intval($_SESSION["uid"]) ];
		$post = mysql_real_escape_string($_POST['prispevok'], $dbContext); // TODO: kontrola badwords

		$markup = 'bb'; // default for non-admin users
		$type = getUser($dbContext, $u, 'access');

		if($type === 'admin' && !empty($_POST['post-markup'])) {
			$markup = in_array($_POST['post-markup'], ['html', 'bb']) ? $_POST['post-markup'] : $markup;
		}

		mysql_query('LOCK TABLES `posts` WRITE', $dbContext);
		mysql_query('START TRANSACTION', $dbContext);
			$updated = 
				mysql_query("
					UPDATE `categories`
					SET `last_post_date` = NOW(), `last_user_posted` = $u 
					WHERE `id` = (SELECT category_id FROM topics WHERE `id` = $t)
			", $dbContext) &&
				mysql_query("
					UPDATE `topics`
					SET `topic_reply_date` = NOW(), `topic_last_user` = $u
					WHERE `id` = $t
			", $dbContext);
			if(!$updated) goto db_error;
			
			$inserted = mysql_query("
				INSERT INTO posts (`topic_id`, `post_creator`, `post_content`, `post_markup`, `post_date`)
				VALUES ($t, $u, '$post', '$markup', NOW())
			", $dbContext);
			if(!$inserted) goto db_error;
		mysql_query('COMMIT', $dbContext);
		mysql_query('UNLOCK TABLES', $dbContext);
		// success
		header("Location: http://$_SERVER[SERVER_NAME]" . dirname($_SERVER["PHP_SELF"]) . "/view_topic.php?tid=$t", TRUE, 302);
		exit;

		db_error:
		mysql_query('ROLLBACK', $dbContext);
		mysql_query('UNLOCK TABLES', $dbContext);
		$error = "!ins";
	} else {
		$error = "!post";
	}
	error_occured:
	header(
		"Location: http://" 
		. $_SERVER["SERVER_NAME"] 
		. dirname($_SERVER["PHP_SELF"]) 
		. "/post_reply.php?flash=" 
		. ($error ? $error : "!")
		, TRUE
		, 302
	);
	exit;
}

// general redirect — user is not signed in
header("Location: http://$_SERVER[SERVER_NAME]" . dirname($_SERVER["PHP_SELF"]) . "/index.php", TRUE, 302);
