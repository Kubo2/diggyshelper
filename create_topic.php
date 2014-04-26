<?php
session_start();
if ($_SESSION['uid'] == "") {
	header("Location: index.php");
	exit();
}
if (isset($_POST['topic_submit'])) {
	if (($_POST['topic_title'] == "") && ($_POST['prispevok'] == "")) {
		echo "Nevyplnili ste vsetky polia. Prosim, vratte sa na predchadzajucu stranku.";
		exit();
	} else {
		include_once("connect.php");
		$cid = $_POST['cid'];
		$title = $_POST['topic_title'];
		$content = $_POST['topic_content'];
		$creator = $_SESSION['uid'];
		$sql = "INSERT INTO topics (category_id, topic_title, topic_creator, topic_date, topic_reply_date) VALUES ('".$cid."', '".$title."', '".$creator."', now(), now())";
		$res = mysql_query($sql) or die(mysql_error());
		$new_topic_id = mysql_insert_id();
		$sql2 = "INSERT INTO posts (category_id, topic_id, post_creator, post_content, post_date) VALUES ('".$cid."', '".$new_topic_id."', '".$creator."', '".$content."', now())";
		$res2 = mysql_query($sql2) or die(mysql_error());
		$sql3 = "UPDATE categories SET last_post_date=now(), last_user_posted='".$creator."' WHERE id='".$cid."' LIMIT 1";
		$res3 = mysql_query($sql3) or die(mysql_error());
		if (($res) && ($res2) && ($res3)) {
			header("Location: view.php?cid=".$cid."&tid=".$new_topic_id);
		} else {
			echo "Nastal problém pri vytváraní vasej tému. Skúste to prosím znova.";
		}
	}
}
?>