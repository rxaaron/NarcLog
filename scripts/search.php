<?php

    $store_prefix=$_COOKIE['store'];
    $drugtable=$store_prefix."_Drugs";
    $ndctable=$store_prefix."_DrugCode";
    $action=$_POST['action'];
    
    include_once('dbconn.php');
    
    $queryString= $db->real_escape_string($_POST['queryString']);
    
    if (!$db){
        echo "There was a database error!";
    }else{
        if($action!="edit"){
            $query=$db->query("SELECT A.ID AS ID, A.BrandName AS Drug, A.Strength, NULL AS Indicator, A.Comments, C.Description AS Form FROM ".$drugtable." AS A INNER JOIN DrugForm AS C ON A.FormID = C.ID WHERE ((A.IsBrand=TRUE AND A.Active=TRUE) AND MATCH (A.BrandName) AGAINST ('".$queryString."*' IN BOOLEAN MODE)) UNION SELECT A.ID AS ID, A.GenericName AS Drug, A.Strength, Concat('(generic for ',A.BrandName,')') AS Indicator, A.Comments, C.Description AS Form FROM ".$drugtable." AS A INNER JOIN DrugForm AS C ON A.FormID = C.ID WHERE ((A.IsBrand=FALSE AND A.Active=TRUE) AND MATCH (A.GenericName,A.BrandName) AGAINST ('".$queryString."*' IN BOOLEAN MODE)) UNION SELECT A.ID, A.BrandName AS Drug, A.Strength, NULL AS Indicator, A.Comments, C.Description As Form FROM ".$drugtable." AS A INNER JOIN ".$ndctable." AS B ON A.ID = B.DrugID INNER JOIN DrugForm AS C ON A.FormID = C.ID WHERE ((A.IsBrand=TRUE AND A.Active=TRUE) AND MATCH (B.NDC) AGAINST ('".$queryString."*' IN BOOLEAN MODE)) UNION SELECT A.ID, A.GenericName AS Drug, A.Strength, Concat('(generic for ',A.BrandName,')') AS Indicator, A.Comments, C.Description AS Form FROM ".$drugtable." AS A INNER JOIN ".$ndctable." AS B ON A.ID = B.DrugID INNER JOIN DrugForm AS C ON A.FormID = C.ID WHERE ((A.IsBrand=FALSE AND A.Active=TRUE) AND MATCH (B.NDC) AGAINST ('".$queryString."*' IN BOOLEAN MODE)) ORDER BY Drug, Strength");
            if ($query){
                if($query->num_rows!=0){
                    echo "<table><colgroup><col class=\"drugname\"><col class=\"drugstrength\"><col class=\"drugform\"><col class=\"drugcomments\"></colgroup><tr><th>Drug Name</th><th>Strength</th><th>Form</th><th>Comments</th></tr>";
                    $c=true;
                    while($results=$query->fetch_object()){
                        echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td><a href=\"#\" onclick=\"return resultlist('".$results->ID."','".$action."')\">".$results->Drug." ".$results->Indicator."</a></td><td class=\"tacenter\">".$results->Strength."</td><td class=\"tacenter\">".$results->Form."</td><td>".$results->Comments."</td></tr>";
                    }
                    echo "</table>";
                }else{
                    echo "There are no drugs matching the search.";
                }
            }else{
                echo "There was an error with the query.";
            }     
        }else{
            //Edit Query contains non-active drugs as well.
             $query=$db->query("SELECT A.ID AS ID, A.BrandName AS Drug, A.Strength, NULL AS Indicator, A.Comments, C.Description AS Form FROM ".$drugtable." AS A INNER JOIN DrugForm AS C ON A.FormID = C.ID WHERE ((A.IsBrand=TRUE) AND MATCH (A.BrandName) AGAINST ('".$queryString."*' IN BOOLEAN MODE)) UNION SELECT A.ID AS ID, A.GenericName AS Drug, A.Strength, Concat('(generic for ',A.BrandName,')') AS Indicator, A.Comments, C.Description AS Form FROM ".$drugtable." AS A INNER JOIN DrugForm AS C ON A.FormID = C.ID WHERE ((A.IsBrand=FALSE) AND MATCH (A.GenericName,A.BrandName) AGAINST ('".$queryString."*' IN BOOLEAN MODE)) UNION SELECT A.ID, A.BrandName AS Drug, A.Strength, NULL AS Indicator, A.Comments, C.Description As Form FROM ".$drugtable." AS A INNER JOIN ".$ndctable." AS B ON A.ID = B.DrugID INNER JOIN DrugForm AS C ON A.FormID = C.ID WHERE ((A.IsBrand=TRUE) AND MATCH (B.NDC) AGAINST ('".$queryString."*' IN BOOLEAN MODE)) UNION SELECT A.ID, A.GenericName AS Drug, A.Strength, Concat('(generic for ',A.BrandName,')') AS Indicator, A.Comments, C.Description AS Form FROM ".$drugtable." AS A INNER JOIN ".$ndctable." AS B ON A.ID = B.DrugID INNER JOIN DrugForm AS C ON A.FormID = C.ID WHERE ((A.IsBrand=FALSE) AND MATCH (B.NDC) AGAINST ('".$queryString."*' IN BOOLEAN MODE)) ORDER BY Drug, Strength");
            if ($query){
                if($query->num_rows!=0){
                    echo "<table><colgroup><col class=\"drugname\"><col class=\"drugstrength\"><col class=\"drugform\"><col class=\"drugcomments\"></colgroup><tr><th>Drug Name</th><th>Strength</th><th>Form</th><th>Comments</th></tr>";
                    $d=true;
                    while($results=$query->fetch_object()){
                        echo "<tr ".(($c=!$c)?'class="even"':'class="odd"')."><td><a href=\"#\" onclick=\"return resultlist('".$results->ID."','".$action."')\">".$results->Drug." ".$results->Indicator."</a></td><td class=\"tacenter\">".$results->Strength."</td><td class=\"tacenter\">".$results->Form."</td><td>".$results->Comments."</td></tr>";
                    }
                    echo "</table>";
                }else{
                    echo "There are no drugs matching the search.";
                }
            }else{
                echo "There was an error with the query.";
            }           
        }
    }
?>