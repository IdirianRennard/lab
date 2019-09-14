<?php
include 'include.php';

$ip = $_SERVER['REMOTE_ADDR'];

?>
<br>
<form action='pro3-test.php' method='post'>
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
      <input type='hidden' name='METHOD' value='DoDirectPayment'>
      <input type='hidden' name='PAYMENTACTION' value='Authorization'>
      <input type='hidden' name='IPADDRESS' value='<?php echo $ip; ?>'>
      <input type="hidden" name="ACCT" value="4024007139580582">
      <input type="hidden" name="EXPDATE" value=<?php echo date( 'm' ) . ( date( 'Y' ) + 3 ); ?>>
      <input type='hidden' name='CVV2' value='456'>
      <input type="hidden" name="FIRSTNAME" value="John">
      <input type="hidden" name="LASTNAME" value="Smith">
      <input type="hidden" name="STREET" value="123 Fake St">
      <input type="hidden" name="CITY" value="SCHENECTADY">
      <input type="hidden" name="STATE" value="NE">
      <input type="hidden" name="ZIP" value="12345">
      <input type="hidden" name="COUNTRYCODE" value="US">
      <input type="hidden" name="AMT" value="10.00">
      <input type='hidden' name='CREDITCARDTYPE' value='Visa'>
      <input type='hidden' name='VERSION' value='90'>
      <input type='hidden' name='VERBOCITY' value='high'>
      <input type='hidden' name="NOTIFYURL" value='https://houserennard.online/idirian/ipn-idirian.php'>
      <input type='submit' class='button' value=' SUBMIT '>
    </td>
  </tr>
</form>
</table>
