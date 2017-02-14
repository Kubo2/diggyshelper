<?php

// load sessions
{
	session_start();
	session_regenerate_id( $delete_old_session = true );
}

// user is not signed in
if(! isset($_SESSION['uid'])) goto p403_template;

$currentUser = $_SESSION['uid'];

// misc
require('./connect.php'); // MUST define() DB_CONNECTED constant in case of db connection success
require('./functions.php');

// array of variables in disposition inside template
$data = \getUser($currentUser, [ 'username', 'description', 'email' ]);

// ==== UPDATE ====
$updated = array();

// first, most common, condition
// we can not update anything if we have no database connection
if(!defined('DB_CONNECTED')) {
	$updated = [
		'basic-info-change' => false,
		'password-change' => false,
	];
	goto page_template;
}

if(isset($_POST['basic-info-change'])) {
	$user = & $_POST['user'];
	$info = array_slice_assoc((!is_array($user) ? [ ] : $user), array_keys($data));

	unset($user);

	if(
		empty($info['description']) // the description is a non-required information
		&& emptyArray(
			array_slice_assoc($info, [ 'username', 'email' ])
		)
	) {
		$updated['basic-info-change'] = false;
		goto page_template;
	} // ============>

	/** the Update Mechanism */

	// what is going to be updated
	$change = array();

	foreach(array_keys($info) as $field) {
		if($info[$field] !== $data[$field]) {
			$change[ $field ] = $info[ $field ];
		}
	}

	if(count($change)) {
		$set = array();

		// prepare data to format "`field1` = 'value1', `field2` = 'value2'"
		foreach($change as $field => $new) $set[ ] = sprintf(' `%s` = \'%s\' ', $field, mysql_real_escape_string($new));
		$setstr = implode(', ', $set);

		$updated['basic-info-change'] = mysql_query(
			sprintf( "UPDATE users SET %s WHERE `id` = %d",
				$setstr,
				$currentUser
			)
		);

		if($updated['basic-info-change']) {
			// output MUST show the UPDATED data
			$data = $change + $data;
		}

		goto page_template;
	} // ============>

	// thus the previous condiiton was 'escaping', we can actively set $updated to false
	$updated['basic-info-change'] = false;

} else if(isset($_POST['password-change'])) { // user wants to change his/her password
	if(
		!empty($_POST['sudo-auth'])
		&& md5($_POST['sudo-auth']) === getUser($currentUser, 'password')
	) {
		if(!empty($_POST['new-password'])) {
			$updated['password-change'] = mysql_query(
				sprintf( "UPDATE users SET `password` = '%s' WHERE `id` = %d",
					md5($_POST['new-password']),
					$currentUser
				)
			);
		}
	} else {
		$updated['password-change'] = false;
	}

	// escape and render; -> the habit
	goto page_template;
}

// ====== template start ======
page_template: {

header('Content-Type: text/html; charset=utf-8');
header('Vary: User-Agent');

// template components
require __DIR__ . '/sanitize.lib.php';

// template settings
set_include_path(__DIR__ . '/includes/');
extract($data);

$isMobile = !empty($ua = & $_SERVER['HTTP_USER_AGENT']) && preg_match('~mobile~i', $ua);

}

// ====== template HTML ====== ?>
<!doctype html>
<?php ($titleConst = "Úprava profilu") && include('head.php') ?>
<style><?php if(!$isMobile): ?>

	/* TODO: kompletný refaktoring HTML a CSS, výsledok funkčný na väčšine zariadení; */

	.pages {
		position: relative;
	}

	.user-profil {
		width: 80%;
		margin: auto
	}

	form.alter-profile {
		box-sizing: border-box;
		display: inline-block;
		position: relative;
		width: 50%;
		margin: auto;
		zoom: 1;
	}

	.alter-profile fieldset {
		float: left;
		min-width: 40%;
		border: 2px dashed  silver;
		margin: .08em .45em;
	}

	.alter-profile legend {
		font-size: large;
		font-size: larger;
	}

	.alter-profile label:not([for]) {
		display: block;
	}

	.alter-profile label input {
		float: right;
		min-width: 70%;
		min-width: available;
		min-width: fill-available;
		width: 70%;
	}

	.alter-profile input[type=text], .alter-profile input[type=password], .alter-profile input[type=email] {
		box-sizing: border-box;
		font-size: 102%;
		padding: .3em .08em;
	}

	.alter-profile input[type=submit] {
		width: 100%;
		margin-top: .65em;
		padding: .34em;
		cursor: pointer;
		cursor: hand;
	}
<?php else: // $isMobile ?>
	.alter-profile fieldset {
		border: 1px dashed silver;
	}
<?php endif ?>
</style>
</head><body class="page profile-edit">
<?php
	include('header.php');
	include('menu.php');
	include('submenu.php');
		?>
<div id="pages">
	<div class="user-profil">
		<h2><?php if(!$isMobile): ?>Úprava používateľského profilu<?php else: ?>Upraviť informácie<?php endif ?></h2>
		<form class='alter-profile' method='POST' action='?'>
			<fieldset>
				<legend>Základné</legend>
				<?php if(isset($updated['basic-info-change'])): ?>
					<?php if($updated['basic-info-change']): ?>
						<p class="success">Informácie aktualizované.</p>
					<?php else: ?>
						<p>Informácie neboli aktualizované. Pravdepodobne ste ich nezmenili alebo nastal problém.</p>
					<?php endif ?>
				<?php endif ?>
				<label>
					<b>Prezývka</b>:<br><input type="text" value="<?= SanitizeLib\escape($username, 'html') ?>" disabled>
				</label>
				<br>
				<label>
					<b>E-mail</b>ová <wbr>adresa:<br><input type="email" name="user[email]" value="<?= SanitizeLib\escape($email, 'html') ?>">
				</label>
				<br>
				<div id="details">
					<p style="clear: right !important"><b>stručný popis</b> používateľa:</p>
					<textarea name="user[description]" style="width: 100%; height: 70px; resize: none"><?= SanitizeLib\sanitize($description, SanitizeLib\HTML) ?></textarea>
				</div>
				<input type="submit" class="button_repair" name="basic-info-change" value="Uložiť">
			</fieldset>
			<br>
		</form><!--
		--><form class='alter-profile' method='POST' action='?'>
			<fieldset>
				<legend>Zmena hesla</legend>
				<?php if(isset($updated['password-change'])): ?>
					<?php if($updated['password-change']): ?>
						<p class="success">Heslo bolo úspešne zmenené.</p>
					<?php else: ?>
						<p class="warning">Pri zmene hesla nastal problém. Skúste to prosím znova.</p>
					<?php endif  ?>
				<?php endif ?>
				<label>Potvrď <b>súčasné</b> heslo:<br><input type="password" name="sudo-auth"></label>
				<br>
				<label>Zadaj <b>nové</b> heslo:<br><input type="text" name="new-password"></label>
				<br>
				<input type="submit" class="button_repair" name="password-change" value="Zmeniť heslo">
			</fieldset>
		</form>
	</div>
</div>
<?php exit(!include 'footer.php') ?>

<?php p403_template: header("Content-Type: text/html; charset=utf-8", true, 401) xor set_include_path(dirname(__FILE__) . '/includes/')

// ====== Forbidden template ======= ?>
<!DOCTYPE html>
<?php

($titleConst = "Prihlásenie - Autentizácia") && include('head.php');

echo('</head><body class="page sign-in">');

include('header.php');
include('menu.php');
include('submenu.php');

require('authentization-form.php');

include('footer.php')

?>
