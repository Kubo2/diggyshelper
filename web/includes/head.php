<?php

/**
 * Absolute web-path to current page's directory.
 * @var string
 */
$absUrl = rtrim(strtr(dirname($_SERVER['PHP_SELF']), '\\', '/'), '/');

/**
 * @var string
 */
$curUrl = $_SERVER['REQUEST_URI'];

// data sanitization library
require_once __DIR__ . '/../sanitize.lib.php';

?>
<meta charset='UTF-8'>
<meta name='theme-color' content='#106CB5'>
<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=no'>
<?php /* Universal title. Only temporarily. */ ?>
<title><?=
			! empty( $titleConst )
			? htmlspecialchars(html_entity_decode($titleConst, ENT_HTML5, 'UTF-8'), ENT_NOQUOTES | ENT_HTML5)
			: "Diggy's Helper &ndash; Česko-slovenské Diggy's Adventure fórum"
?></title>

<?php // {{{ Google Analytics tracking code ============ ?>
<script>

<?php // shared literals are redistributed already in PHP template
      // so when any change is needed, you just change the constants

const GA_GLOBAL = 'ga';
const GA_PROPERTY = 'UA-37444056-2';

?>
function <?= GA_GLOBAL ?>() { <?= GA_GLOBAL ?>.q.push(arguments) }
<?= GA_GLOBAL ?>.q = [ ];
<?= GA_GLOBAL ?>.l = +new Date();

window['GoogleAnalyticsObject'] = <?= json_encode(GA_GLOBAL) ?>;

</script><script>
// initialize the tracker
  ga('create', <?= json_encode(GA_PROPERTY) ?>, 'auto');

// correct some not-yet-fixed programming errors
  ga(function(tracker) {
  	// set correct title for topics page
  	if(location.pathname.substr(-15) == '/view_topic.php') {
  		tracker.set('title', document.getElementById('content').getElementsByTagName('h1')[0].textContent);
  	}

  	// track clicks to user profiles through topic listing
  	(function() {
  		var tbls = document.getElementsByTagName('table');
  		for(var l = tbls.length, i = 0, topics; i < l; i++) {
  			if(tbls[i].className.match(/newest-topics/)) {
  				topics = tbls[i].getElementsByTagName('tbody')[0];
  				break;
  			}
  		}
  		if(!topics) return;

  		for(var l = topics.rows.length, i = 0; i < l; i++) {
  			// the link in the second cell of each row
  			topics.rows[i].cells[1].getElementsByTagName('a')[0].onclick = function() {
  				ga('send', 'event', 'click', 'frontpage->userprofile', this.textContent.replace(/^\s+|\s+$/g, ''), { transport: 'beacon' })
  			};
  		}
  	})();
  });
  
</script>
<?php // }}} Google Analytics tracking code ============ ?>

<link href='<?= "http://diggyshelper.net{$curUrl}" ?>' rel='canonical'>
<link href='<?= $absUrl ?>/css/style.css' rel='stylesheet'>
<link href='<?= $absUrl ?>/favicon.png'   rel='icon' type='image/png'>
