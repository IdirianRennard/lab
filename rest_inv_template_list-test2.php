<?php
include 'include.php';


$clientid = $_SESSION['clientid'];

$secret = $_SESSION['secret'];

$token = $_SESSION['token'];

if ( $_SESSION['enviroment'] == 'production' ) {
  $url = "https://api.paypal.com/v1/invoicing/templates";
} else {
  $url = "https://api.sandbox.paypal.com/v1/invoicing/templates";
}

$header = [
  "Content-Type:application/json",
  "Authorization: Bearer $token",
];

$query= "";

$ch = curl_init();

curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_URL, "$url/$query");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$resp = curl_exec( $ch );

$resp = json_decode( $resp );

$templates = array();

for( $i = 0 ; $i < count( $resp->templates ) ; $i++ ) {
  $templates[ $resp->templates[$i]->template_id ] = $resp->templates[$i]->name;
}

asort( $templates );
?>
<table class="table">
<form action="rest_inv_template-test3.php" method='post'>
  <tr>
    <td>Which Invoice would you like to send?</td><script>spaces(2)</script>
    <td><select class='drop' class='drop' name='temp_id' required>
      <option selected='selected' disabled='disabled'>Select Invoice Name</option>
      <?php
        foreach ($templates as $k => $v) {
          echo "<option value='$k'>$v</option>";
        }
      ?>
    </select><br></td>
  </tr>
  <tr><td>Recipient First Name:</td><td></td><td><input type='text' class='drop' name='r_f_name' id='r_f_name' placeholder="  First Name"></td></tr>
  <tr><td>Recipient Last Name:</td><td></td><td><input type='text' class='drop' name='r_l_name' id='r_l_name' placeholder="  Last Name"></td></tr>
  <tr><td>Recipient Email:</td><td></td><td><input type='text' class='drop' name='r_email' id='r_email' placeholder="  Email Address"></td></tr>
  <tr>
    <td colspan="42" align='right'><hr><input type='submit' class='button' value=' SUBMIT '></td>
  </tr>
</table>
