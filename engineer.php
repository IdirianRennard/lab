<?php
include 'include/credentials.php';

$clientid = $credentials['REST_CLIENT'];
$secret = $credentials['REST_SECRET'];

$url = "https://api.sandbox.paypal.com";

$token_url = $url . "/v1/oauth2/token";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $token_url );
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$clientid:$secret");
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

$result = curl_exec($ch);

$result = json_decode( $result );

$token = $result->access_token;

class data {

};

$data = new data ();

$data->intent = 'sale';
$data->note_to_payer = 'Contact us for any questions on your order.';

$data->payer = new data ();
$data->payer->payment_method = 'paypal';

$data->redirect_urls = new data ();
$data->redirect_urls->cancel_url = 'https://localhost/test/idirian/test.php?rt=cancel';
$data->redirect_urls->return_url = 'https://localhost/test/idirian/test.php?rt=return';

$data->transactions = array();
$data->transactions[0] = new data ();
$data->transactions[0]->amount = new data ();
$data->transactions[0]->amount->currency = 'USD';
$data->transactions[0]->amount->details = new data ();
$data->transactions[0]->amount->details->handling_fee = "1.00";
$data->transactions[0]->amount->details->insurance = "0.40";
$data->transactions[0]->amount->details->shipping = "0.00";
$data->transactions[0]->amount->details->shipping_discount = "0.00";
$data->transactions[0]->amount->details->subtotal = "40.36";
$data->transactions[0]->amount->details->tax = "3.83";
$data->transactions[0]->amount->total = '45.59';

$data->transactions[0]->custom = 'service@paypal.com';
$data->transactions[0]->description = 'Shipping Carrier service selected: ';
$data->transactions[0]->invoice_number = 'JhanH7PRravpKK2';

$data->transactions[0]->item_list = new data ();
$data->transactions[0]->item_list->items = array ();
$data->transactions[0]->item_list->items[0] = new data ();
$data->transactions[0]->item_list->items[0]->currency = 'USD';
$data->transactions[0]->item_list->items[0]->description = 'Sample Description';
$data->transactions[0]->item_list->items[0]->name = 'Sample name';
$data->transactions[0]->item_list->items[0]->price = "40.36";
$data->transactions[0]->item_list->items[0]->quantity = 1;
$data->transactions[0]->item_list->items[0]->sku = "SAMPLE";

/*$data->transactions[0]->shipping_address = new data ();
$data->transactions[0]->shipping_address->city = 'Omaha';
$data->transactions[0]->shipping_address->country_code = 'US';
$data->transactions[0]->shipping_address->line1 = '123 Fake St';
$data->transactions[0]->shipping_address->line2 = '';
$data->transactions[0]->shipping_address->phone = '(888) 221-1161';
$data->transactions[0]->shipping_address->postal_code = '68116';
$data->transactions[0]->shipping_address->recipient_name = 'PayPal Agent';
$data->transactions[0]->shipping_address->state = 'NE';*/

$data->transactions[0]->payment_options = new data ();
$data->transactions[0]->payment_options->allowed_payment_method = 'INSTANT_FUNDING_SOURCE';
$data->transactions[0]->soft_descriptor = 'PayPal REST Testing';

$data = json_encode( $data );

$header = [
  "Content-Type:application/json",
  "Authorization: Bearer $token",
];

$url .= '/v1/payments/payment';

$ch = curl_init();

curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data );

$result = curl_exec( $ch );

curl_close( $ch );


header('Content-Type: application/json');

echo $data;
echo "\n\n";
echo $result;

?>
