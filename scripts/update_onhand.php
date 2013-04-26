<?php
$store_prefix=$_COOKIE['store'];
$drugtable= $store_prefix."_Drugs";
$transactiontable= $store_prefix."_Transactions";

include_once('dbconn.php');

if (!$db) {
    echo 'ERROR: Could not connect to the database.';
} else {
    $drugid = $_POST['drugidonhand'];
    $newonhand = $_POST['onhand'];
    $today = date("Ymd");
    
        //check permissions
    $perms=$db->query("SELECT B.ID, A.BackCount FROM ".$store_prefix."_Permissions AS A INNER JOIN Employee AS B ON A.EmployeeID=B.ID WHERE B.Password = '".$_POST['empidonhand']."';");
    $drugaddperms = $perms->fetch_object();
    if($drugaddperms->BackCount!=1){
        exit("You do not have permission to manually change an on hand amount.");
    }
    
    $update=$db->query("UPDATE ".$drugtable." SET OnHand = ".$newonhand." WHERE ID = ".$drugid.";");
    if ($update){
        $insert=$db->query("INSERT INTO ".$transactiontable." (DateEntered, TransactionDate, TransactionType, Identifier, EmployeeID, Quantity, DrugID) VALUES (".$today.",".$today.",3,'ManualChange',".$drugaddperms->ID.",".$newonhand.",".$drugid.");");
        if($insert){
            echo "Quantity changed.";
        }else{
            echo "Something bad happened. Cry for less help than before.";
        }
    }else{
        echo "Something bad happened.  Cry for help.";
    }
}
?>