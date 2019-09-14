<?php
include 'include.php';

?>
<table class='table'>
  <tr>
    <td>RESPONSE:</td><td></td><td><?php print_r( $_SESSION['response'] ); ?></td>
  </tr>
</table>
<?php
  unset( $_SESSION );
  session_destroy();
?>
