<?php
include 'include.php';

//parse_str( urldecode( base64_decode( $_GET['dt'] ) ), $DT );

asort( $_POST );

$post_string = urldecode( http_build_query( $_POST ) );
?>
<table class='table'>
  <tr>
    <td>POST DATA:</td>
    <script>spaces(4)</script>
    <td colspan='42'><?php echo $post_string; ?></td>
  </tr>
  <tr><td><br><br></td></tr>
  <?php
    foreach ($_POST as $k => $v) {
        echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
    }
  ?>
</table>
<script>
$(document).ready( function () {
  $('#warning').append( "<center><table class='err'><tr><td><b><u>ERROR:</b></u> An error has ocurred with this transaciton.</td></tr></table></center>" );
} )
</script>