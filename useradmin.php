<div id="title">
    <h1><?php echo $_COOKIE['store']; ?> C-II User Administration</h1>
</div>
<div id="content">
    <div id="listdiv">
        <a href="#" onclick="return createnew('scripts/newuser.php');">Create New User</a><br /><br />
        <?php include('scripts/userlist.php'); ?>
    </div>
    <div id="userdiv">
        &nbsp;
    </div>
<div id="entry" style="top:335px;">
</div>    
</div>
