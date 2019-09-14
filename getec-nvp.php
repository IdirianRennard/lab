<?php
include 'include.php';

parse_str( urldecode( base64_decode( $_GET['dt'] ) ) , $DT );

$data = [
  'USER'      => $DT['USER'],
  'PWD'       => $DT['PWD'],
  'SIGNATURE' => $DT['SIGNATURE'],
  'METHOD'    => 'GetExpressCheckoutDetails',
  'TOKEN'     => $_GET['token'],
  'VERSION'   => '124',
];

ksort( $data );

$myvars = urldecode( http_build_query( $data ) );

if ( $DT['enviroment'] == 'sandbox' ) {
  $url = 'https://api-3t.sandbox.paypal.com/nvp';
} else {
  $url = 'https://api-3t.paypal.com/nvp';
}

$result = nvp_api( $url, $myvars );

$resp_string = $result;

parse_str( $result, $result );

$get['cc'] = $result['CURRENCYCODE'];

foreach ( $_GET as $k => $v ) {
  $get["$k"] = $v;
}

ksort( $get );

$get = urldecode( http_build_query( $get ) );

ksort( $result );
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
  foreach ($result as $k => $v) {
    echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
  }

  if ( $result['CHECKOUTSTATUS'] == 'PaymentActionNotInitiated' ) {
    echo "<tr><td colspan='42'><hr></td></tr>";
    echo "<tr><td colspan='42' align='right'><a href='doec-execute.php?$get'><input type='submit' class='button' value='execute'></a></td></tr>";
  }
  ?>
</table>
