--TEST--
basic logout.php functionality test
--INI--
session.gc_probability=0
--FILE--
<?php

session_save_path(__DIR__ . '/session');

require __DIR__ . '/../web/logout.php';

?>
ok
--EXPECTHEADERS--
Location: index.php
--EXPECT--
ok
