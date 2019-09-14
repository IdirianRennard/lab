<?php
include 'include.php';

$EC_token = $_GET['token'];

$oauth = $_SESSION['oauth'];

$clientid = $_SESSION['client'];

$secret = $_SESSION['secret'];

if ( $_SESSION['env'] == 'Production' ) {
  $url = "https://api.paypal.com/v1/payments/billing-agreements/$EC_token/agreement-execute";
} else {
  $url = "https://api.sandbox.paypal.com/v1/payments/billing-agreements/$EC_token/agreement-execute";
}

$header = [
  "Content-Type:application/json",
  "Authorization: Bearer $oauth",
];

//$data_encode = json_encode( $data );

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$clientid:$secret");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_encode );

$result = curl_exec($ch);

$decode = json_decode( $result, true );
//$data = json_decode( $data, true );

?>
<table class='table'>
  <tr><td>URL:</td>
    <script>spaces(4)</script>
    <td><?php echo $url; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr><td>RESPONSE:<br>
    <form action='json_view-test.php' method='post' target='_blank'>
      <input type='hidden' name='json' value='<?php echo $result; ?>'>
      <input type='submit' class='button' value='View JSON'>
    </form></td>
    <script>spaces(4)</script>
    <td><?php echo $result; ?></td>
  </tr>
</table>
