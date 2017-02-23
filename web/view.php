<?php

/**
 * Category topics listing page.
 *
 * @author  Kubo2
 */


session_start();

header('Content-Type: text/html; charset=UTF-8');

require __DIR__ . '/functions.php';
require __DIR__ . '/connect.php';

/** @var stdClass Current listing view context */
$forum = new stdClass;

if(!isset($_GET['cid'])) {
	$forum->id = 0;
} else {
	$forum->id = max(0, (strval($cid = intval($_GET['cid'], 10)) === $_GET['cid']) ? $cid : 0);
}

// echo "Forum ID: {$forum->id}";

// try to fetch the current context
$forumResource = mysql_query(<<< SQL
select id,
	category_title title,
	category_description description
from categories
where id = {$forum->id}
SQL
);

if(!is_resource($forumResource) || !mysql_num_rows($forumResource)) {
	renderNonExisting(); // implies exit() ======>
}

// replace the current dummy context with a newly fetched resource
$forum = mysql_fetch_object($forumResource);

// try to fetch topics into the current context
$topicsResource = mysql_query(<<<SQL
select
	t.id,
	t.topic_title title,
	t.topic_date postDate,
	count(p.id) as postCount,
	u.username as author
from
	posts p
inner join
	(users u, topics t)
on
	t.id = p.topic_id
	and t.topic_creator = u.id
where
	t.category_id = {$forum->id}
group by
	p.topic_id
order by
	t.topic_reply_date desc
SQL
);

if(!is_resource($topicsResource) || !mysql_num_rows($topicsResource)) {
	$forum->topics = array();
} else {

	while($topic = mysql_fetch_object($topicsResource)) {
		$topic->id = intval($topic->id, 10);
		$topic->postCount = intval($topic->postCount, 10);
		$topic->postDate = new DateTime($topic->postDate, new DateTimeZone('Europe/Bratislava'));;

		$forum->topics[$topic->id] = $topic;
	}
}

// var_dump($forum);

renderForum($forum); // implies exit() ======>


//
// views
//


/**
 * Renders a non-existing category (404) view.
 *
 * @param stdClass $context The current forum context:
 * {
 *   id: int
 * }
 */
function renderNonExisting() {
	header('HTTP/1.1 404 Forum Not Found', TRUE, 404);

	ob_start() ?>
<a href='forum.php' class='input_button'>Návrat do fóra</a><hr>
<p>Pokúšate sa zobraziť kategóriu, ktorá neexistuje.</p>
<?php
	_renderLayout(ob_get_clean(), [ 'titleConst' => 'Kategória neexistuje' ]);
	exit();
}


/**
 * Renders the in-category topics listing.
 *
 * @param stdClass $context The current forum context:
 * {
 *   id: int,
 *   title: string,
 *   description: string,
 *   topics: [
 *     topicId => {
 *       id: int,
 *       title: string,
 *       author: string,
 *       postDate: DateTime,
 *       postCount: int
 *     },
 *     topicId => ...
 *   ]
 * }
 *
 */
function renderForum($context) {
	header('HTTP/1.1 200 Rendering Forum');

	$logged = (loggedIn()
		? "<a href='create.php?cid={$context->id}' class='input_button2'>+ Vytvoriť novú tému</a>"
		: "<br>Pre vytvorenie témy je potrebné sa prihlásiť,
			alebo sa <a style='color: #CCA440; font-weight: bold' href='register.php'>zaregistrovať</a>!"
	);

	ob_start() ?>

<div class='nazov'><h2><?= htmlspecialchars($context->title) ?></h2></div>

<?php if(!$context->topics): ?>
	<a href='forum.php' class='input_button'>Návrat do fóra</a>&nbsp;<?= $logged ?><hr>
	<p>V tejto kategórii nie sú k dispozícii žiadne témy.</p>
<?php else: ?>
	
	<table style='width: 100%; border-collapse: collapse'>
		<!-- table heading -->
		<tr><td colspan=3><a href='forum.php' class='input_button'>Návrat do fóra</a>&nbsp;<?= $logged ?></td></tr>
		<tr style='background-color: #666666'>
			<td width='6%' align='center' id='mob-no'></td><!-- span --><td style='color: #000; font-weight: bold;'>&nbsp;Názov témy</td><!-- span --><td width='15%' style='text-align: center;'>Odpovede&nbsp;</td>
		</tr>
		<tr><td colspan=3 style='padding: .5em 0 0'></td></tr>
		<!-- /table heading -->

		<!-- table -->
	<?php foreach($context->topics as $topic): ?>
		<tr id='topiccolor'>
			<td style='text-align: center' id='mob-no'><img width='40' height='40' class='book' src='images/icon/book.png'></td>
			<td>
				<a class='topic topic-link' href='<?= getTopicUrl($topic->id, $context->id) ?>'>&nbsp;<strong style='color: #000000;'><?= htmlspecialchars($topic->title) ?></strong></a><br>
				<span class='post_info'>
					&nbsp;Pridal/a: <a class='memberusers' href='<?= getProfileUrl($topic->author) ?>'><?= htmlspecialchars($topic->author) ?></a>
					<font color='#FFFFFF'>dňa <?= $topic->postDate->format('d.m.Y / H:i:s') ?></font>
				</span>
			</td>
			<td style='text-align: center'><?= $topic->postCount ?></td>
		</tr>
		<tr><td colspan=3></td></tr>
		<tr><td></td></tr>
	<?php endforeach ?>
		<!-- /table -->

	</table>
<?php endif ?>

<?php
	_renderLayout(ob_get_clean(), [ 'titleConst' => $context->title ]);
	exit();
}


/**
 * Renders the page's layout around the specified $content.
 *
 * @param string $content
 * @param array $templateContext The variable scope accessible from subtemplates
 */
function _renderLayout($content, $templateContext = array()) {
	// fix invalid dependancy of footer.php on a variable from header.php
	$templateContext['absUrl'] = & $templateContext['absUrl']; // TODO: fix this in templates

	echo "<!doctype html>\n";
	_renderSubtemplate('header', $templateContext); ?>
<div id='forum'><div id='content'>
	<?= $content ?>
</div></div>
<?php
	_renderSubtemplate('footer', $templateContext);
}


/**
 * Renders a subtemplate.
 *
 * @param string $name The subtemplate symbolic name out of: 'header', 'footer'
 * @param array $vars Specific variable context being passed the subtemplate: [ varname => value, varname... ]
 * @internal This function should be called only inside the main rendering functions.
 */
function _renderSubtemplate($name, $vars = array()) {
	static $map = [
		'header' => ['head', 'header', 'menu', 'submenu', ],
		'footer' => ['footer', ],
	];

	if(!isset($map[$name])) {
		throw new RuntimeException("The subtemplate '$name' not found");
	}

	foreach($map[$name] as $template) {
		includeScoped(__DIR__ . "/includes/$template.php", $vars);;
	}
}


//
// helpers
//


/**
 * Generates a single relative topic URL to be used in the HTML template.
 * Note: This function does not check whether the topic really exists
 * in the database.
 *
 * @param int $tid Topic ID
 * @param int $cid Category ID
 * @return string Relative URL to the topic view
 */
function getTopicUrl($tid, $cid) {
	return sprintf('view_topic.php?cid=%d&amp;tid=%d', $cid, $tid);
}


/**
 * Generates a single relative profile URL to be used in the HTML template.
 * Note: This function does not check whether the topic really exists in the
 * database.
 *
 * @param string $username
 * @return string Relative URL to $username's public profile
 */
function getProfileUrl($username) {
	return sprintf('profile.php?user=%s', urlencode($username));
}
