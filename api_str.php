<?php
include 'include.php';

?>
<br>
  <form action="api_str-test.php" method="post">
    <table class="table">
      <tr>
        <td>Enviroment:</td>
        <script>spaces(4)</script>
        <td><select id='enviroment' name='env' required>
          <option selected disabled>Enviroment</option>
          <option value='live'>Live</option>
          <option value='sandbox'>Sandbox</option>
        </select></td>
      </tr>
      <tr><td><br></td></tr>
      <tr>
        <td>Endpoint Location:</td>
        <script>spaces(4)</script>
        <td><select name='endpoint' required>
          <option selected disabled>End Point</option>
          <option value='payflow'>Pro 2.0</option>
          <option value='legacy'>Pro 3.0</option>
        </select></td>
      </tr>
      <tr><td><br></td></tr>
      <tr>
        <td colspan="42"><textarea rows='5' cols='25' name='api_str'>Enter the API String in here</textarea></td>
      </tr>
      <tr><td colspan='42'><hr></td></tr>
      <tr>
        <td colspan="42" align='right'><input type='submit' class='button' value='SUBMIT'></td>
      </tr>
    </table>
  </form>
