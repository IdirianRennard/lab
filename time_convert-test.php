<?php
include 'include.php';

$old_time = $_POST['date'] . " " . $_POST['hours'] . ":" . $_POST['minutes'];

$date = new DateTime ( $old_time , new DateTimeZone( $_POST['timezone_fr'] ) );

$tz_to = $_POST['timezone_to'];

$format = 'm/d/Y H:i';

$date->setTimeZone( new DateTimeZone( $tz_to ) );
$new_time = $date->format( $format );

?>
<table class='table'>
  <tr>
    <td>INPUT:</td>
    <script>spaces(4)</script>
    <td><?php echo $old_time . " " . $_POST['timezone_fr'] ; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>CONVERSION:</td>
    <td></td>
    <td><?php echo "$new_time $tz_to"; ?></td>
  </tr>
</table>
