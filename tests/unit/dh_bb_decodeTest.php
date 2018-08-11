<?php


class dh_bb_decodeTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;


	// tests
	public function testBasicParse() {
		$bbMarkup = <<< TEXT
Prvý odstavec, [b]tučný text[/b]

[i]Druhý ods[/i]tavec, [i]kurzíva[/i]





Tretí odstav[u]ec, pod[/u]čiarknuté
Nový riadok[del], nový odstavec[/del]

Nasleduje obrázok: [img]https://url-obrazku[/img] ale už [img]nie[/img]
A tento by sa [img]nemal chytiť[/img]

Nový odstavec a koniec textu, hm?

TEXT;

		$expectParsedHtml = <<< HTML
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
HTML;


		$this->assertSame($expectParsedHtml, dh_bb_decode($bbMarkup));
	}


	public function testTaglessParse() {
		$expectParsedHtml = <<< HTML
<p>
Tento text neobsahuje žiadne BBCode tagy<br>
a ani jeho druhý riadok
</p>
HTML;


		$this->assertSame($expectParsedHtml, dh_bb_decode("Tento text neobsahuje žiadne BBCode tagy\na ani jeho druhý riadok"));
		//$this->assertSame('', dh_bb_decode(''));
	}


	public function testEscapeHtml() {
		$bbMarkup = <<< TEXT
Prvý <p>odstavec</p>, [b]tučný text[/b]

[i]Druhý ods[/i]tavec, <i>kurz[i]íva</i>[/i]

Tretí odstav[u]ec, pod[/u]čiarknuté
Nový riadok[del], nový odstavec[/del]

Nový odstavec a <b>koniec textu</b>, hm?

TEXT;

		$expectParsedHtml = <<< HTML
<p>
Prvý &lt;p&gt;odstavec&lt;/p&gt;, <strong>tučný text</strong>
</p><p>
<em>Druhý ods</em>tavec, &lt;i&gt;kurz<em>íva&lt;/i&gt;</em>
</p><p>
Tretí odstav<u>ec, pod</u>čiarknuté<br>
Nový riadok<del>, nový odstavec</del>
</p><p>
Nový odstavec a &lt;b&gt;koniec textu&lt;/b&gt;, hm?
</p>
HTML;


		$this->assertSame($expectParsedHtml, dh_bb_decode($bbMarkup));
	}

}
