<?php
include 'include.php';

$token = $_SESSION['token'];
$url = $_SESSION['url'];
$clientid = $_SESSION['clientid'];
$secret = $_SESSION['secret'];

class invoice {
  public $merchant_info;
  public $billing_info = array();
  public $shipping_info;
  public $items = array();
  public $shipping_cost;
  public $note = "Thank you for your business.";
  public $terms = "No refunds after 30 days.";
  //public $logo_url = "";
}

class merchant_info {
  public $email = 'test@houserennard.online';
  public $first_name = 'Nathanial';
  public $last_name = 'Sheridan';
  public $business_name = 'House Rennard';
  public $phone;
};

class phone {
  public $country_code = '001';
  public $national_number = '4028509472';
};

class address {
  public $line1 = '15104 Wirt St';
  public $city = 'Omaha';
  public $state = 'NE';
  public $postal_code = '68116';
  public $country_code = 'US';
}

class billing_info {
  public $email = 'nsheridan@paypal.com';
  public $first_name = 'Nate';
  public $last_name = 'Sheridan';
};

class shipping_info {
  public $first_name = 'Idirian';
  public $last_name = 'Rennard';
  public $address;
};

class items {
  public $name = "Fixation";
  public $quantity = 2;
  public $unit_price;
  public $tax;
}

class unit_price {
  public $currency = "USD";
  public $value = "1";
};

class tax {
  public $name = "Tax";
  public $percent = 8;
};

class shipping_cost {
  public $amount;
}

class amount {
  public $currency = 'USD';
  public $value = '10.00';
}

$invoice = new invoice;

$invoice->merchant_info = new merchant_info;
$invoice->merchant_info->phone = new phone;
$invoice->merchant_info->address = new address;

$invoice->billing_info[0] = new billing_info;

$invoice->shipping_info = new shipping_info;
$invoice->shipping_info->address = new address;

$invoice->items[0] = new items;
$invoice->items[0]->unit_price = new unit_price;
$invoice->items[0]->tax = new tax;

$invoice->shipping_cost = new shipping_cost;

$invoice->shipping_cost->amount = new amount;

$data = json_encode( $invoice );

$header = [
  "Content-Type:application/json",
  "Authorization: Bearer $token",
];

$ch2 = curl_init();

curl_setopt($ch2, CURLOPT_URL, $url );
curl_setopt($ch2, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch2, CURLOPT_POST, true);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_POSTFIELDS, $data );

$inv_create = curl_exec( $ch2 );

$json = $inv_create;

$inv_create = json_decode( $inv_create );

$url .= $inv_create->id . "/send?notify_merchant=true";

$_SESSION['url'] = $url;
$_SESSION['inv_id'] = $inv_create->id;
?>
<table class='table'>
  <tr>
    <td>SENT:</td>
    <script>spaces(4)</script>
    <td><?php echo $data; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>RESPONSE:</td>
    <td></td>
    <td><?php echo $json; ?></td>
  </tr>
  <?php
    if ( isset( $inv_create->id ) ) {
      echo "<tr><td colspan='42'><hr></td></tr>";
      echo "<tr><td colspan='42' align='right'><a href='rest_inv-test3.php'><input type='button' class='button' value='send'></a></td></tr>";
    }
  ?>
</table>
