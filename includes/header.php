<div id="header">
	<?php @session_start() ?>
	<div id="loginprovizor">
<?php if (!isset($_SESSION['uid'])) { ?>
<form action='login.php' method='post'>
	<input class='input' type='text' name='username' placeholder='Nickname'><br>
	<input class='input' type='password' name='password' placeholder='Heslo'>
	<input class='input' type='checkbox' name='remember'> Neodhlasovať ma<br>
	<input type='submit' name='submit' class='input_button' value='Prihlásiť sa' >&nbsp;
	<a class='button_logout' href='#' >Zabudli ste heslo?</a>&nbsp;
	<a class='button_register' href='register.php'>Registrovať sa</a>
</form>
<?php } else { ?>
Prihlásený používateľ: 
<font color='#106CB5'><?php echo($_SESSION['username']) ?></font> 
<br><br><a class='button' href='#'>Môj profil</a> 
<a class='button_register' href='#'>Žiadosti o priateľstvo (0)</a> 
<a class='button_logout' href='logout.php'>Odhlásiť sa</a>
<?php } ?>
</div>
</div>