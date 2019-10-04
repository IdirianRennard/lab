<?php
include 'include.php';

?>
<form action='rest_payments_sale-test.php' method='post'>
  <table class='table'>
    <tr><td>Client ID:</td>
      <script>spaces(4)</script>
      <td colspan='42'><textarea name='ClientID' cols='72' rows='3'><?php echo $credentials['REST_CLIENT']; ?></textarea></td>
    </tr>
    <tr><td><br></td></tr>
    <tr><td>Secret:</td>
      <script>spaces(4)</script>
      <td colspan='42'><textarea name='Secret' cols='72' rows='3'><?php echo $credentials['REST_SECRET']; ?></textarea></td>
    </tr>
    <tr><td><br></td></tr>
    <tr valign='bottom'>
      <td>Start Date:</td>
      <td></td>
      <td><input type="text" id="datepicker" name="date" placeholder=" 01/01/2000"></td>
      <script>spaces(4)</script>
      <td>Hours:<br><input name="hours" type="number" min="0" max="24" placeholder="  23" size="4" required></td>
      <td>Minutes:<br><input name="minutes" type="number" min="0" max="59" placeholder="  59" size="4" required></td>
      <td>Time Zone:<br>
        <select class='drop' name='timezone' required>
          <option value='Zone' selected disabled>Zone</option>
          <?php

          $timezone_list = timezone_identifiers_list( 2047 );
          $tzarray = [];

          foreach ($timezone_list as $k => $v) {
            $dateTime = new DateTime( );
            $dateTime->setTimeZone(new DateTimeZone( "$v" ));
            $tzarray[$dateTime->format('T')] = NULL;
          }

          foreach ($tzarray as $k => $v) {
            echo "<option value='$k'>$k</option>";
          }
          ?>
        </select>
      </td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
      <td>Enviroment</td>
      <td></td>
      <td><script>env_dropdown()</script></td>
    </tr>
    <tr>
      <td colspan='42' align='right'><hr><input type='submit' class='button' value=' SUBMIT '></td>
    </tr>
  </table>
</form>
