<?php
include 'include.php';

class data {

}

$clientid = $_POST['ClientID'];
$secret = $_POST['Secret'];
$enviroment  = $_POST['enviroment'];

$token = rest_oauth( $clientid, $secret, $enviroment );

if ( $enviroment == 'production' ) {
    $base_url = "https://api.paypal.com";
} else {
    $base_url = "https://api.sandbox.paypal.com";
}

$data = new data ();

$data->name = 'Rennard REST Sub Testing';
$data->description = 'Rennard Testing of REST API Subscriptions';
$data->status = 'Rennard Testing of REST API Subscriptions';
$data->type = 'SERVICE';
$data->category = 'SOFTWARE';
//$data->image_url = 'https://example.com/streaming.jpg';
//$data->home_url = $return_file_path . 'test.php?m=home';

$prod_url = $base_url . "/v1/catalogs/products";

$prod_data = json_encode( $data );

$prod_res = rest_api( $prod_url, $prod_data, $token );

$product = json_decode( $prod_res );

$bp_url = $base_url . "/v1/billing/plans" ;

$data = new data ();

$data->product_id = $product->id;
$data->name = $product->name;
$data->description = $product->description;
$data->status = 'ACTIVE';
$data->billing_cycles = array ();

$cycle = new data ();
$cycle->frequency = new data ();

$cycle->frequency->interval_unit = $_POST['cycle'];
$cycle->frequency->interval_count = $_POST['frequency'];

$cycle->tenure_type = "REGULAR";
$cycle->sequence = 1;
$cycle->total_cycles = $_POST['no_cycles'];

$cycle->pricing_scheme = new data ();

$cycle->pricing_scheme->fixed_price = new data ();

$cycle->pricing_scheme->fixed_price->value = $_POST['amount'];
$cycle->pricing_scheme->fixed_price->currency_code = $_POST['CURRENCY'];

$data->billing_cycles[] = $cycle;

$data->payment_preferences = new data ();
$data->payment_preferences->service_type = 'PREPAID';
$data->payment_preferences->auto_bill_outstanding = TRUE;
$data->payment_preferences->setup_fee = new data ();

$data->payment_preferences->setup_fee->value = $_POST['setup'];
$data->payment_preferences->setup_fee->currency_code = $_POST['CURRENCY'];

$bp_data = json_encode( $data );

$bp_res = rest_api ( $bp_url, $bp_data, $token );

$sub = json_decode( $bp_res );

$sub_url = $base_url . "/v1/billing/subscriptions";

$data = new data ();

$tomorrow = date( 'Y' ) . '-';
$tomorrow .= date( 'm' ) . '-';
$tomorrow .= ( date( 'd' ) + 1 ) . 'T00:00:00Z'; 

$data->plan_id = $sub->id;
$data->start_time = $tomorrow;
$data->quantity = 1;
$data->subscriber = new data ();

$data->subscriber->name = new data ();

$data->subscriber->name->given_name = 'Idirian';
$data->subscriber->name->surname = 'Rennard';

$data->subscriber->email_address = 'idirian@houserennard.online';
$data->auto_renewal = false;

$data->application_context = new data ();
$data->application_context->brand_name = 'House Rennard';
$data->application_context->locale = 'en-US';
$data->application_context->user_action = "SUBSCRIBE_NOW";
$data->application_context->payment_method = new data ();

$data->application_context->payment_method->payer_selected = "PAYPAL";
$data->application_context->payment_method->payee_preferred = "IMMEDIATE_PAYMENT_REQUIRED";

$dt = [
  'RFP'     =>  $return_file_path,
  'Client'  =>  $clientid,
  'Secret'  =>  $secret,
  'env'     =>  $enviroment,
];

$dt = base64_encode( http_build_query( $dt ) );

$data->application_context->return_url = 'https://houserennard.online/idirian/forward.php?dt=' . $dt;
$data->application_context->cancel_url = 'https://houserennard.online/idirian/forward.php?dt=' . $dt;

$sub_data = json_encode( $data );

$sub_res = rest_api( $sub_url, $sub_data, $token );

$result = json_decode( $sub_res );

?>
<table class='table'>
  <tr>
    <td>CATALOG ENDPOINT:</td>
    <script>spaces(4)</script>
    <td><?php echo $prod_url; ?></td>
  </tr>
  <tr><td><br><br></tr>
  <tr>
    <td>CATALOG DATA:</td>
    <td></td>
    <td><?php echo $prod_data; ?></td>
  </tr>
  <tr><td><br><br></tr>
  <tr>
    <td>CATALOG RESPONSE:</td>
    <td></td>
    <td><?php echo $prod_res; ?></td>
  </tr>
  <tr><td><br><br></tr>
  <tr>
    <td>BILLING PLAN ENDPOINT:</td>
    <script>spaces(4)</script>
    <td><?php echo $bp_url; ?></td>
  </tr>
  <tr><td><br><br></tr>
  <tr>
    <td>BILLING PLAN DATA:</td>
    <td></td>
    <td><?php echo $bp_data; ?></td>
  </tr>
  <tr><td><br><br></tr>
  <tr>
    <td>BILLING PLAN RESPONSE:</td>
    <td></td>
    <td><?php echo $bp_res; ?></td>
  </tr>
  <tr><td><br><br></tr>
  <tr>
    <td>SUBSCRIPTION ENDPOINT:</td>
    <script>spaces(4)</script>
    <td><?php echo $sub_url; ?></td>
  </tr>
  <tr><td><br><br></tr>
  <tr>
    <td>SUBSCRIPTION DATA:</td>
    <td></td>
    <td><?php echo $sub_data; ?></td>
  </tr>
  <tr><td><br><br></tr>
  <tr>
    <td>SUBSCRIPTION RESPONSE:</td>
    <td></td>
    <td><?php echo $sub_res; ?></td>
  </tr>
  <?php
    if ( isset( $result->links[0]->href ) ) {
      echo  "<tr><td colspan='42'><hr></td></tr>";
      echo  "<tr><td colspan='42' align='right'>";
      echo  "<a href=" . $result->links[0]->href . " target='_blank'><input type='button' class='button' value='Redirect'></a>";
      echo  "</td></tr>";
    }
  ?>
<table>