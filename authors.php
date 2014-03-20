<?php


session_start();


@header("Content-Type: text/html; charset=utf-8", true, 200);



?>

<!DOCTYPE HTML>
<html>
    <head>
        <?php include 'includes/head.php'; ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.1,user-scalable=no">
        <meta 
            name="description" 
            content="Mohlo by Vás zaujímať, kto stojí za vznikom diskusného fóra Diggy's Helper. Prečítajte si to na tejto stránke."
        >
        <style>
    a[href^='#']:not([href$='#']) {
        font-style: italic;
    }
    div:target, body:target,
    div:not(:target), body:not(:target) {
        transition: none;
    }
    [id]:target {
        outline: 1.8px solid #ff9e49;
        border-top-color: transparent;
        background: #ffcfa4;
        transition: all 1.2s;
    }
    [id]:not(:target) {
        transition: all .7s;
    }
    h1, h2, h3 {
        margin: 0;
        padding: .4em 0 .4em .7em;
        outline: 1.8px solid transparent;
    }
    h2, h3 {
        border-top: 2px dashed silver; 
    }
    p {
        margin: .1em 0 1.2em;
    }
    /* miesta, ktoré treba ešte zmeniť/doplniť obsah */
    .doplniť {
        color: grey;
        font-weight: bold;
        max-width: 55%;
    }
    .doplniť::before {
        display: block;
        border: 3px solid red;
        content: "Nasledujúci element treba ešte zmeniť/doplniť:";
        color: red;
        text-align: center;
        padding: 3.2px;
        margin-bottom: 8px;
    }
    .doplniť::after {
        display: block;
        content: "Po doplnení prosím odoberte triedu .doplniť z elementu.";
        font-size: small;
        color: blue;
        font-weight: normal;
        margin-top: 8px;
    }
        </style>
    </head>
    <body>
	<?php
        include 'includes/header.php';
        include 'includes/menu.php';
        include 'includes/submenu.php';
    ?>
        <div id="pages">
            <article>
    <h1>Autori diskusného fóra Diggy's Helper</h1>
    <p>Kto stojí za vznikom diskusného fóra <b>Diggy's Helper</b>? Či už na našom fóre pôsobíte dlhšie, alebo ste nováčik a chcete sa dozvedieť viac o jeho vzniku, histórii a autoroch, ste tu správne. Čítajte prosím ďalej.</p>
    <p>
        <a class="memberusers" href="#historia">História vzniku</a> &bull;
        <a class="memberusers" href="#autori">Autori fóra</a> :
        <a class="memberusers" href="#WladinQ">Vladimír Jacko</a> - 
        <a class="memberusers" href="#Kubo2">Jakub Kubíček</a>
    </p>
    
    <h2 id="historia">História vzniku</h2>
    <p>Ak ste našli cestu k našemu Česko-Slovenskému fóru predpokladám že ste oboznámený s online hrou Diggy's Adventure.
	Táto online hra doposial nemala žiadne Česko-Slovenské fórum tak sme sa rozhodli jedno fórum pre vás naprogramovať.
	Nápad na naprogramovanie toho fóra napadlo administrátora stránky Vladimíra Jacka dňa 8.12.2013. Kedže prácu na fóre nemôže spravovať
	jeden človek požiadal o pomoc daľsích dvoch programarátorov. Fórum sa každým dňom vylepšuje. Na týchto stránkach možete nájsť
	napríklad informácie o spoločnosti ktorá hru Diggy's Adventure naprogramovala, ďalej je možné tu nájsť informácie o resetovatelých
	baňiach v sekcii <a class="memberusers" href="http://diggyshelper.php5.sk/attractions.php">Zaujímavosti</a>, alebo je k dispozícii poradňa v sekcii <a class="memberusers" href="http://diggyshelper.php5.sk/forum.php">Fórum</a>.
	Po registrácii je možné pridať si svojich priateľou ktorý sú taktiež u nás zaregistrovaný, alebo si vylepšiť svoj profil napríklad pridaním svojej fotografie.
	Za celý tím Diggy's Helper dúfam že nájdete na našich stránkach čo hľadáte.</p>
    
    <h2 id="autori">Autori fóra</h2>
    <dl>
        <dt id="WladinQ"><a class="memberusers" href="https://www.facebook.com/WladinQ" target="_blank">Vladimír Jacko</a></dt>
        <dd>
			<p>Vášnivý programátor v najlepších rokoch a zakladateľ projektu
			Diggy's Helper. Pri programovaní najradšej počúva skupinu KABÁT.
			Rád si pozrie dobrý film, miluje prírodu a dobre vychladené pivo.
			Každý deň premýšla ako najlepšie spríjemniť Váš pobyt na našich stránkach.<p>
			Zaoberá sa prevažne dizajnom projektu. </p>
		</dd>
        <dt id="Kubo2"><a class="memberusers" href="http://kubo2.wz.sk/" target="_blank">Jakub Kubíček</a></dt>
        <dd>
            <p>Mladý programátor zameraný na <b>webové 
            technológie</b>. Zbožňuje exotické ovocie zvané 
            <b>pomelo</b>, rád jazdí na <b>bicykli</b>, v zime 
            <b>lyžuje</b> a medzi jeho záľuby patrí najmä 
            <b>programovanie</b> a tvorba webových stránok.<br>
            Na webe je ho možné nájsť pod prezývkou 
            <strong>Kubo2</strong>.
            <p>Na projekte Diggy's Helper má zásluhy hlavne ako
            <b>manažér</b> projektu, <b>programátor</b> serverovej 
            aplikácie v&nbsp;skriptovacom jazyku PHP a klientského 
            aplikačného rozhrania v jazyku JavaScript.
        </dd>
    </dl>
</article>
	</div>
	<?php include 'includes/footer.php'; ?>
</body>
</html>