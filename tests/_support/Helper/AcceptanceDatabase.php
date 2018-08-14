<?php

namespace Helper;

use Codeception\Exception\ModuleException;


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


	/** @var string .db.cfg filename */
	private $dbCfg;


	/** @var string backup .db.cfg filename */
	private $origCfg;


	public function _initialize() {
		parent::_initialize();
		$this->dbCfg = realpath(getcwd() . '/' . $this->config['dbCfg']);
		$this->origCfg = "$this->dbCfg.backup";
	}


	public function _beforeSuite($settings = array()) {
		parent::_beforeSuite($settings);

		if(is_file($this->origCfg) || !$this->backupFile($this->dbCfg, $this->origCfg)) { // backup .db.cfg
			$baseOrig = basename($this->origCfg);
			throw new ModuleException($this, "failed to backup $this->dbCfg, perhaps $baseOrig already exists?");
		}

		$write = '<?php return ' . var_export([ 'name' => $this->mysqlConfig['dbname'] ] + $this->mysqlConfig, TRUE) . '?>';
		$this->debug("Writing $this->dbCfg");
		if(!file_put_contents($this->dbCfg, $write)) {
			throw new ModuleException($this, "failed to write $this->dbCfg, please rollback from $this->origCfg manually");
		}
	}


	public function _afterSuite() {
		parent::_afterSuite();

		if(is_file($this->origCfg)) { // assume this is the original version
			if(!$this->backupFile($this->origCfg, $this->dbCfg)) {
				throw new ModuleException($this, "failed to rollback $this->dbCfg");
			}
		}
	}


	private function backupFile($orig, $backup) {
		$this->debugSection('Backup', "Renaming $orig to $backup");
		return rename($orig, $backup);
	}

}
