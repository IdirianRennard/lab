<?php
include 'include/rest_functions.php';

$return_file_path = 'https://localhost' . rtrim(  $_SERVER['PHP_SELF'], basename( $_SERVER['PHP_SELF'] ) ) ;

$enviroment = $_POST['enviroment'];
unset( $_POST['enviroment'] );

if ( $enviroment == 'production' ) {
  $url = "https://api.paypal.com";
} else {
  $url = "https://api.sandbox.paypal.com";
}

$clientid = $_POST['ClientID'];
unset( $_POST['ClientID'] );

$secret = $_POST['Secret'];
unset( $_POST['Secret'] );

$token = rest_oauth ( $clientid, $secret, $enviroment );

class billing_plan {
  public $name = "Testing GCS";
  public $description = "Recurring Testing";
  public $type;
  public $payment_definitions = array();
  public $merchant_preferences;
}

class payment_definitions {
  public $name = "Recurring Testing";
  public $type = 'REGULAR';
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

$data->payment_definitions[0] = new payment_definitions ();

if( $_POST['no_cycles'] == 0 || $_POST['no_cycles'] == NULL ) {
  $data->type = 'INFINITE';
} else {
  $data->type = 'FIXED';
}

$data->payment_definitions[0]->frequency = $_POST['cycle'];
$data->payment_definitions[0]->frequency_interval = $_POST['frequency'];
$data->payment_definitions[0]->cycles = $_POST['no_cycles'];

$data->payment_definitions[0]->amount = new amount ();
$data->payment_definitions[0]->amount->currency = $_POST['CURRENCY'];
$data->payment_definitions[0]->amount->value = $_POST['amount'];

if ( isset( $_POST['trial'] ) ) {
  $data->payment_definitions[1] = new payment_definitions ();
  $data->payment_definitions[1]->name = "Trial for GCS Testing";
  $data->payment_definitions[1]->type = "TRIAL";
  $data->payment_definitions[1]->frequency = $_POST['tr_cycle'];
  $data->payment_definitions[1]->frequency_interval = $_POST['tr_frequency'];
  $data->payment_definitions[1]->cycles = $_POST['tr_frequency'];

  $data->payment_definitions[1]->amount = new amount ();
  $data->payment_definitions[1]->amount->currency = $_POST['CURRENCY'];
  $data->payment_definitions[1]->amount->value = $_POST['tr_amount'];
}

$data->merchant_preferences = new merchant_preferences ();
$data->merchant_preferences->setup_fee = new amount ();
$data->merchant_preferences->setup_fee->value = $_POST['setup'];
$data->merchant_preferences->setup_fee->currency = $_POST['CURRENCY'];

$url_append = [
  'auth' => $token,
  'env' => $enviroment,
];

$url_append = base64_encode( http_build_query( $url_append ) );

$data->merchant_preferences->return_url = $return_file_path . "rest_bpba-return.php?auth=$url_append";
$data->merchant_preferences->cancel_url = $return_file_path . 'test.php?cancel=true';
$data->merchant_preferences->notify_url = 'https://houserennard.online/idirian/ipn.php';

$myvars = json_encode( $data );

$url .= '/v1/payments/billing-plans';

$result = rest_api ( $url, $myvars, $token );

$json = $result;

$result = json_decode( $result );

if ( isset( $result->id ) ) {
  $id = $result->id;
} else {
  
  echo "<table class=table>";
  echo "<tr><td colspan='42'>Error on Creating Billing Plan:</td></tr>";
  echo "<tr><td><br></td></tr>";
  echo "<tr><td>Endpoint:</td><tr><td><br></td></tr><td>$url</td></tr>";
  echo "<tr><td><br></td></tr><tr><td><br></td></tr>";
  echo "<tr><td>Sent:</td></tr><tr><td><br></td></tr><tr><td colspan='42'>$myvars</td></tr>";
  echo "<tr><td><br></td></tr><tr><td><br></td></tr>";
  echo "<tr><td>Received:</td></tr><tr><td><br></td></tr><tr><td colspan='42'>$json</td></tr>";
  echo "</table>";
  exit;
}

$patch_url = "$url/$id";

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

$myvars = json_encode( $data );

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

curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
curl_setopt( $ch, CURLOPT_URL, $patch_url );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $header);
curl_setopt( $ch, CURLOPT_POST, true);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars );

$result = curl_exec( $ch );

echo "<script>console.log( $result )</script>";

$url = rtrim( $url, 'billing-plans' );

$url .= 'billing-agreements/';

class shipping_address {
  public $line1 = "123 Fake St";
  public $city = "Omaha";
  public $state = "NE";
  public $postal_code = "68116";
  public $country_code = "US";
}

class plan {
  public $id;
}

class payer_info {
  public $email = 'example@houserennard.online';
}

class payer {
  public $payment_method = "paypal";
  public $payer_info;
}

class billing_agreement {
  public $name;
  public $start_date;
  public $payer;
  public $plan;
  //public $shipping_address;
  //public $input_fields;
}

class input_fields {
  public $no_shipping = 1;
  public $address_override = 1;
}

$clip = new billing_plan;

$data = new billing_agreement ();

//$data->input_fields = new input_fields ();

//$data->experience_profile_id = "XP-HLCL-BM2F-LPGY-3ZSN";
$data->name = $clip->name;
$data->description = $clip->description;
$data->start_date = date( 'c', strtotime( '+1 Day' ) );
$data->payer = new payer ();
$data->payer->payer_info = new payer_info ();
$data->plan = new plan ();
$data->plan->id = $id;
$data->shipping_address = new shipping_address ();

$myvars = json_encode( $data );

$result = rest_api ( $url, $myvars, $token );

$json = $result;

$result = json_decode( $result );

if ( isset( $result->links[0]->href ) ) {
  $redirect = $result->links[0]->href;
} else {
  
  echo "<table class=table>";
  echo "<tr><td colspan='42'>Error on Creating Billing Agreement:</td></tr>";
  echo "<tr><td><br></td></tr>";
  echo "<tr><td>Endpoint:</td><tr><td><br></td></tr><td>$url</td></tr>";
  echo "<tr><td><br></td></tr><tr><td><br></td></tr>";
  echo "<tr><td>Sent:</td></tr><tr><td><br></td></tr><tr><td colspan='42'>$myvars</td></tr>";
  echo "<tr><td><br></td></tr><tr><td><br></td></tr>";
  echo "<tr><td>Received:</td></tr><tr><td><br></td></tr><tr><td colspan='42'>$json</td></tr>";
  echo "</table>";
  exit;
}
header( "location: $redirect&user_action=commit" );
?>
