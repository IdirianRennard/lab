<?php
include 'include.php';

$enviroment = $_POST['enviroment'];
unset( $_POST['enviroment'] );

if ( $enviroment == 'production' ) {
  $url = "https://api.paypal.com";
} else {
  $url = "https://api.sandbox.paypal.com";
}

$clientid = $_POST['ClientID'];
unset( $_POST['ClientID'] );

$secret = $_POST['Secret'];
unset( $_POST['Secret'] );

$token = rest_oauth( $clientid, $secret, $enviroment );

$_SESSION = [
  'token' => $token,
  'env' => $enviroment,
  'client' => $clientid,
  'secret' => $secret,
  'action' => $_POST['action'],
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

$url .= "/v1/payments/payment?$data";

$result = rest_api ( $url, $data, $token );

$result = json_decode( $result );

$trx_ids = array();

for ( $i = 0 ; $i < count( $result->payments ) ; $i++ ) {

  if( $result->payments[$i]->intent == 'authorize' ) {

    $value = $result->payments[$i]->transactions[0]->related_resources[0]->authorization->id;
    $value .= ' | ' . $result->payments[$i]->payer->payer_info->shipping_address->recipient_name;
    $value .= ' | ' . $result->payments[$i]->transactions[0]->amount->total;
    $value .= ' ' . $result->payments[$i]->transactions[0]->amount->currency;

    $key = [
      'trx_id' => $result->payments[$i]->transactions[0]->related_resources[0]->authorization->id,
      'amt' => $result->payments[$i]->transactions[0]->amount->total,
      'cc' => $result->payments[$i]->transactions[0]->amount->currency,
    ];

    $key = urldecode( http_build_query( $key ) );

    $trx_ids[ $key ] = $value;

    echo "<script>console.log( '$key => $value' )</script>";

  }
}
?>

<form action='rest_auth_c_v-test2.php' method='post'>
<table class='table'>
  <tr>
    <td>Select transacation</td>
    <script>spaces(4)</script>
    <td><select class='drop' name='trx_id'>
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
