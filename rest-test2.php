<?php
include 'include.php';

$oauth = $_SESSION['oauth'];

$env = $_SESSION['env'];

if ( $env == 'production' ) {
  $url = "https://api.paypal.com/v1/payments/billing-plans";
} else {
  $url = "https://api.sandbox.paypal.com/v1/payments/billing-plans";
}

$clientid = $_SESSION['client'];

$secret = $_SESSION['secret'];

class billing_plan {
  public $name = "Testing GCS";
  public $description = "Daily Recurring for Testing";
  public $type = "INFINITE";
  public $payment_definitions = array();
  public $merchant_preferences;
}

class payment_definitions {
  public $name = "Daily Recurring";
  public $type = "REGULAR";
  public $frequency_interval = "1";
  public $frequency = "DAY";
  public $cycles = "0";
  public $amount;
}

class amount {
  public $currency = "USD";
  public $value = "1";
}

class merchant_preferences {
  public $setup_fee;
  public $cancel_url = "http://localhost/test/idirian/rest-test5.php?cancel=true";
  public $return_url = "http://localhost/test/idirian/rest-test5.php";
  public $notify_url = NULL;
  public $initial_fail_amount_action = "CANCEL";
  public $max_fail_attempts = "0";
  public $auto_bill_amount = "YES";
}

$data = new billing_plan ();

$data->payment_definitions[0] = new payment_definitions ();
$data->payment_definitions[0]->amount = new amount ();
$data->merchant_preferences = new merchant_preferences ();
$data->merchant_preferences->setup_fee = new amount ();


$data = json_encode( $data );

$header = [
  "Content-Type:application/json",
  "Authorization: Bearer $oauth",
  "Content-Length: " . strlen($data),
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$clientid:$secret");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data );

$result = curl_exec($ch);

$decode = json_decode( $result, true );

$id = $decode['id'];

$create_time = $decode['create_time'];

curl_close($ch);

//print_r( $data );
//print_r( $result );

$_SESSION['id'] = $id;

//header( "location: rest-test3.php");
//echo "<hr><a href='rest-test3.php'>Next</a>";
?>
<table class='table'>
  <tr>
    <td>ENDPOINT:</td>
    <script>spaces(4)</script>
    <td><?php print_r( $url ) ?>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>INPUT:<br>
      <form action='json_view-test.php' method='post' target='_blank'>
        <input type='hidden' name='json' value='<?php echo $data; ?>'>
        <input type='submit' class='button' value='View JSON'>
      </form>
    </td>
    <script>spaces(4)</script>
    <td><?php print_r( $data ); ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>RESPONSE:<br>
      <form action='json_view-test.php' method='post' target='_blank'>
        <input type='hidden' name='json' value='<?php echo $result; ?>'>
        <input type='submit' class='button' value='View JSON'>
      </form></td>
    <script>spaces(4)</script>
    <td><?php print_r( $result ); ?></td>
  </tr>
  <tr><td colspan='42'><hr></td></tr>
  <tr>
    <td colspan='42' align='right'>
      <form action='rest-test3.php' method='post'>
        <input type='submit' class='button' value=' NEXT '>
      </form>
    </td>
  </tr>
</table>
