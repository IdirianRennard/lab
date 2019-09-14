<?php
include 'include.php';

$currency_code = $_POST['CURRENCY'];
unset( $_POST['CURRENCY'] );

$enviroment = $_POST['enviroment'];
unset( $_POST['enviroment'] );

$ip = $_POST['IP'];
unset( $_POST['IP'] );

$version = '124';

$item_no = 5;

$append = [
  'USER'          =>  $_POST['USER'],
  'PWD'           =>  $_POST['PWD'],
  'SIGNATURE'     =>  $_POST['SIGNATURE'],
  'PAYMENTACTION' =>  $_POST['PAYMENTACTION'],
  'enviroment'    =>  $enviroment,
  'VERSION'       =>  $version,
  'AMT'           =>  $_POST['AMT'],
  'TAXAMT'        =>  $item_no,
];

$append = base64_encode( http_build_query( $append ) );

$data = [
  'METHOD'                  =>  'SetExpressCheckout',
  'SOLUTIONTYPE'            =>  'Sole',
  'IPADDRESS'               =>  "$ip",
  "COUNTRYCODE"             =>  "US",
  "LANDINGPAGE"             =>  "Billing",
  "ReqBillingAddress"       =>  '0',
  "NoShipping"              =>  '0',
  "AddressOverride"         =>  '0',
  'L_PAYMENTTYPE0'          =>  'InstantOnly',
  'VERSION'                 =>  $version,
  'VERBOCITY'               =>  'high',
  'CANCELURL'               =>  $return_file_path . 'test.php?cancel',
  'RETURNURL'               =>  $return_file_path . "getec-nvp.php?dt=$append",
  'NOTIFYURL'               =>  'https://houserennard.online/idirian/ipn/ipn.php',
  'PAYMENTREQUEST_0_AMT'    =>  $_POST['AMT'],
  //'PAYMENTREQUEST_0_TAXAMT' =>  $item_no,
  'PAYMENTREQUEST_0_ITEMAMT'=>  $_POST['AMT'],// - $item_no,
  'PAYMENTREQUEST_0_CURRENCYCODE' => $currency_code,
  'LOGOIMG'                 => "https://www.sellmyretro.com/uploaded/icephorm_logo_paypal_checkout.png",
];

$url = "";

if ( $enviroment == 'sandbox' ) {
  $url = 'https://api-3t.sandbox.paypal.com/nvp';
  $r_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
} else {
  $url = 'https://api-3t.paypal.com/nvp';
  $r_url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
}

foreach ( $_POST as $k => $v ) {
  $data["$k"] = $v;
}

for ( $i = 0 ; $i < $item_no ; $i++ ) {
  $data[ "L_PAYMENTREQUEST_0_NAME$i" ] = "Item # " . ( $i + 1 );
  $data[ "L_PAYMENTREQUEST_0_DESC$i" ] = "Description for item # " . ( $i + 1);
  $data[ "L_PAYMENTREQUEST_0_AMT$i" ] = ( $_POST['AMT'] / $item_no );
  //$data[ "L_PAYMENTREQUEST_0_TAXAMT$i" ] = 1;
}

ksort( $data );

$myvars = urldecode( http_build_query( $data ) );

$result = nvp_api( $url, $myvars );

$resp_string = urldecode( $result );

$string = urldecode( $result );

parse_str( $string, $string );

if ( isset( $string['TOKEN'] ) ){
  $token = $string['TOKEN'];
  $redirect = "$r_url$token&useraction=commit";
}

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
  <tr><td colspan='42'><?php echo $resp_string; ?></td></tr>
  <tr><td><br></td></tr>
  <?php
    foreach ($string as $k => $v) {
        if ( substr( $k, 0, 5 ) == "L_AMT" ) {
            $v = number_format( $v, 2 , "." , "," );
        }
      echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
    }
    if ( isset ( $redirect ) ) {
      echo "  <tr><td colspan='42'><hr></td></tr>
              <tr><td colspan='42' align='right'><a href='$redirect'><input type='submit' class='button' value='redirect'></a></td></tr>
           ";
    } 
  ?>
</table>
