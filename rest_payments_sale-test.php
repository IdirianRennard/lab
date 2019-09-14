<?php
include 'include.php';

$enviroment = $_POST['enviroment'];
unset( $_POST['enviroment'] );

if ( $enviroment == 'production' ) {
  $token_url = "https://api.paypal.com/v1/oauth2/token";
  $url = "https://api.paypal.com";
} else {
  $token_url = "https://api.sandbox.paypal.com/v1/oauth2/token";
  $url = "https://api.sandbox.paypal.com";
}

$clientid = $_POST['ClientID'];
unset( $_POST['ClientID'] );

$secret = $_POST['Secret'];
unset( $_POST['Secret'] );

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $token_url );
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$clientid:$secret");
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

$result = curl_exec( $ch );

$json = json_decode( $result );
$token = $json->access_token;

curl_close($ch);

$_SESSION = [
  'token' => $token,
  'env' => $enviroment,
  'client' => $clientid,
  'secret' => $secret,
];

echo "<script>console.log( 'Token => $token' )</script>";

$rest_header = [
  "Content-Type:application/json",
  "Authorization: Bearer $token",
];

$datetime = $_POST['date'] . " " . $_POST['hours'] . ":" . $_POST['minutes'] . ":00";
$tz_to = 'UTC';
$format = 'Y-m-d\TH:i:s\Z';

$dt = new DateTime($datetime, new DateTimeZone($_POST['timezone']));

$dt->setTimeZone(new DateTimeZone($tz_to));

$start_time = $dt->format($format);

echo "<script>console.log( 'Start Time => $start_time' )</script>";

$end_time = gmdate( $format );

echo "<script>console.log( 'End Time => $end_time' )</script>";

$data = [
  'count' => 20,
  'start_index' => 0,
  'sort_by' => 'create_time',
  'sort_order' => 'desc',
  'start_time' => $start_time,
  'end_time' => $end_time
];

$data = urldecode( http_build_query( $data ) );

$url .= "/v1/payments/payment?$data";

$rest_payments = curl_init();

curl_setopt( $rest_payments, CURLOPT_HTTPHEADER, $rest_header );
curl_setopt( $rest_payments, CURLOPT_URL, $url );
curl_setopt( $rest_payments, CURLOPT_RETURNTRANSFER, true );

$result = curl_exec( $rest_payments );

curl_close( $rest_payments );

echo "<script>console.log( 'Result => $result' )</script>";

$result = json_decode( $result );

$result->payments[0]->transactions[0]->related_resources[0]->sale->id;

$trx_ids = array();

for ( $i = 0 ; $i < count ( $result->payments ) ; $i++ ) {
  $trx_ids[$result->payments[0]->transactions[0]->related_resources[0]->sale->id] = $result->payments[0]->transactions[0]->related_resources[0]->sale->id . ' ' . $result->payments[$i]->payer->payer_info->shipping_address->recipient_name;
}
?>
<form action='rest_payments_sale-test2.php' method='post'>
<table class='table'>
  <tr>
    <td>Select transacation</td>
    <script>spaces(4)</script>
    <td>
      <select class='drop' name='trx_id'>
        <option selected disabled>Please Select a Transaction</option>
        <?php
        foreach ( $trx_ids as $k => $v ) {
          echo "<option value='$k'>$v</option>";
        }
        ?>
      </select>
    </td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td colspan='42' align='right'><input type='submit' class='button' value=' SUBMIT '></td>
  </tr>
</table>
