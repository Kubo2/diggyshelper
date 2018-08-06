<?php

class connectphpTest extends \Codeception\Test\Unit {
	
	/**
	 * @var \UnitTester
	 */
	protected $tester;


	/**
	 * @var resource(mysql link)
	 */
	protected $dbContext;


	protected function _before() {
		$this->dbContext = require __DIR__ . '/../../web/connect.php';
	}


	protected function _after() {
		mysql_close($this->dbContext);
	}


	// tests
	public function testConnect() {
		$this->assertTrue(defined('DB_CONNECTED'), 'DB_CONNECTED has not been defined');
		$this->assertSame($this->dbContext, DB_CONNECTED, 'the value returned by connect.php is not the same as DB_CONNECTED');
		$this->assertInternalType('resource', $this->dbContext, 'the value returned by connect.php is not a resource');
		$this->assertEquals('mysql link', get_resource_type($this->dbContext), 'the value returned by connect.php is not a mysql link');
		$this->assertNotEmpty(mysql_stat($this->dbContext), 'mysql_stat failed to return server info');
	}

}
