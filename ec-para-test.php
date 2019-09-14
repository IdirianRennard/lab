<?php
include 'include.php';

$_SESSION['enviroment'] = $_POST['enviroment'];
unset( $_POST['enviroment'] );

$_SESSION['user'] = $_POST['USER'];

$_SESSION['pwd'] = $_POST['PWD'];

$_SESSION['sig'] = $_POST['SIGNATURE'];

$_SESSION['version'] = $_POST['VERSION'];

$_SESSION['q'] = $_POST['q'];
unset( $_POST['q'] );

$url = "";

if ( $_SESSION['enviroment'] == 'sandbox' ) {
  $url = 'https://api-3t.sandbox.paypal.com/nvp';
  $r_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
} else {
  $url = 'https://api-3t.paypal.com/nvp';
  $r_url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
}

$data = array();


$_SESSION['amt'] = 0;

for ( $i = 0 ; $i < $_SESSION['q'] ; $i++ ) {
  $_SESSION['PAYMENTREQUEST_' . $i . '_PAYMENTACTION'] = $_POST['PAYMENTREQUEST_' . $i . '_PAYMENTACTION'];
  $_SESSION["PAYMENTREQUEST_" . $i . "_PAYMENTREQUESTID"] = $_POST["PAYMENTREQUEST_" . $i . "_PAYMENTREQUESTID"];
  $_SESSION["PAYMENTREQUEST_" . $i . "_SELLERPAYPALACCOUNTID"] = $_POST["PAYMENTREQUEST_" . $i . "_SELLERPAYPALACCOUNTID"];
  $_SESSION['PAYMENTREQUEST_' . $i . '_ITEMAMT'] = $_POST['PAYMENTREQUEST_' . $i . '_AMT'];
  $_SESSION['PAYMENTREQUEST_' . $i . '_SHIPPINGAMT'] = 0;
  $_SESSION['PAYMENTREQUEST_' . $i . '_TAXAMT'] = 0;
  $_SESSION['PAYMENTREQUEST_' . $i . '_DESC'] = "Test0" . ( $i + 1 );
  $_SESSION['PAYMENTREQUEST_' . $i . '_CURRENCYCODE'] = 'USD';
  $_SESSION['L_PAYMENTREQUEST_' . $i . '_NAME0'] = "Test0" . ( $i + 1 );
  $_SESSION['L_PAYMENTREQUEST_' . $i . '_AMT0'] = $_POST['PAYMENTREQUEST_' . $i . '_AMT'];
  $_SESSION['L_PAYMENTREQUEST_' . $i . '_NUMBER0'] = $_POST["PAYMENTREQUEST_" . $i . "_PAYMENTREQUESTID"];
  $_SESSION['L_PAYMENTREQUEST_' . $i . '_QTY0'] = 1;
  $_SESSION['amt'] += $_POST['PAYMENTREQUEST_' . $i . '_AMT'];
  $data['PAYMENTREQUEST_' . $i . '_PAYMENTACTION'] = $_SESSION['PAYMENTREQUEST_' . $i . '_PAYMENTACTION'];
  $data["PAYMENTREQUEST_" . $i . "_PAYMENTREQUESTID"] = $_SESSION["PAYMENTREQUEST_" . $i . "_PAYMENTREQUESTID"];
  $data["PAYMENTREQUEST_" . $i . "_SELLERPAYPALACCOUNTID"] = $_SESSION["PAYMENTREQUEST_" . $i . "_SELLERPAYPALACCOUNTID"];
  $data['PAYMENTREQUEST_' . $i . '_ITEMAMT'] =   $_SESSION['L_PAYMENTREQUEST_' . $i . '_AMT0'];
  $data['PAYMENTREQUEST_' . $i . '_SHIPPINGAMT'] = 0;
  $data['PAYMENTREQUEST_' . $i . '_TAXAMT'] = 0;
  $data['PAYMENTREQUEST_' . $i . '_DESC'] = "Test0" . ( $i + 1 );
  $data['PAYMENTREQUEST_' . $i . '_CURRENCYCODE'] = 'USD';
  $data['L_PAYMENTREQUEST_' . $i . '_NAME0'] = "Test0" . ( $i + 1 );
  $data['L_PAYMENTREQUEST_' . $i . '_AMT0'] =   $_SESSION['L_PAYMENTREQUEST_' . $i . '_AMT0'];
  $data['L_PAYMENTREQUEST_' . $i . '_NUMBER0'] = $_SESSION["PAYMENTREQUEST_" . $i . "_PAYMENTREQUESTID"];
  $data['L_PAYMENTREQUEST_' . $i . '_QTY0'] = 1;
}

$data['AMT'] = $_SESSION['amt'];
$data['LOGOIMG'] = "https://www.sellmyretro.com/uploaded/icephorm_logo_paypal_checkout.png";

foreach ( $_POST as $k => $v ) {
  $data["$k"] = $v;
}

ksort( $data );

$myvars = urldecode( http_build_query( $data ) );

$ch = curl_init( $url );

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $myvars );

$result = curl_exec($ch);

curl_close($ch);

$string = urldecode( $result );

parse_str( $string, $string );

ksort( $string );

echo "<table class='table'>";
echo "<tr>
    <td colspan='7'>ENDPOINT:</td>
    <script>spaces(4)</script>
    <td>$url</td>
  </tr>
  <tr><td><br></td></tr>";
echo "<tr>";
echo "<tr><td colspan='42'>SENT:</td></tr>
<tr><td><br></td></tr>
<tr><td colspan='999'>$myvars</td></tr>";
echo "<tr><td><br></td></tr>";
foreach ( $data as $k => $v ) {
  echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
}

echo "<tr><td><br></td></tr>";

echo "<tr>";
echo "<td colspan='42'>RESPONSE:</td></tr>
<tr><td><br></td></tr>
<tr><td colspan='999'>" . urldecode( $result ) . "</td></tr>";
echo "<tr><td><br></td></tr>";
foreach ( $string as $k => $v ) {
  echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
}

if ( isset( $string['TOKEN'] ) ) {
  $token = $string['TOKEN'];
  echo "<tr><td colspan='42'><hr></td></tr>";
  echo "<tr><td colspan='42' align='right'><form action='" . $r_url . $token . "' method='post' target='_blank'><input type='submit' class='button' value='redirect'></form></td></tr>";
}

?>
