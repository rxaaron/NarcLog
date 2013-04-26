<?php

    $store_prefix=$_COOKIE['store'];
    $drugtable=$store_prefix."_Drugs";
    $ndctable=$store_prefix."_DrugCode";
    
    $drugid=$_POST['drugid'];
    $actionid=$_POST['source'];
    
    include_once('dbconn.php');
    
    if($actionid=="rx"){
        //new rx transaction
     
    }elseif($actionid=="transactions"){
        
    }elseif($actionid=="invoice"){
        //new invoice transaction
        
    }elseif($actionid=="onhand"){
        //verify onhand quickly
        $drugonhand=$db->query("SELECT A.BrandName AS Drug, A.Strength, A.OnHand, B.Description AS Form, B.Exact FROM ".$drugtable." AS A INNER JOIN DrugForm AS B ON A.FormID = B.ID WHERE (A.IsBrand=True AND A.Active=True AND A.ID=".$drugid.") UNION SELECT A.GenericName AS Drug, A.Strength, A.OnHand, B.Description AS Form, B.Exact FROM ".$drugtable." AS A INNER JOIN DrugForm AS B on A.FormID = B.ID WHERE (A.IsBrand=False AND A.Active AND A.ID=".$drugid.") ORDER BY Drug, Strength;");
        if($drugonhand){
            while($resultsdrug=$drugonhand->fetch_object()){
                echo "<div class=\"tacenter\"><h2>".$resultsdrug->Drug." ".$resultsdrug->Strength." ".$resultsdrug->Form."</h2>";
                $ndc=$db->query("SELECT NDC FROM ".$ndctable." WHERE DrugID=".$drugid.";");
                if($ndc){
                    $no=1;
                    echo "NDC(s):   ";
                    while($resultsndc=$ndc->fetch_object()){
                        $prerealNDC=substr_replace($resultsndc->NDC, "-", 5, 0);
                        $realNDC=substr_replace($prerealNDC,"-",10,0);
                        if($no==1){
                            echo $realNDC;
                            $no=2;
                        }else{
                            echo "  |  ".$realNDC;
                        }
                    }
                }
                if($resultsdrug->Exact==1){
                    $onhandamount=$resultsdrug->OnHand;
                }else{
                    $onhandamount=  number_format($resultsdrug->OnHand);
                }
            echo "<h2>Quantity On Hand:  ".$onhandamount."</h2></div>";
            }
            echo "<br /><hr><br /><h3>Manually update amount.</h3>";
            echo "<form name=\"updateonhand\" id=\"updateonhand\" action=\"scripts/update_onhand.php\" method=\"POST\" autocomplete=\"off\">";
            echo "<input type=\"hidden\" name=\"drugidonhand\" value=\"".$drugid."\" />";
            echo "<table name=\"onhandtable\" id=\"onhandtable\">";
            echo "<colgroup><col name=\"label\" style=\"width:200px;\"><col name=\"boxes\" style=\"width:500px;\"></colgroup>";
            echo "<tr><td>New On Hand Amount:</td><td><input type=\"text\" name=\"onhand\" autocomplete=\"off\" /></td></tr>";
            echo "<tr><td>Pasword:</td><td><input type=\"password\" name=\"empidonhand\" autocomplete=\"off\" /></td></tr>";
            echo "</table>";
            echo "<input type=\"submit\" name=\"gobabygo\" value=\"Update On Hand Amount\" />";
            echo "</form>";
        }
    }elseif($actionid=="edit"){
        
//show edit form for specific drug
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