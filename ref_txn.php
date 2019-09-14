<?php
include 'include.php';


?>
<form action='ref_txn-test.php' method='post'>
  <table class='table'>
    <tr><td>Partner:</td><script>spaces(4)</script><td><input class='drop' type="text" name="PARTNER" value="<?php echo $credentials['PF_PARTNER']; ?>"></td></tr>
    <tr><td><br></td></tr>
    <tr><td>Vendor:</td><td></td><td><input type="text" class='drop' name="VENDOR" value="<?php echo $credentials['PF_VENDOR']; ?>"></td></tr>
    <tr><td><br></td></tr>
    <tr><td>User:</td><td></td><td><input type="text" name="USER" class='drop' value="<?php echo $credentials['PF_USER']; ?>"></td></tr>
    <tr><td><br></td></tr>
    <tr><td>Password:</td><td></td><td><input type="password" name="PWD" class='drop' value="<?php echo $credentials['PF_PWD']; ?>"></td></tr>
    <tr><td><br></td></tr>
    <tr><td>Enviroment:</td><td></td><td>
      <script>
        env_dropdown();
      </script>
      </td>
    </tr>
    <tr><td colspan='42'><hr></td></tr>
    <tr><td colspan='42' align='right'><input type='submit' class='button' value='submit'></td></tr>
</form>
