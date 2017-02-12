<?php

// yeah it's true, this page is never gonna come back
header('HTTP/1.1 410 Gone', TRUE, 410);
header('Content-Type: text/html; charset=UTF-8');

ob_start(function($buffer) {
	header('Content-Length: ' . strlen($buffer));
	return FALSE;
});

echo <<< HTML
<!doctype html>
<title>Odstránené</title>
<h1>Zmazaná stránka</h1>
<p>Táto stránka bola integrovaná do stránky <a href='statistics.php'>Štatistiky</a> a zmazaná.
Informácie, ktoré ste tu pôvodne hľadali, hľadajte prosím teraz tam.</p>
<cite><a href='authors.php#Kubo2'>Kubo2</a></cite>, DH backend programátor
HTML;

ob_end_flush();

exit;
