<?php

    $store_prefix=$_COOKIE['store'];
    $ndctable=$store_prefix."_DrugCode";
 
include_once('dbconn.php');

if (!$db) {
    echo 'ERROR: Could not connect to the database.';
} else {
        //check permissions
    $perms=$db->query("SELECT A.DrugEdit FROM ".$store_prefix."_Permissions AS A INNER JOIN Employee AS B ON A.EmployeeID=B.ID WHERE B.Password = '".$_POST['empidadd']."';");
    $drugaddperms = $perms->fetch_object();
    if($drugaddperms->DrugEdit!=1){
        exit("You do not have permission to add a new ndc.");
    }
    $insert=$db->query("INSERT INTO ".$ndctable." (DrugID, NDC) VALUES (".$_POST['ndcdrugid'].",'".$_POST['newndc']."');");
    if($insert){
                echo "<html><head><meta http-equiv=\"Refresh\" content=\"1;url=/narclog/\" /></head><h2>NDC Add Successful!</h2></html>";
    }
}
?>
