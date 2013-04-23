<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>C-II Log</title>
        <link rel="stylesheet" href="rsc/narclog.css" type="text/css" />
        <link rel="shortcut icon" href="rsc/favicon.ico" />
        <script>
            function changepage(pagename){
                var xmlhttp;
                xmlhttp=new XMLHttpRequest();
                xmlhttp.open("POST",pagename,false);
                xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xmlhttp.send();
                document.getElementById("content").innerHTML=xmlhttp.responseText;  
                return false;
            };
         </script>
    </head>
    <body>
        <div id="banner">
            <a href="http://gmapserver.grcs.local/"><img src="rsc/GMAP_Logo.png" alt="GMAP/Encore" width ="250" height="100"></a>
        </div>            
        <div id="menu">
            <h2>Entry</h2>
            <a href="index.php" onclick="return changepage('newrx.php');">Dispense RX</a>
            <a href="index.php" onclick="return changepage('newinvoice.php');">Receive Order</a>
            <h2>Reports</h2>
            <a href="index.php" onclick="return changepage('onhand.php');">Check Inventory</a>
            <a href="index.php" onclick="return changepage('adminreports.php');">Administrative</a>
            <h2>Administration</h2>
            <a href="index.php" onclick="return changepage('drugadmin.php');">Drugs</a>
            <a href="index.php" onclick="return changepage('useradmin.php');">Users</a>
            <a href="index.php" onclick="return changepage('systemadmin.php');">System</a>
        </div>
        <div id="main">
            <div id="title">
                <h1>GMAP <?php echo $_COOKIE['store']; ?> C-II Log</h1>
            </div>
            <div id="content">
                <?php 
                    if(!isset($_COOKIE['store'])){
                        include_once('changestore.php');
                    }else{
                        include_once('newrx.php');
                    }
                ?>
            </div>
        </div>            
        <div id="sidebar">
            <p><a href="index.php" onclick="return changepage('changestore.php');">Change Store</a></p>
    </div>
    </body>
</html>

