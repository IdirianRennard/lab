<?php
include "include.php";
include 'include/rest_functions.php';

$params = urldecode( base64_decode( $_GET['params'] ) );

parse_str( $params, $params );

$enviroment = $params['ENVIROMENT'];
$clientid = $params['CLIENTID'];
$secret = $params['SECRET'];

if ( $enviroment == 'production' ) {
  $url = "https://api.paypal.com";
} else {
  $url = "https://api.sandbox.paypal.com";
}

$execute_url = $url . '/v1/payments/payment/' . $_GET['paymentId'] . "/execute";

class execute {
  public $payer_id;
}

$execute = new execute;

$payer_id = $_GET['PayerID'];

$execute->payer_id = $payer_id;

$execute = json_encode( $execute );

$token = rest_oauth ( $clientid, $secret, $enviroment );

$res_e = rest_api( $execute_url, $execute, $token );

?>
<table class='table'>
  <tr> 
    <td>ENDPOINT:</td>  
    <script>spaces(4)</script>
    <td><?php echo $execute_url; ?></td>
  </tr>
  <tr><td><br><br></td>
  <tr>
    <td>INPUT:</td>
    <td></td>
    <td><?php echo $execute; ?></td>
  </tr>
  <tr><td><br><br></td>
  <tr>
    <td>RESPONSE:</td>
    <script>spaces(4)</script>
    <td><?php print_r( $res_e ); ?></td>
  </tr>
</table>
<?php
  unset( $_SESSION );
  session_destroy();
?>
