<?php

namespace Helper;


/**
 * This module provides unit tests with an active 'mysql link' connection to the testing database.
 *
 * @author  Kubo2
 */
class UnitDatabase extends DhDatabase {

	/**
	 * Return the currently active database context.
	 * @return resource(mysql link)
	 */
	public function grabDbContext() {
		return $this->dbContext;
	}

}
