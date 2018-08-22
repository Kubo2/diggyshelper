<?php

use dhForum\viewTopic\VisitedTopicCookie;


class VisitedTopicCookieTest extends \Codeception\Test\Unit {

	const FORMAT = '258,1534887643,928,1531864211,375,1527198611';


	/**
	 * @var \UnitTester
	 */
	protected $tester;


	protected function _before() {

	}


	protected function _after() {

	}


	// tests
	public function testDecode() {
		$visited = new VisitedTopicCookie(static::FORMAT);
		$this->assertTrue($visited->was(258));
		$this->assertFalse($visited->was(999));
		$this->assertInstanceOf(DateTime::class, $visited->when(928));
	}


	public function testEncode() {
		$visited = new VisitedTopicCookie(static::FORMAT);
		$this->assertSame(static::FORMAT, $visited->encode());
		$this->assertSame(static::FORMAT, (string) $visited);
	}


	public function testWhen() {
		$when = new DateTime('1999-09-08');
		$visited = new VisitedTopicCookie('1,' . $when->getTimestamp());
		$this->assertEquals($when, $visited->when(1));
	}


	public function testVisit() {
		$visited = new VisitedTopicCookie;
		$visited->visit(42, new DateTime);
		$this->assertTrue($visited->was(42));
	}

}
