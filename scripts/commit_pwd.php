<?php
       
    $store_prefix=$_COOKIE['store'];
    $permission_table=$store_prefix."_Permissions";
    
    include_once('dbconn.php');
    
    if(!$db){
        exit("There was a problem with the database.");
    }else{
        if(isset($_POST['oldpwd'])){
            $op=$_POST['oldpwd'];
        }else{
            exit("Please enter your current password.");
        }
        if(isset($_POST['newpwd1'])){
            $np1=$_POST['newpwd1'];
        }else{
            exit("Please enter a new password.");
        }
        if(isset($_POST['newpwd2'])){
           $np2=$_POST['newpwd2']; 
        }else{
            exit("Please re-enter new password.");
        }
        if($np1===$np2){
            $check=$db->query("SELECT * FROM Employee WHERE Password='".$op."';");
            if($check->num_rows>0){
                $query=$db->query("UPDATE Employee SET Password='".$np1."' WHERE Password='".$op."';");
                if($query){
                    echo "<html><head><meta http-equiv=\"Refresh\" content=\"1;url=/narclog2/index.php?page=changepassword\" /></head><h2>Password Change Successful!</h2></html>";
                }else{
                    Exit("There was a database error.");
                }
            }else{
                exit("Old Password does not match.");
            }
        }else{
            exit("New passwords do not match!");
        }
    }
    
?>