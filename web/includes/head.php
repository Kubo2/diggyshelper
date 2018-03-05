<?php

/**
 * Absolute web-path to current page's directory.
 * @var string
 */
$absUrl = rtrim(strtr(dirname($_SERVER['PHP_SELF']), '\\', '/'), '/');

/**
 * @var string
 * @deprecated v1.5.3 in favor a more-contained touple
 */
$curUrl = $_SERVER['REQUEST_URI'];

/** @var array(hostname, request URI) */
$requestLoc = array(1 => $curUrl, 0 => isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']);


// data sanitization library
require_once __DIR__ . '/../sanitize.lib.php';

?>
<meta charset='UTF-8'>
<meta name='theme-color' content='#151515'>
<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=no'>
<?php /* Universal title. Only temporarily. */ ?>
<title><?=
			! empty( $titleConst )
			? htmlspecialchars(html_entity_decode($titleConst, ENT_HTML5, 'UTF-8'), ENT_NOQUOTES | ENT_HTML5)
			: "Diggy's Helper &ndash; Česko-slovenské Diggy's Adventure fórum"
?></title>

<script>

function ga() {ga.q.push(arguments)}
ga.q = []; ga.l = +new Date();
ga('create', 'UA-37444056-2', 'auto');

window['GoogleAnalyticsObject'] = 'ga';

// ga(function(tracker) {
	// additional tweaks to the tracker
// });

ga('send', 'pageview');
  
</script>

<link href='<?= "https://$requestLoc[0]$requestLoc[1]" ?>' rel='canonical'>
<link href='<?= $absUrl ?>/css/style.css' rel='stylesheet'>
<link href='<?= $absUrl ?>/favicon.png'   rel='icon' type='image/png'>
