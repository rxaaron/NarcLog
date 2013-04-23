<?php

//store_prefix is here to make transition to multiple stores easier.
$store_prefix = "North";
$tablename = $store_prefix."_Drugs";

include_once('dbconn.php');

if (!$db) {
    echo 'ERROR: Could not connect to the database.';
} else {
    //check permissions
    $perms=$db->query("SELECT A.DrugAdd FROM ".$store_prefix."_Permissions AS A INNER JOIN Employee AS B ON A.EmployeeID=B.ID WHERE B.Password = '".$_POST['empid']."';");
    $drugaddperms = $perms->fetch_object();
    if($drugaddperms->DrugAdd!=1){
        exit("You do not have permission to add a new drug.");
    }
            
    //verify everything was submitted, check value for allowable NULL's
    if(isset($_POST['generic'])){
        $generic=$_POST['generic'];
    }else{
        echo "Please enter a generic name.";
        exit();
    }
    if(isset($_POST['brand'])){
        $brand=$_POST['brand'];
    }else{
        echo "Please enter a brand name.";
    }
    if(isset($_POST['strength'])){
        $strength=$_POST['strength'];
    }else{
        echo "Please enter a strength.";
    }
    if(!empty($_POST['comments'])){
        $comments=$_POST['comments'];
    }else{
        $comments=NULL;
    }
    $formID=$_POST['formid'];
    
    $insert=$db->query("INSERT INTO ".$tablename." (BrandName, GenericName, Strength, FormID, Comments) VALUES ('".$brand."','".$generic."','".$strength."',".$formID.",'".$comments."');");
    
    if($insert){
        echo "New Drug Entered OK!";
    }
}
?>
