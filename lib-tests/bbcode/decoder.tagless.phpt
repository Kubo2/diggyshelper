--TEST--
BB decoder: test with a tagless input
--FILE--
<?php

require __DIR__ . '/../../web/lib/bbcode.php';

echo(dh_bb_decode("Tento text neobsahuje žiadne BBCode tagy\na ani jeho druhý riadok"));

?>
--EXPECT--
<p>
Tento text neobsahuje žiadne BBCode tagy<br>
a ani jeho druhý riadok
</p>
