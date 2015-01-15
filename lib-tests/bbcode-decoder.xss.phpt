--TEST--
an XSS test for lib/bbcode.php
--FILE--
<?php

require __DIR__ . '/../web/lib/bbcode.php';

echo(dh_bb_decode('[b]text <marquee>suck</marquee>[/b]'.PHP_EOL));

echo(dh_bb_decode(htmlspecialchars('[b]text <marquee>suck</marquee>[/b]')));

?>
--EXPECT--
<b>text <marquee>suck</marquee></b>
<b>text &lt;marquee&gt;suck&lt;/marquee&gt;</b>