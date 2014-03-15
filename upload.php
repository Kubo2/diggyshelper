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
<div id="upload">
<html>
<head>
	<?php include 'includes/head.php'; ?>
</head>
<body>

<center><br>
<form action="" method="POST" enctype="multipart/form-data">

<input class='button_register' type="file" name="file"><br><br>
<input class='button_register' type="submit" name="submit" value="Nahrať obrázok">

</form>

<?php

//include the connect.php file because we are going to write
//the mysql info there.
//add some quotes in ().. I had forgotten to write them in the previuos part of this
//tutorial
include ("connect.php");

//we want all the script
//part of code

if (isset($_POST['submit'])) {

//set the location
$loc = "images/upload/";

//let's check if the file in an image

if ($_FILES["file"]["type"] == "image/png" || $_FILES["file"]["type"] == "image/jpeg" || $_FILES["file"]["type"] == "image/jpg" || $_FILES["file"]["type"] == "image/gif") {
	
//script
//lets test is

//lets insert the info of the image
//first we have to separate

$file = explode(".", $_FILES["file"]["name"]);

//lets test it
//it works fine
//lets insert the info into db
mysql_query("INSERT INTO images VALUES ('', '".$file[0]."', '".$file[1]."')");
//now lets take the
$id = mysql_insert_id();

//now move the image
//but we wont use
//we will name the image

$newname = "$id.$file[1]";

//also lets add the whole path
$path = "$loc$newname";

move_uploaded_file($_FILES["file"]["tmp_name"], $path);
echo "Vas obrazok bol uspesne ulozeny na nas server.<br><br>http://diggyshelper.php5.sk/$path<br><br>Pre zobrazenie obrazku <a class='button' target='blank' href='$path'>kliknite tu</a>";

//lets test it
	
} else {
	echo "Nahrat mozete len obrazky s formatom (png, jpg, jpeg a gif)!";
}

}

?>

</center>
</body>
</html>
</div>