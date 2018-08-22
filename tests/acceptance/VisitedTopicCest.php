<?php


class VisitedTopicCest {

	public function _before(AcceptanceTester $I) {

	}


	public function _after(AcceptanceTester $I) {

	}


	// tests
	public function visitedTopicCookieGetsSent(AcceptanceTester $I) {
		$I->amOnPage('/view_topic.php?tid=1');
		$I->seeCookie('visitedTopics');
	}


	public function topicGetsHighlighted(AcceptanceTester $I) {
		$I->setCookie('visitedTopics', '1,1'); // one second after the Unix epoch
		$I->amOnPage('/');
		$I->seeElement('span.unread-posts');
	}
	
}
