<?php
$store_prefix=$_COOKIE['store'];
$drugtable= $store_prefix."_Drugs";
$transactiontable= $store_prefix."_Transactions";

include_once('dbconn.php');

if (!$db) {
    echo 'ERROR: Could not connect to the database.';
} else {
    $drugid = $_POST['drugid'];
    $newonhand = $_POST['onhand'];
    $today = date("Ymd");
    
    $update=$db->query("UPDATE ".$drugtable." SET OnHand = ".$newonhand." WHERE ID = ".$drugid.";");
    if ($update){
        $insert=$db->query("INSERT INTO ".$transactiontable." (DateEntered, TransactionDate, TransactionType, Identifier, EmployeeID, Quantity, DrugID) VALUES (".$today.",".$today.",3,'Preliminary',1,".$newonhand.",".$drugid.");");
        if($insert){
            echo "Worked.";
        }else{
            echo "Something bad happened. Cry for less help than before.";
        }
    }else{
        echo "Something bad happened.  Cry for help.";
    }
}
?>
