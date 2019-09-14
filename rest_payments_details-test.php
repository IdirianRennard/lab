<?php
include 'include.php';

$enviroment = $_POST['enviroment'];
$_SESSION['enviroment'] = $enviroment;
unset( $_POST['enviroment'] );

if ( $enviroment == 'production' ) {
  $token_url = "https://api.paypal.com/v1/oauth2/token";
  $url = "https://api.paypal.com/v1/payments/payment";
} else {
  $token_url = "https://api.sandbox.paypal.com/v1/oauth2/token";
  $url = "https://api.sandbox.paypal.com/v1/payments/payment";
}

$clientid = $_POST['ClientID'];
$_SESSION['clientid'] = $clientid;
unset( $_POST['ClientID'] );

$secret = $_POST['Secret'];
$_SESSION['secret'] = $secret;
unset( $_POST['Secret'] );

$token = rest_oauth( $clientid, $secret, $enviroment );

$_SESSION['token'] = $token;

$header = [
  "Content-Type:application/json",
  "Authorization: Bearer $token",
];

$datetime = $_POST['date'] . " " . $_POST['hours'] . ":" . $_POST['minutes'] . ":00";
$tz_to = 'UTC';
$format = 'Y-m-d\TH:i:s\Z';

$dt = new DateTime($datetime, new DateTimeZone($_POST['timezone']));

$dt->setTimeZone(new DateTimeZone($tz_to));

$start_time = $dt->format($format);

$end_time = gmdate( $format );

$data = [
  'count' => 20,
  'start_index' => 0,
  'sort_by' => 'create_time',
  'sort_order' => 'desc',
  'start_time' => $start_time,
  'end_time' => $end_time
];

$data = urldecode( http_build_query( $data ) );

$url .= "?$data";

$rest_payments = rest_api( $url, NULL, $token );

$response = json_decode( urldecode ( curl_exec( $rest_payments ) ) );

$pay_ids = array();

for ( $i = 0 ; $i < count ( $response->payments ) ; $i++ ) {
  $pay_ids[$response->payments[$i]->id] = $response->payments[$i]->create_time . ' ' . $response->payments[$i]->payer->payer_info->shipping_address->recipient_name;
}

?>
<form action='rest_payments_details-test2.php' method='post'>
<table class='table'>
  <tr>
    <td>Select transacation</td>
    <script>spaces(4)</script>
    <td><select class='drop' name='pay_id'>
      <option selected disabled>Please Select a Transaction</option>
      <?php
      foreach ( $pay_ids as $k => $v ) {
        echo "<option value='$k'>$v $k</option>";
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
