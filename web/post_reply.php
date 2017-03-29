<?php

/**
 * @internal requires PHP >= 5.4
 */

session_start();

require __DIR__ . '/connect.php';
require __DIR__ . '/functions.php';

$uri = getUriParam('intval', 'cid', 'tid'); // escaped by intval()

if( !isset($_SESSION["uid"]) || !($uri['cid'] && $uri['tid']) && !isset($_GET["flash"]) ) {
	header("Location: http://$_SERVER[SERVER_NAME]" . dirname($_SERVER["PHP_SELF"]) . "/index.php", true, 302);
	exit();
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
<div id="content">
	<a class='button_reg' href='./view_topic.php?<?= "tid=$uri[tid]&cid=$uri[cid]" ?>'>Návrat do témy</a>
	<!--script>document.write('<a class="button_upload" onclick="window.open(&quot;upload.php&quot;, &quot;okno1&quot;, &quot;width=500,height=400&quot;)">Nahrať obrázok</a>')</script-->
	<hr>

	<?php if(!empty($flashMessage)) { ?>
	<p class="warning"><?php echo $flashMessage ?></p>
	<?php } else { ?>
	<form action="post_reply_parse.php" method="post" name="zasli-prispevok">
		<?php if(getUser($_SESSION['uid'], 'access') == 'admin') { ?>
		<p><label for='post-markup'>Pridať otázku / odpoveď vo formáte:</label> 
			<select name="post-markup" id='post-markup'>
				<option value="bb" selected="selected">BB kód</option>
				<option value="html">HTML</option>
			</select>
		</p>
		<?php } else { ?>
		<p>Pridať odpoveď:</p>
		<?php } ?>
		<textarea name="prispevok" rows="12" cols="75"></textarea><br>
			<button class='button' id="b" tabindex=0><b>tučné</b></button>
			<button class='button' id="i" tabindex=0><i>kurzíva</i></button>
			<button class='button' id="u" tabindex=0><u>podčiarknuté</u></button>
			<button class='button' id="del" tabindex=0><s>prečiarknuté</s></button>
			<br><br>
		<input type="hidden" name="tid" value="<?= $uri['tid'] ?>">
		<input type="hidden" name="cid" value="<?= $uri['cid'] ?>">
		<input type="submit" name="reply_submit" class="input_button" value="+ Pridať otázku / odpoveď">
	</form>
	<?php } ?>
</div>
</div>
</center>
	<?php include 'includes/footer.php'; ?>
</body>
</html>
