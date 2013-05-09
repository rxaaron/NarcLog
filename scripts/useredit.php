<?php

    $store_prefix=$_COOKIE['store'];
    $permission_table=$store_prefix."_Permissions";
    
include_once('dbconn.php');

if (!$db) {
    echo 'ERROR: Could not connect to the database.';
} else {
    $permsquery=$db->query("SELECT ID, DrugAdd, DrugEdit, BackCount, EnterRx, EnterInvoice, EditTransaction, HistoryReports, AdminReports, RPh, Administrator, Active FROM ".$permission_table." WHERE EmployeeID=".$_POST['userid'].";");
    if($permsquery->num_rows>0){
        echo "<form name=\"userprop\" id=\"userprop\" action=\"scripts/commit_user_change.php\" method=\"POST\"><table><tr><th>Ability</th><th>Allow?</th></tr>";

        $c=true;
        while($res=$permsquery->fetch_object()){
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>Add Drug</td><td class=\"tacenter\">";
            if($res->DrugAdd==1){
                echo "<input type=\"checkbox\" name=\"drugadd\"  checked=\"checked\" />";
            }else{
                echo "<input type=\"checkbox\" name=\"drugadd\" />";
            }
            echo "</td></tr>";
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>Edit Drug</td><td class=\"tacenter\">";
            if($res->DrugEdit==1){
                echo "<input type=\"checkbox\" name=\"drugedit\"  checked=\"checked\" />";
            }else{
                echo "<input type=\"checkbox\" name=\"drugedit\" />";
            }
            echo "</td></tr>";
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>Verify Backcount</td><td class=\"tacenter\">";
            if($res->BackCount==1){
                echo "<input type=\"checkbox\" name=\"backcount\"  checked=\"checked\" />";
            }else{
                echo "<input type=\"checkbox\" name=\"backcount\" />";
            }
            echo "</td></tr>";
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>Enter New Rx</td><td class=\"tacenter\">";
            if($res->EnterRx==1){
                echo "<input type=\"checkbox\" name=\"enterrx\"  checked=\"checked\" />";
            }else{
                echo "<input type=\"checkbox\" name=\"enterrx\" />";
            }
            echo "</td></tr>";
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>Enter New Invoice</td><td class=\"tacenter\">";
            if($res->EnterInvoice==1){
                echo "<input type=\"checkbox\" name=\"enterinvoice\"  checked=\"checked\" />";
            }else{
                echo "<input type=\"checkbox\" name=\"enterinvoice\" />";
            }
            echo "</td></tr>";
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>Void Transaction</td><td class=\"tacenter\">";
            if($res->EditTransaction==1){
                echo "<input type=\"checkbox\" name=\"edittransaction\"  checked=\"checked\" />";
            }else{
                echo "<input type=\"checkbox\" name=\"edittransaction\" />";
            }
            echo "</td></tr>";
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>History Reporting</td><td class=\"tacenter\">";
            if($res->HistoryReports==1){
                echo "<input type=\"checkbox\" name=\"historyreports\"  checked=\"checked\" />";
            }else{
                echo "<input type=\"checkbox\" name=\"historyreports\" />";
            }
            echo "</td></tr>";
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>Administration Reporting</td><td class=\"tacenter\">";
            if($res->AdminReports==1){
                echo "<input type=\"checkbox\" name=\"adminreports\"  checked=\"checked\" />";
            }else{
                echo "<input type=\"checkbox\" name=\"adminreports\" />";
            }
            echo "</td></tr>";
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>RPh</td><td class=\"tacenter\">";
            if($res->RPh==1){
                echo "<input type=\"checkbox\" name=\"rph\"  checked=\"checked\" />";
            }else{
                echo "<input type=\"checkbox\" name=\"rph\" />";
            }
            echo "</td></tr>";
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>Administrator</td><td class=\"tacenter\">";
            if($res->Administrator==1){
                echo "<input type=\"checkbox\" name=\"administrator\"  checked=\"checked\" />";
            }else{
                echo "<input type=\"checkbox\" name=\"administrator\" />";
            }
            echo "</td></tr>";
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>Active User</td><td class=\"tacenter\">";
            if($res->Active==1){
                echo "<input type=\"checkbox\" name=\"active\"  checked=\"checked\" />";
            }else{
                echo "<input type=\"checkbox\" name=\"active\" />";
            }
            echo "</td></tr>";
            echo "<input type=\"hidden\" name=\"id\" value=\"".$res->ID."\" />";
        }
        echo "</table><br />Password:<input type=\"password\" name=\"userid\" /><br /><br /><input type=\"submit\" name=\"gobabygo\" value=\"Submit Changes\" />";
        echo "</form>";
    }else{
        echo "<form name=\"userprop\" id=\"userprop\" action=\"scripts/create_user_perms.php\" method=\"POST\"><table><tr><th>Ability</th><th>Allow?</th></tr>";

        $c=true;
        
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>Add Drug</td><td class=\"tacenter\">";

                echo "<input type=\"checkbox\" name=\"drugadd\" />";
  
            echo "</td></tr>";
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>Edit Drug</td><td class=\"tacenter\">";

                echo "<input type=\"checkbox\" name=\"drugedit\" />";

            echo "</td></tr>";
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>Verify Backcount</td><td class=\"tacenter\">";

                echo "<input type=\"checkbox\" name=\"backcount\" />";
     
            echo "</td></tr>";
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>Enter New Rx</td><td class=\"tacenter\">";

                echo "<input type=\"checkbox\" name=\"enterrx\" />";
         
            echo "</td></tr>";
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>Enter New Invoice</td><td class=\"tacenter\">";

                echo "<input type=\"checkbox\" name=\"enterinvoice\" />";
    
            echo "</td></tr>";
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>Void Transaction</td><td class=\"tacenter\">";

                echo "<input type=\"checkbox\" name=\"edittransaction\" />";
            
            echo "</td></tr>";
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>History Reporting</td><td class=\"tacenter\">";

                echo "<input type=\"checkbox\" name=\"historyreports\" />";
    
            echo "</td></tr>";
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>Administration Reporting</td><td class=\"tacenter\">";

                echo "<input type=\"checkbox\" name=\"adminreports\" />";
          
            echo "</td></tr>";
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>RPh</td><td class=\"tacenter\">";

                echo "<input type=\"checkbox\" name=\"rph\" />";
            
            echo "</td></tr>";
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>Administrator</td><td class=\"tacenter\">";

                echo "<input type=\"checkbox\" name=\"administrator\" />";
            
            echo "</td></tr>";
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>Active User</td><td class=\"tacenter\">";

                echo "<input type=\"checkbox\" name=\"active\" />";
           
            echo "</td></tr>";
            echo "<input type=\"hidden\" name=\"id\" value=\"".$_POST['userid']."\" />";
        
        echo "</table><br />Password:<input type=\"password\" name=\"userid\" /><br /><br /><input type=\"submit\" name=\"gobabygo\" value=\"Submit Changes\" />";
        echo "</form>";
    }
}
?>
