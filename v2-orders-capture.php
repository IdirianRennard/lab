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

$dt = base64_decode ( $_GET[ 'dt'] );
$dt = urldecode( $dt );

parse_str( $dt, $nvp );

$token = rest_oauth( $nvp['client'], $nvp['secret'], $nvp['enviroment'] );

class data {

}

$data = new data ();

$data->amount = new data ();
$data->amount->currency_code = $nvp['currency'];
$data->amount->value = $nvp['amount'];
$data->final_capture = true;

$data = json_encode( $data );

echo "ENDPOINT: " . $nvp['cap_url'] . "<hr>";
echo "DATA: " . $data . "<hr>";

$res = rest_api ( $nvp['cap_url'], $data, $token );

echo $res;

//End testing
echo "<hr>";
?>
<a href='index.php'><input class='button' type='submit' value='Return Home'></a>
</body>
