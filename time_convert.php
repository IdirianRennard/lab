<?php
  include 'include.php';
?>
<form action='time_convert-test.php' method='post'>
<table class='table'>
  <tr>
    <td><br>Time to Convert:</td>
    <script>spaces(4)</script>
    <td><br><input type="text" id="datepicker" name="date" placeholder=" 01/01/2000"></td>
    <td>Hours:<br><input name="hours" type="number" min="0" max="24" placeholder="  23" size="4" required></td>
    <td>Minutes:<br><input name="minutes" type="number" min="0" max="59" placeholder="  59" size="4" required></td>
    <td>Time Zone:<br>
      <select class='drop' name='timezone_fr' required>
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
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Convert To:</td>
    <td></td>
    <td><select class='drop' name='timezone_to' required>
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
  </tr>
  <tr><td colspan="42"><hr></td></tr>
  <tr>
    <td colspan="42" align='right'><input type='submit' class='button' value='convert'></td>
  </tr>
</table>
</form>
