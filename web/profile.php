<?php

require "./functions.php"; // some useful miscellanous functionality
require "./connect.php"; // database connection

$id = !empty($_GET['user']) ? mysql_real_escape_string($_GET['user']) : false;
$httpStatus = 200;

$userinfo = [
	"user-name" => null,
	"user-email" => null,
	//"user-email-sanitized" => null,
	"description" => null,
	"user-group" => null,
	"user-register-date" => null,
	"stats-post-count" => null,
	"stats-last-visit" => null,
	"avatar-path" => null,
];

if(!$id) {
	$httpStatus = 404;
	goto page_template;
}

$rawinfo= <<< SQL
	select
		u.username as `user-name`,
		u.email as`user-email`,
		u.description,
		u.access as `user-group`,
		date_format(u.registerdate, '%e. %c. %Y') as `user-register-date`,
		date_format('00-00-0000 00:00', '%e. %c. %Y') as `stats-last-visit`, -- TODO: fix last visit
		count(p.id) as `stats-post-count`
	from
		users u
	join
		posts p
			on
				p.post_creator = u.id
	where
		u.username = '$id'
	having
		username is not null
SQL;

if(defined('DB_CONNECTED')) {
	$rawinfo = mysql_query($rawinfo);

	if(! $rawinfo) {
		$httpStatus = 'databáze'; // very tricky hack
		goto page_template;
	}

	if(!mysql_num_rows($rawinfo)) {
		$httpStatus = 404;
		goto page_template;
	}
	$rawinfo = mysql_fetch_assoc($rawinfo);
}

$userinfo = $rawinfo + $userinfo;

// ====== template start ======
page_template:

session_start();
header("Content-Type: text/html; charset=utf-8", true, (int) $httpStatus);

// template components
require_once("sanitize.lib.php");

// template settings
set_include_path("./includes/");

// ====== template HTML ====== ?>
<!doctype html>
<?php $titleConst = $httpStatus == 200 ? "Profil používateľa „{$userinfo['user-name']}“" : 'Neexistuje záznam'; include('head.php') ?>
</head><body class="page profil">
<?php
	include('header.php');
	include('menu.php');
	include('submenu.php');
		?>
<div id="pages" >
	<?php if($httpStatus == 200): ?>
	<div class="user-profil">
			<div class="user-info">
				<h1 class="no-center">Profil používateľa <big><?= SanitizeLib\escape($userinfo['user-name'], 'html') ?></big></h1>
				<table style="table-layout: fixed; width: 800px">
					<style scoped>table td {text-align: left !important}</style>
					<tr>
						<td rowspan="6">
							<?=( SanitizeLib\escape((string) $userinfo['description'], 'HTML') )?>
						</td>
					</tr>
					<tr>
						<td class='even'>Používateľské právomoci:</td>
						<td class='odd'><?= id(['admin' => 'Administrátor', 'moderator' => 'Moderátor', 'member' => 'Člen'])[$userinfo['user-group']] ?></td>
					</tr>
					<tr>
						<td class='even'>E-mail:</td>
						<td class='odd'><?= SanitizeLib\escape(sk_sanitizeEmail($userinfo['user-email']), 'html') ?></td>
					</tr>
					<tr>
						<td class='even'>Celkový počet príspevkov:</td>
						<td class='odd'><?= $userinfo['stats-post-count'] ?></td>
					</tr>
					<tr>
						<td class='even'>Posledná návšteva:</td>
						<td class='odd'><?= $userinfo['stats-last-visit'] ?></td>
					</tr>
					<tr>
						<td class='even'>Registrovaný dňa:</td>
						<td class='odd'><?= $userinfo['user-register-date'] ?></td>
					</tr>
					<?php if(isset($_SESSION['uid']) && $_SESSION['username'] === $userinfo['user-name']): // je užívateľ prihlásený a je to jeho profil?>
					<tfoot>
						<tr>
							<td colspan=2>
								<form action="profile-edit.php?" method="POST" accept-charset="utf-8">
									<button class='button_register' type="submit">Upraviť informácie</button>
								</form>
							</td>
						</tr>
					</tfoot>
					<?php endif ?>
				</table>
			</div>
	</div>
	<?php else: ?>
	<div class="page error error-<?= $httpStatus ?>">
		<h1>Chyba <?= $httpStatus ?></h1>
	</div>
	<?php endif ?>
</div>
<?php include('footer.php') ?>
