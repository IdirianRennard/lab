<?php
$url = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';

$data = file_get_contents( 'php://input' );

$string = urldecode( http_build_query( $data ) );

$string .= "&cmd=_notify-validate";

$ch = curl_init();

curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_POST, true );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_HEADER, true );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $string );

$resp = urldecode( curl_exec( $ch ) );

$http_code = curl_getinfo( $ch, CURLINFO_RESPONSE_CODE );

curl_close($ch);

$headers =
  'From: "IPN Handler" <idirian@houserennard.online>' . "\r\n" .
  'Reply-To: idirian@houserennard.online' . "\r\n" .
  'X-Mailer: PHP/' . phpversion();

$subject = "IPN Test";

$message = "HTTP CODE: $http_code";
$message .= "RESPONSE: $resp\n\n";


mail( 'nsheridan@paypal.com', $subject, $message, $headers);

?>

