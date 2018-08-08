<?php


class genericCest {

	public function _before(AcceptanceTester $I) {
		$I->amOnPage('/');
	}


	public function _after(AcceptanceTester $I) {

	}


	// tests
	public function home(AcceptanceTester $I) {
		$I->see('Vítame ťa na stránke Diggy\'s Helper');
	}


	public function loginLogout(AcceptanceTester $I) {
		$I->seeElement('form', ['method' => 'post', 'action' => 'login.php']);
		$I->seeInField('.input_log', 'Prihlásiť sa');
		
		$I->fillField(['name' => 'username'], 'Kubo2');
		$I->fillField(['name' => 'password'], 'heslo123');
		$I->click('Prihlásiť sa');

		$I->seeCookie('PHPSESSID');
		$I->canSeeInSource('<b>Kubo2</b>');
		$I->seeLink('Môj profil');
		$I->seeLink('Odhlásiť sa', 'logout.php');

		$I->click('Odhlásiť sa');
		$I->seeInField('.input_log', 'Prihlásiť sa');
	}

}
