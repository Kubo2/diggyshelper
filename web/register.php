<?php

session_start();

// ak užívateľ nie je prihlásený, neexistuje ani 'uid'
// v {@see logout.php} je totižto volaná funkcia session_destroy()
if(isset($_SESSION['uid'])) {
	header("Location: http://$_SERVER[SERVER_NAME]" .dirname($_SERVER["PHP_SELF"]). "index.php", true, 302);
	exit;
}

header("Content-Type: text/html; charset=utf-8", true, 200);
?>
<!doctype html>
<html>
<head>
	<?php ($titleConst = "dh: Registrácia") &&require 'includes/head.php' ?>
	<style type="text/css">
		.red{
		color:white;
		background:red;
		border-radius:5px;
		padding:0px 10px;
		}

		.orange{
		color:white;
		background:orange;
		border-radius:5px;
		padding:0px 10px;
		}

		.green{
		color:white;
		background:green;
		border-radius:5px;
		padding:0px 10px;
		}

		td.required::after {
			color: #f00;
			content: ' *';
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
	<a class='button' href='index.php'>Návrat na hlavnú stránku</a>
	<hr>
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
		<p>Registráciou sa staňete členmi stráky Diggy's Helper. Výhodi registrácie sú uvedené nižšie.</p>
		<style scoped>.ochrana-pred-robotmi{display:none}</style>
		<form method='post' action='?'>
			<table border='0px'>
				<tr>
					<td>Registrovať sa:</td>
					<td></td>
					<td ROWSPAN="6">
						<h3>Výhody registrovaných užívateľov:</h3>
							- osobný profil<br>
							- pridávať otázky a odpoveďe vo fóre<br>
							- pridať si známych ľudí, spoluhráčov do priateľov<br>
							- možnosť zapojiť sa do sútaží o GEMY
					</td>
				</tr><tr>
					<td class="required">
						<input name='username' type='text' placeholder='Nickname' class='input' autocomplete='off' required>
					</td>
				</tr><tr>
					<td class="required">
						<input name='password' type='password' placeholder='Heslo' class='input' autocomplete='off' id='status' required>
					</td><td style="min-width: 180px">
						<span class="first"></span>
					</td>
				</tr><tr>
					<td class="required">
						<input name='password2' type='password' placeholder='Heslo znovu' class='input' autocomplete='off' required>
					</td>
				</tr><tr class="ochrana-pred-robotmi">
					<td>
						Prosím, <strong>nevypĺňajte</strong>.
						Políčko si iba overuje, či nie ste <b>automatický spamovací robot.</b>
					</td><td>
						<input type="url" name='url'>
					</td>
				</tr><tr>
					<td class="required">
						<input name='email' type='email' placeholder='E-mail' class='input' required>
					</td>
				</tr><!--tr>
					<td><input class='input' autocomplete='off' name='facebookname' placeholder='Meno na facebooku' value='' type='text'></td>
				</tr--><tr>
					<td>
						<input class='button_register' type='submit' value='Registrovať sa'>
					</td>
				</tr>
			</table>
			<br>
			<font color='red'>*</font> Povinné polia<br>
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
	<b>Bravó!</b> Vitajte na našom fóre ;-) V pravom hornom rohu sa môžete prihlásiť.
	<a href="./">Prejsť na hlavnú stránku</a>
</p>
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
<?php goto closing; connect_err: ?>
<p class="warning">
	Ľutujeme, ale naša databáza je momentálne na pár minút nedostupná.
	Skúste to prosím o niekoľko minút neskôr. <a href="javascript:history.go(-1)">Späť</a>
</p>
<?php goto closing; empty_passwd: ?>
<p class='warning'>
	Vyplňte prosím heslo. <a href="javascript:history.go(-1)">Upraviť</a>
</p>
<?php goto closing; empty_email: ?>
<p class="warning">Vyplňte emailovú adresu.</p>
<?php goto closing; psw_not_eq: ?>
<p class="warning">
	Zadané heslá sa musia zhodovať. <a href="javascript:history.go(-1)">Upraviť</a>
</p>
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
<?php goto closing; usr_already_exists: ?>
<p class="warning">
	Bohužiaľ, registrácia sa nevydarila. Na našom fóre už užívateľ 
	s rovnakou prezývkou existuje. <a href="javascript:history.go(-1)">
	Upravte ju prosím</a> alebo si zvoľte inú.
	<?php // TODO: návrhy existujúcich prezývok ?>
</p>
<?php goto closing; unsuccesful_registration: ?>
<p class="warning">
	Pri registrácii nastala chyba. Zopakujte svoj pokus prosím o niekoľko minút.
</p>

<?php closing: ?>
	</div>
</div>
<!-- no opening <center> tag seen -->
	<?php require 'includes/footer.php'; ?>
</body>
</html>