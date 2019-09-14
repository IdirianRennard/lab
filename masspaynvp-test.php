<?php
include 'include.php';


$enviroment = $_POST['enviroment'];
unset( $_POST['enviroment']);

unset( $_POST['quantity'] );

if( $enviroment == 'live') {
  $endpoint = 'https://api-3t.paypal.com/nvp';
} else {
  $endpoint = 'https://api-3t.sandbox.paypal.com/nvp';
}

$data = array();

foreach ($_POST as $key => $value) {
    $data["$key"] = $value;
}


ksort( $data );

$myvars = urldecode( http_build_query( $data ) );

$ch = curl_init( $endpoint );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$resp = curl_exec( $ch );

parse_str( $resp, $resp );
?>

<table class='table'>
  <tr><td colspan="42" align='left'>INPUT:</td></tr>
  <tr><td><br></td></tr>
  <?php
  foreach ($data as $k => $v) {
    if( $k == 'PWD') {
      $pwd_v = "";
      for( $i = 0 ; $i < strlen( $v ) ; $i += 1 ) {
        $pwd_v .= 'X';
      }
      echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$pwd_v|</td></tr>";
    } else {
      echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
    }
  }
  ?>
  <tr><td><br></td></tr>
  <tr><td><br></td></tr>
  <tr><td colspan="42" align='left'>RESPONSE:</td></tr>
  <tr><td><br></td></tr>
  <?php
  foreach ($resp as $k => $v) {
    echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
  }
  ?>
</table>
