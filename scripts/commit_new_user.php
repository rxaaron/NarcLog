<?php

//store_prefix is here to make transition to multiple stores easier.
$store_prefix = $_COOKIE['store'];
$tablename = $store_prefix."_Permissions";

include_once('dbconn.php');

if (!$db) {
    echo 'ERROR: Could not connect to the database.';
} else {
    //check permissions
    $perms=$db->query("SELECT A.Administrator FROM ".$store_prefix."_Permissions AS A INNER JOIN Employee AS B ON A.EmployeeID=B.ID WHERE B.Password = '".$_POST['empid']."' AND A.Active=TRUE;");
    $drugaddperms = $perms->fetch_object();
    if($drugaddperms->Administrator!=1){
        exit("You do not have permission to add a new user.");
    }
            
    //verify everything was submitted, check value for allowable NULL's
    if(isset($_POST['fullname'])){
        $fullname=$_POST['fullname'];
    }else{
        exit("Please enter a name.");
    }
    if(isset($_POST['initials'])){
        $initials=$_POST['initials'];
    }else{
        exit("Please enter initials.");
    }
    if(isset($_POST['ipwd'])){
        $password=$_POST['ipwd'];
    }else{
        exit("Please enter an initial password.");
    }
    if(isset($_POST['location'])){
        $location=$_POST['location'];
    }else{
        exit("Please enter a location.");
    }
    if(isset($_POST['email'])){
        $email = $_POST['email'];
    }else{
        exit("Please enter an email.");
    }
 
    $insert=$db->query("INSERT INTO Employee (FullName, Initials, Password, Location, Email) VALUES ('".$fullname."','".$initials."','".$password."','".$location."','".$email."');");
    
    if($insert){
        echo "<html><head><meta http-equiv=\"Refresh\" content=\"1;url=/narclog/index.php?page=useradmin\" /></head><h2>User Entry Successful!</h2></html>";
    }
}
?>
