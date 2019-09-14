<?php
include 'include.php';

$enviroment = $_POST['enviroment'];
unset( $_POST['enviroment'] );

if ( $enviroment == 'sandbox' ) {
    $endpoint = "https://svcs.sandbox.paypal.com/AdaptivePayments/Pay";
    $r_url = "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_ap-payment&paykey=";
} else {
    $endpoint = "https://svcs.paypal.com/AdaptivePayments/Pay";
    $r_url = "https://www.paypal.com/cgi-bin/webscr?cmd=_ap-payment&paykey=";
}

$header = [
  "X-PAYPAL-SECURITY-USERID: " . $_POST['USER'],
  "X-PAYPAL-SECURITY-PASSWORD: " . $_POST['PWD'],
  "X-PAYPAL-SECURITY-SIGNATURE: " . $_POST['SIGNATURE'],
  "X-PAYPAL-REQUEST-DATA-FORMAT: NV",
  "X-PAYPAL-RESPONSE-DATA-FORMAT: NV",
  "X-PAYPAL-APPLICATION-ID: " . $_POST['APP-ID'],
];

$_SESSION['header'] = $header;

foreach( $header as $k => $v ) {
  echo "<script>console.log( '$v' )</script>";
}

echo "<script>console.log( 'ENDPOINT : $endpoint' )</script>";

$_SESSION['enviroment'] = $enviroment;

$input = [
    'actionType'                        =>  $_POST['actionType'],
    'clientDetails.applicationID'       =>  $_POST['APP-ID'],
    'clientDetails.ipAddress'           =>  $_POST['IPADDRESS'],
    'currencyCode'                      =>  $_POST['CURRENCY'],
    'feesPayer'                         =>  $_POST['feePayer'],
    'memo'                              =>  'Example Memo',
    'requestEnvelope.errorLanguage'     =>  'en_US',
    'returnUrl'                         =>  $return_file_path . "adpt-chained-return.php?method=return", 
    'cancelUrl'                         =>  $return_file_path . "adpt-chained-return.php?method=cancel",
];

for ( $i = 0 ; $i < $_POST['q'] ; $i++ ) {
  $input["receiverList.receiver($i).amount"] = $_POST["RECEIVER" . $i . "_AMT"];
  $input["receiverList.receiver($i).email"] = $_POST["RECEIVER". $i . "_ACCOUNTID"];

  if ( $i == 0 ) {
    $input["receiverList.receiver($i).primary"] = 1;
  } else {
    $input["receiverList.receiver($i).primary"] = 0;
  }
};


$data = urldecode( http_build_query( $input ) );
echo "<script>console.log( '$data' )</script>";
//console( $input );


$ch = curl_init();

curl_setopt( $ch, CURLOPT_URL, $endpoint );
curl_setopt( $ch, CURLOPT_POST, true );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_HEADER, true );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $header);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );

$resp = urldecode( curl_exec( $ch ) );
//echo $resp; 

$http_code = curl_getinfo( $ch, CURLINFO_RESPONSE_CODE );

curl_close($ch);

$headers = [];
$output = rtrim($resp);
$vars = explode("\n",$output);
$headers['status'] = $vars[0];
array_shift($vars);

foreach($vars as $part){
  $middle = explode(":",$part,2);
  if ( !isset($middle[1]) ) { $middle[1] = null; }
  $headers[trim($middle[0])] = trim($middle[1]);
} 


$console = [
  'HTTP CODE'       =>  $http_code,
  'RESPONSE'        =>  strstr( $resp, 'responseEnvelope' ),
  'PAYPAL-DEBUG-ID' =>  $headers['Paypal-Debug-Id'],
];

console ( $console );

parse_str( $console[ 'RESPONSE'], $parse_array );
//console( $parse_array );

if ( $parse_array['responseEnvelope_ack'] == 'Success' ) {
  $r_url .= $parse_array['payKey'];
  $_SESSION['payKey'] = $parse_array['payKey'];
  echo "<script>console.log( 'REDIRECT URL : $r_url' )</script>";
}

?>
<table class='table'>
  <tr>
    <td>ENDPOINT:</td>
    <script>spaces(4)</script>
    <td><?php echo $endpoint; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>HEADERS:</td>
    <td></td>
    <td align='top'>
    <?php 
      foreach( $header as $k => $v ) {
        echo "$v<br>";
      }
    ?>
    </td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
      <td>INPUT:</td>
      <td></td>
      <td><?php echo $data; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <?php
    ksort( $input );
    foreach( $input as $k => $v ) {
      echo "<tr><td>$k</td><td></td><td>$v</td></tr>";
    }
  ?>
  <tr><td><br></td></tr>
  <tr><td><br></td></tr>
  <tr>
      <td>RESPONSE:</td>
      <td></td>
      <td><?php echo $console[ 'RESPONSE']; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <?php
    ksort( $parse_array );
    foreach( $parse_array as $k => $v ) {
      echo "<tr><td>$k</td><td></td><td>$v</td></tr>";
    }
  ?>
  <?php
    if ( $parse_array['responseEnvelope_ack'] == 'Success' ) {
      echo "<tr><td><br></td></tr>";
      echo "<tr><td><br></td></tr>";
      echo "<tr><td>REDIRECT_URL:</td><td></td><td>$r_url</td></tr>";
      echo "<tr><td colspan='42'><hr></td></tr>";
      echo "<tr><td colspan='42' align='right'><a href='$r_url' target=_blank><input type='submit' class='button' value='redirect'></a></td></tr>";
    } 
  ?>
</table>

