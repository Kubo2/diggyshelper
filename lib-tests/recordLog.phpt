--TEST--
test for recordLog() library function
--FILE--
<?php

// <DEPS />
require __DIR__ . '/../web/functions.php';

// <TEST>
const TEST_LOG_SECTION = 'dummy-sect';
define('TEST_LOG_DIR', __DIR__ . '/logs');

var_dump(recordLog('Launching at port XX...', 'notice', TEST_LOG_SECTION, TEST_LOG_DIR));
var_dump(recordLog('Running' . "\nadditional information not logged", 'status', TEST_LOG_SECTION, TEST_LOG_DIR));
var_dump(recordLog('Internal at xXX crashed', 'fatal error', TEST_LOG_SECTION, TEST_LOG_DIR));
var_dump(recordLog('Stopped', 'status', TEST_LOG_SECTION, TEST_LOG_DIR));

// the filename which should be the test's logfile
readfile(sprintf('%s/%s-%d-%s.log', TEST_LOG_DIR, TEST_LOG_SECTION, date('Y'), date('m')));
// </TEST>

?>
--CLEAN--
<?php

const TEST_LOG_SECTION = 'dummy-sect';
define('TEST_LOG_DIR', __DIR__ . '/logs');

if(is_file(sprintf('%s/%s-%d-%s.log', TEST_LOG_DIR, TEST_LOG_SECTION, date('Y'), date('m')))) {
	unlink(sprintf('%s/%s-%d-%s.log', TEST_LOG_DIR, TEST_LOG_SECTION, date('Y'), date('m')));
}

if(is_dir(TEST_LOG_DIR)) {
	rmdir(TEST_LOG_DIR);
}

?>
--EXPECTF--
bool(true)

Notice: $message should not contain a newline in %s on line %d
bool(true)
bool(true)
bool(true)
[%d-%d-%d %d:%d:%d] Notice: Launching at port XX...
[%d-%d-%d %d:%d:%d] Status: Running
[%d-%d-%d %d:%d:%d] Fatal error: Internal at xXX crashed
[%d-%d-%d %d:%d:%d] Status: Stopped
