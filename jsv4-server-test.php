<?php
include 'include.php';

$_SESSION = $_POST;

switch ( $_POST['intent'] ) {
  case 'subscription':
    $cre_file = 'jsv4-server-billing-cre.php';
    $exe_file = 'jsv4-server-billing-exe.php';
    break;

  default:
    $cre_file = 'jsv4-server-cre.php';
    $exe_file = 'jsv4-server-exe.php';
    break;
}

$allowed = 'paypal.FUNDING.CARD';

if ( isset( $_POST['PPC'] ) ) {
  $allowed .= ', paypal.FUNDING.CREDIT';
}
?>

<table class='table'><tr><td>
<div id="paypal-button"></div>
<script type="text/javascript" src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>

let cre_file = '<?php echo $cre_file; ?>';
let exe_file = '<?php echo $exe_file; ?>';

paypal.Button.render( {
  env: '<?php echo $_POST['enviroment']; ?>',
  style: {
    label: '<?php echo $_POST['label']; ?>',
    size: '<?php echo $_POST['size']; ?>',
    color: '<?php echo $_POST['color']; ?>',
    shape: '<?php echo $_POST['shape']; ?>',
    <?php if ( $_POST['layout'] !== 'vertical' && isset( $_POST['tagline'] ) ) {
      echo "tagline: '" . $_POST['tagline'] . "',";
    }
    ?>
    layout: '<?php echo $_POST['layout']; ?>'
    <?php if ( $_POST['layout'] !== 'vertical') {
      echo ", fundingicons: '" . $_POST['icons'] . "'";
    }
    ?>
  },
  funding: {
    allowed: [<?php echo $allowed; ?>]
  },
  // Set up a payment
  payment: function(data, actions) {
    return actions.request.post( 'jsv4/' + cre_file )
      .then( function( res ) {
        console.log ( res );
        return res.id;
      } )
  },
  // Execute the payment
  onAuthorize: function(data, actions) {
    console.log ( data );
    let token = data.paymentToken;

    return actions.request.post( 'jsv4/' + exe_file + '?&token=' + token, {
      paymentID: data.paymentID,
      payerID: data.payerID
    }).then( function ( e ) {

      console.log( e );
      let message = "<table class='table'>";
      message += "<tr><td>RESPONSE:</td>";
      message += "<td>&nbsp&nbsp&nbsp&nbsp</td>";
      message += "<td>" + JSON.stringify(e) + "</td></tr></table>";

      $('#trx_info').html( message );
    } )
  }
}, '#paypal-button');

</script>
</td></tr></table>
<br><br>
<div id='trx_info'>
</div>
