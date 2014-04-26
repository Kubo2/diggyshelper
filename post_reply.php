<?php

session_start();

if(!isset($_SESSION["uid"]) || !intval(!empty($_GET["cid"]) ? $_GET["cid"] : 0)) {
	header("Location: http://$_SERVER[SERVER_NAME]" . dirname($_SERVER["PHP_SELF"]) . "/index.php", true, 302);
	exit;
}

header("Content-Type: text/html; charset=utf-8", true, 200);

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

	<a class='button' href='javascript:history.back(1)'>Späť</a> <a class='button_register' onclick="window.open('upload.php', 'okno1', 'width=500,height=400')">Nahrať obrázok</a><hr />

	<form action="post_reply_parse.php" method="post" name="zasli-prispevok">
		<p>Pridať odpoveď:</p>
		<textarea name="prispevok" rows="5" cols="75"></textarea><br>
					<button class='button' id="b" tabindex=0><b>tučné</b></button>
					<button class='button' id="i" tabindex=0><i>kurzíva</i></button>
					<button class='button' id="u" tabindex=0><u>podčiarknuté</u></button>
					<button class='button' id="del" tabindex=0><s>prečiarknuté</s></button>
		<br /><br />
		<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
		<input type="hidden" name="tid" value="<?php echo $tid; ?>" />
		<input type="submit" name="reply_submit" class="input_button" value="Pridať odpoveď">
	</form>
</div>
</div>
</center>
	<?php include 'includes/footer.php'; ?>
</body>
</html>