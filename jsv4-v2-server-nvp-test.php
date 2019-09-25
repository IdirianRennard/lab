<?php
include 'include.php';

if ( $_POST['intent'] === 'subscription' ) {
  
} else {
  $create_url   = 'jsv4/v2-server-nvp-setec.php';
  $execute_url  = 'jsv4/v2-server-nvp-doec.php';
  $_SESSION['vault'] = 'false';
}

foreach( $_POST as $k => $v ) {
  $_SESSION["$k"] = $v;
} 

$ip = $_SERVER['REMOTE_ADDR'];

/*$append = [
  'client'  =>  $_POST['client'],
  'intent'  =>  $_SESSION['intent'],
  'commit'  =>  'true',
  'vault'   =>  $_SESSION['vault'],
];*/

$cred_append = [
  'user'    =>  $_POST[ 'USER' ],
  'pwd'     =>  $_POST[ 'PWD' ],
  'sig'     =>  $_POST[ 'SIG' ],
  'amt'     =>  $_POST[ 'amount' ],
  'ip'      =>  $ip,
  'cur'     =>  $_POST[ 'CURRENCY' ],
  'env'     =>  $_POST[ 'enviroment' ],
  'return'  =>  "$return_file_path/test?return=true",
  'cancel'  =>  "$return_file_path/test?cancel=true",
];

if ( $_POST[ 'intent'] == 'capture' ) {
  $cred_append['action'] = 'sale';
} else {
  $cred_append['action'] = 'authorization';
}

//ksort( $append );

ksort( $cred_append );

//$append = urldecode( http_build_query( $append ) );

$cred_append = base64_encode( urldecode( http_build_query( $cred_append ) ) );
console ( $cred_append );

$url = "https://www.paypal.com/sdk/js?client-id=" . $_POST[ 'client' ];
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
      let CREATE_PAYMENT_URL = '<?php echo "$create_url/?dt=$cred_append"; ?>';
      

      return fetch( CREATE_PAYMENT_URL ).then( function (res) {
        return res.json();
      } ).then( function (data) {
        console.log( data );
        return data.id;
      } );
    }, 

    onApprove: function(data) {
      console.log( data );
      let EXECUTE_URL = '<?php echo "$execute_url/?dt=$cred_append&orderID="; ?>' + data.orderID + "&payerID=" + data.payerID;
      console.log( 'EXECUTE URL: ' + EXECUTE_URL )
      
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
<div id='trx_info'>
</div>
