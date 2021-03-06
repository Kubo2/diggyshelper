<?php

require __DIR__ . '/functions.php';
require __DIR__ . '/lib/template.php';

/**
 * Show a user's profile.
 */


$dbContext = require __DIR__ . '/connect.php';

$id = $dbContext && !empty($_GET['user']) ? mysql_real_escape_string($_GET['user'], $dbContext) : FALSE;

$userinfo = [
	"user-name" => null,
	"user-email" => null,
	"description" => null,
	"user-group" => null,
	"user-register-date" => null,
	"stats-post-count" => null,
	"stats-last-visit" => null,
	"avatar-path" => null,
];

$httpStatus = 200;
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
		date_format(u.registerdate, '%d. %m. %Y') as `user-register-date`,
		date_format('00-00-0000 00:00', '%d. %m. %Y') as `stats-last-visit`, -- TODO: fix last visit
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

if($dbContext) {
	$rawinfo = mysql_query($rawinfo, $dbContext);

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
header('Content-Type: text/html; charset=UTF-8', TRUE, (int) $httpStatus);

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
<div id="pages">
	<?php if($httpStatus == 200): ?>
	<div class="user-profil" itemscope itemtype='https://schema.org/Person'>
			<div class="user-info">
				<h2 class="no-center">Profil používateľa <big itemprop='name'><?= htmlspecialchars($userinfo['user-name']) ?></big></h2>
				
				<div id="mob-yes" class="foto"><img src="images/thumb/no-avatar.jpg"></div>
				
				<table style="table-layout: fixed; width: 100%" border="0px">
					<!--style scoped>table td {text-align: left !important}</style-->
					<tr>
						<td colspan="3" itemprop='description'><?= htmlspecialchars($userinfo['description']) ?><hr></td>
					</tr>
					<tr id="mob-no">
						<td rowspan="6">
							<div class="foto"><img src="images/thumb/no-avatar.jpg"></div>
						</td>
					</tr>
					<tr>
						<td class='even'>Používateľské právomoci:</td>
						<td class='odd'><?= id(['admin' => 'Administrátor', 'moderator' => 'Moderátor', 'member' => 'Člen'])[$userinfo['user-group']] ?></td>
					</tr>
					<tr>
						<td class='even'>E-mail:</td>
						<td class='odd' itemprop='email'><?= htmlspecialchars(sk_sanitizeEmail($userinfo['user-email'])) ?></td>
					</tr>
					<tr>
						<td class='even'>Počet príspevkov:</td>
						<td class='odd'><?= $userinfo['stats-post-count'] ?></td>
					</tr>
					<tr>
						<td class='even'>Posledná návšteva:</td>
						<td class='odd'><?= $userinfo['stats-last-visit'] ?></td>
					</tr>
					<tr>
						<td class='even'>Deň registrácie:</td>
						<td class='odd' itemprop='birthDate'><?= $userinfo['user-register-date'] ?></td>
					</tr>
					<?php if(loggedIn() && $_SESSION['username'] === $userinfo['user-name']): // je užívateľ prihlásený a je to jeho profil?>
					<tfoot>
						<tr>
							<td colspan="3" style="text-align: right;">
								<hr>
								<form action="profile-edit.php?" method="POST" accept-charset="utf-8">
									<button class='button_repair2' type="submit">Upraviť informácie</button>
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
