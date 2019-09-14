<?php
include 'include.php';

if ( isset( $_POST['tagline'] ) ) {
  $tagline = 'true';
} else {
  $tagline = 'false';
}

if ( isset( $_POST['PPC'] ) ) {
  $allowed = 'paypal.FUNDING.CREDIT';
}
?>

<table class='table'><tr><td>
<div id="paypal-button"></div>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
  paypal.Button.render({
    // Configure environment
    env: '<?php echo $_POST['enviroment']; ?>',
    client: {
      sandbox: '<?php echo $_POST['client']; ?>',
      production: '<?php echo $_POST['client']; ?>'
    },
    // Customize button (optional)
    locale: 'en_US',
    style: {
      label: '<?php echo $_POST['label']; ?>',
      size: '<?php echo $_POST['size']; ?>',
      color: '<?php echo $_POST['color']; ?>',
      shape: '<?php echo $_POST['shape']; ?>',
      tagline: <?php echo $tagline; ?>,
      layout: '<?php echo $_POST['layout']; ?>'
    },
    funding: {
      allowed: [<?php echo $allowed; ?>]
    },

    // Enable Pay Now checkout flow (optional)
    commit: true,

    // Set up a payment
    payment: function(data, actions) {
      return actions.payment.create({
        intent: '<?php echo $_POST['intent']; ?>',
        transactions: [{
          amount: {
            total: '<?php echo $_POST['amount']; ?>',
            currency: '<?php echo $_POST['currency']; ?>'
          }
        }]
      });
    },
    // Execute the payment
    onAuthorize: function(data, actions) {
      return actions.payment.execute().then( function(e) {
        // Show a confirmation message to the buyer

        let message = "<table class='table'>";
        message += "<tr><td>RESPONSE:<br><form action='json_view-test.php' method='post' target='_blank'>";
        message += "<input type='hidden' name='json' value='" + JSON.stringify(e) + "'>";
        message += "<input type='submit' class='button' value='View JSON'></form></td>";
        message += "<td>&nbsp&nbsp&nbsp&nbsp</td>";
        message += "<td>" + JSON.stringify(e) + "</td></tr></table>";

        $('#trx_info').html( message );
      } );
    }
  }, '#paypal-button');

</script>
</td></tr></table>
<br><br>
<div id='trx_info'>
</div>
