<?php echo "<div class=\"storechange\"><br /><br />Current store: ".$_COOKIE['store']."<br /><br />"; ?>

<form name="storechange" id="storechange" action="scripts/set_store.php" method="POST">
    <select name="storename" id="storename">
        <option value="North" label="North">North</option>
        <option value="RCB" label="RCB">RCB</option>
        <option value="South" label="South">South</option>
        <option value="WSS" label="WSS">WSS</option>
    </select>
    <input type="submit" name="gobabygo" value="Change Store" />
</form>
</div>