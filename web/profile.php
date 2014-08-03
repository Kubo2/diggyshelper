<?php

require "./functions.php"; // some useful miscellanous functionality
require "./connect.php"; // database connection

$id = !empty($_GET['user']) ? mysql_real_escape_string($_GET['user']) : false;
$httpStatus = 200;

$userinfo = [
	"user-name" => null,
	"user-group" => null,
	"user-email" => null,
	//"user-email-sanitized" => null,
	"user-register-date" => null,
	"stats-post-count" => null,
	"stats-last-visit" => null,
	"avatar-path" => null,
];

if(!$id) {
	$httpStatus = 404;
	goto page_template;
}

$rawinfo= <<<SQL
	select
		u.username as `user-name`,
		u.email as`user-email`,
		u.access as `user-group`,
		date_format(u.registerdate, '%e. %c. %Y') as `user-register-date`,
		date_format('00-00-0000 00:00', '%e. %c. %Y') as `stats-last-visit`, -- TODO: fix last visit
		count(p.id) as `stats-post-count`
	from
		users u,
		posts p
	where
		u.username = '$id' AND p.post_creator = u.id
	GROUP BY u.id HAVING u.id IS NOT NULL
SQL;

if(defined('DB_CONNECTED')) {
	$rawinfo = mysql_query($rawinfo);
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
header("Content-Type: text/html; charset=utf-8", true, $httpStatus);

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
				<h1>Profil používateľa <big><?= SanitizeLib\escape($userinfo['user-name'], 'html') ?></big></h1>
				<table style="table-layout: fixed; width: 800px">
					<style scoped>table td {text-align: left !important}</style>
					<tr>
						<td>Používateľské právomoci:</td>
						<td><?= id(['admin' => 'Administrátor', 'moderator' => 'Moderátor', 'member' => 'Člen'])[$userinfo['user-group']] ?></td>
					</tr>
					<tr>
						<td>E-mail:</td>
						<td><?= SanitizeLib\escape(sk_sanitizeEmail($userinfo['user-email']), 'html') ?></td>
					</tr>
					<tr>
						<td>Celkový počet príspevkov:</td>
						<td><?= $userinfo['stats-post-count'] ?></td>
					</tr>
					<tr>
						<td>Posledná návšteva:</td>
						<td><?= $userinfo['stats-last-visit'] ?></td>
					</tr>
					<tr>
						<td>Registrovaný dňa:</td>
						<td><?= $userinfo['user-register-date'] ?></td>
					</tr>
					<?php if(isset($_SESSION['uid']) && $_SESSION['username'] === $userinfo['user-name']): // je užívateľ prihlásený a je to jeho profil?>
					<tfoot>
						<tr>
							<td colspan=2>
								<form action="profile-edit.php?" method="POST" accept-charset="utf-8">
									<button type="submit">Upraviť informácie</button>
								</form>
							</td>
						</tr>
					</tfoot>
					<?php endif ?>
				</table>
			</div>
		<!--img 
			src="<?= $userinfo['avatar-path'] ?>"
			alt="Profilový obrázok používateľa <?= $userinfo['user-name'] ?>"
			width="280"
			height="350"
			class="user-avatar"-->
	</div>
	<?php else: ?>
	<div class="page error error-<?= $httpStatus ?>">
		<h1>Chyba <?= $httpStatus ?></h1>
	</div>
	<?php endif ?>
</div>
<?php include('footer.php') ?>
