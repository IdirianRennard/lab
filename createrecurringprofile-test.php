<?php 
include 'include.php';

$enviroment = $_POST['enviroment'];
unset ( $_POST['enviroment'] );

if( $enviroment == 'live') {
  $endpoint = 'https://api-3t.paypal.com/nvp';
} else {
  $endpoint = 'https://api-3t.sandbox.paypal.com/nvp';
}

$data = urldecode( http_build_query( $_POST ) );

$res = nvp_api( $endpoint, $data );

$resp_string = urldecode( $res );

parse_str( $res, $res );

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
  echo "<tr><td colspan='42'>$data</td></tr>";
  echo "<tr><td><br></td></tr>";
  foreach ($_POST as $k => $v) {
      echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
  }

  echo "<tr><td><br></td></tr>";
  echo "<tr><td><br></td></tr>";

  echo "<tr><td colspan='42' align='left'>RESPONSE:</td></tr>";
  echo "<tr><td><br></td></tr>";
  echo "<tr><td colspan='42'>$resp_string</td></tr>";
  echo "<tr><td><br></td></tr>";
  foreach ($res as $k => $v) {
    echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
  }
  echo "<tr><td><br></td></tr>";
?>
</tr>
</table>