<?php
include 'include.php';

?>
<br>
<form action='getbal-test.php' method='post'>
<table class='table'>
  <tr>
    <td>API Username</td>
    <script>spaces(4)</script>
    <td><input type='text' class='drop' name='USER' value='<?php echo $credentials['API_USER']; ?>'></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>API Password</td>
    <td></td>
    <td><input type='text' class='drop' name='PWD' value='<?php echo $credentials['API_PWD']; ?>'></td>
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
  <tr>
    <td colspan='42' align='right'><hr>
      <input type='submit' class='button' value=' SUBMIT '>
    </td>
  </tr>
</form>
</table>
