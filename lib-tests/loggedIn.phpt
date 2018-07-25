--TEST--
test for loggedIn() library function
--INI--
session.gc_probability=0
--COOKIE--
PHPSESSID=user-session
--FILE--
<?php

// functions library being tested
require __DIR__ . '/../web/functions.php';

// loggedIn() needs an active session
session_save_path(__DIR__ . '/../web-tests/session');
session_start();

$data = $_SESSION;


/* test IS signed in. */
test_translate(loggedIn());

// sign out
$_SESSION = array();

/* Is NOT signed in. */
test_translate(loggedIn());


// discard session changes!
$_SESSION = $data;

// helper
function test_translate($bool) {
	echo 'User ' . ($bool ? 'is' : 'is not') . " signed in.\n";
}

?>
--EXPECT--
User is signed in.
User is not signed in.
