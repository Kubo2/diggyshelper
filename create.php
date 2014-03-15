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
	
	<?php session_start(); ?>
	<?php
		if ((!isset($_SESSION['uid'])) || ($_GET['cid'] == "")) {
			header("Location: index.php");
			exit();
		}
		$cid = $_GET['cid'];
	?>
<div id="forum">
	<?php
		echo "Vitaj <font color='#106CB5'>".$_SESSION['username']."</font> !
	<div class='right'><a class='button_logout' href='logout.php'>Odhlasit sa</a></div>";
	?>
<hr />
<a class='button' href='javascript:history.back(1)'>Spat</a> <a class='button_obr' onclick="window.open('upload.php', 'okno1', 'width=500,height=400')">Nahrat obrazok</a>
<hr/>
<div id="content">
	<form action="create_topic.php" method="post">
		<p>Nazov temy:</p>
		<input type="text" name="topic_title" size="98" maxlength="150" />
		<p>Obsah temy:</p>
		<textarea name="topic_content" rows="5" cols="75"></textarea><br>
		<button class='button' type=button onclick="addtag('b')"><b>tucne</b></button> <button class='button' type=button onclick="addtag('i')"><i>kurziva</i></button> <button class='button' type=button onclick="addtag('u')"><u>podciarknute</u></button> <button class='button' type=button onclick="addtag('s')"><s>preciarknute</s></button> <button class='button' type=button onclick="addtag('center')">center</button> <button class='button_obr' type=button onclick="addtag('docastne nefunkcne')">images/nefunkcne</button><br>
		Tag na vlozenie obrazku: &lt;img src=&quot;link obrazku&quot; width=&quot;350&quot; height=&quot;250&quot;&gt;
		<br /><br />
		<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
		<input type="submit" name="topic_submit" class='input_button' value="Vytvorit novu temu" />
	</form>
</div>
</div>
<div id="statistiky">
	<?php include 'includes/statistiky.php'; ?>
</div>
</center>
</body>
</html>