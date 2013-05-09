<?php

    $store_prefix=$_COOKIE['store'];
    $drugtable=$store_prefix."_Drugs";
    $ndctable=$store_prefix."_DrugCode";
    $transactiontable=$store_prefix."_Transactions";
    
include_once('dbconn.php');

if (!$db) {
    echo 'ERROR: Could not connect to the database.';
} else {
    //check permissions

    $perms=$db->query("SELECT B.ID, B.Initials, A.EditTransaction FROM ".$store_prefix."_Permissions AS A INNER JOIN Employee AS B ON A.EmployeeID=B.ID WHERE B.Password = '".$_POST['userid']."' AND A.Active=TRUE;");
    $drugaddperms = $perms->fetch_object();
    if($drugaddperms->EditTransaction!=1){
        exit("You do not have permission to cancel transactions.");
    }
    
    if($_POST['actionid']==1){
        $newtrans=4;
        $cmts="Rx ".$_POST['identifier']." voided by ".$drugaddperms->Initials;
    }else{
        $newtrans=6;
        $cmts="Invoice ".$_POST['identifier']." voided by ".$drugaddperms->Initials;
    }
    
    $update=$db->query("UPDATE ".$transactiontable." SET Active=False, Comments='Voided by ".$drugaddperms->Initials."' WHERE ID=".$_POST['transid'].";");
    
    if($update){
        $insert=$db->query("INSERT INTO ".$transactiontable." (DateEntered, TransactionDate, TransactionType, Identifier, EmployeeID, Quantity, NewOnHand, DrugID, Comments) VALUES (".date("Ymd").",".date("Ymd").",".$newtrans.",'Correction',".$drugaddperms->ID.",".$_POST['quantity'].",".$_POST['newonhand'].",".$_POST['drugid'].",'".$cmts."');");
        if ($insert){
            $drugfix=$db->query("UPDATE ".$drugtable." SET OnHand=".$_POST['newonhand']." WHERE ID=".$_POST['drugid'].";");
            if($drugfix){
            echo "<html><head><meta http-equiv=\"Refresh\" content=\"1;url=/narclog/index.php?page=reviewtrans\" /></head><h2>Transaction Cancelled!</h2></html>";
            }
        }
    }
}
?>
