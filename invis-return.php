<?php
include 'include.php';

?>
<table class='table'>
  <tr>
    <td colspan='42'>RESPONSE:</td>
  </tr>
  <tr><td><br></td></tr>
  <tr><td colspan='42'><?php echo urldecode( http_build_query( $_POST ) ); ?></td></tr>
  <tr><td><br></td></tr>
  <?php
    ksort( $_POST );

    foreach ($_POST as $k => $v) {
        echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>$v</td></tr>";
    }
  ?>
</table>
