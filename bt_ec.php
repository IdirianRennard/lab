<?php
include 'include.php';

?>
<form action='bt_ec-test.php' method='post'>
  <table class='table'>
    <tr>
      <td>
        Access Token:
      </td>
      <script>spaces(4)</script>
      <td colspan='42'>
        <textarea name='access_token' cols='72' rows='1'><?php echo $credentials['BT_TOKEN']; ?></textarea>
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
