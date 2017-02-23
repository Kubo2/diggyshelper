<?php

require __DIR__ . '/functions.php';

session_start();

if(loggedIn()) {
	recordLog("User #{$_SESSION['uid']} has requested registration page", 'page request', 'reg');
	header("Location: http://$_SERVER[SERVER_NAME]" .rtrim(dirname($_SERVER["PHP_SELF"]), '/'). "/index.php", true, 303);
	exit;
}

header("Content-Type: text/html; charset=utf-8", true, 200);
?>
<!doctype html>
<html>
<head>
	<?php ($titleConst = 'Registrácia') &&require 'includes/head.php' ?>
	<style type="text/css">
		.red {
			color:white;
			background:red;
			border-radius:5px;
			padding: 5px;
			font-size: 12px;
			position: relative;
			bottom: 1px;
		}

		.orange {
			color:white;
			background:orange;
			border-radius:5px;
			padding: 5px;
			font-size: 12px;
			position: relative;
			bottom: 1px;
		}

		.green {
			color:white;
			background:green;
			border-radius:5px;
			padding: 5px;
			font-size: 12px;
			position: relative;
			bottom: 1px;
		}

		@media (max-width: 620px) {
			.red {
				margin: 5px 0 5px 0;
				width: 100%;
			}
			
			.orange {
				margin: 5px 0 5px 0;
				width: 100%;
			}
			
			.green {
				margin: 5px 0 5px 0;
				width: 100%;
			}
			
			/* break the <table> into pieces (rows) */
			td, th, tr,
			thead, tbody, tfoot,
			table, table caption {
				display: block;
				width: 100%;
				text-align: center;
			}

			/* add bottom margin for the benefits list and center the block */
			table td[rowspan='6'] {
				margin: 0 auto 1em;
				width: 80%;
				text-align: left;
			}

			/* spread the <input>s */
			table input {
				width: 100%;
				box-sizing: border-box;

				/* box-sizing prefixes */
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
			}

			/* remove the original statement & apply the fix */
			table tr:first-child td:nth-child(1) {
				display: none;
			}

			table td.required-patch {
				display: block !important;
			}

			/* remove the unwanted space */
			table tr:first-child td:nth-child(2) {
				display: none;
			}
		}

		@media (max-width: 400px) {
			/* cancel the width of the block */
			table td[rowspan='6'] {
				/*width: 100%;*/
				display: none;
			}
		}
	</style>
</head>

<body>
	<?php
		require 'includes/header.php';
		require 'includes/menu.php';
		require 'includes/submenu.php'; 
	?>
<div id="forum">
	<a class='button_reg' href='index.php'>Návrat na hlavnú stránku</a>

	<div id="content">
<?php
// Tu vychádzam z faktu, že ak užívateľ neodoslal aspoň username,
// buď
// 	- ešte neodoslal formulár (POST požiadavok)
// alebo
// 	- nemá záujem sa registrovať
// pretože username slúži ako login a tým pádom je pre registráciu kľučové

