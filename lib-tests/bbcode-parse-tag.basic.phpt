--TEST--
dh_bbcode_parse_tag(): basic test
--FILE--
<?php

// just a single node
//echo(dh_bbcode_parse_tag('[!]'));
echo(dh_bbcode_parse_tag('[b]bold text internal[/b]') . PHP_EOL);

// nested nodes
echo(dh_bbcode_parse_tag('[b]bold text [i]bold text with italics[/i][/b]') . PHP_EOL);

// empty node ()
echo(dh_bbcode_parse_tag('[b][/b]') . PHP_EOL);
echo(dh_bbcode_parse_tag('[b]   [/b]') . PHP_EOL);

?>
--EXCEPT--
<b>bold text internal</b>
<b>bold text <i>bold text with italics</i></b>
[b][/b]
[b][/b]

