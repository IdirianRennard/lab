<?php

include 'include.php';

$append = $_POST;

ksort( $append );

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
$secure_token_id = 'RENNARD-';

for ($i = 0 ; $i < 36 ; $i++) {
  $secure_token_id .= $characters[mt_rand(0, strlen($characters) - 1)];
}

unset( $_POST['AMT'] );
unset( $_POST['TRXTYPE'] );

$append = base64_encode( http_build_query( $append ) );

$data = [ 
    'AMT' => '0.00',
    'SILENTTRAN' => 'TRUE',
    'CREATESECURETOKEN' => 'Y',
    'SECURETOKENID' => $secure_token_id,
    'RETURNURL' => $return_file_path . "magento2-return.php?dt=$append",
    'ERRORURL' => $return_file_path . "magento2-error.php?dt=$append",
    'TRXTYPE' => 'A',
];

foreach( $_POST as $k => $v ) {
    $data["$k"] = $v;
}

ksort( $data );

$myvars = urldecode( http_build_query( $data ) );

$resp = nvp_api( $endpoint, $myvars );

$resp_str = $resp;

parse_str( $resp, $resp );

$pp_secure_token = $resp['SECURETOKEN'];
$pp_secure_token_id = $resp['SECURETOKENID'];

$iframe_url = "$page?SECURETOKEN=$pp_secure_token&SECURETOKENID=$pp_secure_token_id";

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
    <div id=''
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
            <script>spaces(4)</script>
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
            <td><input type='text' name='BILLTOZIP' placeholder='  Billing Postal Code'></td>
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
