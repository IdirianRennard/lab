<?php
include 'include.php';

$cmd = [
  'Cart Upload' => '_cart',
  'X-Click' => '_xclick',
  'Subscription' => '_xclick-subscriptions',
  'Automatic Billing' => '_xclick-auto-billing',
  'Payment Plan' => '_xclick-payment-plan',
  'Donate' => '_donations',
];
?>
<form action='xclick-unhosted-test.php' method='post'>
  <table class='table'>
    <tr>
      <td>Enviroment:</td>
      <script>spaces(4)</script>
      <td><script>env_dropdown();</script></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Button Type:</td>
      <td></td>
      <td>
        <select name='cmd' class='drop'>
          <option selected disabled>Please select a CMD value</option>
          <?php
          foreach ( $cmd as $k => $v ) {
            echo "<option value='$v'>$k</option>";
          }
          ?>
        </select>
      </td>
    </tr>
    <tr><td><br></td></tr>
    <tr><td colspan='42'>
      <textarea name="xclick"cols="42" rows="7">Enter the params you wish to decode</textarea>
    </td></tr>
    <tr><td colspan="42" align="right"><hr><input type="submit" class="button" value="SUBMIT"></td></tr>
  </table>
</form>
