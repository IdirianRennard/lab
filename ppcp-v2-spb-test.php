<?php
include 'include.php';

$client         =   $_POST[ 'client' ];
$secret         =   $_POST[ 'secret' ];
$enviroment     =   $_POST[ 'enviroment' ];
$merchant       =   $_POST[ 'merchant_id' ];
$amount         =   $_POST[ 'amount' ];
$currency       =   $_POST[ 'CURRENCY' ];
$intent         =   $_POST[ 'intent' ];
$create_url     =   'jsv4/ppcp-server-cre.php';
$execute_url    =   'jsv4/ppcp-server-exe.php';

$vault          =   'false';

$src_append = [
    'client-id'     =>  $client,
    'intent'        =>  $intent,
    'commit'        =>  'true',
    'vault'         =>  $vault,
    'merchant-id'   =>  $merchant,
];
  
asort( $src_append );
  
$src_append = urldecode( http_build_query( $src_append ) );
  
$src_url = "https://www.paypal.com/sdk/js?$src_append&currency=$currency";

$ord_append = [
    'c'     =>  $client,
    's'     =>  $secret,
    'e'     =>  $enviroment,
    'a'     =>  $amount,
    'cur'   =>  $currency,
    'm'     =>  $merchant,
    'i'     =>  $intent,
];

asort( $ord_append );

$ord_append = base64_encode( http_build_query( $ord_append ) );

$create_url .= "/?dt=$ord_append";

$execute_url .= "/?dt=$ord_append&orderID=";
?>
<script src='<?php echo $src_url; ?>'></script>
  
<table class='table'>
  <tr>
    <td><div id="paypal-button"></div></td>
  </tr>
</table>
  
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
    paypal.Buttons( {
      style: {
          layout: '<?php echo $_POST['layout']; ?>',
          color:  '<?php echo $_POST['color']; ?>',
          shape:  '<?php echo $_POST['shape']; ?>',
          label:  '<?php echo $_POST['label']; ?>',
          height: <?php echo (int)$_POST['size']; ?>
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
