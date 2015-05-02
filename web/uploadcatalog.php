<!doctype html>
<html>
<head>
	<title>Pridať fotky / Luxury Design</title>
	<link rel='stylesheet' href='css/style.css' />
</head>
<body>
<?php include 'functions.php'; ?>
<?php include 'connect.php'; ?>

<div id="menu">
	<?php require_once 'menu.php'; ?>
</div>
<div id="obsah">
<center>
	<h1>Pridať katalóg</h1>
</center>
<?php
if(loggedIn()){
?>
<div id="admintitlebar">
	<?php require_once 'admintitlebar.php'; ?>
</div><br>
<form method='post'>
	<?php
		if(isset($_POST['submit'])){
		$namesk = $_POST['namesk'];
		$nameen = $_POST['nameen'];
		$foto = $_POST['foto'];
		$popissk = $_POST['popissk'];
		$popisen = $_POST['popisen'];
		$cena = $_POST['cena'];
				
		if(empty($namesk) or empty($nameen) or empty($popissk) or empty($popisen) or empty($cena)){
			$message = "Vyplň všetky polia!";
		} else {
			mysql_query("INSERT INTO catalog VALUES('', '".$namesk."', '".$nameen."', '".$foto."', '".$popissk."', '".$popisen."', '".$cena."'");
			$message = "Katalóg úspešne pridaný!";
		}
						
		echo "<div class='box'>$message</div>";
		}
	?>
	
<table border="0">
	<tr>
		<td>Názov v SK: <input type="text" name="namesk"></td> <td>Názov v EN: <input type="text" name="nameen"></td>
	</tr>
	<tr>
		<td>Popis v SK: <input type="text" name="popissk"></td> <td>Popis v EN: <input type="text" name="popisen"></td>
	</tr>
	<tr>
		<td>Cena v €: <input type="text" name="cena"></td> <td>Foto: <input type="file" value="browse"  name="foto"></td>
	</tr>
	<tr>
		<td><input type="submit" name="submit" value="Pridať katalóg"></td>
	</tr>
</table>

</form>
<?php
} else {
?>
	Na zobrazenie admin nastavení je potrebné sa <a id="adminlogin" href="adminloginzone.php">prihlásiť</a>.
<?php
}
?>
</div>
<div id="footer">
	<?php require_once 'footer.php'; ?>
</div>
</body>
</html>