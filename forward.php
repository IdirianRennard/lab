<?php

$dt = $_GET['dt'];

$dt = urldecode( base64_decode( $dt ) );

parse_str( $dt, $data );

$rtp = $data['RFP'];

$get = urldecode( http_build_query( $_GET ) );

header( "location: $rtp" . "rest-sub-v1-return.php?$get" );
?>