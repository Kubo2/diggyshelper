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

	

	<?php include 'includes/submenu.php'; ?>

	

	<div id="pages">

		Sútaže:<br><br>

		<font color="red">!!! Sútaže sa uskutočnia až po spustení novej verzie stránky Diggy's Helper !!!</font>

	</div>



	<?php include 'includes/footer.php'; ?>

</body>

</html>