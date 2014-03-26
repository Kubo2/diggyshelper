<?php

session_start();
header("Content-Type: text/html; charset=utf-8", true, 200);
mb_internal_encoding('UTF-8');
?>
<!DOCTYPE HTML>
<html>
<head>
	<?php require 'includes/head.php'; ?>
	
	<!-- jQuery nie je vôbec portrebné. @see selector.js ~Kubo2 -->
	<!--script type="text/javascript" src="jquery.js"></script-->
	<!-- selector.js bol nahradený globálnym javascriptom diggyshelper.js @since 1.1 -->
	<!--script type="text/javascript" src="./selector.js"></script-->
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
		input:required::after {
			content: " *";
			color: red;
		}
		input[required]:after {
			content: " *";
			color: red;
		}
	</style>

</head>
<body>
	<?php
		//require 'connect.php';
		//require 'includes/functions.php';
		require 'includes/header.php';
		require 'includes/menu.php';
		require 'includes/submenu.php'; 
	?>
	
<div id="forum">
	<a class='button' href='index.php'>Návrat do fóra</a>
<hr >
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
	<h1>Registrácia</h1>
	<p>Staňte sa členmi diskusného fóra Diggy's Helper.</p>
	<style scoped>.ochrana-pred-robotmi{display:none}</style>

	<form method='post' action='?'>
	<table border='0'>
		<caption>Registrovať sa</caption>
		<tr>
			<td><input name='username' type=text placeholder='Nickname' class='input' required><td>
		</tr>
		<tr>
			<td><input name='password' type=password placeholder='Heslo' class='input' autocomplete='off' id='status' required>&nbsp;<span class='first'></span></td>
		</tr>
		<tr>
			<td><input name='password2' type=password placeholder='Heslo znovu' class='input' autocomplete='off' required></td>
		</tr>
		<tr>
			<td><input name='email' type=email placeholder='E-mail' class='input' ></td>
		</tr>
		<tr>
			<td><input class='button_register' type='submit' value='Registrovať sa'></td>
		</tr>
		<tr class="ochrana-pred-robotmi">
			<td>
				Prosím, <strong>nevypĺňajte</strong>. 
				Políčko si iba overuje, či nie ste <b>automatický spamovací robot.</b>
			</td>
			<td><input type="url" name='url'></td>
		</tr>
	</table>
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
	// teraz sme presvedčení, že ani jedno heslo nie je prázdné
	if( empty($_POST['password']) || empty($_POST['password2']) ) goto empty_passwd;
	// hashe hesiel sa musia zhodovať
	if( ($userdata['password'] = md5($_POST['password'])) != md5($_POST['password2']) ) goto psw_not_eq;
	// validácia emailovej adresy
	if(!empty($_POST['email']) && !($atPos = mb_strpos($_POST['email'], '@')) || $atPos == mb_strlen($_POST['email']) - 1) goto invalid_email;
	// sme pripojení k databázi?
	if(FALSE === (require 'connect.php')) goto connect_err;
	// ošetríme username a email proti sql injection
	$userdata['username'] = mysql_real_escape_string($_POST['username']);
	$userdata['email'] = isset($_POST['email']) ? mysql_real_escape_string($_POST['email']) : false;
	// pokúsime sa vložiť užívateľa do databáze
	if(!mysql_query(
		"INSERT INTO `users`(`registerdate`,`username`,`password`" . ((bool) $userdata['email'] ? ',`email`' : '') . ") 
		VALUES(NOW(),'$userdata[username]','$userdata[password]'" . ((bool) $userdata['email'] ? ',\'' . $userdata['email'] . '\'' : '') . ")") 
	// 1062 - duplicate entry
	&& mysql_errno() == 1062) goto unsuccesful_registration;
?>
<p class=succes>
	Bravó! Vitajte na našom fóre ;-) V pravom hornom rohu sa môžete prihlásiť.
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
	vráť sa a políčko <code>&quot;url&quot;</code> nechaj prázdne.
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
<?php goto closing; psw_not_eq: ?>
<P class="warning">
	Zadané heslá sa musia zhodovať. <a href="javascript:history.go(-1)">Upraviť</a>
</p>
<?php goto closing; invalid_email: ?>
<p class="warning">
	Správne zadaná emailová adresa musí obsahovať znak zavináča, 
	pričom ten nesmie byť ani na začiatku, ani na konci adresy.<br>
	Ak neviete emailovú adresu správne zadať, nechajte prosím 
	políčko prázdne. <a href="javascript:history.go(-1)">Upraviť</a>
</p>
<?php goto closing; unsuccesful_registration: ?>
<p class="warning">
	Bohužiaľ, registrácia sa nevydarila. Na našom fóre už užívateľ 
	s rovnakou prezývkou existuje. <a href="javascript:history.go(-1)">
	Upravte ju prosím</a> alebo si zvoľte inú.
</p>

<?php closing: ?>
</div>
</div>
</center>
	<?php require 'includes/footer.php'; ?>
</body>
</html>