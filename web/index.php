<?php

require __DIR__ . '/functions.php';
require __DIR__ . '/lib/template.php';
require __DIR__ . '/lib/viewTopic.php';

/**
 * Front page.
 */


$dbContext = require __DIR__ . '/connect.php';

if(!empty($_COOKIE['visitedTopics'])) {
	try {
		$visited = new dhForum\viewTopic\VisitedTopicCookie($_COOKIE['visitedTopics']);
	} catch(DomainException $e) {
		setcookie('visitedTopics', 'unset', 1); // one second after the Unix epoch
	}
}

// database query for topic metadata
$theQuery = <<< SQL
SELECT
	t.id topic_id,
	t.category_id,
	t.topic_date,
	p.post_count,
	t.topic_title,
	lp.post_date last_post_date,
	lp.post_creator last_post_user,
	lp.username last_post_username
FROM topics t

LEFT JOIN  -- get count numbers of posts
(
	SELECT
		COUNT(id) - 1 post_count,
		topic_id
	FROM posts
	GROUP BY topic_id
) p
ON t.id = p.topic_id

LEFT JOIN  -- get metadata about the most recent posts
(
	SELECT
		p.topic_id,
		p.post_date,
		p.post_creator,
		u.username
	FROM posts p

	LEFT JOIN
		users u
	ON p.post_creator = u.id

	WHERE
		p.post_date
	IN (
		SELECT
			MAX(p.post_date)
		FROM posts p
		GROUP BY p.topic_id
	)
) lp
ON t.id = lp.topic_id

ORDER BY  -- sort appropriately
	last_post_date DESC,
	p.post_count ASC,
	t.topic_date DESC

LIMIT 0, 11

SQL;


$topics = array();
if($dbContext && ($theData = mysql_query($theQuery, $dbContext))) {
	while(FALSE !== ($thread = mysql_fetch_object($theData))) {
		$thread = (object) [
			'topicID' => intval($thread->topic_id),
			'categoryID' => intval($thread->category_id),
			'topicDate' => new DateTime($thread->topic_date),
			'postCount' => intval($thread->post_count),
			'topicTitle' => $thread->topic_title,
			'lastPostDate' => new DateTime($thread->last_post_date),
			'lastPostUser' => intval($thread->last_post_user), // user ID
			'lastPostUsername' => $thread->last_post_username,
			'topicVisited' => FALSE, // topic visited in the past?
		];

		if(!isset($visited) || !$visited->was($thread->topicID) || $thread->lastPostDate < $visited->when($thread->topicID)) {
			array_push($topics, $thread);
		} else { // topic visited before by the user and new replies are present
			$thread->topicVisited = TRUE;
			array_unshift($topics, $thread);
		}
	} unset($thread);

	mysql_free_result($theData);
}


// ====== template start ======
page_template:

session_start();
header('Content-Type: text/html; charset=UTF-8', TRUE, $topics ? 200 : 503);

// TODO: napísať cachovanie na strane servera + HTTP ETag
header('Cache-Control: max-age=9, must-revalidate');

// template settings
set_include_path("./includes/");
date_default_timezone_set("Europe/Bratislava");

// ====== template HTML ====== ?>
<!doctype html>
<?php include('head.php') ?>

<?php // ====== META DESCRIPTION ====== ?>
<meta content="Si kopáč? Zapoj sa do komunity kopáčov, ktorí si navzájom radi radia! Diggy's Helper pre Diggy's Adventure je úplne prvé česko-slovenské diskusné fórum o hre Diggy's Adventure." name='description'>
<?php // === END META DESCRIPTION ====== ?>

</head><body class="page front">
<?php
	include('header.php');
	include('menu.php');
	include('submenu.php');
	echo "\n";
		?>
<div class="pages">
	<style scoped>
	/**
	 * Stylesheet available only in div.pages scope.
	 */
	table.newest-topics {
		margin: 3.5% 0 0;
		table-layout: fixed;
		width: 100%;
	}

	.newest-topics th {
		color: #FFF;
		background: #CCA440;
		font-weight: normal;
	}

	.unread-posts {
		color: #11A815;
		cursor: default;
	}
	</style>
	<h1>Vítame ťa na stránke Diggy's Helper</h1>
	<p><strong>Diggy's Helper je diskusné fórum</strong>, kde sa môžeš  s komunitou ľudí s rovnakou
	záľubou podeliť o svoje postrehy a skúsenosti s hrou <a class="memberusers" href="about-game.php">Diggy's Adventure</a>.
	<br>Taktiež v prípade, že niečomu nerozumieš alebo sa chceš o niečom dozvedieť viac, sú tu vítané tvoje
	otázky a problémy. Stačí vybrať správnu kategóriu a vytvoriť v nej tému.
	
	<?php if(!count($topics)): ?>
	<p style='font-size: larger; color: #666'>(Je nám to ľúto, najnovšiu diskusiu sa nám tentoraz nepodarilo zistiť. Vyzerá to na dočasný problém s pripojením k našej
		databáze, alebo žeby tu vážne neboli žiadne témy?)</p>
	<?php else: // count($topics) > 0 ?>
	<table class="newest-topics" id="mob-no">
		<caption id="bold">Najnovšia diskusia</caption>
		<thead>
			<tr>
				<th width="50%" id="mob-no">Meno vlákna</th>
				<th width="16%" id="mob-no">Posledný príspevok pridal</th>
				<th width="12%" id="mob-no">kedy</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($topics as $thread): ?>
			<tr>
				<td id="mob-name">
					<?= $thread->topicVisited ? "<span class='unread-posts' title='nové odpovede'>●</span>" : NULL ?>
					<a href='<?= "view_topic.php?tid={$thread->topicID}" ?>' class='memberusers'>
						<?= htmlspecialchars($thread->topicTitle) ?>
					</a>
				</td>
				<td id="mob-author">
					<a href='profile.php?user=<?= rawurlencode($thread->lastPostUsername) ?>' class='memberusers'>
						<?= htmlspecialchars($thread->lastPostUsername) ?>
					</a>
				</td>
				<td id="mob-date">
					<time datetime=<?= $thread->lastPostDate->format('"c"') ?>>
						<?= sk_relativeDateFormat($thread->lastPostDate, new DateTimeImmutable) ?>
					</time>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	
	<div id="mob-prispevky">
		<b>Najnovšia diskusia</b>
		<div class="hlavicka">
			<p class="left">Meno vlákna</p><p class="right">pridané</p>
		</div>
		<br><br>
		<?php foreach($topics as $thread): ?>
		<ul>
			<a href='<?= "view_topic.php?tid={$thread->topicID}" ?>'>
				<li>
					<?= htmlspecialchars($thread->topicTitle) ?>
					<time datetime=<?= $thread->lastPostDate->format('"c"') ?>>
						<?= $thread->topicVisited ? "<span class='unread-posts'>●</span>" : NULL ?>
						<?= sk_relativeDateFormat($thread->lastPostDate, new DateTimeImmutable) ?>
					</time>
				</li>
			</a>
		</ul>
		<?php endforeach ?>
	</div>
	<?php endif // !count($topics) ?>

</div>
<?php include('footer.php') ?>
