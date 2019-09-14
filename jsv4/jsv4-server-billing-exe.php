<?php
session_start();

$info = $_SESSION;

$env = $info['enviroment'];
unset( $info['enviroment'] );


if ( $env == 'production' ) {
  $url = "https://api.paypal.com";
} else {
  $url = "https://api.sandbox.paypal.com";
}

$url .= '/v1/payments/billing-agreements/' . $_GET['token'] . '/agreement-execute';

$token = $info['token'];
unset( $info['token'] );

$rest_header = [
  "Content-Type:application/json",
  "Authorization: Bearer $token",
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_HTTPHEADER, $rest_header);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);

header('Content-Type: application/json');

echo $result;
?>
