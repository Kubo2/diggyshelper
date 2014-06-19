<?php
session_start();
if(isset($_SESSION['name'])){
    $text = $_POST['text'];
 
    $fp = fopen("log.html", 'a');
    fwrite($fp, "<div class='msgln'>(".date("H:i:s", Time()).") <b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
    fclose($fp);
}
?>