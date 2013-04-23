<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Add NDC to Drug</title>
    </head>
    <body>
        <form name="addndc" id="addndc" action="scripts/commit_ndc.php" method="POST" autocomplete="off">
            <table name="ndctable" id="ndctable">
                <colgroup><col name="label" style="width:200px;"><col name="boxes" style="width:500px;"></colgroup>
                <tr><td>Select Drug:</td><td><?php include_once('scripts/quick_druglist.php'); ?></td></tr>
                <tr><td>New NDC:</td><td><input type="text" name="newndc" autocomplete="off" /></td></tr>
            </table>
            <input type="submit" name="gobabygo" value="Add NDC" />
        </form>
    </body>
</html>