<?php
class data {

}

$dt = urldecode( base64_decode( ( $_GET[ 'dt' ] ) ) );

parse_str( $dt, $dt );

if ( $dt['env'] == 'sandbox' ) {
    $url = 'https://api-3t.sandbox.paypal.com/nvp';
} else {
    $url = 'https://api-3t.paypal.com/nvp';
}

$data = [
    'METHOD'                            =>  'SetExpressCheckout',
    'RETURNURL'                         =>  $dt[ 'return' ],
    'CANCELURL'                         =>  $dt[ 'cancel' ],
    'NOTIFYURL'                         =>  'https://houserennad.online/ipn/ipn.php',
    'NOSHIPPING'                        =>  '0',
    'SOLUTIONTYPE'                      =>  'SOLE',
    'LANDINGPAGE'                       =>  'Billing',
    'L_BILLINGTYPE0'                    =>  'RecurringPayments',
    'L_BILLINGAGREEMENTDESCRIPTION0'    =>  'House Rennard NVP Recurring Test',
    'PAYMENTREQUEST_0_AMT'              =>  $dt[ 'amt' ],
    'PAYMENTREQUEST_0_CURRENCYCODE'     =>  $dt[ 'cur'],
    'PAYMENREQUEST_0_DESC'              =>  'Idirian Recurring EC NVP',
    'PAYMENREQUEST_0_CUSTOM'            =>  'Idirian custom variable test!',
    'PAYMENREQUEST_0_INVNUM'            =>  'Idirian InvNum variable test!',
    'PAYMENTREQUEST_0_PAYMENTACTION'    =>  'SALE',
    'VERSION'                           =>  '124',
    'USER'                              =>  $dt[ 'user' ],
    'PWD'                               =>  $dt[ 'pwd' ],
    'SIGNATURE'                         =>  $dt[ 'sig' ],
];

ksort( $data );

$myvars = urldecode( http_build_query( $data ) );

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
$return->id = $jesus[ 'TOKEN' ];

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
$reply->ack = $jesus[ 'ACK' ];
$reply->http = $http_code;
$reply->cal = $jesus[ 'CORRELATIONID' ];
$reply->response = array ();
foreach ( $jesus as $k => $v ){
  $reply->response["$k"] = $v;
} 

ksort( $reply->response );
$reply->string = strstr( $resp, 'TOKEN' );

$return->api->response = $reply;

$return = json_encode ( $return );

header('Content-Type: application/json');
echo $return;
?>