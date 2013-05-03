<?php

    $store_prefix=$_COOKIE['store'];
    $drugtable=$store_prefix."_Drugs";
    $ndctable=$store_prefix."_DrugCode";
    
include_once('dbconn.php');

if (!$db) {
    echo 'ERROR: Could not connect to the database.';
} else {
    $query=$db->query("SELECT A.ID AS ID, A.BrandName AS Drug, A.Strength, NULL AS Indicator, C.Description AS Form FROM ".$drugtable." AS A INNER JOIN DrugForm AS C ON A.FormID = C.ID WHERE (A.IsBrand=TRUE AND A.Active=TRUE) UNION SELECT A.ID AS ID, A.GenericName AS Drug, A.Strength, Concat('(generic for ',A.BrandName,')') AS Indicator, C.Description AS Form FROM ".$drugtable." AS A INNER JOIN DrugForm AS C ON A.FormID = C.ID WHERE (A.IsBrand=FALSE AND A.Active=TRUE) ORDER BY Drug, Strength;");
    
    if ($query){
        while($result=$query->fetch_object()){
                echo "<option value=\"".$result->ID."\" label=\"".$result->Drug." ".$result->Indicator." ".$result->Strength." ".$result->Form."\">".$result->Description."</option>";
        }
    }
}
?>
