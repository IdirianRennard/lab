<?php
include 'include.php';

$intent = [
    'capture' => 'Sale',
    'authorize' => 'Authorization',
    //'order' => 'Order',
    //'subscription' => 'Subscription',
];

ksort( $intent );

?>

<form action='v2-orders-patch-test.php' method='post'>
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
    <tr><td><br></td></tr>
    <tr>
        <td>Amount:</td>
        <td></td>
        <td><input type='number' name='amount' placeholder='  00.00' required></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td>Currency:</td>
        <td></td>
        <td><?php echo currency_dropdown(); ?></td>
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
            ?></select>
        </td>
    </tr>
    <tr><td><br></td></tr>
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

