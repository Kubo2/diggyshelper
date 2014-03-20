<div id="header">
	<div id="loginprovizor">
		<?php session_start(); ?>
		<?php
			if (!isset($_SESSION['uid'])) {
				echo "<form action='login.php' method='post'>
				<input class='input' type='text' name='username' placeholder='Nickname' value='' /><br/>
				<input class='input' type='password' name='password' placeholder='Heslo' value='' />&nbsp;
				<input class='input' type='checkbox' name='remember'> Neodhlasovať ma<br/>
				<input type='submit' name='submit' class='input_button' value='Prihlásiť sa' />&nbsp;
				<a class='button_logout' href='#'>Zabudli ste heslo?</a>&nbsp;
				<a class='button_register' href='register.php'>Registrovať sa</a>
				";
			} else {
				echo("Prihlásený používateľ: <font color='#106CB5'>$_SESSION[username]</font></br>
				<img src='#'>
				<br/><a class='button' href='#'>Môj profil</a> <a class='button_register' href='#'>Žiadosti o priateľstvo (0)</a> <a class='button_logout' href='logout.php'>Odhlásiť sa</a>");
			}
		?>
	</div>
</div>