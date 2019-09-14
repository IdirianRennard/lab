<?php
include 'include.php';
?>
<form action="" method="post" target="_blank" id='direction'>
  <table class="table">
    <tr><td>Please enter in an Email Address or Payer ID:</td>
      <script>spaces(4)</script>
      <td>
        <input type="hidden" name="cmd" value="_cart">
        <input type="hidden" name="upload" value="1">
        <input type="text" name="business" value="<?php echo $credentials['EMAIL']; ?>">
        <input type="hidden" name="item_name_1" value="Cart Upload Test">
        <input type="hidden" name="amount_1" value="1.00">
        <input type="hidden" name="lc" value="US">
        <input type="hidden" name="custom" value="<?php echo $comment; ?>">
        <input type="hidden" name="return" value="<?php echo $return_file_path . 'test.php?return=true'; ?>">
        <input type='hidden' name='notify_url' value='https://houserennard.online/idirian/ipn/ipn.php'>
      </td>
    </tr>
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
