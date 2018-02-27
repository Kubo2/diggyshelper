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

		$pattern[ ] = '~\[(img)](https?://.+?(?<!\[/img]))\[/img]~i';
	}


	// preprocessing
	$snippet = trim($snippet);
	$snippet = str_replace(["\r\n", "\r"], "\n", $snippet);
	$snippet = htmlspecialchars($snippet, ENT_QUOTES, 'utf-8');
	$snippet  = preg_replace("~\n{2,}~", "\n</p><p>\n", $snippet);

	// replacement
	$snippet = preg_replace_callback($pattern, function( $token ) {
		$tagName = strtolower($token[1]);
		if($tagName === 'img') {
			return "<a href='$token[2]' target='_blank' rel='noopener'>"
				. "<img src='$token[2]'></a>";
		} else {
			return !empty($token[2]) // tag contents ought not be empty
				? sprintf('<%1$s>%2$s</%1$s>', strtolower($tagName), $token[2])
				: $token[0];
		}
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
