<?php
include 'include.php';

$enviroment = $_POST['enviroment'];
unset ( $_POST['enviroment'] );

if( $enviroment == 'live') {
  $endpoint = 'https://payflowpro.paypal.com';
  $mode = 'live';
} else {
  $endpoint = 'https://pilot-payflowpro.paypal.com';
  $mode = 'test';
}

$data = array();

foreach ($_POST as $key => $value) {
  $data["$key"] = $value;
}

$myvars = urldecode( http_build_query( $data ) );

$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$secure_token_id = '';

for ($i = 0 ; $i < 36 ; $i++) {
  $secure_token_id .= $characters[mt_rand(0, strlen($characters) - 1)];
}

$data['SILENTTRAN'] = TRUE;
$data['AMT'] = 1;
$data['TRXTYPE'] = 'S';
$data['NOTIFYURL'] = 'https://houserennard.online/idirian/ipn.php';
$data['RETURNURL'] = $return_file_path . 'invis-return.php?m=return';
$data['ERRORURL'] = $return_file_path . 'invis-return.php?url=error';
$data['CANCELURL'] = $return_file_path . 'invis-return.php?url=cancel';
$data['CREATESECURETOKEN'] = 'Y';
$data['VERBOSITY'] = 'HIGH';
$data['SECURETOKENID'] = $secure_token_id;
$data['SECURETOKEN'] = '';
$data['COMMENT1'] = 'NATES TRANS REDIRECT TEST';

ksort( $data );

$myvars = urldecode( http_build_query( $data ) );

$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $endpoint );
curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

$resp = curl_exec( $ch );

$re_str = $resp;

parse_str( $resp, $resp );

ksort( $resp );

$pp_secure_token = $resp['SECURETOKEN'];
$pp_secure_token_id = $resp['SECURETOKENID'];

$url = "$endpoint?SECURETOKENID=$pp_secure_token_id&SECURETOKEN=$pp_secure_token";


?>
<table class='table'>
  <tr>
    <td>ENDPOINT:</td>
    <td></td>
    <td><?php echo $endpoint; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td colspan='42'>SENT:</td>
  </tr>
  <tr><td><br></td></tr>
  <tr><td colspan='42'><?php echo $myvars; ?></td></tr>
  <tr><td><br></td></tr>
  <?php
    foreach ($data as $k => $v) {
      echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
    }
  ?>
  </tr>
  <tr><td><br></td></tr>
  <tr><td><br></td></tr>
  <tr>
    <td colspan='42'>RESPONSE:</td>
  </tr>
  <tr><td><br></td></tr>
  <tr><td colspan='42'><?php echo $re_str; ?></td></tr>
  <tr><td><br></td></tr>
  <?php
    foreach ($resp as $k => $v) {
      echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
    }

    if( $resp['RESULT'] == 0 ) {
      echo "<tr><td colspan='42'><hr></td></tr>";
      echo "<tr><td><form action='$url' method='post'>";
      echo '<td><input type="hidden" name="ACCT" value="4024007139580582"></td>
          <td><input type="hidden" name="EXPDATE" value=\'';
      echo date( 'm' ) . ( date( 'y' ) + 3 );
      echo '\'</td>
          <td><input type="hidden" name="DISABLERECEIPT" value="true"></td>
          <td><input type="hidden" name="BILLTOFIRSTNAME" value="John"></td>
          <td><input type="hidden" name="BILLTOLASTNAME" value="Smith"></td>
          <td><input type="hidden" name="BILLTOSTREET" value="123 Fake St"></td>
          <td><input type="hidden" name="BILLTOCITY" value="SCHENECTADY"></td>
          <td><input type="hidden" name="TENDER" value="C"></td>
          <td><input type="hidden" name="CURRENCY" value="USD"></td>
          <td><input type="hidden" name="STATE" value="NY"></td>
          <td><input type="hidden" name="STREET" value="123 Fake St"></td>
          <td><input type="hidden" name="CITY" value="SCHENECTADY"></td>
          <td><input type="hidden" name="ZIP" value="12345"></td>
          <td><input type="hidden" name="VERBOSITY" value="high"></td>
          <td><input type="hidden" name="COMMENT1" value="Nate Test"></td>
          <td><input type="hidden" name="COMMENT2" value="This is using Transparent Redirect"></td>
        </tr>';
      echo "<tr><td colspan='42' align='right'><input type='submit' class='button' value=' SUBMIT '></form></td></tr>";
    }
  ?>
</table>
