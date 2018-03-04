<?php

/**
 * DH BBCode decoder.
 *
 * @author   Kubo2
 * @version  0.1.0
 *
 * @package DH
 * @subpackage markup
 */


function dh_bb_decode( $snippet ) // : string
{
	static $codes = [ // code name => printf format string
		'b' => '<strong>%s</strong>',
		'i' => '<em>%s</em>',
		'del' => '<del>%s</del>',
		'u' => '<u>%s</u>',
	];

	if(!isset($codes['img'])) {
		$codes['img'] = function($arg) {
			return !preg_match('~^https?://~i', $arg)
				? NULL // leave the original input alone
				: "<a href='$arg' target='_blank' rel='noopener'><img style='display: block' src='$arg'></a>";
		};
	}


	// snippet preprocessing
	$snippet = trim($snippet);
	$snippet = str_replace(["\r\n", "\r"], "\n", $snippet);
	$snippet = htmlspecialchars($snippet, ENT_QUOTES, 'utf-8');
	$snippet  = preg_replace("~\n{2,}~", "\n</p><p>\n", $snippet);

	// bbcode processing
	$openings = $pairs = array();
	foreach($codes as $code => $format) {
		$offset = 0;
		while(FALSE !== $c = strpos($snippet, "[$code]", $offset)) {
			$openings[] = ['code' => $code, 'pos' => $c, 'skip' => strlen($code) + 2];
			$offset = $c + end($openings)['skip'];
		}
	}

	foreach($openings as $op) {
		$end = strpos($snippet, "[/{$op['code']}]", $op['pos']);
		if(FALSE === $end) {
			continue;
		} else {
			$arg = substr($snippet, $op['pos'] + $op['skip'], $end - $op['pos'] - $op['skip']);
			if(!$arg) {
				continue;
			}
		}

		$replace = is_callable($formatCode = $codes[$op['code']]) ? $formatCode($arg) : sprintf($formatCode, $arg);
		if($replace !== NULL) {
			$pairs["[{$op['code']}]{$arg}[/{$op['code']}]"] = $replace;
		}
	}

	// replacement
	$snippet = str_replace(array_keys($pairs), array_values($pairs), $snippet);

	// enclose it in a paragraph
	// (bb "document" root)
	$snippet = "<p>\n" . $snippet . "\n</p>";

	// strip newlines
	$snippet = preg_replace("~(?<!<p>)\n(?!</p>)~s", "<br>\n", $snippet);

	return $snippet;
}
