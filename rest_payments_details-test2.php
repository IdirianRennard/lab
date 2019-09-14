<?php
include 'include.php';

if ( $_SESSION['enviroment'] == 'production' ) {
  $url = "https://api.paypal.com/v1/payments/payment/" . $_POST['pay_id'];
} else {
  $url = "https://api.sandbox.paypal.com/v1/payments/payment/" . $_POST['pay_id'];
}

$token = $_SESSION['token'];

$header = [
  "Content-Type:application/json",
  "Authorization: Bearer $token",
];

$rest_payments = curl_init();

curl_setopt( $rest_payments, CURLOPT_HTTPHEADER, $header );
curl_setopt( $rest_payments, CURLOPT_URL, $url );
curl_setopt( $rest_payments, CURLOPT_RETURNTRANSFER, true );

$response = urldecode ( curl_exec( $rest_payments ) );

?>
<table class='table'>
  <tr>
    <td>RESPONSE:</td>
    <script>spaces(4)</script>
    <td><?php print_r( $response ); ?></td>
  </tr>
</table>
<?php
  unset( $_SESSION );
  session_destroy();
?>
