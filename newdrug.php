<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>New Drug Entry</title>
    </head>
    <body>
        <form name="newdrug" id="newdrug" action="scripts/commit_new_drug.php" method="POST" autocomplete="off">
            <table name="newdrugtable" id="newdrugtable">
                <colgroup><col name="label" style="width:200px;"><col name="boxes" style="width:500px;"></colgroup>
                <tr><td>Brand Name:</td><td><input type="text" name="brand" autocomplete="off" /></td></tr>
                <tr><td>Generic Name:</td><td><input type="text" name="generic" autocomplete="off" /></td></tr>
                <tr><td>Strength:</td><td><input type="text" name="strength" autocomplete="off" /></td></tr>
                <tr><td>Form:</td><td><?php include_once('scripts/form_list.php'); ?></td></tr>
                <tr><td>Comments:</td><td><textarea name="comments" columns="30" rows="5"></textarea></td></tr>
                <tr><td>Password:</td><td><input type="password" name="empid" autocomplete="off" /></td></tr>
            </table>
            <input type="submit" name="gobaby" value="Submit New Drug" />
        </form>
    </body>
</html>
