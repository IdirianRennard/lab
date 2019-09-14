<?php
include 'include.php';

$enviroment = $_POST['enviroment'];
unset ( $_POST['enviroment'] );


if ( $enviroment == 'sandbox' ) {
  $url = 'https://api-3t.sandbox.paypal.com/nvp';
} else {
  $url = 'https://api-3t.paypal.com/nvp';
}

$data['METHOD'] = 'GetTransactionDetails';
$data['VERSION'] = 142;

foreach ($_POST as $k => $v) {
  $data["$k"] = $v;
}

$myvars = urldecode( http_build_query( $data ) );

$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

$result = urldecode( curl_exec( $ch ) );

parse_str( $result, $output );

ksort( $output );

?>
<table class='table'>
  <tr><td>ENDPOINT:</td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan='42'><?php echo $url; ?></td></tr>
  <tr><td><br></td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan='42' align='left'>INPUT:</td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan='42'><?php echo $myvars; ?></td></tr>
  <tr><td><br></td></tr>
    <?php
    foreach ($data as $k => $v) {
        echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
    }
    ?>
  <tr><td><br></td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan='42' align='left'>RESPONSE:</td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan='42'><?php echo $result; ?></td></tr>
  <tr><td><br></td></tr>
  <?php
  foreach ($output as $k => $v) {
    echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
  }
  ?>
</table>
