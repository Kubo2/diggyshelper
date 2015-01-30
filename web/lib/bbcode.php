<?php

/**
 * DH BB code decoder.
 *
 * @author   Kubo2
 * @version  0.0.0
 *
 * @package DH
 * @subpackage markup
 *
 * @internal This library requires ext 'pcre' to be loaded.
 */
if(!extension_loaded('pcre')) {
	throw new RuntimeException('dh / BB Code library requires PHP \'pcre\' extension to be loaded.', PHP_INT_MAX - 1);
}

//mb_internal_encoding('UTF-8');

function dh_bb_decode( $snippet ) // : string
{
	static $bb = array('b', 'i', 'del', 'u'); // paired bb codes
	static $pattern = array(); // regex patterns

	if(!count($pattern)) {
		foreach($bb as $tag) {
			$tag = preg_quote($tag, '~');
			$pattern[ ] = <<<PATTERN
~(?six:
	\[($tag)]
	(
		.+?
		(?<!
			\[/$tag]
		)
	)
	\[/$tag]
)~
PATTERN;
		}

		if(false) { // intentionally
			// bold
			$bb[ ] 			= '#\\[b\\](.+)\\[/b\\]#i';
			$replace[ ] 	= '<b>\\1</b>';

			// italics
			$bb[ ] 			= '#\\[i\\](.+)\\[/i\\]#i';
			$replace[ ] 	= '<i>\\1</i>';

			// deleted text
			$bb[ ] 			= '#\\[del\\](.+)\\[/del\\]#i';
			$replace[ ] 	= '<del>\\1</del>';

			// "underlined" (i think it would be inserted) text
			$bb[ ] 			= '#\\[u\\](.+)\\[/u\\]#i';
			$replace[ ] 	= '<u>\\1</u>';
		}
	}

	// preprocessing
	$snippet = trim($snippet);
	$snippet = str_replace(["\r\n", "\r"], "\n", $snippet);
	$snippet = htmlspecialchars($snippet, ENT_QUOTES, 'utf-8');
	$snippet  = preg_replace("~\n{2,}~", "\n</p><p>\n", $snippet);

	// replacement
	$snippet = preg_replace_callback($pattern, function( $token ) {
		return
			!empty($token[2])
				? sprintf('<%1$s>%2$s</%1$s>', strtolower($token[1]), $token[2])
				: $token[0];
	}, $snippet);

	// close it to paragraph
	// (bb "document" root)
	$snippet = "<p>\n" . $snippet . "\n</p>";

	// strip newlines
	// for($pos = 0; $pos + 1 <= strlen($snippet); ) {
	// 	$next = strpos($snippet, "\n", $pos) + $pos; // next newline
	// 	echo("Next newline: $next\n");
	// 	$pos = $next + 1;

	// 	if(substr($snippet, $next - 3, $next) === '<p>' OR substr($snippet, $next, 4) === '</p>')
	// 		continue;

	// 	$snippet = substr($snippet, 0, $next) . "<br>\n" . substr($snippet, $next);
	// }
	$snippet = preg_replace("~(?<!<p>)\n(?!</p>)~s", "<br>\n", $snippet);

	return $snippet;
}
