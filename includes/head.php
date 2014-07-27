<?php
// absolute url off current document
// depends on requested resource's url
$absUrl = rtrim(dirname($_SERVER["PHP_SELF"]), '/');

?>
<meta charset="utf-8">
<!--meta name="viewport" content="width=device-width,initial-scale=1.1,user-scalable=no"-->
<!-- Universal title. Only temporarily. -->
<title><?php echo !empty($titleConst) ? $titleConst : "Diggy's Helper - Prvé česko-slovenksé fórum o hre Diggy's Adventure" ?></title>

<link rel='stylesheet' href='<?php echo $absUrl; ?>/css/style.css'>
<link href="<?php echo $absUrl; ?>/favicon.png" rel="icon" type="image/png">
<!--script type="text/javascript" src="<?php echo $absUrl; ?>/diggyshelper.js"></script-->
