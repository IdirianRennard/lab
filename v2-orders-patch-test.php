<?php
include 'include.php';

class data {

}


$client = $_POST[ 'ClientID' ];
$_SESSION['client'] = $_POST[ 'ClientID' ];

$secret = $_POST[ 'Secret' ];
$_SESSION['secret'] = $_POST[ 'Secret' ];

$enviroment = $_POST[ 'enviroment'] ; 
$_SESSION[ 'enviroment' ] = $_POST[ 'enviroment' ];

if ( $enviroment == 'production' ) {
    $token_url = "https://api.paypal.com/v1/oauth2/token";
    $url = "https://api.paypal.com";
} else {
    $token_url = "https://api.sandbox.paypal.com/v1/oauth2/token";
    $url = "https://api.sandbox.paypal.com";
}

$token = rest_oauth( $client, $secret, $enviroment );

$url .= '/v2/checkout/orders';

class order {
    public $application_context;
    public $intent;
    public $purchase_units;
}

class amount {
    public $currency_code;
    public $value;
}

class purchase_units {
    public $amount;
}

class urls {
    public $cancel_url = 'https://localhost/test/idirian/v2-orders-return.php?rv=cancel';
    public $return_url = 'https://localhost/test/idirian/v2-orders-return.php?rv=return';
}

$trans = new order ();

$trans->application_context = new urls;

$trans->intent = strtoupper( $_POST[ 'intent' ] );
$trans->purchase_units = array();

$amount = new amount ();
$amount->currency_code = $_POST[ 'CURRENCY' ];
$amount->value = $_POST[ 'amount' ];

$trans->purchase_units[0] = new purchase_units ();
$trans->purchase_units[0]->amount = $amount;
$trans->purchase_units[0]->description = "This is the initial descr.";

$data = json_encode( $trans );

$result = rest_api( $url, $data, $token );

$result = json_decode( $result );

$patch_url = $result->links[2]->href;
console( $patch_url );

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

$data = new data ();

$data->op = 'replace';
$data->path = "/purchase_units/@reference_id=='default'/description";
$data->value = new data ();
$data->value->description = "Patch new Descr";

$myvars = [];

$myvars[] = $data;

$myvars = json_encode( $myvars );

$ch = curl_init();

curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
curl_setopt( $ch, CURLOPT_URL, $patch_url );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $header);
curl_setopt( $ch, CURLOPT_POST, true);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars );

$result = curl_exec( $ch );

console( $result );
echo $result;