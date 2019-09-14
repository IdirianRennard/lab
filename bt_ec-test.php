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
?>
<div id='render'></div>

<script src="https://www.paypalobjects.com/api/checkout.js" data-version-4></script>
<script src="https://js.braintreegateway.com/web/3.39.0/js/client.min.js"></script>
<script src="https://js.braintreegateway.com/web/3.39.0/js/paypal-checkout.min.js"></script>
<script src="https://js.braintreegateway.com/web/dropin/1.14.1/js/dropin.min.js"></script>

<div id="dropin-container"></div>
<button id="submit-button">Request payment method</button>
<script>
  var button = document.querySelector( '#submit-button' );

  braintree.dropin.create( {
    authorization: 'CLIENT_AUTHORIZATION',
    container: '#render'
    }, function ( createErr, instance ) {
      button.addEventListener('click', function () {
        instance.requestPaymentMethod( function ( requestPaymentMethodErr, payload) {
          // Submit payload.nonce to your server
        } );
      } );
    } );
</script>

<?php
//End testing
echo "<hr>";
?>
<a href='index.php'><input class='button' type='submit' value='Return Home'></a>
</body>
