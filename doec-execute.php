<?php
include 'include.php';

parse_str( urldecode( base64_decode( $_GET['dt'] ) ) , $DT );

$currency_code = $_GET['cc'];

$data = [
  'USER'                            =>  $DT['USER'],
  'PWD'                             =>  $DT['PWD'],
  'SIGNATURE'                       =>  $DT['SIGNATURE'],
  'METHOD'                          =>  'DoExpressCheckoutPayment',
  'TOKEN'                           =>  $_GET['token'],
  'PAYERID'                         =>  $_GET['PayerID'],
  'PAYMENTREQUEST_0_AMT'            =>  $DT['AMT'] + $DT['TAXAMT'],
  'PAYMENTREQUEST_0_TAXAMT'         =>  $DT['TAXAMT'],
  'PAYMENTREQUEST_0_ITEMAMT'        =>  $DT['AMT'],
  'PAYMENTREQUEST_0_CURRENCYCODE'   =>  $currency_code,
  'VERSION'                         =>  '124',
];

for ( $i = 0 ; $i < $DT['TAXAMT'] ; $i++ ) {
  $data[ "L_PAYMENTREQUEST_0_NAME$i" ] = "Item # " . ( $i + 1 );
  $data[ "L_PAYMENTREQUEST_0_DESC$i" ] = "Description for item # " . ( $i + 1);
  $data[ "L_PAYMENTREQUEST_0_AMT$i" ] = ( $DT['AMT'] / $DT['TAXAMT'] );
  $data[ "L_PAYMENTREQUEST_0_TAXAMT$i" ] = 1;
}


ksort( $data );

$myvars = urldecode( http_build_query( $data ) );

if ( $DT['enviroment'] == 'sandbox' ) {
  $url = 'https://api-3t.sandbox.paypal.com/nvp';
  $r_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
} else {
  $url = 'https://api-3t.paypal.com/nvp';
  $r_url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
}

$result = nvp_api( $url, $myvars );

parse_str( $result, $output );

ksort( $output );

?>
<table class='table'>
  <tr><td>ENDPOINT:</td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan='42'><?php echo $url; ?></td></tr>
  <tr><td><br></td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan='42' align='left'>INPUT:</td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan='42'><?php echo $myvars; ?></td></tr>
  <tr><td><br></td></tr>
    <?php
    foreach ($data as $k => $v) {
        echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
    }
    ?>
  <tr><td><br></td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan='42' align='left'>RESPONSE:</td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan='42'><?php echo $result; ?></td></tr>
  <tr><td><br></td></tr>
  <?php
  foreach ($output as $k => $v) {
    echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
  }
  ?>
</table>