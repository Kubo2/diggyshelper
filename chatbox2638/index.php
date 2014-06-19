<?php
session_start();
 
if(isset($_GET['logout'])){    
 
    //Simple exit message
    $fp = fopen("log.html", 'a');
    fwrite($fp, "<div class='msgln'><i>User ". $_SESSION['name'] ." has left the chat session.</i><br></div>");
    fclose($fp);
 
    session_destroy();
    header("Location: index.php"); //Redirect the user
}
 
function loginForm(){
    echo'
    <div id="loginform">
    <form action="index.php" method="post">
        <p>Zadaj prezivku.</p>
        <label for="name">Meno:</label>
        <input type="text" name="name" id="name" />
        <input type="submit" name="enter" id="enter" value="Vstupit" />
    </form>
    </div>
    ';
}
 
if(isset($_POST['enter'])){
    if($_POST['name'] != ""){
        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
    }
    else{
        echo '<span class="error">Zadajte prosim v nazve</span>';
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
<div id="wrapper">
    <div id="menu">
        <p class="welcome">Vitajte, <b><?php echo $_SESSION['name']; ?></b></p>
        <p class="logout"><a id="exit" href="#">Odist</a></p>
        <div style="clear:both"></div>
    </div>    
    <div id="chatbox"><?php
    if(file_exists("log.html") && filesize("log.html") > 0){
        $handle = fopen("log.html", "r");
        $contents = fread($handle, filesize("log.html"));
        fclose($handle);
 
        echo $contents;
    }
    ?></div>
 
    <form name="message" action="">
        <input name="usermsg" type="text" id="usermsg" size="63" />
        <input name="submitmsg" type="submit"  id="submitmsg" value="Odoslat" />
    </form>
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