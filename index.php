<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>C-II Log</title>
        <link rel="stylesheet" href="rsc/narclog.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="rsc/print.css" type="text/css" media="print" />
        <link rel="shortcut icon" href="rsc/favicon.ico" />
        <script>
            function changepage(pagename){
                var xmlhttp;
                xmlhttp=new XMLHttpRequest();
                xmlhttp.open("POST",pagename,false);
                xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xmlhttp.send();
                document.getElementById("main").innerHTML=xmlhttp.responseText;  
                return false;
            }
            function searchbox(inpt,actn) {
                document.getElementById("search").style.height='300px';
                document.getElementById("entry").style.top='335px';
                document.getElementById("entry").innerHTML="";
                var xmlhttp;
                xmlhttp=new XMLHttpRequest();
                xmlhttp.open("POST","scripts/search.php",false);
                xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xmlhttp.send("queryString="+inpt+"&action="+actn);
                document.getElementById("results").innerHTML=xmlhttp.responseText;
                return false;
            }
            function resultlist(drugid,source) {
                document.getElementById("search").style.height='50px';
                document.getElementById("entry").style.top='85px';
                document.getElementById("results").innerHTML="";
                document.getElementById("inputStringBox").value="";
                var xmlhttp;
                xmlhttp=new XMLHttpRequest();
                xmlhttp.open("POST","scripts/action.php",false);
                xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xmlhttp.send("drugid="+drugid+"&source="+source);
                document.getElementById("entry").innerHTML=xmlhttp2.responseText;
                return false;
            }
            function createnew(newwhat){
                var xmlhttp;
                xmlhttp=new XMLHttpRequest();
                xmlhttp.open("POST",newwhat,false);
                xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xmlhttp.send();
                document.getElementById("entry").innerHTML=xmlhttp.responseText;
                return false;
            }
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
            <a href="index.php" onclick="return changepage('onhand.php');">Check On Hand</a>
            <a href="index.php" onclick="return changepage('inventory.php');">Quick Inventory</a>
            <a href="index.php" onclick="return changepage('adminreports.php');">Administrative</a>
            <h2>Administration</h2>
            <a href="index.php" onclick="return changepage('drugadmin.php');">Drugs</a>
            <a href="index.php" onclick="return changepage('useradmin.php');">Users</a>
            <a href="index.php" onclick="return changepage('systemadmin.php');">System</a>
        </div>
        <div id="main">
            <?php 
                    if(!isset($_COOKIE['store'])){
                        include_once('changestore.php');
                    }else{
                        include_once('newrx.php');
                    }
                ?>
        </div>            
        <div id="sidebar">
            <p><a href="index.php" onclick="return changepage('changestore.php');">Change Store</a></p>
    </div>
    </body>
</html>

