<?php

    $store_prefix=$_COOKIE['store'];
    $ndctable=$store_prefix."_DrugCode";
 
include_once('dbconn.php');

if (!$db) {
    echo 'ERROR: Could not connect to the database.';
} else {
            //check permissions
    $perms=$db->query("SELECT A.DrugEdit FROM ".$store_prefix."_Permissions AS A INNER JOIN Employee AS B ON A.EmployeeID=B.ID WHERE B.Password = '".$_POST['empidndc']."' AND A.Active=TRUE;");
    $drugaddperms = $perms->fetch_object();
    if($drugaddperms->DrugEdit!=1){
        exit("You do not have permission to delete an ndc.");
    }
    $update=$db->query("UPDATE ".$ndctable." SET Active=False WHERE ID=".$_POST['ndcid'].";");
    if($update){
                echo "<html><head><meta http-equiv=\"Refresh\" content=\"1;url=/narclog/index.php?page=drugadmin\" /></head><h2>NDC Deleted.</h2></html>";
    }
    
}
?>
