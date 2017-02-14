<!-- znásilnený checkbox (http://djpw.cz/166587#22)' --><input type='checkbox' id='mmenu-state'>
<label for='mmenu-state'><!-- tento element sa napozicuje nad ikonku menu -->
	<font color="#FFF" size="5px" style="position: relative; left: 5px; bottom: 2px;">Diggy's Helper</font>
</label>
<div id="menu">

<?php

/**
 * @var array(url => array(text [, class [, id ]]))
 * @todo take on the idea
 */
$items = [
	'register.php' => ['Registrovať sa', ],
];

?>


<?php if(!isset($_SESSION['uid'])): // $user->isLoggedIn() ?>
	<a href="register.php" id="regAlog" class='first-item'>Registrovať sa</a>
	<!--a href="" id="regAlog">Prihlásiť sa</a-->
	<a href="index.php">Domov</a>
<?php else: // !$user->isLoggedIn() ?>
	<a href="index.php" class='first-item'>Domov</a>
<?php endif // $user->isLoggedIn() ?>

	<a href="forum.php">Fórum</a>
	<a href="whatandhow.php">Diggy's Adventure</a>
	<a href="attractions.php">Zaujímavosti</a>
	<!--a href="contest.php">Súťaže</a-->
	<a href="statistics.php">Štatistiky</a>
	<a href="authors.php">Autori</a><!--
	font class="jazykon">Slovenský</font>&nbsp;&nbsp;&nbsp;<a href="">English</a
--></div>

<?php if(FALSE): ?>
<!--ul id="sutaz">
		!!! NOVÁ SÚTAŽ PRÁVE TERAZ !!!<br/><br/>
		Hrá sa o 50 gemov v hre Diggy's Adventure.<br><br>
		<a href="contest.php" class="button">Viac informácii</a>
		
	</ul-->
<!-- nabudúce prosím radšej <div> ~Kubo2 -->
<?php endif ?>
