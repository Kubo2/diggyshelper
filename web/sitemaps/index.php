<?php

/**
 * Automatic sitemap index generator.
 *
 * @author   Jakub Kubíček
 * @version  1.0.0
 * @package dh
 */

define('USECACHE', is_file('./index_usecache'));
define('UCFILE', './index_usecache');
define('CACHEFILE', './index.cache');

require_once('./../lib-core.php');
require_once('./sample.php');

if(substr_compare($_SERVER["REQUEST_URI"], '/index.php', -10) === 0) {
	$uri = sprintf(
		"http://%s/%s",
			$_SERVER["SERVER_NAME"],
			ltrim(dirname($_SERVER["REQUEST_URI"]), '/')
	);

	header("Location: $uri", true, 301);
	exit;
}

ob_start(function($buffer) {
	chdir(dirname($_SERVER['SCRIPT_FILENAME'])); {
		if(!USECACHE || !is_file(CACHEFILE)) {
			file_put_contents(CACHEFILE, $buffer);
			touch(UCFILE);
		}
	} return false;
});

if(is_file(CACHEFILE) && USECACHE) {
	readfile(CACHEFILE);
	goto FLUSH;
}

/**
 * XML Sitemap index Generator core
 *
 * @version 1.0
 */
{
	/**
	 * Prepares pretty pseudo-file for parseSample()
	 */
	$tmp = tempnam(sys_get_temp_dir(), "dh~"); {
		$fp = fopen($tmp, 'w');
		fwrite(
			$fp,
			<<<sample
<sitemap>
	<loc>{%location%}</loc>
	<lastmod>{%modified%}</lastmod>
</sitemap>
sample
		);		
	} fclose($fp);
	
	$sitemapList = new DirectoryIterator("glob://". dirname(__FILE__) ."/*.xml.php");
	$skeleton = null;

	foreach($sitemapList as $sitemap) {
		if($sitemap->isFile()) {
			$skeleton .= samples\parseSample($tmp, [
				"location" => sprintf(
					"http://%s/%s/%s",
						$_SERVER["SERVER_NAME"],
						trim($_SERVER["REQUEST_URI"], '/'),
						$sitemap->getFilename()
				),
				"modified" => date("Y-m-d", $sitemap->getATime())
			]);
		}
	}

	$xml = samples\parseSample('./samples/sitemap-index.sample', array("SOMETHING" => $skeleton));

	echo $xml;
}

FLUSH: {
	header("Content-Type: application/xml; charset=utf-8", true, USECACHE && (
		strtotime(
			whether(
				$_SERVER["HTTP_IF_MODIFIED_SINCE"],
				"+ 1 day" /// <summary>strtotime()'s argument</summary>
			)
		) < iftrue(@ filemtime(CACHEFILE), time())
	) ? 304 : 200);
	header("Cache-Control: max-age=9, must-revalidate");
	header(
		sprintf(
			"Last-Modified: %s",
			gmdate(
				"D, j M Y H:i:s",
				iftrue(
					@ filemtime(CACHEFILE),
					time()
				)
			)
		)
	);

	ob_end_flush() && flush();
}
