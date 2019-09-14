<?php
include 'include.php';

$ip = $_SERVER['REMOTE_ADDR'];

?>
<br>
<form action='docapture-nvp-test.php' method='post'>
<table class='table'>
  <tr>
    <td>API Username</td>
    <script>spaces(4)</script>
    <td><input type='text' class='drop' name='USER' value='<?php echo $credentials['BRAD_APIUSER']; ?>'></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>API Password</td>
    <td></td>
    <td><input type='text' class='drop' name='PWD' value='<?php echo $credentials['BRAD_APIPWD']; ?>'></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>API Signature</td>
    <td></td>
    <td><input type='text' class='drop' name='SIGNATURE' value='<?php echo $credentials['BRAD_APISIG']; ?>' ></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Transaction ID:</td>
    <td></td>
    <td><input type='text' class='drop' name='TRXID' placeholder='  A12BC34DE56FG78H' required></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Amount</td>
    <td></td>
    <td><input type='number' class='drop' name='AMT' placeholder='  $00.00' step='0.01' required></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Currency:</td>
    <td></td>
    <td><?php echo currency_dropdown(); ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Enviroment:</td>
    <td></td>
    <td>
        <select id='enviroment' name="enviroment" class='drop' required>
        <option selected disabled>Select Enviroment</option>
        <option value="live">Live</option>
        <option value="sandbox">Sandbox</option>
      </select>
    </td>
  </tr>
  <tr>
    <td colspan='42' align='right'><hr>
      <input type='submit' class='button' value=' SUBMIT '>
    </td>
  </tr>
</form>
</table>
