<?php
include 'include.php';

?>
<form action='' method='post' id='direction' target='_blank'>
  <table class="table">
    <tr>
      <td>Please enter in an Email Address or Payer ID:</td>
      <script>spaces(4)</script>
      <td>
        <input type="hidden" name="cmd" value="_donations">
        <input type="text" name="business" value="<?php echo $credentials['EMAIL']; ?>" required>
        <input type="hidden" name="lc" value="US">
        <input type="hidden" name="item_name" value="Donation Testing">
        <input type="hidden" name="no_note" value="0">
        <input type="hidden" name="cn" value="Add special instructions to the seller:">
        <input type="hidden" name="no_shipping" value="2">
        <input type="hidden" name="rm" value="1">
        <input type="hidden" name="return" value="<?php echo $return_file_path . 'test.php'; ?>">
        <input type="hidden" name="currency_code" value="USD">
        </form>
      </td>
    <tr><td><br></td></tr>
    <tr>
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
