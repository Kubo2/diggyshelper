<?php

// load sessions
{
	session_start();
	session_regenerate_id();
}

// user is not signed in
if( !isset($_SESSION['uid']) ) goto p403_template;

$currentUser = $_SESSION['uid'];

// misc
require('./connect.php');
require('./functions.php');

// array of variables in disposition inside template
$data = \getUser($currentUser, [ 'username', 'description', 'email' ]);

// user <i>probably</i> wants to change basic account information
if(isset($_POST['basic-info-change'])) {
	$user = & $_POST['user'];
	$info = array_slice_assoc((!is_array($user) ? [ ] : $user), array_keys($data));
	unset($user);

	// user probably don't want to change basic info, but the blame has the form (and the user-agent)
	if(/*count($info) < count($data) || */emptyArray($info)) {
		// <HACK>
			$_POST[ 'password-change' ] = true; 	// (!) this does imply passing password change condition below, 
														// but is not good parctice (even if necessary)
		// </HACK>
	} else {
		$change = array();

		foreach(array_keys($info) as $field) {
			if(
				!empty($info[$field])
				&& ( $info[$field] !== $data[$field] )
			) {
				$change[ $field ] = $info[ $field ];
			}
		}// var_dump($change);

		if(count($change) && defined('DB_CONNECTED')) {
			$set = array();
			foreach($change as $field => $new) $set[ ] = sprintf(' `%s` = \'%s\' ', $field, mysql_real_escape_string($new));
			$setstr = implode(', ', $set); // implode into "`field1` = 'value1', `field2` = 'value2'"

			$updated = mysql_query(
				sprintf( "UPDATE users SET %s WHERE `id` = %d",
					$setstr,
					$currentUser
				)
			);

			if($updated) {
				$data = $change + $data;
			}

			goto page_template;
		}
	}
}

// user wants to change his/her password
if(isset($_POST['password-change'])) {
	if(
		!empty($_POST['sudo-auth'])
		&& md5($_POST['sudo-auth']) === getUser($currentUser, 'password')
	) {
		if(!empty($_POST['new-password'])) {
			$updated = mysql_query(
				sprintf( "UPDATE users SET `password` = '%s' WHERE `id` = %d",
					md5($_POST['new-password']),
					$currentUser
				)
			);
		}
	} else {
		$updated = false;
	}

	// escape and render
	goto page_template;
}

// ====== template start ======
page_template: {

header("Content-Type: text/html; charset=utf-8");

// template components
require('./sanitize.lib.php');

// template settings
set_include_path("./includes/");
extract($data);

}

// ====== template HTML ====== ?>
<!doctype html>
<meta name=robots content=noindex>
<?php ($titleConst = "Úprava profilu") && include('head.php') ?>
</head><body class="page profile-edit">
<?php
	include('header.php');
	include('menu.php');
	include('submenu.php');
		?>
<div id="pages" >
	<div class="user-profil">
		<h1>Úprava používateľského profilu</h1>
		<form name="alter-profile" action="?" method="post">
			<!--style scoped-->
			<style>
				form[name='alter-profile'] {
					display: block;
					position: relative;
					width: 80%;
					margin: auto;
					overflow: hidden;
					zoom: 1;
				}

				fieldset {
					float: left;
					min-width: 40%;
					border: 2px dashed  silver;
					margin: .08em .45em;
					/* padding: 0; */
				}

				legend {
					font-size: large;
					font-size: larger;
				}

				label:not([for]) {
					display: block;
				}

				label input {
					float: right;
					min-width: 70%;
					min-width: available;
					min-width: fill-available;
					width: 70%;
				}

				input[type=text], input[type=password], input[type=email] {
					box-sizing: border-box;
					font-size: 102%;
					padding: .3em .08em;
				}

				input[type=submit] {
					width: 100%;
					margin-top: .65em;
					padding: .34em;
					cursor: pointer;
					cursor: hand;
				}
			</style>
			<fieldset>
				<legend>Základné</legend>
				<!-- =============== -->
				<?php if(/*isset($_POST['basic-info-change']) && */isset($updated)): ?>
					<?php if($updated): ?>
						<p class="success">Informácie aktualizované.</p>
					<?php else: ?>
						<p>Informácie neboli aktualizované. Pravdepodobne ste ich nezmenili alebo nastal problém.</p>
					<?php endif ?>
				<?php endif ?>
				<label><b>Prezývka</b>: <input type="text" value="<?= SanitizeLib\escape($username, 'html') ?>" disabled></label>
				<label><b>E-mail</b>ová <wbr>adresa: <input type="email" name="user[email]" value="<?= SanitizeLib\escape($email, 'html') ?>"></label>
				<div id="details">
					<p style="clear: right !important"><b>stručný popis</b> používateľa</p>
					<textarea name="user[description]" style="width: 100%; height: 70px; resize: none"><?= $description ?></textarea>
				</div>
				<input type="submit" name="basic-info-change" value="Aktualizovať informácie">
			</fieldset>
			<fieldset>
				<legend>Zmena hesla</legend>
				<!-- =============== -->
				<?php if(isset($_POST['password-change']) && isset($updated)): ?>
					<?php if($updated): ?>
						<p class="success">Heslo bolo úspešne zmenené.</p>
					<?php else: ?>
						<p class="warning">Pri zmene hesla nastal problém. Skúste to prosím znova.</p>
					<?php ; endif ?>
				<?php ; endif ?>
				<label><b>Súčasné</b> heslo: <input type="password" name="sudo-auth"></label>
				<label><b>Nové</b> heslo: <input type="text" name="new-password"></label>
				<input type="submit" name="password-change" value="Potvrdiť zmenu">
			</fieldset>
		</form>
	</div>
</div>
<?php include('footer.php') && die ?>

<?php p403_template: {

header("Content-Type: text/html; charset=ansi", true, 403);

}

// ====== Forbidden template ======= ?>
<!DOCTYPE html>
<meta charset=ansi>
<title>Forbidden</title>
<h1>Forbidden access</h1>
<p>You aren't authorized to access this resource whithout signing in.</p>
<p>Please refer to some <a href="index.php">public page</a> and sign in first.</p>
