<?php

    $store_prefix=$_COOKIE['store'];
    $ndctable=$store_prefix."_DrugCode";
 
include_once('dbconn.php');

if (!$db) {
    echo 'ERROR: Could not connect to the database.';
} else {
    $insert=$db->query("INSERT INTO ".$ndctable." (DrugID, NDC) VALUES (".$_POST['drugid'].",'".$_POST['newndc']."');");
    if($insert){
        echo "NDC added.";
    }
}
?>
