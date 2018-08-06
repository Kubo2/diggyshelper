<?php

namespace Helper;


/**
 * This module extends the functionality of DhDatabase to generate
 * a .db.cfg database configuration with testing values and rollback
 * after testing.
 *
 * Additionaly it defines the 'dbCfg' required option which should be a path
 * to the dhForum's .db.cfg file relative to the location of codeception.yml.
 *
 * @author  Kubo2
 */
class AcceptanceDatabase extends DhDatabase {

	/** @var array */
	protected $requiredFields = ['dsn', 'user', 'password', 'dbCfg'];


	public function _beforeSuite($settings = array()) {
		$this->debug(realpath(getcwd() . '/' . $this->config['dbCfg']));
		parent::_beforeSuite($settings);
		$this->debug(__METHOD__);
	}


	public function _afterSuite() {
		parent::_afterSuite();
		$this->debug(__METHOD__);
	}

}
