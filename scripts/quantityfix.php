<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Fix On Hand Quantity</title>
    </head>
    <body>
        <form name="onhandfix" id="onhandfix" action="quick_updateonhand.php" method="POST" autocompete="off">
            <table name="newonhand" id="newonhand">
                <colgroup><col name="label" style="width:200px;"><col name="boxes" style="500px;"></colgroup>
                <tr><td>Drug:</td><td><?php include_once('scripts/quick_druglist.php'); ?></td></tr>
                <tr><td>New Onhand:</td><td><input type="text" name="onhand" /></td></tr>
            </table>
            <input type="submit" name="gobabygo" value="Fix On Hand" />
        </form>
    </body>
</html>
