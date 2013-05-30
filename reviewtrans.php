<div id="title">
    <h1><?php echo $_COOKIE['store']; ?> C-II Transactions</h1>
</div>
<div id="content">
    <div id="search">
        <form name="searchform" id="searchform" autocomplete="off">
            <table style="width:95%;">
                <colgroup><col id="label" style="width:20%;"><col id="box" style="width:70%"></colgroup>
                <tr>
                    <td>Search by Name or NDC:</td>
                    <td><input type="text" name="inputStringBox" id="inputStringBox" autocomplete="off" onkeyup="searchbox(this.value,'transactions');" style="width:90%;" autofocus placeholder="Enter Brand Name, Generic Name, or NDC" /></td>
                </tr>            
            </table>
        </form>
        <div id="results">
        </div>
    </div>
    <div id="entry">
        &nbsp;
    </div>
</div>