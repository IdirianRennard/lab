<?php
include 'include.php';
?>
<form action='rest_identity-test.php' method='post'>
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
        <textarea name='Secret' cols='72' rows='3'><?php echo $credentials['REST_SECRET']; ?></textarea>
      </td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Return URL:</td>
      <td></td>
      <td colspan='42'><input size="72" type='url' value='<?php echo $return_file_path . 'test.php?return=true'; ?>' name='return' required></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Additional Scopes:</td>
      <td></td>
      <td><input type="checkbox" name="address" value="address">  Address</td>
      <script>spaces(4)</script>
      <td><input type="checkbox" name="email" value="email">  Email</td>
      <script>spaces(4)</script>
      <td><input type="checkbox" name="phone" value="phone">  Phone</td>
      <script>spaces(4)</script>
      <td><input type="checkbox" name="profile" value="profile">  Profile</td>
      <script>spaces(4)</script>
      <td><input type='checkbox' name='invoicing' value='https://uri.paypal.com/services/invoicing'></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>
        Enviroment:
      </td>
      <td></td>
      <td colspan='42'>
        <select id='enviroment' class='drop' class='drop' name='enviroment' required>
          <option selected='selected' disabled='disabled'>Select Enviroment</option>
          <option value='production'>Production</option>
          <option value='sandbox'>Sandbox</option>
        </select>
      </td>
    <tr>
      <td colspan="42" align='right'><hr>
        <input type='submit' class='button' value=' SUBMIT '>
      </td>
    </tr>
  </table>
</form>
