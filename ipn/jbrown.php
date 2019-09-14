<?php

$url = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';

$myvars = http_build_query( $_POST );

$myvars = str_replace( "¤" , "&curren" , $myvars );
$myvars = str_replace( "¬" , "&not" , $myvars );

$myvars = urldecode( $myvars );

$message = "IPN String: <br>$myvars <hr>";

$myvars .= "&cmd=_notify-validate";

$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );

$message .= "Test RESPONSE: $response <hr>";

$url = 'https://ipnpb.paypal.com/cgi-bin/webscr';

$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );

$message .= "Live RESPONSE: $response <hr>";


$headers =
  'MIME-Version: 1.0' . "\r\n" .
  'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
  'From: idirian@houserennard.online' . "\r\n" .
  'Reply-To: idirian@houserennard.online' . "\r\n" .
  'X-Mailer: PHP/' . phpversion();

$subject = "IPN Test";

$message .= "<table>";

ksort( $_POST );

foreach ( $_POST as $k => $v ) {
  $message .= "<tr><td>[</td><td>&nbsp&nbsp&nbsp&nbsp</td><td>$k</td><td>&nbsp&nbsp&nbsp&nbsp</td><td>]</td><td>&nbsp&nbsp</td><td>=></td><td>&nbsp&nbsp</td><td>$v</td></tr>";
}

$message .= "</table>";

echo $message;

mail( 'jamesbrown@paypal.com', $subject, $message, $headers);

?>
