<?php

namespace Helper;

use Codeception\Exception\ModuleException;


// ext-mysql in 5.4.0 >= PHP < 7.0.0 generates an E_DEPRECATED on each call
error_reporting(E_ALL & ~E_DEPRECATED);


/**
 * Populates a 'mysql link' connection to database in addition to the default PDO one.
 *
 * @author  Kubo2
 */
abstract class DhDatabase extends \Codeception\Module\Db {

	/** @var resource(mysql link) */
	protected $dbContext;


	/**
	 * 'mysql link' connection config.
	 * @internal populated by self::_initialize()
	 * @var array
	 */
	protected $mysqlConfig = [];


	/**
	 * @throws ModuleException
	 */
	public function _initialize() {
		$meta = $this->parseDsn($this->config['dsn']);

		if(array_key_exists('unix_socket', $meta)) {
			$meta['host'] = ":$meta[unix_socket]";
			unset($meta['unix_socket'], $meta['port']);
		}

		if(!array_key_exists('host', $meta) || !array_key_exists('dbname', $meta)) {
			throw new ModuleException($this, 'dsn has to contain both \'host\' (or \'unix_socket\') and \'dbname\' keys');
		}

		if(!empty($meta['port'])) {
			$meta['host'] = "$meta[host]:$meta[port]";
			unset($meta['port']);
		}
		$this->dbContext = mysql_connect($meta['host'], $this->config['user'], $this->config['password']);

		if(!$this->dbContext) {
			throw new ModuleException($this, 'could not connect to database using ext-mysql');
		}

		if(array_key_exists('charset', $meta)) {
			mysql_set_charset($meta['charset'], $this->dbContext);
		}

		mysql_select_db($meta['dbname'], $this->dbContext);

		$this->mysqlConfig = $meta + array('user' => $this->config['user'], 'password' => $this->config['password']);
		$this->debugSection('DhDatabase', json_encode($this->mysqlConfig));

		parent::_initialize();
	}


	/**
	 * Parse PDO-style connection string for MySQL into an array.
	 *
	 * @param  string DSN
	 * @return array(param => value)
	 * @throws ModuleException if the connection string is not for MySQL
	 */
	private function parseDsn($dsn) {
		list($prefix, $dsn) = explode(':', $dsn, 2);
		if($prefix !== 'mysql') {
			throw new ModuleException($this, "impossible to utilize $prefix: dsn, only mysql: dsn available");
		}

		$params = [];
		foreach(explode(';', $dsn) as $param) {
			list($p, $v) = explode('=', $param);
			$params[$p] = $v;
		}

		return $params;
	}


	public function _conflicts() {
		return 'Codeception\Lib\Interfaces\Db';
	}

}
