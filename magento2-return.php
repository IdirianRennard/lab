<?php
include 'include.php';

parse_str( urldecode( base64_decode( $_GET['dt'] ) ), $DT );

$enviroment = $DT['enviroment'];

if( $enviroment == 'live') {
    $endpoint = 'https://payflowpro.paypal.com/';
    $page = 'https://payflowlink.paypal.com/';
    
} else {
    $endpoint = 'https://pilot-payflowpro.paypal.com';
    $page = 'https://pilot-payflowlink.paypal.com';
    
}

$data = [
    'PARTNER'           =>  $DT['PARTNER'],
    'VENDOR'            =>  $DT['VENDOR'],
    'USER'              =>  $DT['USER'],
    'PWD'               =>  $DT['PWD'],
    'ORIGID'            =>  $_POST['PNREF'],
    'AMT'               =>  $DT['AMT'],
    'CURRENCY'          =>  $DT['CURRENCY'],
    'TRXTYPE'           =>  $DT['TRXTYPE'],
    'BILLTOCITY'        =>  $_POST['BILLTOCITY'],
    'BILLTOCOUNTRY'     =>  $_POST['BILLTOCOUNTRY' ],
    'BILLTOFIRSTNAME'   =>  $_POST['BILLTOFIRSTNAME'],
    'BILLTOLASTNAME'    =>  $_POST['BILLTOLASTNAME'],
    'BILLTONAME'        =>  $_POST['BILLTONAME'],
    'BILLTOSTATE'       =>  $_POST['BILLTOSTATE'],
    'BILLTOSTREET'      =>  $_POST['BILLTOSTREET'],
    'BILLTOZIP'         =>  $_POST['BILLTOZIP'],
    'FIRSTNAME'         =>  $_POST['FIRSTNAME'],
    'LASTNAME'          =>  $_POST['LASTNAME'],
    'CITY'              =>  $_POST['CITY'],
    'COUNTRY'           =>  $_POST['COUNTRY'],
    'STATE'             =>  $_POST['STATE'],
    'ADDRESS'           =>  $_POST['ADDRESS'],
    'ZIP'               =>  $_POST['ZIP'],
    'TENDER'            =>  'C',
];

ksort( $data );

$myvars = urldecode( http_build_query( $data ) );

$resp = nvp_api( $endpoint, $myvars );

parse_str( $resp, $resp_arr );

ksort( $resp_arr );

$void_data = [ 
    'PARTNER'   =>  $DT['PARTNER'],
    'VENDOR'    =>  $DT['VENDOR'],
    'USER'      =>  $DT['USER'],
    'PWD'       =>  $DT['PWD'],
    'ORIGID'    =>  $_POST['PNREF'],
    'TRXTYPE'   =>  'V',
];

$void_vars = urldecode( http_build_query( $void_data ) );

$void_resp = nvp_api( $endpoint, $void_vars );

parse_str( $void_resp, $void_resp_arr );

ksort( $void_resp_arr );

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
    <tr><td colspan="42" align='left'><?php echo $resp; ?></td></tr>
    <tr><td><br></td></tr>
    <?php
    foreach ($resp_arr as $k => $v) {
      echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
    }
    ?>
    <tr><td><br></td></tr>
    <tr><td><br></td></tr>
    <tr>
        <td colspan="42" align='left'>VOID CALL:</td>
    </tr>
    <tr><td><br></td></tr>
    <tr><td colspan="42" align='left'><?php echo $void_vars; ?></td></tr>
    <tr><td><br></td></tr>
    <?php
    foreach ($void_data as $k => $v) {
        echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
    }
    ?>
    <tr><td><br></td></tr>
    <tr><td><br></td></tr>
    <tr><td colspan="42" align='left'>VOID RESPONSE:</td></tr>
    <tr><td><br></td></tr>
    <tr><td colspan="42" align='left'><?php echo $void_resp; ?></td></tr>
    <tr><td><br></td></tr>
    <?php
    foreach ($void_resp_arr as $k => $v) {
      echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
    }
    ?>
</table>