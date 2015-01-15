--TEST--
Bulletin Board decoder: basic test
--FILE--
<?php

require __DIR__ . '/../web/lib/bbcode.php';

$encoded = <<<BB
Prv? odstavec, [b]tu?n? text[/b]

[i]Druh? ods[/i]tavec, [i]kurz?va[/i]





Tret? odstav[u]ec, pod[/u]?iarknut?
Nov? riadok[del], nov? odstavec[/del]

Nov? odstavec a koniec textu

BB;

echo(dh_bb_decode($encoded));

?>
--EXPECT--
<p>
Prv? odstavec, <b>tu?n? text</b>
</p><p>
<i>Druh? ods</i>tavec, <i>kurz?va</i>
</p><p>
Tret? odstav<u>ec, pod</u>?iarknut?<br>
Nov? riadok<del>, nov? odstavec</del>
</p><p>
Nov? odstavec a koniec textu
</p>
