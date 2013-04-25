<?php

    $store_prefix=$_COOKIE['store'];
    $drugtable=$store_prefix."_Drugs";
    $ndctable=$store_prefix."_DrugCode";
    
    $drugid=$_POST['drugid'];
    $actionid=$_POST['source'];
    
    include_once('dbconn.php');
    
    if($actionid=="rx"){
        //new rx transaction
        
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
        }
    }elseif($actionid=="edit"){
        //show edit form for specific drug
        
    }else{
        echo "Somehow we still didn't match.";
    }
 
?>