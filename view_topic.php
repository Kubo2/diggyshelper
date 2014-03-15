<html>
<head>
	<?php include 'includes/head.php'; ?>
</head>
<body>
	<?php include 'includes/header.php'; ?>
	
	<?php session_start(); ?>
<div id="forum">
<?php
if (!isset($_SESSION['uid'])) {
	echo "<form action='login.php' method='post'>
	<input class='input' type='text' name='username' placeholder='Nickname' value='' />&nbsp;
	<input class='input' type='password' name='password' placeholder='Heslo' value='' />&nbsp;
	<input class='input' type='checkbox' name='remember'> Neodhlasovat ma&nbsp;
	<input type='submit' name='submit' class='input_button' value='Prihlasit sa' />&nbsp;
	<a class='button_register' href='register.php'>Registrovat sa</a>
	";
} else {
	echo "Vitaj <font color='#106CB5'>".$_SESSION['username']."</font> !
	<div class='right'><a class='button_logout' href='logout.php'>Odhlasit sa</a></div>";
}
?>

<hr />
<div id="content">
	<?php
		include_once("connect.php");
		$cid = $_GET['cid'];
		$tid = $_GET['tid'];
		$sql = "SELECT * FROM topics WHERE category_id='".$cid."' AND id='".$tid."' LIMIT 1";
		$res = mysql_query($sql) or die(mysql_error());
		if (mysql_num_rows($res) == 1) {
			echo "<table width='100%'>";
			if ($_SESSION['uid']) { echo "<tr><td colspan='2'><a class='button' href='javascript:history.back(1)'>Spat</a> | <input type='submit' class='input_button' value='Pridat otazku/odpoved' onClick=\"window.location = 'post_reply.php?cid=".$cid."&tid=".$tid."'\" /><hr />"; } else { echo "<tr><td colspan='2'><a class='button' href='javascript:history.back(1)'>Spat</a> | Na pridanie odpovedi je potrebne sa <font color='#106CB5'><b>Prihlasit</b></font>, alebo sa <font color='#33CC00'><b>Registrovat</b></font>!<hr /></td></tr>"; }
			while ($row = mysql_fetch_assoc($res)) {
				$sql2 = "SELECT p.post_date, p.post_content, u.username as post_creator FROM posts p JOIN users u ON p.post_creator= u.id WHERE category_id='".$cid."' AND topic_id='".$tid."'";
				$res2 = mysql_query($sql2) or die(mysql_error());
				while ($row2 = mysql_fetch_assoc($res2)) {
					echo "<tr><td valign='top' style='border: 2px solid #106CB5;'><div style='min-height: 90px;'><strong>&nbsp;".$row['topic_title']."</strong>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;Pridal/a: <font color='#106CB5'>".$row2['post_creator']."</font> dna <font color='#009933'>".date("d.m.Y / H:i:s", strtotime($row2['post_date']))."</font>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a class='button' href='#'>Upravit</a><hr />".$row2['post_content']."</div></td></tr><tr><td colspan='2'><hr /></td></tr>";
				}
				$old_views = $row['topic_views'];
				$new_views = $old_views + 1;
				$sql3 = "UPDATE topics SET topic_views='".$new_views."' WHERE category_id='".$cid."' AND id='".$tid."' LIMIT 1";
				$res3 = mysql_query($sql3) or die(mysql_error());
			}
			echo "</table>";
		} else {
			echo "<p>Tato tema neexistuje.</p>";
		}
	?>
</div>
</div>
<div id="statistiky">
	<?php include 'includes/statistiky.php'; ?>
</div>
</center>
	<?php include 'includes/footer.php'; ?>
</body>
</html>