<?php 
include '../include/rest_functions.php';

session_start();

$clientid = $_SESSION['client'];
$secret = $_SESSION['secret'];
$enviroment = $_SESSION[ 'enviroment'] ; 

$token = rest_oauth( $clientid, $secret, $enviroment );

if ( $enviroment == 'production' ) {
    $url = "https://api.paypal.com/v1/payments/billing-plans";
  } else {
    $url = "https://api.sandbox.paypal.com/v1/payments/billing-plans";
  }

class billing_plan {
    public $name = "JSv4 - v2 - GCS Recurring Testing";
    public $description = "Recurring Testing using JSv4 - v2";
    public $type;
    public $payment_definitions = array();
    public $merchant_preferences;
}
  
class payment_definitions {
    public $name = "JSv4 - v2 - GCS Recurring Testing";
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
  
$data->type = "INFINITE";
  
$data->payment_definitions[0] = new payment_definitions ();
$data->payment_definitions[0]->frequency = 'DAY';
$data->payment_definitions[0]->frequency_interval = 1;
$data->payment_definitions[0]->cycles = 0;
$data->payment_definitions[0]->amount = new amount ();
$data->payment_definitions[0]->amount->currency = $_SESSION['CURRENCY'];
$data->payment_definitions[0]->amount->value = $_SESSION['amount'];
  
$data->merchant_preferences = new merchant_preferences ();
$data->merchant_preferences->return_url = $_SESSION['return'];
$data->merchant_preferences->cancel_url = $_SESSION['return'] . "/?cancel=1";
  
  
$data = json_encode( $data );

$plan = rest_api( $url, $data, $token );

$plan = json_decode( $plan );

$create_time = $plan->create_time;

$url .= "/" . $plan->id;

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

$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$request_id = '';

for ($i = 0 ; $i < 36 ; $i++) {
    $request_id .= $characters[mt_rand(0, strlen($characters) - 1)];
}

$rest_header = [
    "Content-Type:application/json",
    "Authorization: Bearer $token",
    "PayPal-Request-Id: $request_id",
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_HTTPHEADER, $rest_header);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data );

$result = curl_exec($ch);

if ( $enviroment == 'production' ) {
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
    public $name = "JSv4 - v2 - GCS Recurring Testing";
    public $description = "Recurring Testing using JSv4 - v2";
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
$data->plan->id = $plan->id;
  
$data->shipping_address = new shipping_address ();
  
$data = json_encode( $data );

$agreement = rest_api( $url, $data, $token );

echo $agreement;

/*$agreement = json_decode( $agreement );

$plan = $agreement->plan;

$plan = json_encode( $plan );

echo $plan;
/*$ec_token = $agreement->links[0]->href;

$ec_token = substr( $ec_token, strpos( $ec_token, "?" ) + 1 );

parse_str( $ec_token, $ec_token );

$ec_token = $ec_token['token'];

class ba_data {
    public $id;
}
  
$ba_data = new ba_data ();
$ba_data->id = $ec_token;
  
 
echo json_encode( $ba_data );*/
?>