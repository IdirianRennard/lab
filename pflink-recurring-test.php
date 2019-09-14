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

$env = $_POST['env'];
unset ( $_POST['env'] );

if( $env == 'live') {
  $endpoint = 'https://payflowpro.paypal.com/';
  $page = 'https://payflowlink.paypal.com/';
  $mode = 'live';
} else {
  $endpoint = 'https://pilot-payflowpro.paypal.com/';
  $page = 'https://pilot-payflowlink.paypal.com/';
  $mode = 'test';
}

$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$secure_token_id = '';

for ($i = 0 ; $i < 36 ; $i++) {
  $secure_token_id .= $characters[mt_rand(0, strlen($characters) - 1)];
}

$data = [
  'CREATESECURETOKEN' => 'Y',
  'CURRENCY' => 'USD',
  'SECURETOKENID' => $secure_token_id,
  'COMMENT1' => 'NATE TEST PFLINK',
  //'NOTIFYURL' => 'https://localhost/test/idirian/ipn/ipn.php',
  //'ERRORURL' => $return_file_path . 'test.php?error',
  //'RETURNURL' => $return_file_path . 'test.php?return',
  //'SILENTPOSTURL' => 'https://houserennard.online/idirian/ipn/ipn.php',
];


foreach ($_POST as $key => $value) {
  $data["$key"] = $value;
}

ksort( $data );

$url = $endpoint;

$myvars = urldecode( http_build_query( $data ) );

echo $myvars;

echo "<br><br>";

$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$resp = curl_exec( $ch );

echo $resp;

/*parse_str( $resp, $resp );

$pp_secure_token = $resp['SECURETOKEN'];
$pp_secure_token_id = $resp['SECURETOKENID'];

$iframe_url = "$page?SECURETOKEN=$pp_secure_token&SECURETOKENID=$pp_secure_token_id";

ksort( $resp );*/

//End testing
echo "<hr>";
?>
<a href='index.php'><input class='button' type='button' value='Return Home'></a>
</body>
