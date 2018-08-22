<?php

require __DIR__ . '/functions.php';
require __DIR__ . '/lib/bbcode.php';
require __DIR__ . '/lib/viewTopic.php';

/**
 * View a single topic thread.
 */


$dbContext = require __DIR__ . '/connect.php';

$visited = new dhForum\viewTopic\VisitedTopicCookie;
if(!empty($_COOKIE['visitedTopics'])) {
	try {
		$visited->decode($_COOKIE['visitedTopics']);
	} catch(DomainException $e) {
		// pass
	}
}


// initialize sessions
session_start();

// initialize buffer (temporary; will be replaced by templates)
ob_start();

header('Content-Type: text/html; charset=UTF-8', TRUE, 200);

?>
<!DOCTYPE HTML>
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
	
<div id="forum" itemscope itemtype='https://schema.org/Question'><div id="content"><?php
	function _render_reply_anch_tpl($topicId) { ?>
<a rel='nofollow' class='input_button2' href=<?php
		printf("'./post_reply.php?tid=%d'", $topicId)
?>>
	+ Pridať otázku / odpoveď
</a>

	<?php
	}

	/** @var callable */
	$fuckable_404 = function($render = '<p>Táto téma neexistuje.</p>') {
		header('HTTP/1.1 404 No such topic');
		echo($render);
	};

	if(!isset($_GET['tid'])) {
		call_user_func($fuckable_404, <<<document404
<h1>Chyba: Stránka sa nenašla</h1>
<p>Požadovaná stránka na tomto serveri nebola nájdená.</p>
<p>Požadovanú stránku nemožno zobraziť, pretože táto stránka neexistuje.</p>
document404
);
	} else {
		$qs = (object) getUriParam(function($arg) { return max(0, intval($arg)); }, 'tid', 'cid');
		if($qs->tid) {
			if(NULL !== $qs->cid) {
				$qsParams = explode('&', $_SERVER['QUERY_STRING']);
				foreach($qsParams as $key => $param) {
					if(0 === strpos($param, 'cid=')) {
						unset($qsParams[$key]);
					}
				}

				header('Location: ' . strstr($_SERVER['REQUEST_URI'], '?', TRUE) . '?' . implode('&', $qsParams), TRUE, 301); // affordable since we're using output buffering
				exit(); // ======>
			}

			$topicSql = <<<SQL
SELECT
	topic_title title,
	topic_creator creator,
	category_id cid
FROM
	topics
WHERE
	`id` = %d
SQL;
			$topic = mysql_query(sprintf($topicSql, $qs->tid), $dbContext);

			if($topic && mysql_num_rows($topic)) {
				$postsSql = <<<SQL
SELECT
	p.post_date added,
	p.post_content `text`,
	p.post_markup markup,
	u.username author
FROM
	posts p
JOIN
	users u
ON
	p.post_creator = u.id
WHERE
	topic_id = %d
ORDER BY
	p.post_date ASC
SQL;

				if(!$posts = mysql_query(sprintf($postsSql, $qs->tid), $dbContext)) goto suckableFail;
				$topic = mysql_fetch_object($topic) ?>

	<h2 class='no-center' itemprop='name'><?= htmlspecialchars($topic->title) ?></h2>
	<table border=0 style='width: 100%'>
		<tr>
			<td colspan=2>
				<a class='button' <?php printf("href='./view.php?cid=%d'", $topic->cid) ?>>Návrat do kategórie</a>

				<?php if( ! loggedIn() ) { ?>
					<br>Na pridanie odpovede je potrebné sa prihlásiť, alebo sa <a style="color: #CCA440; font-weight: bold" href="register.php">zaregistrovať</a>!
				<?php } else _render_reply_anch_tpl($qs->tid) ?>
				
			</td>
		</tr>
		<?php $dhPrimary = TRUE // is this the very first loopthrough?>
		<?php while(($post = mysql_fetch_object($posts)) !== false): ?>
		<tr>
			<?php $answer = $dhPrimary ? NULL : 'itemprop=suggestedAnswer itemscope itemtype="https://schema.org/Answer"' ?>
			<td valign='top' id='topiccolor' <?= $answer ?>>
				<nobr class="post-meta line">
					<schema itemprop='author' itemscope itemtype='https://schema.org/Person'>Pridal/a:
						<a
							itemprop='url'
							class='memberusers'
							href='<?= sprintf('./profile.php?user=%s', urlencode($post->author)) // handles also ' " < > ?>'>
								<?= htmlspecialchars($post->author) ?>
						</a>
					</schema> dňa <time
						itemprop='<?= $dhPrimary ? 'datePublished' : 'dateCreated' ?>'
						datetime='<?= id(new DateTime($post->added))->format('c') ?>'>
							<?= id(new DateTime($post->added))->format('d.m.Y / H:i:s') ?>
					</time>
				</nobr>
				<hr>
				<div class='post post-text' itemprop='<?= $dhPrimary ? 'description' : 'text' ?>'>
					<?php
						if($post->markup == 'html') {
							echo $post->text;
						} elseif($post->markup == 'bb') {
							echo dh_bb_decode($post->text);
						}
					?>
				</div>
			</td>
		</tr>
		<tr><td></td></tr>
		<?php $dhPrimary = FALSE // not the first loopthrough anymore ?>
		<?php endwhile ?>
		<tr>
			<td colspan=2>
				<a class='button' <?php printf("href='./view.php?cid=%d'", $topic->cid) ?>>Návrat do kategórie</a>

				<?php if( ! loggedIn() ) { ?>
					<br>Na pridanie odpovede je potrebné sa prihlásiť, alebo sa <a style="color: #CCA440; font-weight: bold" href="register.php">zaregistrovať</a>!
				<?php } else _render_reply_anch_tpl($qs->tid) ?>
			</td>
		</tr>
	</table>
<?php suckableFail:
	if(! $posts): ?>
	<p>Niečo sa nepodarilo. Skúste <a href=<?= sprintf("\"%s\"", htmlspecialchars($_SERVER['REQUEST_URI']), ENT_QUOTES) ?>>obnoviť stránku.</a>
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

<?php

if(isset($topic) && $topic instanceof \stdClass) {
	// set “visited topics” cookie
	$visited->visit($qs->tid, new DateTime);
	setcookie('visitedTopics', $visited, time() + 3600 * 24 * 90); // expire about three months from now

	// TODO: ↓ is a provisional solution; we must get rid of it in favor of non-PHP templates
	// we replace the current "universal title" by the name of the topic
	$html = ob_get_clean();
	$html = preg_replace('~<title>(?:.+(?<!</title>))</title>~i', "<title>{$topic->title}</title>", $html);
	echo $html;
} else {
	ob_end_flush();
}

flush();
