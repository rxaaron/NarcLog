<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Qty Used in Last 15 Days</title>
        <link rel="stylesheet" href="rsc/narclog.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="rsc/print.css" type="text/css" media="print" />
    </head>
    <body>
        <?php
            include_once('/narclog/scripts/dbconn.php');
            if(!$db){
                exit("Database error!");
            }else{
                $drugquery=$db->query("S");
            }
        ?>
    </body>
</html>
