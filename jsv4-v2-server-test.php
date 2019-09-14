<?php
include 'include.php';

if ( $_POST['intent'] === 'subscription' ) {
  $create_url = 'jsv4/v2-server-billing-cre.php';
  $execute_url = 'jsv4/v2-server-billing-exe.php?orderID=';
  $_SESSION['intent'] = 'capture';
  $_SESSION['vault'] = 'true';
  unset( $_POST['intent'] );
} else {
  $create_url = 'jsv4/v2-server-cre.php';
  $execute_url = 'jsv4/v2-server-exe.php?orderID=';
  $_SESSION['vault'] = 'false';
}

foreach( $_POST as $k => $v ) {
  $_SESSION["$k"] = $v;
} 

unset( $_POST );

$append = [
  'client-id' => $_SESSION['client'],
  'intent' => $_SESSION['intent'],
  'commit' => 'true',
  'vault' => $_SESSION['vault'],
];

asort( $append );

$append = urldecode( http_build_query( $append ) );

$url = "https://www.paypal.com/sdk/js?$append&currency=" . $_SESSION['CURRENCY'];
?>
<script src='<?php echo $url; ?>'></script>

<table class='table'>
  <tr>
    <td><div id="paypal-button"></div></td>
  </tr>
</table>

<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
  paypal.Buttons( {
    style: {
        layout: '<?php echo $_SESSION['layout']; ?>',
        color:  '<?php echo $_SESSION['color']; ?>',
        shape:  '<?php echo $_SESSION['shape']; ?>',
        label:  '<?php echo $_SESSION['label']; ?>',
        height: <?php echo (int)$_SESSION['size']; ?>
    },

    createOrder: function () {
      let CREATE_PAYMENT_URL = '<?php echo $create_url; ?>';

      return fetch( CREATE_PAYMENT_URL ).then( function (res) {
        return res.json();
      } ).then( function (data) {
        console.log( data );
        return data.id;
      } );
    }, 

    onApprove: function(data) {
      console.log( data );
      let EXECUTE_URL = '<?php echo $execute_url; ?>' + data.orderID;

      return fetch( EXECUTE_URL ).then( function (res) {
        return res.json();
      } ).then( function ( e ) {
        console.log( e );
        let message = "<table class='table'>";
        message += "<tr><td>RESPONSE:</td>";
        message += "<td>&nbsp&nbsp&nbsp&nbsp</td>";
        message += "<td>" + JSON.stringify( e ) + "</td></tr></table>";

        $('#trx_info').html( message );
      } );
    } 
  } ).render( '#paypal-button' );
</script>
<br><br>
<div id='trx_info'>
</div>
