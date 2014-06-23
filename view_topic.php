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
<?php // TODO: Prepísať celý skript ?>
<head>
	<?php include 'includes/head.php'; ?>
</head>
<body>
	<?php include 'includes/header.php'; ?>
	
	<?php include 'includes/menu.php'; ?>
	
	<?php include 'includes/submenu.php'; ?>
	
<div id="forum">
<div id="content">
	<?php
		include_once("connect.php");

		/** < intentionally @ > */
		@$cid 	= intVal($_GET['cid']);
		@$tid 		= intVal($_GET['tid']);
		/** < / intentionally @ > */

		// TODO: obmedziť získavanie dát na jeden dotaz
		$sql = "SELECT topic_title, topic_views FROM `topics` WHERE `category_id` = $cid AND `id` = $tid LIMIT 1";
		$res = mysql_query($sql);
		if ($res && mysql_num_rows($res) == 1) {
			echo "<table width='100%'>";
			if (!empty($_SESSION['uid'])) { echo "<tr><td colspan='2'><a class='button' href='javascript:history.back(1)'>Späť</a> | <input type='submit' class='input_button' value='Pridať otázku/odpoveď' onClick=\"window.location = 'post_reply.php?cid=".$cid."&tid=".$tid."'\" /><hr />"; } else { echo "<tr><td colspan='2'><a class='button' href='javascript:history.back(1)'>Späť</a> | Na pridanie odpovedí je potrebné sa <font color='#106CB5'><b>Prihlásiť</b></font>, alebo sa <font color='#33CC00'><b>Registrovať</b></font>!<hr /></td></tr>"; }
			while ($row = mysql_fetch_assoc($res)) {
				$sql2 = "SELECT p.post_date, p.post_content, u.username as post_creator FROM posts p JOIN users u ON p.post_creator= u.id WHERE category_id='".$cid."' AND topic_id='".$tid."'";
				$res2 = mysql_query($sql2);
				while ($res2 && $row2 = mysql_fetch_assoc($res2)) {
					echo "<tr><td valign='top' style='border: 2px solid #33CC00;'><div style='min-height: 90px;'><strong>&nbsp;".$row['topic_title']."</strong>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;Pridal/a: <font color='#106CB5'>".$row2['post_creator']."</font> dňa <font color='#33CC00'>".date("d.m.Y / H:i:s", strtotime($row2['post_date']))."</font><hr />".$row2['post_content']."</div></td></tr><tr><td colspan='2'><hr /></td></tr>";
				}

				/** @todo odstrániť nasledujúce štyri riadky (vyžaduje úpravu štruktúry databáze) */
				$old_views = $row['topic_views'];
				$new_views = $old_views + 1;
				$sql3 = "UPDATE topics SET topic_views='".$new_views."' WHERE category_id='".$cid."' AND id='".$tid."' LIMIT 1";
				$res3 = mysql_query($sql3) or die(mysql_error());

			}
			echo "</table>";
		} else {
			echo "<p>Táto téma neexistuje.</p>";
		}
	?>
</div>
</div>
</center>
	<?php include 'includes/footer.php'; ?>
</body>
</html>