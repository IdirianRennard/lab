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

$result = curl_exec($ch);

$result = json_decode( $result );

$token = $result->access_token;

curl_close($ch);

$url .= '/v1/notifications/webhooks-events';

$rest_header = [
  "Content-Type:application/json",
  "Authorization: Bearer $token",
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_HTTPHEADER, $rest_header);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


$result = curl_exec($ch);

$result = json_decode( $result );
?>

<table class='table'>
  <tr>
    <td>Endpoint:</td>
    <script>spaces(4)</script>
    <td><?php echo $url; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Events:</td>
  </tr>
  <tr><td><br></td></tr>
  <?php
    foreach ( $result->events as $k => $v ) {
      echo "<tr><td colspan='42'>";
      echo json_encode( $v );
      echo "</td></tr>";
      echo "<tr><td><br></td></tr>";
    };
    ?>
  </table>
