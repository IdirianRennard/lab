<?php

$dt = $_GET['dt'];

$dt = urldecode( base64_decode( $dt ) );

parse_str( $dt, $data );

$rtp = $data['rfp'];

$get = urldecode( http_build_query( $_GET ) );

header( "location: $rtp?$get" );
?>