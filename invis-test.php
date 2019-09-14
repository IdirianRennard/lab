<?php

include 'include.php';

$enviroment = $_POST['enviroment'];
unset ( $_POST['enviroment'] );

if( $enviroment == 'live') {
    $endpoint = 'https://payflowpro.paypal.com/';
    $page = 'https://payflowlink.paypal.com/';
    
  } else {
    $endpoint = 'https://pilot-payflowpro.paypal.com';
    $page = 'https://pilot-payflowlink.paypal.com';    
  }
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$secure_token_id = '';

for ($i = 0 ; $i < 36 ; $i++) {
  $secure_token_id .= $characters[mt_rand(0, strlen($characters) - 1)];
}

$data = [ 
    'SILENTTRAN' => 'TRUE',
    'CREATESECURETOKEN' => 'Y',
    'SECURETOKENID' => $secure_token_id,
    'RETURNURL' => $return_file_path . 'invis-return.php?m=return',
    'ERRORURL' => $return_file_path . 'test.php?m=error',
    'CANCELURL' => $return_file_path . 'test.php?m=cancel',
];

for ( $i = 1 ; $i < 11 ; $i++ ) {
    $data["USER$i"] = "This is a test of USER$i";
}

foreach( $_POST as $k => $v ) {
    $data["$k"] = $v;
}

ksort( $data );

$myvars = urldecode( http_build_query( $data ) );

$ch = curl_init( $endpoint );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$resp = curl_exec( $ch );

$resp_str = $resp;

parse_str( $resp, $resp );

$pp_secure_token = $resp['SECURETOKEN'];
$pp_secure_token_id = $resp['SECURETOKENID'];

$iframe_url = "$page?SECURETOKEN=$pp_secure_token&SECURETOKENID=$pp_secure_token_id";
//$iframe_url = $return_file_path . "test.php?m=post";

?>
<table class='table'>
    <tr>
        <td colspan="42" align='left'>ENDPOINT:</td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td colspan="42" align='left'><?php echo $endpoint; ?></td>
    </tr>
    <tr><td><br></td></tr>
    <tr><td><br></td></tr>
    <tr>
        <td colspan="42" align='left'>INPUT:</td>
    </tr>
    <tr><td><br></td></tr>
    <tr><td colspan="42" align='left'><?php echo $myvars; ?></td></tr>
    <tr><td><br></td></tr>
    <?php
    foreach ($data as $k => $v) {
        echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
    }
    ?>
    <tr><td><br></td></tr>
    <tr><td><br></td></tr>
    <tr><td colspan="42" align='left'>RESPONSE:</td></tr>
    <tr><td><br></td></tr>
    <tr><td colspan="42" align='left'><?php echo $resp_str; ?></td></tr>
    <tr><td><br></td></tr>
    <?php
    foreach ($resp as $k => $v) {
      echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
    }
    ?>
    <tr><td><br></td></tr>
    <tr><td><br></td></tr>
    <tr>
        <td colspan="42" align='left'>POST URL:</td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td colspan="42" align='left'><?php echo $iframe_url; ?></td>
    </tr>
    <?php 
    if ( $resp['RESULT'] == 0 ) {
        echo "<tr><td colspan='42'><br><hr></td></tr>";
        echo "<tr><td colspan='840'>";
        echo "<form action='$iframe_url' method='post' target='_blank'><table>";
        echo "<tr>
            <td>CC Number:</td>
            <script>spaces(4)</script>
            <td><input type='text' name='ACCT' placeholder='  4111111111111111'></td>
            <script>spaces(4)</script>
            <td><input type='text' name='EXPDATE' placeholder='  EXP Date (MMYY)'></td>
            </tr>";
        echo "<tr>
            <td>Name:</td>
            <script>spaces(4)</script>
            <td><input type='text' name='BILLTOFIRSTNAME' placeholder='  First Name'></td>
            <script>spaces(4)</script>
            <td><input type='text' name='BILLTOLASTNAME' placeholder='  Last Name'></td>
            </tr>";

        echo "<tr>
            <td>Street Name:</td>
            <td></td>
            <td><input type='text' name='BILLTOSTREET' placeholder='  Billing Street'></td>
            <td></td>
            <td class='shipping'><input type='text' name='STREET' placeholder='  Shipping Street'></td>
            </tr>";
        
        echo "<tr>
            <td>City Name:</td>
            <td></td>
            <td><input type='text' name='BILLTOCITY' placeholder='  Billing City'></td>
            <td></td>
            <td class='shipping'><input type='text' name='CITY' placeholder='  Shipping City'></td>
            </tr>";

        echo "<tr>
            <td>State:</td>
            <td></td>
            <td><input type='text' name='BILLTOSTATE' placeholder='  Billing State'></td>
            <td></td>
            <td class='shipping'><input type='text' name='STATE' placeholder='  Shipping State'></td>
            </tr>";

        echo "<tr>
            <td>Postal Code:</td>
            <td></td>
            <td><input type='text' name='BILLTIP' placeholder='  Billing Postal Code'></td>
            <td></td>
            <td class='shipping'><input type='text' name='ZIP' placeholder='  Shipping Postal Code'></td>
            </tr></table>";

            echo "<tr><td colspan='42'><hr></td></tr>";
            echo "<tr><td><input type='hidden' name='COMMENT1' value='Idirian Test'>";
            echo "<input type='hidden' name='VERBOSITY' value='high'></td>";
            echo "<input type='hidden' name='TENDER' value='C'>";
            echo "<input type='hidden' name='DISABLERECEIPT' value='true'>";
            echo "<input type='hidden' name='CURRENCY' value='USD'>";
            echo "<input type='hidden' name='COMMENT2' value='This is using Transparent Redirect'></td></tr>";
            echo "<tr><td colspan='42' align='right'><input type='submit' class='button' value='submit'></td></tr>";
            echo "</form>";
        }
    ?>
</table>
