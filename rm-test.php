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

$url = "https://api-3t.paypal.com/nvp";

$data = [
  'USER' => <<YOUR API USERNAME>>,
  'PWD' => <<YOUR API PASSWORD>>,
  'SIGNATURE' => <<YOUR API SIGNATURE>>,
  'METHOD' => 'GetTransactionDetails',
  'TRANSACTIONID' => $_GET['tx'],
  'VERSION' => 124,
];

$myvars = urldecode( http_build_query( $data ) );

$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$result = urldecode( curl_exec( $ch ) );

echo "$result<br><br>";

parse_str( $result, $data );

ksort( $data );

echo "<table>";
foreach ( $data as $k => $v ) {
  echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
}
echo "</table>";

$first_name = $data['FIRSTNAME'];

$last_name = $data['LASTNAME'];

$payer_email = $data['EMAIL'];

$item_name = $data['L_NAME0'];

/*amount3

mc_amount3

period3

recurring
*/
$subscr_date = $data['TIMESTAMP'];

$subscr_id = $data['SUBSCRIPTIONID'];

$payer_id = $data['PAYERID'];

$residence_country = $data['SHIPTOCOUNTRYNAME'];

//mc_currency

$payer_status = $data['PAYERSTATUS'];

//reattempt


//End testing
echo "<hr>";
?>
<a href='index.php'><input class='button' type='submit' value='Return Home'></a>
</body>
