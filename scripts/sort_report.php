<?php

    $store_prefix=$_COOKIE['store'];
    $drugtable=$store_prefix."_Drugs";
    $ndctable=$store_prefix."_DrugCode";
    $transactiontable=$store_prefix."_Transactions";
    
            include_once('dbconn.php');
            
    if (!$db){
        echo "There was a database error!";
    }else{
            
        $drugfilter=$_POST['drugfilter'];
        $drugid=$_POST['drugid'];
        $datefilter=$_POST['datefilter'];
        $fromdate=$_POST['fromdate'];
        $todate=$_POST['todate'];
        
        if($drugfilter==="false"){
            $drugquerytext="SELECT A.ID, A.BrandName AS Drug, NULL AS Indicator, A.Strength, B.Description AS Form, B.Exact, A.OnHand FROM ".$drugtable." AS A INNER JOIN DrugForm AS B ON A.FormID = B.ID WHERE (A.IsBrand=true AND A.Active=True) UNION SELECT A.ID, A.GenericName AS Drug, Concat(' (',A.BrandName,')') AS Indicator, A.Strength, B.Description AS Form, B.Exact, A.OnHand FROM ".$drugtable." AS A INNER JOIN DrugForm AS B ON A.FormID = B.ID WHERE (A.IsBrand=false AND A.Active=true) ORDER BY Drug, Strength;";
            
        }elseif($drugfilter==="true"){
            $drugquerytext="SELECT A.ID, A.BrandName AS Drug, NULL AS Indicator, A.Strength, B.Description AS Form, B.Exact, A.OnHand FROM ".$drugtable." AS A INNER JOIN DrugForm AS B ON A.FormID = B.ID WHERE (A.IsBrand=true AND A.Active=True AND A.ID=".$drugid.") UNION SELECT A.ID, A.GenericName AS Drug, Concat(' (',A.BrandName,')') AS Indicator, A.Strength, B.Description AS Form, B.Exact, A.OnHand FROM ".$drugtable." AS A INNER JOIN DrugForm AS B ON A.FormID = B.ID WHERE (A.IsBrand=false AND A.Active=true AND A.ID=".$drugid.") ORDER BY Drug, Strength;";
            $drugnamefull ="";
        }

        $drugquery=$db->query($drugquerytext);
        
        if($drugquery){
            
            echo "<h2 class=\"tacenter\">Drug Usage</h2>";
        
            echo "<table><colgroup><col style=\"width:300px;\"><col style=\"width:75px;\"><col style=\"width:100px;\"><col style=\"width:75px;\"><col style=\"width:75px;\"></colgroup>";
            echo "<tr><th>Drug Name</th><th>Strength</th><th>Form</th><th>Current Amt</th><th>Qty Used</th></tr>";
            $c=true;
            while($res=$drugquery->fetch_object()){
                $drugnamefull=$res->Drug." ".$res->Strength." ".$res->Form;
                if($datefilter==="true"){
                    $transquerytext="SELECT Quantity FROM ".$transactiontable." WHERE (DrugID=".$res->ID." AND Active=true AND TransactionType=1) AND (TransactionDate BETWEEN '".date("Ymd",(strtotime($fromdate)))."' AND '".date("Ymd",(strtotime($todate)))."');";
                }elseif($datefilter==="false"){
                    $transquerytext="SELECT Quantity FROM ".$transactiontable." WHERE (DrugID=".$res->ID." AND Active=true AND TransactionType=1);";
                }
                      
                $transactionquery=$db->query($transquerytext);
                        
                $quantity=0;
                while($quantres=$transactionquery->fetch_object()){
                     $quantity += $quantres->Quantity;
                }
                if($quantity>0){
                    echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>".$res->Drug.$res->Indicator."</td><td class=\"tacenter\">".$res->Strength."</td><td class=\"tacenter\">".$res->Form."</td><td class=\"taright\">";
                    if($res->Exact==1){
                        echo $res->OnHand;
                    }else{
                        echo number_format($res->OnHand);
                    }
                    echo "</td><td class=\"taright\">".$quantity."</td></tr>";
               }
          }
     }
}
    echo "</table>";
    echo "<h3>Filters: </h3>";
    if($drugfilter==="true"){
        echo " Drug: ".$drugnamefull."<br /><br />";
    }
    if($datefilter==="true"){
        echo " Dates: From ".$fromdate." To ".$todate;
    }
?>