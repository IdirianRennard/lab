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

$env = $_POST['enviroment'];
unset ( $_POST['enviroment'] );

if( $env == 'live') {
  $endpoint = 'https://payflowpro.paypal.com/';
  $page = 'https://payflowlink.paypal.com/';
} else {
  $endpoint = 'https://pilot-payflowpro.paypal.com/';
  $page = 'https://pilot-payflowlink.paypal.com/';
}

$login = 'jlindberry';
$partner = 'PayPal';
$amount = $_POST['AMT'];


echo "<form class='submitArea'  action='$page'  method='POST' target='_blank'>";
echo "<input type='hidden' name='LOGIN' value='$login'>";
echo "<input type='hidden' name='PARTNER' value='$partner'>";
echo "<input type='hidden' name='INVOICE' value='HAJ7193'>";
echo "<input type='hidden' name='AMOUNT' value='$amount'>";
echo "<input type='hidden' name='TYPE' value='S'>";
echo "<input type='hidden' name='DESCRIPTION' value='Invoice: 6988'>";
echo "<input type='hidden' name='METHOD' value='CC'>";
echo "<input type='hidden' name='NAME' value='Brad Test'>";
echo "<input type='hidden' name='ADDRESS' value='12321 Port Grace Blvd'>";
echo "<input type='hidden' name='ZIP' value='68128'>";
echo "<input type='hidden' name='CITY' value='LaVista'>";
echo "<input type='hidden' name='COUNTRYCODE' value='US'>";
echo "<input type='hidden' name='EMAIL' value='schweinoconsulting@gmail.com'>";
echo "<input type='submit' name='Buy' value='Continue to payment' class='button button--brand'>";
echo "</form>";

//End testing
echo "<hr>";
?>
<a href='index.php'><input class='button' type='submit' value='Return Home'></a>
</body>
