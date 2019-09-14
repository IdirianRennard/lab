<?php
include 'include.php';

if ( $_SESSION['enviroment'] == 'sandbox' ) {
  $url = 'https://api-3t.sandbox.paypal.com/nvp';
  $r_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
} else {
  $url = 'https://api-3t.paypal.com/nvp';
  $r_url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
}

$data = [
  'USER' => $_SESSION['user'],
  'PWD' => $_SESSION['pwd'],
  'SIGNATURE' => $_SESSION['sig'],
  'METHOD' => 'DoExpressCheckoutPayment',
  'TOKEN' => $_POST['token'],
  'PAYERID' => $_POST['PayerID'],
  'VERSION' => $_SESSION['version'],
  'AMT' => $_SESSION['amt'],
];

for ( $i = 0 ; $i < $_SESSION['q'] ; $i++ ) {
  $data['PAYMENTREQUEST_' . $i . '_PAYMENTACTION'] = $_SESSION['PAYMENTREQUEST_' . $i . '_PAYMENTACTION'];
  $data["PAYMENTREQUEST_" . $i . "_PAYMENTREQUESTID"] = $_SESSION["PAYMENTREQUEST_" . $i . "_PAYMENTREQUESTID"];
  $data["PAYMENTREQUEST_" . $i . "_SELLERPAYPALACCOUNTID"] = $_SESSION["PAYMENTREQUEST_" . $i . "_SELLERPAYPALACCOUNTID"];
  $data['PAYMENTREQUEST_' . $i . '_AMT'] = $_SESSION['L_PAYMENTREQUEST_' . $i . '_AMT0'];
  $data['PAYMENTREQUEST_' . $i . '_ITEMAMT'] = $_SESSION['L_PAYMENTREQUEST_' . $i . '_AMT0'];
  $data['PAYMENTREQUEST_' . $i . '_SHIPPINGAMT'] = 0;
  $data['PAYMENTREQUEST_' . $i . '_TAXAMT'] = 0;
  $data['PAYMENTREQUEST_' . $i . '_DESC'] = "Test0" . ( $i + 1 );
  $data['PAYMENTREQUEST_' . $i . '_CURRENCYCODE'] = 'USD';
  $data['L_PAYMENTREQUEST_' . $i . '_NAME0'] = "Test0" . ( $i + 1 );
  $data['L_PAYMENTREQUEST_' . $i . '_AMT0'] = $_SESSION['L_PAYMENTREQUEST_' . $i . '_AMT0'];
  $data['L_PAYMENTREQUEST_' . $i . '_NUMBER0'] = $_SESSION["PAYMENTREQUEST_" . $i . "_PAYMENTREQUESTID"];
  $data['L_PAYMENTREQUEST_' . $i . '_QTY0'] = 1;
}

ksort( $data );

$myvars = urldecode( http_build_query( $data ) );


$result = nvp_api( $url, $myvars );

$result_str = $result;

parse_str( $result, $result );

ksort( $result );
?>
<table class='table'>
  <tr>
    <td colspan='7'>ENDPOINT:</td>
    <script>spaces(4)</script>
    <td><?php echo $url; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr><td colspan="42">SENT:</td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan='999'><?php echo $myvars; ?></td></tr>
  <tr><td><br></td></tr>
  <?php
  foreach ( $data as $k => $v ) {
    echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
  }
  ?>
  <tr><td><br></td></tr>
  <tr><td colspan="42">RESPONSE:</td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan='999'><?php echo $result_str; ?></td></tr>
  <tr><td><br></td></tr>
  <?php
  foreach ( $result as $k => $v ) {
    echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
  }
  ?>
</table>
