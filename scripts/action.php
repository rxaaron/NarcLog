<?php

    $store_prefix=$_COOKIE['store'];
    $drugtable=$store_prefix."_Drugs";
    $ndctable=$store_prefix."_DrugCode";
    $transactiontable=$store_prefix."_Transactions";
    
    $drugid=$_POST['drugid'];
    $actionid=$_POST['source'];
    
    include_once('dbconn.php');
    
    if($actionid=="rx"){
        //new rx transaction
        include('drug_header.php');
        echo "<br /><hr><br /><h3>Dispense New Presription</h3>";
        echo "<form name=\"newrx\" id=\"newrx\" action=\"scripts/commit_rx.php\" method=\"POST\" autocomplete=\"off\">";
        echo "<input type=\"hidden\" name=\"oldonhand\" value=\"".$resultsdrug->OnHand."\" />";
        echo "<input type=\"hidden\" name=\"drugidnewrx\" value=\"".$drugid."\" />";
        echo "<table name=\"newrxtable\" id=\"newrxtable\">";
        echo "<colgroup><col name=\"label\" style=\"width:200px;\"><col name=\"boxes\" style=\"width:500px;\"></colgroup>";
        echo "<tr><td>Dispense Date:</td><td><input type=\"text\" name=\"dispensedate\" autocomplete=\"off\" value=\"".date("m/d/Y")."\" /></td></tr>";
        echo "<tr><td>Rx Number:</td><td><input type =\"text\" name=\"rxnumber\" autocomplete=\"off\" /></td></tr>";
        echo "<tr><td>Quantity Dispensed:</td><td><input type =\"text\" name=\"qtydispensed\" autocomplete=\"off\" /></td></tr>";
        echo "<tr><td>Quantity Remaining:</td><td><input type =\"text\" name=\"qtyremaining\" autocomplete=\"off\" /></td></tr>";
        echo "<tr><td>Password:</td><td><input type =\"password\" name=\"passwordnewrx\" autocomplete=\"off\" /></td></tr>";
        echo "</table>";
        echo "<input type=\"submit\" name=\"gobabygo\" value=\"Enter Transaction\" />";
        echo "</form>";
     
    }elseif($actionid=="transactions"){
        include('drug_header.php');
                        if($resultsdrug->Exact==1){
                    $onhandamount=$resultsdrug->OnHand;
                }else{
                    $onhandamount=  number_format($resultsdrug->OnHand);
                }
            echo "<div class=\"tacenter\"><h2>Quantity On Hand:  ".$onhandamount."</h2></div>";
        $transactionquery=$db->query("SELECT A.ID, A.DateEntered, A.TransactionDate, B.ID AS Transtype, B.Action, B.Description AS Transaction, A.Identifier, C.Initials AS Employee, A.Quantity, A.NewOnHand, D.ID AS DrugID, E.Exact, A.Comments, A.Active AS NotVoid FROM ".$transactiontable." AS A INNER JOIN TransactionType AS B ON A.TransactionType = B.ID INNER JOIN Employee AS C ON A.EmployeeID = C.ID INNER JOIN .".$drugtable." AS D ON A.DrugID = D.ID INNER JOIN DrugForm AS E ON D.FormID = E.ID WHERE A.DrugID=".$drugid." ORDER BY A.TransactionDate DESC, A.ID DESC;");
        if($transactionquery->num_rows>0){
            echo "<br /><hr><br /><table><colgroup> <col name=\"edit\" style=\"width:50px;\"><col name=\"dateent\" style=\"width:100px;\"><col name=\"datetrans\" style=\"width:120px;\"><col name=\"ttype\" style=\"width:120px;\"><col name=\"ident\" style=\"width:105px;\"><col name=\"emp\" style=\"width:75px;\"><col name=\"quant\" style=\"width:70px\"><col name=\"newon\" style=\"width:160px;\"><col name=\"comments\"></colgroup><tr><th>&nbsp;</th><th class=\"tacenter\">Entry Date</th><th class=\"tacenter\">Transaction Date</th><th class=\"tacenter\">Type</th><th class=\"tacenter\">Rx/Invoice #</th><th class=\"tacenter\">Employee</th><th class=\"tacenter\">Quantity</th><th class=\"tacenter\">Amt After Transaction</th><th>Comments</th></tr>";
            $c=true;
            while($trans=$transactionquery->fetch_object()){
                
                if($trans->Action==2){
                    $transclass=" drugreceive";
                }elseif($trans->Action==3){
                    $transclass=" rphoverride";
                }else{
                    $transclass="";
                }
                
                if($trans->Exact==1){
                    $quant=$trans->Quantity;
                    $noh=$trans->NewOnHand;
                }else{
                    $quant=number_format($trans->Quantity);
                    $noh=number_format($trans->NewOnHand);
                }
                
                if($trans->NotVoid==0){
                    $void=" voided";
                    $cancel="";
                }elseif($trans->Transtype==3 OR $trans->Transtype==5 or $trans->Transtype==4 or $trans->Transtype==6){
                    $void="";
                    $cancel="";
                }else{
                    $void="";
                    $cancel="<a href=\"#\" onclick=\"return entrydetail(".$trans->ID.",".$trans->Action.",".$quant.",".$trans->DrugID.",".$trans->Identifier.",".$trans->NotVoid.");\">Cancel</a>";
                }
                
                echo "<tr ".(($c=!$c)?'class="even':'class="odd').$void."\"><td>".$cancel."</td><td class=\"tacenter\">".date("m/d/Y",strtotime($trans->DateEntered))."</td><td class=\"tacenter\">".date("m/d/Y",strtotime($trans->TransactionDate))."</td><td class=\"tacenter".$transclass."\">".$trans->Transaction."</td><td class=\"tacenter\">".$trans->Identifier."</td><td class=\"tacenter\">".$trans->Employee."</td><td class=\"tacenter".$transclass."\">".$quant."</td><td class=\"tacenter\">".$noh."</td><td>".$trans->Comments."</td></tr>";              
            }
            echo "</table><hr><div id=\"transdetail\"></div>";
        }else{
            exit("<br /><br />There are no transactions for this drug.");
        }
    }elseif($actionid=="invoice"){
        //new invoice transaction
        include('drug_header.php');
        echo "<br /><hr><br /><h3>Recieve Order</h3>";
        echo "<form name=\"newinvoice\" id=\"newinvoice\" action=\"scripts/commit_invoice.php\" method=\"POST\" autocomplete=\"off\">";
        echo "<input type=\"hidden\" name=\"oldonhand\" value=\"".$resultsdrug->OnHand."\" />";
        echo "<input type=\"hidden\" name=\"drugidnewrx\" value=\"".$drugid."\" />";
        echo "<table name=\"newinvoicetable\" id=\"newinvoicetable\">";
        echo "<colgroup><col name=\"label\" style=\"width:200px;\"><col name=\"boxes\" style=\"width:500px;\"></colgroup>";
        echo "<tr><td>Receive Date:</td><td><input type=\"text\" name=\"dispensedate\" autocomplete=\"off\" value=\"".date("m/d/Y")."\" /></td></tr>";
        echo "<tr><td>Invoice Number:</td><td><input type =\"text\" name=\"rxnumber\" autocomplete=\"off\" /></td></tr>";
        echo "<tr><td>Quantity Received:</td><td><input type =\"text\" name=\"qtydispensed\" autocomplete=\"off\" /></td></tr>";
        echo "<tr><td>Quantity Remaining:</td><td><input type =\"text\" name=\"qtyremaining\" autocomplete=\"off\" /></td></tr>";
        echo "<tr><td>Password:</td><td><input type =\"password\" name=\"passwordnewrx\" autocomplete=\"off\" /></td></tr>";
        echo "</table>";
        echo "<input type=\"submit\" name=\"gobabygo\" value=\"Enter Transaction\" />";
        echo "</form>";
     
    }elseif($actionid=="onhand"){
        //verify onhand quickly
            include('drug_header.php');
                if($resultsdrug->Exact==1){
                    $onhandamount=$resultsdrug->OnHand;
                }else{
                    $onhandamount=  number_format($resultsdrug->OnHand);
                }
            echo "<div class=\"tacenter\"><h2>Quantity On Hand:  ".$onhandamount."</h2></div>";
            
            echo "<br /><hr><br /><h3>Manually update amount.</h3>";
            echo "<form name=\"updateonhand\" id=\"updateonhand\" action=\"scripts/update_onhand.php\" method=\"POST\" autocomplete=\"off\">";
            echo "<input type=\"hidden\" name=\"drugidonhand\" value=\"".$drugid."\" />";
            echo "<table name=\"onhandtable\" id=\"onhandtable\">";
            echo "<colgroup><col name=\"label\" style=\"width:200px;\"><col name=\"boxes\" style=\"width:500px;\"></colgroup>";
            echo "<tr><td>New On Hand Amount:</td><td><input type=\"text\" name=\"onhand\" autocomplete=\"off\" /></td></tr>";
            echo "<tr><td>Comments:</td><td><textarea name=\"comments\" columns=\"30\" rows=\"5\"></textarea></td></tr>";
            echo "<tr><td>Pasword:</td><td><input type=\"password\" name=\"empidonhand\" autocomplete=\"off\" /></td></tr>";
            echo "</table>";
            echo "<input type=\"submit\" name=\"gobabygo\" value=\"Update On Hand Amount\" />";
            echo "</form>";

    }elseif($actionid=="edit"){
        
//show edit form for specific drug
        include('drug_header.php');
        echo "<h2>Drug Properties</h2>";
        $drugedit=$db->query("SELECT BrandName, GenericName, Strength, IsBrand, FormID, Comments, Active FROM ".$drugtable." WHERE ID=".$drugid.";");
        while($editr=$drugedit->fetch_object()){
            echo "<form name=\"editdrug\" id=\"editdrug\" action=\"scripts/commit_edit_drug.php\" method=\"POST\" autocomplete=\"off\">";
            echo "<table name=\"editdrugtable\" id=\"newdrugtable\">";
            echo "<colgroup><col name=\"label\" style=\"width:200px;\"><col name=\"boxes\" style=\"width:500px;\"></colgroup>";
            echo "<tr><td>Drug ID:</td><td><input type=\"text\" name=\"drugid\" value=\"".$drugid."\" readonly /></td></tr>";
            echo "<tr><td>Brand Name:</td><td><input type=\"text\" name=\"brand\" autocomplete=\"off\" value=\"".$editr->BrandName."\"/></td></tr>";
            echo "<tr><td>Generic Name:</td><td><input type=\"text\" name=\"generic\" autocomplete=\"off\" value=\"".$editr->GenericName."\" /></td></tr>";
            echo "<tr><td>Strength:</td><td><input type=\"text\" name=\"strength\" autocomplete=\"off\" value=\"".$editr->Strength."\" /></td></tr>";
            if($editr->IsBrand==1){
                echo "<tr><td>Is Brand?</td><td><input type=\"checkbox\" name=\"isbrand\"checked /></td></tr>";
            }else{
                echo "<tr><td>Is Brand?</td><td><input type=\"checkbox\" name=\"isbrand\" /></td></tr>";
            }
            echo "<tr><td>Form:</td><td><select name=\"formid\" id=\"formid\">";
            //list drug forms, choose appropriate one selected.
            $forms=$db->query("SELECT ID, Description FROM DrugForm WHERE Active=true ORDER BY Description;");
            while($formsr=$forms->fetch_object()){
                if($formsr->ID==$editr->FormID){
                    echo "<option value=\"".$formsr->ID."\" label=\"".$formsr->Description."\" selected>".$formsr->Description."</option>";
                }else{
                    echo "<option value=\"".$formsr->ID."\" label=\"".$formsr->Description."\">".$formsr->Description."</option>";
                }
            }
            echo "</select></td></tr>";
            echo "<tr><td>Comments:</td><td><textarea name=\"comments\" columns=\"30\" rows=\"5\">".$editr->Comments."</textarea></td></tr>";
            echo "<tr><td>Password:</td><td><input type=\"password\" name=\"empid\" autocomplete=\"off\" /></td></tr>";
            echo "</table>";
            echo "<input type=\"submit\" name=\"gobaby\" value=\"Submit Drug Edit\" /></form>";

            //drug edit done, start ndc delete
            echo "<br /><hr><h2>Delete Attached NDC's</h2>";
            $ndcs=$db->query("SELECT ID, NDC From ".$ndctable." WHERE DrugID=".$drugid." AND Active=True;");
            echo "<form name=\"editndc\" id=\"editndc\" action=\"scripts/delete_ndc.php\" method=\"POST\" autocomplete=\"off\">";
            echo "<table><colgroup><col name=\"label\" style=\"width:200px;\"><col name=\"boxes\" style=\"width:500px;\"></colgroup>";
            echo "<tr><td>NDC's:</td><td><select name=\"ndcid\" id=\"ndcid\" size=\"5\">";
                while($ndcr=$ndcs->fetch_object()){
                    $prerealNDC=substr_replace($ndcr->NDC,"-",5,0);
                    $realNDC=substr_replace($prerealNDC,"-",10,0);
                    echo "<option value=\"".$ndcr->ID."\" label=\"".$realNDC."\">".$realNDC."</option>";
                }
            echo "</select></td></tr><tr><td>Password:</td><td><input type=\"password\" name=\"empidndc\" autocomplete=\"off\" /></td></tr></table>";
            echo "<br /><input type=\"submit\" name=\"gobabygo\" value=\"Delete Selected NDC\" /></form>";
            
            //ndc delete done, start ndc add
            echo "<br /><hr><h2>Add NDC to Drug</h2>";
            echo "<form name=\"addndc\" id=\"addndc\" action=\"scripts/commit_ndc.php\" method=\"POST\" autocomplete=\"off\">";
            echo "<input type=\"hidden\" name=\"ndcdrugid\" value=\"".$drugid."\" />";
            echo "<table name=\"ndctable\" id=\"ndctable\">";
            echo "<colgroup><col name=\"label\" style=\"width:200px;\"><col name=\"boxes\" style=\"width:500px;\"></colgroup>";
            echo "<tr><td>New NDC:</td><td><input type=\"text\" name=\"newndc\" autocomplete=\"off\" /></td></tr>";
            echo "<tr><td>Pasword:</td><td><input type=\"password\" name=\"empidadd\" autocomplete=\"off\" /></td></tr>";
            echo "</table>";
            echo "<input type=\"submit\" name=\"gobabygo\" value=\"Add NDC\" />";
            echo "</form>";
            
            if($editr->Active==1){
                //delete drug section!!
                echo "<br /><hr><h2 style=\"color:#ff0000;\">Delete Drug</h2>";
                echo "<form name=\"deletedrug\" id=\"deletedrug\" action=\"scripts/delete_drug.php\" method=\"POST\" autocomplete=\"off\">";
                echo "<input type=\"hidden\" name=\"deletedrugid\" value=\"".$drugid."\" /><br />";
                echo "Password: <input type=\"password\" name=\"empiddel\" autocomplete=\"off\" /><br />";
                echo "<h3 style=\"color:#ff0000;\">Are you sure you want to do this?</h3>";
                echo "<input type=\"submit\" name=\"ohnowhy\" value=\"Delete Drug\" />";
                echo "</form>";
            }else{
                echo "<br /><hr><h2 style=\"color:#ff0000;\">Reactivate Drug</h2>";
                echo "<form name=\"activedrug\" id=\"activedrug\" action=\"scripts/reactivate_drug.php\" method=\"POST\" autocomplete=\"off\">";
                echo "<input type=\"hidden\" name=\"activedrugid\" value=\"".$drugid."\" /><br />";
                echo "Password: <input type=\"password\" name=\"empidact\" autocomplete=\"off\" /><br />";
                echo "<h3 style=\"color:#ff0000;\">Are you sure you want to do this?</h3>";
                echo "<input type=\"submit\" name=\"ohnowhy\" value=\"Reactivate Drug\" />";
                echo "</form>"; 
            }
        }
    }else{
        echo "Somehow we still didn't match.";
    }
 
?>