<?php

use org\bovigo\vfs\vfsStream;


class recordLogTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;


	/** @var string */
	protected $logDir;


	protected function _before() {
		$logDir = __CLASS__ . '.recordLogDir';
		vfsStream::setup($logDir);
		$this->logDir = vfsStream::url($logDir);
	}

	
	// tests
	public function testLoggingWorks() {
		$this->assertTrue(recordLog('Launching at port XX...', 'notice', NULL, $this->logDir));
		$this->assertTrue(recordLog('Internal at xXX crashed', 'fatal error', NULL, $this->logDir));
		$this->assertTrue(recordLog('Stopped', 'status', NULL, $this->logDir));

		$logFile = $this->logDir . '/' . date('Y') . '-' . date('m') . '.log';
		$this->assertFileExists($logFile);
		$logs = file_get_contents($logFile);

		$this->assertContains('Notice: Launching at port XX...', $logs);
		$this->assertContains('Fatal error: Internal at xXX crashed', $logs);
		$this->assertContains('Status: Stopped', $logs);
	}


	/**
	 * @skip this code should trigger an E_USER_NOTICE which is wrongly interpretted as PHPUnit_Framework_Exception
	 * @expectedException PHPUnit_Framework_Error_Notice
	 */
	public function testNLNotPermitted() {
		recordLog('Running' . "\nadditional information not logged", 'status', NULL, $this->logDir);
	}

}
