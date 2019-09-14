<?php
include 'include.php';

if( $_POST['enviroment'] == NULL ) {
  $env = 'sandbox';
} else {
  $env = $_POST['enviroment'];
}
unset( $_POST['enviroment'] );

$client = $_POST['client'];
unset( $_POST['client'] );

$amount = $_POST['amount'];
unset( $_POST['amount'] );

?>
<table class='table'>
  <tr><script>spaces(4)</script><script>spaces(4)</script><script>spaces(4)</script></tr>
  <tr>
    <td colspan='42' align='center'>
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <script src="https://www.paypalobjects.com/api/checkout.min.js"></script>
        <div id="paypal-button-container"></div>
        <script>
          paypal.Button.render({
            env: '<?php echo $env;?>', // sandbox | production
            // PayPal Client IDs - replace with your own
            // Create a PayPal app: https://developer.paypal.com/developer/applications/create
            style: {
              size: 'small',
              color: 'blue',
              shape: 'pill',
            },

            client: {
              sandbox:    '<?php echo $client; ?>',
              production: '<?php echo $client; ?>'
            },

            // Show the buyer a 'Pay Now' button in the checkout flow
            commit: true,

            // payment() is called when the button is clicked
            payment: function(data, actions) {

              // Make a call to the REST api to create the payment
              return actions.payment.create({
                payment: {
                  transactions: [
                    {
                      amount: { total: '<?php echo $amount ?>', currency: 'USD' }
                    }
                  ]
                }
              } );
            },

            // onAuthorize() is called when the buyer approves the payment
            onAuthorize: function(data, actions) {

              // Make a call to the REST api to execute the payment
              return actions.payment.execute().then(function() {
                window.alert('Payment Complete!');
              });
            }
          }, '#paypal-button-container');

      </script>
    </td>
  </tr>
  <tr><br></tr>
</table>
