<?php
include 'include.php';

class data {

};

$enviroment = $_POST['enviroment'];
unset( $_POST['enviroment'] );

if ( $enviroment == 'production' ) {
  $url = "https://api.paypal.com";
} else {
  $url = "https://api.sandbox.paypal.com";
}

$clientid = $_POST['ClientID'];
$secret = $_POST['Secret'];

$token = rest_oauth ( $clientid, $secret, $enviroment );

$url .= '/v1/payments/payment';

$payment_method = $_POST['payment_method'];


$funding_instruments = new data ();

if( $payment_method === 'credit_card' ) {
  class credit_card {
    public $number;
    public $type;
    public $expire_month;
    public $expire_year;
    public $cvv2;
    public $first_name;
    public $last_name;
  }

  $credit_card = new credit_card;
  $credit_card->number = $_POST['number'];
  $credit_card->type = $_POST['card_type'];
  $credit_card->expire_month = $_POST['expire_month'];
  $credit_card->expire_year = $_POST['expire_year'];
  $credit_card->cvv2 = $_POST['cvv2'];
  $credit_card->first_name = $_POST['first_name'];
  $credit_card->last_name = $_POST['last_name'];

  $funding_instruments->credit_card = $credit_card;

}

$data = new data ();
$data->payer = new data ();
$data->transactions = array ();
$data->transactions[0] = new data ();
$data->transactions[0]->amount = new data ();
$data->transactions[0]->item_list = new data ();
$data->redirect_urls = new data ();

$data->intent = 'sale';
$data->payer->payment_method = $payment_method;

if ( $payment_method === 'credit_card' ) {
  $data->payer->funding_instruments[0] = $funding_instruments;
}

$data->transactions[0]->amount->total = '0.01';
$data->transactions[0]->amount->currency = 'USD';

$data->transactions[0]->item_list->items = array();
$data->transactions[0]->item_list->items[0] = new data ();
$data->transactions[0]->item_list->items[0]->name = 'Rennard Copper';
$data->transactions[0]->item_list->items[0]->description = 'Copper Coin stamped with Rennard Seal';
$data->transactions[0]->item_list->items[0]->quantity = 1;
$data->transactions[0]->item_list->items[0]->price = 0.01;
//$data->transactions[0]->item_list->items[0]->tax = 0;
$data->transactions[0]->item_list->items[0]->currency = 'USD';

$shipping_addres = new data ();
$shipping_addres->recipient_name = "Test Tester McTestington III";
$shipping_addres->line1 = "123 Fake St.";
$shipping_addres->line2 = "STE 9001";
$shipping_addres->city = "San Jose";
$shipping_addres->country_code = "US";
$shipping_addres->postal_code = "95131";
$shipping_addres->phone = "018882211161";
$shipping_addres->state = "CA";

$data->transactions[0]->item_list->shipping_address = $shipping_addres;

$append = [
  'CLIENTID' => $clientid,
  'SECRET' => $secret,
  'ENVIROMENT' => $enviroment,
];

$append = base64_encode( http_build_query( $append ) );

$data->redirect_urls->return_url = $return_file_path . "rest_payments_return.php?params=$append";
$data->redirect_urls->cancel_url = $return_file_path . 'rest_payments_return.php?cancel=true';

$data = json_encode( $data );

$response = rest_api ( $url, $data, $token );

$still_json = $response;

$response = json_decode( $response );

if ( $payment_method === 'credit_card' ) {
  $redirect = 'rest_payments_dcc_redirect.php';

} else {
  if ( isset( $response->links[1]->href ) ) {
    $redirect = $response->links[1]->href;
  }
}

?>
<table class='table'>
  <tr>
    <td>ENDPOINT:</td>
    <script>spaces(4)</script>
    <td><?php echo $url; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>
      INPUT:<br>
      <form action='json_view-test.php' method='post' target='_blank'>
        <input type='hidden' name='json' value='<?php echo $data; ?>'>
        <input type='submit' class='button' value='View JSON'>
      </form>
    </td>
    <td></td>
    <td><?php echo $data; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>
      RESPONSE:<br>
      <form action='json_view-test.php' method='post' target='_blank'>
        <input type='hidden' name='json' value='<?php echo $still_json; ?>'>
        <input type='submit' class='button' value='View JSON'>
      </form>
    </td>
    <td></td>
    <td><?php echo $still_json; ?></td>
  </tr>
  <?php
    if ( isset( $redirect ) ) {
      echo "<tr><td><br></td></tr>";
      echo "<tr>";
        echo "<td>REDIRECT URL:</td>";
        echo "<td></td>";
        echo "<td>$redirect</td>";
      echo "</tr>";
      echo "<tr><td colspan='42'><hr></td></tr>";
      echo "<tr><td colspan='42' align='right'><a href='$redirect' target='_blank'><input type='submit' class='button' value='redirect'></a></td></tr>";
      echo "<script>console.log( 'REDIRECT URL : $redirect' )</script>";
    }
  ?>
</table>