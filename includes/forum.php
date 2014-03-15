<?php session_start(); ?>
<div id="forum">
<?php
if (!isset($_SESSION['uid'])) {
?><form action='login.php' method='post'>
	<input class='input' type='text' name='username' placeholder='Nickname' autocomplete="on">&nbsp;
	<input class='input' type='password' name='password' placeholder='Heslo' autocomplete="off">&nbsp;
	<input class='input' type='checkbox' name='remember'> Neodhlasovať ma&nbsp;
	<input type='submit' name='submit' class='input_button' value='Prihlásiť sa'>&nbsp;
	<a class='button_register' href='register.php'>Registrovat sa</a>
</form><?php
} else {
	echo <<<WELCOMEUSER
Vitaj <span style="color:#106CB5">$_SESSION[username]</span>!
	<div class='right'><a class='button_logout' href='logout.php'>Odhlásiť sa</a></div>
WELCOMEUSER;
}
?>

<hr>
<div id="content">
	<?php
		include_once("connect.php");
		$sql = "SELECT * FROM categories ORDER BY category_title ASC";
		$res = mysql_query($sql) or die(mysql_error());
		$categories = "";
		if (mysql_num_rows($res) > 0) {
			while ($row = mysql_fetch_assoc($res)) {
				$id = $row['id'];
				$title = $row['category_title'];
				$descrition = $row['category_description'];
				$categories .= "<a href='view.php?cid=".$id."' class='cat_links'>".$title."<br><font size='-1'>".$descrition."</font></a>";
			}
			echo $categories;
		} else {
			echo "<p>Zatiaľ nie sú k dispozícii žiadne kategórie.</p>";
		}
	?>
</div>
</div>
<div id="statistiky">
	<?php include 'includes/statistiky.php'; ?>
</div>
</center>