<?php

/**
 * @todo učesať a zrefaktorovať kód
 * @internal requires PHP >= 5.4
 */


require __DIR__ . '/functions.php';
session_start();

if(loggedIn()) { // iba ak je užívateľ prihlásený
	if(isset($_POST['prispevok'])) { // iba ak existuje príspevok
		$error  = false;

		if(false === require('./db-connector/connect.php'))
			$error = "!db";
		elseif(empty($_POST["tid"]) || empty($_POST["cid"]))
			$error = "!id";
		elseif(!trim($_POST["prispevok"]))
			$error = "!post";

		if((bool) $error) goto error_occured;

		list($c, $t, $u) = [ intval($_POST["cid"]), intval($_POST["tid"]), intval($_SESSION["uid"]) ];
		$post = mysql_real_escape_string($_POST['prispevok']); // TODO: kontrola badwords

		mysql_query("LOCK TABLES `posts` WRITE");
		mysql_query("START TRANSACTION");
			$updated= 
				mysql_query( "
					UPDATE `categories`
					SET `last_post_date` = NOW(), `last_user_posted` = $u 
					WHERE `id` = $c
			" ) &&
				mysql_query( "
					UPDATE `topics`
					SET `topic_reply_date` = NOW(), `topic_last_user` = $u
					WHERE `id` = $t
			" );
			if(!$updated) goto db_error;
			
			$inserted= mysql_query( "
				INSERT INTO posts (`category_id`, `topic_id`, `post_creator`, `post_content`, `post_date`)
				VALUES ($c, $t, $u, '$post', NOW())
			" );
			if(!$inserted) goto db_error;
		mysql_query("COMMIT");
		mysql_query("UNLOCK TABLES");
		// success
		header("Location: http://$_SERVER[SERVER_NAME]" . dirname($_SERVER["PHP_SELF"]) . "/view_topic.php?tid=$t&cid=$c", true, 302);
		exit;

		db_error:
		mysql_query("ROLLBACK");
		mysql_query("UNLOCK TABLES");
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
		, true
		, 302
	);
	exit;
}

// general redirect — user is not signed in
header("Location: http://$_SERVER[SERVER_NAME]" . dirname($_SERVER["PHP_SELF"]) . "/index.php", true, 302);
