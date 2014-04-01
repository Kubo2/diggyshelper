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
	
	<!-- jQuery nie je vôbec portrebné. @see selector.js ~Kubo2 -->
	<!--script type="text/javascript" src="jquery.js"></script-->
	<!-- selector.js bol nahradený globálnym javascriptom diggyshelper.js @since 1.1 -->
	<!--script type="text/javascript" src="./selector.js"></script-->
	<style type="text/css">
		.red{
		color:white;
		background:red;
		border-radius:5px;
		padding:0px 10px;
		}

		.orange{
		color:white;
		background:orange;
		border-radius:5px;
		padding:0px 10px;
		}

		.green{
		color:white;
		background:green;
		border-radius:5px;
		padding:0px 10px;
		}
	</style>

</head>
<body>
	<?php
		include 'includes/header.php';
		include 'connect.php';
	?>
	
	<?php include 'includes/menu.php'; ?>
	
	<?php include 'includes/submenu.php'; ?>
	
<div id="forum">
	<a class='button' href='index.php'>Návrat do fóra</a>
<hr />
<div id="content">
	<form method='post'>
		<?php
		$reg = false;
			if(isset($_POST['submit'])){
				$username = $_POST['username'];
				$password = $_POST['password'];
				$password2 = $_POST['password2'];
				$email = $_POST['email'];
				
				if(empty($username) || empty($password) || empty($password2) || empty($email)){
					$message = "&bull; Vyplňte prosím všetky povinné polia!<br><br>";
				} else if($password != $password2) {
					$message = "&bull; Zadané heslá sa nezhodujú!<br><br>";
				} else {
					mysql_query("  INSERT INTO users(registerdate,username,password,email) 
								VALUES(NOW(),'$username',MD5('$password'),'$email')  ");
					$reg = true;
					$message = "Registrácia dokončená! <a href='index.php'>Vráťte sa</a> do fóra, kde sa môžete prihlásiť (aj tak by bolo najlepšie spraviť možnosť prihlásenia sa hneď po registrácii).<br><br>";
				}
						
				echo "<div class='box'>$message</div>";
			}
		?>
	<table border='0'>
		<tr>
			<td>Registrovať sa:</td>
		</tr>
		<tr>
			<td><input class='input' name='username' placeholder='Nickname' value='<?php echo isset($_POST["submit"])&&!$reg?$username:''; ?>' type='text'> <font color='red'>*</font></td>
		</tr>
		<tr>
			<td><input class='input' autocomplete='off' name='password' placeholder='Heslo' id='status' value='<?php echo isset($_POST["submit"])&&!$reg?$password:''; ?>' type='<?php echo isset($password)&&!$reg?'text':'password'; ?>'> <font color='red'>*</font> <span class='first'></span></td>
		</tr>
		<tr>
			<td><input class='input' autocomplete='off' name='password2' placeholder='Heslo znova' value='' type='password'> <font color='red'>*</font></td>
		</tr>
		<tr>
			<td><input class='input' name='email' placeholder='E-mail' value='<?php echo isset($_POST["submit"])&&!$reg?$email:''; ?>' type='text'> <font color='red'>*</font></td>
		</tr>
		<tr>
			<td><input class='button_register' type='submit' name='submit' value='Registrovať sa'></td>
		</tr>
	</table>

	</form>
</div>
</div>
</center>
	<?php include 'includes/footer.php'; ?>
</body>
</html>