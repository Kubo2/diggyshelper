<?php

// ak skript nie je volaný metódou POST, pošleme 405 a krátku správu
if($_SERVER["REQUEST_METHOD"] != 'POST') {
	if(isset($_SERVER["HTTP_USER_AGENT"]) && stripos($_SERVER["HTTP_USER_AGENT"], 'bot') !== false) {
		header("Allow: POST", true, 405);
		header("Content-Type: text/plain; charset=utf-8");
		echo "You can not call this file with HTTP $_SERVER[REQUEST_METHOD] method.\n\n";
		echo "This resource is available only via HTTP POST method.";
	} else {
		goto presmerovanie;
	}
	exit;
}

// zašleme session identifikátor
session_start();

// ak sme už prihlásení, presmerujeme
if(isset($_SESSION['uid'])) goto presmerovanie;

// nie sme prihlásení: ak teda už existuje cookie so session identifikátorom, vygenerujeme nový
if(isset($_COOKIE[ini_get('session.name')])) {
	session_regenerate_id();
}

// ak užívateľ neposlal minimálne username, nemá záujem o prihlásenie
if(empty($_POST["username"])) goto presmerovanie;

// samotný proces prihlasovania
$errorMessage = "";
if(!empty($_POST["password"])) {
	if(!defined('DB_CONNECTED') && FALSE === require("./connect.php")) {
		$errorMessage = "Ospravedlňujeme sa Vám, no naša databáza je bohužiaľ na niekoľko minút nedostupná. Skúste sa prihlásiť opäť o niekoľko minút.";
		goto login_errorpage;
	}
}

// sme pripojení k databázi/databáze
// ošetríme vstupy
$userdata = [
	"nick" => mysql_real_escape_string($_POST["username"]),
	"password" => mysql_real_escape_string($_POST["password"]),
];

// poskladáme dotaz
// 	- exists - 0/1 (neexistuje/existuje)
// 	- id - NULL/int (neexistuje/id používateľa)
$usr = <<<SQL
SELECT COUNT(`id`) AS `exists`, `id` 
FROM `users` 
WHERE 
	`username` = '$userdata[nick]'
AND 
	`password` = MD5('$userdata[password]')
SQL;

// posielame dotaz
$rs = mysql_query($usr);

// prázdne heslo alebo podobný problém
if(!$rs) {
	goto login_errorpage;
}

// fetchneme si jeden riadok result-setu
$det = mysql_fetch_assoc($rs);

// kontrolujeme, či užívateľ existuje, prípadne zadal zlé heslo
if( ! (bool) (int) $det['exists'] ) {
	$errorMessage = "Zadali ste zlé heslo. Prosím, skontrolujte, či nemáte zapnutú funkciu <kbd>Caps Lock</kbd>, prípadne zopakujete svoj pokus s využitím nástroja <em>Odkryť heslo</em>.";
	goto login_errorpage;
}

// užívateľ existuje
$_SESSION = [
	"uid" => (int) $det['id'],
	"username" => $_POST['username'],
];

presmerovanie:

// kam presmerovať
$redirectTo = "http://$_SERVER[SERVER_NAME]/" . trim(dirname($_SERVER["SCRIPT_NAME"]), '/') . "/index.php";

// presmerovať na referer?
$ref = !isset($_POST["redirect-noreferer"]);

// ak existuje referrer a je z nášho servera, presmeruj na referrer
if(
	isset($_SERVER["HTTP_REFERER"])
	&& preg_match('~^https?://' . preg_quote($_SERVER["SERVER_NAME"]) . '/~', $_SERVER["HTTP_REFERER"])
	&& $ref) {
	$redirectTo = $_SERVER["HTTP_REFERER"];
}

// presmeruj na správnu adresu
//print($redirectTo); # the bug unpacker
header("Location: $redirectTo", true, 302);

exit;

// chybová stránka prihlasovania
login_errorpage:
header("Content-Type: text/html; charset=utf-8", true, 401);
?>
<html>
	<head>
		<meta charset='utf-8'>
		<?php $titleConst = "Login Error &bull; Chyba prihlásenia"; include "includes/head.php" ?>
	</head>
<body>
	<?php 
		include "includes/header.php";
		include "includes/menu.php";
		include "includes/submenu.php";
	?>
	<div class="pages" style="width: auto; margin: 0 auto">
		<h1>Prihlásenie zlyhalo</h1>
		<p class="error message"><?php echo !empty($errorMessage) ? $errorMessage : "Pri operácii nastala chyba."; ?></p>
	</div>
</body>
</html>
