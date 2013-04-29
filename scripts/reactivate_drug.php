<?php

//store_prefix is here to make transition to multiple stores easier.
$store_prefix = $_COOKIE['store'];
$tablename = $store_prefix."_Drugs";

include_once('dbconn.php');

if (!$db) {
    echo 'ERROR: Could not connect to the database.';
} else {
    //check permissions
    $perms=$db->query("SELECT A.DrugEdit FROM ".$store_prefix."_Permissions AS A INNER JOIN Employee AS B ON A.EmployeeID=B.ID WHERE B.Password = '".$_POST['empidact']."';");
    $drugaddperms = $perms->fetch_object();
    if($drugaddperms->DrugEdit!=1){
        exit("You do not have permission to reactivate a drug.");
    }
        
$update=$db->query("UPDATE ".$tablename." SET Active=True WHERE ID=".$_POST['activedrugid'].";");
    
    if($update){
                echo "<html><head><meta http-equiv=\"Refresh\" content=\"1;url=/narclog/\" /></head><h2>Drug Reactivated!</h2></html>";
    }
}
?>
