<?php

session_start();

$client = $_SESSION['client'];
$secret = $_SESSION['secret'];
$enviroment = $_SESSION['enviroment'] ; 
$orderId = $_GET[ 'orderID' ];
$intent = $_SESSION['intent'];

if ( $enviroment == 'production' ) {
    $token_url = "https://api.paypal.com/v1/oauth2/token";
    $url = "https://api.paypal.com/v2/checkout/orders/" . $orderId . "/$intent";
} else {
    $token_url = "https://api.sandbox.paypal.com/v1/oauth2/token";
    $url = "https://api.sandbox.paypal.com/v2/checkout/orders/" . $orderId . "/$intent";
}

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $token_url );
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$client:$secret");
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

$result = curl_exec($ch);

curl_close($ch);

$result = json_decode( $result );

$token = $result->access_token;

$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$request_id = '';

for ($i = 0 ; $i < 36 ; $i++) {
  $request_id .= $characters[mt_rand(0, strlen($characters) - 1)];
}

$header = [
    "Content-Type:application/json",
    "Authorization: Bearer $token",
    "PayPal-Request-Id: $request_id",
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, '' );

$resp = curl_exec( $ch );

header('Content-Type: application/json');

echo $resp;

?>