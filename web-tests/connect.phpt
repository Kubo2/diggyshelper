--TEST--
basic connect.php functionality test
--INI--
assert.active=1
--FILE--
<?php

require __DIR__ . '/bootstrap.php';


$dbContext = require __DIR__ . '/../web/connect.php';

assert(defined('DB_CONNECTED'), 'DB_CONNECTED has not been defined');
assert(DB_CONNECTED === $dbContext, 'the value returned by connect.php is not the same as DB_CONNECTED'); // this would be really odd

assert(is_resource($dbContext), 'the value returned by connect.php is not a resource');
assert(get_resource_type($dbContext) === 'mysql link', 'the value returned by connect.php is not a mysql link');
assert((bool) mysql_stat($dbContext), 'mysql_stat failed to return server info');

?>
ok
--EXPECT--
ok
--CLEAN--
<?php require __DIR__ . '/cleanup.php' ?>
