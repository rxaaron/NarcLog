<?php
        echo "<h3 style=\"color:#ff0000;\">Do you really want to cancel this transaction?</h3>";
        echo "<form name=\"dummy\" id=\"dummy\" action=\"scripts/cancel_transaction.php\" method=\"POST\" autocomplete=\"off\">";
        echo "<input type=\"hidden\" name=\"transid\" value=\"".$_POST['transid']."\" />";
        echo "<input type=\"hidden\" name=\"actionid\" value=\"".$_POST['actionid']."\" />";
        echo "<input type=\"hidden\" name=\"quantity\" value=\"".$_POST['quantity']."\" />";
        echo "<input type=\"hidden\" name=\"drugid\" value=\"".$_POST['drugid']."\" />";
        echo "<input type=\"hidden\" name=\"identifier\" value=\"".$_POST['identifier']."\" />";
        echo "<input type=\"hidden\" name=\"active\" value=\"".$_POST['active']."\" />";
        echo "<table>";
        echo "<colgroup><col name=\"label\" style=\"width:200px;\"><col name=\"boxes\" style=\"width:500px;\"></colgroup>";
        echo "<tr><td>New On Hand:</td><td><input type=\"text\" name=\"newonhand\" autocomplete=\"off\" /></td></tr>";
        echo "<tr><td>Password:</td><td><input type=\"password\" name=\"userid\" /></td></tr>";
        echo "</table>";
        echo "<br /><br /><input type=\"submit\" name=\"gobabygo\" value=\"Cancel Transaction\" />";
        echo "</form>";
?>
