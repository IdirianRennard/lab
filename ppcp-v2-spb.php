<?php
include 'include.php';

$color = [
  'gold' => 'Gold',
  'blue' => 'Blue',
  'silver' => 'Silver',
];

asort( $color );

$shape = [
  'pill' => 'Pill',
  'rect' => 'Rectangle',
];

asort( $shape );

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
  'paypal' => 'PayPal',
];

asort( $label );

$layout = [
  'horizontal' => 'Horizontal',
  'vertical' => 'Vertical',
];

$intent = [
  'capture' => 'Sale',
  'authorize' => 'Authorization',
  //'order' => 'Order',
  'subscription' => 'Subscription',
];

asort( $intent );

$return_url = $return_file_path . 'rest_payments_return.php';

?>
<div id='check'></div>
<form action='ppcp-v2-spb-test.php' method='post'>
<table class='table'>
  <tr>
    <td>Enviroment:</td>
    <script>spaces(4)</script>
    <td>
      <script>
        env_dropdown();
      </script>
    </td>
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
    <td>Merchant ID:</td>
    <td></td>
    <td><input type='text' name='merchant_id' class='drop' value='<?php echo $credentials['BRAD_PAYERID']; ?>'>
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
    <td><input type='number' name='size' min='25' max='55' placeholder='  Size' required>
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
