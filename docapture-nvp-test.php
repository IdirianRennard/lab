<?php
include 'include.php';

$enviroment = $_POST['enviroment'];
unset ( $_POST['enviroment'] );

if( $enviroment == 'live') {
  $endpoint = 'https://api-3t.paypal.com/nvp';
} else {
  $endpoint = 'https://api-3t.sandbox.paypal.com/nvp';
}

$data = [
  'USER'              =>  $_POST['USER'],
  'PWD'               =>  $_POST['PWD'],
  'SIGNATURE'         =>  $_POST['SIGNATURE'],
  'METHOD'            =>  'DoCapture',
  'AUTHORIZATIONID'   =>  $_POST['TRXID'],
  'AMT'               =>  $_POST['AMT'],
  'CURRENCYCODE'      =>  $_POST['CURRENCY'],
  'COMPLETETYPE'      =>  'Complete',
  'SHIPTONAME'        =>  "John Smith",
  'SHIPTOSTREET'      =>  "123 Fake St",
  'SHIPTOCITY'        =>  "SCHENECTADY",
  'SHIPTOSTATE'       =>  "NY",
  'SHIPTOZIP'         =>  "12345",
  'SHIPTOCOUNTRY'     =>  "US",
  'VERSION'           =>  124,
];

asort( $data );

$myvars = urldecode( http_build_query( $data ) );

$resp_string = nvp_api( $endpoint, $myvars );

parse_str( $resp_string, $resp );
?>
<table class='table'>
  <tr><td>ENDPOINT:</td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan='42'><?php echo $endpoint; ?></td></tr>
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
    foreach ($resp as $k => $v) {
      echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
    }
    echo "<tr><td><br></td></tr>";
  ?>
  </tr>
</table>
