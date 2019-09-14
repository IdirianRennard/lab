<?php
include '../include/rest_functions.php';

session_start();

$client = $_SESSION[ 'client' ];
$secret = $_SESSION[ 'secret' ];
$enviroment = $_SESSION[ 'enviroment'] ; 


if ( $enviroment == 'production' ) {
    $token_url = "https://api.paypal.com/v1/oauth2/token";
    $url = "https://api.paypal.com";
} else {
    $token_url = "https://api.sandbox.paypal.com/v1/oauth2/token";
    $url = "https://api.sandbox.paypal.com";
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

$url .= '/v2/checkout/orders';

$header = [
    "Content-Type:application/json",
    "Authorization: Bearer $token",
];

class order {
    public $intent;
    public $purchase_units;
    public $application_context;
}

class amount {
    public $currency_code;
    public $value;
}

class item {
    public $name = "Idirian's test object";
    public $quantity = 1;
    public $description = "Idirian's test object";
}

class purchase_units {
    public $amount;
}

class urls {
    public $cancel_url = 'https://localhost/test/idirian/v2-orders-return.php?rv=cancel';
    public $return_url = 'https://localhost/test/idirian/v2-orders-return.php?rv=return&a=';
}

$trans = new order ();

$trans->application_context = new urls;
$trans->intent = strtoupper( $_SESSION[ 'intent' ] );
$trans->purchase_units = array();

$amount = new amount ();
$amount->currency_code = $_SESSION[ 'CURRENCY' ];
$amount->value = $_SESSION[ 'amount' ];

$item = new item ();
$trans->item  = $item;

$trans->purchase_units[0] = new purchase_units ();
$trans->purchase_units[0]->amount = $amount;

$data = json_encode( $trans );

$ch = curl_init();

curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data );

$result = curl_exec( $ch );

curl_close( $ch );

header('Content-Type: application/json');

echo $result;

?>