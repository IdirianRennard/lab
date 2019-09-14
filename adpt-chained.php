<?php
include 'include.php';

$ip = $_SERVER['REMOTE_ADDR'];

$actionType = [
    'PAY'       => 'Pay',
    'CREATE'    =>  'Create',
];

asort( $actionType );

$feePayer = [
    'EACHRECEIVER'      =>  'Each Receiver',
    'PRIMARYRECEIVER'   =>  'Primary Receiver',
];

asort( $feePayer );

?>
<form action='adpt-chained-test.php' method='post'>
    <table class='table'>
        <tr>
            <td>API Username:</td>
            <script>spaces(4)</script>
            <td><input type='text' class='drop' name='USER' value='<?php echo $credentials['API_USER']; ?>'></td>
        </tr>
        <tr><td><br></td></tr>
        <tr>
            <td>API Password:</td>
            <td></td>
            <td><input type='text' class='drop' name='PWD' value='<?php echo $credentials['API_PWD']; ?>'></td>
        </tr>
        <tr><td><br></td></tr>
        <tr>
            <td>API Signature:</td>
            <td></td>
            <td><input type='text' class='drop' name='SIGNATURE' value='<?php echo $credentials['API_SIG']; ?>'></td>
        </tr>
        <tr><td><br></td></tr>
        <tr>
            <td>APP-ID:</td>
            <td></td>
            <td><input type='text' class='drop' name='APP-ID' value='APP-80W284485P519543T'></td>
        </tr>
        <tr><td><br></td></tr>
        <tr>
            <td>Action Type:</td>
            <td></td>
            <td>
                <select name='actionType' class='drop' required>
                    <option selected disabled>Select Action Type</option>
                    <?php
                    foreach( $actionType as $k => $v ) {
                        echo "<option value='$k'>$v</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr><td><br></td></tr>
        <tr>
            <td>Recipient Number:</td>
            <td></td>
            <td><input type='number' id='number' name="q" min="1" max='3' value='0' required></td>
        </tr>
        <tr>
            <td id='recipients' colspan='900' align='center'></td>
        </tr>
        <tr id='remove'><td><br></td></tr>
        <tr>
            <td>Fee Payer:</td>
            <td></td>
            <td>
                <select name='feePayer' class='drop' required>
                    <option selected disabled>Select Action Type</option>
                    <?php
                    foreach( $feePayer as $k => $v ) {
                        echo "<option value='$k'>$v</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr><td><br></td></tr>
        <tr>
            <td>Enviroment:</td>
            <td></td>
            <td>
                <select id='enviroment' name="enviroment" class='drop' required>
                    <option selected disabled>Select Enviroment</option>
                    <option value="live">Live</option>
                    <option value="sandbox">Sandbox</option>
                </select>
            </td>
        </tr>
        <tr><td><br></td></tr>
        <tr>
            <td>Currency:</td>
            <td></td>
            <td><?php echo currency_dropdown(); ?></td>
        </tr>
        <tr><td colspan='42'><hr></td></tr>
        <tr>
            <td colspan='42' align='right'>
                <input type='hidden' name='IPADDRESS' value='<?php echo $ip; ?>'>
                <input type='submit' class='button' value='submit'>
            </td>
        </tr>
    </table>
</form>
<script>
$(document).ready( function () {
    $('#number').on('change', function(e) {
        let message = '<td colspan="3" align="center"><br>';

        for ( var i = 0 ; i < e.target.value ; i++ ) {
            message += "<input type='hidden' name='RECEIVER" + i + "_PAYMENTACTION' value='Sale'>";
            message += "<input type='hidden' name='RECEIVER" + i + "_CURRENCYCODE' value='USD'>";
            message += "<input type='hidden' name='RECEIVER" + i + "_PAYMENTREQUESTID' value='HR-0" + ( i + 1 ) + "'>";
            message += "<input type='text' placeholder='  Recipient " + ( i + 1 ) + " Email' name='RECEIVER" + i + "_ACCOUNTID' required>&nbsp&nbsp&nbsp&nbsp&nbsp";
            message += "<input type='text' placeholder='  Amount' name='RECEIVER" + i + "_AMT' required><br><br>";
        }

        message += '</td>'

        $('#recipients').html( message );

        $('#AMT').val( e.target.value );

        let blank = '';
        $('#remove').html( blank );
    } );
} );
</script>
