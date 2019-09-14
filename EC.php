<?php
include 'include.php';
?>

<form action='EC-test.php' method='post'>
<table class='table'>
  <tr>
    <td>Enviroment</td>
    <script>spaces(4)</script>
    <td><select class='drop' id='enviroment' class='drop' name='enviroment' required>
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
    <td><textarea name='client' class='drop' cols="42" rows="7"><?php echo $credentials['REST_CLIENT']; ?></textarea></td>
  </tr>
  <tr><td ><br></td></tr>
  <tr>
    <td>Amount in USD</td>
    <td></td>
    <td><input type='number' name='amount' value='15.00'></td>
  </tr>
  <tr><td colspan='42'><hr></td></tr>
  <tr>
    <td colspan='42' align='right'><input type='submit' class='button' value=' SUBMIT '></td>
  </tr>
</table>
</form>
