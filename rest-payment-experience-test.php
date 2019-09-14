<?php


$enviroment = $_POST['enviroment'];
unset( $_POST['enviroment'] );

if ( $enviroment == 'production' ) {
  $url = "https://api.paypal.com";
} else {
  $url = "https://api.sandbox.paypal.com";
}

$token_url = $url . "/v1/oauth2/token";

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

$json = $result;

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

$url .= '/v1/payment-experience/web-profiles';

class profile {
    public $name;
    public $presentation;
    public $input_fields;
    public $flow_config;
}

class presentation {
    public $logo_image;
}

class input_fields {
    public $no_shipping;
    public $address_override;
}

class flow_config {
    public $landing_page_type;
}

$profile = new profile ();

$profile->name = $_POST['name'];

$profile->presentation = new presentation ();
$profile->presentation->logo_image = $_POST['logo_image'];

$profile->input_fields  = new input_fields ();
$profile->input_fields->no_shipping = $_POST['no_shipping'];
$profile->input_fields->address_override = $_POST['address_override'];

$profile->flow_config = new flow_config ();
$profile->flow_config->landing_page_type = $_POST['landing_page'];

$data = json_encode( $profile );

$ch = curl_init();

curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data );

$resp = curl_exec( $ch );

header('Content-Type: application/json');

echo $resp;
?>
