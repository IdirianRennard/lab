<?php
session_start();

$info = $_SESSION;

$env = $info['enviroment'];
unset( $info['enviroment'] );

if ( $env == 'production' ) {
  $token_url = "https://api.paypal.com/v1/oauth2/token";
  $url = "https://api.paypal.com";
} else {
  $token_url = "https://api.sandbox.paypal.com/v1/oauth2/token";
  $url = "https://api.sandbox.paypal.com";
}

$client = $info['client'];
unset( $info['client'] );

$secret = $info['secret'];
unset( $info['secret'] );

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $token_url );
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$client:$secret");
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

$result = curl_exec($ch);

$result = json_decode( $result );

$token = $result->access_token;

$_SESSION['token'] = $token;

$url .= '/v1/payments/payment';

$rest_header = [
  "Content-Type:application/json",
  "Authorization: Bearer $token",
];

class data {

};

$data = new data ();
$data->payer = new data ();
$data->transactions = array ();
$data->transactions[0] = new data ();
$data->transactions[0]->amount = new data ();
$data->transactions[0]->item_list = new data ();
$data->redirect_urls = new data ();

$data->intent = $info['intent'];
$data->payer->payment_method = 'paypal';

$data->transactions[0]->amount->total = $info['amount'];
$data->transactions[0]->amount->currency = 'USD';

$data->transactions[0]->item_list->items = array();
$data->transactions[0]->item_list->items[0] = new data ();
$data->transactions[0]->item_list->items[0]->name = 'Rennard Coin';
$data->transactions[0]->item_list->items[0]->description = 'Rare Metal Coin stamped with Rennard Seal';
$data->transactions[0]->item_list->items[0]->quantity = 1;
$data->transactions[0]->item_list->items[0]->price = $info['amount'];
$data->transactions[0]->item_list->items[0]->tax = 0;
$data->transactions[0]->item_list->items[0]->currency = 'USD';

$data->redirect_urls->return_url = $info['return'];
$data->redirect_urls->cancel_url = $info['return'] . '?cancel=true';

$data = json_encode( $data );

$ch = curl_init();

curl_setopt($ch, CURLOPT_HTTPHEADER, $rest_header);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data );

$resp = curl_exec( $ch );

curl_close( $ch );

header('Content-Type: application/json');

echo $resp;
?>
