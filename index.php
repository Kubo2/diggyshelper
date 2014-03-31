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
		<center>
			<h3>Vítam ťa na stránke Diggy's Helper</h3>
			<img src="images/bg/logo-DA.png">
		</center><br>
		Kto povedal, že všetky mýtické poklady už boli objavené? Prekop sa s Diggym k tajomstvám ukrytým pod zemou. Si pripravený na dobrodružstvo? Zbožňuješ staroveké civilizácie a ich záhady? Chcel by si objavovať dávno stratené chrámy a zabudnuté kobky? Tak potom si ten pravý. Tajomstvá ukryté tisícky rokov pod zemou legendárnych území po celom svete čakajú len na tvoje šikovné ruky a myseľ objaviteľa. Pridaj sa k Profesorovi, Linde a robotovi Rustymu, postav kemp a vydaj sa na dobrodružstvo tvojho života.<br><br>
		<center>
			<a href="http://portal.pixelfederation.com/diggysadventure/?lang=SK" target="blank" class="playgamepp">Hraj na Pixel Portáli</a>
			<a href="https://apps.facebook.com/diggysadventure/" target="blank" class="playgamefb">Hraj na Facebooku</a>
		</center><br><br>
		<b>O firme PIXEL FEDERATION:</b><br>
		Firma <a class="memberusers" href="http://www.pixelfederation.com/?lang=sk" target="blank">PIXEL FEDERATION</a> bola založená v roku 2007 štyrmi nadšencami z herného priemyslu a venuje sa výhradne tvorbe online webových a mobilných hier, jednou z nich je aj spomínaný Diggy's Adventure. Inovatívne myslenie či entuziazmus v tíme dopĺňajú skúsenosti z vlastných herných projektov. Tá správna kombinácia ľudí s rôznym backgroundom nám umožňuje zdolávať výzvy, ktoré dnešný game development ponúka. Nájdete nás v hlavnom meste Slovenska, v Bratislave.
	</div>
	<?php include 'includes/footer.php' ?>
</body>
</html>