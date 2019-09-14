<?php

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

  $message = "<select class='drop' name='currency'>";

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

?>
