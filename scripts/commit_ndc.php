<?php

include_once('dbconn.php');

if (!$db) {
    echo 'ERROR: Could not connect to the database.';
} else {
    $insert=$db->query("INSERT INTO DrugCode (DrugID, NDC) VALUES (".$_POST['drugid'].",'".$_POST['newndc']."');");
    if($insert){
        echo "NDC added.";
    }
}
?>
