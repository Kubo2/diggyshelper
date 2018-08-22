<?php

/**
 * Shared functionality for {@link ../view_topic.php}.
 *
 * @author  Kubo2
 */

namespace dhForum\viewTopic;


/**
 * Provides functionality to work with the “visited topics” cookie format.
 *
 * Cookie formát je formálne definovaný nasledovne:
 *
 *   topicid := <integer>+
 *   timestamp := <integer>+
 *   record := <topicid>,<timestamp>
 *   cookie := <record>[,<record>]
 *
 * V praxi vyzerá asi takto:
 *
 *   258,1534887643,928,1531864211,375,1527198611
 */
class VisitedTopicCookie {

	const DELIM = ',';


	/**
	 * Topic ID to \DateTime of last visit mapping.
	 *
	 * @var array(int => \DateTime)
	 */
	private $topics = [];


	/**
	 * Constructs an instance of this object from $format.
	 */
	public function __construct($format = NULL) {
		if($format !== NULL) {
			$this->decode($format);
		}
	}


	/**
	 * Parses $format and reintializes the instance with obtained values.
	 * Following the nature of “having visited” someplace, there isn't a way
	 * to remove a recorded visit from the instance.
	 *
	 * @param  string the formatted string
	 * @throws \InvalidArgumentException on invalid $format type
	 */
	public function decode($format) {
		if(!is_string($format)) {
			throw new \InvalidArgumentException('$format must be a string');
		}

		$this->parse($format);
	}


	/**
	 * Visits a topic programmatically.
	 *
	 * @param  int which
	 * @param  \DateTime when
	 */
	public function visit($visited, \DateTime $when) {
		$this->topics[$visited] = $when;
	}


	/**
	 * @throws \DomainException on invalid $format format
	 */
	protected function parse($format) {
		$parts = explode(static::DELIM, $format);
		if(count($parts) & 1) { // intenationally & -- the number is odd if the first bit is set
			throw new DomainException('$format must contain an even number of records');
		}

		$isKey = TRUE;
		foreach($parts as $record) {
			if($isKey) {
				$key = intval($record);
			} else {
				try {
					$this->topics[$key] = @ new \DateTime("@$record");
				} catch(\Exception $e) {
					// pass
				}
			}

			$isKey = !$isKey;
		}
	}


	/**
	 * Returns the “visited topics” cookie format representation of the instance.
	 *
	 * @return string
	 */
	public function encode() {
		foreach($this->topics as $visited => $when) {
			$format[] = $visited . static::DELIM . $when->getTimestamp();
		}

		return implode(static::DELIM, $format);
	}


	/**
	 * @return string
	 */
	public function __toString() {
		return $this->encode();
	}


	/**
	 * Was a topic visited?
	 *
	 * @param  int which
	 * @return bool
	 */
	public function was($tid) {
		return array_key_exists($tid, $this->topics);
	}


	/**
	 * When was a topic visited?
	 *
	 * @param  int which
	 * @return \DateTime
	 */
	public function when($tid) {
		if(!$this->was($tid)) {
			throw new \OutOfBoundsException("$tid hasn't been visited yet");
		}

		return $this->topics[$tid];
	}

}
