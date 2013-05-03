<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Qty Used in Last 15 Days</title>
        <link rel="stylesheet" href="rsc/narclog.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="rsc/print.css" type="text/css" media="print" />
        <script>
            function filterrpt(){
                var drugfilter = document.getElementById("drugfilter").checked;
                var drugid = document.getElementById("drugid").options[document.getElementById("drugid").selectedIndex].value;
                var datefilter = document.getElementById("datefilter").checked;
                var fromdate = document.getElementById("fromdate").value;
                var todate = document.getElementById("todate").value;
                var xmlhttp;
                xmlhttp=new XMLHttpRequest();
                xmlhttp.open("POST","scripts/sort_report.php",false);
                xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xmlhttp.send("drugfilter="+drugfilter+"&drugid="+drugid+"&datefilter="+datefilter+"&fromdate="+fromdate+"&todate="+todate);
                document.getElementById("report").innerHTML=xmlhttp.responseText;
                return false;
            }
        </script>
    </head>
    <body>
        <div id="options">
            <form id="rptoptions" name="rptoptions">
                <table name="rptoptiontbl" style="margin-left:25px;">
                    <tr>
                        <td><input type="checkbox" name="drugfilter" id="drugfilter" /></td>
                        <td>Filter by Drug:</td>
                        <td><select name="drugid" id="drugid"><?php include_once('scripts/drug_select.php'); ?></select></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="textbox" id="fromdate" name="fromdate" value="<?php echo date("m/d/Y",strtotime("-15 days")); ?>" /></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" id="datefilter" name="datefilter" /></td>
                        <td>Filter by Date:</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Through:</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="textbox" id="todate" name="todate" value="<?php echo date("m/d/Y"); ?>" /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><button name="gobaby" onclick="return filterrpt();">Filter Report</button></td>
                    </tr>
                </table>
            </form>
        </div>
        <div id="report" style="width:700px;">

        </div>
    </body>
</html>
