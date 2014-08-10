<?php

require "./connect.php"; // database connection
session_start();
header("Content-Type: text/html; charset=utf-8", true, 200);

?>
<!--DOCTYPE HTML-->
<html>
<head>
	<?php include './includes/head.php'; ?>
</head>
<body>

	<?php
		include './includes/header.php';
		include './includes/menu.php';
		include './includes/submenu.php';
	?>	

<div id="pages">
	<h3>O používateľoch fóra Diggy's Helper</h3>
	<p>Administrátorom fóra je: <a class="memberusers" style="font-weight: bold" href="profile.php?user=WladinQ">WladinQ</a> &amp; <a class="memberusers" style="font-weight: bold" href="profile.php?user=Kubo2">Kubo2</a></p>
	<?php
	$admins =  mysql_query("SELECT `username` FROM `users` WHERE `access` IN ('admin', 'moderator') AND NOT `id` = {$cfg['administrator']['user.id']}");
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
	<p>Ak sa chcete dozvedieť štatistické údaje o našich používateľoch, prejdite prosím na stránku <a class="memberusers" href="<?php echo $absUrl; ?>/statistics.php">Štatistiky</a>.</p>

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
<?php include './includes/footer.php'; ?>
</body>
</html>