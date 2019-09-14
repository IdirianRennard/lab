<?php
session_start();

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

$url .= '/v1/invoicing/templates';
$_SESSION['url'] = $url;

header( 'location: rest_inv_template-test2.php');

?>
