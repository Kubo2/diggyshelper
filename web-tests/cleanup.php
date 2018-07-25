<?php

namespace dhTest;

use mysqli;

/**
 * This script cleans up after testsite-testing.
 *
 * @author  Kubo2
 */


$dbCfg = __DIR__ . '/../web/.db.cfg';
$dbCfgOrig = "$dbCfg.backup";

// assume .db.cfg exists if the backup exists
if(is_file($dbCfgOrig)) {
	$dbDefaults = require $dbCfg;

	$dbContext = new mysqli($dbDefaults['host'], $dbDefaults['user'], $dbDefaults['password']);
	$dbContext->query('DROP DATABASE IF EXISTS `' . $dbContext->escape_string($dbDefaults['name']) . '`');

	rename($dbCfgOrig, $dbCfg);
}
