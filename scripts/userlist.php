<?php

    $store_prefix=$_COOKIE['store'];
    $permission_table=$store_prefix."_Permissions";
    
include_once('dbconn.php');

if (!$db) {
    echo 'ERROR: Could not connect to the database.';
} else {
    $users=$db->query("SELECT ID, FullName, Initials, Location, Email, Active FROM Employee ORDER BY FullName;");
    if($users){
        echo "<table><colgroup><col style=\"width:150px;\"><col style=\"width:75px;\"><col style=\"width:100px;\"><col style=\"width:200px;\"><col style=\"width:50px;\">";
        echo "<tr><th>Full Name</th><th>Initials</th><th>Location</th><th>Email</th><th>Active</th></tr>";
        $c=true;
        while($res=$users->fetch_object()){
            echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td><a href=\"#\" onclick=\"return useredit(".$res->ID.");\">".$res->FullName."</a></td><td class=\"tacenter\">".$res->Initials."</td><td class=\"tacenter\">".$res->Location."</td><td class=\"tacenter\">".$res->Email."</td><td class=\"tacenter\">";
            if($res->Active==1){
                echo "<input type=\"checkbox\" disabled=\"disabled\" checked=\"checked\" />";
            }else{
                echo "<input type=\"checkbox\" disabled=\"disabled\" />";
            }
            echo "</td></tr>";
        }
        echo "</table>";
    }
}
?>
