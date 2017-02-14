<?php

/** @var string current processing script */
$page = basename((0 < $q = strpos($u = $_SERVER['REQUEST_URI'], '?')) ? substr_replace($u, '', $q) : $u);

?>
<div id="header">
	<a href='./' class='logo'>Diggy's Helper</a>

	<div id="loginprovizor">
		<?php 	if(!isset($_SESSION['uid'])): // TODO: restructure session array	?>
		<form action='login.php' method='post'>
			<?php   if(in_array($page, [ 'register.php', 'login.php', ], TRUE)):   ?>
				<input type="hidden" name="redirect-noreferer" value="1">
			<?php endif ?>
			<input class='input' type='text' name='username' placeholder='Nickname'><br>
			<input class='input' type='password' name='password' placeholder='Heslo'>
			<!--label><input class='input' type='checkbox' name='remember'>&nbsp;Neodhlasovať ma</label--><br><br>
			<input type='submit' name='submit' class='input_log' value='Prihlásiť sa'>&nbsp;
			<!--a class='button_logout' href='#' >Zabudli ste heslo?</a>&nbsp;-->
			<a class='button_register' href='register.php'>Registrovať sa</a>
		</form>
		<?php else: ?>
		<img type="userimages" src="images/thumb/no-avatar.jpg" align="left" alt="Profilová fotografia">
		<b><?= htmlspecialchars($_SESSION['username']) ?></b><br><br>
		Počet príspevkov: <?= $_SESSION['userbox']['user.posts.count'] ?><br>
<!--		Posledná návšteva: 00/00/0000<br>-->
		Deň registrácie: <?= date('d. m. Y', $_SESSION['userbox']['user.reg.date']) ?>

		<div class="buttonmenu">
			<a class='button-header' title='Môj profil' href='./profile.php?user=<?= urlencode($_SESSION['username']) ?>'>
				Môj profil
			</a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a class='button-header' title='Fórum' href='forum.php'>
				Fórum
			</a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a
				class='button_logout'
				title='Odhlásiť sa'
				href='logout.php'>
					Odhlásiť sa
			</a>
		</div>
		<?php endif ?>
	</div>
</div>
