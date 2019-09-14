<?php

$credentials = [
  'EMAIL'           =>  'test@houserennard.online',

  'API_USER'        =>  'test_api1.houserennard.online',
  'API_PWD'         =>  'KY55YZG3P5PLZCQF',
  'API_SIG'         =>  'AXX7mYPHH9rMLBowrRHQ7VwXTiyqAe6wVSrIuROubT-qKKVCj99GLBmf',

  'BRAD_APIUSER'       =>  'brad1_api1.brad1.com',
  'BRAD_APIPWD'        =>  'NYU635QLGYK2SJXW',
  'BRAD_APISIG'        =>  'AIg7G10R6skhA5mGdmcaVrtIURzYALG2NUkAdG9zdzMSqXs2sWZZeVXS',

  'BT_TOKEN'        =>  'access_token$sandbox$wcjmhvwmdjvyc96t$fb91a6764f3c1660c4d3f8bc72f31cc4',
  'BT_MERCH_ID'     =>  'b3jdzs4vztpct67t',
  'BT_PUBLIC_KEY'   =>  'wy2m82tymdwdyksb',
  'BT_PRIVATE_KEY'  =>  'c9588c278f8b688105de7e7d0b830e78',
  'BT_TOKEN_KEY'    =>  'sandbox_qbfbp52b_b3jdzs4vztpct67t',

  'PF_PARTNER'      =>  'PayPal',
  'PF_VENDOR'       =>  'campbellwebdev',
  'PF_USER'         =>  'pftest',
  'PF_PWD'          =>  'Test1234!',

  'BRAD_VENDOR'     =>  'Schweino',
  'BRAD_USER'       =>  'GreatNate',
  'BRAD_PWD'        =>  'Nate1234!',

  'BRAD_PAYERID'    =>  'EWM7XKYW4FWFC',

  'REST_CLIENT'     =>  'Ac6H07w7vhsy6TuJCPccxzIHy_JUQa_5u6FxfdoB9Ehr_BnbxwDw2rYkZz35Jon_hD2Bn249yE8qiZwM',
  'REST_SECRET'     =>  'EDvA3U7a1tlSzfI5r1PkczipzpfhyPXCjLqRnBDThMhwEvTRD96cn4nMCKzgcTRLWOh_93sSD1jS9J3e',
];

if ( $_SERVER[ 'HTTP_HOST' ] == 'localhost' ) {

} else {
  $brad = [  
    'BRAD_APIUSER'    =>  'brad1_api1.brad1.com',
    'BRAD_APIPWD'     =>  'NYU635QLGYK2SJXW',
    'BRAD_APISIG'     =>  'AIg7G10R6skhA5mGdmcaVrtIURzYALG2NUkAdG9zdzMSqXs2sWZZeVXS',
    'BRAD_VENDOR'     =>  'Schweino',
    'BRAD_USER'       =>  'GreatNate',
    'BRAD_PWD'        =>  'Nate1234!',
    'BRAD_PAYERID'    =>  'EWM7XKYW4FWFC',
  ];
  
  foreach( $brad as $k => $v ) {
    $credentials[$k] = '';

    for ( $i = 0 ; $i < strlen( $v ) ; $i++ ) {
      $credentials[$k] .= 'x';
    } 
  }
} 

?>
