<?php
include 'include.php';
?>

<form action='rest_payments-test.php' method='post'>
  <table class='table'>
    <tr>
      <td>
        Client ID:
      </td>
      <script>spaces(4)</script>
      <td colspan='42'>
        <textarea name='ClientID' cols='72' rows='3'><?php echo $credentials['REST_CLIENT']; ?></textarea>
      </td>
    </tr>
    <tr>
      <td><br></td>
    </tr>
    <tr>
      <td>Secret:</td>
      <td></td>
      <td colspan='42'>
        <textarea name='Secret' cols='72' rows='3' ><?php echo $credentials['REST_SECRET']; ?></textarea>
      </td>
    </tr>
    <tr>
      <td><br></td>
    </tr>
    <tr valign='top'>
      <td>Payment Method:</td>
      <td></td>
      <td><select class='drop' name='payment_method' id='payment_method' required>
        <option selected disabled>Select Payment Method</option>
        <option value='credit_card'>Credit Card</option>
        <option value='paypal'>PayPal</option>
      </td>
      <td id='funding_instruments' align='left'></td>
    </tr>
    <tr id='remove'>
      <td><br></td>
    </tr>
    <tr>
      <td>
        Enviroment:
      </td>
      <td></td>
      <td>
        <select id='enviroment' class='drop' name='enviroment' required>
          <option selected='selected' disabled='disabled'>Select Enviroment</option>
          <option value='production'>Production</option>
          <option value='sandbox'>Sandbox</option>
        </select>
      </td>
    </tr>
    <tr>
      <td colspan="42" align='right'>
        <hr>
        <input type='submit' class='button' value=' SUBMIT '>
      </td>
    </tr>
  </table>
</form>

<script>
$(document).ready( function () {
  $('#payment_method').on('change', function(e) {
    let message = '';
    let blank = '';

    if ( e.target.value === 'credit_card' ) {
      message += "<table><tr><td><input type='text' placeholder='  First Name' name='first_name' required></td>";
      message += "<td><input type='text' placeholder='  Last Name' name='last_name' required></td>";
      message += "<td><input type='text' placeholder='  Card Number' name='number' required></td>";
      message += "</tr><tr><td><br></td></tr><tr>";
      message += "<td><select class='drop' name='card_type' required>";
      message += "<option selected='selected' disabled='disabled'>Select Card Type</option>";
      message += "<option value='amex'>American Express</option>";
      message += "<option value='discover'>Discover</option>";
      message += "<option value='visa'>Visa</option>";
      message += "<option value='mastercard'>Mastercard</option></select></td>";
      message += "<td><select class='drop' name='expire_month' required>";
      message += "<option selected='selected' disabled='disabled'>Select Month</option>";

      for  ( let i = 1 ; i < 13 ; i++ ) {
        message += "<option value" + i + ">" + i + "</option>";
      }

      message += "</select>";
      message += "<select class='drop' name='expire_year' required>";
      message += "<option selected='selected' disabled='disabled'>Select Year</option>";

      for  ( let i = ( new Date() ).getFullYear() ; i < ( ( new Date() ).getFullYear() + 9 ) ; i++ ) {
        message += "<option value" + i + ">" + i + "</option>";
      }

      message += "</select></td>";
      message += "<td><input type='text' placeholder='  CVV2' name='cvv2' required></td>";
      message += "</tr></table>";

    } else {
      message = ''
      blank = '<td><br></td>'
    }

    $('#funding_instruments').html( message );

    $('#remove').html( blank );

  } );
} );
</script>
