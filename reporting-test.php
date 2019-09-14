<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/ui_mod.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/jquery-ui-git.css" >
<script  src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="js/scripts.js"></script>
<body id='test'>
<?php

session_start();
$myvars = get_defined_vars();

ksort( $myvars );

echo "<table>";
foreach ($myvars as $k => $v) {
  ksort( $myvars[$k] );

  echo "<tr><td>$k:</td></tr>";
  foreach ($myvars[$k] as $k => $v) {
    echo "<tr><td></td><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(2)</script><td>=></td><script>spaces(4)</script><td>";
    print_r( $v );
    echo "</td></tr>";
  }
}

echo "</table>";
echo "<br>";
echo "<hr>";
echo "<br>";
//This is the section to test in

$partner = $_POST['PARTNER'];
$vendor = $_POST['VENDOR'];
$user = $_POST['USER'];
$password = $_POST['PWD'];

$date = date ( 'Y-m-d', strtotime( $_POST['date'] ) );

if ( $_POST['enviroment'] == 'sandbox' ) {
  $url = 'https://payments-reports.paypal.com/test-reportingengine';
} else {
  $url = 'https://payments-reports.paypal.com/reportingengine';
}


$input_xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?> \n
<reportingEngineRequest>
  <authRequest>
    <user>$user</user>
    <vendor>$vendor</vendor>
    <partner>$partner</partner>
    <password>$password</password>
   </authRequest>
   <getMetaDataRequest>
    <reportId>RE0000000003019605547</reportId>
   </getMetaDataRequest>
</reportingEngineRequest>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);

$result = curl_exec( $ch );
curl_close( $ch );

echo "<textarea cols='72' rows='10' id='copy'>$result</textarea>";

//End testing
echo "<hr>";
?>
<a href='index.php'><input class='button' type='submit' value='Return Home'></a>
</body>
