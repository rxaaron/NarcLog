<?php

//store_prefix is here to make transition to multiple stores easier.
$store_prefix = $_COOKIE['store'];
$tablename = $store_prefix."_Drugs";

include_once('dbconn.php');

if (!$db) {
    echo 'ERROR: Could not connect to the database.';
} else {
                //check permissions
    $perms=$db->query("SELECT A.DrugEdit FROM ".$store_prefix."_Permissions AS A INNER JOIN Employee AS B ON A.EmployeeID=B.ID WHERE B.Password = '".$_POST['empid']."' AND A.Active=TRUE;");
    $drugaddperms = $perms->fetch_object();
    if($drugaddperms->DrugEdit!=1){
        exit("You do not have permission to edit a drug.");
    }
    
        //verify everything was submitted, check value for allowable NULL's
    $drugid=$_POST['drugid'];
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
    if(isset($_POST['isbrand'])){
        $isbrand="TRUE";
    }else{
        $isbrand="FALSE";
    }
    
    $update=$db->query("UPDATE ".$tablename." SET BrandName='".$brand."', GenericName='".$generic."', Strength='".$strength."', IsBrand=".$isbrand.", FormID=".$formID.", Comments='".$comments."' WHERE ID=".$drugid.";");
    
    if($update){
        echo "<html><head><meta http-equiv=\"Refresh\" content=\"1;url=/narclog/index.php?page=drugadmin\" /></head><h2>Update Successful!</h2></html>";
    }
}
?>