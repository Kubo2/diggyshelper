<?php

session_start();
header("Content-Type: text/html; charset=utf-8", true, 200);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<?php

		$GLOBALS['titleConst'] = 'Ľudia, ktorí sú spojení s Diggy\'s Helper'; // intentionally $GLOBALS -- preseve "magic dependencies"
		include 'includes/head.php';

		?>
		<meta content="Mohlo by Vás zaujímať, kto stojí za vznikom diskusného fóra Diggy's Helper. Prečítajte si to na tejto stránke." name="description">
		<style>
	a[href^='#']:not([href$='#']) {
		font-style: italic;
	}
	div:target, body:target,
	div:not(:target), body:not(:target) {
		transition: none;
	}
	[id]:target {
		outline: 1.8px solid #ff9e49;
		border-top-color: transparent;
		background: #ffcfa4;
		transition: all 1.2s;
	}
	[id]:not(:target) {
		transition: all .7s;
	}
	h1, h2, h3 {
		margin: 0;
		padding: .4em 0 .4em .7em;
		outline: 1.8px solid transparent;
	}
	h2, h3 {
		border-top: 2px dashed silver; 
	}
	p {
		margin: .1em 0 1.2em;
	}
	dd, dt {
		clear: both;
	}
		</style>
	</head>
	<body>
	<?php
		include 'includes/header.php';
		include 'includes/menu.php';
		include 'includes/submenu.php';
	?>
		<div id="pages">
			<article>
	<h1>Autori diskusného fóra Diggy's Helper</h1>
	<p>Kto stojí za vznikom diskusného fóra <b>Diggy's Helper</b>? Či už na našom fóre
	pôsobíte dlhšie, alebo ste nováčik a chceli by ste sa dozvedieť viac o jeho vzniku,
	histórii či autoroch, ste tu správne. Vyberte si záložku (odkaz) alebo čítajte ďalej.</p>
	<p>
		<a class="memberusers" href="#historia">História vzniku</a> &bull;
		<a class="memberusers" href="#autori">Autori fóra</a><i>:</i>
		<a class="memberusers" href="#WladinQ">Vladimír Jacko</a> - 
		<a class="memberusers" href="#Kubo2">Jakub Kubíček</a>
	</p>
	
	<h2 id="historia">História vzniku</h2>
	<p>Ak ste našli cestu k našemu česko-slovenskému fóru, predpokladám, že ste oboznámený s online hrou Diggy's Adventure.
	Táto online hra doposiaľ nemala žiadne Česko-Slovenské fórum, tak sme sa rozhodli jedno fórum pre vás naprogramovať. :-<i>)</i>
	<br>
	Podnet prišiel od Vladimíra Jacka dňa <time datetime='2013-12-08'>8. 12. 2013</time>. Kedže však prácu na fóre nemôže spravovať
	jeden človek, požiadal o pomoc dalších dvoch programarátorov. Fórum sa každým dňom vyvíja. Na jeho stránkach možete nájsť
	napríklad informácie o spoločnosti, ktorá hru Diggy's Adventure vytvorila, ďalej je možné nájsť tu informácie o resetovateľných
	baniach v sekcii <a class="memberusers" href="http://diggyshelper.php5.sk/attractions.php">Zaujímavosti</a>, alebo je k dispozícii
	online česko-slovenská diskusná poradňa v sekcii <a class="memberusers" href="http://diggyshelper.php5.sk/forum.php">Fórum</a>.
	<p>
	Po <a href="./register.php" class='memberusers'>registrácii vlastného používateľského profilu</a> je možné okrem iného prispievať do fóra, podeliť sa 
	s ostatnými o osobné skúsenosti s hrou Diggy's Adventure, položiť vlastnú otázku či napríklad spestriť si profil pridaním svojej fotografie. :-<i>)</i>
	<br>
	Za celý tím Diggy's Helper dúfam, že nájdete na našich stránkach to, čo hľadáte.</p>
	
	<h2 id="autori">Autori fóra</h2>
	<dl>
		<dt id="WladinQ"><a class="memberusers" href="https://www.facebook.com/WladinQ" target="_blank">Vladimír <strong>WladinQ</strong> Jacko</a></dt>
		<dd>
			<img src="images/icon/WladinQ.jpg" style='float: left; width: 180px; margin: .25em 1em 0 0'>
			<p>Vášnivý programátor v najlepších rokoch a zakladateľ projektu
			Diggy's Helper. Pri programovaní najradšej počúva skupinu KABÁT.
			Rád si pozrie dobrý film, miluje prírodu a dobre vychladené pivo.
			Každý deň premýšla ako najlepšie spríjemniť Váš pobyt na našich stránkach.<p>
			Zaoberá sa prevažne dizajnom projektu. </p>
		</dd>
		<dt id="Kubo2"><a class="memberusers" href="http://kubo2.wz.sk/" target="_blank">Jakub <strong>Kubo2</strong> Kubíček</a></dt>
		<dd>
							 <img src="images/icon/Kubo2.jpg" style='float: right; width: 180px'>
							  <p>Mladý programátor zameraný na webové technológie. Ako rýchlostný kanoista 
							  jazdí na pretekárskej kanojke, v lete si často na tréning zájde bicyklom a v zime sa neunúva zostávať 
							  doma, keď sa s rodinou a známimi ide na lyžovačku. Za najlepšie ovocie považuje 
							  exotický kúsok nazývaný pomelo.
							  <!--br-->Medzi jeho ďaľšie záľuby patrí najmä <b>programovanie</b> a tvorba webových 
							  stránok.
							  <br>Na webe je ho možné nájsť pod prezývkou <strong>Kubo2</strong>.</p>

							  <p>Na projekte Diggy's Helper má zásluhy hlavne ako <b>manažér</b> projektu, 
							  <b>programátor</b> serverovej aplikácie v&nbsp;skriptovacom jazyku PHP a klientského 
							  aplikačného rozhrania v jazyku JavaScript.</p>

							  <!-- tento obrázok si musím niekde poznačiť ;-) images/icon/kanoistika-voda.jpg -->
		</dd>
	</dl>
</article>
	</div>
	<?php include 'includes/footer.php'; ?>
</body>
</html>