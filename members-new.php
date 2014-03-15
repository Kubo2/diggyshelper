<?php
require "./connect.php"; // database connection
header("Vary: X-Requested-With", true);
if(
	isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest"
    && !empty($_SERVER['HTTP_X_USER_ID'])
  ) {
	header("Vary: X-Requested-With, X-User-Id", true, 200);
	header("Content-Type: text/json; charset=utf-8");
	$id = intval($_SERVER['HTTP_X_USER_ID']);
	if($id > 0) {
		$dotaz = "SELECT username, access, DATE_FORMAT(registerdate, '%e. %c. roku %Y') as registrovany FROM users WHERE id = $id";
		$userinfo = mysql_query($dotaz);
		if($userinfo && mysql_num_rows($userinfo)) {
			$userinfo = mysql_fetch_assoc($userinfo);
			$outputJson = '{ "prezyvka" : "'
				.$userinfo['username']
				.'", "prava" : "'
				.($userinfo['access'] != "member" ? "moderátorom" : "členom")
				.'", "registrovany" : "'
				.$userinfo['registrovany']
				.'" }';
			echo $outputJson;
		} else {
			header("X-Man: First Class", true, 404);
			echo '{ "chyba" : "Neexistujúci používateľ." }';
		}
	} else {
		header("X-Man: First Class", true, 400);
		echo '{ "chyba" : "Nesprávny formát zadaného identifikátoru používateľa." }';
	}
	exit;
}
ob_start();
session_start();
header("Content-Type: text/html; charset=utf-8", true, 200);
//require "./includes/functions.php";
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
	?>	
<div id="loginpassage" style="text-align:center">
<?php
if (!isset($_SESSION['uid'])) { ?>
<form action='login.php' method='post'>
	<input class='input' type='text' name='username' placeholder='Nickname'  title="Nickname">&nbsp;
	<input class='input' type='password' name='password' placeholder='Heslo' title="Heslo">&nbsp;
	<input class='input' type='checkbox' name='remember'> Neodhlasovať ma&nbsp;
	<input type='submit' name='submit' class='input_button' value='Prihlásiť sa'>&nbsp;
	<!--a class='button_logout' href='#'>Zabudli ste heslo?</a>&nbsp;-->
	<a class='button_register' href='./register.php'>Registrovať sa</a>
</form>
<?php } else { ?>
Prihlásený používateľ: <b style="color:#106CB5">
<?php echo $_SESSION['username']; ?>
</b>&nbsp;&rsaquo;&nbsp;<a class='button_logout' href='logout.php'>Odhlásiť sa</a>
<?php } ?>
</div>
<div id="pages">
	<h3>O používateľoch fóra Diggy's Helper</h3>
	<?php $cfg = parse_ini_file("./.config.ini", true); ?>
	<p>Administrátorom fóra je <a style="font-weight:bold;" href="<?php echo $absUrl . "/#member=" . $cfg["administrator"]["user.id"]; ?>"><?php echo $cfg["administrator"]["user.name"]; ?></a></p>
	<?php
	$admins =  mysql_query("SELECT `id`, `username` FROM `users` WHERE `access` IN ('admin', 'moderator') AND NOT `id` = {$cfg['administrator']['user.id']}");
	if($admins) {
		echo "<h4>Moderátori fóra</h4>\n<ul>\n";
		while(($admin = mysql_fetch_assoc($admins)) !== false) {
			echo "\t<li>\n\t";
			echo "\t<a href='$absUrl/#member=$admin[id]'>$admin[username]</a>\n";
			echo "\t</li>";
		}
		echo "</ul>\n";
	}
	?>
	<p>Ak sa chcete dozvedieť štatistické údaje o našich používateľoch, prejdite prosím na stránku <a href="<?php echo $absUrl; ?>/statistics.php">Štatistiky</a>.</p>

<?php if(false) { ?>
~Programátor Kubo2: Odmazaná kopa balastu a dlhočizná zbytočná tabuľka. Tá bude nahradená komplexnejším výpisom používateľov.
Ďalej chcem podotknúť, že nie je možné vypisovať sem všetkých používateľov, pretože ich môže neskôr byť nesmierne veľa (cirka 100-300).
Namiesto toho výpis nahradím napríklad vyhľadávaním používateľov, pretože keď bude niekto chcieť vidieť používateľov profil, určite 
si nebude prezerať 10 obrazoviek odkazov na používateľské profily. Okrem toho by takýto výpis používateľov mohol byť zneužitý na spam. 
Naviac informácie, ktoré boli o používateľoch uvedené v tabuľke, sem nepatrili, ale naopak priamo do používateľského profilu.

Vzhľadom k vyššie uvedeným dôvodom sa prikláňam skôr ku pridaniu všeobecných informácií (prípadne nejakých ľahších štatistík) o používateľoch 
na túto stránku.

~Programátor Kubo2: Poznámka. Tento text je určený iba ku orientácii v pláne akcií a pre zaistenie informovanosti prvého autora 
a zakľadateľa fóra Diggy's Helper Vladimíra WladinQa Jacka. Tento text môže zostať v zdrojovom kóde, ačkoli sa nikdy nezobrazí.
<?php } ?>
	
</div>
<?php include './includes/footer.php'; ?>
</body>
</html>