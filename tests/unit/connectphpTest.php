<?php

class connectphpTest extends \Codeception\Test\Unit {
	
	/**
	 * @var \UnitTester
	 */
	protected $tester;


	protected function _before() {

	}


	protected function _after() {

	}


	// tests
	public function testConnect() {
		$dbContext = require __DIR__ . '/../../web/connect.php';

		$this->assertTrue(defined('DB_CONNECTED'), 'DB_CONNECTED has not been defined');
		$this->assertSame($dbContext, DB_CONNECTED, 'the value returned by connect.php is not the same as DB_CONNECTED');
		$this->assertInternalType('resource', $dbContext, 'the value returned by connect.php is not a resource');
		$this->assertEquals('mysql link', get_resource_type($dbContext), 'the value returned by connect.php is not a mysql link');
		$this->assertNotEmpty(mysql_stat($dbContext), 'mysql_stat failed to return server info');
	}

}