<?php
include 'include.php';

?>
<form action='rest-payment-experience-test.php' method='post'>
  <table class='table'>
    <tr>
      <td>Client ID:</td>
      <script>spaces(4)</script>
      <td colspan='42'><textarea name='ClientID'cols='72' rows='3'><?php echo $credentials['REST_CLIENT']; ?></textarea></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Secret:</td>
      <td></td>
      <td colspan='42'><textarea name='Secret' cols='72' rows='3'><?php echo $credentials['REST_SECRET']; ?></textarea></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td>Profile Name:</td>
        <td></td>
        <td><input type='text' name='name' placeholder='  Name of the Profile'></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td>Logo URL:</td>
        <td></td>
        <td><input type='url' name='logo_image' placeholder='  URL of the Logo'></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td>User Action:</td>
        <td></td>
        <td>
          <label class="switch">
            <input type='checkbox' name='user_action' value='commit'>
            <span class="slider round"></span>
          </label>Commit
        </td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td>Landing Page:</td>
        <td></td>
        <td><select name='landing_page' required>
            <option disabled selected>Select a Landing Page</option>
            <option value='billing'>Billing</option>
            <option value='login'>Login</option>
            </select>
        </td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td>Shipping Info:</td>
        <td></td>
        <td><select name='no_shipping' required>
            <option selected disabled>Please Select your Shipping Preference</option>
            <option value='0'>Displays the shipping address on the PayPal pages.</option>
            <option value='1'>Redacts shipping address fields from the PayPal pages.</option>
            <option value='2'>Gets the shipping address from the customer's account profile.</option>
            </select>
        </td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td>Address Override:</td>
        <td></td>
        <td><select name='address_override' required>
            <option selected disabled>Please Select your Address Preference</option>
            <option value='0'>Displays the shipping address on file.</option>
            <option value='1'>Displays the shipping address specified in this call. the customer cannot edit this shipping address.</option>
            </select>
        </td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>
        Enviroment:
      </td>
      <td></td>
      <td><script>env_dropdown()</script></td>
    <tr>
    <tr>
      <td colspan="42"><hr></td>
    </tr>
    <tr>
      <td colspan='42' align='right'><input type='submit' class='button' value=' SUBMIT '></td>
    </tr>
  </table>
</form>