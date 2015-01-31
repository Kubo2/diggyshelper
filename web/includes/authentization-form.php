<?php

/**
 * Before include()ing this one, there MUST be sent a "401 Authorization Required" status
 * header, because this provides a specifc way to authenticate and user can authorizate through.
 *
 * @internal
 * @subpackage Application Includes
 * @version  1.0.0
 *
 * @author   Kubo2
 */

?>

<h1>Vyžadované overenie totožnosti</h1>
<p>Pre prezeranie tejto stránky je potrebné sa z technických či bezpečnostných dôvodov prihlásiť.
	Môžete tak učiniť cez formulár nižšie.</p>
<p>Ak nemáš záujem prezerať si túto stránku, môžeš ju s kľudným svedomím <a href='./index.php'>opustiť.</a></p>

<form action='./login.php?' method='POST' style='width: 20em; margin: auto' class="auth">
	<style scoped>form.auth label{display:block}form.auth input:not([type='submit']){float:right}</style>
	<label>Používateľ <input class='input' type='text' name='username'></label>
	<label>Heslo <input class='input' type='password' name='password'></label>
	<label style='clear: both'><input type='submit' name='submit' class='input_button' value='Prihlásiť sa'></label>
</form>