if(empty($_POST['username'])) {
?>
		<style scoped>.ochrana-pred-robotmi{display:none}</style>
		<form method='post' action='?' onsubmit="
			var regForm = this; this.onsubmit = null;
			var timeout = window.setTimeout(regForm.submit, 700);
			ga('send', 'event', 'registerUserAccount', 'formSubmit', { hitCallback: function() { window.clearTimeout(timeout); regForm.submit() } });
			return false;
		">
			<table border='0px' width="80%" style="margin: auto;">
				<!-- display: table-caption -->
				<caption>
					<h2>Registrovať sa</h2>
					
					<p>Staňte sa členom diskusného fóra Diggy's Helper.</p>
					
					<div id="mob-yes">
						<br><b>Výhody registrovaných používateľov:</b>
						
						<ul>
							<li>- osobný profil</li>
							<li>- možnosť pridávať otázky a odpovede vo fóre</li><!-- // yet not possible, but save it till implementing fb login
							<li>- pridať si známych ľudí, spoluhráčov do priateľov</li-->
							<li>- možnosť zapojiť sa do sútaží o GEMY</li>
						</ul>
					</div>
				</caption>
				<!--/ display: table-caption -->
				
				<!-- registration form body start -->
				<tr>
					<td style="color: #cca440" colspan="2">Všetky tri údaje sú povinné.</td>
					
					<td ROWSPAN="6" width="40%">
						<h3>Výhody registrovaných používateľov:</h3>
						
						<ul>
							<li>osobný profil</li>
							<li>možnosť pridávať otázky a odpovede vo fóre</li><!-- // yet not possible, but save it till implementing fb login
							<li>pridať si známych ľudí, spoluhráčov do priateľov</li-->
							<li>možnosť zapojiť sa do sútaží o GEMY</li>
						</ul>
					</td>
					<td style='color: #cca440; display: none' class='required-patch'>Všetky tri údaje sú povinné.</td>
				</tr>
				<tr>
					<td width="25%">
						<input name='username' type='text' placeholder='Používateľské meno' class='input_reg' autocomplete='off' required>
					</td>
					<td></td>
				</tr>
				<tr>
					<td>
						<input name='email' type='email' placeholder='E-mail' class='input_reg' required>
					</td>
					<td></td>
				</tr>
				<tr>
					<td>
						<input name='password' type='password' placeholder='Heslo' class='input_reg' autocomplete='off' id='status' required>
					</td>
					<td style="min-width: 180px">
						<span class="first"></span>
					</td>
				</tr>
				<tr>
					<td>
						<input name='password2' type='password' placeholder='Heslo znovu' class='input_reg' autocomplete='off' required>
					</td>
					<td></td>
				</tr>
				<tr class="ochrana-pred-robotmi">
					<td>
						Prosím, <strong>nevypĺňajte</strong>.
						Políčko si iba overuje, či nie ste <b>automatický spamovací robot.</b>
					</td>
					<td>
						<input type="url" name='url'>
					</td>
				</tr>
				<!--tr>
					<td><input class='input' autocomplete='off' name='facebookname' placeholder='Meno na facebooku' value='' type='text'></td>
				</tr-->
				<tr>
					<td>
						<input class='button_register' type='submit' value='Registrovať sa'>
					</td>
					<td></td>
				</tr>
			</table>
			<!--font color='#5999cc'>*</font> "Meno na facebooku" sa zobrazuje len administrátorom stránky. Slúži na odosielanie GEMOV výhercom. (toto pole nieje povinné)-->
		</form>
<?php 
goto closing;
} else {
	$userdata = [];
	// užívateľ zaslal formulár
	// čo potrebujeme, je 
	// 	- username [:unique]
	// 	- password == password2 [:not-empty:md5:eq]
	// 	- email [:if-not-empty;contains-at-sign(@)]
	// 	- url [:require-empty]
	//
	// spam kontrola
	if(!empty($_POST['url'])) goto spam;
	// teraz sme presvedčení, že ani jedno heslo nie je prázdne
	if( empty($_POST['password']) || empty($_POST['password2']) ) goto empty_passwd;
	// hashe hesiel sa musia zhodovať
	if( (($userdata['password'] = md5($_POST['password']))) != md5($_POST['password2']) ) goto psw_not_eq;
	// email nesmie byť prázdny
	if(empty($_POST['email'])) goto empty_email;
	// validácia emailovej adresy
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) goto invalid_email;
	// sme pripojení k databázi?
	if(FALSE === (require 'connect.php')) goto connect_err;
	// ošetríme username a email proti sql injection
	$userdata['username'] = mysql_real_escape_string($_POST['username']);
	$userdata['email'] = !empty($_POST['email']) ? mysql_real_escape_string($_POST['email']) : false;
	// primary structure
	$newusr = "INSERT INTO `users`(`registerdate`, `username`, `password`, `email`)\n";
	// data
	$newusr .= "VALUES(NOW(), '$userdata[username]', '$userdata[password]', '$userdata[email]') ";
	// query - pokúsime sa vložiť užívateľa do databáze
	$success = mysql_query($newusr);
	// was registration successful?
	if(!$success) {
		// 1062 - duplicate entry
		if(mysql_errno() == 1062) {
			goto usr_already_exists;
		}
		// any else error
		goto unsuccesful_registration;
	}
?>
<h1>Registrácia úspešná</h1>
<p class="succes">
	Bravó! Vitajte na našom fóre ;-) V pravom hornom rohu sa môžete prihlásiť
	alebo <a href="./index.php">prejsť na hlavnú stránku</a>.
