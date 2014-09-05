<?php // TODO: poupraviť spôsob zobrazovania infoboxu ?>
<div id="header">
	<div id="loginprovizor">
		<?php 	if(!isset($_SESSION['uid'])): // TODO: restructure session array	?>
		<form action='login.php' method='post'>
			<?php if(in_array(basename($_SERVER["REQUEST_URI"]), [ 'register.php', ])): ?>
			<input type="hidden" name="redirect-noreferer" value="1">
			<?php endif ?>
			<input class='input' type='text' name='username' placeholder='Nickname'><br>
			<input class='input' type='password' name='password' placeholder='Heslo'>
			<!--label><input class='input' type='checkbox' name='remember'>&nbsp;Neodhlasovať ma</label--><br><br>
			<input type='submit' name='submit' class='input_button' value='Prihlásiť sa'>&nbsp;
			<!--a class='button_logout' href='#' >Zabudli ste heslo?</a>&nbsp;-->
			<a class='button_register' href='register.php'>Registrovať sa</a>
		</form>
		<?php else: ?>
		<img type="userimages" src="images/thumb/no-avatar.jpg" align="left" alt="Profilová fotografia">
		Prihlásený používateľ &raquo; <strong><?php echo($_SESSION['username']) ?></strong><br><br>
		Počet príspevkov: -1<br>
		Posledná návšteva: 00/00/0000<br>
		<hr/>
		<a class='button' title='Môj profil' href='./profile.php?user=<?php echo urlencode($_SESSION['username']) ?>'><img type='userbuttons' src='./images/icon/profile1.png'></a> 
		<!--a class="button_register" title="Žiadosti o priateľstvo" href="#"><img type="userbuttons" src="icon/friends.png"> (0)</a--> 
		<!--a class="button_register" title="Upozornenia" href="#"><img type="userbuttons" src="icon/info2.png"> (0)</a-->
		<!--a class="setting" title="Nastavenia (Administrátor)" href="#"><img type="adminmoderatorbuttons" src="icon/as.png"></a-->
		<!--a class="setting" title="Nastavenia (Moderátor)" href="#"><img type="adminmoderatorbuttons" src="icon/ms.png"></a-->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a style='float:right;' class='button_logout' title='Odhlásiť sa' href='logout.php'><img type='userbuttons' src='./images/icon/off2.png'></a>
		<?php endif ?>
	</div>
</div>