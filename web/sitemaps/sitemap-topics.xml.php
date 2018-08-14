<?php

/**
 * An automatic XML sitemap generator for topics.
 *
 * @author Kubo2
 */


$dbContext = require __DIR__ . '/../connect.php';

if(!$dbContext) {
	reportUnavailable();
}

$resource = mysql_query(<<< SQL
	select * from topics
	order by topic_reply_date
SQL
, $dbContext);

if(!is_resource($resource) || !mysql_num_rows($resource)) {
	reportUnavailable();
}

$sitemap = new DOMDocument('1.0', 'UTF-8');
$sitemap->appendChild($urlset = $sitemap->createElementNS('http://www.sitemaps.org/schemas/sitemap/0.9', 'urlset'));

$changefreq = $sitemap->createElement('changefreq', 'daily');
while($topic = mysql_fetch_object($resource)) {
	$el = $sitemap->createElement('url'); // URL container

	$el->appendChild($sitemap->createElement('loc'))->appendChild(
		$sitemap->createTextNode(getTopicUrl($topic->id, $topic->category_id))
	);

	$el->appendChild($sitemap->createElement('lastmod',
		(new DateTime($topic->topic_reply_date, new DateTimeZone('Europe/Bratislava')))->format(DateTime::W3C)
	));

	$el->appendChild($changefreq->cloneNode($deep = TRUE));

	$urlset->appendChild($el);
}

reportSitemap($sitemap);


//
// responses
//


/**
 * HTTP 503
 */
function reportUnavailable() {
	header('HTTP/1.1 503 Sitemap Temporarily Unavailable', TRUE, 503);
	header('Content-Type: application/xml');
	header('Retry-After: 900');
	echo <<< XML
<?xml version='1.0' encoding='UTF-8' standalone='yes' ?>
<error>
	<code>503</code>
	<description>Sitemap Temporarily Unavailable</description>
	<reason>Server failed to generate this resource. Please check back in a short time.</reason>
</error>\n
XML;
	exit();
}


/**
 * Responds with an application/xml sitemap
 * @param DOMDocument the XML document to report to the client
 */
function reportSitemap($dom) {
	header('HTTP/1.1 200 Sending Sitemap', TRUE, 200);
	header('Content-Type: application/xml');
	$dom->formatOutput = FALSE;
	echo $dom->saveXML();
	exit();
}


//
// helpers
//


/**
 * Generates a single topic URL relative to current environment.
 *
 * @param int topic ID
 * @param int category ID
 * @return string the URL
 */
function getTopicUrl($tid, $cid) {
	static $pattern = NULL;

	if(!isset($pattern)) {

		// give preference to HTTP_HOST
		if(isset($_SERVER[$var = 'HTTP_HOST']) || isset($_SERVER[$var = 'SERVER_NAME'])) {
			$host = $_SERVER[$var];
		} else {
			$host = php_uname('n');
		}

		$pattern = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http') . "://$host/view_topic.php?cid=%d&tid=%d";
	}

	return sprintf($pattern, $cid, $tid);
}
