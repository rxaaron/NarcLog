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

    $perms=$db->query("SELECT B.ID, A.EnterInvoice FROM ".$store_prefix."_Permissions AS A INNER JOIN Employee AS B ON A.EmployeeID=B.ID WHERE B.Password = '".$_POST['passwordnewrx']."' AND A.Active=TRUE;");
    $drugaddperms = $perms->fetch_object();
    if($drugaddperms->EnterInvoice!=1){
        exit("You do not have permission to add a new drug.");
    }
    
    $drugid=$_POST['drugidnewrx'];
    $empid=$drugaddperms->ID;
    $oldonhand=$_POST['oldonhand'];
    
    if(isset($_POST['dispensedate'])){
        $dispense=date("Ymd",strtotime($_POST['dispensedate']));         }else{
        exit("Please enter a Receive Date.");
    }
    if(isset($_POST['rxnumber'])){
        $rxnumber=$_POST['rxnumber'];
    }else{
        exit("Please enter an Invoice Number.");
    }
    if(isset($_POST['qtydispensed'])){
        $qtydisp=$_POST['qtydispensed'];
    }else{
        exit("Please enter a received quantity.");
    }
    if(isset($_POST['qtyremaining'])){
        $qtyrem=$_POST['qtyremaining'];
    }else{
        exit("Please enter a quantity remaining.");
    }
    $middleonhand = $oldonhand+$qtydisp;
    $rphchange = $qtyrem-$middleonhand;
    
        if(isset($_POST['override'])){
        $supperms=$db->query("SELECT B.ID, A.RPh FROM ".$store_prefix."_Permissions AS A INNER JOIN Employee AS B ON A.EmployeeID=B.ID WHERE B.Password = '".$_POST['supervisor']."';");
        $supres=$supperms->fetch_object();
        if ($supres->RPh!=1){
            exit("Supervisor password is not correct.");
        }else{
            $superid=$supres->ID;
            $newtrans=$db->query("INSERT INTO ".$transactiontable." (DateEntered, TransactionDate, TransactionType, Identifier, EmployeeID, Quantity, NewOnHand, DrugID) VALUES (".date("Ymd").",".$dispense.",2,'".$rxnumber."',".$empid.",".$qtydisp.",".$middleonhand.",".$drugid.");");
            if($newtrans){
                $retrans=$db->query("INSERT INTO ".$transactiontable." (DateEntered, TransactionDate, TransactionType, Identifier, EmployeeID, Quantity, NewOnHand, DrugID,Comments ) VALUES (".date("Ymd").",".$dispense.",3,'".$rxnumber."',".$superid.",".$rphchange.",".$qtyrem.",".$drugid.",'".$_POST['comments']."');"); 
                if(!$retrans){
                    echo "Why did that break?!?!?";
                }
            }
            $updatedrug=$db->query("UPDATE ".$drugtable." SET OnHand=".$qtyrem." WHERE ID=".$drugid.";");
            if($updatedrug){
                        exit("<html><head><meta http-equiv=\"Refresh\" content=\"1;url=/narclog/\" /></head><h2>Invoice Entry Successful!</h2></html>");
            }
        }
    }

    if(($oldonhand+$qtydisp)==$qtyrem){
        //back count matches, proceed with transaction.
        $newtrans=$db->query("INSERT INTO ".$transactiontable." (DateEntered, TransactionDate, TransactionType, Identifier, EmployeeID, Quantity, NewOnHand, DrugID) VALUES (".date("Ymd").",".$dispense.",2,'".$rxnumber."',".$empid.",".$qtydisp.",".$qtyrem.",".$drugid.");");
        if($newtrans){

            $updatedrug=$db->query("UPDATE ".$drugtable." SET OnHand=".$qtyrem." WHERE ID=".$drugid.";");
            if($updatedrug){
                        echo "<html><head><meta http-equiv=\"Refresh\" content=\"1;url=/narclog/\" /></head><h2>Invoice Entry Successful!</h2></html>";
            }
        }
    }else{
        //back count does not match!!!
        include('drug_header.php');
        echo "<br /><hr><br /><h2 style=\"color:#ff0000;\">Quantities Do Not Match</h2><h3>Please verify NDC's match and back count is correct.<br />Expected quantity remaining was: ".($oldonhand+$qtydisp)."</h3>";
        echo "<form name=\"newinvoice\" id=\"newinvoice\" action=\"commit_invoice.php\" method=\"POST\" autocomplete=\"off\">";
        echo "<input type=\"hidden\" name=\"oldonhand\" value=\"".$resultsdrug->OnHand."\" />";
        echo "<input type=\"hidden\" name=\"drugidnewrx\" value=\"".$drugid."\" />";
        echo "<table name=\"newinvoicetable\" id=\"newinovoicetable\">";
        echo "<colgroup><col name=\"label\" style=\"width:200px;\"><col name=\"boxes\" style=\"width:500px;\"></colgroup>";
        echo "<tr><td>Entry Date:</td><td><input type=\"text\" name=\"entrydate\" value=\"".date("Ymd")."\" readonly />";
        echo "<tr><td>Receive Date:</td><td><input type=\"text\" name=\"dispensedate\" autocomplete=\"off\" value=\"".$dispense."\" /></td></tr>";
        echo "<tr><td>Invoice Number:</td><td><input type =\"text\" name=\"rxnumber\" autocomplete=\"off\" value=\"".$rxnumber."\" /></td></tr>";
        echo "<tr><td>Quantity Received:</td><td><input type =\"text\" name=\"qtydispensed\" autocomplete=\"off\" value=\"".$qtydisp."\" /></td></tr>";
        echo "<tr><td>Quantity Remaining:</td><td><input type =\"text\" name=\"qtyremaining\" autocomplete=\"off\" value=\"".$qtyrem."\" /></td></tr>";
        echo "<tr><td>Password:</td><td><input type =\"password\" name=\"passwordnewrx\" autocomplete=\"off\" /></td></tr>";
        echo "<tr><td>Override?:</td><td><input type=\"checkbox\" name=\"override\" /></td></tr>";
        echo "<tr><td>Supervisor Password:</td><td><input type =\"password\" name=\"supervisor\" autocomplete=\"off\" /></td></tr>";
        echo "<tr><td>Supervisor Comments:</td><td><textarea name=\"comments\" columns=\"30\" rows=\"5\"></textarea></td></tr>";
        echo "</table>";
        echo "<input type=\"submit\" name=\"gobabygo\" value=\"Enter Transaction\" />";
        echo "</form>";
     
    }
}
?>
