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

page_template:
// template begin
session_start();
header("Content-Type: text/html; charset=utf-8", true, $httpStatus);

// template settings
set_include_path("./includes/");

?>
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
				<table border="0px" width="auto">
				<style scoped>table td {text-align: left !important}</style>
					<tr>
						<td ROWSPAN="6">
							<img src="<?= $userinfo['avatar-path'] ?>" alt="Profilový obrázok používateľa <?= $userinfo['user-name'] ?>" width="240" height="300" class="user-avatar">
						</td>
						<td ROWSPAN="6" width="20px"></td>
						<td COLSPAN="3"><strong>Profil používateľa "<?= $userinfo['user-name'] ?>"</strong><br><?= id(['admin' => 'Administrátor', 'moderator' => 'Moderátor', 'member' => 'Člen'])[$userinfo['user-group']] ?> stránky</td>
					</tr>
					<tr>
						<td>Email:</td>
						<td ROWSPAN="4" width="50px"></td>
						<td><?= sk_sanitizeEmail($userinfo['user-email']) ?></td>
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
					<tr>
						<td COLSPAN="3">
							<?php if(isset($_SESSION['uid'])): // je užívateľ prihlásený?>
							<form action="profile-edit.php?" method="POST" accept-charset="utf-8">
									<button class='button_register' type="submit">Upraviť informácie</button>
							</form>
							<?php endif ?>
						</td>
					</tr>
				</table>
			</div>
	</div>
	<?php else: ?>
	<div class="page error error-<?= $httpStatus ?>">
		<h1>Chyba <?= $httpStatus ?></h1>
	</div>
	<?php endif ?>
</div>
<?php include('footer.php'); FLUSH (   ) ?>
