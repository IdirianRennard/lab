<?php

$splunk_dropdown = [
    'paypal'    =>  'PayPal',
    'payflow'   =>  'Payflow',
    'mts'       =>  'MTS',
    'search'    =>  'Search & Reporting',
    'globalops' =>  'Global Ops',
];

ksort( $splunk_dropdown );

header('Content-Type: application/json');

echo json_encode( $splunk_dropdown );
?>