<?php

// initialize sessions
session_start();

// initialize buffer (temporary; will be replaced by templates)
ob_start(  );

header("Content-Type: text/html; charset=utf-8", true, 200);

?>
<!DOCTYPE HTML>
<html>
<?php // TODO: Prepísať celý skript ?>
<head>
	<!--link rel="canonical" href="http://<?=( $_SERVER['SERVER_NAME'] . rtrim(dirname($_SERVER['REQUEST_URI']), '/'))?>/view_topic.php"-->
	<?php include 'includes/head.php'; ?>
</head>
<body>
	<?php include 'includes/header.php'; ?>
	
	<?php include 'includes/menu.php'; ?>
	
	<?php include 'includes/submenu.php'; ?>
	
<div id="forum">
<div id="content"><?php
	
	require("./connect.php");
	require('./functions.php');

	/** @var callable */
	$fuckable_404 = function($render = '<p>Táto téma neexistuje.</p>') {
		header("HTTP/1.1 404 Topic does not exist");
		echo($render);
		//exit; # never, never exit
	};

	if(!isset($_GET['cid'], $_GET['tid'])) {
		$fuckable_404("<h1>Chyba 404:</h1><p>Požadovaná stránka nebola nájdená.<p>Požadovanú stránku nemožno zobraziť, pretože táto stránka neexistuje.");
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
					sprintf( "SELECT p.post_date as `added`, p.post_content as `text`, u.username as `author`
							FROM `posts` p
								JOIN `users` u
									ON p.post_creator = u.id
								WHERE `category_id` = %d AND `topic_id` = %d
							ORDER BY p.post_date ASC ",
						$cid,
						$tid
					)
				);

				if(! $posts) goto suckableFail;

				$topic = mysql_fetch_object($topic) ?>

	<h1   class='no-center' ><?= htmlspecialchars($topic->title) ?></h1>
	<table border=0 style='width: 100%'>
		<tr>
			<td colspan=2>
				<?php if(!empty($_GET['cid'])): ?>
					<a class='button' <?php printf("href='./view.php?cid=%d'", (int) $_GET['cid']) ?> >Späť do kategórie</a> |
				<?php endif ?>
				<?php if( ! loggedIn() ): ?>
					Na pridanie odpovede je potrebné sa <b style="color: #106cb5">Prihlásiť</b>, alebo sa <b style="color: #33cc00">Registrovať</b>!
					<hr><?php 
						else: 
					?><a class='input_button' rel='nofollow' href='<?= 
						sprintf('./post_reply.php?cid=%d&amp;tid=%d', $cid, $tid) 
					?>'>Pridať otázku/odpoveď</a>
					<hr>
				<?php endif ?>
			</TD>
		</tr>
		<?php while(($post = mysql_fetch_object($posts)) !== false): ?>
		<tr>
			<td valign='top' style='border: 2px solid #33cc00; padding: 5px'>
				<nobr class="line post-meta">Pridal/a: <a 
					style="font-weight: bold" 
					class='memberusers' 
					href='./profile.php?user=<?=( urlencode($post->author /*, 'HTML'*/) )?>'><?=(
						SanitizeLib\escape($post->author, 'HTML')
					)?></a> dňa <time datetime=<?=(
						id(new DateTime($post->added))->format("'c'")
					)?> style='color: #33cc00'><?=( id(new DateTime($post->added))->format("d.m.Y / H:i:s") )?></time>
				</nobr>
				<hr><div   class='post post-text'><?=( SanitizeLib\sanitize($post->text,  SanitizeLib\HTML) )?></div>
			</td>
		</tr>
		<?php endwhile ?>
	</table>
<?php suckableFail:
	if(! $posts): ?>
	<p>Sorry, but something wrong happened. Please retry.
		<?php ; endif ?>
			<?php } else {
				$fuckable_404();
			}
		} else {
			$fuckable_404();
		}
	}


	?>
</div>
</div>
	<?php include 'includes/footer.php'; ?>
</body>
</html>

<?php ob_end_flush(); flush() ?>
