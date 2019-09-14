<?php
include 'include.php';


class data {

};



$ch = curl_init();

curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data );

$response = curl_exec( $ch );

curl_close( $ch );



?>
<table class='table'>
  <tr>
    <td>ENDPOINT:</td>
    <script>spaces(4)</script>
    <td><?php echo $url; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>
      INPUT:<br>
      <form action='json_view-test.php' method='post' target='_blank'>
        <input type='hidden' name='json' value='<?php echo $data; ?>'>
        <input type='submit' class='button' value='View JSON'>
      </form>
    </td>
    <td></td>
    <td><?php echo $data; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>
      RESPONSE:<br>
      <form action='json_view-test.php' method='post' target='_blank'>
        <input type='hidden' name='json' value='<?php echo $still_json; ?>'>
        <input type='submit' class='button' value='View JSON'>
      </form>
    </td>
    <td></td>
    <td><?php echo $still_json; ?></td>
  </tr>
  <?php
    if ( isset( $redirect ) ) {
      echo "<tr><td colspan='42'><hr></td></tr>";
      echo "<tr><td colspan='42' align='right'><a href='$redirect'><input type='submit' class='button' value='redirect'></a></td></tr>";
    }
  ?>
</table>
