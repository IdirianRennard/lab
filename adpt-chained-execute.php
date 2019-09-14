<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/ui_mod.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/jquery-ui-git.css" >
<script  src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="js/scripts.js"></script>
<body id='test'>
<?php
include 'include/rest_functions.php';

session_start();
$myvars = get_defined_vars();

ksort( $myvars );

$return_file_path = 'https://localhost' . rtrim(  $_SERVER['PHP_SELF'], basename( $_SERVER['PHP_SELF'] ) ) ;

echo "<table>";
foreach ($myvars as $k => $v) {
  ksort( $myvars[$k] );
  if ( $k !== '_SERVER' ) {
    echo "<tr><td>$k:</td></tr>";
    foreach ($myvars[$k] as $k => $v) {
      echo "<tr><td></td><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(2)</script><td>=></td><script>spaces(4)</script><td>";
      print_r( $v );
      echo "</td></tr>";
    }
  }
}

echo "</table>";
echo "<br>";
echo "<hr>";
echo "<br>";
//This is the section to test in

$enviroment = $_SESSION['enviroment'];

if ( $enviroment == 'sandbox' ) {
  $endpoint = "https://svcs.sandbox.paypal.com/AdaptivePayments/ExecutePayment";
} else {
  $endpoint = "https://svcs.paypal.com/AdaptivePayments/ExecutePayment";
}

$header = $_SESSION['header'];

foreach( $header as $k => $v ) {
  echo "<script>console.log( '$v' )</script>";
}

echo "<script>console.log( 'ENDPOINT : $endpoint' )</script>";

$input = [
  'payKey'                        =>  $_SESSION['payKey'],
  'actionType'                    =>  'PAY',
  'requestEnvelope.errorLanguage' =>  'en_US',
];

$data = urldecode( http_build_query( $input ) );
echo "<script>console.log( '$data' )</script>";


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

parse_str( $console[ 'RESPONSE' ], $parse_array );

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
  <tr>
      <td>RESPONSE:</td>
      <td></td>
      <td><?php echo $console[ 'RESPONSE']; ?></td>
  </tr>
</table>


<?php
//End testing
echo "<hr>";
?>
<a href='index.php'><input class='button' type='submit' value='Return Home'></a>
</body>
