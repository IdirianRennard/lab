<?php
include 'include.php';

$custom = json_decode( $_SESSION['CUSTOM'] );

if( $custom->ENV == 'live') {
  $endpoint = 'https://payflowpro.paypal.com';
} else {
  $endpoint = 'https://pilot-payflowpro.paypal.com';
}

$data = array();

foreach ($_SESSION as $k => $v) {
  $data["$k"] = $v;
}

$data['ACTION'] = 'D';
$data['AMT'] = $custom->AMT;
$data['CURRENCY'] = $custom->CURRENCY;
$data['NOTIFYURL'] = 'https://houserennard.online/idirian/ipn/ipn.php';

$myvars = urldecode( http_build_query( $data ) );

$headers[] = "PAYPAL-NVP:Y";

$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $endpoint );
curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

$resp = curl_exec( $ch );

parse_str( $resp, $resp );

ksort( $resp );

if ( isset( $resp['BILLINGAGREEMENTID'][19] ) ) {
  $_SESSION['BAID'] = $resp['BILLINGAGREEMENTID'][19];
}
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
    <td></td>
    <td colspan='42'><?php print_r( $resp ) ?>
  </tr>
  <?php
    if ( isset( $custom->BILLINGTYPE )  ) {
      echo "<tr><td colspan='42'><hr></td></tr>";
      echo "<tr><td colspan='42' align='right'><a href='ec-pf-doref.php'><input type='button' class='button' value=' DO REFERENCE '></a></tr></td>";
    } else {
      unset( $_SESSION );
      session_destroy();
    }
  ?>
</table>
