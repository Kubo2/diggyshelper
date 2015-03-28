<?php

session_start();
header("Content-Type: text/html; charset=utf-8", true, 200);

?>
<!DOCTYPE HTML>
<html><head>
	<?php ($titleConst = 'dh: Súťaže o gemy -- Diggy\'s Adventure') && include 'includes/head.php' ?>
</head><body>
<?php
	include 'includes/header.php';
	include 'includes/menu.php';
	include 'includes/submenu.php'
		?>
	<div id="pages">
		<big>Sútaže:</big><br><br>
		<font style='color: red; font-style: italic; font-size: 110%'>Sútaže sa uskutočnia až po spustení novej verzie stránky Diggy's Helper.</font>
	</div>
	<?php include 'includes/footer.php' ?>
</body></html>
