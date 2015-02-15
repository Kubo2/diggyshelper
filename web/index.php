<?php

define('_DB_ERROR', FALSE === (require __DIR__ . '/connect.php'));
if(_DB_ERROR) goto page_template;

// performs a query to the database
// it result-set will be stored in two-dimensional array internally
$theQuery = <<<SQL
SELECT t.id as tid,
	t.category_id as cid,
        t.topic_title as title,
        u.username as author,
        p.count - 1 as answers,
        t.topic_date as created
FROM topics t
INNER JOIN (
	users u,
	(
        	SELECT COUNT(id) as count,
                	topic_id
                FROM posts
                GROUP BY topic_id
                -- LIMIT 0, 11
        ) p
      )
        ON(t.id = p.topic_id AND t.topic_creator = u.id)
ORDER BY t.topic_reply_date DESC,
	p.count ASC,
	t.topic_date DESC
LIMIT 0, 11
SQL;

$theData = mysql_query($theQuery);
$topics = array();
if($theData) {
	while(false !== ($thread = mysql_fetch_assoc($theData))) {
		$topics[] = array(
			"tid" => intval($thread['tid']),
			"cid" => intval($thread['cid']),
			"title" => $thread["title"],
			"author" => $thread["author"],
			"created" => new DateTime($thread["created"]),
		);
	}
	unset($thread);
}

// ====== template start ======
page_template:

session_start();
header("Content-Type: text/html; charset=utf-8", true, 200);
header("Cache-Control: max-age=9, must-revalidate");
// TODO: napísať cachovanie na strane servera + HTTP ETag

// template components
require "sanitize.lib.php";

// template settings
set_include_path("./includes/");
date_default_timezone_set("Europe/Bratislava");

if(_DB_ERROR) ob_start();

// ====== template HTML ====== ?>
<!doctype html>
<?php include('head.php') ?>
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
		margin: 3.5%;
		table-layout: fixed;
	}

	.newest-topics th {
		background: rgb(6, 90, 156);
	}
	</style>
<?php if(_DB_ERROR):
	require __DIR__ . '/includes/database-error.php';
	ob_end_flush();
else: // No _DB_ERROR ?>
	<h1>Vítame ťa na stránke Diggy's Helper</h1>
	<p><strong>Diggy's Helper je diskusné fórum</strong>, kde sa môžeš  s komunitou ľudí s rovnakou
	záľubou podeliť o svoje postrehy a skúsenosti s hrou <a href="./about-game.php">Diggy's Adventure</a>.
	<br>Taktiež v prípade, že niečomu nerozumieš alebo sa chceš o niečom dozvedieť viac, sú tu vítané tvoje
	otázky a problémy. Stačí vybrať správnu kategóriu a vytvoriť v nej tému.
	<table class="newest-topics">
		<caption>Najnovšia diskusia</caption>
		<thead>
			<tr>
				<th width="50%">Meno vlákna</th>
				<th width="16%">Zakľadateľ vlákna</th>
				<th width="12%">Dátum založenia</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($topics as $thread): ?>
			<tr>
				<td>
					<a href=<?= '"' . "./view_topic.php?cid={$thread['cid']}&amp;tid={$thread['tid']}" . '"' ?>>
						<?= SanitizeLib\escape($thread['title'], 'HTML') ?>
					</a>
				</td>
				<td>
					<?= SanitizeLib\escape($thread['author'], 'HTML') ?>
				</td>
				<td>
					<time datetime=<?= $thread['created']->format("\"c\"") ?>>
						<?= $thread['created']->format("j. n. Y, H:i") ?>
					</time>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
<?php ; endif // _DB_ERROR ?>
</div>
<?php include('footer.php') ?>
