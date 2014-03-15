<?php

require_once("connect.php");
@ini_set("short_open_tag", 1);

$statsItemsCount = mysql_query(
"SELECT (
	SELECT COUNT(*)
	FROM `users`
) AS `users_count`, (
	SELECT COUNT(*)
	FROM `categories`
) AS `categories_count`, (
	SELECT COUNT(*)
	FROM `topics`
) AS `topics_count`;
");

if(!$statsItemsCount) { ?>
<small>Štatistiky nedostupné.</small>
<?php } else {
	list($usersCount, $categoriesCount, $topicsCount) = mysql_fetch_row($statsItemsCount);
?>

Počet registrovaných používateľov: (<?=$usersCount?>) 
<font color="#FFF">|</font> 
Počet kategórií: (<?=$categoriesCount?>) 
<font color="#FFF">|</font> 
Počet tém: (<?=$topicsCount?>)

<?php
}