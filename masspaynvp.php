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


<br>
<form action='masspaynvp-test.php' method='post'>
<table class='table'>
  <tr>
    <td>API Username</td>
    <script>spaces(4)</script>
    <td><input type='text' class='drop' name='USER' value='<?php echo $credentials['API_USER']; ?>' ></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>API Password</td>
    <td></td>
    <td><input type='text' class='drop' name='PWD' value='<?php echo $credentials['API_PWD']; ?>' ></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>API Signature</td>
    <td></td>
    <td><input type='text' class='drop' name='SIGNATURE' value='<?php echo $credentials['API_SIG']; ?>' ></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Enviroment:</td>
    <td></td>
    <td>
      <select id='enviroment' name="enviroment" class='drop' required>
        <option selected disabled>Select Enviroment</option>
        <option value="live">Live</option>
        <option value="sandbox">Sandbox</option>
      </select>
    </td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td><input type='hidden' name='RECEIVERTYPE' value='EmailAddress'>
      How many recieivers do we have?</td>
      <td></td>
      <td><input type='number' id='number' name="quantity" min="1" max='3' value='0'></td>
  </tr>
  <tr id='recipients'>
  </tr>
  <tr id='remove'><td><br></td></tr>
  <tr>
    <td>Currency</td>
    <td></td>
    <td>
      <select align='right' class='drop' name='CURRENCYCODE' required>
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
  <tr><td colspan='42'><hr></td></tr>
  <tr>
    <td colspan='42' align='right'>
      <input type='hidden' name='RECEIVERTYPE' value='EmailAddress'>
      <input type='hidden' name='VERSION' value='90'>
      <input type='hidden' name='METHOD' value='MassPay'>
      <input type='submit' class='button' value='SUBMIT'>
    </td>
  </tr>
</form>
</table>
