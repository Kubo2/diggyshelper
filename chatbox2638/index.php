<?
session_start();
 
if(isset($_GET['logout'])){    
 
    //Simple exit message
    $fp = fopen("log.html", 'a');
    fwrite($fp, "<div class='msgln'><font color='red'><i>Uzivatel <b>". $_SESSION['name'] ."</b> opustil konverzaciu.</font></i><br></div>");
    fclose($fp);
 
    session_destroy();
    header("Location: index.php"); //Redirect the user
}
 
function loginForm(){
    echo'
    <div id="loginform">
	<h2>Diggys Helper Chat</h2>
    <form action="index.php" method="post">
        <input type="text" size="20px" name="name" id="name" autocomplete="off" placeholder="Zadajte NICK" />
		<br><br>
		<input type="password" size="20px" name="heslo" id="heslo" autocomplete="off" placeholder="Heslo" /><br>Heslo momentalne nieje potrebne.
		<br><br>
        <input type="submit" name="enter" id="enter" value="Spustit chat" />
    </form>
    </div>
    ';
}
 
if(isset($_POST['enter'])){
    if($_POST['name'] != ""){
        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
    }
    else{
        echo '<span class="error">Nezadali ste NICK</span><br>';
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Chat</title>
<link type="text/css" rel="stylesheet" href="style.css" />
</head>
<?php
if(!isset($_SESSION['name'])){
    loginForm();
}
else{
?>
<?php
if(strpos($_SERVER['QUERY_STRING'], "delete") !== FALSE) {
    echo @unlink("log.html") ? "<font color='#fff'>Konverzacia bol zmazana.</font><br><br><a id='enter' href='index.php'>Navrat do konverzacie</a>" : "<font color='#fff'>Odstranovanie konverzacie zlyhalo.</font><br><br><a id='enter' href='index.php'>Navrat do konverzacie</a>";
    exit;
}
?>
<div id="wrapper">
    <div id="menu">
        <p class="welcome">Ste prihlaseny pod menom: <b><?php echo $_SESSION['name']; ?></b></p>

<?php if(is_file("log.html")) { ?>
<a id="delete" href="?delete">Odstranit konverzaciu</a>
<?php } ?>

        <p class="logout"><a id="exit" href="#">Opustit konverzaciu</a></p>
        <div style="clear:both"></div>
    </div>    

    <form name="message" action="">
        <input name="usermsg" type="text" id="usermsg" size="60px" autocomplete="off" placeholder="Napisat spravu..." />
        <input name="submitmsg" type="submit"  id="submitmsg" value="Odoslat" />
    </form>
    
    <div id="chatbox"><?php
    if(file_exists("log.html") && filesize("log.html") > 0){
        $handle = fopen("log.html", "r");
        $contents = fread($handle, filesize("log.html"));
        fclose($handle);
 
        echo $contents;
    }
    ?></div>
</div>
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript">
// jQuery Document
$(document).ready(function(){
    //If user submits the form
    $("#submitmsg").click(function(){    
        var clientmsg = $("#usermsg").val();
        $.post("post.php", {text: clientmsg});                
        $("#usermsg").attr("value", "");
        return false;
    });
 
    //Load the file containing the chat log
    function loadLog(){        
        var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
        $.ajax({
            url: "log.html",
            cache: false,
            success: function(html){        
                $("#chatbox").html(html); //Insert chat log into the #chatbox div                
                var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
                if(newscrollHeight > oldscrollHeight){
                    $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
                }                
              },
        });
    }
    setInterval (loadLog, 1000);    //Reload file every 1 seconds
 
    //If user wants to end session
    $("#exit").click(function(){
        var exit = confirm("Ste si isti, ze chcete ukoncit chat?");
        if(exit==true){window.location = 'index.php?logout=true';}        
    });
});
</script>
<?php
}
?>
</body>
</html>