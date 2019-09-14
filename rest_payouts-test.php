<?php
include 'include.php';

$enviroment = $_POST['enviroment'];
unset( $_POST['enviroment'] );

$clientid = $_POST['ClientID'];
unset( $_POST['ClientID'] );

$secret = $_POST['Secret'];
unset( $_POST['Secret'] );

$token = rest_oauth( $clientid, $secret, $enviroment );

if ( $enviroment == 'production' ) {
  $url = "https://api.paypal.com/v1/payments/payouts";
} else {
  $url = "https://api.sandbox.paypal.com/v1/payments/payouts";
}

$currency = $_POST['currency'];

$batch_id = date( 'ymdHis' );

$characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

for ($i = 0 ; $i < 10 ; $i++) {
  $batch_id .= $characters[mt_rand(0, strlen($characters) - 1)];
}

class payout {
  public $sender_batch_header;
  public $items = array();
}

class sender_batch_header {
  public $sender_batch_id;
}

class items {
  public $recipient_type = "EMAIL";
  public $amount;
  public $receiver;
}

class amount {
  public $value;
  public $currency;
}

$items = array();

$data = new payout ();

$data->sender_batch_header = new sender_batch_header ();

$data->sender_batch_header->sender_batch_id = $batch_id;
$data->sender_batch_header->email_subject = 'Memo Field';
$data->sender_batch_header->email_message = 'This is the email message_field.';

$rec_arr = array();


for ( $i = 0 ; $i < $_POST['quantity'] ; $i += 1 ) {
  $data->items[$i] = new items ();

  $data->items[$i]->amount = new amount ();

  $data->items[$i]->amount->value = $_POST["amt$i"];
  $data->items[$i]->amount->currency = $currency;

  $data->items[$i]->note = 'Testing the note feature';
  $data->items[$i]->sender_item_id = $batch_id;
  $data->items[$i]->receiver = $_POST["rec$i"];
}

$data_encode = json_encode( $data );

$result = rest_api( $url, $data_encode, $token );

?>
<table class='table'>
  <tr>
    <td>ENDPOINT:</td>
    <td></td>
    <td><?php echo $url; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>SENT:</td>
    <script>spaces(4)</script>
    <td><?php print_r( $data_encode ); ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>RESPONSE:</td><td></td><td><?php print_r( $result ); ?></td>
  </tr>
</table>