<?php
//error_reporting(E_ALL|E_STRICT);
/* Session sa musí inicializovať ešte *pred* odoslaním akéhokoľvek výstupu */
// @see http://php.net/session-start
session_start();

// zapnutie output bufferingu (nemám iný spôsob posielania hlavičiek po výstupe) 
// @see http://php.net/ob-start
@ob_start();

// pridaná HTTP hlavička určujúca kódovanie (neviem, čo máš v head.php, ale pre istotu, keďže 
// si mi písal, že ti nejde utf8) -- diakritika by už mala fachať 
@header("Content-Type: text/html; charset=utf-8", true, 200);

// pre odkomentovanie doctypu jednoducho odstráň sekvenciu -- zo začiatku aj z konca
?>
<!--DOCTYPE HTML-->
<html>
<head>
	<?php include 'includes/head.php'; ?>
	
		<script>
		function addtag(g, o)
		{
		   var t = document.getElementsByTagName('textarea')[0];
		   if (typeof t.selectionStart == 'number')
		   {
			  var v = t.value,
				 s = t.selectionStart,
				 e = t.selectionEnd;
			  if (!o)
			  {
				 t.value = v.substring(0, s) + String.fromCharCode(60)+g+'>' + v.substring(s, e) + String.fromCharCode(60)+'/'+g+'>' + v.substring(e);
			  }
			  else if (g == 'img')
			  {
				 t.value = v.substring(0, s) + String.fromCharCode(60)+'img src="' + v.substring(s, e) + '">' + v.substring(e);
			  }
			  else if (g == 'cite')
			  {
				 t.value = v.substring(0, s) + '&bdquo;' + v.substring(s, e) + '&ldquo;' + v.substring(e);
			  }
			  else
			  {
				 return;
			  }
		   }
		   else if (document.selection)
		   {
			  t.focus();
			  s = document.selection.createRange();
			  if (s.parentElement() == t)
			  {
				 if (!o)
				 {
					s.text = String.fromCharCode(60)+g+'>' + s.text + String.fromCharCode(60)+'/'+g+'>';
				 }
				 else if (g == 'img')
				 {
					s.text = String.fromCharCode(60)+'img src="' + s.text + '">';
				 }
				 else if (g == 'cite')
				 {
					s.text = '&bdquo;' + s.text + '&ldquo;';
				 }
				 else
				 {
					return;
				 }
			  }
		   }
		   else
		   {
			  return;
		   }
		}
	</script>
	
</head>
<body>
	<?php include 'includes/header.php'; ?>
	
	<?php include 'includes/menu.php'; ?>
	
	<?php session_start(); ?>
	<?php
		if ((!isset($_SESSION['uid'])) || ($_GET['cid'] == "")) {
			header("Location: index.php");
			exit();
		}
		$cid = $_GET['cid'];
		$tid = $_GET['tid'];
	?>
	
<center>
<div id="loginpassage">
	<?php
		echo("Prihlásený používateľ: <font color='#106CB5'>$_SESSION[username]</font> &rsaquo; <a class='button' href='#'>Môj profil</a> <a class='button_register' href='#'>Žiadosti o priateľstvo (0)</a> <a class='button_logout' href='logout.php'>Odhlásiť sa</a>");
	?>
</div>
</center>
<div id="forum">
<div id="content">

	<a class='button' href='javascript:history.back(1)'>Späť</a> <a class='button_register' onclick="window.open('upload.php', 'okno1', 'width=500,height=400')">Nahrať obrázok</a><hr />

	<form action="post_reply_parse.php" method="post">
		<p>Pridať odpoveď:</p>
		<textarea name="reply_content" rows="5" cols="75"></textarea><br>
		<button class='button' type=button onclick="addtag('b')"><b>tučné</b></button> <button class='button' type=button onclick="addtag('i')"><i>kurzíva</i></button> <button class='button' type=button onclick="addtag('u')"><u>podčiarknuté</u></button> <button class='button' type=button onclick="addtag('s')"><s>prečiarknuté</s></button> <button class='button' type=button onclick="addtag('center')">center</button> <button class='button_register' type=button onclick="addtag('docastne nefunkcne')">images/nefunkčné</button><br>
		Tag na vloženie obrázku: &lt;img src=&quot;link obrázku&quot; width=&quot;350&quot; height=&quot;250&quot;&gt;
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