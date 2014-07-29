<html>
<head>
	<title>Search Box</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<?php
	include "connect.php";
?>

<span id="box">
<b>Vyhľadať užívateľa:</b> 
<input type="text" id="search_box">
</span>

<div id="search_result">

</div>

<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="index.js"></script>
</body>
</html>