<?php
@ob_start();
session_start();
?>

<html>
<head>
	<?php include 'includes/head.php'; ?>
</head>
<body>
	<?php include 'includes/header.php'; ?>
<center>
<div id="pages">
	<?php
		include_once("connect.php");

		if (isset($_POST['username'])) {
			$username = $_POST['username'];
			$password = md5($_POST['password']);
			$remember = $_POST['remember'];
			$sql = "SELECT COUNT(*), id FROM users WHERE username='".$username."' AND password='".$password."' LIMIT 1";
			$res = mysql_query($sql);
			if(!$res) 
				echo "Nastala chyba: Nasša databáza je nedostupná. Prosím, zopakujte svoj pokus neskôr.";
			else {
				$user = mysql_fetch_row($res);
				if($user[0]) {
					$_SESSION['uid'] = $user[1];
					$_SESSION['username'] = $username;
					if(isset($_POST["remember"]) && $ucache = fopen("./usercache.cache", "a")) {
						$identifier = sha1("<<" . $username . $user[1] . ">>");
						fwrite($ucache, time() . "||" . $username . "||" . $identifier . "\n");
						fclose($ucache);
						setcookie("remember_user", $identifier, time()+60*60*24*30*2);
					}
					header("Location: ./index.php");
					ob_end_clean();
					exit;
				} else {
					echo "Neplatné prihlasovacie údaje. <a class='button' href='./index.php' onclick=\"history.go(-1);return false\">Späť</a>";
				}
			}
		}
	?>
</div>
</center>
</body>
</html>

<?php
@ob_end_flush();