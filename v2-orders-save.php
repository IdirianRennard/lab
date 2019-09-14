<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/ui_mod.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/jquery-ui-git.css" >
<script  src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="js/scripts.js"></script>
<body id='test'>
<?php
include 'include/rest_functions.php';
include 'include/credentials.php';

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

$client = $credentials['REST_CLIENT'];
$secret = $credentials['REST_SECRET'];

$env = 'sandbox';

$BASE_URL = 'https://api.sandbox.paypal.com';

$id = '53M17899XY078551T';

$token = rest_oauth( $client, $secret, $env );

//echo $token;

$url = "$BASE_URL/v2/checkout/orders/$id/save";

$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$request_id = '';
    
for ($i = 0 ; $i < 36 ; $i++) {
  $request_id .= $characters[mt_rand(0, strlen($characters) - 1)];
}
    
$header = [
  "Content-Type:application/json",
  "Authorization: Bearer $token",
 // "PayPal-Request-Id: $request_id",
];
  
$ch = curl_init();
  
curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $header) ;
curl_setopt( $ch, CURLOPT_POST, true );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    
$resp = curl_exec( $ch );
  
echo $resp;

//End testing
echo "<hr>";
?>
<a href='index.php'><input class='button' type='submit' value='Return Home'></a>
</body>
