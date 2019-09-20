<?php
include 'include.php';

$trx_type = [
  'A'   =>  'Authorization',
  'B'   =>  'Balance Inquiry',
  'C'   =>  'Credit (Refund)',
  'D'   =>  'Delayed Capture',
  'F'   =>  'Voice Authorization',
  'I'   =>  'Inquiry',
  'K'   =>  'Rate Lookup',
  'L'   =>  'Data Upload',
  'N'   =>  'Duplicate Transaction',
  'S'   =>  'Sale',
  'R'   =>  'Recurring Billing - Inquiry',
  'NRC' =>  'Credit (Non-Referenced)',
];

asort( $trx_type );
?>


<form action="Pro2-test.php" method="post">
  <table class='table'>
    <tr><td>Partner:</td><script>spaces(4)</script><td><input class='drop' type="text" name="PARTNER" value="<?php echo $credentials['PF_PARTNER']; ?>" ></td></tr>
    <tr><td><br></td></tr>
    <tr><td>Vendor:</td><td></td><td><input type="text" class='drop' name="VENDOR" value="<?php echo $credentials['BRAD_VENDOR']; ?>"></td></tr>
    <tr><td><br></td></tr>
    <tr><td>User:</td><td></td><td><input type="text" name="USER" class='drop' value="<?php echo $credentials['BRAD_USER']; ?>" ></td></tr>
    <tr><td><br></td></tr>
    <tr><td>Password:</td><td></td><td><input type="password" name="PWD" class='drop' value="<?php echo $credentials['BRAD_PWD']; ?>" ></td></tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Transaction Type:</td>
      <td></td>
      <td><select id='intent' name='TRXTYPE' class='drop' required>
        <option selected disabled>Select Transaction Type</option>
        <?php foreach ( $trx_type as $k => $v ) {
          echo "<option value='$k'>$v</option>";
        } ?>
      </select></td>
    </tr>
    <tr>
      <td id='ORIGID' colspan='42' align='center'></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Amount:</td>
      <td></td>
      <td><input type="number" name="AMT" value="1.00"></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Currency:</td>
      <td></td>
      <td><?php echo currency_dropdown(); ?></td>
    </tr>
    <tr><td><br></td></tr>
    <tr><td>Enviroment:</td><td></td><td>
      <select id='enviroment' name="enviroment" class='drop' required>
        <option selected disabled>Select Enviroment</option>
        <option value="live">Live</option>
        <option value="sandbox">Sandbox</option>
    </select></td></tr>
    <tr>
      <td colspan='42'><hr></td>
      <input type="hidden" name="ACCT" value="5105105105105100">
      <input type="hidden" name="EXPDATE" value=<?php echo date( 'm' ) . ( date( 'y' ) + 3 ); ?>>
      <input type="hidden" name="DISABLERECEIPT" value="true">
      <input type="hidden" name="BILLTOFIRSTNAME" value="John">
      <input type="hidden" name="BILLTOLASTNAME" value="Smith">
      <input type="hidden" name="BILLTOSTREET" value="123 Fake St">
      <input type="hidden" name="BILLTOCITY" value="SCHENECTADY">
      <input type="hidden" name="TENDER" value="C">
      <input type="hidden" name="STATE" value="NY">
      <input type="hidden" name="STREET" value="123 Fake St">
      <input type="hidden" name="CITY" value="SCHENECTADY">
      <input type="hidden" name="ZIP" value="12345">
      <input type="hidden" name="VERBOSITY" value="high">
      <input type="hidden" name="COMMENT1" value="Nate's Test">
      <input type="hidden" name="NOTIFYURL" value="https://houserennard.online/ipn/ipn.php">
      <input type="hidden" name="CANCELURL" value="<?php echo $return_file_path . 'test.php?cancel=true'; ?>">
      <input type="hidden" name="ERRORURL" value="<?php echo $return_file_path . 'test.php?error=true'; ?>">
      <input type="hidden" name="RETURNURL" value="<?php echo $return_file_path . 'test.php?return=true'; ?>">
      </td>
    </tr>
    <tr><td colspan='3' align='right'><input type="submit" class='button' value="SUBMIT"></td></tr>
  </table>
</form>
<script>
$(document).ready( function () {

  $('#intent').on('change', function( e ) {
    let message;

    switch ( e.target.value ) {
      case 'C':
        message = "<br>Original ID: <input type='text' placeholder='  PNREF' name='ORIGID' required>";
        break;

      case 'R':
        message = "<br>Profile ID: <input type='text' placeholder='  PROFILEID' name='ORIGPROFILEID' required>";
        break;

      default:
        message = '';
    }

    $('#ORIGID').html( message );
  } );

} );
</script>
