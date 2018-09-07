<?php

require __DIR__ . '/functions.php';

$dbContext = require __DIR__ . '/connect.php';


// load sessions
{
	session_start();
	session_regenerate_id( $delete_old_session = true );
}


// user is not signed in
if(!loggedIn()) {
	goto p403_template;
} elseif(!$dbContext) {
	$updated = ['basic-info-change' => FALSE, 'password-change' => FALSE];
	goto page_template;
}


$currentUser = $_SESSION['uid'];

// array of user information available as variables within the template
$data = \getUser($dbContext, $currentUser, [ 'username', 'description', 'email' ]);

// section of information that will have been updated
$updated = array();

if(isset($_POST['basic-info-change'])) {
	$user = & $_POST['user'];
	$info = array_slice_assoc((!is_array($user) ? [ ] : $user), array_keys($data));

	unset($user);

	if(
		empty($info['description']) // the description is a non-required information
		&& arrayHasEmptyElements(
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
		foreach($change as $field => $new) $set[ ] = sprintf(' `%s` = \'%s\' ', $field, mysql_real_escape_string($new, $dbContext));
		$setstr = implode(', ', $set);

		$updated['basic-info-change'] = mysql_query(sprintf("UPDATE users SET %s WHERE `id` = %d", $setstr, $currentUser), $dbContext);

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
		&& md5($_POST['sudo-auth']) === getUser($dbContext, $currentUser, 'password')
	) {
		if(!empty($_POST['new-password'])) {
			$updated['password-change'] = mysql_query(
				sprintf("UPDATE users SET `password` = '%s' WHERE `id` = %d", md5($_POST['new-password']), $currentUser),
				$dbContext
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

header('Content-Type: text/html; charset=UTF-8');
header('Vary: User-Agent');

// template settings
set_include_path(__DIR__ . '/includes/');
extract($data);

$isMobile = !empty($ua = & $_SERVER['HTTP_USER_AGENT']) && preg_match('~mobile~i', $ua);

}

// ====== template HTML ====== ?>
<!doctype html>
<?php ($titleConst = "Úprava profilu") && include('head.php') ?>

</head>
<body class="page profile-edit">
<?php
	include('header.php');
	include('menu.php');
	include('submenu.php');
?>
<div id="pages">
	<div class="user-profil">
		<a class='button_reg' id='mob-no' href='./profile.php?user=<?= urlencode($_SESSION['username']) ?>'>Návrat do profilu</a>
		
		<h2><?php if(!$isMobile): ?>Úprava používateľského profilu<?php else: ?>Upraviť informácie<?php endif ?></h2>
		
		<form class='alter-profile' method='POST' action='?'>
			<div class="zakladne">
				<h3>Základné informácie</h3>
				
				<?php if(isset($updated['basic-info-change'])): ?>
					<?php if($updated['basic-info-change']): ?>
						<p class="success">Informácie aktualizované.</p>
					<?php else: ?>
						<p>Informácie neboli aktualizované. Pravdepodobne ste ich nezmenili alebo nastal problém.</p>
					<?php endif ?>
				<?php endif ?>
				
				<hr>
				Používateľské meno:<br>
				<input type="text" value="<?= htmlspecialchars($username) ?>" disabled><br>
				E-mailová adresa:<br>
				<input type="email" name="user[email]" value="<?= htmlspecialchars($email) ?>"><br>
				Stručný popis používateľa:<br>
				<textarea name="user[description]" style="height: 70px; resize: none"><?= htmlspecialchars($description) ?></textarea><br>
				<input type="submit" class="button_repair" name="basic-info-change" value="Uložiť informácie">
			</div>
		</form>
		
		<form class='alter-profile' method='POST' action='?'>
			<div class="zmenahesla">
				<h3>Zmena hesla</h3>
				
				<?php if(isset($updated['password-change'])): ?>
					<?php if($updated['password-change']): ?>
						<p class="success">Heslo bolo úspešne zmenené.</p>
					<?php else: ?>
						<p class="warning">Pri zmene hesla nastal problém. Skúste to prosím znova.</p>
					<?php endif  ?>
				<?php endif ?>
				
				<hr>
				Potvrď súčasné heslo:<br>
				<input type="password" name="sudo-auth" placeholder="****" autocomplete="off"><br>
				Zadaj nové heslo:<br>
				<input type="text" name="new-password" placeholder="****" autocomplete="off"><br>
				<input type="submit" class="button_repair" name="password-change" value="Zmeniť heslo">
			</div>
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

include('footer.php');
