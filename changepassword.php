<div id="title">
    <h1>Change Password</h1>
</div>
<div id="content">
    <div id="listdiv">
        <form id="chgpwd" name="chgpwd" action="scripts/commit_pwd.php" method="POST" autocomplte="off">
            <table>
                <colgroup><col id="label" style="width:20%;"><col id="box" style="width:70%"></colgroup>
                <tr><td>Old Password:</td><td><input type="password" name="oldpwd" autocomplte="off" /></td></tr>
                <tr><td>New Password:</td><td><input type="password" name="newpwd1" autocomplte="off" /></td></tr>
                <tr><td>Repeat New Password:</td><td><input type="password" name="newpwd2" autocomplte="off" /></td></tr>
            </table>
            <input type="submit" name="gobabygo" value="Change Password" />
        </form>
    </div>
</div>