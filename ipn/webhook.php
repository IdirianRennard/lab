<?php

class cred {
  public $client;
  public $secret;
  public $token_url;
  public $url;
  public $token;
  public $webhook_id;
};

class verify {
  public $transmission_id;
  public $transmission_time;
  public $cert_url;
  public $auth_algo;
  public $transmission_sig;
  public $webhook_id;
  public $webhook_event;
}

$message = '';

$req_headers = apache_request_headers();

$wh_event = json_decode( file_get_contents('php://input') );

$sb = new cred ();
$sb->client = 'Ac6H07w7vhsy6TuJCPccxzIHy_JUQa_5u6FxfdoB9Ehr_BnbxwDw2rYkZz35Jon_hD2Bn249yE8qiZwM';
$sb->secret = 'EDvA3U7a1tlSzfI5r1PkczipzpfhyPXCjLqRnBDThMhwEvTRD96cn4nMCKzgcTRLWOh_93sSD1jS9J3e';
$sb->token_url = 'https://api.sandbox.paypal.com/v1/oauth2/token';
$sb->url = 'https://api.sandbox.paypal.com/v1/notifications/verify-webhook-signature';
$sb->webhook_id = '0KR80519DC745060G';

$live = new cred ();
$live->client = 'ATjr95vYYL_NJNcE1UJVfyVCypGA0U6ngu8mNTOLGU89fQ_XtII8DTF7o3HAttd5jgnihU6_Y93W_ZXm';
$live->secret = 'ECT2yPTy8qYrcnlbgmv8fK8oKeTxhnACnqivYCHsgA9Ohr2yTcTf7pLn_LOjbneWWdKPuPxq0bDmPMAw';
$live->token_url = 'https://api.paypal.com/v1/oauth2/token';
$live->url = 'https://api.paypal.com/v1/notifications/verify-webhook-signature';
$live->webhook_id = '2CM68596AC0806207';

$ch = curl_init();

curl_setopt( $ch, CURLOPT_URL, $sb->token_url );
curl_setopt( $ch, CURLOPT_POST, true);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt( $ch, CURLOPT_USERPWD, "$sb->client:$sb->secret" );
curl_setopt( $ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials" );

$result = curl_exec($ch);

$result = json_decode( $result );

$sb->token = $result->access_token;

$rest_header = [
  "Content-Type:application/json",
  "Authorization: Bearer $sb->token",
];

$verify = new verify ();
$verify->transmission_id = $req_headers['Paypal-Transmission-Id'];
$verify->transmission_time = $req_headers['Paypal-Transmission-Time'];
$verify->cert_url = $req_headers['Paypal-Cert-Url'];
$verify->auth_algo = $req_headers['Paypal-Auth-Algo'];
$verify->transmission_sig = $req_headers['Paypal-Transmission-Sig'];
$verify->webhook_id = $sb->webhook_id;
$verify->webhook_event = $wh_event;

$data = json_encode( $verify );

$ch = curl_init();

curl_setopt( $ch, CURLOPT_HTTPHEADER, $rest_header );
curl_setopt( $ch, CURLOPT_URL, $sb->url );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );

$result = curl_exec($ch);

$result = json_decode( $result );

$message .= "Sandbox: $result->verification_status";
$message .= "<br><br>";

$ch = curl_init();

curl_setopt( $ch, CURLOPT_URL, $live->token_url );
curl_setopt( $ch, CURLOPT_POST, true);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt( $ch, CURLOPT_USERPWD, "$live->client:$live->secret" );
curl_setopt( $ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials" );

$result = curl_exec($ch);

$result = json_decode( $result );

$live->token = $result->access_token;

$rest_header = [
  "Content-Type:application/json",
  "Authorization: Bearer $live->token",
];

$verify = new verify ();
$verify->transmission_id = $req_headers['Paypal-Transmission-Id'];
$verify->transmission_time = $req_headers['Paypal-Transmission-Time'];
$verify->cert_url = $req_headers['Paypal-Cert-Url'];
$verify->auth_algo = $req_headers['Paypal-Auth-Algo'];
$verify->transmission_sig = $req_headers['Paypal-Transmission-Sig'];
$verify->webhook_id = $live->webhook_id;
$verify->webhook_event = $wh_event;

$data = json_encode( $verify );

$ch = curl_init();

curl_setopt( $ch, CURLOPT_HTTPHEADER, $rest_header );
curl_setopt( $ch, CURLOPT_URL, $live->url );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );

$result = curl_exec($ch);

$result = json_decode( $result );

$message .= "Live: $result->verification_status";
$message .= "<br><br><hr>";

$verify->webhook_id = $sb->webhook_id . " || " . $live->webhook_id;


?>
