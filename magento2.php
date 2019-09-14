<?php
include 'include.php';

$intent = [
  'S' => 'Sale',
  'A' => 'Authorization',
];

ksort( $intent );

?>

<form action='magento2-test.php' method='post'>
  <table class='table'>
    <tr>
      <td>Partner:</td>
      <script>spaces(4)</script>
      <td><input class='drop' type="text" name="PARTNER" value="<?php echo $credentials['PF_PARTNER']; ?>"></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Vendor:</td>
      <td></td
      ><td><input type="text" class='drop' name="VENDOR" value="<?php echo $credentials['PF_VENDOR']; ?>"></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>User:</td>
      <td></td>
      <td><input type="text" name="USER" class='drop' value="<?php echo $credentials['PF_USER']; ?>"></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Password:</td>
      <td></td>
      <td><input type="password" name="PWD" class='drop' value="<?php echo $credentials['PF_PWD']; ?>"></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Intent:</td>
      <td></td>
      <td><select class='drop' name='TRXTYPE' id='intent' required>
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
      <td><input type='number' name='AMT' class='drop' placeholder='  00.00'></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Currency:</td>
      <td></td>
      <td><?php echo currency_dropdown(); ?>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Enviroment:</td>
      <td></td>
      <td><select id='enviroment' name="enviroment" class='drop' required>
        <option selected disabled>Select Enviroment</option>
        <option value="live">Live</option>
        <option value="sandbox">Sandbox</option>
      </select></td>
    </tr>
    <tr><td colspan='42'><hr></td></tr>
    <tr>
      <td colspan="42" align='right'><input type='submit' class='button' value='SUBMIT'></td>
    </tr>
  </table>
</form>
