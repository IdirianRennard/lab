<?php
include 'include.php';

?>
<table class='table'>
    <form id='token'>
        <tr>
            <td>Client ID:</td>
            <script>spaces(4)</script>
            <td colspan='42'><textarea name='ClientID'cols='72' rows='3'><?php echo $credentials['REST_CLIENT']; ?></textarea></td>
        </tr>
        <tr><td><br></td></tr>
        <tr>
            <td>Secret:</td>
            <td></td>
            <td colspan='42'><textarea name='Secret' cols='72' rows='3'><?php echo $credentials['REST_SECRET']; ?></textarea></td>
        </tr>
        <tr><td><br></td></tr>
        <tr>
            <td>Enviroment</td>
            <td></td>
            <td><script>env_dropdown()</script>
        </tr>
        <tr><td><br></td></tr>
        <tr>
            <td><input type='submit' class='button' value='SUBMIT'></td>
    </form>
    <tr><td colspan='42'><hr></td></tr>

</table>

<script>
$(document).ready( function () { }
    $('#token').submit( function(e) {
        e.preventDefault();
    } )
)
</script>
