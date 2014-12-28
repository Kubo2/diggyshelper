--TEST--
test for loggedIn() library function
--FILE--
<?php

session_start(); 						// require sessions
$_SESSION = array();
require(__DIR__ . '/../web/functions.php'); 		// functions library being tested

/* IS signed in. */
$_SESSION['uid'] = 1;
echo 'User ', loggedIn() ? 'is' : 'is not', ' signed in.' . PHP_EOL;

/* Is NOT signed in. */
$_SESSION['uid'] = NULL;
echo 'User ', loggedIn() ? 'is' : 'is not', ' signed in.' . PHP_EOL;

--EXPECT--
User is signed in.
User is not signed in.
