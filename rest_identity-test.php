<?php
include 'include.php';

$enviroment = $_POST['enviroment'];
$_SESSION['enviroment'] = $enviroment;
unset( $_POST['enviroment'] );

if ( $enviroment == 'production' ) {
  $token_url = "https://api.paypal.com/v1/oauth2/token";
  $url = "https://api.paypal.com";
} else {
  $token_url = "https://api.sandbox.paypal.com/v1/oauth2/token";
  $url = "https://api.sandbox.paypal.com";
}

$clientid = $_POST['ClientID'];
$_SESSION['clientid'] = $clientid;
unset( $_POST['ClientID'] );

$secret = $_POST['Secret'];
$_SESSION['secret'] = $secret;
unset( $_POST['Secret'] );

$return = $_POST['return'];
unset( $_POST['return'] );

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $token_url );
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$clientid:$secret");
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

$result = curl_exec($ch);

curl_close($ch);

$result = json_decode( $result, TRUE );

$token = $result['access_token'];
$_SESSION['token'] = $token;

$url .= '/v1/identity/openidconnect/userinfo?schema=openid';
$_SESSION['url'] = $url;

$header = [
  "Content-Type:application/json",
  "Authorization: Bearer $token",
];

$scopes = 'openid https://uri.paypal.com/services/paypalattributes';

foreach ($_POST as $k => $v) {
  $scopes .= " $k";
  unset( $_POST["$k"] );
}

$ch_i = curl_init();

curl_setopt($ch_i, CURLOPT_URL, $url );
curl_setopt($ch_i, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch_i, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch_i, CURLOPT_POST, true);
curl_setopt($ch_i, CURLOPT_RETURNTRANSFER, true);

$identity = curl_exec( $ch_i );

curl_close( $ch_i );

?>
<script src='https://www.paypalobjects.com/js/external/api.js'></script>
<table class='table'>
  <tr>
    <td>ENDPOINT:</td>
    <script>spaces(4)</script>
    <td><?php print_r( $url ) ?>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>REQUESTED SCOPES:</td>
    <script>spaces(4)</script>
    <td><?php echo $scopes; ?></td>
  </tr>
  <tr><td><br></td></tr>
  <tr>
    <td>RESPONSE:</td>
    <script>spaces(4)</script>
    <td><?php print_r( $identity ); ?></td>
  </tr>
  <tr><td colspan='42'><hr></td></tr>
  <tr>
    <td colspan='42' id='lippButton' align='center'>
      <script>
      paypal.use( ['login'], function (login) {
        login.render ( {
          "appid":"<?php echo $clientid; ?>",
          <?php
          if ( $enviroment === 'production' ) {

          } else {
            echo '"authend":"sandbox",';
          }
          ?>
          "scopes":"<?php echo $scopes; ?>",
          "containerid":"lippButton",
          "locale":"en-us",
          "returnurl": "<?php echo $return; ?>"
        } );
      } );
      </script>
    </td>
</table>
<?php
  unset( $_SESSION );
  session_destroy();
?>
