<?php 
    setcookie("store",$_POST['storename'],time()+60*60*24*30,"/narclog/"); 
    header("Location: http://gmapserver.grcs.local/narclog/")
?>