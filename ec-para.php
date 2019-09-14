<?php
include 'include.php';

$ip = $_SERVER['REMOTE_ADDR'];

?>
<form action='ec-para-test.php' method='post'>
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
    <td>Recipient Number:</td>
    <td></td>
    <td><input type='number' id='number' name="q" min="1" max='3' value='0' required></td>
  </tr>
  <tr>
    <td id='recipients' colspan='900' align='center'></td>
  </tr>
  <tr id='remove'><td><br></td></tr>
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
<script>
$(document).ready( function () {
  $('#number').on('change', function(e) {
    let message = '<td colspan="3" align="center"><br>';

    for ( var i = 0 ; i < e.target.value ; i++ ) {
      message += "<input type='hidden' name='PAYMENTREQUEST_" + i + "_PAYMENTACTION' value='Sale'>";
      message += "<input type='hidden' name='PAYMENTREQUEST_" + i + "_CURRENCYCODE' value='USD'>";
      message += "<input type='hidden' name='PAYMENTREQUEST_" + i + "_PAYMENTREQUESTID' value='HR-0" + ( i + 1 ) + "'>";
      message += "<input type='text' placeholder='  Recipient " + ( i + 1 ) + " Email' name='PAYMENTREQUEST_" + i + "_SELLERPAYPALACCOUNTID' required>&nbsp&nbsp&nbsp&nbsp&nbsp";
      message += "<input type='text' placeholder='  Amount' name='PAYMENTREQUEST_" + i + "_AMT' required><br><br>";
    }

    message += '</td>'

    $('#recipients').html( message );

    $('#AMT').val( e.target.value );

    let blank = '';
    $('#remove').html( blank );
  } );
} );
</script>
