<?php
// zapnutie output bufferingu (nemám iný spôsob posielania hlavičiek po výstupe) 
// @see http://php.net/ob-start
@ob_start();

// pridaná HTTP hlavička určujúca kódovanie (neviem, čo máš v head.php, ale pre istotu, keďže 
// si mi písal, že ti nejde utf8) -- diakritika by už mala fachať 
@header("Content-Type: text/html; charset=utf-8", true, 200);

// nikde to tu neni
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
	<style type="text/css">
	td {
		text-align: center;
		width: 300px;
	}

	tr:first-child td {
		background: #33cc00;
	}

	table {
		margin: auto;
	}
	</style>
	<?php include 'includes/head.php'; ?>
</head>
<body>
	<?php include 'includes/header.php'; ?>
	
	<?php include 'includes/menu.php'; ?>
	
	<?php include 'includes/submenu.php'; ?>
	
	<div id="statistiky">
	
	<?php
	require_once("connect.php");

	$membersCount = mysql_query("SELECT COUNT(*) FROM `users`");
	$newestMember = mysql_query("SELECT `id`, `username` 
FROM `users` 
WHERE `registerdate` = (
	SELECT MAX(`registerdate`) 
	FROM `users`
)
");
	$mostActiveMember = mysql_query("SELECT u.username, p.post_creator AS id, COUNT(p.post_creator) AS posts_count 
FROM posts p
JOIN users u on u.id = p.post_creator 
GROUP BY post_creator
ORDER BY posts_count DESC
LIMIT 1");
	$newestTopic = mysql_query("SELECT id, category_id, topic_title 
from topics 
where topic_date = (
	select max(topic_date) 
	from topics
)");
	$mostViewedTopic = mysql_query("SELECT t.id, t.category_id, t.topic_title, v.views 
FROM (
	SELECT MAX( topic_views ) AS views 
	FROM topics 
) v 
JOIN topics t ON t.topic_views = v.views 
LIMIT 1");
	
	$membersCount = $membersCount ? mysql_fetch_row($membersCount) : array(-1);
	if($newestMember)
		$newestMember = mysql_fetch_assoc($newestMember);
	if($mostActiveMember)
		$mostActiveMember = mysql_fetch_assoc($mostActiveMember);
	if($newestTopic)
		$newestTopic = mysql_fetch_assoc($newestTopic);
	if($mostViewedTopic)
		$mostViewedTopic = mysql_fetch_assoc($mostViewedTopic);



	?>
	
	<p>
		<h3>Počet zaregistrovaných užívateľov: ... <?php echo $membersCount[0]; ?> ...</h3>
		
		Najnovší člen: <?php
				if(!$newestMember)
					echo "Nedostupný.";
				else { ?>
				<b><a class="memberusers" href="./#member=<?php echo $newestMember['id']; ?>" rel="nofollow">
					<?php echo $newestMember['username']; ?>
				</a></b>.
				<?php } ?><br><br>
		Najaktívnejší člen: <?php
				if(!$mostActiveMember)
					echo "Nedostupný.";
				else { ?>
				<b><a class="memberusers" href="./#member=<?php echo $mostActiveMember['id']; ?>" rel="nofollow">
					<?php echo $mostActiveMember['username']; ?>
				</a></b> so svojimi <span style="color:red"><?php echo $mostActiveMember['posts_count']; ?></span> príspevkami .
				<?php } ?><br><br>
		Najnovšia téma: <?php
				if(!$newestTopic)
					echo "Žiadna.";
				else { ?>
				<b><a class="naj" href="./view_topic.php?tid=<?php echo $newestTopic['id']; ?>&amp;cid=<?php echo $newestTopic['category_id']; ?>">
					<?php echo $newestTopic['topic_title']; ?>
				</a></b>.
				<?php } ?><br><br>
		Najzobrazovanejšia téma: <?php
				if(!$mostViewedTopic)
					echo "Nie je.";
				else { ?>
				<b><a class="naj" href="./view_topic.php?tid=<?php echo $mostViewedTopic['id']; ?>&amp;cid=<?php echo $mostViewedTopic['category_id']; ?>">
					<?php echo $mostViewedTopic['topic_title']; ?>
				</a></b> 
				zobrazená <span style="color:red"><?php echo $mostViewedTopic['views']; ?></span> krát .
				<?php } ?>
	</p>
	</div>
	
	<?php include 'includes/footer.php'; ?>
</body>
</html>