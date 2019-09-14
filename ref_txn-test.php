<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/ui_mod.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/jquery-ui-git.css" >
<script  src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="js/scripts.js"></script>
<body id='test'>
<?php

session_start();
$myvars = get_defined_vars();

ksort( $myvars );

echo "<table>";
foreach ($myvars as $k => $v) {
  ksort( $myvars[$k] );

  echo "<tr><td>$k:</td></tr>";
  foreach ($myvars[$k] as $k => $v) {
    echo "<tr><td></td><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(2)</script><td>=></td><script>spaces(4)</script><td>";
    print_r( $v );
    echo "</td></tr>";
  }
}

echo "</table>";
echo "<br>";
echo "<hr>";
echo "<br>";
//This is the section to test in

$enviroment = $_POST['enviroment'];
unset( $_POST['enviroment'] );

if( $enviroment == 'production') {
    $endpoint = 'https://payflowpro.paypal.com/';
  } else {
    $endpoint = 'https://pilot-payflowpro.paypal.com/';
  }


$data = [
    'ORIGID' => 'B80P0C076102',
    'TRXTYPE' => 'I',
    'TENDER' => 'C',
    'AMT' => '1.50',
    'COMMENT1' => 'PAYPAL TECH SUPPORT TESTING',
];

foreach( $_POST as $k => $v ) {
    $data[$k] = $v;
}

ksort( $data );

$myvars = urldecode( http_build_query( $data ) );

echo $endpoint . "<br><br>";
echo $myvars . "<br><br>";

$ch = curl_init( $endpoint );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$resp = curl_exec( $ch );

echo $resp;


//End testing
echo "<hr>";
?>
<a href='index.php'><input class='button' type='submit' value='Return Home'></a>
</body>
