<?php

// initialize sessions
session_start();

// initialize buffer (temporary; will be replaced by templates)
ob_start(  );

header("Content-Type: text/html; charset=utf-8", true, 200);

?>
<!doctype html>
<html>
<?php // TODO: Prepísať celý skript ?>
<head>
	<?php include 'includes/head.php' ?>
</head>
<body>
	<?php
		include 'includes/header.php';
		include 'includes/menu.php';
		include 'includes/submenu.php';
			?>
	
<div id="forum"><div id="content"><?php
	
	require("./connect.php");
	require('./functions.php');
	require('./lib/bbcode.php');

	function _render_reply_anch_tpl($categoryId, $topicId) { ?>
<a rel='nofollow' class='input_button' href=<?php
		printf("'./post_reply.php?cid=%d&amp;tid=%d'", $categoryId, $topicId)
?>>
	<b>Pridať</b> otázku / odpoveď
</a>
	<?php
	}

	/** @var callable */
	$fuckable_404 = function($render = '<p>Táto téma neexistuje.</p>') {
		header("HTTP/1.1 404 Topic does not exist");
		echo($render);
	};

	if(!isset($_GET['cid'], $_GET['tid'])) { // either one or both does not exist
		call_user_func($fuckable_404, <<<document404
<h1>Chyba: Stránka sa nenašla</h1>
<p>Požadovaná stránka na tomto serveri nebola nájdená.</p>
<p>Požadovanú stránku nemožno zobraziť, pretože táto stránka neexistuje.</p>
document404
);
	} else {
		$qs = array_slice_assoc($_GET, [ 'cid', 'tid' ]);
		array_walk($qs, function(& $id) {
			$id = max(0, intval($id));
		});
		extract($qs);

		if($cid && $tid) {
			$topic = mysql_query(
				sprintf( "SELECT `topic_title` as `title`, `topic_creator` as `creator`
						FROM `topics`
							WHERE `category_id` = %d AND `id` = %d
						LIMIT 1",
					$cid,
					$tid
				)
			);

			if($topic && mysql_num_rows($topic)) {
				$posts = mysql_query(
					sprintf("SELECT p.post_date as `added`, p.post_content as `text`, p.post_markup as 'markup', u.username as `author`
							FROM `posts` p
								JOIN `users` u
									ON p.post_creator = u.id
								WHERE `category_id` = %d AND `topic_id` = %d
							ORDER BY p.post_date ASC",
						$cid,
						$tid
					)
				);

				if(! $posts) goto suckableFail;

				$topic = mysql_fetch_object($topic) ?>

	<h1 class='no-center' ><?= SanitizeLib\sanitize($topic->title, SanitizeLib\HTML) ?></h1>
	<table border=0 style='width: 100%'>
		<tr>
			<td colspan=2>
				<?php if( $cid ): ?>
					<a class='button' <?php printf("href='./view.php?cid=%d'", $cid) ?>>Späť do kategórie</a> |
				<?php endif ?>

				<?php if( ! loggedIn() ) { ?>
					Na pridanie odpovede je potrebné sa <b style="color: #106cb5">Prihlásiť</b>, alebo sa <b style="color: #33cc00">Registrovať</b>!
				<?php } else _render_reply_anch_tpl($cid, $tid) ?>
				<hr>
			</td>
		</tr>
		<?php while(($post = mysql_fetch_object($posts)) !== false): ?>
		<tr>
			<td valign='top' style='border: 2px solid #33cc00; padding: 5px'>
				<nobr class="post-meta line">Pridal/a: <a 
					style="font-weight: bold" 
					class='memberusers' 
					href=<?=( sprintf("'./profile.php?user=%s'", urlencode($post->author)) ) // handles also ' " < > ?>><?=(
						SanitizeLib\escape($post->author, 'HTML')
					)?></a> dňa <time datetime=<?=(
						id(new DateTime($post->added))->format("'c'")
					)?> style='color: #33cc00'><?=( id(new DateTime($post->added))->format("d.m.Y / H:i:s") )?></time>
				</nobr>
				<hr><div class='post post-text'><?php
				if($post->markup == 'html') {
					echo $post->text;
				} elseif($post->markup == 'bb') {
					echo dh_bb_decode($post->text);
				}
				?></div>
			</td>
		</tr>
		<?php endwhile ?>
		<tr>
			<td colspan=2>
				<?php if( loggedIn() ) _render_reply_anch_tpl($cid, $tid) ?>
			</td>
		</tr>
	</table>
<?php suckableFail:
	if(! $posts): ?>
	<p>Niečo sa nepodarilo. Skúste <a href=<?= (unset)
		printf("\"%s\"", SanitizeLib\escape($_SERVER['REQUEST_URI'], 'html'))
	?>>obnoviť stránku.</a>
		<?php ; endif ?>
			<?php } else {
				call_user_func($fuckable_404);
			}
		} else {
			call_user_func($fuckable_404);
		}
	}

?></div></div>
	<?php include 'includes/footer.php'; ?>
</body>
</html>

<?php ob_end_flush(); flush() ?>
