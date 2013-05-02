<?php
    include_once('dbconn.php');
    
    if(!$db){
        exit("An error occurred with the database.");
    }else{
        $list=$db->query("SELECT RptName, Location, Description FROM NarcReports WHERE Active=true;");
        if($list){
            echo "<table><colgroup><col style=\"width:200px;\"><col style=\"width:500px;\"></colgroup><tr><th>Report</th><th>Description</th></tr>";
            $c=true;
            while($res=$list->fetch_object()){
                echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td><a href=\"reports/".$res->Location."\">".$res->RptName."</a></td><td>".$res->Description."</td></tr>";
            }
            echo "</table>";
        }
    }
?>
