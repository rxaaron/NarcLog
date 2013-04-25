<?php

    $store_prefix=$_COOKIE['store'];
    $drugtable=$store_prefix."_Drugs";
    $ndctable=$store_prefix."_DrugCode";
    
include_once('dbconn.php');

if (!$db) {
    echo 'ERROR: Could not connect to the database.';
} else {
    $drugs=$db->query("SELECT A.ID, A.BrandName AS Drug, A.Strength, A.OnHand, B.Description AS Form, B.Exact FROM ".$drugtable." AS A INNER JOIN DrugForm AS B ON A.FormID = B.ID WHERE (A.IsBrand=True AND A.Active=True) UNION SELECT A.ID, A.GenericName AS Drug, A.Strength, A.OnHand, B.Description AS Form, B.Exact FROM ".$drugtable." AS A INNER JOIN DrugForm AS B on A.FormID = B.ID WHERE (A.IsBrand=False AND A.Active) ORDER BY Drug, Strength;");
    if($drugs){
        echo "<table><colgroup><col class=\"listdrug\"><col class=\"liststrength\"><col class=\"listform\"><col class=\"listndc\"><col class=\"listamount\"></colgroup>";
        echo "<tr><th>Drug</th><th>Strength</th><th>Form</th><th>NDC(s)</th><th>On Hand</th></tr>";
        $c=true;
        while($dresults=$drugs->fetch_object()){
            if($dresults->Exact==1){
                $onhandamount=$dresults->OnHand;
            }else{
                $onhandamount=  number_format($dresults->OnHand);
            }
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td>".$dresults->Drug."</td><td class=\"tacenter\">".$dresults->Strength."</td><td class=\"tacenter\">".$dresults->Form."</td><td class=\"tacenter\">";
            $ndcs=$db->query("SELECT NDC FROM ".$ndctable." WHERE DrugID=".$dresults->ID." AND Active=True;");
            if($ndcs){
                while($rndc=$ndcs->fetch_object()){
                    $ndashc1=substr_replace($rndc->NDC, "-", 5, 0);
                    $ndashc=substr_replace($ndashc1, "-", 10, 0);
                    echo " ".$ndashc." ";
                }
            }
            echo "</td><td class=\"taright\">".$onhandamount."</td></tr>";
        }
        echo "</table>";
    }
}
?>
