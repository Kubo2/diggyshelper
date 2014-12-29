<?php

session_start();
header("Content-Type: text/html; charset=utf-8", true, 200);

?><!DOCTYPE HTML>
<?php include 'includes/head.php' ?>
</head><body>
<?php
	include 'includes/header.php';
	include 'includes/menu.php';
	include 'includes/submenu.php';
		?>
	<div id="pages">
		<h1>Sútaže</h1>
		<p><i>Sútaže sa uskutočnia až po spustení novej verzie stránky Diggy's Helper.</i></p>
	</div>
<?php include 'includes/footer.php' ?>
