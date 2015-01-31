--TEST--
Bulletin Board decoder: basic test
--FILE--
<?php

require __DIR__ . '/../web/lib/bbcode.php';

$encoded = <<<BB
Prvý odstavec, [b]tučný text[/b]

[i]Druhý ods[/i]tavec, [i]kurzíva[/i]





Tretí odstav[u]ec, pod[/u]čiarknuté
Nový riadok[del], nový odstavec[/del]

Nový odstavec a koniec textu, hm?

BB;

echo(dh_bb_decode($encoded));

?>
--EXPECT--
<p>
Prvý odstavec, <b>tučný text</b>
</p><p>
<i>Druhý ods</i>tavec, <i>kurzíva</i>
</p><p>
Tretí odstav<u>ec, pod</u>čiarknuté<br>
Nový riadok<del>, nový odstavec</del>
</p><p>
Nový odstavec a koniec textu, hm?
</p>
