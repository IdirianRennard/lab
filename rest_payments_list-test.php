<?php
include 'include.php';
include './include/rest_functions.php';

$enviroment = $_POST['enviroment'];
unset( $_POST['enviroment'] );

$clientid = $_POST['ClientID'];
unset( $_POST['ClientID'] );

$secret = $_POST['Secret'];
unset( $_POST['Secret'] );

$token = rest_oauth( $clientid, $secret, $enviroment );

$datetime = $_POST['date'] . " " . $_POST['hours'] . ":" . $_POST['minutes'] . ":00";
$tz_to = 'UTC';
$format = 'Y-m-d\TH:i:s\Z';

$dt = new DateTime($datetime, new DateTimeZone($_POST['timezone']));

$dt->setTimeZone(new DateTimeZone($tz_to));

$start_time = $dt->format($format);

$end_time = gmdate( $format );

$data = [
  'count' => $_POST['count'],
  'start_index' => 0,
  'sort_by' => 'create_time',
  'sort_order' => 'desc',
  'start_time' => $start_time,
  'end_time' => $end_time
];

$data = urldecode( http_build_query( $data ) );

if ( $enviroment == 'production' ) {
  $url = "https://api.paypal.com/v1/payments/payment";
} else {
  $url = "https://api.sandbox.paypal.com/v1/payments/payment";
}

$url .= "?$data";

$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$request_id = '';

for ($i = 0 ; $i < 36 ; $i++) {
  $request_id .= $characters[mt_rand(0, strlen($characters) - 1)];
}

$header = [
  "Content-Type:application/json",
  "Authorization: Bearer $token",
  "PayPal-Request-Id: $request_id",
];

$rest_payments = curl_init();

curl_setopt( $rest_payments, CURLOPT_HTTPHEADER, $header );
curl_setopt( $rest_payments, CURLOPT_URL, $url );
curl_setopt( $rest_payments, CURLOPT_RETURNTRANSFER, true );

$result = urldecode ( curl_exec( $rest_payments ) );

?>
<table class='table'>
  <tr>
    <td>ENDPOINT:</td>
    <script>spaces(4)</script>
    <td><?php echo $url; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>RESPONSE:</td>
    <td></td>
    <td><?php echo $result; ?></td>
  </tr>
</table>
