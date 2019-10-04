<?php
include 'include.php';

$trx_type = [
  'A'   =>  'Authorization',
  'B'   =>  'Balance Inquiry',
  'C'   =>  'Credit (Refund)',
  'D'   =>  'Delayed Capture',
  'E'   =>  'Buyer Authentication',
  'F'   =>  'Voice Authorization',
  'I'   =>  'Inquiry',
  'K'   =>  'Rate Lookup',
  'L'   =>  'Data Upload',
  'N'   =>  'Duplicate Transaction',
  'NRC' =>  'Credit (Non-Referenced)',
  'S'   =>  'Sale',
  'R'   =>  'Recurring Billing - Inquiry',
  
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
      <td id='ORIGID' colspan='42' align='left'><br></td>
    </tr>
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
    <tr>
      <td>Enviroment:</td>
      <td></td>
      <td><script>env_dropdown()</script></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td>Comment:</td>
        <td></td>
        <td><input type="text" name="COMMENT1" value="Idirian's Test"></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Custom Header Information:</td>
      <td></td>
      <td>
        <label class="switch">
          <input type='checkbox' class='drop' id='custom_header'>
          <span class="slider round"></span>
        </label>
      </td>
    </tr>
    <tr>
        <td id='header_info' colspan='42' align='left'><br></td>
    </tr>
    <tr>
      <td colspan='42'><hr></td>   
      <input type="hidden" name="DISABLERECEIPT" value="true">
      <input type="hidden" name="TENDER" value="C">
      <input type="hidden" name="VERBOSITY" value="high">
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
      case 'C', 'I':
        message = "<br><table class='table'><tr><td>Original ID:</td><td>&nbsp&nbsp&nbsp&nbsp</td><td><input type='text' placeholder='  PNREF' name='ORIGID' required></td></tr></table>";
      break;

      case 'R':
        message = "<br><table class='table'><tr><td>Profile ID:</td><td>&nbsp&nbsp&nbsp&nbsp</td><td><input type='text' placeholder='  PROFILEID' name='ORIGPROFILEID' required></td></tr></table>";
      break;

      default:
        $('#ORIGID').css( 'text-align', 'left');

        message = "<br>Credit Card Info: <br><table class='table'>";
          message += "<tr><td>Card Number:</td><td><input type='text' name='ACCT' value='5105105105105100'></td><td>CVV2:<input type='text' name='CVV2' value='456' size='3'></td></tr>";
          message += "<tr><td><br></td></tr>";
          message += "<tr><td>Exp Date:</td><td><input type='text' name='EXPDATE' value='<?php echo date( 'm' ) . ( date( 'y' ) + 3 ); ?>'></td></tr>";
          message += "<tr><td><br></td></tr>";
          message += "<tr><td>Billing Name:</td><td><input type='text' name='BILLTOFIRSTNAME' value='John'></td><td><input type='text' name='BILLTOLASTNAME' value='Smith'></td></tr>";
          message += "<tr><td><br></td></tr>";
          message += "<tr><td>Billing Address:<br></td><td><input type='text' name='BILLTOSTREET' value='123 Fake St'><br><input type='text' name='BILLTOCITY' value='SCHENECTADY'></td>";
          message += "<td>";
          message += "<br><?php state_dropdown( 'NY' ); ?>";  
          message += "<input type='text' name='BILLTOZIP' value='12345' size='6'></td></tr>"
        message += "</table>";
      break;
    }

    $('#ORIGID').html( message );
  } );

  $('#custom_header').on('change', function( e ) {
    let message;

    if ( e.target.checked ) {
      message = "<br><table class='table'>";
        message += "<tr><td>Use Legacy Variables:</td><td>&nbsp&nbsp&nbsp&nbsp</td><td><label class='switch'><input type='checkbox' class='drop' name='legacy_variables'><span class='slider round'></span></label></tr>";
        message += "<tr><td><br></td></tr>";
        message += "<td>Request ID:</td><td></td><td><input type='text' name='VPS' placeholder='Custom VPS-REQUEST-ID'></td></tr>";
      message += "</table>";

    } else {
      message = '';
    }
    
    $('#header_info').html( message );
  } )

} );
</script>
