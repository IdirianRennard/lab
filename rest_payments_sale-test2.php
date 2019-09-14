<?php
include 'include.php';

if ( $_SESSION['env'] == 'production' ) {
  $token_url = "https://api.paypal.com/v1/oauth2/token";
  $url = "https://api.paypal.com";
} else {
  $token_url = "https://api.sandbox.paypal.com/v1/oauth2/token";
  $url = "https://api.sandbox.paypal.com";
}

$token = $_SESSION['token'];

$rest_header = [
  "Content-Type:application/json",
  "Authorization: Bearer $token",
];

$url .= '/v1/payments/sale/' . $_POST['trx_id'];

$ch = curl_init();

curl_setopt($ch, CURLOPT_HTTPHEADER, $rest_header);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec( $ch );

curl_close( $ch );
?>
<table class='table'>
  <tr>
    <td>ENDPOINT:</td>
    <script>spaces(4)</script>
    <td><?php echo $url; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>RESPONSE:<br>
      <form action='json_view-test.php' method='post' target='_blank'>
        <input type='hidden' name='json' value='<?php echo $result; ?>'>
        <input type='submit' class='button' value='view json'>
      </form></td>
    <td></td>
    <td><?php echo $result; ?></td>
  </tr>
</table>
