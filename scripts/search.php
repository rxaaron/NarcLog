<?php

    $store_prefix=$_COOKIE['store'];
    $drugtable=$store_prefix."_Drugs";
    $action=$_POST['action'];
    
    include_once('dbconn.php');
    
    $queryString= $db->real_escape_string($_POST['queryString']);
    
    if (!$db){
        echo "There was a database error!";
    }else{
        $query=$db->query("SELECT A.ID AS ID, A.BrandName AS Drug, A.Strength, NULL AS Indicator, A.Comments, C.Description AS Form FROM ".$drugtable." AS A INNER JOIN DrugForm AS C ON A.FormID = C.ID WHERE ((A.IsBrand=TRUE AND A.Active=TRUE) AND MATCH (A.BrandName) AGAINST ('".$queryString."*' IN BOOLEAN MODE)) UNION SELECT A.ID AS ID, A.GenericName AS Drug, A.Strength, Concat('(generic for ',A.BrandName,')') AS Indicator, A.Comments, C.Description AS Form FROM ".$drugtable." AS A INNER JOIN DrugForm AS C ON A.FormID = C.ID WHERE ((A.IsBrand=FALSE AND A.Active=TRUE) AND MATCH (A.GenericName,A.BrandName) AGAINST ('".$queryString."*' IN BOOLEAN MODE)) UNION SELECT A.ID, A.BrandName AS Drug, A.Strength, NULL AS Indicator, A.Comments, C.Description As Form FROM ".$drugtable." AS A INNER JOIN DrugCode AS B ON A.ID = B.DrugID INNER JOIN DrugForm AS C ON A.FormID = C.ID WHERE ((A.IsBrand=TRUE AND A.Active=TRUE) AND MATCH (B.NDC) AGAINST ('".$queryString."*' IN BOOLEAN MODE)) UNION SELECT A.ID, A.GenericName AS Drug, A.Strength, Concat('(generic for ',A.BrandName,')') AS Indicator, A.Comments, C.Description AS Form FROM ".$drugtable." AS A INNER JOIN DrugCode AS B ON A.ID = B.DrugID INNER JOIN DrugForm AS C ON A.FormID = C.ID WHERE ((A.IsBrand=FALSE AND A.Active=TRUE) AND MATCH (B.NDC) AGAINST ('".$queryString."*' IN BOOLEAN MODE)) ORDER BY Drug, Strength");
        if ($query){
            echo "<table><colgroup><col name=\"drugname\" style=\"width:350px;\"><col name=\"drugstrength\" style=\"width:75px;\"><col name=\"drugform\" style=\"width:100px;\"><col name=\"drugcomments\"></colgroup><tr><th>Drug Name</th><th>Strength</th><th>Form</th><th>Comments</th></tr>";
            while($results=$query->fetch_object()){
                echo "<tr><td><a href=\"index.php\" onclick=\"return resultlist('".$results->ID."','".$action."')\">".$results->Drug." ".$results->Indicator."</a></td><td>".$results->Strength."</td><td>".$results->Form."</td><td>".$results->Comments."</td></tr>";
            }
            echo "</table>";
        }else{
            echo "There are no matching results.";
        }
    }
?>