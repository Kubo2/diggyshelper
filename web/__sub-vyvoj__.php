<?php

/**
 * This file is an attempt of proxy simulation for vyvoj.diggyshelper.net
 * subdomain. Primarily this makes sense for WladinQ.
 *
 * @author   Kubo2
 * @version  1.0.0
 * @internal  This is wrote for PHP >= 5.4 interpreter and may not work with lower versions.
 *
 */


/**
 * Preparation
 */
{
	if(!is_array($_GET) || !count($_GET)) {
		header("Kubo2: Fucking this bullshit already xyz", true, 400);
		exit;
	}

	if(!isset($_GET['uri']) || !is_scalar($_GET['uri'])) {
		header("Kubo2: URI not provided, sorry & go to the hell", true, 400);
		exit;
	}

	sleep(1);
	//set_time_limit(9); # see wedos's PHP configuration -> disable_functions
	ini_set('max_execution_time', 9);
}

/**
 * Configuration
 */
{
	define('URI', ltrim($_GET['uri'], '/'));
	unset($_GET['uri']);

	define('QS', http_build_query($_GET));
	define('SERVER', "diggyshelper.php5.sk");

	define('REQUEST', 'http://' . SERVER . '/' . URI . '?' . QS);
}

/**
 * Action
 */
{
	// 		get_headers(	$url, 			$assoc)
	$meta = get_headers(REQUEST, (int) true);
	$response = file_get_contents(REQUEST, false, stream_context_create(
			array(
				"http" => array(
					"method" => "GET",
					"protocol_version" => '1.1',
					"timeout" => 3.5,
					"ignore_errors" => true,
				)
			)
		)
	);

	/**
	 * Render
	 */
	{
		header($meta[0]);
		header("Content-Type: {$meta['Content-Type']}");
		echo($response);

		if(strpos($meta['Content-Type'], 'text/html') !== false)
			print("\n<!-- rendered by simple proxy script on " . $_SERVER['SERVER_ADDR'] . " -->");
		flush();
	}
}