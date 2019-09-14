<?php
include 'include.php';
?>
<form action="" method='get' target="_blank" id='direction'>
  <table class="table">
    <tr><td>Please enter in an Email Address or Payer ID:</td>
      <script>spaces(4)</script>
      <td>
        <input type="hidden" name="cmd" value="_xclick-subscriptions">
        <input type="input" name="business" value="VA4QLK8WQUTGS">
        <input type="hidden" name="lc" value="US">
        <input type="hidden" name="item_name" value="monthly">
        <input type="hidden" name="no_note" value="1">
        <input type="hidden" name="no_shipping" value="1">
        <input type="hidden" name="src" value="1">
        <input type="hidden" name="a3" value="19.00">
        <input type="hidden" name="p3" value="1">
        <input type="hidden" name="t3" value="M">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="notify_url" value="https://traintofightback.com/?ihc_action=paypal">
        <input type="hidden" name="cancel_return" value="https://traintofightback.com/iump-register/">
        
        <input type="hidden" name="srt" value="1">
        <input type="hidden" name="return" value="https://traintofightback.com/iump-register/">
        <input type="hidden" name="rm" value="2">
      </td></tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Enviroment:</td>
      <td></td>
      <td>
        <select id="enviroment" class='drop' required>
          <option selected disabled>Select Enviroment</option>
          <option value="live">Live</option>
          <option value="sandbox">Sandbox</option>
        </select>
      </td>
    <tr><td colspan='42'><hr></td></tr>
    <tr><td colspan="42" align="right"><input type="submit" class="button" value="SUBMIT"></td></tr>
  </table>
</form>
<script>
$( document ).ready(function() {

  //On change of the dropdown modify the location of a donation link
  $('#enviroment').on('change', function() {
    if ( $(this).val() == 'live' ) {
      $('#direction').attr( "action", 'https://www.paypal.com/cgi-bin/webscr');
    } else {
      $('#direction').attr( "action", 'https://www.sandbox.paypal.com/cgi-bin/webscr');
    }
  } );

} );
</script>
