<?php

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.1\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

if($version == 'sandbox'){
  $fp = fsockopen ('tls://ipnpb.sandbox.paypal.com', 443, $errno, $errstr, 30);
} else {
  $fp = fsockopen ('tls://ipnpb.paypal.com', 443, $errno, $errstr, 30);
}

$header .= "Host: www.paypal.com\r\n";
$header .= "Connection: close\r\n\r\n";

$putRes = fputs ($fp, $header . $req);

$headers =
  'MIME-Version: 1.0' . "\r\n" .
  'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
  'From: idirian@houserennard.online' . "\r\n" .
  'Reply-To: idirian@houserennard.online' . "\r\n" .
  'X-Mailer: PHP/' . phpversion();

$subject = "IPN Test";

mail( 'nsheridan@paypal.com', $subject, $putRes, $headers);
?>
