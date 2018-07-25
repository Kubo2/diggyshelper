<?php

namespace dhTest;

use mysqli;

/**
 * This script sets up the environment for testsite-testing.
 *
 * @author  Kubo2
 */


$dbCfg = __DIR__ . '/../web/.db.cfg';
$dbCfgOrig = "$dbCfg.backup";

if(is_file($dbCfgOrig)) {
	failClean('impossible to backup .db.cfg, ' . basename($dbCfgOrig) . ' already exists');
} elseif(!rename($dbCfg, $dbCfgOrig)) {
	failClean('impossible to backup .db.cfg, rename() failed');
}

$dbDefaults = [
	'host' => 'localhost',
	'user' => 'dh_tester',
	'password' => 'testing',
	'name' => uniqid('dh_test_', TRUE)
];

if(!file_put_contents($dbCfg, '<?php return ' . var_export($dbDefaults, TRUE) . '?>')) {
	failClean('impossible to write .db.cfg', $dbCfg, $dbCfgOrig);
}

$dbContext = new mysqli($dbDefaults['host'], $dbDefaults['user'], $dbDefaults['password']);

if(!$dbContext->query('CREATE DATABASE `' . $dbContext->escape_string($dbDefaults['name']) . '`')) {
	failClean('could not create a database', $dbCfg, $dbCfgOrig, $dbContext);
}

// will use liquibase.properties in the same directory
$liquibase = escapeshellcmd(realpath(__DIR__ . '/../liquibase/liquibase.jar') . " --url=jdbc:mysql://{$dbDefaults['host']}/{$dbDefaults['name']} update");

if(substr(php_uname(), 0, 7) == 'Windows') {
	$liquibase = strtr($liquibase, ['/' => '^/']);

	// this is a workaround as there's no way of spawning a subprocess on Windows without the absolute path
	$liquibaseProc = popen("start /B C:\\ProgramData\\Oracle\\Java\\javapath\\java.exe -jar $liquibase 2>&1", 'r');
	
	$liquibaseOut = fgets($liquibaseProc, 28); // reads (length - 1) bytes
	pclose($liquibaseProc);
} else {
	exec("java -jar $liquibase 2>&1", $liquibaseOut);
	$liquibaseOut = substr($liquibaseOut[0], 0, 27);
}


if(strcmp($liquibaseOut, 'Liquibase Update Successful') <> 0) {
	failClean('database setup failed' . $liquibaseOut, $dbCfg, $dbCfgOrig, $dbContext, $dbDefaults['name']);
}


unset($dbCfg, $dbCfgOrig, $dbDefaults, $dbContext, $liquibase, $liquibaseProc, $liquibaseOut);


//
// helpers
//

function failClean($reason, $dbCfg = NULL, $dbCfgBackup = NULL, $dbContext = NULL, $dbName = NULL) {
	if($dbCfg && $dbCfgBackup) {
		rename($dbCfgBackup, $dbCfg);
	}

	if($dbContext) {
		if($dbName) {
			$dbContext->query('DROP DATABASE IF EXISTS `' . $dbContext->escape_string($dbName) . '`');
		}

		$dbContext->close();
	}

	die("fail $reason");
}
