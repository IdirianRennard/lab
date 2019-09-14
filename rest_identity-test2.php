<script>
function print(words) {
  document.write(words);
}

function spaces(number) {
  print("<td>")
  for( let i = 0 ; i < number ; i ++ ) {
    print("&nbsp");
  }
  print("</td>")
}
</script>
<body background='https://i.pinimg.com/originals/8f/4a/df/8f4adf83f77fd739525fbddde4e464e2.jpg'>
<?php

session_start();
$myvars = get_defined_vars();

ksort( $myvars );

echo "<table>";
foreach ($myvars as $k => $v) {
  ksort( $myvars[$k] );

  echo "<tr><td>$k:</td></tr>";
  foreach ($myvars[$k] as $k => $v) {
    echo "<tr><td></td><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(2)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
  }
}

echo "</table>";
echo "<br>";
echo "<hr>";
echo "<br>";
//This is the section to test in

$clientid = $_SESSION['clientid'];
$secret = $_SESSION['secret'];
$token = $_SESSION['token'];
$url = $_SESSION['url'];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$clientid:$secret");
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

$result = curl_exec($ch);

curl_close($ch);

$result = json_decode( $result, TRUE );

//End testing
echo "<hr>";
?>
