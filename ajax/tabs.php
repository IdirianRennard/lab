<?php
$tabs = [
    'bliz'  =>  'Blizzard',
    'pypl'  =>  'PayPal',
];
  
ksort( $tabs );

header('Content-Type: application/json');

echo json_encode( $tabs );
  
?>