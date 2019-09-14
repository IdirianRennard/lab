<?php
session_start();

$enviroment = $_POST['env'];
unset ( $_POST['env'] );

$json = array();
$_SESSION = array();

if ( $_POST['BILLINGTYPE'] === 'MerchantInitiatedBilling' ) {
  $json['BILLINGTYPE'] = $_POST['BILLINGTYPE'];
} else {
  unset( $_POST['BILLINGTYPE'] );
}

$json['ENV'] = $enviroment;
$json['AMT'] = $_POST['AMT'];
$json['CURRENCY'] = $_POST['CURRENCY'];

ksort( $json );

$_SESSION['CUSTOM'] = json_encode( $json );
$_SESSION['PARTNER'] = $_POST['PARTNER'];
$_SESSION['VENDOR'] = $_POST['VENDOR'];
$_SESSION['USER'] = $_POST['USER'];
$_SESSION['PWD'] = $_POST['PWD'];
$_SESSION['TRXTYPE'] = $_POST['TRXTYPE'];
$_SESSION['TENDER'] = $_POST['TENDER'];

$data = array();

if( $enviroment == 'live') {
  $endpoint = 'https://payflowpro.paypal.com';
  $r_url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
} else {
  $endpoint = 'https://pilot-payflowpro.paypal.com';
  $r_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
}

foreach ($_POST as $key => $value) {
  $data["$key"] = $value;
}

$myvars = urldecode( http_build_query( $data ) );

//$headers[] = "PAYPAL-NVP:Y";

$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $endpoint );
curl_setopt( $ch, CURLOPT_POST, 1 );
//curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

$resp = curl_exec( $ch );

parse_str( $resp, $resp );

$token = $resp['TOKEN'];

//print_r( $resp );

header( "location: $r_url$token" );
