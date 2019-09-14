<?php
include 'include.php';

$trx_type = [
  'A' => 'Authorization',
  'S' => 'Sale',
];

?>
<form id='direction' action=''  method='POST' target='_blank'>
<table class='table'>
    <tr>
        <td>Vendor:</td>
        <script>spaces(4)</script>
        <td><input type='text' name='LOGIN' value='<?php echo $credentials['PF_VENDOR']; ?>'></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td>Partner:</td>
        <td></td>
        <td><input type='text' name='LOGIN' value='<?php echo $credentials['PF_PARTNER']; ?>'></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td>Enviroment:</td>
        <td></td>
        <td><script>env_dropdown();</script></td>
    </tr>
    <tr><td colspan='42'><hr></td></tr>
    <tr>
        <td colspan='42' align='right'>
        <input type='hidden' name='PARTNER' value='PayPal'>
        <input type='hidden' name='INVOICE' value='HAJ7193'>
        <input type='hidden' name='AMOUNT' value='169.50'>
        <input type='hidden' name='TYPE' value='S'>
        <input type='hidden' name='DESCRIPTION' value='Invoice: 6988'>
        <input type='hidden' name='METHOD' value='CC'>
        <input type='hidden' name='NAME' value='Brad Test'>
        <input type='hidden' name='ADDRESS' value='12321 Port Grace Blvd'>
        <input type='hidden' name='ZIP' value='68128'>
        <input type='hidden' name='CITY' value='LaVista'>
        <input type='hidden' name='COUNTRYCODE' value='US'>
        <input type='hidden' name='EMAIL' value='schweinoconsulting@gmail.com'>
        <input type='submit' class='button' value='SUMBIT'>
    </tr>
</table>
</form>
<script>
$(document).ready( function () { 

    $('#enviroment').on('change', function( e ) {
        if ( e.target.value === 'sandbox' ) {
            $('#direction').attr( "action", 'https://pilot-payflowlink.paypal.com/');
        } 
        
        if ( e.target.value === 'production' ) {
            $('#direction').attr( "action", 'https://payflowlink.paypal.com/');
        } 

    } )
} )
</script>
