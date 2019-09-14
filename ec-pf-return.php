<?php
include 'include.php';

$enviroment = json_decode( $_SESSION['CUSTOM'] );

$enviroment = $enviroment->ENV;

if( $enviroment == 'live') {
  $endpoint = 'https://payflowpro.paypal.com';
} else {
  $endpoint = 'https://pilot-payflowpro.paypal.com';
}

foreach ($_SESSION as $key => $value) {
  $data["$key"] = $value;
}

$data['ACTION'] = 'G';
$data['TOKEN'] = $_GET['token'];

$myvars = urldecode( http_build_query( $data ) );

//$headers[] = "PAYPAL-NVP:Y";

$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $endpoint );
curl_setopt( $ch, CURLOPT_POST, 1 );
//curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

$resp = curl_exec( $ch );

parse_str( $resp, $resp );

ksort( $resp );
?>
<table class='table'>
  <tr>
    <td>ENDPOINT:</td>
    <script>spaces(4)</script>
    <td colspan='42'><?php echo $endpoint; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>INPUT:</td>
    <td></td>
    <td colspan='42'><?php echo $myvars; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr><td>RESPONSE:</td></tr>
  <tr><td><br></td></tr>
  <?php
    foreach ($resp as $k => $v) {
      echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
    }
    $_SESSION['TOKEN'] = $data['TOKEN'];
    $_SESSION['PAYERID'] = $_GET['PayerID'];
  ?>
  <tr><td colspan='42'><hr></td></tr>
  <tr><td colspan='42' align='right'><a href='ec-pf-execute.php'><input type='button' class='button' value=' EXECUTE '></a></td></tr>
</table>
