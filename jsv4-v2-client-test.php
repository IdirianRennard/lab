<?php
include 'include.php';

$clientid = $_POST[ 'client' ];

$tag_url = 'https://www.paypal.com/sdk/js?client-id=' . $clientid;

?>
<head>
    <script src='<?php echo $tag_url; ?>'></script>
</head>

<table class='table'>
  <tr><td id="paypal-button-container"></td></tr>
</table>

<script>
  paypal.Buttons({
    style: {
        layout: '<?php echo $_POST['layout']; ?>',
        color: '<?php echo $_POST['color']; ?>',
        shape: '<?php echo $_POST['shape']; ?>',
        label: '<?php echo $_POST['label']; ?>',
        height: <?php echo (int)$_POST['size']; ?>
    },
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: '<?php echo $_POST['amount']; ?>'
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      return actions.order.capture().then(function(details) {
        console.log( details );
        return fetch( '/paypal-transaction-complete', {
          method: 'post',
            body: JSON.stringify({
                orderID: data.orderID
            })
        }); 
      });
    }
  }).render('#paypal-button-container');
</script>