<?php
include 'include.php';

if( $_POST['enviroment'] === 'sandbox' ) {
  $url = "https://api-3t.sandbox.paypal.com/nvp";
} else {
  $url = "https://api-3t.paypal.com/nvp";
}


$datetime = $_POST['date'] . " " . $_POST['hours'] . ":" . $_POST['minutes'] . ":00";
unset( $_POST['date'] );
unset( $_POST['hours'] );
unset( $_POST['minutes'] );
$tz_to = 'UTC';
$format = 'Y-m-d\TH:i:s\Z';

$dt = new DateTime($datetime, new DateTimeZone($_POST['timezone']));

$dt->setTimeZone(new DateTimeZone($tz_to));

$start_date = $dt->format($format);

$end_date = gmdate( $format );

$data = [
  'USER' => $_POST['USER'],
  'PWD' => $_POST['PWD'],
  'SIGNATURE' => $_POST['SIGNATURE'],
  'METHOD' => 'TransactionSearch',
  'STARTDATE' => $start_date,
  'ENDDATE'=> NULL,//$end_date,
  'VERBOSITY' => 'HIGH',
  'VERSION' => 94,
];

if( $_POST['status'] == NULL ) {
  unset(  $_POST['status'] );
} else {
  $data['STATUS'] = $_POST['status'];
}

$data_arr = $data;

$data = urldecode( http_build_query( $data ) );

$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
curl_setopt( $ch, CURLOPT_HEADER, 0 );
curl_setopt( $ch, CURLOPT_TIMEOUT, 1000 );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$resp = urldecode( curl_exec( $ch ) );
$resp_string = $resp;

parse_str( $resp, $resp )
?>
<table class='table'>
  <tr>
    <td colspan="42" align='left'>ENDPOINT:</td>
    <td></td>
    <td><?php echo $url; ?></td>
  </tr><td colspan="42" align='left'></td>
  <tr><td><br></td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan="42" align='left'>INPUT:</td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan='999'><?php echo $data; ?></td></tr>
  <tr><td><br></td></tr>
  <?php
  foreach ($data_arr as $k => $v) {
    echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
  }
  ?>
  <tr><td><br></td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan="42" align='left'>RESPONSE:</td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan='999'><?php echo $resp_string; ?></td></tr>
  <tr><td><br></td></tr>
  <?php
  foreach ($resp as $k => $v) {
    echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
  }
  ?>
</table>
