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
  //'credit' => 'PayPal Credit',
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
  'order' => 'Order'
];
?>
<div id='check'></div>
<form action='jsv4-client-test.php' method='post'>
<table class='table'>
  <tr>
    <td>Enviroment</td>
    <script>spaces(4)</script>
    <td><select class='drop' id='enviroment' name='enviroment' required>
      <option selected='selected' disabled='disabled'>Select Enviroment</option>
      <option value='production'>Production</option>
      <option value='sandbox'>Sandbox</option>
      </select>
    </td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Client ID:</td>
    <td></td>
    <td><textarea name='client' class='drop' cols="42" rows="2"><?php echo $credentials['REST_CLIENT']; ?></textarea></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Label:</td>
    <td></td>
    <td><select class='drop' name='label' required>
      <option selected>Select a Label</option>
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
      <option selected>Select a Size</option>
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
      <option selected>Select a Color</option>
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
      <option selected>Select a Shape</option>
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
      <option selected>Select a Shape</option>
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
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Intent:</td>
    <td></td>
    <td><select class='drop' name='intent' required>
      <option selected>Select an Intent</option>
      <?php
      foreach ( $intent as $k => $v ) {
        echo "<option value='$k'>$v</option>";
      }
      ?>
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
    <td><select class='drop' name='currency'>
      <?php
        foreach ( $currency as $k => $v ) {
          if ( $v == 'USD' ) {
            echo "<option value='$v' selected>$v</option>";
          } else {
            echo "<option value='$v'>$v</option>";
          }
        }
      ?>
      </select>
    </td>
  </tr>
  <tr><td colspan='42'><hr></td></tr>
  <tr>
    <td colspan='42' align='right'><input type='submit' class='button' value='submit'></td>
  </tr>
</table>
</form>
<script>

</script>
