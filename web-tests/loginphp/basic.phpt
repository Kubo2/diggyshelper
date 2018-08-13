--TEST--
basic login.php functionality test
--INI--
assert.active=1
--ENV--
return '
HTTP_REFERER=https://example.com/backlink
SERVER_NAME=example.com
REQUEST_URI=/login.php
';
--POST--
username=Example&password=example
--FILE--
<?php

require __DIR__ . '/../bootstrap.php';

session_save_path(__DIR__ . '/../session');

require __DIR__ . '/../../web/login.php'; // exit()s

assert($_SESSION['username'] === 'Example', 'username needs to be set to Example in session');
assert($_SESSION['uid'] === 4, 'uid needs to be 4 in session according to test-data.sql');

?>
--CLEAN--
<?php sleep(5); require __DIR__ . '/../cleanup.php' ?>
--EXPECTHEADERS--
HTTP/1.1 303 See Other
Location: https://example.com/backlink
--EXPECT--
Resource Has Been Moved To: https://example.com/backlink
