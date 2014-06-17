<?php // TODO: poupraviť spôsob zobrazovania infoboxu ?>
<div id="header">
	<div id="loginprovizor">
		<?php 
		if(!isset($_SESSION['uid'])) { // TODO: restructure session array
		?>
		<form action='login.php' method='post'>
			<input class='input' type='text' name='username' placeholder='Nickname'><br>
			<input class='input' type='password' name='password' placeholder='Heslo'>&nbsp;
			<label><input class='input' type='checkbox' name='remember'>&nbsp;Neodhlasovať ma</label><br>
			<input type='submit' name='submit' class='input_button' value='Prihlásiť sa'>&nbsp;
			<!--a class='button_logout' href='#' >Zabudli ste heslo?</a>&nbsp;--><!-- <<TODO -->
			<a class='button_register' href='register.php'>Registrovať sa</a>
		</form>
		<?php } else { ?>
		Prihlásený používateľ: <span style="color: #106cb5"><?php echo($_SESSION['username']) ?></span>&rsaquo;
		<a class='button' href='./#member=<?php echo($_SESSION['uid']) ?>'>Môj profil</a>
		<!--a class='button_register' href='#'>Žiadosti o priateľstvo (0)</a-->
		<a class='button_logout' href='logout.php'>Odhlásiť sa</a>
		<?php } ?>
	</div>
</div>