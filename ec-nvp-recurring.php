<?php
    include 'include.php';

    $ip = $_SERVER['REMOTE_ADDR'];
?>
<form action='ec-nvp-recurring-test.php' method='post'>
<table class='table'>
  <tr>
    <td>API Username</td>
    <script>spaces(4)</script>
    <td colspan="42"><input type='text' class='drop' name='USER' value='<?php echo $credentials['API_USER']; ?>'></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>API Password</td>
    <td></td>
    <td colspan="42"><input type='text' class='drop' name='PWD' value='<?php echo $credentials['API_PWD']; ?>'></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>API Signature</td>
    <td></td>
    <td colspan='42'><input type='text' class='drop' name='SIGNATURE' value='<?php echo $credentials['API_SIG']; ?>'></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Amount</td>
    <td></td>
    <td><input type='number' name='AMT' value='' min='1.00' placeholder='  00.00' required></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Setup Fee:</td>
    <td></td>
    <td><input type='number' name='INITAMT' min='0.00' max='100' class='drop' placeholder='  00.00' required></td>
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
      <input type='hidden' name='METHOD' value='SetExpressCheckout'>
      <input type='hidden' name='SOLUTIONTYPE' value='Mark'>
      <input type='hidden' name='IPADDRESS' value='<?php echo $ip; ?>'>
      <input type="hidden" name="COUNTRYCODE" value="US">
      <input type="hidden" name="ReqBillingAddress" value='0'>
      <input type="hidden" name="NoShipping" value='0'>
      <input type="hidden" name="AddressOverride" value='0'>
      <input type='hidden' name='VERSION' value='82.0'>
      <input type='hidden' name='VERBOCITY' value='high'>
      <input type='hidden' name='CANCELURL' value='<?php echo $return_file_path . 'test.php?cancel'; ?>'>
      <input type='hidden' name='RETURNURL' value='<?php echo $return_file_path . 'getec-para-nvp.php'; ?>'>
      <input type='hidden' name='NOTIFYURL' value='https://houserennard.online/idirian/ipn/ipn.php'>
      <input type='submit' class='button' value=' SUBMIT '>
    </td>
  </tr>
</form>
</table>
