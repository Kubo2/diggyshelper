<?php

/**
 * Simple *.sample template parser.
 *
 * @author   Jakub Kubíček
 * @version  1.0.0
 * @package samples
 */
namespace samples;
/**
 * Parses a sample file with optional array of variables.
 *
 * The sample file is always parsed as plaintext. It can contain some commands
 * in curly braces, which are „executed“ by sample parser. There are several
 * predefined commands in disposition:
 *
 * - <code>{INCLUDE "filename"}</code> includes other sample from actual dir 
 *   to current. This is recursively parsed by {@link #parseSample()} with all passed
 *   variables also passed to its context.
 * - <code>{%VARNAME%}</code> prints the variables contents if it was assigned
 *   or simply nothing if not.
 *
 *
 * @param string template path to process
 * @param array optional variables passed to parser
 * @return string the result of parser e.g. parsed sample
 */
function parseSample($template, array $vars = array()) {
	checkTemplate($template);
	$sampleDir = dirname($template);
	$result = file_get_contents($template);

	/**
	 * Process {INCLUDE "filename"} directives.
	 */
	{
		$result = preg_replace_callback(
			'~{INCLUDE\s+"([^"]+)"}~',
			function($m) use($sampleDir, $vars) {
				$fullpath = "$sampleDir/$m[1]";
				checkTemplate($fullpath);
				return parseSample($fullpath, $vars);
			},
			$result
		);
	}

	/**
	 * Process {%VARNAME%} directives,
	 */
	{
		$result = preg_replace_callback(
			'~{%([_a-z0-9]+)%}~i',
			function($m) use($vars) {
				return
					empty($vars[ $m[1] ])
					? ""
					: (string) $vars[ $m[1] ]
				;
			},
			$result
		);
	}

	return $result;
}

/**
 * Checks accessbility of passed template due to sample parser's permissions.
 *
 * @param string template filename
 * @throws Exception if the template doesn't exist or is not readable
 */
function checkTemplate($fileName) {
	$fileName = realpath($fileName);
	clearstatcache($fileName);

	if(!is_file($fileName))
		throw new Exception("Template {$fileName} is not a regular file");

	if(!is_readable($fileName))
		throw new Exception("Template {$fileName} not readable");
}

/**
 * Base exception for all {@code sample} functions
 */
class Exception extends \Exception {
	
}
