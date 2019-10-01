<?php
class data {

}

parse_str( urldecode( base64_decode( ( $_GET[ 'dt' ] ) ) ), $dt );

if ( $dt[ 'env' ] == 'sandbox' ) {
    $url = 'https://api-3t.sandbox.paypal.com/nvp';
} else {
    $url = 'https://api-3t.paypal.com/nvp';
}

$data = [
    'USER'                            =>  $dt[ 'user' ],
    'PWD'                             =>  $dt[ 'pwd' ],
    'SIGNATURE'                       =>  $dt[ 'sig' ],
    'METHOD'                          =>  'DoExpressCheckoutPayment',
    'TOKEN'                           =>  $_GET[ 'orderID' ],
    'PAYERID'                         =>  $_GET[ 'payerID' ],
    'PAYMENTREQUEST_0_AMT'            =>  $dt[ 'amt' ],
    'PAYMENTREQUEST_0_ITEMAMT'        =>  $dt[ 'amt' ],
    'PAYMENTREQUEST_0_CURRENCYCODE'   =>  $dt[ 'cur' ],
    'PAYMENTREQUEST_0_PAYMENTACTION'  =>  $dt[ 'action' ],
    'VERSION'                         =>  '124',
];

ksort( $data );
$data_arr = $data;

$data = urldecode( http_build_query( $data ) );

$request_id = "RENNARD-";

$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

for ($i = 0 ; $i < 24 ; $i++) {
  $request_id .= $characters[mt_rand(0, strlen($characters) - 1)];
}

$headers[] = "X-VPS-REQUEST-ID: $request_id";

$ch = curl_init();

curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $ch, CURLOPT_POST, true );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_HEADER, true );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );

$resp = urldecode( curl_exec( $ch ) );

$http_code = curl_getinfo( $ch, CURLINFO_RESPONSE_CODE );

curl_close($ch);

$res_header = [];
$output = rtrim( $resp );
$vars = explode( "\n",$output );
$res_header[ 'status' ] = $vars[ 0 ];
array_shift( $vars );

foreach( $vars as $part ){
  $middle = explode( ":", $part, 2);
  if ( !isset($middle[1] ) ) { $middle[1] = null; }
  $headers[ trim($middle[0] ) ] = trim( $middle[1] );
} 

parse_str( strstr( $resp, 'TOKEN' ), $jesus );

$return = new data ();
$return->ack = $jesus[ 'ACK' ];
$return->http_response = $http_code;
$return->cal = $jesus[ 'CORRELATIONID' ];

if ( isset( $jesus[ 'PAYMENTINFO_0_TRANSACTIONID' ] ) ) {
  $return->transaction = $jesus[ 'PAYMENTINFO_0_TRANSACTIONID' ];
}

if ( isset( $jesus[ 'L_ERRORCODE0' ] ) ) {
  $error = new data ();
  $error->error_code = $jesus[ 'L_ERRORCODE0' ];
  $error->severity = $jesus[ 'L_SEVERITYCODE0' ];
  $error->subject = $jesus[ 'L_SHORTMESSAGE0' ];
  $error->error_message = $jesus[ 'L_LONGMESSAGE0' ];
  $return->error = $error;
}

$return->api = new data ();
$return->api->enviroment = $dt[ 'env' ];
$return->api->endpoint = $url;

$call = new data ();
$call->header = new data ();
$call->header->request_id = $request_id;
$call->data = array ();
foreach ( $data_arr as $k => $v ) {
  if ( $k == 'USER' || $k == 'PWD' || $k == 'SIGNATURE' ) {
    $call->data["$k"] = '<< REDACTED >>';
  } else {
    $call->data["$k"] = $v;
  }
}

ksort( $call->data );

$call->string = $data;

$return->api->call = $call;

$reply = new data ();
$reply->response = array ();
foreach ( $jesus as $k => $v ){
  $reply->response["$k"] = $v;
} 

ksort ( $reply->response );

$reply->string = strstr( $resp, 'TOKEN' );

$return->api->response = $reply;


$return = json_encode ( $return );

header('Content-Type: application/json');
echo $return;

?>