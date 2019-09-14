<?php
include 'include.php';

$plan_id = $_SESSION['id'];

$oauth = $_SESSION['oauth'];

$env = $_SESSION['env'];

if ( $env == 'production' ) {
  $url = "https://api.paypal.com//v1/payments/billing-agreements/";
} else {
  $url = "https://api.sandbox.paypal.com/v1/payments/billing-agreements/";
}

$clientid = $_SESSION['client'];

$secret = $_SESSION['secret'];

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
  public $email = "personal@houserennard.online";
}

class payer {
  public $payment_method = "paypal";
  public $payer_info;
}

class billing_agreement {
  public $name = "Daily Recurring";
  public $description = "Daily Recurring Testing";
  public $start_date;
  public $payer;
  public $plan;
  public $shipping_address;
}

$data = new billing_agreement ();
$data->start_date = date( 'c', strtotime( '+1 Day' ) );
$data->payer = new payer ();
$data->payer->payer_info = new payer_info ();
$data->plan = new plan ();
$data->plan->id = $plan_id;
$data->shipping_address = new shipping_address ();


$header = [
  "Content-Type:application/json",
  "Authorization: Bearer $oauth",
];

$data = json_encode( $data );

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$clientid:$secret");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data );

$result = curl_exec($ch);

$json = json_decode( $result, true );

/*print_r( $data );
echo "<hr>";
print_r( $result );*/

if ( isset( $json['links']['0']['href'] ) ) {
  $redirect = $json['links']['0']['href'];
}


//echo $redirect;

//header( "location: $redirect" );
//echo "<hr><a href='$redirect'>Next</a>";

?>
<table class='table'>
  <tr>
    <td>ENDPOINT:</td>
    <script>spaces(4)</script>
    <td><?php print_r( $url ) ?>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>
      INPUT:
      <br>
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
    <td>
      RESPONSE:
      <br>
      <form action='json_view-test.php' method='post' target='_blank'>
        <input type='hidden' name='json' value='<?php echo $result; ?>'>
        <input type='submit' class='button' value='View JSON'>
      </form>
    </td>
    <script>spaces(4)</script>
    <td><?php print_r( $result ); ?></td>
  </tr>
  <?php
    if ( isset( $json['links']['0']['href'] ) ) {
      echo "<tr><td colspan='42'><hr></td></tr>
      <tr>
        <td colspan='42' align='right'>
          <form action='$redirect' method='post' target='_blank'>
          <input type='submit' class='button' value=' REDIRECT '>
        </form></td>
      </tr>";
    }
  ?>
</table>
