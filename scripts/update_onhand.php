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
    $comments=$_POST['comments'];
    
        //check permissions
    $perms=$db->query("SELECT B.ID, A.BackCount FROM ".$store_prefix."_Permissions AS A INNER JOIN Employee AS B ON A.EmployeeID=B.ID WHERE B.Password = '".$_POST['empidonhand']."';");
    $drugaddperms = $perms->fetch_object();
    if($drugaddperms->BackCount!=1){
        exit("You do not have permission to manually change an on hand amount.");
    }
    
    $update=$db->query("UPDATE ".$drugtable." SET OnHand = ".$newonhand." WHERE ID = ".$drugid.";");
    if ($update){
        $insert=$db->query("INSERT INTO ".$transactiontable." (DateEntered, TransactionDate, TransactionType, Identifier, EmployeeID, Quantity, NewOnHand, DrugID, Comments) VALUES (".$today.",".$today.",3,'ManualChange',".$drugaddperms->ID.",".$newonhand.",".$newonhand.",".$drugid.",'".$comments."');");
        if($insert){
                    echo "<html><head><meta http-equiv=\"Refresh\" content=\"1;url=/narclog/\" /></head><h2>Quantity Updated!</h2></html>";
        }else{
            echo "Something bad happened. Cry for less help than before.";
        }
    }else{
        echo "Something bad happened.  Cry for help.";
    }
}
?>
