<?php
//error_reporting(E_ALL|E_STRICT);
/* Session sa musí inicializovať ešte *pred* odoslaním akéhokoľvek výstupu */
// @see http://php.net/session-start
session_start();

// zapnutie output bufferingu (nemám iný spôsob posielania hlavičiek po výstupe) 
// @see http://php.net/ob-start
@ob_start();

// pridaná HTTP hlavička určujúca kódovanie (neviem, čo máš v head.php, ale pre istotu, keďže 
// si mi písal, že ti nejde utf8) -- diakritika by už mala fachať 
@header("Content-Type: text/html; charset=utf-8", true, 200);

// pre odkomentovanie doctypu jednoducho odstráň sekvenciu -- zo začiatku aj z konca
?>
<!--DOCTYPE HTML-->
<html>
<head>
	<?php include 'includes/head.php'; ?>
</head>
<body>
	<?php include 'includes/header.php'; ?>
	
	<?php include 'includes/menu.php'; ?>
	
	<?php include 'includes/submenu.php'; ?>

	<div id="forum">
<div id="content">
<?php
include_once("connect.php");
// skrakta zbavujúca nevyhnutnosti kontrolovať existenciu
// TODO: zaviesť nejakú funckiu, ktorá sa o to automaticky postará
$_GET['cid'] = & $_GET['cid'] && $cid = max(0, $_GET['cid']);

if(!$cid) {
	// tu treba ošetriť situáciu, keď nebolo zadané id
	// presmeruje sa na výpis kategórií
	header("Location: http://$_SERVER[SERVER_NAME]" . dirName($_SERVER["PHP_SELF"]) . "/forum.php", true, 301);
	// @see http://php.net/ob-end-clean
	@ob_end_clean();
	exit;
} else {
	if(isset($_SESSION['uid']))
		$logged = " | <a href='create.php?cid=".$cid."' class='button'>Vytvoriť tému</a>";
	else
		$logged = " | Na vytvorenie témy je potrebné sa <span style='color:#106CB5'><b>Prihlásiť</b></span>, alebo sa <font color='#33CC00'><b>Registrovať</b></span>!";
	
	$sql = " SELECT `id` FROM `categories` WHERE `id` = $cid ";
	$res = mysql_query($sql);
	
	// táto podmienka je tu namiesto or die(...), zabezpečuje zobrazenie jednoduchej chybovky 
	// celé fórum by šlo napísať inak 
	if($res) {
		if(mysql_num_rows($res) == 1) {
		// zmenil som dotaz, aby ťahal všetky potrebné dáta naraz 
		// obmedzil som dotazy na konštantnú hodnotu 2, aplikácia bude vďaka tomu bežať rýchlejšie 
		// @see http://php.vrana.cz/predcasna-optimalizace.php
		$sql2 = <<<SQLQUERY
select 
	t.id as topic_id, 
	t.topic_title, 
	t.topic_views, 
	t.topic_date, 
	count(p.id) as topic_post_count, 
	u.username as topic_creator_name 
from posts p 
join (users u, topics t) on t.id = p.topic_id and t.topic_creator = u.id
where t.category_id = $cid 
group by p.topic_id 
order by t.topic_reply_date desc
SQLQUERY;

		$res2 = mysql_query($sql2); // odmazané ďaľšie or die(...)
		
		if($res2) {
			if(mysql_num_rows($res2)) {
				$topics = <<<TOPICSTABLE
<table style="width:100%;border-collapse:collapse;">
	<tr>
		<td colspan='3'>
			<a href='forum.php' class='button'>Návrat do fóra</a>$logged
			<hr>
		</td>
	</tr><tr style='background-color:#106CB5'>
		<td width='50' align='center'></td>
		<td><span style='color:#FFF'>Názov témy</span></td>
		<td width='200' align='center'><font color='#FFF'>Počet odpovedí</font></td>
		<td width='100' align='center'><font color='#FFF'>Zobrazené</font></td>
	</tr><tr>
		<td colspan='3'><hr></td>
	</tr>
TOPICSTABLE;

				while(list($topicId, $topicTitle, $topicViews, $topicDate, $topicPostCount, $topicCreatorName) = mysql_fetch_row($res2)) {
					$topicDate = date("d.m.Y / H:i:s", strtotime($topicDate));
					$topics .= <<<TOPICSTABLE
	<tr>
		<td>
			<center><img width='40' height='40' src='http://diggyshelper.php5.sk/images/icon/icon2.jpg'></center>
		</td>
		<td>
			<a class='topic' href='view_topic.php?cid=$cid&amp;tid=$topicId'>
				<strong>$topicTitle</strong>
			</a>
		<br>
			<span class='post_info'>Pridal/a: 
				<a class="memberusers" href="http://diggyshelper.net/profile.php?user=$topicCreatorName">$topicCreatorName</a>
			dňa 
				<font color='#33CC00'>$topicDate</font>
			</span>
		</td><td align='center'>$topicPostCount</td>
		<td align='center'>$topicViews&nbsp;&times;</td>
	</tr><tr>
		<td colspan='3'><hr></td>
	</tr>
TOPICSTABLE;
				}
				$topics .= "\n</table>";
				echo $topics;
				unset($topics);
				mysql_free_result($res2);
			} else {
			echo <<<NOTOPICSTEXT
<a href='index.php' class='button'>Návrat do fóra</a><hr>
<p>V tejto kategórii nie sú k dispozícii žiadne témy.$logged</p>
NOTOPICSTEXT;
			}
		}
	} else {
			echo <<<NONEXISTING
<a href='index.php' class='button'>Návrat do fóra</a><hr>
<p>Pokúšate sa zobraziť kategóriu, ktorá neexistuje.
NONEXISTING;
		}
		// v prípade, že sa jeden z výsledkov nepodarilo načítať
	} elseif(!$res || !$res2) {
	@header("Retry-After: 900", true, 503);
	echo <<<OFFLINE_PAGE
<h1>Databáza nedostupná</h1>
<p class=warning>Ospravedlňujeme sa Vám, ale túto stránku sa bohužiaľ nepodarilo zobraziť, 
lebo náš databázový server je dočasne nedostupný. Vyskúšajte to prosím neskôr.</p>
<p><a href="" onclick="location.reload();return false">Obnoviť stránku</a></p>
OFFLINE_PAGE;
}
}

?>
</div>
</div>
</center>
	<?php include 'includes/footer.php'; ?>
</body>
</html>
<?php
// vypustenie obsahu z bufferu
// @see http://php.net/ob-end-flush
@ob_end_flush();
