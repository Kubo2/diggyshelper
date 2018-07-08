<?php

/**
 * Data sanitization library.
 *
 * @author   Kubo2 <kelerest123@gmail.com>
 * @version 1.0.0
 * @package sanitize-lib
 * @deprecated v1.5.3 in favor of a brand-new DH templating engine
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
 */
function sanitize($data, $context) {
	if(!is_string($data)) {
		// why even bother?
		return NULL;
	}

	if(!is_array($context)) {
		$context = array($context);
	}

	$data = (string) $data;
	
	foreach($context as $esc) {
		switch($esc) {
			case HTML: {
				$data = htmlspecialchars($data, ENT_QUOTES);
			} break;
			case SQL: {
				throw new \UnexpectedValueException('Use of the SanitizeLib::SQL context is deprecated');
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
