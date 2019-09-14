<?php
include "include.php";

$temp_id = $_POST['temp_id'];

$clientid = $_SESSION['clientid'];

$secret = $_SESSION['secret'];

$token = $_SESSION['token'];

if ( $_SESSION['enviroment'] == 'production' ) {
  $url = "https://api.paypal.com/v1/invoicing/templates";
} else {
  $url = "https://api.sandbox.paypal.com/v1/invoicing/templates";
}

$header = [
  "Content-Type:application/json",
  "Authorization: Bearer $token",
];


$ch = curl_init();

curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_URL, "$url/$temp_id");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec( $ch );

$json_response = $response;

$response = json_decode( $response );

curl_close( $ch );

$url= "https://api.paypal.com/v1/invoicing/invoices/";

$r_email = $_POST['r_email'];
$r_f_name = $_POST['r_f_name'];
$r_l_name = $_POST['r_l_name'];

class merchant_info {
  public $email = 'njsheridan@gmail.com';
  public $first_name = 'Nathanial';
  public $last_name = 'Sheridan';
  public $business_name = 'House Rennard';
  public $phone;
};

class phone {
  public $country_code = '001';
  public $national_number = '4028509472';
};

class billing_info {
  public $email;
  public $first_name;
  public $last_name;
};

class shipping_info {
  public $first_name;
  public $last_name;
  public $address;
};

class address {
  public $line1 = '15104 Wirt St';
  public $city = 'Omaha';
  public $state = 'NE';
  public $postal_code = '68116';
  public $country_code = 'US';
};

class invoice {
  public $template_id;
  public $merchant_info;
  public $billing_info;
  public $shipping_info;
};

$invoice = new invoice;
$invoice->template_id = $temp_id;
$invoice->merchant_info = new merchant_info;
$invoice->merchant_info->phone = new phone;

$invoice->billing_info = array();
$invoice->billing_info[0] = new billing_info;
$invoice->billing_info[0]->email = $r_email;
$invoice->billing_info[0]->first_name = $r_f_name;
$invoice->billing_info[0]->last_name = $r_l_name;


$invoice->shipping_info = new shipping_info;
$invoice->shipping_info->first_name = $r_f_name;
$invoice->shipping_info->last_name = $r_l_name;
$invoice->shipping_info->address = new address;

$data = json_encode( $invoice );

$ch2 = curl_init();

curl_setopt($ch2, CURLOPT_HTTPHEADER, $header );
curl_setopt($ch2, CURLOPT_URL, "$url" );
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch2, CURLOPT_POSTFIELDS, $data );

$result = curl_exec( $ch2 );

curl_close( $ch2 );

$result = json_decode( $result );

$url .= "/" . $result->template_id . "/send?notify_merchant=true";

$ch3 = curl_init();

curl_setopt($ch3, CURLOPT_URL, $url );
curl_setopt($ch3, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch3, CURLOPT_POST, true);
curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);

$inv_create = curl_exec( $ch3 );

curl_close( $ch3 );

?>
<table class='table'>
  <tr>
    <td>SENT:</td><script>spaces(4)</script><td><?php print_r( $data ); ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>RESPONSE:</td><td></td><td><?php print_r( $json_response ); ?></td>
  </tr>
</table>
<?php
  unset( $_SESSION );
  session_destroy();
?>
