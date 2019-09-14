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

class data {

}

$dt = $_GET['dt'];

$dt = urldecode( base64_decode( $dt ) );

parse_str( $dt, $data );

$enviroment = $data['env'];

$client = $data['Client'];

$secret = $data['Secret'];

$token = rest_oauth( $client, $secret, $enviroment );

$data = new data ();

$data->reason = "Create new subscription";

$data = json_encode( $data );

if ( $enviroment == 'production' ) {
    $base_url = "https://api.paypal.com";
} else {
    $base_url = "https://api.sandbox.paypal.com";
}

$url = $base_url . "/v1/billing/subsscriptions/" . $_GET['subscription_id'] . "/activate";

$result = rest_api( $url, $data, $token );

echo $result;

//End testing
echo "<hr>";
?>
<a href='index.php'><input class='button' type='submit' value='Return Home'></a>
</body>
