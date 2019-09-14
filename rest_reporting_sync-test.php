<?php
include 'include.php';

$enviroment = $_POST['enviroment'];
$_SESSION['enviroment'] = $enviroment;
unset( $_POST['enviroment'] );

if ( $enviroment == 'production' ) {
  $token_url = "https://api.paypal.com/v1/oauth2/token";
  $url = "https://api.paypal.com/v1/reporting/transactions";
} else {
  $token_url = "https://api.sandbox.paypal.com/v1/oauth2/token";
  $url = "https://api.sandbox.paypal.com/v1/reporting/transactions";
}

$clientid = $_POST['ClientID'];
$_SESSION['clientid'] = $clientid;
unset( $_POST['ClientID'] );

$secret = $_POST['Secret'];
$_SESSION['secret'] = $secret;
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
  'start_date' => $start_time,
  'end_date' => $end_time,
  'fields' => 'all',
  'page_size' => 100,
  'page' => 1,
];

if ( $_POST['transaction_id'] !== '' ) {
  $data['transaction_id'] = $_POST['transaction_id'];
  unset( $_POST['transaction_id'] );
}

$data = urldecode( http_build_query( $data ) );

$url .= "/?$data";

$resp = rest_api( $url, NULL, $token );

?>
<table class='table'>
  <tr>
    <td>URL:</td>
    <script>spaces(4)</script>
    <td><?php print_r( $url ); ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>RESPONSE:</td>
    <td></td>
    <td><?php print_r( $resp ); ?></td>
  </tr>
</table>
<?php
  unset( $_SESSION );
  session_destroy();
?>
