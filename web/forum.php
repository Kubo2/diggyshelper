<?php

$dbContext = require __DIR__ . '/connect.php';


// headers
session_start();

header('Content-Type: text/html; charset=UTF-8');

if(!$dbContext) {
	header('Retry-After: 600', TRUE, 503);
} else {
	$resource = mysql_query('SELECT `id`, category_title, category_description FROM categories ORDER BY category_title ASC', $dbContext);

	$categories = [];
	while(list($id, $title, $description) = mysql_fetch_row($resource)) {
		$categories[] = (object) [
			'id' => $id,
			'title' => $title,
			'description' => $description,
		];
	}
}

?>
<!doctype html>
<html>
<head>
<?php
	$GLOBALS['titleConst'] = 'Kategórie na fóre'; // intentionally $GLOBALS -- preseve "magic dependencies"
	include 'includes/head.php';
?>
</head>
<body>
<?php
	include 'includes/header.php';
	include 'includes/menu.php';
	include 'includes/submenu.php';
?>
<div id='forum'>
	<div id='content'>
<?php if(!$dbContext): ?>
<p>
	Ľutujeme, ale nič tu nie je.
	 Naša databáza je momentálne na niekoľko minút nedostupná.
	 Už pracujeme na rýchlom vyriešení problému. Prosím, skúste
	 sa sem vrátiť o chvíľočku.
</p>
<?php elseif(!$categories): ?>
	<p>Zatial nie sú k dispozícii žiadne kategórie.</p>
<?php else: ?>
	<ul class="category">
	<?php foreach($categories as $category): ?>
		<li><a href="./view.php?cid=<?= $category->id ?>"><b><?= htmlspecialchars($category->title) ?></b><br><?= htmlspecialchars($category->description) ?></a>
	<?php endforeach ?>
	</ul>
<?php endif ?>
</div>
</div>
	<?php include 'includes/footer.php'; ?>
</body>
</html>
