<?php
include 'include.php';

$ip = $_SERVER['REMOTE_ADDR'];

?>
<br>
<form action='EC-NVP-test.php' method='post' target="_blank">
<table class='table'>
  <tr>
    <td>API Username:</td>
    <script>spaces(4)</script>
    <td><input type='text' class='drop' name='USER' value='<?php echo $credentials['API_USER']; ?>'></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>API Password:</td>
    <td></td>
    <td><input type='text' class='drop' name='PWD' value='<?php echo $credentials['API_PWD']; ?>'></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>API Signature:</td>
    <td></td>
    <td><input type='text' class='drop' name='SIGNATURE' value='<?php echo $credentials['API_SIG']; ?>'></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Intent:</td>
    <td></td>
    <td>
      <select name='PAYMENTACTION' class='drop' required>
        <option selected disabled>Select Payment Action</option>
        <option value='Authorization'>Authorization</option>
        <option value='Order'>Order</option>
        <option value='Sale'>Sale</option>
      </select>
    </td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
      <td>Currency:</td>
      <td></td>
      <td><?php echo currency_dropdown(); ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Amount:</td>
    <td></td>
    <td><input type="number" name="AMT" placeholder="  $0.00" step=".01"></td>
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
  <tr><td colspan='42'><hr></td></tr>
  <tr>
    <td colspan='42' align='right'>
      <input type='hidden' name='IP' value='<?php echo $ip; ?>'>
      <input type='submit' class='button' value=' SUBMIT '>
    </td>
  </tr>
</form>
</table>
