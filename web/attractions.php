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
	<?php

	$GLOBALS['titleConst'] = "Postrehy, zaujímavosti z Diggy's Adventure"; // intentionally $GLOBALS -- preseve "magic dependencies"
	include 'includes/head.php';

	?>
</head>
<body>
	<?php include 'includes/header.php'; ?>
	
	<?php include 'includes/menu.php'; ?>
	
	<?php include 'includes/submenu.php'; ?>
	
	<div id="zaujimavosti">
		<h1>Zaujímavosti</h1>
		<p><strong>Obetoval som pre vás veľké množstvo energie</strong> (v Diggy's Adventure), aby som vám
		odhalil kde, koľko a čoho miniete a získate. Dúfam, že vám to pri ďalšom kopaní aspoň trochu pomôže.
		<cite><a class="memberusers" href="profile.php?user=WladinQ">WladinQ</a></cite>
		<p style='margin-top: .3em; font-size: larger'><strong>Chcete sa aj vy podeliť o vaše kopáčske zážitky?</strong>
			<a href='./' class='memberusers'>Prezrite si</a> naše fórum a <a href='./register.php' class='memberusers'>zaregistrujte sa</a>,
			aby ste si mohli aj vy vytvárať vlastné vlákna.</p>

		<!-- ================================== -->
		<h2 style='text-align: center'>Resetovateľné bane</h2>

		<!-- ================================== -->
		<table border="1px" frame="void">
		<caption><h3>Egypt</h3></caption>
			<tr>
				<td><b>BAŇA</b></td> <td><b>POLÍČOK</b></td> <td><b>MINUTEJ ENERGIE</b></td> <td><b>ZÍSKANÉ SKÚSENOSTI</b></td> <td><b>ZÍSKANÉ ZLATO</b></td> <td><b>ZÍSKANÝ METERIÁL</b></td> <td><b>RESETOVACIA DOBA</b></td>
			</tr>
			<tr>
				<td>Uhoľná kaverna</td> <td>25</td> <td>544</td> <td>cca 609</td> <td>cca 17</td> <td>Meď 18</td> <td>8 hodín</td>
			</tr>
			<tr>
				<td>Kováčske dielne</td> <td>33</td> <td>483</td> <td>cca 537</td> <td>cca 29</td> <td>1 Plech</tdr> <td>23 hodín</td>
			</tr>
			<tr>
				<td>Sad</td> <td>42</td> <td>300</td> <td>cca 327</td> <td>cca 7</td> <td>15 Brusníc, 8 Melónov</td> <td>8 hodín</td>
			</tr>
			<tr>
				<td>Luxorská knižnica</td> <td>13</td> <td>1040</td> <td>2280</td> <td>0</td> <td>0</td> <td>23 hodín</td>
			</tr>
			<tr>
				<td>Hubáreň</td> <td>44</td> <td>675</td> <td>cca 743</td> <td>cca 40</td> <td>35 Húb</td> <td>23 hodín</td>
			</tr>
		</table>

		<!-- ================================== -->
		<table border="1px" frame="void">
		<caption><h3>Škandinávia</h3></caption>
			<tr>
				<td><b>BAŇA</b></td> <td><b>POLÍČOK</b></td> <td><b>MINUTEJ ENERGIE</b></td> <td><b>ZÍSKANÉ SKÚSENOSTI</b></td> <td><b>ZÍSKANÉ ZLATO</b></td> <td><b>ZÍSKANÝ METERIÁL</b></td> <td><b>RESETOVACIA DOBA</b></td>
			</tr>
			<tr>
				<td>Hrzdavé jaskyne</td> <td>50</td> <td>3220</td> <td>3610</td> <td>cca 139</td> <td>28 Železnej rudy</td> <td>8 hodín</td>
			</tr>
		</table>
	</div>
	<?php include 'includes/footer.php'; ?>
</body>
</html>