<?php
include 'include/rest_functions.php';
include 'include/credentials.php';

class data {
}

$client = $credentials['REST_CLIENT'];
$secret = $credentials['REST_SECRET'];

$data = new data ();

$data->test = 'this is a test';

$data = json_encode( $data );

$token = rest_oauth( $client, $secret, 'sandbox' );

$url = 'http://webhook.site/95578e5b-670f-40e3-b5b5-eb663673f206';

$header_test = rest_api( $url, $data, $token );

?>