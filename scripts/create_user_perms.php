<?php

    $store_prefix=$_COOKIE['store'];
    $permission_table=$store_prefix."_Permissions";
    
    include_once('dbconn.php');
    
    if(!$db){
        echo 'ERROR: Could not connect to the database.';
    }else{
        
    $perms=$db->query("SELECT B.ID, B.Initials, A.Administrator FROM ".$store_prefix."_Permissions AS A INNER JOIN Employee AS B ON A.EmployeeID=B.ID WHERE B.Password = '".$_POST['userid']."' AND A.Active=TRUE;");
    $drugaddperms = $perms->fetch_object();
    if($drugaddperms->Administrator!=1){
        exit("You do not have permission to controls users.");
    }
        
        if(isset($_POST['id'])){
            $id=$_POST['id'];
        }
        if(isset($_POST['drugadd'])){
            $drugadd="true";
        }else{
            $drugadd="false";
        }
        if(isset($_POST['drugedit'])){
            $drugedit="true";
        }else{
            $drugedit="false";
        }
        if(isset($_POST['backcount'])){
            $backcount="true";
        }else{
            $backcount="false";
        }
        if(isset($_POST['enterrx'])){
            $enterrx="true";
        }else{
            $enterrx="false";
        }
        if(isset($_POST['enterinvoice'])){
            $enterinvoice="true";
        }else{
            $enterinvoice="false";
        }
        if(isset($_POST['edittransaction'])){
            $edittransaction="true";
        }else{
            $edittransaction="false";
        }
        if(isset($_POST['historyreports'])){
            $historyreports="true";
        }else{
            $historyreports="false";
        }
        if(isset($_POST['adminreports'])){
            $adminreports="true";
        }else{
            $adminreports="false";
        }
        if(isset($_POST['rph'])){
            $rph="true";
        }else{
            $rph="false";
        }
        if(isset($_POST['administrator'])){
            $administrator="true";
        }else{
            $administrator="false";
        }
        if(isset($_POST['active'])){
            $active="true";
        }else{
            $active="false";
        }
        $querytext="INSERT INTO ".$permission_table." (EmployeeID, DrugAdd, DrugEdit, BackCount, EnterRx, EnterInvoice, EditTransaction, HistoryReports, AdminReports, RPh, Administrator, Active) VALUES (".$id.",".$drugadd.",".$drugedit.",".$backcount.",".$enterrx.",".$enterinvoice.",".$edittransaction.",".$historyreports.",".$adminreports.",".$rph.",".$administrator.",".$active.");";
        $update=$db->query($querytext);
        if($update){
            echo "<html><head><meta http-equiv=\"Refresh\" content=\"1;url=/narclog/index.php?page=useradmin\" /></head><h2>User Administration Successful!</h2></html>";
        }else{
            echo $querytext;
        }
    }
?>