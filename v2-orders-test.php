<?php
include 'include.php';


$client = $_POST[ 'ClientID' ];

$secret = $_POST[ 'Secret' ];

$enviroment = $_POST[ 'enviroment'] ; 

$dt = [
    'client'        =>  $client,
    'secret'        =>  $secret,
    'enviroment'   =>  $enviroment,
];

$append = base64_encode( http_build_query( $dt ) );

if ( $enviroment == 'production' ) {
    $url = "https://api.paypal.com";
} else {
    $url = "https://api.sandbox.paypal.com";
}

$token = rest_oauth( $client, $secret, $enviroment );

$url .= '/v2/checkout/orders';

$header = [
    "Content-Type:application/json",
    "Authorization: Bearer $token",
  ];

class data {

}
  
class order {
    public $intent;
//  public $application_context;
    public $purchase_units;
}

class amount {
    public $currency_code;
    public $value;
}

class purchase_units {
    public $description = 'this is a test of purchase_units.description';
    public $reference_id = 'this is a test of purchase_units.reference_id';
    public $amount;
    public $items;
    public $shipping_address;
    public $shipping_method = "UPS 2nd Day Air";
    public $partner_fee_details;
    public $payee;
    public $payer;
//    public $breakdown;
}

class urls {
    public $cancel_url = 'https://localhost/test/idirian/v2-orders-return.php?rv=cancel';
    public $return_url = 'https://localhost/test/idirian/v2-orders-return.php?rv=return&a=';
}

class breakdown {
    public $item_total;
    public $shipping;
//    public $total;
}

class item {
    public $quantity = "1";
    public $name = "this is a test of items[].name";
    public $category = "PHYSICAL_GOODS";
    public $unit_amount;
}

class shipping_address {
    public $line1 = "123 Fake St.";
    public $city = "San Jose";
    public $state = "CA";
    public $postal_code = "95131";
    public $country_code = "US";
}

class partner_fee_details {
    public $receiver;
    public $amount;

}

class payer {
    public $name;
    public $email_address = "personal@houserennard.online";
    public $address_portable;
}

class name {
    public $given_name = "Idirian";
    public $surname = "Rennard";   
}

class address_portable {
    public $address_line_1 = "123 Fake St.";
    public $admin_area_2 = "San Jose";
    public $admin_area_1 = "CA";
    public $postal_code = "95131";
    public $country_code = "US";
}

$trans = new order ();

$trans->application_context = new urls;
$trans->application_context->return_url .= strtoupper( $_POST[ 'intent' ] );
$trans->application_context->return_url .= "&dt=$append";

$trans->intent = strtoupper( $_POST[ 'intent' ] );
$trans->purchase_units = array();

$amount = new amount ();
$amount->currency_code = $_POST[ 'CURRENCY' ];
$amount->value = $_POST[ 'amount' ];

$trans->purchase_units[0] = new purchase_units ();

$breakdown = new breakdown ();
$breakdown->item_total = new amount ();
$breakdown->item_total->currency_code = $_POST[ 'CURRENCY' ];
$breakdown->item_total->value = $_POST[ 'amount' ];

$breakdown->shipping = new amount ();
$breakdown->shipping->currency_code = $_POST[ 'CURRENCY' ];
$breakdown->shipping->value = "0.00";

$amount->breakdown = $breakdown;
$amount->total = $_POST[ 'amount' ];

$trans->purchase_units[0]->amount = $amount;

$trans->purchase_units[0]->items = array();

$item = new item ();
$item->unit_amount = new amount ();
$item->unit_amount->currency_code = $_POST[ 'CURRENCY' ];
$item->unit_amount->value = $_POST[ 'amount' ];

$trans->purchase_units[0]->items[] = $item;
$trans->purchase_units[0]->shipping_address = new shipping_address ();

$trans->purchase_units[0]->partner_fee_details = new partner_fee_details ();
$trans->purchase_units[0]->partner_fee_details->receiver->email = "test@houserennard.online";

$trans->purchase_units[0]->partner_fee_details->amount = new amount ();
$trans->purchase_units[0]->partner_fee_details->amount->currency_code = $_POST[ 'CURRENCY' ];
$trans->purchase_units[0]->partner_fee_details->amount->value = $_POST[ 'amount' ];

$trans->purchase_units[0]->payee->email_address = "test@houserennard.online";

$trans->purchase_units[0]->payer = new payer ();
$trans->purchase_units[0]->payer->name = new name ();
$trans->purchase_units[0]->payer->address_portable = new address_portable ();


$data = json_encode( $trans );

$result = rest_api ( $url, $data, $token );

$json = $result;

$result = json_decode( $result );

$redirect = $result->links[1]->href;


?>
<table class='table'>
    <tr>
        <td>Endpoint:</td>
        <script>spaces(4)</script>
        <td><?php echo $url; ?></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td>Sent:</td>
        <td></td>
        <td><?php echo $data; ?></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td>Response:</td>
        <td></td>
        <td><?php echo $json; ?></td>
    </tr>
    <?php
    if ( isset( $result->links[1]->href ) ) {
        echo "<tr><td colspan='42'><hr></td></tr>";
        echo "<tr><td colspan='42' align='right'><a href='$redirect' target='_blank'><input type='submit' class='button' value='Redirect'></a></td></tr>";
    }
    ?>
</table>

