<?php

/**
 * Connects to a database and returns the connection resource identifier.
 *
 * @return resource|boolean mysql resource if successful, or FALSE on failure
 * @constant resource|boolean DB_CONNECTED
 *
 * By our local convention, there's file placed in the same directory called {@file .db.cfg}.
 * This is a PHP script which yields to returning an array of strings containing all of
 * the data necessary to connect to a database:
 *
 * array(
 * 	host => string database server hostname
 * 	user => string server login
 * 	password => string password for the login
 * 	name => string the database's name used for dh Forum
 * )
 *
 * @author Kubo2
 * @version 0.2
 */


if(!defined('DB_CONNECTED')) {
	try {
		$helper = _connectphp_dbconnect(__DIR__ . '/.db.cfg');
		define('DB_CONNECTED', $helper->getConnection());
	} catch(\Exception $e) {
		trigger_error($e->getMessage(), E_USER_WARNING);
		define('DB_CONNECTED', FALSE);
	}
}

return DB_CONNECTED;


/**
 * @param string the path to a database configuration PHP script
 * @return DbConnectionHelper
 */
function _connectphp_dbconnect($dataFile) {
	if(!is_file($dataFile)) {
		trigger_error("You will need to configure your $dataFile file to get a database connection", E_USER_WARNING);
		return FALSE;
	}

	$data = is_array($data = require $dataFile) ? $data : array();

	DbConnectionHelper::connect($data);

	return DbConnectionHelper::getObject();
}



/**
 * Tries to setup and configure a connection to a MySQL Database Server.
 */
final class DbConnectionHelper {

	/** @var resource mysql socket resource */
	private static $connection;


	/** @var self */
	private static $object;


	/**
	 * Singleton-like class - may be instantiated only from within itself
	 */
	private function __construct() {
	}


	/**
	 * Singleton-like class - cloning prohibited
	 */
	private function __clone() {
	}


	/**
	 * Destructor
	 */
	public function __destruct() {
		$this->disconnect();
	}


	/**
	 * @return self
	 */
	public static function getObject() {
		if(!self::$object instanceof self) {
			throw new \RuntimeException('You do not have a connection object set up, call ' . __CLASS__ . '::connect() first');
		}

		return self::$object;
	}


	/**
	 * Opens a mysql connection.
	 *
	 * @param array
	 * @throws \RuntimeException
	 */
	public static function connect($params) {
		if(self::$object && FALSE !== self::$object->getConnection()) {
			throw new \RuntimeException('You are already connected to a database, call ' . __CLASS__ . '::disconnect() first');
		}

		// param check
		if($missing = array_diff(['host', 'name', 'password', 'user'], array_keys($params))) {
			throw new \RuntimeException('Missing ' . implode(', ', $missing) . ' keys from the argument array');
		}

		// setup
		$link = mysql_connect($params['host'], $params['user'], $params['password']);
		if(is_resource($link)) {
			$success = TRUE;

			$success *= mysql_set_charset('utf8', $link); // encoding setting for mysql_real_escape_string()
			$success *= (bool) mysql_query('SET NAMES utf8', $link); // encoding setting for the server

			$success *= mysql_select_db($params['name'], $link);

			self::$connection = $link;

			if(!$success) {
				self::disconnect(); // properly assign self::$connection
			}
		}

		self::$object = new self;
	}


	/**
	 * Closes the mysql connection.
	 * @internal resets self::$connection
	 */
	public static function disconnect() {
		if(is_resource(self::$connection)) {
			mysql_close(self::$connection);
		}

		self::$connection = NULL;
	}


	/**
	 * Returns mysql connection resource if open, FALSE otherwise.
	 *
	 * @return resource|boolean
	 */
	public function getConnection() {
		return is_resource(self::$connection) && mysql_ping(self::$connection)
			? self::$connection
			: FALSE;
	}
}
