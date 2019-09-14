<?php
include 'include.php';

$env = $_POST['enviroment'];
unset ( $_POST['enviroment'] );

if( $env == 'production') {
  $endpoint = 'https://payflowpro.paypal.com/';
  $page = 'https://payflowlink.paypal.com/';
  $mode = 'live';
} else {
  $endpoint = 'https://pilot-payflowpro.paypal.com/';
  $page = 'https://pilot-payflowlink.paypal.com/';
  $mode = 'test';
}

$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$secure_token_id = '';

for ($i = 0 ; $i < 36 ; $i++) {
  $secure_token_id .= $characters[mt_rand(0, strlen($characters) - 1)];
}

$data = [
  'CREATESECURETOKEN' => 'Y',
  'CURRENCY' => 'USD',
  'SECURETOKENID' => $secure_token_id,
  'COMMENT1' => 'NATE TEST PFLINK',
  //'NOTIFYURL' => 'https://localhost/test/idirian/ipn/ipn.php',
  'ERRORURL' => $return_file_path . 'test.php?error=1',
  'RETURNURL' => $return_file_path . 'test.php?return=1',
  //'SILENTPOSTURL' => 'https://houserennard.online/idirian/ipn/ipn.php',
];


foreach ($_POST as $k => $v) {
  $data["$k"] = $v;
}

ksort( $data );

$myvars = urldecode( http_build_query( $data ) );

$ch = curl_init( $endpoint );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$resp = curl_exec( $ch );

$resp_string = $resp;

parse_str( $resp, $resp );

$token = [
  'SECURETOKEN' => $resp['SECURETOKEN'],
  'SECURETOKENID' => $resp['SECURETOKENID'],
];

$token = urldecode( http_build_query ( $token ) );

$iframe_url = "$page?$token";

ksort( $resp );
?>

<br>
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
      if( $k == 'PWD1') {
        $pwd_v = "";
        for( $i = 0 ; $i < strlen( $v ) ; $i += 1 ) {
          $pwd_v .= 'X';
        }
        echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$pwd_v|</td></tr>";
      } else {
        echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
      }
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
    echo "<tr><td>[</td><td></td><td>FRAME URL</td><td></td><td>]</td><td></td><td>=></td><td></td><td>$iframe_url</td></tr>";
  ?>
  </tr>
  <tr><td><br></td></tr>
  <tr><td><br></td></tr>
  <tr>
    <td colspan='42' align='center'>
      <iframe style="background-color: white" src="<?php echo $iframe_url; ?>" name="test_iframe" scrolling="no" width="570px" height="540px"></iframe>
    </td>
  </tr>
  <tr><td><br></td></tr>
  <tr><td><br></td></tr>
</table>
