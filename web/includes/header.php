<?php // TODO: poupraviť spôsob zobrazovania infoboxu ?>
<div id="header">
	<div id="loginprovizor">
		<?php 	if(!isset($_SESSION['uid'])): // TODO: restructure session array	?>
		<form action='login.php' method='post'>
			<?php if(in_array(basename($_SERVER["REQUEST_URI"]), [ 'register.php', ])): ?>
			<input type="hidden" name="redirect-noreferer" value="1">
			<?php endif ?>
			<input class='input' type='text' name='username' placeholder='Nickname'>
			<input class='input' type='password' name='password' placeholder='Heslo'>
			<!--label><input class='input' type='checkbox' name='remember'>&nbsp;Neodhlasovať ma</label--><br>
			<input type='submit' name='submit' class='input_button' value='Prihlásiť sa'>&nbsp;
			<!--a class='button_logout' href='#' >Zabudli ste heslo?</a>&nbsp;-->
			<a class='button_register' href='register.php'>Registrovať sa</a>
		</form>
		<?php else: ?>
		Prihlásený používateľ: <strong><?php echo($_SESSION['username']) ?></strong><br><br>
		<a class='button' href='./profile.php?user=<?php echo urlencode($_SESSION['username']) ?>'>Môj profil</a>
		<!--a class='button_register' href='#'>Žiadosti o priateľstvo (0)</a-->
		<a class='button_logout' href='logout.php'>Odhlásiť sa</a>
		<?php endif ?>
	</div>
</div>