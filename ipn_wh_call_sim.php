<?php
include 'include.php';

$method = [
    'post'  =>  'POST',
    'get'   =>  'GET',
]
?>
<form action='ipn_wh_call_sim-test.php' method='post'>
    <table class='table'>
        <tr>
            <td>ENDPOINT:</td>
            <script>spaces(4)</script>
            <td><input type='text' class='drop' name='endpoint' placeholder='  https://www.paypal.com'></td>
        </tr>
        <tr><td><br></td></tr>
        <tr>
            <td>DATA:</td>
            <td></td>
            <td><textarea name='data' cols="42" rows="7">  Enter the data you wish to send</textarea></td>
        </tr>
        <tr><td colspan='42'><hr></td></tr>
        <tr>
            <td colspan='42' align='right'><input type='submit' class='button' value='submit'></td>
        </tr>
    </table>
</form>