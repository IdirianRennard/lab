<?php
include 'include.php';

$URL = "";

switch ( $_POST['endpoint'] ) {
  case 'payflow':
    switch ( $_POST['env'] ) {
      case 'live':
        $URL = "https://payflowpro.paypal.com";
        break;

      case 'sandbox':
        $URL = "https://pilot-payflowpro.paypal.com";
        break;
      default:
        break;
    }
    break;

  case 'legacy':
    switch ( $_POST['env'] ) {
      case 'live':
        $URL = "https://api-3t.paypal.com/nvp";
        break;
      case 'sandbox':
        $URL = "https://api-3t.sandbox.paypal.com/nvp";
        break;
      default:
        break;
    }
    break;

  default:
    break;
}

$data = $_POST['api_str'];
unset( $_POST['api_str'] );

$ch = curl_init( $URL );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $data);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$resp = curl_exec( $ch );

$resp_str =  $resp;

parse_str( $resp, $resp );

ksort( $resp );

?>
<table class='table'>
  <tr>
    <td>URL:</td>
    <script>spaces(4)</script>
    <td colspan='42'><?php echo $URL; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>Sent:</td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td colspan='42'><?php echo $data; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <?php
    parse_str( $data, $data );
    ksort( $data );

    foreach ($data as $k => $v) {
        echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(2)</script><td>=></td><script>spaces(2)</script><td>|$v|</td></tr>";
    }
  ?>
  <tr><td><br></td></tr>
  <tr>
    <td>RESPONSE:</td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td colspan='42'><?php echo $resp_str; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <?php
    foreach ($resp as $k => $v) {
        echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(2)</script><td>=></td><script>spaces(2)</script><td>$v</td></tr>";
    }
  ?>
</table>
