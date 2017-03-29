<?php

session_start();
ob_start();
header('Content-Type: text/html; charset=UTF-8', TRUE, 200);


/**
 * @var array(úroveň => array(odmeny, obrázok))
 */
$odmeny = array(
	2 => ['100 mincí, 10 gemov, 100 energie', 'http://img.djpw.cz/hsf.png'],
	3 => ['100 mincí, 10 jabĺk, 110 energie', 'http://img.djpw.cz/gsf.png'],
	4 => ['100 mincí, 5x múka, 10 jabĺk, 120 energie', 'http://img.djpw.cz/csf.png'],
	5 => ['10 gemov, 100 mincí, 10 jabĺk, 130 energie', 'http://img.djpw.cz/nse.png'],
	6 => ['100 mincí, 10 jabĺk, 140 energie', 'http://img.djpw.cz/ose.png'],
	7 => ['100 mincí, 10 jabĺk, 150 energie', 'http://img.djpw.cz/tse.png'],
	8 => ['100 mincí, 10 jabĺk, 160 energie', 'http://img.djpw.cz/use.png'],
	9 => ['100 mincí, 20 jabĺk, 170 energie', 'http://img.djpw.cz/use.png'], // taký istý obrázok ako level 8?
	10 => ['5 gemov, 100 mincí, 20 jabĺk, 180 energie', 'http://img.djpw.cz/wse.png'],
	11 => ['100 mincí, 20 jabĺk, 190 energie', 'http://img.djpw.cz/xse.png'],
	12 => ['100 mincí, 20 jabĺk, 200 energie', 'http://img.djpw.cz/yse.png'],
	19 => ['150 mincí, 1x fazule v konzerve, 50 jabĺk, 340 energie', 'http://img.djpw.cz/upf.png'],
	20 => ['5 gemov, 150 mincí, 360 energie', 'http://img.djpw.cz/avf.png'],
	21 => ['200 mincí, 1x fazule v konzerve, 380 energie', 'http://img.djpw.cz/bvf.png'],
	22 => ['200 mincí, 400 energie', 'http://img.djpw.cz/cvf.png'],
	23 => ['1x fazule v konzerve, 200 mincí, 420 energie', 'http://img.djpw.cz/dvf.png'],
	24 => ['50 jabĺk, 200 mincí, 440 energie', 'http://img.djpw.cz/gvf.png'],
	25 => ['5 gemov, 1x pečené kurča, 200 mincí, 460 energie', 'http://img.djpw.cz/kwf.png'],
	27 => ['200 mincí, 1x pečené kurča, 500 energie', 'http://img.djpw.cz/zwf.png'],
	90 => ['800 mincí, 5 gemov, 7900 energie', 'http://img.djpw.cz/wtf.jpeg'],
);


?>
<!DOCTYPE HTML>
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
		<p>Obetoval som pre vás veľké množstvo energie (v Diggy's Adventure), aby som vám
		odhalil kde, koľko a čoho miniete a získate. Dúfam, že vám to pri ďalšom kopaní aspoň trochu pomôže.
		(<a class="memberusers" href="profile.php?user=WladinQ">WladinQ</a>)

		<p style='margin-top: .3em; font-size: larger'>
			Chceš sa aj ty podeliť o svoje kopáčske zážitky?
			<a href='forum.php' class='memberusers'>Pozri sa</a> na naše fórum a <a href='register.php' class='memberusers'>zaregistruj sa</a>,
			aby si si mohol/la aj ty vytvárať vlastné vlákna.
		</p>

		<!-- ================================== -->
		<hr>
		<h2>Resetovateľné bane</h2>

		<!-- ================================== -->
		<table id="mob-no">
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
		<table id="mob-no">
			<caption><h3>Škandinávia</h3></caption>
			<tr>
				<td><b>BAŇA</b></td> <td><b>POLÍČOK</b></td> <td><b>MINUTEJ ENERGIE</b></td> <td><b>ZÍSKANÉ SKÚSENOSTI</b></td> <td><b>ZÍSKANÉ ZLATO</b></td> <td><b>ZÍSKANÝ METERIÁL</b></td> <td><b>RESETOVACIA DOBA</b></td>
			</tr>
			<tr>
				<td>Hrdzavé jaskyne</td> <td>50</td> <td>3220</td> <td>3610</td> <td>cca 139</td> <td>28 železnej rudy</td> <td>8 hodín</td>
			</tr>
		</table>

		<!-- ================================== -->
		<br><hr>
		<h2>Odmeny za úrovňe</h2>

		<table style="text-align: center;">
			<tr>
				<td><b>ÚROVEŇ</b></td>
				<td><b>ODMENY</b></td>
				<td><b>OBRÁZOK</b></td>
			</tr>

			<?php foreach($odmeny as $úroveň => $detaily): ?>
			<tr>
				<td>Úroveň <?= $úroveň ?></td>
				<td><?= $detaily[0] ?></td>
				<td><a rel='noopener' target='_blank' href='<?= $detaily[1] ?>'><span id='mob-no'>Zobraziť </span>obrázok</td>
			</tr>
			<?php endforeach ?>

		</table>
	</div>
	<?php include 'includes/footer.php'; ?>
</body>
</html>
