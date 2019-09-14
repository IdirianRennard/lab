<?php 
include 'include.php';

$enviroment = $_POST['enviroment'];
unset( $_POST['enviroment'] );

$dt = [
  'ENVIROMENT'  =>  $enviroment,
  'USER'        =>  $_POST['USER'],
  'PWD'         =>  $_POST['PWD'],
  'SIGNATURE'   =>  $_POST['SIGNATURE'],
  'AMT'         =>  $_POST['AMT'],
  'INITAMT'     =>  $_POST['INITAMT']
];

ksort( $dt );

$dt = base64_encode( http_build_query( $dt ) );

$data = [
  'METHOD'                            =>  'SetExpressCheckout',
  'RETURNURL'                         =>  $return_file_path . 'ec-nvp-recurring-return.php?dt=' . $dt,
  'CANCELURL'                         =>  $return_file_path . 'test.php?m=cancel',
  'NOTIFYURL'                         =>  'https://houserennad.online/ipn/ipn.php',
  'NOSHIPPING'                        =>  '0',
  'SOLUTIONTYPE'                      =>  'MARK',
  'LANDINGPAGE'                       =>  'Billing',
  'L_BILLINGTYPE0'                    =>  'RecurringPayments',
  'L_BILLINGAGREEMENTDESCRIPTION0'    =>  'House Rennard NVP Recurring Test',
  'PAYMENTREQUEST_0_AMT'              =>  '0.50',
  'PAYMENTREQUEST_0_CURRENCYCODE'     =>  'USD',
  'PAYMENTREQUEST_0_ITEMAMT'          =>  '0.20',
  'PAYMENTREQUEST_0_SHIPPINGAMT'      =>  '0.10',
  'PAYMENTREQUEST_0_TAXAMT'           =>  '0.20',
  'PAYMENREQUEST_0_DESC'              =>  'Idirian Recurring EC NVP',
  'PAYMENREQUEST_0_CUSTOM'            =>  'Idirian custom variable test!',
  'PAYMENREQUEST_0_INVNUM'            =>  'Idirian InvNum variable test!',
  'PAYMENTREQUEST_0_PAYMENTACTION'    =>  'SALE',
  'VERSION'                           =>  '116.0',
  'USER'                              =>  $_POST['USER'],
  'PWD'                               =>  $_POST['PWD'],
  'SIGNATURE'                         =>  $_POST['SIGNATURE'],
];

ksort( $data );

$myvars = urldecode( http_build_query( $data ) );

if ( $enviroment == 'sandbox' ) {
    $url = 'https://api-3t.sandbox.paypal.com/nvp';
    $r_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
} else {
    $url = 'https://api-3t.paypal.com/nvp';
    $r_url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
}

$result = nvp_api( $url, $myvars );

$resp_string = $result;

parse_str( $result, $result );

if ( isset( $result['TOKEN'] ) ) {
  $r_url .= $result['TOKEN'];
}

?>
<table class='table'>
  <tr><td>ENDPOINT:</td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan='42'><?php echo $url; ?></td></tr>
  <tr><td><br></td></tr>
  <tr><td><br></td></tr>
  <?php
    echo "<tr><td colspan='42' align='left'>INPUT:</td></tr>";
    echo "<tr><td><br></td></tr>";
    echo "<tr><td colspan='42'>$myvars</td></tr>";
    echo "<tr><td><br></td></tr>";
    foreach ($data as $k => $v) {
        echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
    }

    echo "<tr><td><br></td></tr>";
    echo "<tr><td><br></td></tr>";

    echo "<tr><td colspan='42' align='left'>RESPONSE:</td></tr>";
    echo "<tr><td><br></td></tr>";
    echo "<tr><td colspan='42'>$resp_string</td></tr>";
    echo "<tr><td><br></td></tr>";
    foreach ($result as $k => $v) {
      echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
    }
    echo "<tr><td><br></td></tr>";
    if ( isset( $result['TOKEN'] ) ) {
      echo "<tr><td colspan='42'><hr></td></tr>";
      echo "<tr><td colspan='42' align='right'><a href='$r_url' target='_blank'><input type='submit' class='button' value='redirect'></a>";
    }
    
  ?>
  </tr>
</table>
