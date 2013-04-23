<?php
$store_prefix=$_COOKIE['store'];
$tablename=$store_prefix."_Drugs";
include_once('dbconn.php');

if (!$db) {
    echo 'ERROR: Could not connect to the database.';
} else {
    $query=$db->query("SELECT ID, BrandName AS Drug, Strength FROM ".$tablename." WHERE (IsBrand=TRUE AND Active=TRUE) UNION SELECT ID, Concat(GenericName,' (generic for ',BrandName,')'), Strength AS Drug FROM ".$tablename." WHERE (IsBrand=FALSE AND Active=TRUE) ORDER BY Drug, Strength;");
    if($query){
        echo "<select name=\"drugid\" id=\"drugid\">";
        while($result=$query->fetch_object()){
            echo "<option value=\"".$result->ID."\" label=\"".$result->Drug." ".$result->Strength."\">".$result->Drug." ".$result->Strength."</option>";
        }
        echo "</select>";
    }
}
?>
