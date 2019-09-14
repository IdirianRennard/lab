<?php
include 'include.php';

$string = $_POST['get_url'];
unset( $_POST['get_url']);

$string = base64_decode( $string );

?>
<table class='table'>
    <tr>
        <td><?php echo $string; ?></td>
    </tr>
</table>
