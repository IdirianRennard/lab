<?php
include 'include.php';

$enviroment = $_POST['enviroment'];
unset ( $_POST['enviroment'] );

if( $enviroment == 'live') {
  $endpoint = 'https://payflowpro.paypal.com';
} else {
  $endpoint = 'https://pilot-payflowpro.paypal.com';
}

$data = array();

$request_id = "RENNARD-";

$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

for ($i = 0 ; $i < 24 ; $i++) {
  $request_id .= $characters[mt_rand(0, strlen($characters) - 1)];
}

$headers[] = "X-VPS-REQUEST-ID: $request_id";
//$headers[] = "PAYPAL-NVP:Y";


switch ( $_POST['TRXTYPE'] ) {
  case 'C':
    $data = [
      'PARTNER' => $_POST['PARTNER'],
      'VENDOR' => $_POST['VENDOR'],
      'USER' => $_POST['USER'],
      'PWD' =>  $_POST['PWD'],
      'TRXTYPE' => $_POST['TRXTYPE'],
      'VERBOSITY' => $_POST['VERBOSITY'],
      'ORIGID' => $_POST['ORIGID'],
      'AMT' => $_POST['AMT'],
      //'TENDER' => $_POST['TENDER'],
      //'COMMENT1' => 'TEST OF CREDIT/REFUND',
    ];
  break;
  
  case 'NRC':
    $data = [
      'PARTNER'             =>  $_POST['PARTNER'],
      'VENDOR'              =>  $_POST['VENDOR'],
      'USER'                =>  $_POST['USER'],
      'PWD'                 =>  $_POST['PWD'],
      'TRXTYPE'             =>  'C',
      'ACCT'                =>  $_POST['ACCT'],
      'CVV2'                =>  '456',
      'EXPDATE'             =>  $_POST['EXPDATE'],
      'VERBOSITY'           =>  $_POST['VERBOSITY'],
      'AMT'                 =>  $_POST['AMT'],
      'CURRENCY'            =>  $_POST['CURRENCY'],
      'BILLTOFIRSTNAME'     =>  $_POST['BILLTOFIRSTNAME'],
      'BILLTOLASTNAME'      =>  $_POST['BILLTOLASTNAME'],
      'BILLTOSTREET'        =>  $_POST['STREET'],
      'BILLTOCITY'          =>  $_POST['CITY'],
      'BILLTOZIP'           =>  $_POST['ZIP'],
      'BILLTOCOUNTRY'       =>  'USA',
      'INVNUM'              =>  $request_id,
      'TENDER'              =>  $_POST['TENDER'],
    ];
  break;

  case 'R':
      $data = [
        'PARTNER' => $_POST['PARTNER'],
        'VENDOR' => $_POST['VENDOR'],
        'USER' => $_POST['USER'],
        'PWD' =>  $_POST['PWD'],
        'TRXTYPE' => $_POST['TRXTYPE'],
        'ACTION' => 'I',
        'VERBOSITY' => $_POST['VERBOSITY'],
        'ORIGPROFILEID' => $_POST['ORIGPROFILEID'],
        'PAYMENTHISTORY' => 'Y',
      ];
  break;

  default:
    foreach ($_POST as $key => $value) {
      $K = strtoupper( $key );
      $data["$K"] = $value;
    }
  break;
}

/*$data['L_NAME0'] = 'Header Test';
$data['L_DESC0'] = 'Header Test Desc';
$data['L_AMT0'] = $_POST['AMT'];*/

ksort( $data );

$myvars = urldecode( http_build_query( $data ) );

$resp = nvp_api( $endpoint, $myvars );

$resp_str = $resp;

parse_str( $resp, $resp );
?>
  <table class='table'>
    <tr><td colspan="42" align='left'>ENDPOINT:</td></tr>
    <tr><td><br></td></tr>
    <tr><td colspan="42" align='left'><?php echo $endpoint; ?></td></tr>
    <tr><td><br></td></tr>
    <tr><td><br></td></tr>
    <tr><td colspan="42" align='left'>INPUT:</td></tr>
    <tr><td><br></td></tr>
    <tr><td colspan="42" align='left'><?php echo $myvars; ?></td></tr>
    <tr><td><br></td></tr>
    <?php
    foreach ($data as $k => $v) {
        echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
    }
    ?>
    <tr><td><br></td></tr>
    <tr><td><br></td></tr>
    <tr><td colspan="42" align='left'>RESPONSE:</td></tr>
    <tr><td><br></td></tr>
    <tr><td colspan="42" align='left'><?php echo $resp_str; ?></td></tr>
    <tr><td><br></td></tr>
    <?php
    if ( isset( $headers ) ) {
      $string = $resp_str;

      $string = urldecode( $string );
    
      $explode_1 = explode( '&', $string );
    
      $string = array();
    
      foreach ( $explode_1 as $k => $v ) {
        $explode_2 = explode( '=', $v );
        $string[ $explode_2[0] ] = $explode_2[1];
      };

      foreach ( $string as $k => $v ) {
        echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
      };
    } else {
      foreach ($resp as $k => $v) {
        echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
      }
    }
    
    ?>
    </table>
</center>
