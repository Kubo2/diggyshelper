<?php


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
		$dbContext = $this->tester->grabDbContext();

		$this->assertSame('Kubo2', getUser($dbContext, 1, 'username'));
		$this->assertSame(
			['username' => 'WladinQ', 'access' => 'admin', 'email' => 'vladimir.jacko.ml@gmail.com'],
			getUser($dbContext, 3, ['username', 'access', 'email'])
		);
		$this->assertSame('admin', getUser($dbContext, 2, ['access']));
		$this->assertSame('member', getUser($dbContext, 4, 'access'));
	}


	public function testNullOnNull() {
		$dbContext = $this->tester->grabDbContext();

		$this->assertNull(getUser($dbContext, 4, 'description'));
	}


	public function testGetNonexistent() {
		$dbContext = $this->tester->grabDbContext();

		$this->tester->dontSeeInDatabase('users', ['id' => 5]);
		$this->assertFalse(getUser($dbContext, 5, 'username'));
	}

}
