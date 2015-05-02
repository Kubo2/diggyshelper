<?php

session_start();

if(!isset($_SESSION["uid"]) || !intval(!empty($_GET["cid"]) ? $_GET["cid"] : 0)) {
	header("Location: http://$_SERVER[SERVER_NAME]" . dirname($_SERVER["PHP_SELF"]) . "/index.php", true, 302);
	exit;
}

header("Content-Type: text/html; charset=utf-8", true, 200);

?>
<!doctype html>
<html>
	<head>
		<?php include 'includes/head.php'; ?>
	</head><body>
		<?php
		// < start including other content >
			include 'includes/header.php';
			include 'includes/menu.php';
			include 'includes/submenu.php';
		// < / end including other content >
		?>
		<div id="forum">
			<a class='button' href='javascript:history.back(1)'>Späť</a>
			<a class='button_register' onclick="window.open('upload.php', 'okno1', 'width=500,height=400')">Nahrať obrázok</a>
			<hr/>
			<div id="content">
				<form action="create_topic.php" method="post" name="vytvor-temu">
					<p>Názov témy:</p>
					<input type="text" name="topic_title" size="98" maxlength="150" tabindex=1>
					<p>Obsah témy:</p>
					<textarea name="prispevok" rows="12" cols="75" tabindex=2></textarea>
					<br>
					<!-- WladinQ! Povedz mi krista, načo je dobré dávať tagu <button>
					atribút type="button" (ktorý na tomto elemente minimálne nie je dovolený)
					plus dávať mu triedu .button? ~ Kubo2 -->
					<!-- Trieda .button ponechaná zámerne. Slúži pre tunajšie vkladanie BB tagov. ~Kubo2 -->
					<button class='button' id="b" tabindex=0><b>tučné</b></button>
					<button class='button' id="i" tabindex=0><i>kurzíva</i></button>
					<button class='button' id="u" tabindex=0><u>podčiarknuté</u></button>
					<button class='button' id="del" tabindex=0><s>prečiarknuté</s></button>
					<!--button class='button' >center</button-->
					<!--button class='button_register' type=button onclick="addtag('docastne nefunkcne')">images/nefunkčné</button>
					<br>
					Tag na vloženie obrázku: &lt;img src=&quot;link obrázku&quot; width=&quot;350&quot; height=&quot;250&quot;&gt;-->
					<br>
					<br>
					<input type="hidden" name="cid" value="<?php echo intval($_GET["cid"]) ?>">
					<input type="submit" name="topic_submit" class='input_button' value="Vytvoriť novú tému" tabindex=3>
				</form>
			</div>
		</div>
		<?php include 'includes/footer.php'; ?>
	</body>
</html>