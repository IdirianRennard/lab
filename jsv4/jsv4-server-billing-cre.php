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
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$client:$secret");
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

$result = curl_exec($ch);

$result = json_decode( $result );

$token = $result->access_token;

$_SESSION['token'] = $token;

if ( $env == 'production' ) {
  $url = "https://api.paypal.com/v1/payments/billing-plans";
} else {
  $url = "https://api.sandbox.paypal.com/v1/payments/billing-plans";
}

class billing_plan {
  public $name = "JSv4 GCS Recurring Testing";
  public $description = "Recurring Testing using JSv4";
  public $type;
  public $payment_definitions = array();
  public $merchant_preferences;
}

class payment_definitions {
  public $name = "JSv4 GCS Recurring Testing";
  public $type = "REGULAR";
  public $frequency_interval;
  public $frequency;
  public $cycles;
  public $amount;
}

class amount {
  public $currency;
  public $value;
}

class merchant_preferences {
  public $setup_fee;
  public $cancel_url;
  public $return_url;
  public $notify_url;
  public $initial_fail_amount_action = "CANCEL";
  public $max_fail_attempts = "0";
  public $auto_bill_amount = "YES";
}

$data = new billing_plan ();

if ( $_SESSION['cycles'] == 0 ) {
  $data->type = "INFINITE";
} else {
  $data->type = "FIXED";
}

$data->payment_definitions[0] = new payment_definitions ();
$data->payment_definitions[0]->frequency = $_SESSION['freq'];
$data->payment_definitions[0]->frequency_interval = $_SESSION['freq_interval'];
$data->payment_definitions[0]->cycles = $_SESSION['cycles'];
$data->payment_definitions[0]->amount = new amount ();
$data->payment_definitions[0]->amount->currency = $_SESSION['CURRENCY'];
$data->payment_definitions[0]->amount->value = $_SESSION['amount'];

$data->merchant_preferences = new merchant_preferences ();
$data->merchant_preferences->return_url = $_SESSION['return'];
$data->merchant_preferences->cancel_url = $_SESSION['return'] . "/?cancel=1";


$data = json_encode( $data );

$rest_header = [
  "Content-Type:application/json",
  "Authorization: Bearer $token",
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_HTTPHEADER, $rest_header);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data );

$result = curl_exec($ch);

$decode = json_decode( $result );

$id  = $decode->id;
$create_time = $decode->create_time;

$url .= "/$id";

class value {
  public $state = "ACTIVE";
}

class update_plan {
  public $op = "replace";
  public $path = "/";
  public $value;

}

$data = [
  new update_plan (),
];

$data[0]->value = new value ();

$data = json_encode( $data );

$ch = curl_init();

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_HTTPHEADER, $rest_header);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data );

$result = curl_exec($ch);

if ( $env == 'production' ) {
  $url = "https://api.paypal.com//v1/payments/billing-agreements/";
} else {
  $url = "https://api.sandbox.paypal.com/v1/payments/billing-agreements/";
}

class shipping_address {
  public $line1 = '2211 N 1st St';
  public $city = 'San Jose';
  public $state = 'CA';
  public $postal_code = '95131';
  public $country_code = 'US';
}

class plan {
  public $id;
}

class payer_info {
  public $email;
}

class payer {
  public $payment_method = "paypal";
  public $payer_info;
}

class billing_agreement {
  public $name = "JSv4 GCS Recurring Testing";
  public $description = "Recurring Testing using JSv4";
  public $start_date;
  public $payer;
  public $plan;
  public $shipping_address;
}

$data = new billing_agreement ();
$data->start_date = date( 'c', strtotime( '+1 Day' ) );
$data->payer = new payer ();
$data->payer->payer_info = new payer_info ();

$data->plan = new plan ();
$data->plan->id = $id;

$data->shipping_address = new shipping_address ();

$data = json_encode( $data );

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_HTTPHEADER, $rest_header);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data );

$result = curl_exec($ch);

$result = json_decode( $result );

curl_close( $ch );

$ec_token = $result->links[0]->href;

if ( $env == 'production' ) {
  $ec_token = ltrim( $ec_token, 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' );
} else {
  $ec_token = ltrim( $ec_token, 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' );
}

class ba_data {
  public $id;
}

$ba_data = new ba_data ();
$ba_data->id = $ec_token;

header('Content-Type: application/json');

echo json_encode( $ba_data );
?>
