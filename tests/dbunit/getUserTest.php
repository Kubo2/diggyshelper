<?php


/**
 * @internal here in this test we rely on $tester->haveDbContext() to be the last opened 'mysql link'
 */
class getUserTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;


	protected function _before() {

	}


	protected function _after() {

	}


	// tests
	public function testGetById() {
		$this->assertSame('Kubo2', getUser(1, 'username'));
		$this->assertSame(
			['username' => 'WladinQ', 'access' => 'admin', 'email' => 'vladimir.jacko.ml@gmail.com'],
			getUser(3, ['username', 'access', 'email'])
		);
		$this->assertSame('admin', getUser(2, ['access']));
		$this->assertSame('member', getUser(4, 'access'));
	}


	public function testNullOnNull() {
		$this->assertNull(getUser(4, 'description'));
	}


	public function testGetNonexistent() {
		$this->tester->dontSeeInDatabase('users', ['id' => 5]);
		$this->assertFalse(getUser(5, 'username'));
	}

}
