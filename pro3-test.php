<?php
include 'include.php';

$enviroment = $_POST['enviroment'];
unset ( $_POST['enviroment'] );

if( $enviroment == 'live') {
  $endpoint = 'https://api-3t.paypal.com/nvp';
} else {
  $endpoint = 'https://api-3t.sandbox.paypal.com/nvp';
}

$data = array();

foreach ($_POST as $k => $v) {
  $data[$k] = $v;
}

ksort( $data );

$myvars = urldecode( http_build_query( $data ) );

//header( "location: $endpoint?$myvars" );

$ch = curl_init( $endpoint );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$resp = curl_exec( $ch );

$resp_string = urldecode( $resp );

parse_str( $resp, $resp );

?>
<table class='table'>
  <tr><td>ENDPOINT:</td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan='42'><?php echo $endpoint; ?></td></tr>
  <tr><td><br></td></tr>
  <tr><td><br></td></tr>
  <?php
    echo "<tr><td colspan='42' align='left'>INPUT:</td></tr>";
    echo "<tr><td><br></td></tr>";
    echo "<tr><td colspan='42'>$myvars</td></tr>";
    echo "<tr><td><br></td></tr>";
    foreach ($data as $k => $v) {
        echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
    }

    echo "<tr><td><br></td></tr>";
    echo "<tr><td><br></td></tr>";

    echo "<tr><td colspan='42' align='left'>RESPONSE:</td></tr>";
    echo "<tr><td><br></td></tr>";
    echo "<tr><td colspan='42'>$resp_string</td></tr>";
    echo "<tr><td><br></td></tr>";
    foreach ($resp as $k => $v) {
      echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
    }
    echo "<tr><td><br></td></tr>";
  ?>
  </tr>
</table>
