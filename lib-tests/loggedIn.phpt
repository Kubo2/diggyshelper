--TEST--
basic test for loggedIn() lib function
--INI--
session.gc_probability=0
assert.active=1
--FILE--
<?php

// store session data locally
session_save_path(__DIR__ . '/../web-tests/session');

// loggedIn() needs an active session
session_start();
assert(session_decode('uid|i:1;username|s:5:"Kubis";'), 'failed to arrange testing session');

// for reference
printf("PHPSESSID=%s\n", session_id());

// functions library being tested
require __DIR__ . '/../web/functions.php';

/* should print: User is signed in. */
test_translate(loggedIn());

// sign out
$_SESSION = array();

/* should print: User is not signed in.*/
test_translate(loggedIn());


// helper function
function test_translate($bool) {
	echo 'User ' . ($bool ? 'is' : 'is not') . " signed in.\n";
}

?>
--EXPECTF--
PHPSESSID=%s
User is signed in.
User is not signed in.
