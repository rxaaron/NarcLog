<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Qty Used in Last 15 Days</title>
        <link rel="stylesheet" href="rsc/narclog.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="rsc/print.css" type="text/css" media="print" />
    </head>
    <body>
        <div id="report" style="width:700px;">
        <h2 class="tacenter">Quantity Used Last 15 days</h2>
        
        <table>
            <colgroup>
                <col style="width:300px;">
                <col style="width:75px;">
                <col style="width:100px;">
                <col style="width:75px;">
                <col style="width:75px;">
            </colgroup>
            <tr>
                <th>Drug Name</th>
                <th>Strength</th>
                <th>Form</th>
                <th>Current Amt</th>
                <th>Qty Used</th>
            </tr>
        <?php
        
    $store_prefix=$_COOKIE['store'];
    $drugtable=$store_prefix."_Drugs";
    $ndctable=$store_prefix."_DrugCode";
    $transactiontable=$store_prefix."_Transactions";
    
            include_once('scripts/dbconn.php');
    
    if (!$db){
        echo "There was a database error!";
    }else{
                   $drugquery=$db->query("SELECT A.ID, A.BrandName AS Drug, NULL AS Indicator, A.Strength, B.Description AS Form, B.Exact, A.OnHand FROM ".$drugtable." AS A INNER JOIN DrugForm AS B ON A.FormID = B.ID WHERE (A.IsBrand=true AND A.Active=True) UNION SELECT A.ID, A.GenericName AS Drug, Concat(' (',A.BrandName,')') AS Indicator, A.Strength, B.Description AS Form, B.Exact, A.OnHand FROM ".$drugtable." AS A INNER JOIN DrugForm AS B ON A.FormID = B.ID WHERE (A.IsBrand=false AND A.Active=true) ORDER BY Drug, Strength;");
                if($drugquery){
                    $c=true;
                    while($res=$drugquery->fetch_object()){
                        
                        $transactionquery=$db->query("SELECT Quantity FROM ".$transactiontable." WHERE (DrugID=".$res->ID." AND Active=true AND TransactionType=1) AND (TransactionDate BETWEEN '".date("Ymd",(strtotime('-15 days')))."' AND '".date("Ymd")."');");
                        
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
        ?>
        </table>
        </div>
    </body>
</html>
