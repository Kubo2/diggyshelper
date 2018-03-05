<?php

header('Content-Type: text/html; charset=UTF-8', TRUE, 200);
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
		<div style="width: 100%; text-align: center;">
			<h2>O hre Diggy's Adventure</h2>
			<img src="images/bg/logo-DA.png">
		</div>
		<P>
			Kto povedal, že&nbsp;všetky mýtické poklady už boli objavené? 
			Prekop&nbsp;sa&nbsp;s&nbsp;Diggym k&nbsp;tajomstvám ukrytým 
			pod zemou. Si pripravený na dobrodružstvo? Zbožňuješ staroveké 
			civilizácie a ich záhady? Chcel by si objavovať dávno stratené chrámy 
			a zabudnuté kobky? Tak potom si ten pravý. Tajomstvá ukryté tisícky 
			rokov pod zemou legendárnych území po celom svete čakajú len na tvoje 
			šikovné ruky a myseľ objaviteľa. Pridaj sa k Profesorovi, Linde a robotovi 
			Rustymu, postav kemp a vydaj sa na dobrodružstvo tvojho života.
		</P>
		<div style="width: 100%; text-align: center;">
			<a href="http://portal.pixelfederation.com/diggysadventure/?lang=SK" target="blank" class="playgamepp">Hraj na Pixel Portáli</a>
			<a href="https://apps.facebook.com/diggysadventure/" target="blank" class="playgamefb">Hraj na Facebooku</a>
		</div>

		<h3 style="text-align: center">O firme PIXEL FEDERATION:</h3><p>
		Firma <a class="memberusers" href="http://www.pixelfederation.com/?lang=sk" target="blank">PIXEL FEDERATION</a> 
		bola založená v roku 2007 štyrmi nadšencami z herného priemyslu a venuje sa 
		výhradne tvorbe online webových a mobilných hier, jednou z nich je aj 
		spomínaný Diggy's Adventure. Inovatívne myslenie či entuziazmus v tíme dopĺňajú 
		skúsenosti z vlastných herných projektov. Tá správna kombinácia ľudí s rôznym 
		backgroundom nám umožňuje zdolávať výzvy, ktoré dnešný game development 
		ponúka. Nájdete nás v hlavnom meste Slovenska, v Bratislave.
	</div>
	<?php include 'includes/footer.php' ?>
</body>
</html>
