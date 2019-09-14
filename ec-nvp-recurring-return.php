<?php
include 'include.php';

$dt = base64_decode( $_GET['dt'] );
parse_str( $dt, $dt );

$enviroment = $dt['ENVIROMENT'];

$date = date("Y-m-d");
$tomorrow = date( "Y-m-d", strtotime($date. ' + 7 days') ) . "T00:00:00Z";
$profile_ref = date( "YMDHis" );

$data = [
  'USER'              =>  $dt['USER'],
  'PWD'               =>  $dt['PWD'],
  'SIGNATURE'         =>  $dt['SIGNATURE'],
  'PROFILESTARTDATE'  =>  $tomorrow,
  'PROFILEREFERENCE'  =>  $profile_ref,
  'BILLINGPERIOD'     =>  'Day',
  'BILLINGFREQUENCY'  =>  12,
  'AMT'               =>  $dt['AMT'],
  'INITAMT'           =>  $dt['INITAMT'],
  'METHOD'            => 'CreateRecurringPaymentsProfile',
  'VERSION'           =>  204,
  'PAYERID'           =>  $_GET['PayerID'],
  'TOKEN'             =>  $_GET['token'],
  'DESC'              =>  'House Rennard NVP Recurring Test',
];

ksort( $data );

$myvars = urldecode( http_build_query( $data ) );

if ( $enviroment == 'sandbox' ) {
  $url = 'https://api-3t.sandbox.paypal.com/nvp';
} else {
  $url = 'https://api-3t.paypal.com/nvp';
}

$result = nvp_api( $url, $myvars );

$resp_string = $result;

parse_str( $result, $resp );

ksort( $resp );

?>
<table class='table'>
  <tr><td>ENDPOINT:</td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan='42'><?php echo $url; ?></td></tr>
  <tr><td><br></td></tr>
  <tr><td><br></td></tr>
  <?php
    echo "<tr><td colspan='42' align='left'>INPUT:</td></tr>";
    echo "<tr><td><br></td></tr>";
    echo "<tr><td colspan='42'>$myvars</td></tr>";
    echo "<tr><td><br></td></tr>";
    foreach ($data as $k => $v) {
        echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
    }

    echo "<tr><td><br></td></tr>";
    echo "<tr><td><br></td></tr>";

    echo "<tr><td colspan='42' align='left'>RESPONSE:</td></tr>";
    echo "<tr><td><br></td></tr>";
    echo "<tr><td colspan='42'>$resp_string</td></tr>";
    echo "<tr><td><br></td></tr>";
    foreach ($resp as $k => $v) {
      echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
    }
    echo "<tr><td><br></td></tr>";
  ?>
  </tr>
</table>