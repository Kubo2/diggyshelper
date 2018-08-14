<?php


class loggedInTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;


	protected function _before() {
		session_start();
		$_SESSION = array();
	}


	protected function _after() {
		session_write_close();
	}


	// tests
	public function testReportSignedIn() {
		$_SESSION = array('uid' => 1, 'username' => 'Kubis');
		$this->assertTrue(loggedIn());
	}


	public function testReportSignedOut() {
		// user signed out by default
		$this->assertFalse(loggedIn());
	}
}
