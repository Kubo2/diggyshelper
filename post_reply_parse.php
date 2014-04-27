<?php 

session_start();

if(isset($_SESSION['uid'])) {
	if(isset($_POST['reply_submit'])) {
		include_once("connect.php"); // chýba overenie, či sa vôbec podarilo pripojiť
		$creator = intval($_SESSION['uid']);
		$cid = intval($_POST['cid']);
		$tid = intval($_POST['tid']);
		// skontrolovať, či nie je prádzny, ťa nenapadlo?
		$reply_content = $_POST['prispevok'];
		// a zase tá atomicita
		// doriti
		$sql = "INSERT INTO posts (category_id, topic_id, post_creator, post_content, post_date) VALUES ('".$cid."', '".$tid."', '".$creator."', '".$reply_content."', now())";
		$res = mysql_query($sql);// or die(mysql_error());
		$sql2 = "UPDATE categories SET last_post_date=now(), last_user_posted='".$creator."' WHERE id='".$cid."' LIMIT 1";
		$res2 = mysql_query($sql2);// or die(mysql_error());
		$sql3 = "UPDATE topics SET topic_reply_date=now(), topic_last_user='".$creator."' WHERE id='".$tid."' LIMIT 1";
		$res3 = mysql_query($sql3);// or die(mysql_error());
		if(($res) && ($res2) && ($res3)) {
		// aj by som to napísal lepšie, keby neboli dve hodiny ráno
			header("Location: view_topic.php?tid=$tid&cid=$cid", true, 302);
		} else {
			echo "<p>Problem pri odoslani vasej odpovede. Skuste to znova neskor.</p>";
		}
}


?>


