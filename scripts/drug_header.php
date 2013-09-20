<?php
        $drugonhand=$db->query("SELECT A.BrandName AS Drug, A.Strength, A.OnHand, B.Description AS Form, B.Exact FROM ".$drugtable." AS A INNER JOIN DrugForm AS B ON A.FormID = B.ID WHERE (A.IsBrand=True AND A.Active=True AND A.ID=".$drugid.") UNION SELECT A.GenericName AS Drug, A.Strength, A.OnHand, B.Description AS Form, B.Exact FROM ".$drugtable." AS A INNER JOIN DrugForm AS B on A.FormID = B.ID WHERE (A.IsBrand=False AND A.Active AND A.ID=".$drugid.") ORDER BY Drug, Strength;");
        if($drugonhand){
            $resultsdrug=$drugonhand->fetch_object();
                echo "<div class=\"tacenter\"><h2>".$resultsdrug->Drug." ".$resultsdrug->Strength." ".$resultsdrug->Form."</h2>";
                $ndc=$db->query("SELECT NDC FROM ".$ndctable." WHERE DrugID=".$drugid." AND Active=TRUE;");
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
                echo "</div>";
        }
?>