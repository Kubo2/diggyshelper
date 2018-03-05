<?php

// ak skript nie je volaný metódou POST, pošleme 405 a krátku správu
if($_SERVER["REQUEST_METHOD"] != 'POST') {
	if(isset($_SERVER["HTTP_USER_AGENT"]) && stripos($_SERVER["HTTP_USER_AGENT"], 'bot') !== false) {
		header("Allow: POST", true, 405);
		header("Content-Type: text/plain; charset=utf-8");
		echo "You can not call this file with HTTP {$_SERVER['REQUEST_METHOD']} method.\n\n";
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
	session_regenerate_id( $delete_old_session = true );
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

_saveUserBoxInfo($_SESSION['uid']);

presmerovanie:

$schema = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';

// kam presmerovať
$redirectTo = "{$schema}://{$_SERVER['SERVER_NAME']}" . substr($u = $_SERVER['REQUEST_URI'], 0, strrpos($u, '/', -strrpos($u, '?'))) . '/index.php';


// presmerovať na referer?
$ref = !isset($_POST["redirect-noreferer"]);

// ak existuje referrer a je z nášho servera, presmeruj na referrer
if($ref && !empty($_SERVER['HTTP_REFERER']) && preg_match('~^https?://' . preg_quote($_SERVER['SERVER_NAME']) . '/~', $_SERVER['HTTP_REFERER'])) {
	$redirectTo = $_SERVER['HTTP_REFERER'];
}

// presmeruj na správnu adresu
{
	header('Content-Type: text/plain');
	header("Location: $redirectTo", TRUE, 303);

	echo "Resource Has Been Moved To: $redirectTo";

	exit();
}

// chybová stránka prihlasovania
login_errorpage:
header('Content-Type: text/html; charset=UTF-8', TRUE, 403);
?>
<!doctype html>
<html>
	<head>
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

<?php


/**
 * Should be called on successful login/sign-in request.
 * Fetches a pair of information from database and stores it in array( user.posts.count => int, user.reg.date => timestamp )
 * which is then stored in $_SESSION['userbox']. These data are updated only on login.
 *
 * @param int   The internal ID of currently active (logged-in) user
 * @return void
 */
function _saveUserBoxInfo($userId) {

	static $compoundSql = <<<SQL
-- sql select for pulling out user's register date and last post count at once
select count(p.id) posts_count, u.registerdate reg_date
from users u
join posts p
  on p.post_creator = u.id

where u.id = {\$userId}
;
SQL;

	$res = mysql_query(str_replace('{$userId}', $userId, $compoundSql));
	if(!$res) {
		$_SESSION['userbox'] = array( 'user.posts.count' => 0, 'user.reg.date' => NULL );
	}

	$row = mysql_fetch_assoc($res);
	$_SESSION['userbox'] = array( 'user.posts.count' => (int) $row['posts_count'], 'user.reg.date' => strtotime($row['reg_date']) );

	return NULL;
}
