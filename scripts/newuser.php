<form name="newuser" id="newuser" action="scripts/commit_new_user.php" method="POST" autocomplete="off">
    <table name="newusertable" id="newusertable">
        <colgroup><col name="label" style="width:200px;"><col name="boxes" style="width:500px;"></colgroup>
        <tr><td>Full Name:</td><td><input type="text" name="fullname" autocomplete="off" /></td></tr>
        <tr><td>Initials:</td><td><input type="text" name="initials" autocomplete="off" /></td></tr>
        <tr><td>Initial Password:</td><td><input type="text" name="ipwd" autocomplete="off" /></td></tr>
        <tr><td>Location:</td><td><input type="text" name="location" autocomplete="off" /></td></tr>
        <tr><td>Email:</td><td><input type="text" name="email" autocomplete="off" /></td></tr>
        <tr><td>Admin Password:</td><td><input type="password" name="empid" autocomplete="off" /></td></tr>
    </table>
    <input type="submit" name="gobaby" value="Add New User" />
</form>