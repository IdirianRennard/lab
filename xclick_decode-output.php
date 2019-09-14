<?php
include 'include.php';

$string = $_POST['get_url'];
unset( $_POST['get_url']);

$string = base64_decode( $string );

$string = urldecode( $string );

parse_str( $string, $string );

ksort( $string );
?>
<table class='table'>
  <?php
    foreach ( $string as $k => $v ) {
      echo "<tr><td>[</td><script>spaces(4)</script><td>$k</td><script>spaces(4)</script><td>]</td><script>spaces(4)</script><td>=></td><script>spaces(4)</script><td>|$v|</td></tr>";
    }
  ?>
</table>
