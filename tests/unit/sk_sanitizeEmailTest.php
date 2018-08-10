<?php


class sk_sanitizeEmailTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;


	// tests
	public function testTranslate() {
		$translated = sk_sanitizeEmail('meno.strednemeno.priezvisko@subdomena.domena.genericka-domena');
		$this->assertSame('meno (bodka) strednemeno (bodka) priezvisko (zavináč) subdomena (bodka) domena (bodka) genericka-domena', $translated);
	}

}
