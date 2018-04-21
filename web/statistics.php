<?php

/**
 * Summaries and statistical data about dh Forum usage.
 */


$dbContext = require __DIR__ . '/connect.php';


// headers
header('Content-Type: text/html; charset=UTF-8', TRUE, 200);

session_start();

?>
<!DOCTYPE HTML>
<html>
<head>
	<style type="text/css">
	td {
		text-align: center;
		width: 300px;
	}
	tr:first-child td {
		background: #33cc00;
	}
	table {
		margin: auto;
	}
	</style>
	<?php

	$GLOBALS['titleConst'] = "Štatistiky Diggy's Helper"; // intentionally $GLOBALS -- preseve "magic dependencies"
	include 'includes/head.php';

	?>
	<meta content="Jednoduchá štatistika aktivity na Diggy's Helper" name='description'>
</head>
<body>
	<?php include 'includes/header.php'; ?>

	<?php include 'includes/menu.php'; ?>

	<?php include 'includes/submenu.php'; ?>

	<div id="statistiky">

	<?php

	$membersCount = mysql_query("SELECT COUNT(*) FROM `users`", $dbContext);
	$newestMember = mysql_query("SELECT `username`
FROM `users`
WHERE `registerdate` = (
	SELECT MAX(`registerdate`)
	FROM `users`
)
", $dbContext);
	$mostActiveMember = mysql_query("SELECT u.username, p.post_creator AS id, COUNT(p.post_creator) AS posts_count
FROM posts p
JOIN users u on u.id = p.post_creator
GROUP BY post_creator
ORDER BY posts_count DESC
LIMIT 1", $dbContext);
	$newestTopic = mysql_query("SELECT id, category_id, topic_title
from topics
where topic_date = (
	select max(topic_date)
	from topics
)", $dbContext);

	$membersCount = $membersCount ? mysql_fetch_row($membersCount) : array(-1);
	if($newestMember)
		$newestMember = mysql_fetch_assoc($newestMember);
	if($mostActiveMember)
		$mostActiveMember = mysql_fetch_assoc($mostActiveMember);
	if($newestTopic)
		$newestTopic = mysql_fetch_assoc($newestTopic);
	?>

	<p>
		<h3>Počet zaregistrovaných užívateľov: ... <?php echo $membersCount[0] ?> ...</h3>

		Najnovší člen: <?php
				if(!$newestMember)
					echo "Nedostupný.";
				else { ?>
				<a class="memberusers" href="./profile.php?user=<?php echo urlencode($newestMember['username']) ?>">
					<?php echo $newestMember['username']; ?><!--
				--></a>.
				<?php } ?><br><br>
		Najaktívnejší člen: <?php
				if(!$mostActiveMember)
					echo "Nedostupný.";
				else { ?>
				<a class="memberusers" href="./profile.php?user=<?php echo urlencode($mostActiveMember['username']) ?>">
					<?php echo $mostActiveMember['username']; ?>
				</a> so svojimi <font style="color: red"><?php echo $mostActiveMember['posts_count']; ?></font> príspevkami.
				<?php } ?><br><br>
		Najnovšia téma: <?php
				if(!$newestTopic)
					echo "Žiadna.";
				else { ?>
				<b><a class="naj" href="./view_topic.php?tid=<?php echo $newestTopic['id'] ?>">
					<?php echo $newestTopic['topic_title']; ?>
				</a></b>.
				<?php } ?>
	</p>

	<h3>O používateľoch fóra Diggy's Helper</h3>
		<p>Administrátormi fóra sú: <a class="memberusers" href="profile.php?user=WladinQ">WladinQ</a> &amp; <a class="memberusers" href="profile.php?user=Kubo2">Kubo2</a></p>
		<?php
		$admins =  mysql_query("SELECT `username` FROM `users` WHERE `access` IN ('admin', 'moderator') AND NOT `username` IN ('Kubo2', 'WladinQ')", $dbContext); # intentionally hardcoded
		if($admins) {
			echo "<h4>Moderátori fóra</h4>\n<ul>\n";
			while(($admin = mysql_fetch_assoc($admins)) !== false) {
				echo "\t<li>\n\t";
				echo "\t<a class='memberusers' href='$absUrl/profile.php?user=" .urlencode($admin['username']). "'>$admin[username]</a>\n";
				echo "\t</li>";
			}
			echo "</ul>\n";
		}
		?>
		
	<?php if(false) { ?>
	~Programátor Kubo2: Odmazaná kopa balastu a dlhočizná zbytočná tabuľka. Tá bude nahradená komplexnejším výpisom používateľov.
	Ďalej chcem podotknúť, že nie je možné vypisovať sem všetkých používateľov, pretože ich môže neskôr byť nesmierne veľa (cirka 100-300).
	Namiesto toho výpis nahradím napríklad vyhľadávaním používateľov, pretože keď bude niekto chcieť vidieť používateľov profil, určite 
	si nebude prezerať 10 obrazoviek odkazov na používateľské profily. Okrem toho by takýto výpis používateľov mohol byť zneužitý na spam. 
	Naviac informácie, ktoré boli o používateľoch uvedené v tabuľke, sem nepatrili, ale naopak priamo do používateľského profilu.

	Vzhľadom k vyššie uvedeným dôvodom sa prikláňam skôr ku pridaniu všeobecných informácií (prípadne nejakých ľahších štatistík) o používateľoch 
	na túto stránku.

	~Programátor Kubo2: Poznámka. Tento text je určený iba ku orientácii v pláne akcií a pre zaistenie informovanosti prvého autora 
	a zakľadateľa fóra Diggy's Helper Vladimíra WladinQa Jacka. Tento text môže zostať v zdrojovom kóde, i keď sa nikdy nezobrazí.
	<?php } ?>
	</div>

	<?php include 'includes/footer.php'; ?>
</body>
</html>
