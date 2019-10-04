<?php
include 'include.php';

$currency = [
  'AUD',
  'BRL',
  'CAD',
  'CZK',
  'DKK',
  'EUR',
  'HKD',
  'HUF',
  'ILS',
  'JPY',
  'MYR',
  'MXN',
  'NOK',
  'NZD',
  'PHP',
  'PLN',
  'GBP',
  'SGD',
  'SEK',
  'CHF',
  'TWD',
  'THB',
  'USD',
]
?>

<form action='rest_payouts-test.php' method='post'>
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
      <td>
        Secret:
      </td>
      <td></td>
      <td colspan='42'>
        <textarea name='Secret' cols='72' rows='3' ><?php echo $credentials['REST_SECRET']; ?></textarea>
      </td>
    </tr>
    <tr>
      <td><br></td>
    </tr>
    <tr valign="top">
      <td>Recipient Number: </td>
      <td></td>
      <td><input type='number' id='number' name="quantity" min="1" max='3' value='0'></td>
      <td id='recipients'></td>
    </tr>
    <tr id='remove'>
      <td><br></td>
    </tr>
    <tr>
      <td>Currency</td>
      <td></td>
      <td>
        <select class='drop' name='currency' required>
          <?php
            asort( $currency );

            foreach ($currency as $k => $v) {
              if( $v === 'USD' ) {
                echo "<option value='$v' selected>$v</option>";
              } else {
                echo "<option value='$v'>$v</option>";
              }
            }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td><br></td>
    </tr>
    <tr>
      <td>
        Enviroment:
      </td>
      <td></td>
      <td><script>env_dropdown()</script></td>
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
  $('#number').on('change', function(e) {
    let message = '';

    for ( var i = 0 ; i < e.target.value ; i++ ) {
      message += "<input type='email' placeholder='  Recipient " + ( i + 1 ) + " Email' name='rec" + i + "' required>&nbsp&nbsp&nbsp&nbsp";
      message += "<input type='text' placeholder='  Amount' name='amt" + i + "' required><br><br>";
    }

    $('#recipients').html( message );

    let blank = '';
    $('#remove').html( blank );

  } );
} );
</script>
