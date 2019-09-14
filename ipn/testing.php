<?php
$value = '{
  "id": "WH-2WR32451HC0233532-67976317FL4543714",
  "create_time": "2014-10-23T17:23:52Z",
  "resource_type": "sale",
  "event_type": "PAYMENT.SALE.COMPLETED",
  "summary": "A successful sale payment was made for $ 0.48 USD",
  "resource": {
    "parent_payment": "PAY-1PA12106FU478450MKRETS4A",
    "update_time": "2014-10-23T17:23:04Z",
    "amount": {
      "total": "0.48",
      "currency": "USD"
    },
    "payment_mode": "ECHECK",
    "create_time": "2014-10-23T17:22:56Z",
    "clearing_time": "2014-10-30T07:00:00Z",
    "protection_eligibility_type": "ITEM_NOT_RECEIVED_ELIGIBLE,UNAUTHORIZED_PAYMENT_ELIGIBLE",
    "protection_eligibility": "ELIGIBLE",
    "links": [
      {
        "href": "https://api.paypal.com/v1/payments/sale/80021663DE681814L",
        "rel": "self",
        "method": "GET"
      },
      {
        "href": "https://api.paypal.com/v1/payments/sale/80021663DE681814L/refund",
        "rel": "refund",
        "method": "POST"
      },
      {
        "href": "https://api.paypal.com/v1/payments/payment/PAY-1PA12106FU478450MKRETS4A",
        "rel": "parent_payment",
        "method": "GET"
      }
    ],
    "id": "80021663DE681814L",
    "state": "completed"
  },
  "links": [
    {
      "href": "https://api.paypal.com/v1/notifications/webhooks-events/WH-2WR32451HC0233532-67976317FL4543714",
      "rel": "self",
      "method": "GET",
      "encType": "application/json"
    },
    {
      "href": "https://api.paypal.com/v1/notifications/webhooks-events/WH-2WR32451HC0233532-67976317FL4543714/resend",
      "rel": "resend",
      "method": "POST",
      "encType": "application/json"
    }
  ],
  "event_version": "1.0"
}';
?>
<form action='webhook.php' method='post' target='_blank'>
  <input type='hidden' name='wh' value='<?php echo $value; ?>'>
  <input type='submit' value='submit'>
</form>
