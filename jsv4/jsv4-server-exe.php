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


$token = $info['token'];

$url .= '/v1/payments/payment/' . $_POST['paymentID'] . '/execute';

$rest_header = [
  "Content-Type:application/json",
  "Authorization: Bearer $token",
];

class execute {
  public $payer_id;
}

$execute = new execute;

$payer_id = $_POST['payerID'];

$execute->payer_id = $payer_id;

$execute = json_encode( $execute );

$ch = curl_init();

curl_setopt($ch, CURLOPT_HTTPHEADER, $rest_header);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $execute );

$resp = curl_exec( $ch );

curl_close( $ch );

header('Content-Type: application/json');

echo $resp;
?>
