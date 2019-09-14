<?php
include 'include.php';

$color = [
  'gold' => 'Gold',
  'blue' => 'Blue',
  'silver' => 'Silver',
  'white' => 'White',
  'black' => 'Black',
];

asort( $color );

$shape = [
  'pill' => 'Pill',
  'rect' => 'Rectangle',
];

asort( $shape );

$size = [
  'small' => 'Small',
  'medium' => 'Medium',
  'large' => 'Large',
  'responsive' => 'Dynamic',
];

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
];

$label = [
  'checkout' => 'PayPal Checkout',
  'pay' => 'Pay with PayPal',
  'buynow' => 'Buy Now',
  'paypal' => 'PayPal',
];

asort( $label );

$layout = [
  'horizontal' => 'Horizontal',
  'vertical' => 'Vertical',
];

$intent = [
  'sale' => 'Sale',
  'authorize' => 'Authorization',
  'order' => 'Order',
  'subscription' => 'Subscription',
];

asort( $intent );

$return_url = $return_file_path . 'rest_payments_return.php';

?>
<div id='check'></div>
<form action='jsv4-server-test.php' method='post'>
<table class='table'>
  <tr>
    <td>Enviroment</td>
    <script>spaces(4)</script>
    <td><script>env_dropdown()</script></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Client ID:</td>
    <td></td>
    <td colspan='42'><textarea name='client' class='drop' cols="42" rows="2"><?php echo $credentials['REST_CLIENT']; ?></textarea></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Secret:</td>
    <td></td>
    <td colspan='42'><textarea name='secret' class='drop' cols="42" rows="2"><?php echo $credentials['REST_SECRET']; ?></textarea></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Label:</td>
    <td></td>
    <td><select class='drop' name='label' required>
      <option selected disabled>Select a Label</option>
      <?php
      foreach ( $label as $k => $v ) {
        echo "<option value='$k'>$v</option>";
      }
      ?>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Size:</td>
    <td></td>
    <td><select class='drop' name='size' id='size' required>
      <option selected disabled>Select a Size</option>
      <?php
      foreach ( $size as $k => $v ) {
        echo "<option value='$k'>$v</option>";
      }
      ?>
    </select>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Color:</td>
    <td></td>
    <td><select class='drop' name='color' required>
      <option selected disabled>Select a Color</option>
      <?php
      foreach ( $color as $k => $v ) {
        echo "<option value='$k'>$v</option>";
      }
      ?>
    </select>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Shape:</td>
    <td></td>
    <td><select class='drop' name='shape' required>
      <option selected disabled>Select a Shape</option>
      <?php
      foreach ( $shape as $k => $v ) {
        echo "<option value='$k'>$v</option>";
      }
      ?>
    </select>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Layout:</td>
    <td></td>
    <td><select class='drop' name='layout' required>
      <option selected disabled>Select a Shape</option>
      <?php
      foreach ( $layout as $k => $v ) {
        echo "<option value='$k'>$v</option>";
      }
      ?>
    </td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Enable PayPal Credit:</td>
    <td></td>
    <td>
      <label class="switch">
        <input type='checkbox' class='drop' name='PPC'>
        <span class="slider round"></span>
      </label>
    </td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Enable Funding Icons:</td>
    <td></td>
    <td>
      <label class="switch">
        <input type='checkbox' class='drop' name='icons'>
        <span class="slider round"></span>
      </label>
    </td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Enable Tagline:</td>
    <td></td>
    <td>
      <label class="switch">
        <input type='checkbox' class='drop' name='tagline'>
        <span class="slider round"></span>
      </label>
    </td>
  </tr><tr><td><br></td></tr>
  <tr>
    <td>Intent:</td>
    <td></td>
    <td><select class='drop' name='intent' id='intent' required>
      <option selected disabled>Select an Intent</option>
      <?php
      foreach ( $intent as $k => $v ) {
        echo "<option value='$k'>$v</option>";
      }
      ?>
    <td id='sub_options' align='bottom'></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Amount:</td>
    <td></td>
    <td><input type='number' name='amount' value='15.00'></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Currency:</td>
    <td></td>
    <td><?php echo currency_dropdown(); ?>
      <input type='hidden' name='return' value='<?php echo $return_url; ?>'>
    </td>
  </tr>
  <tr>
  </tr>
  <tr><td colspan='42'><hr></td></tr>
  <tr>
    <td colspan='42' align='right'><input type='submit' class='button' value='submit'></td>
  </tr>
</table>
</form>
<script>
$(document).ready( function () {

  $('#intent').on('change', function( e ) {
    if ( e.target.value == 'subscription' ) {
      let message = "Frequency:<br><select class='drop' name='freq' required>";
      message += "<option selected disabled>Please Choose a Frequency</option>";
      message += "<option value='day'>Day</option>";
      message += "<option value='week'>Week</option>";
      message += "<option value='month'>Month</option>";
      message += "<option value='year'>Year</option>";
      message += "</select><br><br>";
      message += "Frequency Interval:<br><input type='number' name='freq_interval' maxlength='4' min='1' max='5' placeholder='( 1 - 5 )' required><br><br>";
      message += "Cycles:<br><input type='number' name='cycles' maxlength='4' min='0' max='5' placeholder='( 0 - 10 )' required><br>";

      $('#sub_options').html( message );
    } else {
      $('#sub_options').html( '' );
    };
  } );

} );
</script>
