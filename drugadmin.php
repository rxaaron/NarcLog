<div id="title">
    <h1><?php echo $_COOKIE['store']; ?> C-II Drug Administration</h1>
</div>
<div id="content">
    <div id="search">
        <a href="index.php" onclick="return createnew('scripts/newdrug.php');">Create New Drug</a>
        <form name="searchform" id="searchform" autocomplete="off"  action="" method="POST" onsubmit="formsub('edit');">
            <table style="width:95%;">
                <colgroup><col id="label" style="width:20%;"><col id="box" style="width:70%"></colgroup>
                <tr>
                    <td>Search by Name or NDC:</td>
                    <td><input type="text" name="inputStringBox" id="inputStringBox" autocomplete="off" onkeyup="searchbox(this.value,'edit');" style="width:90%;" /></td>
                </tr>            
            </table>
        </form>
        <div id="results">
        </div>
    </div>
    <div id="entry">
        &nbsp;
    </div>
    <div id="userdiv" style="display:none;"></div>
</div>