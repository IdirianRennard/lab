<?php
include 'include.php';
?>

<form action='rest_disputes-test.php' method='post'>
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
      <td>
        Enviroment:
      </td>
      <td></td>
      <td colspan='42'><script>env_dropdown()</script>
      </td>
    <tr>
    <tr>
      <td colspan="42" align='right'>
        <hr>
        <input type='submit' class='button' value=' SUBMIT '>
      </td>
    </tr>
  </table>
</form>
