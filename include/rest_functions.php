<?php

function console ( $value ) {
  if ( is_array( $value ) ) {
    foreach( $value as $k => $v ) {
      if ( isset( $v ) ) {
        echo "<script>console.log ( '$k : $v' )</script>";
      }
    } 
  } else {
    echo "<script>console.log( '$value' )</script>";
  }
}

$currency = [
  'AUD',
  'BRL',
  'CAD',
  'CZK',
  'DKK',
  'EUR',
  'HKD',
  'HUF',
  'ILS',
  'JPY',
  'MYR',
  'MXN',
  'NOK',
  'NZD',
  'PHP',
  'PLN',
  'GBP',
  'SGD',
  'SEK',
  'CHF',
  'TWD',
  'THB',
  'USD',
];

function currency_dropdown() {
  global $currency;

  $message = "<select class='drop' name='CURRENCY'>";

  foreach ( $currency as $k => $v ) {
    if ( $v == 'USD' ) {
      $message .= "<option value='$v' selected>$v</option>";
    } else {
      $message .= "<option value='$v'>$v</option>";
    }
  }

  $message .= "</select>";

  return $message;
}

function nvp_api ( $endpoint, $data, $header ) {

  echo "<script>console.log( 'ENDPOINT : $endpoint' )</script>";

  $request_id = "RENNARD-";

  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

  for ($i = 0 ; $i < 24 ; $i++) {
    $request_id .= $characters[mt_rand(0, strlen($characters) - 1)];
  }

  $headers = array();

  if ( $header == NULL ) {
    $headers[] = "X-VPS-REQUEST-ID: $request_id";
  } else {
    foreach( $header as $k => $v ) {
      $headers[$k] = $v;
    }
  }

  foreach( $headers as $k => $v ) {
    echo "<script>console.log( '$v' )</script>";
  }
  
  $ch = curl_init();

  curl_setopt( $ch, CURLOPT_URL, $endpoint );
  curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt( $ch, CURLOPT_POST, true );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
  curl_setopt( $ch, CURLOPT_HEADER, true );
  if ( $data === NULL ) {
    
  } else {
    echo "<script>console.log( \"DATA : $data\" )</script>";
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
  }
  
  $resp = urldecode( curl_exec( $ch ) );

  $http_code = curl_getinfo( $ch, CURLINFO_RESPONSE_CODE );
  curl_close($ch);

  $headers = [];
  $output = rtrim($resp);
  $vars = explode("\n",$output);
  $headers['status'] = $vars[0];
  array_shift($vars);

  foreach($vars as $part){
    $middle = explode(":",$part,2);
    if ( !isset($middle[1]) ) { $middle[1] = null; }
    $headers[trim($middle[0])] = trim($middle[1]);
  } 
  
  if ( strstr( $resp, 'RESULT' ) == '' ) {
    $result = strstr( $resp, 'TOKEN' );
  } else {
    if ( strstr( $resp, 'RESULT' ) == '' ) {
      $result = strstr( $resp, 'TIMESTAMP' );
    } else {
      $result = strstr( $resp, 'RESULT' );
    }
  }

  $console = [
    'HTTP CODE' =>  $http_code,
    'RESPONSE'  =>  $result,
  ];

  if ( isset ( $headers['Paypal-Debug-Id'] ) ) {
    $console[ 'PAYPAL-DEBUG-ID' ] = $headers['Paypal-Debug-Id'];
  }

  console ( $console );

  return $console['RESPONSE'];
}

function rest_oauth ( $clientid, $secret, $env ) {
  if ( $env == 'production' ) {
    $token_url = "https://api.paypal.com/v1/oauth2/token";
  } else {
    $token_url = "https://api.sandbox.paypal.com/v1/oauth2/token";
  }

  console( $token_url );

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $token_url );
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_USERPWD, "$clientid:$secret");
  curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

  $res = curl_exec($ch);

  $http_code = curl_getinfo( $ch, CURLINFO_RESPONSE_CODE );
  curl_close($ch);

  $result = json_decode( $res );

  $token = $result->access_token;
  $scope = $result->scope;

  $console = [
    'HTTP CODE'       =>  $http_code,
    'TOKEN'           =>  $token,
    'SCOPE'           =>  $scope,
  ];

  console ( $console );

  return $token;
}

function rest_api ( $endpoint, $data, $token ) {
  
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $request_id = '';
  
  for ($i = 0 ; $i < 36 ; $i++) {
    $request_id .= $characters[mt_rand(0, strlen($characters) - 1)];
  }
  
  $header = [
    "Content-Type:application/json",
    "Authorization: Bearer $token",
    "PayPal-Request-Id: $request_id",
  ];

  $ch = curl_init();

  curl_setopt( $ch, CURLOPT_URL, $endpoint );
  curl_setopt( $ch, CURLOPT_HTTPHEADER, $header);
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
  curl_setopt( $ch, CURLOPT_HEADER, true );

  if ( $data === NULL ) {
    curl_setopt( $ch, CURLOPT_HTTPGET, true );
  } else {
    curl_setopt( $ch, CURLOPT_POST, true );
    echo "<script>console.log( 'DATA: $data' )</script>";
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
  }
  
  $resp = curl_exec( $ch );

  $http_code = curl_getinfo( $ch, CURLINFO_RESPONSE_CODE );
  $curl_headers = curl_getinfo( $ch );

  curl_close ($ch );

  $headers = [];
  $output = rtrim($resp);
  $vars = explode("\n",$output);
  $headers['status'] = $vars[0];
  array_shift($vars);

  foreach($vars as $part){
    $middle = explode(":",$part,2);
    if ( !isset($middle[1]) ) { $middle[1] = null; }
    $headers[trim($middle[0])] = trim($middle[1]);
  } 

  $console = [
    'ENDPOINT'        =>  $endpoint,
    'HTTP CODE'       =>  $http_code,
    'RESPONSE'        =>  strstr( $resp, '{' ),
    'PAYPAL-DEBUG-ID' =>  $headers['paypal-debug-id'],
  ];

  console ( $console );
   
  return $console['RESPONSE'];
}

function state_dropdown( $state ) {
  $us_state_abbrevs = array('AL', 'AK', 'AS', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FM', 'FL', 'GA', 'GU', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MH', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'MP', 'OH', 'OK', 'OR', 'PW', 'PA', 'PR', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VI', 'VA', 'WA', 'WV', 'WI', 'WY', 'AE', 'AA', 'AP');
 
  echo "<select name='STATE' required>";

  if ( $state == NULL ) {
    echo "<option selected disabled>State</option>";
    foreach ( $us_state_abbrevs as $k => $v ) {
      echo "<option value='$v'>$v</option>";
    }
  } else { 
    echo "<option disabled>State</option>";
    foreach ( $us_state_abbrevs as $k => $v ) {
      if ( $v == $state ) {
        echo "<option value='$v' selected>$v</option>";
      } else {
        echo "<option value='$v'>$v</option>";
      }
      
    }
  }
  
  echo "</select>";
}


?>