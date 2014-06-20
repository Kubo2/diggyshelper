<?php

#define
define('ABSURI', (strlen(dirname($_SERVER["PHP_SELF"])) !== 1 ? dirname($_SERVER["PHP_SELF"]) : '') . '/');
define('CHAT_LOGFILE', "./log.html");
// actions
define('CHAT_LOGOUT', "logout");
define('CHAT_ENTER_CONVERSATION', "enter");
define('CHAT_DELETE_CONVERSATION', "cdelete");
define('CHAT_POST_MESSAGE', 'psend');
#enddefine

function redirect($uri, $code = 301)
{
	if(!preg_match('~^[a-z]+://~', $uri))
	{
		$uri = "http" . (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != 'off' ? 's' : '') . "://" . $_SERVER["SERVER_NAME"] . ($uri[0] != '/' ? ABSURI : '') . $uri;
	}
	header("Location: $uri", true, $code);
	exit;
}

/** @var string[] */
$notes = [];

switch($_SERVER["QUERY_STRING"])
{
	case CHAT_LOGOUT:
		setcookie("name", "deleted", time() - 60 * 60 * 24);
		if(!is_file(CHAT_LOGFILE)) goto redirect;
		file_put_contents(
			CHAT_LOGFILE,
			"\n"
			. '<div class="msgln">'
			. 	'<i>Užívateľ <b>' . $_COOKIE["name"] . '</b> opustil chatovací stôl.</i>'
			. '</div>',
			FILE_APPEND
		);
		redirect: redirect("index.php", 303);
	break;

	case CHAT_ENTER_CONVERSATION:
		if(!empty($_POST["name"]) && trim($_POST["name"]))
		{
			//setcookie("name", $_POST["name"], time() + 60 * 60 * 24 * 7, '/', '.' . $_SERVER["SERVER_NAME"], false, true);
			setcookie("name", $_POST["name"], time() + 60 * 60 * 24 * 7);
			redirect("index.php", 302);
		} else {
			array_push($notes, '<span class="error">Prezraďte nám prosím Vaše meno. Ak nám nechcete povedať svoje meno, budete v chatovacej sále vystupovať ako <b>&lt;Anonymný></b>.</span>');
		}
	break;

	case CHAT_POST_MESSAGE:
		if( !empty($_POST["usermsg"]) )
		{
			$name = !empty($_COOKIE["name"]) && trim($_COOKIE["name"]) ? trim($_COOKIE["name"]) : "<Anonymný>";
			$text = trim($_POST["usermsg"]);

			if(empty($text)) break;
			
			touch(CHAT_LOGFILE);
			file_put_contents(
				CHAT_LOGFILE, 
				"\n"
				. '<div class="msgln">'
				. 	'(' . date("H:i:s, d. m. Y") . ')'
				. 	' <b>' . htmlspecialchars($name) . '</b>:&nbsp;'
				. 	htmlspecialchars($text)
				. '</div>', 
				FILE_APPEND
			);
			redirect("index.php", 303);
		} else {
			array_push($notes, '<span class="error">Vyplňte prosím text správy.</span>');
		}
	break;

	case CHAT_DELETE_CONVERSATION:
		if(!isset($_POST["potvrdit-vymazania"]))
		{
			$challenge = 
				'<form action="' . ABSURI . 'index.php?' . CHAT_DELETE_CONVERSATION . '" method="post" style="display: inline-block">'
				. 	'<span class="error">Kliknutím na tlačítko prosím <b>potvrďte</b> vymazanie konverzácie.</span>'
				. 	'<input type="submit" name="potvrdit-vymazania" value="Vymazať konveerzáciu">'
				. '</form>'
			;
			array_unshift($notes, $challenge);
			break;
		}
		if(is_file(CHAT_LOGFILE)) unlink(CHAT_LOGFILE);
	break;

	default:
}

header("Content-Type: text/html; charset=utf-8", true, 200);
header("Chatroom-Guru: Kubo2; I am sexy and I know it!", true);

?>
<!doctype html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta name="robots" content="noindex">
<meta name="author" content="Kubo2">
<meta name="designer" content="WladinQ">
<title>dh-test: Chat</title>
<link href="style.css" rel="stylesheet">
</head><body>
<h1>Chatovacia sála</h1>
<?php

if(count($notes) === 1)
{
	echo $notes[0];
} else if(count($notes) > 1)
{
	echo '<div class="notes">';
	foreach($notes as $note)
	{
		echo '<div>' . $note . '</div>';
	}
	echo '</div>';
}

?>
<?php if(!isset($_COOKIE["name"])) { ?>
<form id="loginform" action="index.php?<?php echo CHAT_ENTER_CONVERSATION ?>" method="post">
	<p>
		<label for="name">Vaša prezývka</label>
		<input type="text" name="name" id="name">
		<input type="submit" value="Vstúpiť">
	</p>
</form>
<?php } else { ?>
<div id="wrapper">
	<div id="menu">
		<p class="welcome">Vitajte, <b><?php echo $_COOKIE["name"] ?></b></p>
		<p class="logout">
			<a id="exit" href="index.php?<?php echo CHAT_LOGOUT ?>">Odísť</a>
			| <a href="index.php?<?php echo CHAT_DELETE_CONVERSATION ?>">Vymazať</a>
		</p>
		<br clear='all'>
	</div>
	<div id="chatbox">
		<?php
			if(!is_file(CHAT_LOGFILE) || !filesize(CHAT_LOGFILE))
			{
				echo "<p>Do konverzácie zatiaľ nikto neprispel. Rozbehnite o  niečom konverzáciu práve Vy!</p>";
			} else {
				readfile(CHAT_LOGFILE);
			}
		?>
	</div>
	<form name="message" action="index.php?<?php echo CHAT_POST_MESSAGE ?>" method="post">
		<input name="usermsg" type="text" id="usermsg" size="63">
		<input type="submit"  id="submitmsg" value="Odoslat">
	</form>
</div>
<?php } ?>
