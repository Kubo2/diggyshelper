--TEST--
BB decoder: html escape test
--FILE--
<?php

require __DIR__ . '/../../web/lib/bbcode.php';

$encoded = <<<BB
Prvý <p>odstavec</p>, [b]tučný text[/b]

[i]Druhý ods[/i]tavec, <i>kurz[i]íva</i>[/i]

Tretí odstav[u]ec, pod[/u]čiarknuté
Nový riadok[del], nový odstavec[/del]

Nový odstavec a <b>koniec textu</b>, hm?

BB;

echo(dh_bb_decode($encoded));

?>
--EXPECT--
<p>
Prvý &lt;p&gt;odstavec&lt;/p&gt;, <b>tučný text</b>
</p><p>
<i>Druhý ods</i>tavec, &lt;i&gt;kurz<i>íva&lt;/i&gt;</i>
</p><p>
Tretí odstav<u>ec, pod</u>čiarknuté<br>
Nový riadok<del>, nový odstavec</del>
</p><p>
Nový odstavec a &lt;b&gt;koniec textu&lt;/b&gt;, hm?
</p>
