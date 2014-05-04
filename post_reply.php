<?php

session_start();

if( !isset($_SESSION["uid"]) || (!@intval($_GET["cid"]) || !@intval($_GET["tid"])) && !isset($_GET["flash"]) ) { // intentionally @
	header("Location: http://$_SERVER[SERVER_NAME]" . dirname($_SERVER["PHP_SELF"]) . "/index.php", true, 302);
	exit;
}

header("Content-Type: text/html; charset=utf-8", true, 200);

/**
 * Flash messages.
 */
$aMasTo = " Nezaškodí niekoľko minúť počkať. <noscript>Skúste sa vrátiť v histórii a opäť odoslať príspevok.</noscript><script>document.write(\"<a href='javascript:void(history.go(-1))'>Vráťte sa</a> (bez ujmy na príspevku) a skúste ho znova odoslať.\")</script>";
$messages = [
	"!db" => "Nebolo možné nadviazať komunikáciu s našou databázou.",
	"!id" => "Nastala chyba. Neodoslali ste údaj o téme, do ktorej chcete prispievať či o kategórii, v ktorej je táto téma.",
	"!post" => "Príspevok je prádzny. Skúste ho vyplniť a potom znova odoslať.",
	"!ins" => "Príspevok sa nepodarilo vložiť.",
];

if(!empty($_GET["flash"])) {
	if(isset($messages[$_GET["flash"]])) {
		$flashMessage = $messages[$_GET["flash"]];
		if(in_array($_GET["flash"], [ "!db", "!ins" ]))
			$flashMessage .= $aMasTo;
	}
}

// pre odkomentovanie doctypu jednoducho odstráň sekvenciu -- zo začiatku aj z konca
?>
<!--DOCTYPE HTML-->
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
<div id="content">
	<a class='button' href='./view_topic.php?<?php echo "tid=$_GET[tid]&cid=$_GET[cid]"; ?>'>Návrat do témy</a>
	<script>document.write('<a class="button_register" onclick="window.open(&quot;upload.php&quot;, &quot;okno1&quot;, &quot;width=500,height=400&quot;)">Nahrať obrázok</a>')</script>
	<hr />

	<?php if(!empty($flashMessage)) { ?>
	<p class="warning"><?php echo $flashMessage ?></p>
	<?php } else { ?>
	<form action="post_reply_parse.php" method="post" name="zasli-prispevok">
		<p>Pridať odpoveď:</p>
		<textarea name="prispevok" rows="5" cols="75"></textarea><br>
			<button class='button' id="b" tabindex=0><b>tučné</b></button>
			<button class='button' id="i" tabindex=0><i>kurzíva</i></button>
			<button class='button' id="u" tabindex=0><u>podčiarknuté</u></button>
			<button class='button' id="del" tabindex=0><s>prečiarknuté</s></button>
			<br /><br />
		<input type="hidden" name="cid" value="<?php echo $_GET['cid']; ?>" />
		<input type="hidden" name="tid" value="<?php echo $_GET['tid']; ?>" />
		<input type="submit" name="reply_submit" class="input_button" value="Pridať odpoveď">
	</form>
	<?php } ?>
</div>
</div>
</center>
	<?php include 'includes/footer.php'; ?>
</body>
</html>