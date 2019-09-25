<?php
include 'include.php';

$endpoint = $_POST[ 'endpoint' ];
echo "<script>console.log( 'ENDPOINT : $endpoint' )</script>";

$data = $_POST[ 'data' ];

$request_id = "RENNARD-";

$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

for ($i = 0 ; $i < 24 ; $i++) {
    $request_id .= $characters[mt_rand(0, strlen($characters) - 1)];
}

$headers[] = "X-VPS-REQUEST-ID: $request_id";

foreach( $headers as $k => $v ) {
    echo "<script>console.log( '$v' )</script>";
}
  
$ch = curl_init();

curl_setopt( $ch, CURLOPT_URL, $endpoint );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $ch, CURLOPT_POST, true );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_HEADER, true );

if ( $data === NULL ) {
    
} else {
    echo "<script>console.log( \"DATA : $data\" )</script>";
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );  
}
  
$resp = urldecode( curl_exec( $ch ) );

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
    'RESPONSE'        =>  strstr( $resp, 'RESULT' ),
];

console ( $console );
?>
<table class='table'>
  <tr>
    <td>ENDPOINT:</td>
    <script>spaces(4)</script>
    <td><?php echo $endpoint; ?></td>
  </tr>
  <tr><td><br></td></td>
  <tr>
    <td>DATA:</td>
    <td></td>
    <td><?php echo $data; ?></td>
  </tr>
  <tr><td><br></td></td>
  <tr>
    <td>HTTP RESPONSE:</td>
    <td></td>
    <td><?php echo $http_code; ?></td>
  </tr>
</table>