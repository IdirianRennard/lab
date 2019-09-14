<?php
session_start();

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

if ( empty($result) ) {
  die("Error: No response.");
} else {
  $json = json_decode($result, true);
  $oauth = $json['access_token'];
}

curl_close($ch);

$_SESSION = [
  'oauth' => $oauth,
  'env' => $enviroment,
  'client' => $clientid,
  'secret' => $secret,
];

header( "location: rest-test2.php" );
?>
