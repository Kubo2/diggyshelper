<?php

/**
 * absolute url off current document
 * (depends on requested resource's url)
 * @var string
 */
$absUrl = rtrim(dirname($_SERVER['PHP_SELF']), '/');

// data sanitization library
require_once __DIR__ . '/../sanitize.lib.php';

?>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=no'>
<?php /* Universal title. Only temporarily. */ ?>
<title><?=
			! empty( $titleConst )
			? SanitizeLib\sanitize($titleConst, SanitizeLib\HTML)
			: "Diggy's Helper &ndash; Prvé česko-slovenské fórum o hre Diggy's Adventure"
?></title>

<link href='<?= $absUrl ?>/css/style.css' rel='stylesheet'>
<link href='<?= $absUrl ?>/favicon.png'   rel='icon' type='image/png'>

