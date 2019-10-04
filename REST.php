<?php
include 'include.php';
?>

<form action='rest-test.php' method='post'>
  <table class='table'>
    <tr>
      <td>
        Client ID:
      </td>
      <script>spaces(4)</script>
      <td>
        <textarea name='ClientID'cols='72' rows='3'><?php echo $credentials['REST_CLIENT']; ?></textarea>
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
      <td>
        <textarea name='Secret' cols='72' rows='3'><?php echo $credentials['REST_SECRET']; ?></textarea>
      </td>
    </tr>
    <tr>
      <td><br></td>
    </tr>
    <tr>
      <td>
        Enviroment:
      </td>
      <td></td>
      <td><script>env_dropdown()</script></td>
    <tr>
      <td colspan="42" align='right'>
        <hr>
        <input type='submit' class='button' value=' SUBMIT '>
      </td>
    </tr>
  </table>
</form>
