<?php
include 'include.php';

if ( $_GET['rv'] === 'return' ) {

    $rv = 'SUCCESS';

    parse_str( urldecode( base64_decode( $_GET['dt'] ) ) , $DT );

    $client = $DT['client'];
    $secret = $DT['secret'];
    $enviroment = $DT['enviroment'] ; 
    $orderId = $_GET[ 'token' ];
    $action = strtolower( $_GET['a'] );

    if ( $enviroment == 'production' ) {
        $url = "https://api.paypal.com/v2/checkout/orders/$orderId/$action";
    } else {
        $url = "https://api.sandbox.paypal.com/v2/checkout/orders/$orderId/$action";
    }

    $token = rest_oauth( $client, $secret, $enviroment );

    $resp = rest_api( $url, NULL, $token);

    $res = json_decode( $resp );

    session_destroy();
} else {
    $rv = 'CANCELLED';
}
?>

<table class='table'>
    <tr>
        <td>Return Value:</td>
        <script>spaces(4)</script>
        <td><?php echo $rv; ?></td>
    </tr>
    <?php 
    if ( $rv === 'SUCCESS' ) {
        echo "<tr><td><br></td></tr>
        <tr>
            <td>Endpoint:</td>
            <td></td>
            <td>$url</td>
        </tr>
        <tr><td><br></td></tr>
        <tr>
            <td>Response:</td>
            <td></td>
            <td>$resp</td>
        </tr>";
        if ( $action === 'authorize' ) {

            echo "<script>console.log( '" . $res->purchase_units[0]->payments->authorizations[0]->links[1]->href . "' )</script>";

            $dt = [
                'client'        =>  $client,
                'secret'        =>  $secret,
                'enviroment'    =>  $enviroment,
                'orderId'       =>  $_GET[ 'token' ],
                'cap_url'       =>  $res->purchase_units[0]->payments->authorizations[0]->links[1]->href,
                'currency'      =>  $res->purchase_units[0]->payments->authorizations[0]->amount->currency_code,
                'amount'        =>  $res->purchase_units[0]->payments->authorizations[0]->amount->value,
            ];
        
            asort( $dt );
            
            $dt = base64_encode ( http_build_query( $dt ) );

            echo "<tr><td colspan='42><hr></td></tr>";
            echo "<tr><td colspan='42' align='right'><a href='v2-orders-capture.php?dt=$dt' target='_blank'><input type='submit' class='button' value='go to capture'></a></td></tr>";
        }
    }
?>    

