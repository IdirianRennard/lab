<?php
include 'include.php';

$oauth = $_SESSION['oauth'];

$env = $_SESSION['env'];

$id = $_SESSION['id'];

if ( $env == 'production' ) {
  $url = "https://api.paypal.com/v1/payments/billing-plans/$id";
} else {
  //$url = "https://api.sandbox.paypal.com/v1/payments/billing-plans/.";
  $url = "https://api.sandbox.paypal.com/v1/payments/billing-plans/$id";
}

$clientid = $_SESSION['client'];

$secret = $_SESSION['secret'];

class value {
  public $state = "ACTIVE";
}

class update_plan {
  public $op = "replace";
  public $path = "/";
  public $value;

}

$data = [
  new update_plan (),
];

$data[0]->value = new value ();

$data = json_encode( $data );

$header = [
  "Content-Type:application/json",
  "Authorization: Bearer $oauth",
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data );

$result = curl_exec($ch);

/*print_r( $data );
echo "<hr>";
print_r( $result );*/

//header( "location: rest-test4.php" );
//echo "<hr><a href='rest-test4.php'>Next</a>";
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
      </form></td>
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
      <form action='rest-test4.php' method='post'>
      <input type='submit' class='button' value=' NEXT '>
    </form></td>
  </tr>
</table>
