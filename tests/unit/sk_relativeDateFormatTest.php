<?php


class sk_relativeDateFormatTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;


	/**
	 * @return array([string $expectedValue, DateTime $date, DateTime $relativeTo], ...)
	 */
	public function dates() {
		$now = new DateTimeImmutable;
		return [
			'5 years ago' => [$this->timeDávno(), new DateTimeImmutable('-5 years'), $now],
			'1 year ago' => [$this->timeDávno(), new DateTimeImmutable('-1 year'), $now],
			'11 months and a week ago' => [$this->timeDávno(), new DateTimeImmutable('-11 months -1 week'), $now],
			'7 months ago' => [$this->timePolroka(), new DateTimeImmutable('-7 months'), $now],
			'5 months ago' => [$this->timeMonths(5), new DateTimeImmutable('-5 months'), $now],
			'1 month and a week ago' => [$this->timeMonths(2), new DateTimeImmutable('-1 month -1 week'), $now],
			'1 month ago' => [$this->timeWeeks(4), new DateTimeImmutable('-1 month'), $now],
			'1 week ago' => [$this->timeDays(7), new DateTimeImmutable('-1 week'), $now],
			'1 day ago' => [$this->timeHours(24), new DateTimeImmutable('-1 day'), $now],
			'3 hours ago' => [$this->timeHours(3), new DateTimeImmutable('-3 hours'), $now],
			'1 hour ago' => [$this->timeMins(60), new DateTimeImmutable('-1 hour'), $now],
			'half an hour ago' => [$this->timeMins(25), new DateTimeImmutable('-25 minutes'), $now],
			'1 minute ago' => [$this->timeTeraz(), new DateTimeImmutable('-1 minute'), $now],
			'half a minute ago' => [$this->timeTeraz(), new DateTimeImmutable('-25 seconds'), $now],
		];
	}


	private function timeDávno() {
		return 'dávno';
	}


	private function timePolroka() {
		return 'pred pol rokom';
	}


	private function timeMonths($n) {
		return "pred $n mesiacmi";
	}


	private function timeWeeks($n) {
		return "pred $n týždňami";
	}


	private function timeDays($n) {
		return "pred $n dňami";
	}


	private function timeHours($n) {
		return "pred $n hodinami";
	}


	private function timeMins($n) {
		return "pred $n minútami";
	}


	private function timeTeraz() {
		return 'teraz';
	}


	// tests
	/**
	 * @dataProvider dates
	 */
	public function testRelativeDateFormatCorrect($exp, $date, $relativeTo) {
		$this->assertSame($exp, sk_relativeDateFormat($date, $relativeTo));
	}

}
