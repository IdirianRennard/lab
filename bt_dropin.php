<?php
include 'include.php';

?>
<form action='bt_dropin-test.php' method='post'>
  <table class='table'>
    <tr>
      <td>Client Token:</td>
      <script>spaces(4)</script>
      <td><textarea name='token' cols='50' rows='2'><?php echo $credentials['BT_TOKEN_KEY']; ?></textarea></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Amount:</td>
      <td></td>
      <td><input type='number' value='15' min='1' name='amount'></td>
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
      <td>
        <select id='enviroment' name="enviroment" class='drop' required>
          <option selected disabled>Select Enviroment</option>
          <option value="live" disabled>Live</option>
          <option value="sandbox">Sandbox</option>
        </select>
      </td>
    </tr>
    <tr><td colspan='42'><hr></td></tr>
    <tr>
      <td colspan='42' align='right'>
        <input type='submit' class='button' value='submit'>
      </td>
    </tr>
  </table>
</form>
