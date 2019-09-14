<?php
include 'include.php';
?>
<form action='ipn_sim-test.php' method='post'>
  <table class='table'>
    <tr>
      <td>IPN Listener URL:</td>
      <script>spaces(4)</script>
      <td><input type='url' name='listener' size='50' value='https://houserennard.online/idirian/ipn/ipn.php'></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Enter NVP String:</td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td colspan="42"><textarea rows='5' cols='55' name='api_str'>Enter the API String in here</textarea></td>
    </tr>
    <tr><td colspan="42"><hr></td></tr>
    <tr>
      <td colspan="42" align='right'><input type='submit' class='button' value='submit'></td>
    </tr>
  </table>
</form>
