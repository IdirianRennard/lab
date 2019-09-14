<?php
include 'include.php';

if ( $_SESSION['enviroment'] == 'production' ) {
  $url = "https://api.paypal.com/v1/invoicing/templates";
} else {
  $url = "https://api.sandbox.paypal.com/v1/invoicing/templates";
}

$token = $_SESSION['token'];

$header = [
  "Content-Type:application/json",
  "Authorization: Bearer $token",
];

$date = date( 'ymd-His' );

class data {
  public $name;
  public $default;
  public $unit_of_measure;
}

class template_data {
  public $merchant_info;
  public $items;
  public $tax_calculated_after_discount;
  public $tax_inclusive;
  public $note;
}

class merchant_info {
  public $email;
  public $first_name;
  public $last_name;
  public $business_name;
  public $phone;
  public $address;
}

class phone {
  public $country_code;
  public $national_number;
}

class address {
  public $line1;
  public $city;
  public $state;
  public $postal_code;
  public $country_code;
}

class items {
  public $name;
  public $quantity;
  public $unit_price;
}

class unit_price {
  public $currency;
  public $value;
}

$data = new data;

$data->name = "Invoice Template Test $date";
$data->default = FALSE;
$data->unit_of_measure = 'AMOUNT';

$data->template_data = new template_data;
$data->template_data->merchant_info = new merchant_info;
$data->template_data->merchant_info->email = 'test@houserennard.online';
$data->template_data->merchant_info->first_name = 'Idirian';
$data->template_data->merchant_info->last_name = 'Rennard';
$data->template_data->merchant_info->business_name = 'House Rennard';

$data->template_data->merchant_info->phone = new phone;
$data->template_data->merchant_info->phone->country_code = '001';
$data->template_data->merchant_info->phone->national_number = '8882211161';

$data->template_data->merchant_info->address = new address;
$data->template_data->merchant_info->address->line1 = '123 Fake St';
$data->template_data->merchant_info->address->city = 'Schenectady';
$data->template_data->merchant_info->address->state = 'NE';
$data->template_data->merchant_info->address->postal_code = '12345';
$data->template_data->merchant_info->address->country_code = 'US';

$data->template_data->items[0] = new items;
$data->template_data->items[0]->name = 'Rennard Copper';
$data->template_data->items[0]->quantity = 1;

$data->template_data->items[0]->unit_price = new unit_price;
$data->template_data->items[0]->unit_price->currency = 'USD';
$data->template_data->items[0]->unit_price->value = '1.00';

$data->template_data->tax_calculated_after_discount = FALSE;
$data->template_data->tax_inclusive = TRUE;
$data->template_data->note = 'Created using Idirian\'s Lab for Testing';

$data = json_encode( $data );

$ch = curl_init();

curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_URL, "$url");
curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$resp = curl_exec( $ch );

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
    <td><?php echo $resp; ?>
  </tr>
  <?php
    $resp = json_decode( $resp );

    if ( isset( $resp->template_id ) ) {
      echo "<tr><td colspan='42'><hr></td></tr>";
      echo "<tr><td colspan='42' align='right'><a href='rest_inv_template_list-test2.php'><input class='button' type='button' value='  View Template List  '></a></td></tr>";
    }
  ?>
</table>
