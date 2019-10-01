<div id="paypal-button-container"></div>
<script src="https://www.paypal.com/sdk/js?client-id=ATjr95vYYL_NJNcE1UJVfyVCypGA0U6ngu8mNTOLGU89fQ_XtII8DTF7o3HAttd5jgnihU6_Y93W_ZXm&currency=USD"></script>
<script>
    paypal.Buttons({
        style: {
            shape: 'rect',
            color: 'gold',
            layout: 'vertical',
            label: 'paypal',
            
        },
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '100'
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                alert('Transaction completed by ' + details.payer.name.given_name + '!');
            });
        }
    }).render('#paypal-button-container');
</script>