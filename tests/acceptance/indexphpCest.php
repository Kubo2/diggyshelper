<?php


class indexphpCest {

	public function _before(AcceptanceTester $I) {

	}

	public function _after(AcceptanceTester $I) {

	}


	// tests
	public function home(AcceptanceTester $I) {
		$I->amOnPage('/');
		$I->see('Vítame ťa na stránke Diggy\'s Helper');
	}

}
