<?php

$url = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';

$myvars = http_build_query( $_POST );

$myvars = str_replace( "¤" , "&curren" , $myvars );
$myvars = str_replace( "¬" , "&not" , $myvars );

$myvars = urldecode( $myvars );

$fp = fsockopen( "$url" );

fwrite( $fp, "POST /reposter.php HTTP/1.1\r\n" );
fwrite( $fp, "Host: example.com\r\n" );
fwrite( $fp, "Content-Type: application/x-www-form-urlencoded\r\n" );
fwrite( $fp, "Content-Length: " . strlen( $myvars ) . "\r\n" );
fwrite( $fp, "Connection: close\r\n" );
fwrite( $fp, "\r\n" );

fwrite( $fp, $myvars );

$message = '';

while ( !feof( $fp ) ) {
    $message .= fgets( $fp, 1024 );
}

$headers =
  'MIME-Version: 1.0' . "\r\n" .
  'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
  'From: idirian@houserennard.online' . "\r\n" .
  'Reply-To: idirian@houserennard.online' . "\r\n" .
  'X-Mailer: PHP/' . phpversion();

$subject = "Fsock Test";

mail( 'njsheridan@gmail.com', $subject, $message, $headers);

?>
