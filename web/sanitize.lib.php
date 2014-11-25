<?php

/**
 * Data sanitization library.
 *
 * @author   Kubo2 <kelerest123@gmail.com>
 * @version 1.0.0
 * @package sanitize-lib
 *
 */
namespace SanitizeLib;

/** @var string */
define('VERSION', '1.0.0');

/** @var string */
define('LIBRARY', 'Sanitize Lib');

/** @var string */
define('IDENTIFIER', 'sanitize-lib');

/**
 * Data contexts constants enumeration for Sanitize Lib.
 */
const HTML = 1;
const SQL = 2;
const JAVASCRIPT = 3;
const JS = JAVASCRIPT;
//const CSS = 4;
const URL = 5;

/**
 * Make sure PHP has been loaded with proper extensions.
 *
 * @return void
 * @throws SanitizeLib\MissingRequirements
 */
{
	$missing = array('filter', 'json');
	foreach($missing as $ext) extension_loaded($ext) && array_shift($missing);
	if(count($missing)) throw new MissingRequirements($missing);
}

// ====== functions ======
/**
 * Sanitize given $data for usage in $context. If given context is unknown, returns $data without changes
 *
 * @param string
 * @param mixed(int|array(int))
 * @return string sanitized data
 * @throws \InvalidArgumentException if given $data is not a string or object that may be converted to string
 */
function sanitize($data, $context) {
	if(!is_string($data) && !method_exists($data, '__toString')) throw new \InvalidArgumentException;
	$data = (string) $data; // if it is object
	if(!is_array($context)) $context = array($context);
	
	foreach($context as $esc) {
		switch($esc) {
			case HTML: {
				$data = htmlspecialchars($data, ENT_QUOTES);
			} break;
			case SQL: { // MUST be already connected to the database using PHP's mysql extension - this is slightly customized for dh-forum, sorry
				$data = mysql_real_escape_string($data);
			} break;
			case JAVASCRIPT: { // MUST be json extension in disposition
				$data = json_encode($data);
			} break;
			case URL: {
				$data = rawurlencode($data);
			} break;

			default: { // nothing to do here
				$data;
			}
		}
	}

	return $data;
}

/**
 * An intelligent alias of unnecessary smooth-talking function {@link SanitizeLib\sanitize()}.
 * Instead of traditional Sanitize Lib sanitize context level constant, here you can pass only
 * string indentifier of sanitize context level (case-insensitive); like {@code "HTML"}.
 *
 * @param string
 * @param string
 * @return string
 * @throws \InvalidArgumentException
 */
function escape($data, $level) {
	$constant = __NAMESPACE__ . '\\' . strtoUPPER($level);
	if(!defined($constant)) {
		// why even bother?
		return $data;
	}
	return sanitize($data, constant($constant));
}

// ====== exception classes ======
/**
 * Base class type of all Sanitize Lib exceptions. Can not be used itself.
 *
 * @abstract
 */
abstract class Exception extends \Exception { }

/**
 * Exception that is thrown when some of Sanitize Lib requirements can not be touched.
 */
final class MissingRequirements extends Exception {
	/** @var array */
	private $requirements;

	/**
	 * Constructs an instance of MissingRequirements exception class.
	 *
	 * @param array   List of requirements missing
	 */
	public function __construct(array $requirements) {
		$this->requirements = $requirements;
		$requirements = count($requirements) ? join(', ', $this->requirements) : "some";
		$message = sprintf("Extensions and/or libraries %s required by %s version %s are missing.", $requirements, LIBRARY, VERSION);
		parent::__construct($message, 9);
	}

	/**
	 * Returns array containing missing requirements in case of which this exception was thrown.
	 *
	 * @return array
	 */
	public function getRequirements() {
		return $this->requirements;
	}
}
