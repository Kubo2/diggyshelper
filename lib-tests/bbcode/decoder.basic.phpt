--TEST--
BB decoder: basic test
--FILE--
<?php

require __DIR__ . '/../../web/lib/bbcode.php';

$encoded = <<<BB
Prvý odstavec, [b]tučný text[/b]

[i]Druhý ods[/i]tavec, [i]kurzíva[/i]





Tretí odstav[u]ec, pod[/u]čiarknuté
Nový riadok[del], nový odstavec[/del]

Nasleduje obrázok: [img]https://url-obrazku[/img] ale už [img]nie[/img]
A tento by sa [img]nemal chytiť[/img]

Nový odstavec a koniec textu, hm?

BB;

echo(dh_bb_decode($encoded));

?>
--EXPECT--
<p>
Prvý odstavec, <strong>tučný text</strong>
</p><p>
<em>Druhý ods</em>tavec, <em>kurzíva</em>
</p><p>
Tretí odstav<u>ec, pod</u>čiarknuté<br>
Nový riadok<del>, nový odstavec</del>
</p><p>
Nasleduje obrázok: <a href='https://url-obrazku' target='_blank' rel='noopener'><img style='display: block' src='https://url-obrazku'></a> ale už [img]nie[/img]<br>
A tento by sa [img]nemal chytiť[/img]
</p><p>
Nový odstavec a koniec textu, hm?
</p>
