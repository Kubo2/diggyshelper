--TEST--
test for sk_sanitizeEmail() library function
--FILE--
<?php

require(__DIR__ . '/../web/functions.php'); 		// functions library being tested

echo sk_sanitizeEmail("meno.strednemeno.priezvisko@subdomena.domena.genericka-domena");

--EXPECT--
meno (bodka) strednemeno (bodka) priezvisko (zavináč) subdomena (bodka) domena (bodka) genericka-domena
