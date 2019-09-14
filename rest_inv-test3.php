<?php
include 'include.php';

$token = $_SESSION['token'];
$url = $_SESSION['url'];
$clientid = $_SESSION['clientid'];
$secret = $_SESSION['secret'];

$header = [
  "Content-Type:application/json",
  "Authorization: Bearer $token",
];

$ch_e = curl_init();

curl_setopt($ch_e, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch_e, CURLOPT_URL, $url);
curl_setopt($ch_e, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch_e, CURLOPT_POSTFIELDS, "" );

$res_e = curl_exec( $ch_e );

curl_close( $ch_e );

?>
<table class='table'>
  <tr>
    <td>URL:</td>
    <script>spaces(4)</script>
    <td><?php echo $url; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <?php
    $json = $res_e;

    $res_e = json_decode( $res_e );

    echo "<tr>";
    if ( isset( $res_e->name ) ) {
      echo "<td>RESPONSE:</td><td></td><td>";
      print_r( $json );
    } else {
      echo "<td colspan='42' align='center'>Invoice Sent Correctly!";
    }
    echo "</td></tr>";
  ?>
</table>
<?php
  unset( $_SESSION );
  session_destroy();
?>
