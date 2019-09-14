<?php
include 'include.php';

?>
<form action='fw-redirect-test.php' method='post' target='_blank'>
    <table class='table'>
        <tr>
            <td>Where would you like to go?</td>
            <script>spaces(4)</script>
            <td><input type='test' class='drop' name='url' placeholder='  www.paypal.com'></td>
        </tr>
        <tr><td colspan='42'><hr></td></tr>
        <td><td colspan='42' align='right'><input type='submit' class='button' value='lets go'></td></tr>
    </table>
</form>
