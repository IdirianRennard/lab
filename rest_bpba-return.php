<?php
include 'include.php';

$EC_token = $_GET['token'];

$data = urldecode( base64_decode( $_GET['auth'] ) );

parse_str( $data, $data );

$token = $data['auth'];

if ( $data['env'] == 'production' ) {
  $url = "https://api.paypal.com/v1/payments/billing-agreements/$EC_token/agreement-execute";
} else {
  $url = "https://api.sandbox.paypal.com/v1/payments/billing-agreements/$EC_token/agreement-execute";
}

$result = rest_api( $url, '', $token );

?>
<table class='table'>
  <tr>
    <td>Endpoint:</td>
    <script>spaces(4)</script>
    <td><?php echo $url; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Response:</td>
    <td></td>
    <td>
      <form action='json_view-test.php' method='post' target='_blank'>
        <input type='hidden' name='json' value='<?php echo $result; ?>'>
        <input type='submit' class='button' value='View JSON'>
      </form>
    </td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td colspan='42'><?php echo $result; ?></td>
  </tr>
</table>
