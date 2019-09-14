<?php
include './include.php';

$button_type = [
  'buy_now' => 'Buy Now',
  'sm_buy_now' => 'Buy Now - Small',
  'buy_now_cc_logo' => 'Buy Now w/ CC Logos',
  'pay_now' => 'Pay Now',
  'sm_pay_now' => 'Pay Now - Small',
  'pay_now_cc_logo' => 'Pay Now w/ CC Logos',
  'shopping_cart' => 'Add to Cart',
  'sm_shopping_cart' => 'Add to Cart - Small',
  'donate' => 'Donate',
  'sm_donate' => 'Donate - Small',
  'donate_cc_logo' => 'Donate w/ CC Logos',
  'subscribe' => 'Subscribe',
  'sm_subscribe' => 'Subscribe - Small',
  'subscribe_cc_logo' => 'Subscribe w/ CC Logos',
  //'installment' => 'Installment Plan',
  //'auto_bill' => 'Automatic Billing',
];

asort( $button_type );
?>
<br>
<form action='buttoncreate.php' method='post'>
<table class='table'>
  <tr>
    <td>Hosted Button ID:</td>
    <script>spaces(4)</script>
    <td><input type='text' class='drop' name='hosted_button_id' placeholder="  Hosted Button ID" required></td>
  </tr>
  <tr><script>spaces(1)</script></tr>
  <tr>
    <td>Button Image:</td>
    <td></td>
    <td>
      <select name="image" id='image' class='drop' required>
        <option value='buy_now' selected='selected' disabled='disabled'>Choose Button Image</option>
        <?php
        foreach ($button_type as $key => $value) {
          echo "<option value='$key'>$value</option>";
        }
        ?>
        <option disabled='disabled'></option>
        <option value='email_link'>Email Link</option>
        <option value='custom'>Enter Your Own Image</option>
      </select>
    </td>
  </tr>
  <tr id='input_image'>
  </tr>
  <tr>
    <td colspan='42' align='right'><hr><input type='submit' class='button' value=' GENERATE '></td>
  </tr>
</table>
</form>
