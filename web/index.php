<?php

header("Content-Type: text/html; charset=utf-8", true, 200);
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'includes/head.php' ?>
</head>
<body>
	<?php 
		include 'includes/header.php';
		include 'includes/menu.php';
		include 'includes/submenu.php'; 
	?>
	<div id="pages">
		<h2 style="text-align: center">Vítame ťa na stránke Diggy's Helper</h2>
		<p><strong>Diggy's Helper je diskusné fórum</strong>, kde sa môžeš  s komunitou ľudí s rovnakou
		záľubou podeliť o svoje postrehy a skúsenosti s hrou Diggy's Adventure. <a class="memberusers" href="http://diggyshelper.net/whatandhow.php">Viac info o hre Diggy's Adventure</a>
		<br>Taktiež v prípade, že niečomu nerozumieš alebo sa chceš o niečom dozvedieť viac, sú tu vítané tvoje
		otázky a problémy. Stačí vybrať správnu kategóriu a vytvoriť v nej tému.
	</div>
	<?php include 'includes/footer.php' ?>
</body>
</html>