<?php

include_once('dbconn.php');

if (!$db) {
    echo 'ERROR: Could not connect to the database.';
} else {
    $query=$db->query("SELECT ID, Description FROM DrugForm WHERE Active=true ORDER BY Description;");
    
    if ($query){
        echo "<select name=\"formid\" id=\"formid\">";
        while($result=$query->fetch_object()){
            if($result->ID==2){
                echo "<option value=\"".$result->ID."\" label=\"".$result->Description."\" selected>".$result->Description."</option>";
            }else{
                echo "<option value=\"".$result->ID."\" label=\"".$result->Description."\">".$result->Description."</option>";
            }
        }
        echo "</select>";
    }
}
?>
