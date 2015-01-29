<?php

if(isset($_COOKIE[ini_get('session.name')])) session_start();

// <production server> only
if(!in_array($_SERVER['SERVER_ADDR'], array('127.0.0.1', '::1'))) {
	@ ini_set('display_errors', 0); // intentionally @
}

// 200 can be replaced, but Content-Type header is neccessary
header("Content-Type: text/html; charset=utf-8", true, 200);

define('_DB_ERROR', FALSE === (require __DIR__ . '/connect.php'));

// switch on output buffering 
ob_start();

?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'includes/head.php'; ?>
</head>
<body>
	<?php
		include 'includes/header.php';
		include 'includes/menu.php';
		include 'includes/submenu.php';
	?>
	
<div id="forum">
	<div id="content">
	<?php

	if(_DB_ERROR) {
		require __DIR__ . '/includes/database-error.php';
		ob_end_flush();
	} else {
		$crs = mysql_query(' SELECT `id`, `category_title`, `category_description` FROM `categories` ORDER BY `category_title` ASC ');

		if($crs && mysql_num_rows($crs) > 0) {
			while( list($id, $title, $description) = mysql_fetch_row($crs) ) {
				printf('<a class="cat_links categories links" href="./view.php?cid=%s">', $id);
				printf("\n%s<br>%s\n", $title, $description); // TODO: fixnúť menší font
				print('</a>');
			}
		} else {
			echo "<p>Zatial nie sú k dispozícii žiadne kategórie.</p>";
		}

		ob_end_flush();
	}
// ...	?>
</div>
</div>
	<?php include 'includes/footer.php'; ?>
</body>
</html>