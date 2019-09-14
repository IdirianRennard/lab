<?php
include "include.php";

$oauth = $_SESSION['oauth'];

$env = $_SESSION['env'];

if ( $env == 'production' ) {
  $url = "https://api.paypal.com/v1/payments/payouts";
} else {
  $url = "https://api.sandbox.paypal.com/v1/payments/payouts";
}

$clientid = $_SESSION['client'];

$secret = $_SESSION['secret'];

$currency = $_SESSION['currency'];

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

$header = [
  "Content-Type:application/json",
  "Authorization: Bearer $oauth",
];

$items = array();

$data = new payout ();

$data->sender_batch_header = new sender_batch_header ();

$data->sender_batch_header->sender_batch_id = $batch_id;
$data->sender_batch_header->email_subject = 'Memo Field';
$data->sender_batch_header->email_message = 'This is the email message_field.';

$rec_arr = array();


for ( $i = 0 ; $i < $_SESSION['quantity'] ; $i += 1 ) {
  $data->items[$i] = new items ();

  $data->items[$i]->amount = new amount ();

  $data->items[$i]->amount->value = $_SESSION["amt$i"];
  $data->items[$i]->amount->currency = $currency;

  $data->items[$i]->note = 'Testing the note feature';
  $data->items[$i]->sender_item_id = $batch_id;
  $data->items[$i]->receiver = $_SESSION["rec$i"];
}

$data_encode = json_encode( $data );

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_encode );

$result = curl_exec($ch);

$decode = json_decode( $result, true );
$data = json_decode( $data_encode,  true );

?>
<table class='table'>
  <tr>
    <td>SENT:</td><script>spaces(4)</script><td><?php print_r( $data_encode ); ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>RESPONSE:</td><td></td><td><?php print_r( $result ); ?></td>
  </tr>
</table>
<?php
  unset( $_SESSION );
  session_destroy();
?>
