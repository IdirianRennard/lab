<?php
include 'include.php';

$data = [
  'USER' => $_SESSION['user'],
  'PWD' => $_SESSION['pwd'],
  'SIGNATURE' => $_SESSION['sig'],
  'METHOD' => 'GetExpressCheckoutDetails',
  'TOKEN' => $_GET['token'],
  'VERSION' => $_SESSION['version'],
];
ksort( $data );

$myvars = urldecode( http_build_query( $data ) );

if ( $_SESSION['enviroment'] == 'sandbox' ) {
  $url = 'https://api-3t.sandbox.paypal.com/nvp';
} else {
  $url = 'https://api-3t.paypal.com/nvp';
}

$ch = curl_init( $url );

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $myvars );

$result = urldecode( curl_exec($ch) );

$result_str = $result;

curl_close($ch);

parse_str( $result, $result );

ksort( $result );
?>

<table class='table'>
  <tr>
    <td colspan='7'>ENDPOINT:</td>
    <script>spaces(4)</script>
    <td><?php echo $url; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr><td colspan='42'>SENT:</td></tr>
  <tr><td><br></td></tr>
  <tr>
    <td colspan="999">
      <?php
      echo $myvars;
      ?>
    </td>
  </tr>
  <tr><td><br></td></tr>
  <?php
  foreach ($data as $k => $v) {
    echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
  }
  ?>
  <tr><td><br></td></tr>
  <tr><td colspan='42'>RESPONSE:</td></tr>
  <tr><td><br></td></tr>
  <tr>
    <td colspan="999">
      <?php
      echo $result_str;
      ?>
    </td>
  </tr>
  <tr><td><br></td></tr>
  <?php
  foreach ($result as $k => $v) {
    echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
  }

  if ( $result['CHECKOUTSTATUS'] == 'PaymentActionNotInitiated' ) {
    echo "<tr><td colspan='42'><hr></td></tr>";
    echo "<tr><td colspan='42' align='right'><form action='doec-para-execute.php' method='post'>";

    foreach ( $_GET as $k => $v ) {
      echo "<input type='hidden' name='$k' value='$v'>";
    }

    foreach ( $result as $k => $v ) {
      echo "<input type='hidden' name='$k' value='$v'>";
    }

    echo "<input type='submit' class='button' value='execute'></form></td></tr>";
  }
  ?>
</table>
