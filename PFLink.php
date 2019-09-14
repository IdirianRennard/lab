<?php
include 'include.php';

$trx_type = [
  'A' => 'Authorization',
  //'B' => 'Balance Inquiry',
  //'C' => 'Credit (Refund)',
  //'D' => 'Delayed Capture',
  //'F' => 'Voice Authorization',
  //'I' => 'Inquiry',
  //'K' => 'Rate Lookup',
  //'L' => 'Data Upload',
  //'N' => 'Duplicate Transaction',
  'S' => 'Sale',
];
?>
<form action='pflink-test.php' method='post'>
  <table class='table'>
    <tr><td>Partner:</td><script>spaces(4)</script><td><input class='drop' type="text" name="PARTNER" value="<?php echo $credentials['PF_PARTNER']; ?>"></td></tr>
    <tr><td><br></td></tr>
    <tr><td>Vendor:</td><td></td><td><input type="text" class='drop' name="VENDOR" value="<?php echo $credentials['BRAD_VENDOR']; ?>"></td></tr>
    <tr><td><br></td></tr>
    <tr><td>User:</td><td></td><td><input type="text" name="USER" class='drop' value="<?php echo $credentials['BRAD_USER']; ?>"></td></tr>
    <tr><td><br></td></tr>
    <tr><td>Password:</td><td></td><td><input type="password" name="PWD" class='drop' value="<?php echo $credentials['BRAD_PWD']; ?>"></td></tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Transaction Type:</td>
      <td></td>
      <td><select id='intent' name='TRXTYPE' class='drop' required>
        <option selected disabled>Select Transaction Type</option>
        <?php foreach ( $trx_type as $k => $v ) {
          echo "<option value='$k'>$v</option>";
        } ?>
      </select></td>
    </tr>
    <tr><td><br></td></tr>
    <tr><td>Enviroment:</td><td></td><td>
      <script>
        env_dropdown();
      </script>
      </td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Amount:</td>
      <td></td>
      <td><input type="number" name="AMT" value="0.00"></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Currency:</td>
      <td></td>
      <td><?php echo currency_dropdown(); ?></td>
    </tr>
    <tr><td><br></td></tr>
    <tr><td>Template:</td><td></td><td>
      <select name="TEMPLATE" class='drop' required>
        <option selected disabled>Select Template</option>
        <option value="TEMPLATEA">Template A</option>
        <option value="TEMPLATEB">Template B</option>
        <option value="TEMPLATEC">Template C</option>
        <option value="MOBILE">Mobile</option>
    </select></td></tr>
    <tr><td colspan='42'><hr></td></tr>
    <tr>
      <td colspan='42' align='right'>
        <input type='submit' class='button' value=' SUBMIT '>
      </td>
    </tr>
  </table>
</form>
