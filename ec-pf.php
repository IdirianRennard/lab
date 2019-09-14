<?php
include 'include.php';
?>
<form action='ec-pf-test.php' method='post'>
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
      <select name="env" class='drop' id='enviroment' required>
        <option selected disabled>Select Enviroment</option>
        <option value="live">Live</option>
        <option value="sandbox">Sandbox</option>
    </select></td></tr>
    <tr><td><br></td></tr>
    <tr><td>Billing Type:</td><td></td><td>
        <select name='BILLINGTYPE' class='drop' required>
          <option selected disabled>Select Billing Type</option>
          <option value='Standard'>Standard</option>
          <option value='MerchantInitiatedBilling'>Billing Agreement</option>
        </select>
    <tr><td><br></td></tr>
    <tr>
      <td colspan='42' align='right'>
        <input type='hidden' name='TRXTYPE' value='S'>
        <input type='hidden' name='TENDER' value='P'>
        <input type='hidden' name='ACTION' value='S'>
        <input type='hidden' name='CURRENCY' value='USD'>
        <input type='hidden' name='RETURNURL' value='<?php echo $return_file_path . 'ec-pf-return.php?RETURN=true'; ?>'>
        <input type='hidden' name='CANCELURL' value='<?php echo $return_file_path . 'ec-pf-return.php?CANCEL=true'; ?>'>
        <input type='hidden' name='NOTIFYURL' value='https://houserennard.online/idirian/ipn/ipn.php'>
        <input type='hidden' name='AMT' value='1.00'>
        <input type='submit' class='button' value=' SUBMIT '>
      </td>
    </tr>
  </table>
</form>
