<?php
include 'include.php';

unset( $_SESSION['PAYERID'] );
unset( $_SESSION['TOKEN'] );

$custom = json_decode( $_SESSION['CUSTOM'] );

if( $custom->ENV == 'live') {
  $endpoint = 'https://payflowpro.paypal.com';
} else {
  $endpoint = 'https://pilot-payflowpro.paypal.com';
}

$data= array();

foreach ($_SESSION as $k => $v) {
  $data["$k"] = $v;
}

$data['AMT'] = $custom->AMT;
$data['ACTION'] = 'D';
$data['NOTIFYURL'] = 'https://houserennard.online/idirian/ipn/ipn.php';

ksort( $data );

//print_r( $data );

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
    <td>INPUT:</td>
    <script>spaces(4)</script>
    <td colspan='42'><?php echo $myvars; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>RESPONSE:</td>
  </tr>
  <tr><td><br></td></tr>
  <?php
  foreach ($resp as $k => $v) {
    echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
  }
  ?>
</table>
<?php
  unset( $_SESSION );
  session_destroy();
?>
