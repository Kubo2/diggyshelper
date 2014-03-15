<?php
//error_reporting(E_ALL|E_STRICT);
/* Session sa musí inicializovať ešte *pred* odoslaním akéhokoľvek výstupu */
// @see http://php.net/session-start
session_start();

// zapnutie output bufferingu (nemám iný spôsob posielania hlavičiek po výstupe) 
// @see http://php.net/ob-start
@ob_start();

// pridaná HTTP hlavička určujúca kódovanie (neviem, čo máš v head.php, ale pre istotu, keďže 
// si mi písal, že ti nejde utf8) -- diakritika by už mala fachať 
@header("Content-Type: text/html; charset=utf-8", true, 200);

// pre odkomentovanie doctypu jednoducho odstráň sekvenciu -- zo začiatku aj z konca
?>
<!--DOCTYPE HTML-->
<html>
<head>
	<?php include 'includes/head.php'; ?>
</head>
<body>
	<?php include 'includes/header.php'; ?>
	
	<?php include 'includes/menu.php'; ?>
	
	<?php session_start(); ?>
<center>
<div id="loginpassage">
<?php
if (!isset($_SESSION['uid'])) {
	echo "<form action='login.php' method='post'>
	<input class='input' type='text' name='username' placeholder='Nickname' value='' />&nbsp;
	<input class='input' type='password' name='password' placeholder='Heslo' value='' />&nbsp;
	<input class='input' type='checkbox' name='remember'> Neodhlasovať ma&nbsp;
	<input type='submit' name='submit' class='input_button' value='Prihlásiť sa' />&nbsp;
	<a class='button_logout' href='#'>Zabudli ste heslo?</a>&nbsp;
	<a class='button_register' href='register.php'>Registrovať sa</a>
	";
} else {
	echo "Vitaj <font color='#106CB5'>".$_SESSION['username']."</font> !
	<a class='button_logout' href='logout.php'>Odhlásiť sa</a>";
}
?>
</div>
</center>
<div id="forum">
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
			echo "<p>Zatial nie sú k dispozícii žiadne kategórie.</p>";
		}
	?>
</div>
</div>
</center>
	<?php include 'includes/footer.php'; ?>
</body>
</html>