</p>
<script>ga('send', 'event', 'registerUserAccount', 'afterProcess', <?=json_encode($_POST['username'])?>, 0) /* zero means success */</script>
<?php
goto closing;
} ?>
<?php spam: ?>
<p class="warning">
	Iba hlúpy spamovací robot ako ty by vyplnil políčko 
	s&nbsp;názvom <code>&quot;url&quot;</code>.
	<br>
	Prosím pokračuj na <a href="./">hlavnú stránku. </a>
</p>
<p>
	Registrácia neprebehla úspešne, ale to nevadí. Ak si človek, 
	vráť sa a políčko <code>&apos;url&apos;</code> nechaj prázdne.
</p>
<?php recordLog("SPAM PREVENTED from IP '{$_SERVER['REMOTE_ADDR']}'", 'action', 'reg') ?>
<?php goto closing; connect_err: ?>
<p class="warning">
	Ľutujeme, ale naša databáza je momentálne na pár minút nedostupná.
	Skúste to prosím o niekoľko minút neskôr. <a href="javascript:history.go(-1)">Späť</a>
</p>
<script>ga('send', 'event', 'registerUserAccount', 'afterProcess', null, 255) /* 255 means technical server problem */</script>
<?php goto closing; empty_passwd: ?>
<p class='warning'>
	Vyplňte prosím heslo. <a href="javascript:history.go(-1)">Upraviť</a>
</p>
<script>ga('send', 'event', 'registerUserAccount', 'afterProcess', 'missingPassword', 1) /* one means 'missing' */</script>
<?php goto closing; empty_email: ?>
<p class="warning">Vyplňte emailovú adresu.</p>
<script>ga('send', 'event', 'registerUserAccount', 'afterProcess', 'missingEmail', 1) /* one means 'missing' */</script>
<?php goto closing; psw_not_eq: ?>
<p class="warning">
	Zadané heslá sa musia zhodovať. <a href="javascript:history.go(-1)">Upraviť</a>
</p>
<script>ga('send', 'event', 'registerUserAccount', 'afterProcess', 'passwordsNotMatch', 2) /* two means 'invalid' */</script>
<?php goto closing; invalid_email: ?>
<p class="warning">
	Správne zadaná emailová adresa musí obsahovať znak zavináča, 
	pričom ten nesmie byť ani na začiatku, ani na konci adresy.<br>
	Ak neviete emailovú adresu správne zadať, nechajte prosím 
	políčko prázdne. <a href="javascript:history.go(-1)">Upraviť</a>
</p>
<p class="info">
	Nevyžadujeme od vás tento údaj, avšak keď ho už zadáte, dbajte prosím na jeho správny formát.
</p>
<script>ga('send', 'event', 'registerUserAccount', 'afterProcess', 'invalidEmail', 2) /* two means 'invalid' */</script>
<?php goto closing; usr_already_exists: ?>
<p class="warning">
	Bohužiaľ, registrácia sa nevydarila. Na našom fóre už užívateľ 
	s rovnakou prezývkou existuje. Ak si myslíte, že táto prezývka 
	má patriť vám, <b>kontaktujte nás</b> na emailovú adresu
	<a href='mailto:kubo2@diggyshelper.net'>kubo2@diggyshelper.net</a>
	<?php // TODO: návrhy existujúcich prezývok ?>
	<?php recordLog("Attempt to register already taken nickname '{$_POST['username']}'", 'action', 'reg') ?>
</p>
<script>ga('send', 'event', 'registerUserAccount', 'afterProcess', 'userAlreadyExists', 127) /* 127 means 'failure' */</script>
<?php goto closing; unsuccesful_registration: ?>
<p class="warning">
	Pri registrácii nastala chyba. Zopakujte svoj pokus prosím o niekoľko minút.
</p>
<script>ga('send', 'event', 'registerUserAccount', 'afterProcess', null, 255)</script>

<?php closing: ?>
	</div>
</div>
<!-- no opening <center> tag seen -->
	<?php require 'includes/footer.php'; ?>
</body>
</html>
<?php
/**
 * @todo [GA] consider splitting 'afterProcess' to two actions, 'afterSuccess' and 'afterFailure'
 * @todo [TPL] switch the template to Latte
 */
?>
