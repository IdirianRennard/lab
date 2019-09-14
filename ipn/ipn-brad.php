<?php

$myvars = "Daily Report";
$url = "https://houserennard.online/highlander/ipn.php";

$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$url = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';

$myvars = "cmd=_notify-validate";

foreach ($_POST as $key => $value) {
  $myvars .= "&$key=$value";
}

$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );

$message = "Test RESPONSE: $response \n\n";

$url = 'https://ipnpb.paypal.com/cgi-bin/webscr';

$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );

$message .= "Live RESPONSE: $response \n\n";

$headers =
  'From: "Idirian Rennard IPN" <idirian@houserennard.online>' . "\r\n" .
  'Reply-To: idirian@houserennard.online' . "\r\n" .
  'X-Mailer: PHP/' . phpversion();

$subject = "IPN Test";

$message .= "POST: \n\n";
foreach ($_POST as $key => $value) {
  $message .= "[ $key ] => $value \n";
}

mail( 'bschweinsburg@paypal.com', $subject, $message, $headers);

?>
