<?php

$clientid = 'v1sEMwSlQEsf23Cyx1eZ3bIZD';
$secret = 'CXk63g9MhxRPhE3z9gpRctcm0qbBQUy748Iuxya75PsSrHaeAk';

$data = file_get_contents( 'php://input' );

$data = json_decode( $data );

class data {

}

$id = substr( $data->link, -19 );

$link = $data->link;
$username = $data->username;

$token_url = 'https://api.twitter.com/oauth2/token';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $token_url );
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$clientid:$secret");
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

$result = curl_exec($ch);

$result = json_decode( $result );

$token = $result->access_token;

$headers = [
  "authorization: Bearer $token",
  "content-type: applicaiton/json"
];

$url = "https://api.twitter.com/1.1/statuses/show/$id.json";

$ch = curl_init();

curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers) ;
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

$res = curl_exec( $ch );

header('Content-Type: application/json');
echo $res;

$json = json_decode( $res );

$flag = FALSE;

if ( $json->in_reply_to_status_id !== NULL ) {
  $flag = TRUE;
}

if ( $json->in_reply_to_user_id !== NULL ) {
  $flag = TRUE;
}

if ( $json->in_reply_to_screen_name !== NULL ) {
  $flag = TRUE;
}

if ( $flag ) {
  exit;
}

$discord = new data ();

$discord->username = $username;
$discord->content = $json->text;

$discord = json_encode( $discord );

$url = 'https://discordapp.com/api/webhooks/616055110467977225/t0I_5hsN72doSq7UOC3usad6KQMQU4-WUhFI35eLK3PtcExmZ1dlXgyChlG5kmJ8PP5Z';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $discord );

$res = curl_exec( $ch );

?>